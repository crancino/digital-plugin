<?php

namespace YOOthemeDigital\Sources\Scientilla;

use ZOOlanders\YOOessentials\Source\Type\AbstractSourceType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\HasCacheTimes;

class Scientilla extends AbstractSourceType implements SourceInterface, HasCacheTimes
{
    public function types(): array
    {
        $objectType = new ScientillaType($this);

        return [
            $objectType,
            new ScientillaQueryType($this, $objectType),
        ];
    }

    public function defaultCacheTime(): int
    {
        return $this->config('cache_default', HasCacheTimes::DEFAULT_CACHE_TIME);
    }

    public function minCacheTime(): int
    {
        return 0;
    }
}

