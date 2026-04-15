<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  System.digital
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;

/**
 * Legacy plugin entrypoint for Joomla to instantiate the plugin.
 *
 * This is required unless using the services/provider.php plugin structure.
 */
final class PlgSystemDigital extends CMSPlugin
{
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

