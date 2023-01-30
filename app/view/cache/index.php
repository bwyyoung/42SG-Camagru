<?php class_exists('Template') or exit; ?>
<link rel="stylesheet" href="css/default.css" type="text/css" />

<!DOCTYPE html>
<html>
<head>
    <title><?php echo htmlentities($title, ENT_QUOTES, 'UTF-8') ?></title>
    <meta charset="utf-8">
</head>
<body>

<h1>Home</h1>
<p>Welcome to the home page, list of colors:</p>
<ul>
    <?php foreach($colors as $color): ?>
    <li><?php echo htmlentities($color, ENT_QUOTES, 'UTF-8') ?></li>
    <?php endforeach; ?>
</ul>
<?php echo $username ?> is <?php echo $age ?> years old <br /> <br />

<?php if ($age == 18) : ?>
true
<?php elseif ($age == 11) : ?>
Child
<?php else : ?>
false
<?php endif; ?>

<br />

<?php if ($username == 'Terry') : ?>
true
<?php else : ?>
false
<?php endif; ?>



</body>
</html>



