<?php class_exists('Template') or exit; ?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/default.css">
    <title><?php echo htmlentities($title, ENT_QUOTES, 'UTF-8') ?></title>
    <meta charset="utf-8">
</head>
<body>
<div class="content">
    
<?php use core\Init as Init; ?>
<div class="topnav">
    <a class="active" href="#home">Home</a>
    <a href="#about">About</a>
    <a href="#contact">Contact</a>

    <div class="login-container flex">
        <?php if (!(Init::getInstance()->login)) : ?>
        <form name="navbar_login" id="navbar_login" method="post" action="http://camagru.sg/?action=login">
            <input type="text" placeholder="Username" name="username">
            <input type="text" placeholder="Password" name="psw">
            <button type="submit">Login</button>
        </form>
        <div>
        <button type="submit">Register</button>
        <?php else : ?>
        <button type="submit">Logout</button>
        <?php endif; ?>
        </div>
    </div>
</div>

<h1>Home</h1>
<p>Welcome to the home page, list of colors:</p>


<?php if ($age == 18) : ?>
true
<?php elseif ($age == 11) : ?>
<?php echo $username ?> is <?php echo $age ?> years old <br /> <br />
<?php else : ?>
false
<?php endif; ?>

<?php if ($username == 'Terry') : ?>
true
<ul>
    <?php foreach($colors as $color): ?>
    <li><?php echo htmlentities($color, ENT_QUOTES, 'UTF-8') ?></li>
    <?php endforeach; ?>
</ul>
<?php else : ?>
false
<?php endif; ?>



</div>
</body>
</html>


