<?php
include_once("connect.php");
$edate=date('Y-m-d',time()+(30*24*60*60));
/*$sql="select utg.user_id, u.user_email, u.user_name, utg.endDate from users u, users_to_group utg where u.id=utg.user_id AND DATE( utg.endDate ) = ( NOW( ) + INTERVAL 1
MONTH )";*/
$sql="select utg.user_id, u.user_email, u.user_name, utg.endDate from users u, users_to_group utg where u.id=utg.user_id AND DATE( utg.endDate ) ='".$edate."'";
//echo $edate;
//exit();
$q=mysql_query($sql);
while($r=mysql_fetch_array($q))
{
	//print_r($r);
	$to=$r['user_email'];
	$subject='Swing Data - Update Membership';
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: '.$r['full_name'].' <'.$r['user_email'].'>' . "\r\n";
$headers .= 'From: Swingd App <admin@swingd.com>' . "\r\n";
//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

mail($to,$subject,'<html><head></head><body><b>Please update your swingd membership. Your current membership will expire on '.date('d M, Y',strtotime($r['endDate'])).'</b></body></html>',$headers);
}
?>