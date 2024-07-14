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
    <?php
        if(empty($_GET['selector']) and empty($_GET['validator'])){
            echo "could not validate your request";
        }else{
            $selector = $_GET["selector"];
            $validator = $_GET["validator"];
            if(ctype_xdigit($selector) and ctype_xdigit($validator)):
                ?>
    <h3 style="text-align:center"> Enter New password </h3>
        <div style="color:red">
            <?php Session::flash("error"); ?> 
        </div>
    <form action="controllers/ResetPasswordController.php" method="post">
        <input type="hidden" name="type" value="change_password">
        <input type="hidden" name="selector" value="<?= $selector ?>">
        <input type="hidden" name="validator" value="<?= $validator ?>">
        <input type="password" name="password" placeholder="Enter a new password">
        <input type="password" name="confirmed" placeholder="repeat new password">
        <button type="submit" name="submit"> change </button>
    </form>
    <?php
        else:
            echo "could not validate your request";
        endif;
            }
    ?>
</body>
</html>