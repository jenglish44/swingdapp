<?php
include_once("connect.php");

$u=array();
	/*$u['success']=1;
	$u['msg']='success';*/
$cdate=date('Y-m-d H:i:s');
$sql="select u.id from users u where u.user_email='".$_REQUEST['u']."'";
//echo $sql;
$q=mysql_query($sql);
$r=mysql_fetch_array($q);
if($r['id']>0)
{
	$u['success']=0;
	$u['msg']='Email Already Exists!';
}
else
{
	$sql="insert into users set ";
	$sql.="user_email='".$_REQUEST['u']."', ";
	$sql.="user_name='".$_REQUEST['n']."', ";
	$sql.="password='".md5($_REQUEST['p'])."', ";
	$sql.="register_date='".$cdate."', ";
	$sql.="registration_timestamp='".time()."', ";
	$sql.="user_status='active'";
	mysql_query($sql);
	$uid=mysql_insert_id();
	
	//grouping
	$sql="select id,name from users_group where code='rookie'";
	$q=mysql_query($sql);
	$row=mysql_fetch_array($q);
	$ex_date=date(((int)date('Y')+1).'-m-d H:i:s');
	$sql="insert into users_to_group set user_id='".$uid."', user_group_id='".$row['id']."', startDate='".$cdate."', endDate='".$ex_date."'";
	mysql_query($sql);
	
	if($uid>0){
		$u['id']=$r['id'];
		$u['success']=1;
		$u['msg']='success';
		$u['id']=$uid;
		$u['user_email']=$_REQUEST['u'];
		$u['user_name']=$_REQUEST['n'];
		$u['user_group']=$row['name'];
	}
	else
	{
		$u['success']=0;
		$u['msg']='Account could not be created!';
	}
}
echo json_encode($u);
?>