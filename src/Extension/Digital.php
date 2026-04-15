<?php
namespace IIT\Plugin\System\Digital\Extension;

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Uri\Uri;
use Joomla\Event\SubscriberInterface;

class Digital extends CMSPlugin implements SubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'onBeforeCompileHead' => 'onBeforeCompileHead',
        ];
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

        // Always add the stylesheet directly to avoid registry/template edge cases.
        $document->addStyleSheet(Uri::root(true) . '/media/plg_system_digital/css/all.min.css');

        // 1. Inject FontAwesome from local media folder
        // The registry is automatically picked up from joomla.asset.json
        $wa->getRegistry()->addExtensionRegistryFile('plg_system_digital');

        if ($wa->getRegistry()->exists('style', 'plg_system_digital.fontawesome')) {
            $wa->useStyle('plg_system_digital.fontawesome');
        }

        // 2. Inject Custom JS from settings (frontend only, skip builder/customizer mode)
        $customizerParam    = $app->input->get('customizer', null);
        $yooBuilderMarker   = $app->input->get('yoobuilder', null);
        $hasCustomizerInUri = strpos($_SERVER['REQUEST_URI'] ?? '', 'customizer=') !== false;
        $phpDetectedBuilder = !empty($customizerParam) || $hasCustomizerInUri || $yooBuilderMarker === '1';

        $jsCode = (string) $this->params->get('custom_js', '');

        if ($jsCode !== '' && !$phpDetectedBuilder) {
            $trimmed = trim($jsCode);

            if (stripos($trimmed, '<script') === false) {
                $jsCode = '<script>' . $jsCode . '</script>';
            }

            $document->addCustomTag($jsCode);
        }
    }
}