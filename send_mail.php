<?php
require_once "functions.php";
	
	$from 			= 'email@example.com';
	$reply_to		= 'email@example.com';
	$path_attchment = 'https://cdn.sstatic.net/Sites/drupal/img/logo.png';
	$body_email	    = '<h2>Hmood World!</h2><p>This is something with <b>HTML</b> formatting and <b>Attachment</b> .</p>' ;
	$to 			= 'email@example.com';
	$subject 		= 'Test email with attachment';
	$mail_send		= 'Test Mail Send';
	$mail_failed	= 'Test Mail Failed';


//send_mail($from,$to,$subject,$body_email,$path_attchment,$reply_to)
	send_mail($from,$to,$subject,$body_email,$path_attchment,$reply_to,$mail_send,$mail_failed);



?>