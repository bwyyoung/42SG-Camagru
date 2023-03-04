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
    
<script><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/js/validate.js'); ?></script>
<style><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/css/navbar.css'); ?></style>
<div class="topnav">

    <a <?php if (($method == '' && $controller == 'index')) : ?> class="active"
    <?php endif; ?> href="http://camagru.sg/">Home</a>
    <a <?php if (($method == 'about')) : ?> class="active"
    <?php endif; ?> href="http://camagru.sg/index/about">About</a>
    <a <?php if (($method == 'contact')) : ?> class="active"
    <?php endif; ?>  href="http://camagru.sg/index/contact">Contact</a>

    <?php if (($controller != 'register')) : ?>
    <div class="login-container flex">
        <?php if (!($login)) : ?>
        <form name="navbar_login" id="navbar_login" method="post" action="http://camagru.sg/account/login" novalidate="novalidate" >
            <input type="text" placeholder="Username" name="username" id="username" title='Login' >
            <input type="password" minlength="14" placeholder="Password" name="password" id="password" title='Password' >
            <input type="checkbox"  value="1" title='Remember Me' id="rememberme" name="rememberme">
            <button type="submit" id="btn_login_submit">Login</button>
            <div class="login_outside_form">
                <a class="forgotpassword" href="http://camagru.sg/account/forgotpassword"> Forgot <br/> password? </a>
                <a style="padding: unset" href="http://camagru.sg/register">  <button type="button">Register</button></a>
                <script><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/js/validate.js'); ?></script>
                <script><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/js/navbar.js'); ?></script>
        <?php else : ?>
                <div class="dropdown">
                    <button class="dropbtn"><?php echo htmlentities($username, ENT_QUOTES, 'UTF-8') ?>
                        <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                        <a href="http://camagru.sg/account/upload">Upload Image</a>
                        <a href="http://camagru.sg/account/">Profile</a>
                        <a href="http://camagru.sg/account/settings">Settings</a>
                    </div>
                </div>
                <a style="padding: unset" href="http://camagru.sg/account/logout" class="logout"> <button type="submit">Logout</button></a>
        <?php endif; ?>
            </div>
        </form>

    </div>
    <?php endif; ?>
</div>

<style><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/css/account.css'); ?></style>

<?php if (($state == 'state_forgotpassword')) : ?>
FORGOTPASSWORD
<?php elseif (($state == 'state_settings')) : ?>
    SETTINGS

<?php elseif (($state == 'state_upload')) : ?>
    UPLOAD

<?php else : ?>
    PROFILE
<?php endif; ?>

<script><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/js/account.js'); ?></script>

</div>
</body>
</html>


