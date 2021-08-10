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

                          ],

                          "highlight" => [
                              "pre_tags" => ["<b>"],
                            "post_tags" => ["</b>"],
                            "fields" => [
                              "product_reference" => ["force_source" => false ]
                          ]
                          ]
            ]
        ]);


        if($query['hits']['total']>=0){
            
            $result = $query['hits']['hits'];
            
            foreach($result as $single_result){
              $suggestions [] = $single_result['highlight']['product_reference'];
            }

            if(isset($suggestions)){
                echo json_encode($suggestions);
            }
            else{
                echo "no success";
            }
            
        }

        
    }
?>