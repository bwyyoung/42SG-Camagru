<?php class_exists('View\Template') or exit; ?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlentities($title, ENT_QUOTES, 'UTF-8') ?></title>
    <meta charset="utf-8">
    <base href="/" />
</head>
<body>
<div class="content">
    
<style><?php require_once('D:\PhpstormProjects\DSTA_Build-1/app/view/css/navbar.css'); ?></style>
<div class="topnav">

    <a <?php if (($method == '' && $controller == 'index')) : ?> class="active"
    <?php endif; ?> href="http://www.camagru.sg/">Home</a>
    <a <?php if (($method == 'about')) : ?> class="active"
    <?php endif; ?> href="http://camagru.sg/index/about">About</a>
    <a <?php if (($method == 'contact')) : ?> class="active"
    <?php endif; ?>  href="http://camagru.sg/index/contact">Contact</a>

    <?php if (($controller != 'register')) : ?>
    <div class="login-container flex">
        <?php if (!($login)) : ?>
        <form name="navbar_login" id="navbar_login" method="post" action="http://camagru.sg/account/login">
            <input  type="text" placeholder="Username" name="username">
            <input type="password" minlength="14" placeholder="Password" name="password">
            <button type="submit">Login</button>
            <div class="login_outside_form">
                <a class="forgotpassword" href="http://camagru.sg/forgotpassword"> Forgot <br/> password? </a>
                <a style="padding: unset" href="http://camagru.sg/register">  <button type="button">Register</button></a>
                <?php else : ?>
                <a style="padding: unset" href="http://camagru.sg/index/logout"> <button type="submit">Logout</button></a>
                <?php endif; ?>
            </div>
        </form>

    </div>
    <?php endif; ?>
</div>


<?php if (($method == '')) : ?>
<h1>Home</h1>
<p>Welcome to Camagru SG</p>

<?php elseif (($method == 'about')) : ?>
<h1>About</h1>
<p> How to upload photos here and stuff </p>
<h1>Terms of Service</h1>
<p> Law stuff </p>
<?php elseif (($method == 'contact')) : ?>
<h1>Contact</h1>
<p>Contact our staff here</p>
<?php endif; ?>


</div>
</body>
</html>


