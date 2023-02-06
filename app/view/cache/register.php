<?php class_exists('Template') or exit; ?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../../public/css/default.css">
    <title><?php echo htmlentities($title, ENT_QUOTES, 'UTF-8') ?></title>
    <meta charset="utf-8">
</head>
<body>
<div class="content">
    
<?php use core\Init as Init; ?>
<div class="topnav">
    <a <?php if ((Init::getInstance()->req_controller == 'index')) : ?> class="active"
    <?php endif; ?> href="http://camagru.sg">Home</a>
    <a href="http://camagru.sg/index/about">About</a>
    <a href="http://camagru.sg/index/contact">Contact</a>

    <div class="login-container flex">
        <?php if (!(Init::getInstance()->login)) : ?>
        <form name="navbar_login" id="navbar_login" method="post" action="http://camagru.sg/index/login">
            <input type="text" placeholder="Username" name="username">
            <input type="text" placeholder="Password" name="psw">

            <button type="submit">Login</button>

        </form>
        <div style="float: right">
            <a class="forgotpassword" href="http://camagru.sg/forgotpassword"> Forgot <br/> password? </a>
            <a style="padding: unset" href="http://camagru.sg/register">  <button type="button">Register</button></a>

            <?php else : ?>
            <a style="padding: unset" href="http://camagru.sg/index/logout"> <button type="submit">Logout</button></a>
            <?php endif; ?>
        </div>
    </div>
</div>

<h1>Registration</h1>
<p>Welcome to the registration page</p>


</div>
</body>
</html>


