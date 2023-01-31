<?php
	session_start();
	if (!isset($_SESSION["loggued_on_user"])) {
		header ('Location: login.php');
		exit();
	}
	if (!isset($_GET['id']) || $_GET['id'] == '') {
		header ('Location: /');
		exit();
	}
?>

<html>
	<head>
		<?php require_once ('template/head_includes.php'); ?>
		<title>Camagru - Login</title>
		<link href="/css/postdetail.css" rel="stylesheet">
	</head>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript" src="js/upload.js"></script>
	<body>
		<div class="whole_body">
			<?php require_once ('template/menu_bar.php'); ?>
			<div class="container">
				<div class="row post_detail_row">
					<div class="col-sm-1"></div>
					<div class="col-sm-10 form post_detail_col">
						<?php
							require_once 'functions/postdetail_fetch.php';
							require_once 'config/setup.php';
							$load_img = load_image($_GET['id'], $conn);
							?>
							<div>
							<span style="color: grey; display:inline; float:left;"><?php echo $load_img['postdate']; ?></span>
							<?php
								if ($load_img['login'] === $_SESSION['loggued_on_user']) {
									?>
										<form action="functions/delete_post.php" method="POST" style="display:inline;" id="form_delete_post">
											<i class="fas fa-trash-alt" id="delete_post" style="line-height:27px;" onclick="delete_post();"></i>
											<input type="hidden" name="img_id" value="<?php echo $_GET['id']; ?>">
											<input type="hidden" name="post_login" value="<?php echo $load_img['login']; ?>">
										</form>
									<?php
								}
							?>
							</div>
							<img class="post_image" src="<?php echo $load_img['img']; ?>">
							<span style="color: grey;">Posted by : </span><span><?php echo $load_img['login']; ?></span>
							<div class='like_comment_btn'>
								<input type="hidden" id="image_id" name="imgid" value="<?php echo $_GET['id']; ?>">
								<input type="hidden" id="loggued_on_user" name="login" value="<?php echo $_SESSION['loggued_on_user']; ?>">
								<div class="button_align">
									<div>
										<span class="visually-hidden">Likes:</span>
										<?php
											if (check_liked($_GET['id'], $_SESSION['loggued_on_user'], $conn)) {
												?>
													<i class="fas fa-heart fa-lg" id="like-btn-1" aria-hidden="true" onclick="likePost(1)"></i>
													<i class="far fa-heart fa-lg" id="like-btn-0" aria-hidden="true" onclick="likePost(0)" style="display:none"></i>
												<?php
											} else {
												?>
													<i class="fas fa-heart fa-lg" id="like-btn-1" aria-hidden="true" onclick="likePost(1)" style="display:none"></i>
													<i class="far fa-heart fa-lg" id="like-btn-0" aria-hidden="true" onclick="likePost(0)"></i>
												<?php
											}
										?>
									</div>
									<div id="num_likes">
										<?php echo(get_num_likes($_GET['id'], $conn)); ?>
									</div>
								</div>
								<div class="button_align">
									<span class="visually-hidden">Comments:</span><i class="fas fa-comment fa-lg" id="comment-btn" aria-hidden="true" onclick="showComments()"></i>
									<div id="num_comments">
										<?php echo(get_num_comments($_GET['id'], $conn)); ?>
									</div>
								</div>
							</div>
							<div id="comment_display" style="display:none">
								<div id="comment_list"></div>
								<div>
									<textarea name="comment" id="comment_input" placeholder="Enter the comment."></textarea>
									<button id="comment_submit" onclick="commentPost(event);">Submit</button>
								</div>
							</div>
					</div>
					<div class="col-sm-1"></div>
					</div>
				</div>
			</div>
		</div>
		<footer>
			<i class="far fa-copyright"> 2019 doyang</i>
		</footer>
	</body>
</html>