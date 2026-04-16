<?php

namespace YOOthemeDigital\Sources\Zenodo;

use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedSourceData;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use YOOthemeDigital\Sources\Zenodo\Api\ZenodoApiClient;

class ZenodoQueryType extends AbstractQueryType
{
    use LoadsSourceFromArgs, CachesResolvedSourceData;

    public const NAME = 'records';
    public const LABEL = 'Records';
    public const DESCRIPTION = 'List of Zenodo records';

    public function __construct(SourceInterface $source, private ZenodoType $zenodoType)
    {
        parent::__construct($source);
    }

    public static function getCacheKey(): string
    {
        return 'zenodo-records-query';
    }

    public function config(): array
    {
        return [
            'fields' => [
                $this->name() => [
                    'type' => ['listOf' => $this->zenodoType->name()],
                    'args' => [
                        'offset' => ['type' => 'Int'],
                        'limit' => ['type' => 'Int'],
                        'cache' => ['type' => 'Int'],
                    ],
                    'metadata' => [
                        'group' => 'Essentials',
                        'label' => $this->label(),
                        'description' => $this->description(),
                        'fields' => [
                            '_offset_limit' => [
                                'type' => 'grid',
                                'width' => '1-2',
                                'description' => 'Set the starting point and limit the number of records.',
                                'fields' => [
                                    'offset' => [
                                        'label' => 'Start',
                                        'type' => 'yooessentials-number',
                                        'modifier' => 1,
                                        'default' => 0,
                                        'source' => true,
                                        'attrs' => [
                                            'min' => 0,
                                            'placeholder' => 0,
                                        ],
                                    ],
                                    'limit' => [
                                        'label' => 'Quantity',
                                        'type' => 'yooessentials-number',
                                        'default' => 20,
                                        'source' => true,
                                        'attrs' => [
                                            'min' => 1,
                                            'placeholder' => 20,
                                        ],
                                    ],
                                ],
                            ],
                            'cache' => $this->cacheField(),
                        ],
                    ],
                    'extensions' => [
                        'call' => [
                            'func' => __CLASS__ . '::resolve',
                            'args' => [
                                'source_id' => $this->source->id(),
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function resolve($root, array $args): array
    {
        /** @var Zenodo */
        $source = self::loadSource($args, Zenodo::class);

        if (!$source) {
            return [];
        }

        return self::resolveFromCache($source, $args, function () use ($source, $args) {
            $zenodoApiClient = new ZenodoApiClient();

            $searchParams = [
                'sort' => 'mostrecent',
                'communities' => $source->community,
                'type' => $source->resource_type,
            ];

            if (isset($args['offset'])) {
                $searchParams['page'] = (int) ($args['offset'] / ($args['limit'] ?? 20)) + 1;
            }
            if (isset($args['limit'])) {
                $searchParams['size'] = $args['limit'];
            }

            return $zenodoApiClient->searchPublications($searchParams, true);
        });
    }
}

