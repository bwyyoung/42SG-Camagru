<?php
$name = $_GET['name'] ?? 'CAMAGRU';

header('Content-Type: text/html; charset=utf-8');
printf('Start of program: %s<br>', htmlspecialchars($name, ENT_QUOTES, 'UTF-8'));

if (!isset($_SERVER['PATH_INFO']))
{
    echo "Home page";
    exit();
}

print "The request path is : ".$_SERVER['PATH_INFO'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Camagru Home Page</title>
</head>
<body>
    <p>HELLO WORLD WEEDS</p>
</body>
</html>