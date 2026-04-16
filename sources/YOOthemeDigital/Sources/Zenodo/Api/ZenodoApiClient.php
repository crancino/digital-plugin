<?php

namespace YOOthemeDigital\Sources\Zenodo\Api;

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Log\Log;

defined('_JEXEC') or die('Restricted Access');

class ZenodoApiClient
{
    private $accessToken;
    private $apiUrl;
    private static $cache = [];

    public function __construct()
    {
        // Prefer plugin params (template-independent). Fallback to old template params.
        $this->accessToken = '';
        $zenodoBaseUrl = '';

        $plugin = PluginHelper::getPlugin('system', 'digital');
        if (!empty($plugin->params)) {
            $params = json_decode($plugin->params);
            $this->accessToken = $params->zenodo_token ?? $this->accessToken;
            $zenodoBaseUrl = $params->zenodo_url ?? $zenodoBaseUrl;
        }

        if (empty($this->accessToken)) {
            $db = Factory::getContainer()->get(\Joomla\Database\DatabaseInterface::class);
            $templateName = 'yootheme_digital';

            $query = $db->getQuery(true)
                ->select($db->quoteName(['params']))
                ->from($db->quoteName('#__template_styles'))
                ->where($db->quoteName('template') . ' = ' . $db->quote($templateName));

            $db->setQuery($query);
            $templateParams = $db->loadResult();
            $params = json_decode($templateParams);
            $this->accessToken = $params->zenodo_token ?? '';
        }

        $zenodoBaseUrl = is_string($zenodoBaseUrl) ? trim($zenodoBaseUrl) : '';
        $zenodoBaseUrl = $zenodoBaseUrl !== '' ? rtrim($zenodoBaseUrl, '/') : 'https://zenodo.org';
        $this->apiUrl = $zenodoBaseUrl . '/api/records';
    }

    public function searchPublications($queryParams, $formatData)
    {
        $url = $this->apiUrl . '?' . http_build_query($queryParams);
        $cacheKey = md5(json_encode($queryParams) . ($formatData ? 'formatted' : 'raw'));

        if (isset(self::$cache[$cacheKey])) {
            return self::$cache[$cacheKey];
        }

        $debug = false;
        $plugin = PluginHelper::getPlugin('system', 'digital');
        if (!empty($plugin->params)) {
            $p = json_decode($plugin->params);
            $debug = !empty($p->debug_sources);
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->accessToken,
            'Accept: application/json',
            'User-Agent: Joomla Digital Plugin'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $rawResponse = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $contentType = (string) curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        if ($curlError) {
            if ($debug) {
                Log::addLogger(['text_file' => 'digital.log.php'], Log::ALL, ['plg_system_digital']);
                Log::add('Zenodo API cURL Error: ' . $curlError, Log::ERROR, 'plg_system_digital');
            }
            curl_close($ch);
            throw new \RuntimeException('Zenodo API request failed (cURL): ' . $curlError);
        }

        if (empty($rawResponse)) {
            curl_close($ch);
            throw new \RuntimeException("Zenodo API returned an empty response (HTTP {$httpCode}).");
        }

        $response = json_decode($rawResponse, true);
        $jsonError = json_last_error();
        curl_close($ch);

        // Zenodo should return JSON. If we got HTML (or invalid JSON), surface it clearly in the builder.
        if ($jsonError !== JSON_ERROR_NONE || !is_array($response)) {
            $snippet = trim(strip_tags($rawResponse));
            $snippet = preg_replace('/\s+/', ' ', $snippet ?? '');
            $snippet = mb_substr($snippet, 0, 600);

            if ($debug) {
                Log::addLogger(['text_file' => 'digital.log.php'], Log::ALL, ['plg_system_digital']);
                Log::add(
                    "Zenodo API non-JSON response (HTTP {$httpCode}, Content-Type: {$contentType}). Snippet: {$snippet}",
                    Log::ERROR,
                    'plg_system_digital'
                );
            }

            throw new \RuntimeException(
                "Zenodo API returned an unexpected response (HTTP {$httpCode}, Content-Type: {$contentType}). " .
                "Snippet: {$snippet}"
            );
        }

        if ($httpCode >= 400) {
            $message = $response['message'] ?? $response['error'] ?? null;
            $message = is_string($message) ? $message : null;

            if ($debug) {
                Log::addLogger(['text_file' => 'digital.log.php'], Log::ALL, ['plg_system_digital']);
                Log::add(
                    'Zenodo API error (HTTP ' . $httpCode . '): ' . ($message ?: 'Unknown error'),
                    Log::ERROR,
                    'plg_system_digital'
                );
            }

            throw new \RuntimeException('Zenodo API error (HTTP ' . $httpCode . '): ' . ($message ?: 'Unknown error'));
        }

        if ($formatData) {
            $result = $this->formatData($response);
            self::$cache[$cacheKey] = $result;
            return $result;
        }

        self::$cache[$cacheKey] = $response;
        return $response;
    }

    public function getFields($queryParams)
    {
        $pubs = $this->searchPublications($queryParams, true);

        if (is_array($pubs) && !empty($pubs) && isset($pubs[0]) && is_array($pubs[0])) {
            return array_keys($pubs[0]);
        }

        return [
            'title', 'doi', 'doi_url', 'publication_date', 'description',
            'resource_type', 'creators', 'journal', 'keywords', 'record_url'
        ];
    }

    public function formatData($data)
    {
        $records = [];
        if (!isset($data['hits']['hits'])) {
            return $records;
        }

        foreach ($data['hits']['hits'] as $publication) {
            $record = [];
            $record['title'] = $publication['metadata']['title'] ?? '';
            $record['doi'] = $publication['metadata']['doi'] ?? '';
            $record['doi_url'] = $publication['doi_url'] ?? '';
            $record['publication_date'] = $publication['metadata']['publication_date'] ?? '';
            $record['description'] = $publication['metadata']['description'] ?? '';
            $record['resource_type'] = $publication['metadata']['resource_type']['title'] ?? '';
            $record['creators'] = $this->formatCreators($publication['metadata']['creators'] ?? []);
            $record['journal'] = $this->formatJournal($publication['metadata'] ?? []);
            $record['keywords'] = isset($publication['metadata']['keywords']) ? $this->formatKeywords($publication['metadata']['keywords']) : '';
            $record['record_url'] = $publication['links']['self_html'] ?? '';

            $records[] = $record;
        }

        return $records;
    }

    private function formatJournal($metadata)
    {
        if (!isset($metadata['journal']['title'])) {
            return '';
        }

        $journal = $metadata['journal']['title'];

        if (isset($metadata['journal']['volume'])) {
            $journal .= ", " . $metadata['journal']['volume'];
        }
        if (isset($metadata['journal']['issue'])) {
            $journal .= "(" . $metadata['journal']['issue'] . ")";
        }
        if (isset($metadata['journal']['pages'])) {
            $journal .= ", " . $metadata['journal']['pages'];
        }
        if (isset($metadata['publication_date'])) {
            $journal .= ", " . date("Y", strtotime($metadata['publication_date']));
        }

        return $journal;
    }

    private function formatKeywords($data)
    {
        return rtrim(implode(', ', $data), ', ');
    }

    private function formatCreators($data)
    {
        $str = '';
        foreach ($data as $creator) {
            $new_arr = array_map('trim', explode(',', $creator['name'] ?? ''));
            $str .= implode(" ", array_reverse($new_arr)) . ", ";
        }

        return rtrim($str, ', ');
    }
}

