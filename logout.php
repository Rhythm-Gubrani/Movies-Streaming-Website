<?php
session_start();
session_unset();
unset($_COOKIE["username"]);
setcookie("username", time() - 3600);
unset($_COOKIE["password"]);
setcookie("password", time() - 3600);
unset($_COOKIE['status']);
setcookie("status", time() - 3600);
header("Location: ./connexion.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Logout</title>
</head>
<body>

</body>
</html>
