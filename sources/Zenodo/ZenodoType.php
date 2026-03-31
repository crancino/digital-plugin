<?php

use ZOOlanders\YOOessentials\Source\GraphQL\AbstractObjectType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\HasDynamicFields;

require_once  'api/ZenodoApiClient.php';

class ZenodoType extends AbstractObjectType implements HasSourceInterface
{
    use HasDynamicFields;
    // a unique name is required for the type registration,
    // using the source config is in general a good way to do so
    public function name(): string
    {
        return 'Zenodo_' . sha1(json_encode($this->source->config()));
    }

    // return a standard config for the Type based
    // on the current source configuration
    public function config(): array
    {
        $config = $this->source->config();
       
        $searchParams = [
             //'q' => 'creators.name:"' . $ricercatore . '"', // Filtra per il nome del ricercatore
            //'q' => '', 
             'sort' => 'mostrecent',      // Ordina per data di caricamento, la più recente prima
             //'page' => 1,                 // Numero di pagina per la paginazione
             //'size' => 10,                // Numero di risultati per pagina
            //'communities' => 'naned',// Filtra per una specifica community
            'communities' => $config['community'], // Filtra per una specifica community
            'type' => $config['resource_type'],     // Filtra per tipo di pubblicazione (es. publication, dataset, software, etc.)
        ];
        
        $zenodoApiClient = new ZenodoApiClient();
        $values = $zenodoApiClient->getFields($searchParams);
        
        //die(var_dump($values));
        
        foreach ($values as $value) {
            $fields[self::encodeField($value)]  = [
                'type' => 'String',
                'metadata' => [
                    'label' => self::labelField($value),
                    'fields' => [],
                ]
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