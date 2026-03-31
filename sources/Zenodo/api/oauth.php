<?php

function authenticate($clientId, $authorizationUrl, $redirectUri){
$authUrl = $authorizationUrl . '?' . http_build_query([
    'client_id' => $clientId,
    'redirect_uri' => $redirectUri,
    'response_type' => 'code',
    'grant_type'=> 'authorization_code',
    'scope' => 'deposit:write deposit:actions',
]);
// Redirect l'utente all'URL di autorizzazione
header('Location: ' . $authUrl);
}

?>

