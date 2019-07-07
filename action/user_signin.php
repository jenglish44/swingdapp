<?php
include_once("connect.php");

$u=array();
	/*$u['success']=1;
	$u['msg']='success';*/
$cdate=date('Y-m-d H:i:s');
$ctime=time();
//$sql="select u.id,u.user_email,u.user_name,ug.user_group_id, g.name as user_group from users u, users_group g, users_to_group ug where u.user_email='".$_REQUEST['u']."' and u.password='".md5($_REQUEST['p'])."' and u.id=ug.user_id and ug.user_group_id=g.id and ug.startDate<='".$cdate."'";
$sql="select u.id,u.user_email,u.user_name from users u where u.user_email='".$_REQUEST['u']."' and u.password='".md5($_REQUEST['p'])."' ";
//echo $sql;
$q=mysql_query($sql);
$r=mysql_fetch_array($q);
if($r['id']>0)
{
	$sql="select ug.id,ug.user_group_id,ug.startDate, ug.endDate, g.name as user_group from users_group g, users_to_group ug where ug.user_id='".$r['id']."' and ug.user_group_id=g.id order by ug.id desc";
	$gq=mysql_query($sql);
	$gr=mysql_fetch_array($gq);
	//$u['id']=$r['id'];
	if($gr['user_group_id']>0)
	{
		$u['success']=1;
		$u['msg']='success';
		$u['id']=$r['id'];
		$u['user_email']=$r['user_email'];
		$u['user_name']=$r['user_name'];
		if($ctime>=strtotime($gr['startDate']) && $ctime<=strtotime($gr['endDate']))
			$u['user_group']=$gr['user_group'];
		else
		{
			$sql="select id from users_group where code='rookie'";
			$rq=mysql_query($sql);
			$rrow=mysql_fetch_array($rq);
			$ex_date=date(((int)date('Y')+1).'-m-d H:i:s');
			$sql="insert into users_to_group set user_id='".$r['id']."', user_group_id='".$rrow['id']."', startDate='".$cdate."', endDate='".$ex_date."'";
			mysql_query($sql);
			$u['user_group']='Rookie';
		}
	}
	else
	{
		$u['success']=0;
		$u['msg']='Invalid account status!';
	}
}
else
{
	$u['success']=0;
	$u['msg']='Wrong Email or Password!';
}
echo json_encode($u);
?>