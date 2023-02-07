<?php class_exists('Template') or exit; ?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlentities($title, ENT_QUOTES, 'UTF-8') ?></title>
    <meta charset="utf-8">
</head>
<body>
<div class="content">
    
<link rel="stylesheet" href="../../../public/css/navbar.css">
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
        </form>
        <div>
            <a style="padding: unset" href="http://camagru.sg/register">  <button type="button">Register</button></a>
        <?php else : ?>
            <a style="padding: unset" href="http://camagru.sg/index/logout"> <button type="submit">Logout</button></a>
        <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
</div>


<link rel="stylesheet" href="../../public/css/register.css">

<form action="http://camagru.sg/register/register_account" method="post" >
    <div class="registercontainer">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>
        <label for="username"><b>username</b></label>
        <input type="text" placeholder="Enter Username" name="username" id="username" required>
        <br/>
        <label for="email"><b>Email</b></label>
        <input type="text" placeholder="Enter Email" name="email" id="email" required>
<br/>
        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
        <br/>
        <label for="psw-repeat"><b>Repeat Password</b></label>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
<br/>
        <hr>

        <p>By creating an account you agree to our <a href="http://camagru.sg/index/about">Terms & Privacy</a>.</p>
        <button type="submit" class="registerbtn">Register</button>
    </div>

    <div class="registercontainer signin">
        <p>Already have an account? <a href="http://camagru.sg/">Sign in</a>.</p>
    </div>
</form>


</div>
</body>
</html>


