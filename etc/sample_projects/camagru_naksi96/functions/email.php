<?php
	function email_verify($email, $login, $hash) {
		$to      = $email; // Send email to our user
		$subject = 'Signup | Verification from Camagru'; // Give the email a subject 
		$message = '
		
		Thanks for signing up to Camagru! 
		
		'.$login.'
				
		Please click this link to activate your account:
		http://localhost:3000/verify.php?email='.$email.'&hash='.$hash.'
		
		'; // Our message above including the link
							
		$headers = 'From:no-reply-verify@Camagru.com' . "\r\n"; // Set from headers
		mail($to, $subject, $message, $headers); // Send our email
	}

	function email_passwd($email, $login, $rand_pw) {
		$to      = $email; // Send email to our user
		$subject = 'Find Password | password reset from Camagru'; // Give the email a subject 
		$message = '
		
		You have requested to reset your password! 
		
		'.$login.'
		
		Plase login by using the password below, and change the password.

		'.$rand_pw.'
		
		'; // Our message above including the link
							
		$headers = 'From:no-reply-reset@Camagru.com' . "\r\n"; // Set from headers
		mail($to, $subject, $message, $headers); // Send our email
	}

	function email_comment_alert($email, $login, $from) {
		$to      = $email; // Send email to our user
		$subject = 'Notification from Camagru | '.$from.' commented on you picture!'; // Give the email a subject 
		$message = '
		
		Hi '.$login.',
		
		'.$from.' has commented on your picture!
		Come and figure out what this person said!
		
		';
							
		$headers = 'From:no-reply-notification@Camagru.com' . "\r\n"; // Set from headers
		mail($to, $subject, $message, $headers); // Send our email
	}
?>