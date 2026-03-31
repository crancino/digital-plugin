<?php

use ZOOlanders\YOOessentials\Source\GraphQL\AbstractQueryType;
use ZOOlanders\YOOessentials\Source\GraphQL\HasSourceInterface;
use ZOOlanders\YOOessentials\Source\SourceService;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;

//require_once  'api/Record.php';
require_once  'api/ZenodoApiClient.php';
require_once  'ZenodoSource.php';

class ZenodoQueryType extends AbstractQueryType implements HasSourceInterface
{
    private $ZenodoType;
    private $community;
    private $resource_type;
    public function __construct(SourceInterface $source, ZenodoType $mySourceType)
    {
        parent::__construct($source);

        
        // declare the source type/s for use in the config
        $this->ZenodoType = $mySourceType;
       
        $config = $this->source->config();
        $this->community = $config['community'];
        $this->resource_type = $config['resource_type'];
    }

    // a unique name for the query type,
    // we recommend using the source id
    public function name(): string
    {
        return "Zenodo_{$this->source()->id()}_query";
    }

    public function config(): array
    {
        //die(var_dump($this->ZenodoType->config()['metadata']));
        
       $args = [
           'source_id' => $this->source->id(),
           'community' => $this->community,
           'resource_type' => $this->resource_type
        ];
        return [

            'fields' => [

                $this->name() => [
                    'type' => ['listOf' => $this->ZenodoType->name()],

                    'args' => [

                        'offset' => [
                            'type' => 'Int',
                        ],
                        'limit' => [
                            'type' => 'Int',
                        ]

                    ],

                    'metadata' => [
                        'group' => 'Zenodo',
                        'label' => $this->label(),
                        'fields' => [],
                    ],

                    'extensions' => [
                        'call' => [
                            'func' => __CLASS__ . '::resolve',
                            'args' => $args,
                        ],
                    ],

                ],

            ],

        ];
    }
    
    
    
    /*
    public static function resolve($root, array $args): array
    {
        
    $source = self::loadSource($args, ZenodoSource::class);
        //die(var_dump($source));
        if (!$source) {
            return [];
        }
        return (new ZenodoResolver($source, $args, $root))->resolve();
    }
    */
   public static function resolve($root, array $args): array
    {
        
       //die(var_dump($args));
       $zenodoApiClient = new ZenodoApiClient();

        // Definisci i parametri di ricerca
        $searchParams = [
             //'q' => 'creators.name:"' . $ricercatore . '"', // Filtra per il nome del ricercatore
            //'q' => '', // Filtra per il nome del ricercatore
             'sort' => 'mostrecent',      // Ordina per data di caricamento, la più recente prima
             //'page' => 1,                 // Numero di pagina per la paginazione
             //'size' => 10,                // Numero di risultati per pagina
            //'communities' => $this->community, // Filtra per una specifica community
            'communities' => $args['community'], // Filtra per una specifica community
            'type' => $args['resource_type']     // Filtra per tipo di pubblicazione (es. publication, dataset, software, etc.)
             // Aggiungi altri parametri di filtro secondo necessità
        ];

         // Esegui la ricerca
        $pubs = $zenodoApiClient->searchPublications($searchParams, true);
      //die(var_dump($pubs));
        return $pubs;
       
    }  
    
  
    
    
    
    
}