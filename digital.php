<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.digital
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Log\Log;
use Joomla\Event\Priority;
use Joomla\Event\SubscriberInterface;

use function YOOtheme\app;
use YOOtheme\Path;
use YOOtheme\Application;
use ZOOlanders\YOOessentials\Source\SourceLoader;
use ZOOlanders\YOOessentials\Source\SourceService;

/**
 * Legacy plugin entrypoint for Joomla to instantiate the plugin.
 *
 * This is required unless using the services/provider.php plugin structure.
 */
final class PlgSystemDigital extends CMSPlugin implements SubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            // Run AFTER the System - YOOtheme plugin bootstraps template_bootstrap.php
            'onAfterInitialise' => ['onAfterInitialise', Priority::LOW],
            // Run early enough for builder/container resolution.
            'onAfterDispatch' => ['onAfterDispatch', Priority::LOW],
            // Ensure our head injections still run
            'onBeforeCompileHead' => ['onBeforeCompileHead', Priority::LOW],
            // Defer Essentials source registration until the document phase,
            // so Essentials has time to bootstrap its SourceLoader.
            'onAfterInitialiseDocument' => ['onAfterInitialiseDocument', Priority::LOW],
        ];
    }

    public function onAfterInitialise(): void
    {
        if (!function_exists('YOOtheme\\app') || !class_exists(Application::class, false)) {
            return;
        }

        if (!PluginHelper::isEnabled('system', 'yooessentials')) {
            return;
        }

        // Expose this plugin directory to YOOtheme Path resolver.
        Path::setAlias('~digital', __DIR__);
        Path::setAlias('~digital_url', '~/plugins/system/digital');
    }

    public function onAfterInitialiseDocument(): void
    {
        $this->registerEssentialsSources();
    }

    public function onAfterDispatch(): void
    {
        $this->registerEssentialsSources();
        $this->enableCodemirrorForCustomJsField();
    }

    private function enableCodemirrorForCustomJsField(): void
    {
        $app = $this->getApplication() ?? Factory::getApplication();
        if (!$app || !$app->isClient('administrator')) {
            return;
        }

        // Only on plugin edit screen
        $option = $app->input->getCmd('option');
        $view   = $app->input->getCmd('view');
        $layout = $app->input->getCmd('layout');

        if ($option !== 'com_plugins' || $view !== 'plugin' || $layout !== 'edit') {
            return;
        }

        if ((bool) $this->params->get('debug_sources', 0)) {
            Log::addLogger(['text_file' => 'digital.log.php'], Log::ALL, ['plg_system_digital']);
            Log::add('enableCodemirrorForCustomJsField: matched com_plugins plugin edit', Log::DEBUG, 'plg_system_digital');
        }

        $document = $app->getDocument();
        if (!$document || !method_exists($document, 'getWebAssetManager')) {
            return;
        }

        $wa = $document->getWebAssetManager();

        // Load Joomla CodeMirror web assets
        $wa->getRegistry()->addExtensionRegistryFile('plg_editors_codemirror');
        if ($wa->getRegistry()->exists('style', 'plg_editors_codemirror')) {
            $wa->useStyle('plg_editors_codemirror');
        }
        // Ensure the base CodeMirror module is present (importmap + deps)
        if ($wa->getRegistry()->exists('script', 'codemirror')) {
            $wa->useScript('codemirror');
        }
        // Ensure editor-api / editors glue is present for the webcomponent
        if ($wa->getRegistry()->exists('script', 'editors')) {
            $wa->useScript('editors');
        }
        if ($wa->getRegistry()->exists('script', 'webcomponent.editor-codemirror')) {
            $wa->useScript('webcomponent.editor-codemirror');
        }

        // Upgrade the specific textarea into a CodeMirror editor (still stored as textarea value on submit)
        $document->addCustomTag(<<<'HTML'
<script>
function digitalInitCustomJsCodemirror() {
  var ta = document.getElementById('jform_params_custom_js');
  if (!ta) return;
  if (ta.closest('joomla-editor-codemirror')) return;

  var wrapper = document.createElement('joomla-editor-codemirror');
  wrapper.setAttribute('options', JSON.stringify({
    mode: 'javascript',
    lineNumbers: true,
    lineWrapping: true,
    activeLine: true,
    highlightSelection: true,
    autoCloseBrackets: true,
    foldGutter: true,
    height: '300px'
  }));

  ta.parentNode.insertBefore(wrapper, ta);
  wrapper.appendChild(ta);

  // Self-check: if the web component isn't registered, highlighting won't appear.
  setTimeout(function () {
    if (!customElements.get('joomla-editor-codemirror')) {
      console.error('Digital: CodeMirror web component not registered. Check that webcomponent.editor-codemirror is loaded.');
    }
  }, 0);
}
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', digitalInitCustomJsCodemirror);
} else {
  digitalInitCustomJsCodemirror();
}
</script>
HTML);
    }

    private function registerEssentialsSources(): void
    {
        // Never interfere with extension installation/updates (installer expects JSON responses).
        $jApp = $this->getApplication() ?? Factory::getApplication();
        if ($jApp && $jApp->isClient('administrator')) {
            $option = $jApp->input->getCmd('option');
            $task   = $jApp->input->getCmd('task');
            if ($option === 'com_installer' || str_starts_with($task, 'install') || str_starts_with($task, 'update')) {
                return;
            }
        }

        if (!function_exists('YOOtheme\\app') || !class_exists(Application::class, false)) {
            return;
        }

        if (!PluginHelper::isEnabled('system', 'yooessentials')) {
            return;
        }

        // Some builder/ajax contexts bootstrap YOOtheme partially (app exists, but not all packages/autoloaders).
        // Ensure the full template bootstrap ran so core services (e.g. ImageProvider) are available.
        if (!class_exists(\YOOtheme\ImageProvider::class)) {
            $themeBootstrap = JPATH_ROOT . '/templates/yootheme/bootstrap.php';
            if (is_file($themeBootstrap)) {
                require_once $themeBootstrap;
            }
        }

        // Compatibility: some custom builder templates expect ImageProvider service.
        // In some contexts it's not registered, so we provide a minimal implementation.
        if (method_exists(app(), 'has') && method_exists(app(), 'add') && !app()->has(\YOOtheme\ImageProvider::class)) {
            app()->add(\YOOtheme\ImageProvider::class, function () {
                return new class {
                    public function getUrl(string $path): string
                    {
                        try {
                            if (class_exists(\YOOtheme\Url::class)) {
                                $url = \YOOtheme\Url::to($path);
                                return $url === false ? $path : $url;
                            }
                        } catch (\Throwable $e) {
                            // ignore
                        }

                        return $path;
                    }
                };
            });
        }

        // Ensure aliases exist even if this is triggered without onAfterInitialise (edge cases).
        Path::setAlias('~digital', __DIR__);
        Path::setAlias('~digital_url', '~/plugins/system/digital');

        // Ensure our source classes are autoloadable in this request.
        // Also registers GraphQL + Essentials autoloaders as needed.
        $sourcesAutoloader = __DIR__ . '/sources/autoload.php';
        if (is_file($sourcesAutoloader)) {
            require_once $sourcesAutoloader;
        }

        // Ensure Essentials' Source module is bootstrapped in this request.
        // Builder/admin contexts may bootstrap YOOtheme without loading all Essentials modules.
        try {
            $yooessentialsDir = JPATH_ROOT . '/plugins/system/yooessentials';
            if (is_dir($yooessentialsDir)) {
                Path::setAlias('~yooessentials', $yooessentialsDir);
                Path::setAlias('~yooessentials_url', '~/plugins/system/yooessentials');
            }

            // Load the Essentials Source module bootstrap to register the loader/service.
            app()->load('~yooessentials/modules/source/bootstrap.php');
        } catch (\Throwable $e) {
            // If Essentials source bootstrap isn't available, don't break the builder.
            // We can't safely register sources without the SourceService.
            return;
        }

        // Register source providers directly to avoid relying on the 'yooessentials-sources' loader,
        // which may not be present in some builder contexts.
        try {
            // Register our source classes as YOOtheme container services so `app($class)` can resolve them.
            // (YOOtheme\Application::load() only accepts file globs, not inline config arrays.)
            if (method_exists(app(), 'has') && method_exists(app(), 'add')) {
                if (!app()->has(\YOOthemeDigital\Sources\Zenodo\Zenodo::class)) {
                    app()->add(\YOOthemeDigital\Sources\Zenodo\Zenodo::class);
                }
                if (!app()->has(\YOOthemeDigital\Sources\Scientilla\Scientilla::class)) {
                    app()->add(\YOOthemeDigital\Sources\Scientilla\Scientilla::class);
                }
            }

            /** @var SourceService $service */
            $service = app(SourceService::class);
            $service->addSourceType('zenodo', \YOOthemeDigital\Sources\Zenodo\Zenodo::class);
            $service->addSourceType('scientilla', \YOOthemeDigital\Sources\Scientilla\Scientilla::class);
        } catch (\Throwable $e) {
            if ((bool) $this->params->get('debug_sources', 0)) {
                Log::addLogger(['text_file' => 'digital.log.php'], Log::ALL, ['plg_system_digital']);
                Log::add('Failed registering SourceService providers: ' . $e->getMessage(), Log::ERROR, 'plg_system_digital');
            }
            return;
        }

        if ((bool) $this->params->get('debug_sources', 0)) {
            Log::addLogger(['text_file' => 'digital.log.php'], Log::ALL, ['plg_system_digital']);
            Log::add(
                'Registered SourceService providers: zenodo, scientilla',
                Log::INFO,
                'plg_system_digital'
            );
        }
    }

    public function onBeforeCompileHead(): void
    {
        $app = $this->getApplication() ?? Factory::getApplication();

        if (!$app) {
            return;
        }

        if (!$app->isClient('site')) {
            return;
        }

        $document = $app->getDocument();
        $wa       = $document->getWebAssetManager();

        // Add custom font "Hey August" from this plugin's media folder.
        $fontBase = Uri::root(true) . '/media/plg_system_digital/fonts/';
        $document->addStyleDeclaration(
            "@font-face{font-family:'Hey August';font-style:normal;font-weight:400;font-display:swap;"
            . "src:url({$fontBase}Hey%20August.ttf) format('truetype'),"
            . "url({$fontBase}Hey%20August.otf) format('opentype');}"
        );

        // Always add the stylesheet directly to avoid registry/template edge cases.
        $document->addStyleSheet(Uri::root(true) . '/media/plg_system_digital/css/all.min.css');

        // Ensure the plugin registry file is known to the WebAsset registry
        $wa->getRegistry()->addExtensionRegistryFile('plg_system_digital');

        if ($wa->getRegistry()->exists('style', 'plg_system_digital.fontawesome')) {
            $wa->useStyle('plg_system_digital.fontawesome');
        }

        // Custom JS injection (frontend only, skip builder/customizer mode)
        $customizerParam    = $app->input->get('customizer', null);
        $yooBuilderMarker   = $app->input->get('yoobuilder', null);
        $hasCustomizerInUri = strpos($_SERVER['REQUEST_URI'] ?? '', 'customizer=') !== false;
        $phpDetectedBuilder = !empty($customizerParam) || $hasCustomizerInUri || $yooBuilderMarker === '1';

        // Iframe detection: when embedded in YOOtheme Builder, mark subsequent navigations
        // so PHP can reliably detect builder context and skip injecting custom scripts.
        $iframeDetectionScript = <<<'JSCODE'
<script>
(function() {
    if (window.self !== window.top) {
        function addBuilderMarkerToLinks() {
            document.querySelectorAll('a[href]').forEach(function(link) {
                var href = link.getAttribute('href');
                if (!href || href.startsWith('#') || href.startsWith('javascript:') || href.indexOf('yoobuilder=1') !== -1) return;
                var separator = href.indexOf('?') !== -1 ? '&' : '?';
                link.setAttribute('href', href + separator + 'yoobuilder=1');
            });
        }
        if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', addBuilderMarkerToLinks); }
        else { addBuilderMarkerToLinks(); }
        new MutationObserver(addBuilderMarkerToLinks).observe(document.body, { childList: true, subtree: true });
    }
})();
</script>
JSCODE;
        $document->addCustomTag($iframeDetectionScript);

        $jsCode = (string) $this->params->get('custom_js', '');

        if ($jsCode !== '' && !$phpDetectedBuilder) {
            $trimmed = trim($jsCode);

            // Keep parity with template behavior: allow pasting full snippets with <script> tags.
            if (stripos($trimmed, '<script') === false) {
                $jsCode = '<script>' . $jsCode . '</script>';
            }

            $document->addCustomTag($jsCode);
        }
    }
}

