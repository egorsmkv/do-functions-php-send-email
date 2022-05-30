<?php

$data = [
    'name' => 'Yehor',
];

$encoded = base64_encode(json_encode($data));
echo $encoded;

echo "\n";
echo "\n";

$decoded = (array)json_decode(base64_decode($encoded));
print_r($decoded);
