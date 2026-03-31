<?php
require_once __DIR__ . '/sources/Zenodo/Zenodo.php';
$app->load(__DIR__ . '/modules/fontawesome/bootstrap.php');

return [
    'yooessentials-sources' => [
        'zenodo' => Zenodo::class
    ]
];