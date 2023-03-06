<?php class_exists('View\Template') or exit;?><?php include(WEB_ROOT."/app/view/template/template_include.php"); ?><?php use loader\Media as Media; ?>

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
    <?php endif; ?> href="http://camagru.sg/">Home</a>
    <a <?php if (($method == 'about')) : ?> class="active"
    <?php endif; ?> href="http://camagru.sg/index/about">About</a>
    <a <?php if (($method == 'contact')) : ?> class="active"
    <?php endif; ?>  href="http://camagru.sg/index/contact">Contact</a>

    <div class="login-container flex">
        <?php if (!($login)) : ?>
            <?php if (($controller != 'register' && $method != 'forgot_password' && $method != 'reset_password')) : ?>
            <form name="navbar_login" id="navbar_login" method="post" action="http://camagru.sg/account/login" novalidate="novalidate" >
                <input type="text" placeholder="Username" name="username" id="username" title='Login' >
                <input type="password" minlength="14" placeholder="Password" name="password" id="password" title='Password' >
                <input type="checkbox"  value="1" title='Remember Me' id="rememberme" name="rememberme">
                <button type="submit" id="btn_login_submit">Login</button>
                <div class="login_outside_form">
                    <a class="forgotpassword" href="http://camagru.sg/account/forgot_password"> Forgot <br/> password? </a>
                    <a style="padding: unset" href="http://camagru.sg/register">  <button type="button">Register</button></a>
                    <script><?php require_once('D:\PhpstormProjects\DSTA_Build-1/app/view/js/validate.js'); ?></script>
                    <script><?php require_once('D:\PhpstormProjects\DSTA_Build-1/app/view/js/navbar.js'); ?></script>
            <?php endif; ?>
        <?php else : ?>
            <div class="dropdown">
                <button class="dropbtn"> <?php echo htmlentities($username, ENT_QUOTES, 'UTF-8') ?>&nbsp;
                    <i class="fa fa-caret-down"></i>
                        <img id="image-verified"
                        <?php if (($verified)) : ?>
                            src='<?= Media::image_site_svg("verified"); ?>'
                        <?php else : ?>
                            src='<?= Media::image_site_svg("unverified"); ?>'
                        <?php endif; ?>
                    >
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


