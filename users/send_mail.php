<?php

function send_mail($header,$msg){
/*	send_mail_actual($header,$msg);
	$to = $header['to'];
	$from = $header['from'];
	$header['to'] = $from;
	$header['from'] = $to;
	*/
	return send_mail_actual($header,$msg);
}

function send_mail_actual($header,$msg)
{

	$auth = array("host"=>"email-smtp.us-east-1.amazonaws.com", "user"=>"AKIAJW3K6VXEBPPXJN7A", "pass"=>"Ah26S2+qVsEExenetS0DsXB4da00hz/CDOO2H3F3DZG9", "port"=>"587", "protocol"=>"tsl");

	$host = $auth['host'];
	$user = $auth['user'];
	$pass = $auth['pass'];
	$port = $auth['port'];
	$protocol = $auth['protocol'];
	require_once '../users/mail/mail/PHPMailerAutoload.php';
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = $host;
	$mail->SMTPAuth = true;
	$mail->Username = $user;
	$mail->Password = $pass;
	$mail->SMTPSecure = $protocol;
	$mail->Port = $port;
	
	$mail->setFrom($header['from']);
	$mail->addAddress($header['to']);
	//$mail->addAddress('another_email_id@example.com');
	//$mail->addReplyTo('reply_to@example.com', 'Information');
	if(isset($header['cc']) && strlen($header['cc'])>=5)
	{
		$mail->addCC($header['cc']);
	}
	if(isset($header['bcc']) && strlen($header['bcc'])>=5)
	{
		$mail->addBCC($header['bcc']);
	}
	//$mail->addBCC("hruparel@everythingneon.com");
	$mail->Subject = $header['subject'];
	$mail->Body    = $msg;
	$mail->IsHTML(true);
	$GLOBALS['debug']=2;
	$mail->SMTPDebug  = 1; // enables SMTP debug information (for testing)
			               // 1 = errors and messages
			               // 2 = messages only
	$mail->Debugoutput = function($str, $level){
		$GLOBALS['debug'].="$level: $str\n";
	};

	if(!$mail->send())
	{
		// echo 'Mailer Error: ' . $mail->ErrorInfo;
		return 0;
		//echo 'Message could not be sent.';
		return $GLOBALS['debug'];
	}
	else
	{
		// echo 'Message has been sent';
		return 1;
		return $GLOBALS['debug'];
		
	}
	
}