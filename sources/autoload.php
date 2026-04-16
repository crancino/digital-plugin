<?php
/**
 * Bulletproof autoloader for Digital plugin sources.
 *
 * - Loads YOOtheme autoloader (GraphQL classes)
 * - Loads Essentials autoloader only if the plugin is enabled
 * - Registers PSR-4 for YOOthemeDigital\
 */

defined('_JEXEC') or die('Restricted Access');

// --- STEP 1: YOOtheme vendor autoload (GraphQL types live there) ---
$yooAutoloader = JPATH_ROOT . '/templates/yootheme/vendor/autoload.php';
if (file_exists($yooAutoloader)) {
    require_once $yooAutoloader;
}

// --- STEP 2: GraphQL compatibility aliases ---
if (class_exists('YOOtheme\\GraphQL\\Type\\Definition\\ObjectType') && !class_exists('\\GraphQL\\Type\\Definition\\ObjectType')) {
    class_alias('YOOtheme\\GraphQL\\Type\\Definition\\ObjectType', 'GraphQL\\Type\\Definition\\ObjectType');
    class_alias('YOOtheme\\GraphQL\\Type\\Definition\\IntType', 'GraphQL\\Type\\Definition\\IntType');
    class_alias('YOOtheme\\GraphQL\\Type\\Definition\\StringType', 'GraphQL\\Type\\Definition\\StringType');
    class_alias('YOOtheme\\GraphQL\\Type\\Definition\\Type', 'GraphQL\\Type\\Definition\\Type');
    class_alias('YOOtheme\\GraphQL\\Type\\Definition\\InputObjectType', 'GraphQL\\Type\\Definition\\InputObjectType');
}

// --- STEP 3: Load Essentials autoloader if enabled ---
$essentialsActive = false;

if (class_exists('\\Joomla\\CMS\\Plugin\\PluginHelper')) {
    $essentialsActive = \Joomla\CMS\Plugin\PluginHelper::isEnabled('system', 'yooessentials');
}

if ($essentialsActive) {
    $zoolandersAutoloader = JPATH_ROOT . '/plugins/system/yooessentials/modules/autoload.php';
    if (file_exists($zoolandersAutoloader)) {
        require_once $zoolandersAutoloader;
    }
}

// --- STEP 4: PSR-4 autoload for our sources ---
spl_autoload_register(function ($class) {
    $prefix   = 'YOOthemeDigital\\';
    $base_dir = __DIR__ . '/YOOthemeDigital/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file           = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require_once $file;
        return true;
    }

    return false;
}, true, true);

