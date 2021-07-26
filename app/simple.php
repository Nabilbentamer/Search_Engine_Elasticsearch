<?php 

require_once 'vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()->build();

//$client = new Elasticsearch\Client(['hosts' => ['127.0.0.1:9200']]);
/*
$params = [
    'index' => 'products',
    'type'  => 'product',
    'id'    => '4',
    'body'  => ['username' => 'nabil'],
];

$response = $client->index($params);
//print_r($response);*/


?>