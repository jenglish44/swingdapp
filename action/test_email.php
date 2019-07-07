<?php
	include_once("connect.php");
	/*$order_no=substr(md5(date('Ym')),0,4).'-'.rand(1000,9999);
	$sql="insert into orders set "
		." order_no='".$order_no."' ,"
		." po_no='' ,"
		." user_id='".$user_id."' ,"
		." discount='0' ,"
		." order_total='".$amount."' ,"
		." payment_method='".$payment_gateway."' ,"
		." order_status='completed' ,"
		." order_date='".$cdate."'";
	//echo $sql.'---';
	mysql_query($sql);
	$order_id=mysql_insert_id();
	$sql="insert into order_detail set "
		." order_id='".$order_id."' ,"
		." product_id='".$mrow['id']."' ,"
		." product_title='".$mrow['name']." membership for 1 year' ,"
		." qty='1' ,"
		." amt='".$mrow['amount']."'";
	//echo $sql;
	mysql_query($sql);*/



$from='';
$to='bisritesh@gmail.com';
$subject='Swingd Membership Purchase';
$message=file_get_contents('../app/templates/sales_receipt.php');
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

$order_id=1;
// Additional headers
$headers .= 'To: Ritesh Biswas <'.$to.'>' . "\r\n";
$headers .= 'From: Swingd App <admin@swingd.com>' . "\r\n";

$sql="select o.*,u.id as uid,u.user_email,u.user_name, up.* from orders o left join users u on u.id=o.user_id left join users_profile up on up.user_id=o.user_id where o.id='".$order_id."'";
echo $sql;
$oq=mysql_query($sql);
$order=mysql_fetch_array($oq);
$sql="select order_date from orders where user_id='".$order['uid']."' order by order_date desc";
$loq=mysql_query($sql);
$lo_date=mysql_fetch_array($loq);
$sql="select * from order_detail where order_id='".$order_id."'";
$odq=mysql_query($sql);
$odr=mysql_fetch_array($odq);

$email_params=array('%po_number%','%receipt_date%','%order_no%','%order_date%','%last_pdate%','%user_email%','%user_company%','%user_name%','%user_fname%','%user_lname%','%user_addr1%','%user_addr2%','%user_city%','%user_zip%','%user_country%','%user_state%','%user_product%','%product_title%','%product_price%','%product_duration%','%user_amount%','%user_price%','%user_subtotal%','%user_total%');
$email_values=array('po_number'=>'',
					'receipt_date'=>date('m/d/Y'),
					'order_no'=>$order['order_no'],
					'order_date'=>(($order['order_date']!='' || $order['order_date']!='0000-00-00 00:00:00')?date('m/d/Y',strtotime($order['order_date'])):''),
					'last_pdate'=>(($lo_date['order_date']!='' || $lo_date['order_date']!='0000-00-00 00:00:00')?date('m/d/Y',strtotime($lo_date['order_date'])):''),
					'user_email'=>$order['user_email'],
					'user_company'=>$order['company_name'],
					'user_name'=>$order['user_name'],
					'user_fname'=>'',
					'user_lname'=>'',
					'user_addr1'=>$order['address1'],
					'user_addr2'=>$order['address2'],
					'user_city'=>$order['city'],
					'user_zip'=>$order['zip'],
					'user_country'=>$order['country'],
					'user_state'=>$order['state'],
					'user_product'=>$odr['product_id'],
					'product_title'=>$odr['product_title'],
					'product_price'=>$odr['amt'],
					'product_duration'=>'',
					'user_amount'=>$odr['amt'],
					'user_subtotal'=>$order['order_total'],
					'user_total'=>$order['order_total']
					);
/*print '<pre>';
print_r($order);
print_r($email_values);
print '</pre>';*/
$message=str_replace($email_params,$email_values,$message);
mail($to,$subject,$message,$headers);

?>