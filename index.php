<?php

    require_once "app\simple.php";


    if(isset($_GET['q'])){
        
        $q = $_GET['q'];

        
        $query = $client->search([

            'body' => [
                'query' => [

                    //'fuzzy' => ['product_state' => $q] 

                    /*
                    "match_phrase_prefix" => [
                        "product_image" => ["query"=> $q] //,"prodcut_reference" => ["query"=> $q]
                          ]*/

                            
                          "multi_match" => [
                            "fields" => ["product_brand", "product_category","product_state","product_reference","product_name"],
                            "query" => $q,
                            "type" => "phrase_prefix"
                        ]

                        /*    
                        'multi_match' => [
                            'query' => $q,
                            'fields' => ['product_name','product_image','product_reference','product_brand'],
                            'type' => 'phrase_prefix',
                            'fuzziness' => 'AUTO'
                        ]*/

                ]
            ]
        ]);


        if($query['hits']['total']>=1){
            
            $result = $query['hits']['hits'];

        }

    }

?>

<!DOCTYPE html> 
<html lang="en">
<head>
    
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    <title>Search Engine</title>

</head>

<body>
    <div class="s130">
        <form action="index.php" method="GET">
          <div class="inner-form">
            <div class="input-field first-wrap">
              <div class="svg-wrapper">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path
                    d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z">
                  </path>
                </svg>
              </div>
              <input id="search" type="text" placeholder="What are you looking for?" name ="q"/>
            </div>
            <div class="input-field second-wrap">
              <button class="btn-search" type="submit">SEARCH</button>
            </div>
          </div>
        </form>
      </div>

    <div class="container mt-5 mb-5">
        <div class="d-flex justify-content-center row">
            <div class="col-md-10">


                <!-- start of products listings-->
                
                <?php 

                if(isset($result)){
                    foreach($result as $r){

                ?>

                <div class="row p-2 bg-white border rounded">
                    <div class="col-md-3 mt-1"><img class="img-fluid img-responsive rounded product-image" src="images/<?php echo $r['_source']['product_image'] ?> " ></div>
                    <div class="col-md-6 mt-1">
                        <h5> Réf: <?php echo $r['_source']['product_reference'] ?></h5>
                        <h6> Category : <?php echo $r['_source']['product_category'] ?> / Marque : <?php echo $r['_source']['product_brand'] ?></h6>
                        <div class="d-flex flex-row">
                            <div class="ratings mr-2"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div><span>310</span>
                        </div>
                        <p class="text-justify text-truncate para mb-0"> ceci est une description de test<br><br></p>
                    </div>
                    <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                        <div class="d-flex flex-row align-items-center">
                            <h4 class="mr-1"> Nom: <?php echo $r['_source']['product_name'] ?></h4><span class="strike-text">$20.99</span>
                        </div>
                        <h6 class="text-success">Etat du produit :<?php echo $r['_source']['product_state'] ?></h6>
                        <div class="d-flex flex-column mt-4"><button class="btn btn-primary btn-sm" type="button">Details</button><button class="btn btn-outline-primary btn-sm mt-2" type="button">Add to wishlist</button></div>
                    </div>
                </div>

                <?php 
                                    }
                                }

                ?>



            </div>
        </div>
    </div>
</body>

</html>