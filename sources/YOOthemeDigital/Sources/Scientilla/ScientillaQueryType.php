<?php

namespace YOOthemeDigital\Sources\Scientilla;

use Joomla\CMS\Log\Log;
use Joomla\CMS\Plugin\PluginHelper;
use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\Resolver\CachesResolvedSourceData;
use ZOOlanders\YOOessentials\Source\Resolver\HasDynamicArgs;
use ZOOlanders\YOOessentials\Source\Resolver\LoadsSourceFromArgs;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use YOOthemeDigital\Sources\Scientilla\Api\ScientillaApiClient;

class ScientillaQueryType extends AbstractQueryType
{
    use LoadsSourceFromArgs, HasDynamicArgs, CachesResolvedSourceData;

    public const NAME = 'profile';
    public const LABEL = 'Profile';
    public const DESCRIPTION = 'Get Scientilla user profile';

    public function __construct(SourceInterface $source, private ScientillaType $scientillaType)
    {
        parent::__construct($source);
    }

    public static function getCacheKey(): string
    {
        return 'scientilla-profile-query';
    }

    public function config(): array
    {
        return [
            'fields' => [
                $this->name() => [
                    'type' => $this->scientillaType->name(),
                    'args' => [],
                    'metadata' => [
                        'group' => 'Essentials',
                        'label' => $this->label(),
                        'description' => $this->description(),
                        'fields' => [],
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

    public static function resolve($root, array $args)
    {
        /** @var Scientilla */
        $source = self::loadSource($args, Scientilla::class);

        if (!$source) {
            return [];
        }

        $debug = false;
        $plugin = PluginHelper::getPlugin('system', 'digital');
        if (!empty($plugin->params)) {
            $p = json_decode($plugin->params);
            $debug = !empty($p->debug_sources);
        }

        try {
            return self::resolveFromCache($source, $args, $root, function () use ($source, $debug) {
                $scientillaApiClient = new ScientillaApiClient();

                // Single source of truth: always read email from the source instance config.
                $email = null;
                try {
                    $cfgEmail = $source->config('email');
                    if (is_string($cfgEmail) && trim($cfgEmail) !== '') {
                        $email = trim($cfgEmail);
                    }
                } catch (\Throwable $e) {
                    // ignore
                }

                if ($debug) {
                    Log::addLogger(['text_file' => 'digital.log.php'], Log::ALL, ['plg_system_digital']);
                    Log::add(
                        'Scientilla resolver using instance email=' . json_encode($email),
                        Log::DEBUG,
                        'plg_system_digital'
                    );
                }

                if (!$email) {
                    return [];
                }

                $profile = $scientillaApiClient->searchProfile($email, true);
                return $profile ?: [];
            });
        } catch (\Throwable $e) {
            error_log('Scientilla resolve error: ' . $e->getMessage());
            return [];
        }
    }
}

