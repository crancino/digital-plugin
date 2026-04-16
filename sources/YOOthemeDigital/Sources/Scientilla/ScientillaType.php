<?php

namespace YOOthemeDigital\Sources\Scientilla;

use YOOtheme\Str;
use ZOOlanders\YOOessentials\Source\GraphQL\GenericType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSource;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;

class ScientillaType extends GenericType implements HasSourceInterface
{
    use HasSource;

    public const LABEL = 'Profile';

    public function __construct(SourceInterface $source)
    {
        $this->source = $source;
    }

    public function name(): string
    {
        return Str::camelCase([$this->source->queryName(), 'Profile'], true);
    }

    public function config(): array
    {
        $fields = [
            'username' => ['type' => 'String', 'metadata' => ['label' => 'Username']],
            'name' => ['type' => 'String', 'metadata' => ['label' => 'First Name']],
            'surname' => ['type' => 'String', 'metadata' => ['label' => 'Last Name']],
            'completeName' => ['type' => 'String', 'metadata' => ['label' => 'Full Name']],
            'jobTitle' => ['type' => 'String', 'metadata' => ['label' => 'Job Title']],
            'researchLine' => ['type' => 'String', 'metadata' => ['label' => 'Research Line']],
            'centre' => ['type' => 'String', 'metadata' => ['label' => 'Centre']],
            'directorate' => ['type' => 'String', 'metadata' => ['label' => 'Directorate']],
            'office' => ['type' => 'String', 'metadata' => ['label' => 'Office']],
            'description' => ['type' => 'String', 'metadata' => ['label' => 'Description']],
            'interests' => ['type' => 'String', 'metadata' => ['label' => 'Interests']],
            'image' => ['type' => 'String', 'metadata' => ['label' => 'Profile Image URL']],
        ];

        return [
            'fields' => $fields,
            'metadata' => [
                'type' => true,
                'label' => $this->label(),
            ],
        ];
    }

    public function fields(): array
    {
        $config = $this->config();
        return $config['fields'] ?? [];
    }
}

