<?php

namespace YOOthemeDigital\Sources\Zenodo;

use YOOtheme\Str;
use ZOOlanders\YOOessentials\Source\GraphQL\GenericType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSource;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\HasDynamicFields;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use YOOthemeDigital\Sources\Zenodo\Api\ZenodoApiClient;

class ZenodoType extends GenericType implements HasSourceInterface
{
    use HasDynamicFields, HasSource;

    public const LABEL = 'Record';

    public function __construct(SourceInterface $source)
    {
        $this->source = $source;
    }

    public function name(): string
    {
        return Str::camelCase([$this->source->queryName(), 'Record'], true);
    }

    public function config(): array
    {
        $config = $this->source->config();

        $searchParams = [
            'sort' => 'mostrecent',
            'communities' => $config['community'] ?? '',
            'type' => $config['resource_type'] ?? '',
        ];

        $zenodoApiClient = new ZenodoApiClient();
        $values = $zenodoApiClient->getFields($searchParams);

        $fields = [];
        foreach ($values as $value) {
            $fields[self::encodeField($value)] = [
                'type' => 'String',
                'metadata' => [
                    'label' => self::labelField($value),
                    'fields' => [],
                ],
            ];
        }

        return [
            'fields' => $fields,
            'metadata' => [
                'type' => true,
                'label' => $this->label(),
            ],
        ];
    }
}

