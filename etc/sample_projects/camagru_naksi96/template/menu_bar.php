<?php
// protection from direct access
if (realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] )) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
	exit();
}
?>
<nav>
	<ul>
	<div>
		<li>
			<a class="navbar-brand" href="/">
				<span class="logo">CAMAGRU</span>
			</a>
		</li>
	</div>
	<div class="right_nav">
		<?php
			if (isset($_SESSION["loggued_on_user"])) {
		?>
		<li>
			<a href="upload.php" class="menu"><i class="fas fa-upload fa-lg" name="Upload"></i></a>
		</li>
		<li>
			<a href="myaccount.php?id=default" class="menu"><i class="fas fa-user-circle fa-lg" name="My Account"></i></a>
		</li>
		<li>
			<a href="functions/logout.php" class="menu"><i class="fas fa-sign-out-alt fa-lg" name="Logout"></i></a>
		</li>
		<?php
			} else {
		?>
			<li>
				<a href="login.php" class="menu" style="line-height:60px;">Login</a>
			</li>
		<?php
			}
		?>
	</div>
	</ul>
</nav>