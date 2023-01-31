<?php
	// protection from direct access
	if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		exit();
	}
	require_once("config/setup.php");
	$sql = $conn->prepare("SELECT login, email FROM users WHERE login=?");
	$sql->execute(array($_SESSION['loggued_on_user']));
	$ref = $sql->fetch();
?>

<div class="content_body">
<form action="../functions/delete.php" class="acct_details" method="post">
<h3>Delete Account</h3>
<fieldset>
	<legend>Please verify your login to delete your account.</legend>
		<input autocomplete="off" id="login" name="login" type="text" required placeholder="Login"/>
		<input autocomplete="off" id="passwd" name="passwd" type="password" required placeholder="Password"/>
	<?php
		if(isset($_SESSION["error"])){
			$error = $_SESSION["error"];
			echo "<span class='error'>$error</span>";
			unset($_SESSION["error"]);
		}
	?>
</fieldset>
<div class="clear"></div>
	<input name="delete" class="delete_btn" type="submit" value="Remove my account!">
</form>
</div>