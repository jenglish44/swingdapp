<?php
$from='';
$to='bisritesh@gmail.com';
$subject='Swingd Membership Purchase';
$message=file_get_contents('templates/sales_receipt.php');
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: Ritesh Biswas <'.$to.'>' . "\r\n";
$headers .= 'From: Swingd App <admin@swingd.com>' . "\r\n";
mail($to,$subject,$message,$headers);

?>