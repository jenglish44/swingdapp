<?php
include_once("connect.php");
$payment_gateway=$_REQUEST['p'];
$user_id=$_REQUEST['u'];
$membership=$_REQUEST['m'];
$mq=mysql_query("select id,amount,name from `users_group` where code='".$membership."'");
$mrow=mysql_fetch_array($mq);
$amount=$mrow['amount'];
include_once('payment/'.$payment_gateway.".php");

if($arr['success']==1)
{
	//$u['id']=$r['id'];
	$u['success']=1;
	$u['msg']='upgradation successful';
	//$u['id']=$r['id'];
	//$u['user_email']=$r['user_email'];
	//$u['user_name']=$r['user_name'];
	$u['user_group']=$mrow['id'];
	$ex_date=date(((int)date('Y')+1).'-m-d H:i:s');
	$u['expire_date']=date('jS M, Y',strtotime($ex_date));
	$cdate=date('Y-m-d H:i:s');
	$sql="update users_to_group set endDate='".$cdate."' where user_id='".$user_id."'";
	mysql_query($sql);
	$sql="insert into users_to_group set user_id='".$user_id."', user_group_id='".$mrow['id']."', payment_method='".$payment_gateway."', startDate='".$cdate."', endDate='".$ex_date."'";
	mysql_query($sql);
	$u['user_group']=$mrow['name'];
	//$u['expire_date']=date('dS M, Y',(time()+(365*24*60*60*1000)));
}
else
{
	$u['success']=0;
	$u['msg']='Transaction failed.'.$arr['msg'];
}
echo json_encode($u);
?>