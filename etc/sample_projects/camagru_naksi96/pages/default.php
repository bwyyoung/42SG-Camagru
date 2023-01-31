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
	<form action="../functions/acct_update.php" class="acct_details" method="post">
	<h3>Account Info</h3>
	<fieldset>
		<legend>Update Information</legend>
		<p class="">
			<label for="login">Login</label>
			<input autocomplete="off" class="input-text" id="login" name="login" value="<?php echo $ref['login']; ?>" type="text" required placeholder="New Login"/>
		</p>
		<p class="">
			<label for="email">E-mail</label>
			<input autocomplete="off" class="input-text" id="email" name="email" value="<?php echo $ref['email']; ?>" type="email" required placeholder="New E-mail"/>
		</p>
		<?php
			if(isset($_SESSION["error"])){
				$error = $_SESSION["error"];
				echo "<span class='error'>$error</span>";
				unset($_SESSION["error"]);
			}
		?>
	</fieldset>
	<div class="clear"></div>
	<p>
		<input class="save_change" name="save_acct_details" style="margin-right: 5px" type="submit" value="Save changes">
	</p>
	</form>
</div>