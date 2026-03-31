<?php
defined('_JEXEC') or die('Restricted Access');
define('DS', DIRECTORY_SEPARATOR);
require_once __DIR__.'..'.DS.'..'.DS.'..'.DS.'..'.DS.'helpers'.DS.'DbHelper.php';

class ZenodoApiClient
{
    private $accessToken;
    private $apiUrl;

    public function __construct()
    {
        $dbHlpr = new DbHelper();
        $params = $dbHlpr->getThemeConfig();
        
        $this->accessToken = $params->zenodo_token;
        $this->apiUrl = 'https://zenodo.org/api/records';
    }

   
    
    public function searchPublications($queryParams, $formatData)
    {
        $url = $this->apiUrl . '?' . http_build_query($queryParams);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $this->accessToken]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Ignora la verifica del certificato

        $response = json_decode(curl_exec($ch), true);

        if (curl_errno($ch)) {
            echo 'Errore cURL: ' . curl_error($ch);
        }

        curl_close($ch);

        if ($formatData == true){
            return $this->formatData($response);
        }
        
        return $response;
    }

     public function getRecord($id)
    {
        $url = $this->apiUrl . '/' . $id;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $this->accessToken]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Ignora la verifica del certificato

        $response = json_decode(curl_exec($ch), true);

        if (curl_errno($ch)) {
            echo 'Errore cURL: ' . curl_error($ch);
        }

        curl_close($ch);

        return $response;
    }
    
    public function getFields($queryParams)
    {
     
        $pubs = $this->searchPublications($queryParams, true);
        //die(var_dump(($pubs)));
        return array_keys($pubs[0]);
    }
    
    
    
    public function formatData ($data)
    {
        $records = [];
        foreach ($data['hits']['hits'] as $publication) {
            //$details = $this->getRecord($publication['id']);
            
            $record['title'] = $publication['title'];
            $record['doi'] = $publication['doi'];
            $record['doi_url'] = $publication['doi_url'];
            $record['publication_date'] = $publication['metadata']['publication_date'];
            $record['description'] = $publication['metadata']['description'];
            $record['resource_type'] = $publication['metadata']['resource_type']['title'];
            $record['creators'] = $this->formatCreators($publication['metadata']['creators']);
            $record['journal'] = $this->formatJournal($publication['metadata']);
            
            $record['keywords'] = "";
            if(isset($publication['metadata']['keywords'])){
                $record['keywords'] = $this->formatKeywords($publication['metadata']['keywords']);
                }
                
            $record['record_url'] = $publication['links']['self_html'];
            
            array_push($records, $record);
            
            //print(var_dump($record));
        }
        
        return $records;
    }
    
    public function formatJournal($metadata){
       
        $journal = "";
        if(!isset($metadata['journal']['title'])){
            return $journal;
        }
        
        $journal = $metadata['journal']['title'];
        
        if(isset($metadata['journal']['volume'])){
            $journal .= ", ".$metadata['journal']['volume'];
        }
        
        if(isset($metadata['journal']['issue'])){
            $journal .= "(".$metadata['journal']['issue'].")";
        }
        
        if(isset($metadata['journal']['pages'])){
            $journal .= ", ".$metadata['journal']['pages'];
        }
        /*
        if(isset($metadata['journal']['issn'])){
            $journal .= ", ISSN: ".$metadata['journal']['issn'];
        }
        */
        if(isset($metadata['publication_date'])){
            $journal .= ", ".date("Y", strtotime($metadata['publication_date']));
        }
        
        return $journal;
    }
    
    
    public function formatKeywords($data)
    {
        $str = '';
        foreach ($data as $field) {
            
            
            $str .= $field .", ";
        }
        
        return rtrim($str, ', ');
        
    }
    
    public function formatCreators ($data)
    {
        $str = '';
        foreach ($data as $creator) {
            $new_arr = array_map('trim', explode(',', $creator['name']));
            
            $str .= implode(" ", array_reverse($new_arr)) .", ";
        }
        
        return rtrim($str, ', ');
        
    }
    
    
}

?>