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
    <?php
        require_once "helpers/Session.php";
    ?>
    <div style="color: red;"> <?php Session::flash("error") ?> </div>
    <form action="controllers/UserController.php" method="post">
        <input type="hidden" name="type" id="" value="register">
        <input type="text" name="username" id="" placeholder="username">
        <input type="text" name="email" id="" placeholder="email">
        <input type="text" name="password" id="" placeholder="passwaord">
        <input type="text" name="confirmed" id="" placeholder="confirm password">
        <a href="login.php">already exists</a>
        <button type="submit" name="submit">signup</button>
    </form>
</body>
</html>