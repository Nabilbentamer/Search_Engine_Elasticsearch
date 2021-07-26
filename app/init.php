<?php

    use Elasticsearch\ClientBuilder;

    require 'vendor/autoload.php';

    $hosts = ['localhost:9200'];
    
    $elasticclient = ClientBuilder::create()->build();

    

    
    //var_dump($result);

    function Mapping(){
        $params = [
            'index' => 'articles',
            'body' => [
                'mappings' => [
                    'article' => [
                        'properties' => [
                            'id' => [
                                'type' => 'integer'
                             
                            ],
                            'product_name' => [
                                'type' => 'string'
                             
                            ],
                            'product_reference' => [
                                'type' => 'string'
                             
                            ],                            
                            'product_brand' => [
                                'type' => 'string'
                             
                            ],
                            'product_state' => [
                                'type' => 'string'
                             
                            ],
                        ]
                    ]
                ]
            ]
        ];
    $elasticclient->indices()->create($params);

}





    ?>
