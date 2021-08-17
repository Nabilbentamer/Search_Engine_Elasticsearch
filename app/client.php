<?php 

require_once '../vendor/autoload.php';

$client = Elasticsearch\ClientBuilder::create()
->setBasicAuthentication('elastic', 'mqdYszgeuIrLnY0xqO3Z')
->build();




?>