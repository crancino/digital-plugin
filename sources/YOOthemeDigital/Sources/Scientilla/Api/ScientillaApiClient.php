<?php

namespace YOOthemeDigital\Sources\Scientilla\Api;

use Joomla\CMS\Plugin\PluginHelper;

defined('_JEXEC') or die('Restricted Access');

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

require_once __DIR__ . '/../../../../helpers/DbHelper.php';

class ScientillaApiClient
{
    
    private $accessToken;
    private $baseUrl;
    private $apiUrl;
    private $profileKeys;

    public function __construct()
    {
        //die("wassup");
        // Prefer plugin params. Fallback to template params (legacy).
        $params = null;

        $plugin = PluginHelper::getPlugin('system', 'digital');
        if (!empty($plugin->params)) {
            $params = json_decode($plugin->params);
        }

        if (!$params) {
            $dbHelper = new \DbHelper();
            $params   = $dbHelper->getThemeConfig();
        }

        $this->accessToken = $params->scientilla_token ?? '';
        $this->baseUrl     = isset($params->scientilla_url) ? rtrim($params->scientilla_url, '/') : '';

        $this->apiUrl = $this->baseUrl ?: 'https://scientilla.iit.it';
        $this->apiUrl .= '/api/v1/';
        $this->profileKeys = [];
    }

    public function searchProfile($email, $formatData = true)
    {
        
        if (empty($this->accessToken) || empty($email)) {
            return $formatData ? [] : null;
        }

        $url = $this->apiUrl . 'users/username/' . rawurlencode($email) . '/profile';

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $this->accessToken]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            error_log('Scientilla profile cURL Error: ' . curl_error($ch));
            curl_close($ch);
            return $formatData ? [] : null;
        }
        curl_close($ch);

        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('Scientilla profile JSON decode error: ' . json_last_error_msg());
            return $formatData ? [] : null;
        }

        if (isset($decoded['error'])) {
            return $formatData ? [] : null;
        }

        return $formatData ? $this->formatProfileData($decoded) : $decoded;
    }

    public function searchPeople($queryParams = [], $formatData = true)
    {
        //die("searchPeople");
        if (empty($this->accessToken)) {
            return $formatData ? [] : null;
        }

        $url = $this->apiUrl . 'userData?limit=' . ($queryParams['limit'] ?? 10);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $this->accessToken]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            error_log('Scientilla people cURL Error: ' . curl_error($ch));
            curl_close($ch);
            return $formatData ? [] : null;
        }
        curl_close($ch);

        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log('Scientilla people JSON decode error: ' . json_last_error_msg());
            return $formatData ? [] : null;
        }

        return $formatData ? $this->formatPeopleData($decoded) : $decoded;
    }

    public function formatPeopleData($data)
    {
        if (!isset($data['items']) || !is_array($data['items'])) {
            return [];
        }

        return array_map(function ($item) {
            return $this->formatProfileData(['items' => [$item]]);
        }, $data['items']);
    }

    public function formatProfileData($rawProfile)
    {
        if (isset($rawProfile['items']) && is_array($rawProfile['items'])) {
            $profile = $rawProfile['items'][0] ?? [];
        } else {
            $profile = $rawProfile;
        }

        if (empty($profile)) {
            return [];
        }

        $researchLine = '';
        $directorate  = '';
        $office       = '';
        $centre       = '';

        if (!empty($profile['groups']) && is_array($profile['groups'])) {
            foreach ($profile['groups'] as $group) {
                if (($group['type'] ?? '') === 'Research Line') {
                    $researchLine = $group['name'] ?? $researchLine;
                }
                if (($group['type'] ?? '') === 'Directorate') {
                    $directorate = $group['name'] ?? $directorate;
                }
                if (!empty($group['offices']) && is_array($group['offices'])) {
                    $office = implode(', ', $group['offices']);
                }
                if (!empty($group['center']['name'])) {
                    $centre = $group['center']['name'];
                }
            }
        }

        $interests = '';
        if (!empty($profile['interests']) && is_array($profile['interests'])) {
            $interests = implode(', ', $profile['interests']);
        }

        return [
            'username'      => $profile['username'] ?? '',
            'name'          => $profile['name'] ?? '',
            'surname'       => $profile['surname'] ?? '',
            'completeName'  => trim(($profile['name'] ?? '') . ' ' . ($profile['surname'] ?? '')),
            'jobTitle'      => $profile['jobTitle'] ?? '',
            'researchLine'  => $researchLine,
            'centre'        => $centre,
            'directorate'   => $directorate,
            'office'        => $office,
            'description'   => $profile['description'] ?? '',
            'interests'     => $interests,
            'image'         => $this->resolveProfileImage($profile),
        ];
    }

    private function resolveProfileImage(array $profile): string
    {
        $image = '';

        if (!empty($profile['image'])) {
            $image = $profile['image'];
        } elseif (!empty($profile['profileImage'])) {
            $image = $profile['profileImage'];
        } elseif (!empty($profile['avatar'])) {
            $image = $profile['avatar'];
        }

        if (empty($image)) {
            return '';
        }

        return $this->baseUrl . '/' . ltrim($image, '/');
    }
}

