<?php 


//send_mail($from,$to,$subject,$body_email,$path_attchment,$reply_to)
function send_mail($from,$to,$subject,$body_email,$path_attchment,$reply_to,$mail_send,$mail_failed)   {

	$random_hash = md5(date('r', time()));
	//define the headers we want passed. Note that they are separated with \r\n
	$headers = "From: " . $from . "\r\nReply-To:". $reply_to ;
	//add boundary string and mime type specification
	$headers .= "\r\nContent-Type: multipart/mixed; boundary=\"PHP-mixed-".$random_hash."\"";
	//read the atachment file contents into a string,
	//encode it with MIME base64, 
	//and split it into smaller chunks
	$attachment = chunk_split(base64_encode(file_get_contents($path_attchment)));
	//define the body of the message.
	ob_start(); //Turn on output buffering
	?>
	--PHP-mixed-<?php echo $random_hash; ?> 
	Content-Type: multipart/alternative; boundary="PHP-alt-<?php echo $random_hash; ?>"

	--PHP-alt-<?php echo $random_hash; ?> 
	Content-Type: text/html; charset="iso-8859-1"
	Content-Transfer-Encoding: 7bit

	<?php print $body_email ; ?>

	--PHP-alt-<?php echo $random_hash; ?>--

	--PHP-mixed-<?php echo $random_hash; ?> 
	Content-Type: <?php echo get_mime_type($path_attchment); ?>; name="attachment" 
	Content-Transfer-Encoding: base64 
	Content-Disposition: attachment 

	<?php echo $attachment; ?>
	--PHP-mixed-<?php echo $random_hash; ?>--

	<?php
	//copy current buffer contents into $message variable and delete current output buffer
	$message = ob_get_clean();
	//send the email
	$mail_sent = @mail( $to, $subject, $message, $headers );
	//if the message is sent successfully print "Mail sent". Otherwise print "Mail failed"
	echo $mail_sent ? $mail_send : $mail_failed;
}


//This function ti Select the attachment file type
function get_mime_type($filename) {
    $idx = explode( '.', $filename );
    $count_explode = count($idx);
    $idx = strtolower($idx[$count_explode-1]);

    $mimet = array( 
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',

        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',

        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',

        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',

        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',

        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'docx' => 'application/msword',
        'xlsx' => 'application/vnd.ms-excel',
        'pptx' => 'application/vnd.ms-powerpoint',


        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    if (isset( $mimet[$idx] )) {
     return $mimet[$idx];
    } else {
     return 'application/octet-stream';
    }
 }
?> 