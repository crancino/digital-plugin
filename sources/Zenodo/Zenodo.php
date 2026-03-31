<?php

if (!class_exists('ZOOlanders\YOOessentials\Source\Type\AbstractSourceType')) {
    return;
}

use ZOOlanders\YOOessentials\Source\Type\AbstractSourceType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Source\SourceService;

require_once  'ZenodoQueryType.php';
require_once  'ZenodoType.php';

class Zenodo extends AbstractSourceType implements SourceInterface
{
    // declare here the source types and queries
    public function types(): array
    {
        
        //die(var_dump(new ZenodoType($this)));
        return [
            $objectType = new ZenodoType($this),
            new ZenodoQueryType($this, $objectType)
        ];
    }
}