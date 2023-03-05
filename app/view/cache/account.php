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
    
<style><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/css/navbar.css'); ?></style>
<div class="topnav">

    <a <?php if (($method == '' && $controller == 'index')) : ?> class="active"
    <?php endif; ?> href="http://camagru.sg/">Home</a>
    <a <?php if (($method == 'about')) : ?> class="active"
    <?php endif; ?> href="http://camagru.sg/index/about">About</a>
    <a <?php if (($method == 'contact')) : ?> class="active"
    <?php endif; ?>  href="http://camagru.sg/index/contact">Contact</a>

    <?php if (($controller != 'register' && $method != 'forgot_password' && $method != 'reset_password')) : ?>
    <div class="login-container flex">
        <?php if (!($login)) : ?>
        <form name="navbar_login" id="navbar_login" method="post" action="http://camagru.sg/account/login" novalidate="novalidate" >
            <input type="text" placeholder="Username" name="username" id="username" title='Login' >
            <input type="password" minlength="14" placeholder="Password" name="password" id="password" title='Password' >
            <input type="checkbox"  value="1" title='Remember Me' id="rememberme" name="rememberme">
            <button type="submit" id="btn_login_submit">Login</button>
            <div class="login_outside_form">
                <a class="forgotpassword" href="http://camagru.sg/account/forgot_password"> Forgot <br/> password? </a>
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

<?php if (($state == 'state_forgotpassword' || $state == 'state_resetpassword' ||  $state == 'state_forgotpassword_submit')) : ?>
    
<style><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/css/form.css'); ?></style>
<div class="formcontainer">
    <?php if (($state == 'state_forgotpassword')) : ?>
        <form action="http://camagru.sg/account/forgot_password_submit" method="post" id="form_forgot_password" novalidate="novalidate" >
            <h1>Forgot Password</h1>
            <p>Enter your email address and click Submit. <br>
                An email will be sent to your address containing a link that you can follow to reset your password.<br>
                <b>Remember to check your junk or spam folder if the email doesn't appear in your inbox.</b>
            </p>
            <hr>
            <label for="email"><b>Email</b></label>
<input type='email' placeholder="Enter Email" name="email" id="email" required>
<br/>
<span id = "email_check" style="color:red"></span> <br/>

            <span id = "message_error" style="color:red"> </span>

<button type="submit" class="formbtn" id="btn_submit">Submit</button>
        </form>
    <?php elseif (($state == 'state_forgotpassword_submit')) : ?>
        <span id = "reg_success" style="color:greenyellow"> <?php echo htmlentities($message, ENT_QUOTES, 'UTF-8') ?> <br>
        The link in the email will expire in 24 hours. <br>
        If you did not receive your password reset email, please <a href="http://camagru.sg/account/forgot_password">Click Here.</a>
        </span> <br>
    <?php elseif (($state == 'state_resetpassword')) : ?>
    <form action="http://camagru.sg/account/reset_password_submit" method="post" id="form_reset_password" novalidate="novalidate" >
        <h1>Reset Password</h1>
        <p>Enter your new password and click Submit.
        </p>
        <hr>
        
<label for="password"><b>Password</b></label>
<input type="password" placeholder="Enter Password (8-100 characters, UPPERCASE, lowercase, Numbers and Symbols)" name="password" id="password"
       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
       required>
<br/><br/>
<label for="password-repeat"><b>Repeat Password</b></label>
<input type="password" placeholder="Repeat Password" name="password-repeat" id="password-repeat"
       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
       required>
<br/><br/>


        <input type="hidden" value="<?php echo $_GET['email'];?>" name="email" id="email">
<input type="hidden" value="<?php echo $_GET['token'];?>" name="token" id="token">
        <span id = "message_error" style="color:red"> </span>

<button type="submit" class="formbtn" id="btn_submit">Submit</button>
    </form>
    <?php endif; ?>
</div>
    <script><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/js/validate.js'); ?></script>
    <script><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/js/form.js'); ?></script>

<?php elseif (($state == 'state_settings')) : ?>
    <style><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/css/form.css'); ?></style>
<style><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/css/settings.css'); ?></style>
<div class="formcontainer">
    <h2>Settings</h2>
    <div class="tab">
        <button class="tablinks active" onclick="openTab(event, 'Edit Username')">Edit Username</button>
        <button class="tablinks" onclick="openTab(event, 'Edit Email Address')">Edit Email Address</button>
        <button class="tablinks" onclick="openTab(event, 'Edit Password')">Edit Password</button>
    </div>
    <form action="http://camagru.sg/account/edit_user" method="post" id="form_settings_username" novalidate="novalidate" >
        <div id="Edit Username" class="tabcontent">
                <label for="username"><b>Username</b></label>
<input type="text" placeholder="Enter Username" name="username" id="username" required>
<span id = "username_check" style="color:red"></span> <br/><br/>
        </div>

        <div id="Edit Email Address" class="tabcontent">
                <label for="email"><b>Email</b></label>
<input type='email' placeholder="Enter Email" name="email" id="email" required>
<br/>
<span id = "email_check" style="color:red"></span> <br/>

        </div>

        <div id="Edit Password" class="tabcontent">
                
<label for="password"><b>Password</b></label>
<input type="password" placeholder="Enter Password (8-100 characters, UPPERCASE, lowercase, Numbers and Symbols)" name="password" id="password"
       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
       required>
<br/><br/>
<label for="password-repeat"><b>Repeat Password</b></label>
<input type="password" placeholder="Repeat Password" name="password-repeat" id="password-repeat"
       pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
       required>
<br/><br/>


        </div>
        <span id = "message_error" style="color:red"> </span>

<button type="submit" class="formbtn" id="btn_submit">Submit</button>
    </form>

</div>
<script><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/js/settings.js'); ?></script>
<script><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/js/validate.js'); ?></script>
<script><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/js/form.js'); ?></script>

<?php elseif (($state == 'state_upload')) : ?>
    UPLOAD

<?php else : ?>
    PROFILE
<?php endif; ?>

<script><?php require_once('E:\PHPStorm\DSTA_Build-1/app/view/js/account.js'); ?></script>

</div>
</body>
</html>


