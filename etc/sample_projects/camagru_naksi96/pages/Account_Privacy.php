<?php
// protection from direct access
if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
?>
<div class="content_body">
<form action="../functions/passwd_update.php" class="acct_details" method="post">
<h3>Account Privacy</h3>
	<fieldset>
		<legend>Password change</legend>
		<p class="">
			<label for="password_current">Current password (leave blank to leave unchanged)</label>
			<input autocomplete="off" class="input-text" id="password_current" name="oldpw" type="password"/>
		</p>
		<p class="">
			<label for="password_1">New password (leave blank to leave unchanged)</label>
			<input autocomplete="off" class="input-text" id="password_1" name="newpw" type="password"/>
		</p>
		<p class="">
			<label for="password_2">Confirm new password</label>
			<input autocomplete="off" class="input-text" id="password_2" name="newpw_conf" type="password"/>
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
	<input name="save_acct_pw" class="save_change" type="submit" value="Save changes">
</form>
</div>