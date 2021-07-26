<?php
use Elasticsearch\ClientBuilder;
require 'vendor/autoload.php';

class SearchElastic
{
   private $elasticclient = null;

    public function __construct()
   {
       $this->elasticclient = Elasticsearch\ClientBuilder::create()->build();
   }

   public function Mapping(){

    $params = [

        'index' => 'products',
        'body' => [
            'mappings' => [
                'product' => [
                    'properties' => [
                        'id' => [
                            'type' => 'text'
                         
                        ],
                        'product_name' => [
                            'type' => 'text'
                         
                        ],
                        'product_reference' => [
                            'type' => 'text'
                         
                        ],                            
                        'product_brand' => [
                            'type' => 'text'
                         
                        ],
                        'product_state' => [
                            'type' => 'text'
                         
                        ],
                    ]
                ]
            ]
        ]
    ];

    $this->elasticclient->indices()->create($params);

}

public function InsertData()
  {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $database_name = "search_engine";

  $con = mysqli_connect($servername,$username,$password,$database_name);
  $client = $this->elasticclient;
  $sql = "SELECT * FROM products ";
  
  $result = $con->query($sql);
  $params = null;

  while ($row = $result->fetch_assoc())
    {
       
    $params['body'][] = array(
      'index' => array(
        '_index' => 'articles',
        '_type' => 'article',
        '_id' => $row['id'],
      ) ,
    );
/*
    $params['body'][] = [
        'index' => [
            '_index' => 'articles',
	    ]
    ];*/

    $params['body'][] = ['product_name' => $row['product_name'], 'product_reference' => $row['product_reference'], 'product_brand' => $row['product_brand'], 'product_state' => $row['product_state'] ];
    }
  $this->Mapping();
  $responses = $client->bulk($params);
  return true;
  }

}

$p = new SearchElastic();
$p->InsertData();
?>

