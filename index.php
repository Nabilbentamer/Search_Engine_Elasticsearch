<?php

    require_once "app\simple.php";

    if(isset($_GET['q'])){
        
        $q = $_GET['q'];
        
        $query = $client->search([

            'body' => [
                    "query" => [
                            "multi_match" => [
                              "fields"=>["product_*"],
                              "query"=>$q,
                              "prefix_length"=>"0",
                              "fuzziness"=>"1"
                            ]
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
    
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <title>Search Engine</title>

</head>

<body>
        <form action="index.php" method="GET" autocomplete="off">

        <div class="wrapper">

            <div class="search-input">

                <a href="" target="_blank" hidden></a>
                <input type="text" placeholder="Type to search.." name="q">
                
                <div class="autocom-box">
                    <!-- here list are inserted from javascript -->
                    
                </div>
                
                <button class="icon" type="submit"><i class="fas fa-search"></i></button>
                
                </div>

                </div>

        </form>

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

    <script src="search_as_you_type.js" ></script>
</body>

</html>