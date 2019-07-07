<?php
include_once("connect.php");

$fc=$_REQUEST['fc'];
$arr=array();
switch($fc)
{
	case 'forgotpass':
		$sql="select id,user_name from users where user_email='".$_REQUEST['u']."'";
		$q=mysql_query($sql);
		$r=mysql_fetch_array($q);
		if($r['id']>0)
		{
			$vcode=mt_rand(1000,9999);
			$allow_time=24;//hours
			$vcode_expires=time()+($allow_time*60*60*1000);
			$sql="update users set validation_user_code='".$vcode."', vcode_expireat='".$vcode_expires."' where user_email='".$_REQUEST['u']."'";
			if($q=mysql_query($sql))
			{
				$arr['success']=1;
				$arr['msg']="Code generated successfully.";
			}
			//email
			$to=$_REQUEST['u'];
			$subject='Swing Data - Forgot password';

// message
$message = "
<html>
<head>
  <title>Swingd Mobile app - Unique code</title>
</head>
<body>
	<p>Hello ".$r['user_name']."!</p>
  <p>Someone has requested to change your SwingD password, and you can do this using the unique code below.</p>
  <p><b>".$vcode."</b> is your unique code.  It will remain valid for one day. </p>
  <p>If you didn't request this, please ignore this email.</p>
  <p>Your password won't change until you access the app and create a new one.</p>
  <br/><br />
  Copyright &copy; SwingD
</body>
</html>
";

// To send HTML mail, the Content-type header must be set
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-2\r\nContent-Transfer-Encoding: 8bit\r\nX-Priority: 1\r\nX-MSMail-Priority: High\r\n";
	//$from_header .= "From: ".$_REQUEST['email']."\r\n" . "Reply-To: ".$_REQUEST['email']."\r\n" . "X-Mailer: PHP/" . phpversion() . "\r\n";			
	$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";			
	$headers .= 'From: Swing Data Mobile App' . "\r\n";

// Mail it
			mail($to, $subject, $message, $headers);
			//mail($_REQUEST['u'], 'Swing Data - Forgot password', 'Here are the unique coe.This code is vaild upto 24 hours from now.Code: '.$vcode);
		}
		else
		{
			$arr['success']=0;
			$arr['msg']="Error! Email not found.";
		}
		break;
		
		case 'code':
			$sql="select id, vcode_expireat, user_status from users where user_email='".$_REQUEST['u']."' and validation_user_code='".$_REQUEST['c']."'";
			//echo $sql;
			$q=mysql_query($sql);
			$r=mysql_fetch_array($q);
			$now=time();
			if($r['id']=="")
			{
				$arr['success']=0;
				$arr['msg']="Invalid unique code or email.";
			}
			elseif($r['user_status']!='active')
			{
				$arr['success']=0;
				$arr['msg']="This account is not active anymore. Please contact administrator.";
			}
			elseif($now>$r['vcode_expireat'])
			{
				$arr['success']=0;
				$arr['msg']="This code is not active anymore.";
			}
			else
			{
				$arr['success']=1;
				$sql="update users set validation_user_code='', vcode_expireat='0' where id='".$r['id']."'";
				mysql_query($sql);
			}
		break;
		case 'reset':
			$sql="update users set password='".md5($_REQUEST['p'])."' where user_email='".$_REQUEST['u']."' ";
			if($q=mysql_query($sql))
			{
				$arr['success']=1;
			}
			else
			{
				$arr['success']=0;
				$arr['msg']="Error ! Please try again later.";
			}
		break;
		case 'userreset':
			$sql="select id, user_status from users where user_email='".$_REQUEST['u']."' and password='".md5($_REQUEST['op'])."'";
			//echo $sql;
			$q=mysql_query($sql);
			$r=mysql_fetch_array($q);
			if($r['id']=="")
			{
				$arr['success']=0;
				$arr['msg']="Wrong password.";
			}
			elseif($r['user_status']!='active')
			{
				$arr['success']=0;
				$arr['msg']="This account is not active anymore. Please contact administrator.";
			}
			else
			{
				$sql="update users set password='".md5($_REQUEST['p'])."' where user_email='".$_REQUEST['u']."' ";
				if($q=mysql_query($sql))
				{
					$arr['success']=1;
				}
				else
				{
					$arr['success']=0;
					$arr['msg']="Error ! Please try again later.";
				}
			}
		break;
}
	
echo json_encode($arr);
/*$vcode=3532;
$_REQUEST['u']='bisritesh@gmail.com';
$to=$_REQUEST['u'];
$subject='Swing Data - Forgot password';
$message = '
<html>
<head>
  <title>Unique code</title>
</head>
<body>
  <p>Here are the unique coe.This code is vaild upto 24 hours from now.</p>
  <p>Code: <b>'.$vcode.'</b></p>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: Ritesh <'.$_REQUEST['u'].'>' . "\r\n";
$headers .= 'From: Swing Data Mobile  App <'.$_REQUEST['u'].'>' . "\r\n";
//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
	$from_header = "MIME-Version: 1.0\r\n";
	$from_header .= "Content-type: text/html; charset=iso-8859-2\r\nContent-Transfer-Encoding: 8bit\r\nX-Priority: 1\r\nX-MSMail-Priority: High\r\n";
	//$from_header .= "From: ".$_REQUEST['email']."\r\n" . "Reply-To: ".$_REQUEST['email']."\r\n" . "X-Mailer: PHP/" . phpversion() . "\r\n";			
	$from_header .= "X-Mailer: PHP/" . phpversion() . "\r\n";			

// Mail it
			$r=mail($to, $subject, $message,$from_header);
			//mail($_REQUEST['u'], 'Swing Data - Forgot password', 'Here are the unique coe.This code is vaild upto 24 hours from now.Code: '.$vcode);*/
?>