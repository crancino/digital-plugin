<?php

use YOOtheme\Metadata;
use YOOtheme\Path;

class AssetsListener
{
    public static function initHead(Metadata $metadata)
    {
        
		// Style file
        $metadata->set('style:script:fa-generalcss', ['href' => Path::get('../assets/css/fontawesome.css')]);
		$metadata->set('style:fa-solid-css', ['href' => Path::get('../assets/css/solid.css')]);
		$metadata->set('style:fa-brands-css', ['href' => Path::get('../assets/css/brands.css')]);
        // Inline style
       /* $metadata->set('style:my-inline-css', 'body {color: blue}');
*/
        // Script file
        /*$metadata->set('script:fa-general-js', ['src' => Path::get('../assets/js/fontawesome.js'), 'defer' => true]);
		$metadata->set('script:fa-solid-js', ['src' => Path::get('../assets/js/solid.js'), 'defer' => true]);
		$metadata->set('script:fa-brands-js', ['src' => Path::get('../assets/js/brands.js'), 'defer' => true]);*/
        // Inline script
        //$metadata->set('script:my-inline-js', 'var custom = 123;');*/
    }
}
