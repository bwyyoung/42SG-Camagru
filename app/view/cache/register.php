<?php class_exists('Template') or exit; ?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlentities($title, ENT_QUOTES, 'UTF-8') ?></title>
    <meta charset="utf-8">
    <base href="/" />
</head>
<body>
<div class="content">
    
<style><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/css/navbar.css'); ?></style>
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
        <form name="navbar_login" id="navbar_login" method="post" action="http://camagru.sg/index/login">
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


<style><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/css/register.css'); ?></style>

<form method="post">
    <button type="submit"  class="registercontainer" name="test">Test</button>
</form>

<form action="http://camagru.sg/register/register_account" method="post" id="form_register">
    <div class="registercontainer">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>
        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="username" id="username" required>

        <span id = "username_check" style="color:red"></span> <br/><br/>
        <label for="email"><b>Email</b></label>
        <input type='email' placeholder="Enter Email" name="email" id="email" required>
<br/>
        <span id = "email_check" style="color:red"></span> <br/>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password (minimum 14 characters, Uppercase, Lowercase, numbers and symbols)" name="psw" id="psw"
               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
               required>
        <br/><br/>
        <label for="psw-repeat"><b>Repeat Password</b></label>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat"
               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
               required>
<br/><br/>


        <span id = "message_error" style="color:red">Please fill in registration information. </span> <br><br>
        <hr>

        <p>By creating an account you agree to our <a href="http://camagru.sg/index/about">Terms & Privacy</a>.</p>
        <button type="submit" class="registerbtn" id="btn_register_submit">Register</button>
    </div>

    <div class="registercontainer signin">
        <p>Already have an account? <a href="http://camagru.sg/">Sign in</a>.</p>
    </div>
</form>

<script><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/js/register.js'); ?></script>


</div>
</body>
</html>


