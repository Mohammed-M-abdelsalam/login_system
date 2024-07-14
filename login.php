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
    <div style="color:red"> <?php Session::flash("error");?> </div>
    <div style="color:green"> <?php Session::flash("success");?> </div>
    <form action="controllers/UserController.php" method="post">
        <input type="hidden" name="type" value="login" id="">
        <input type="text" name="email" id="" placeholder="email">
        <input type="text" name="password" id="" placeholder="passwaord">
        <a href="reset_password.php">forgot password</a>
        <a href="register.php">register</a>
        <button type="submit" name="submit">login</button>
    </form>
</body>
</html>