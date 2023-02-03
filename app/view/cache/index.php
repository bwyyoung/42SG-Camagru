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
    <?php endif; ?> href="http://www.camagru.sg/">Home</a>
    <a href="http://www.camagru.sg/index/about">About</a>
    <a href="http://www.camagru.sg/index/contact">Contact</a>

    <div class="login-container flex">
        <?php if (!(Init::getInstance()->login)) : ?>
        <form name="navbar_login" id="navbar_login" method="post" action="http://www.camagru.sg/index/login">
            <input type="text" placeholder="Username" name="username">
            <input type="text" placeholder="Password" name="psw">
            <button type="submit">Login</button>
        </form>
        <div>
            <a style="padding: unset" href="http://www.camagru.sg/register">  <button type="button">Register</button></a>
        <?php else : ?>
            <a style="padding: unset" href="http://www.camagru.sg/index/logout"> <button type="submit">Logout</button></a>
        <?php endif; ?>
        </div>
    </div>
</div>

<h1>Home</h1>
<p>Welcome to the home page</p>


</div>
</body>
</html>


