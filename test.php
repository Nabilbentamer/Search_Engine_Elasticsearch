<?php

    require_once "app\simple.php";


    if(isset($_POST['q'])){
        
        $q = $_POST['q'];
        
        $query = $client->search([

            'body' => [
                'query' => [                            
                          "multi_match" => [
                            "fields" => ["product_brand", "product_category","product_state","product_reference","product_name"],
                            "query" => $q,
                            "type" => "phrase_prefix"
                        ]

                ]
            ]
        ]);


        if($query['hits']['total']>=1){
            
            $result = $query['hits']['hits'];
            
            foreach($result as $single_result){
              $suggestions [] = $single_result['_source']['product_reference'];
            }

            echo json_encode($suggestions);
        }
        
    }
?>