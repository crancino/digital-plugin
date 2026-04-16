<?php

/**
 * YOOtheme Digital plugin sources config.
 *
 * Loaded via YOOtheme's app()->load() from the plugin.
 */

defined('_JEXEC') or die;

require_once __DIR__ . '/autoload.php';

$sources = [];

// Avoid triggering autoload loops if Essentials is broken/missing.
$essentialsBaseExists = class_exists('ZOOlanders\\YOOessentials\\Source\\Type\\AbstractSourceType')
    || class_exists('ZOOlanders\\YOOessentials\\Source\\GraphQL\\GenericType');

if ($essentialsBaseExists && class_exists('YOOthemeDigital\\Sources\\Zenodo\\Zenodo')) {
    $sources['zenodo'] = \YOOthemeDigital\Sources\Zenodo\Zenodo::class;
}

if ($essentialsBaseExists && class_exists('YOOthemeDigital\\Sources\\Scientilla\\Scientilla')) {
    $sources['scientilla'] = \YOOthemeDigital\Sources\Scientilla\Scientilla::class;
}

return [
    'yooessentials-sources' => $sources,
];

