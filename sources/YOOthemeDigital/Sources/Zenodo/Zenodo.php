<?php

namespace YOOthemeDigital\Sources\Zenodo;

use ZOOlanders\YOOessentials\Source\Type\AbstractSourceType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Source\Resolver\HasCacheTimes;

class Zenodo extends AbstractSourceType implements SourceInterface, HasCacheTimes
{
    public string $community;
    public string $resource_type;

    public function bind(array $config): SourceInterface
    {
        parent::bind($config);

        $this->community = $config['community'] ?? '';
        $this->resource_type = $config['resource_type'] ?? '';

        return $this;
    }

    public function types(): array
    {
        if (empty($this->community)) {
            return [];
        }

        $objectType = new ZenodoType($this);

        return [
            $objectType,
            new ZenodoQueryType($this, $objectType),
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

