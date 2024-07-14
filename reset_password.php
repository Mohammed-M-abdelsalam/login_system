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
    require_once("nav.php"); 
    require_once "helpers/Session.php";
    ?>
    <div style="color:green"> <?php Session::flash("success");?> </div>
    <div style="color:red"> <?php Session::flash("error");?> </div>
    <form action="controllers/ResetPasswordController.php" method="post">
        <input type="hidden" name="type" value="reset_password" id="">
        <input type="text" name="email" id="" placeholder="email">
        <button type="submit" name="submit">send</button>
    </form>
</body>
</html>