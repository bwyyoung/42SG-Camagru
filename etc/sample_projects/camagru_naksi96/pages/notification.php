<?php
	// protection from direct access
	if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
		exit();
	}
	require_once("config/setup.php");
	$sql = $conn->prepare("SELECT login, notification FROM users WHERE login=?");
	$sql->execute(array($_SESSION['loggued_on_user']));
	$ref = $sql->fetch();
?>

<div class="content_body">
<h3>Notification Setting</h3>
<form action="../functions/noti_update.php" method="POST">
 <p id="mobile_notification">
	 Mobile Notification: <input name="mobile_noti" type="checkbox" <?php if($ref['notification']) { ?>checked<?php }; ?>><br/>
	 <input class="save_change" name="submit"  type="submit" value="Save changes">
 </p>
</form>
</div>