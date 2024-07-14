<?php 
require_once "helpers/Session.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/index.css">
</head>
<body>
    <?php require_once("nav.php") ?>

    <section class="main">
        <h2>welcome, 
            <?php 
                if(Session::put("name")):  
                    echo Session::put('name'); 
                else: 
                    echo " guest" ;
                endif;  
            ?> 
        </h2>
    </section>
</body>
</html>