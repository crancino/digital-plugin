<?php
/**
 * @package   Essentials YOOtheme Pro 2.0.19 build 1026.0920
 * @author    ZOOlanders https://www.zoolanders.com
 * @copyright Copyright (C) Joolanders, SL
 * @license   http://www.gnu.org/licenses/gpl.html GNU/GPL
 */

//namespace ZOOlanders\YOOessentials\Source\Provider\Csv;

use YOOtheme\Event;
use YOOtheme\File;
use YOOtheme\Path;
use YOOtheme\Str;
use ZOOlanders\YOOessentials\Source\Resolver\HasCacheTimes;
use ZOOlanders\YOOessentials\Source\Type\AbstractSourceType;
use ZOOlanders\YOOessentials\Source\Type\DynamicSourceInputType;
use ZOOlanders\YOOessentials\Source\Type\SourceInterface;
use ZOOlanders\YOOessentials\Source\Provider\Csv\Type\CsvFilterType;
use ZOOlanders\YOOessentials\Source\Provider\Csv\Type\CsvOrderingType;
use ZOOlanders\YOOessentials\Util\Prop;
use ZOOlanders\YOOessentials\Vendor\League\Csv\Reader;

require_once  'api/ZenodoApiClient.php';

class ZenodoSource extends AbstractSourceType implements SourceInterface, HasCacheTimes
{
    /** @var Reader */
    private $zenodo;

    public function types(): array
    {
        //die("here");
        try {
            $this->zenodo();
        } catch (\Exception $e) {
            Event::emit('yooessentials.error', [
                'addon' => 'source',
                'provider' => 'zenodo',
                'error' => $e->getMessage(),
            ]);

            return [];
        }
/*
        $filterType = new CsvFilterType();
        $orderingType = new CsvOrderingType();
        $objectType = new Type\CsvFileType($this);
        $queryType = new Type\CsvQueryType($this, $objectType);

        return [
            $filterType,
            $orderingType,
            new DynamicSourceInputType($filterType),
            new DynamicSourceInputType($orderingType),
            $objectType,
            $queryType,
        ];*/
        return [];
    }

    public function zenodo()
    {
        
        die("macheooohh");
        $zenodoApiClient = new ZenodoApiClient();

        // Definisci i parametri di ricerca
        $searchParams = [
             //'q' => 'creators.name:"' . $ricercatore . '"', // Filtra per il nome del ricercatore
            'q' => '', // Filtra per il nome del ricercatore
             'sort' => 'mostrecent',      // Ordina per data di caricamento, la più recente prima
             //'page' => 1,                 // Numero di pagina per la paginazione
             //'size' => 10,                // Numero di risultati per pagina
            //'communities' => $this->community, // Filtra per una specifica community
            'communities' => 'naned', // Filtra per una specifica community
             'type' => 'publication',     // Filtra per tipo di pubblicazione (es. publication, dataset, software, etc.)
             // Aggiungi altri parametri di filtro secondo necessità
        ];

         // Esegui la ricerca
        $pubs = $zenodoApiClient->searchPublications($searchParams);
      
        
        $records = [];
        
        foreach ($pubs['hits']['hits'] as $publication) {
            $record =(array)$publication;
            array_push($records, $record);
        }
        
        return $records;
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
