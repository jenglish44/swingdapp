<?php
include_once("connect.php");

$today=date('Y-m-d H:i:s');
$ctime=time();
/*$sql="select ug.code from users_group ug, users_to_group utg, users u where u.id='".$_REQUEST['u']."' and u.id=utg.id and utg.user_group_id=ug.id and utg.startDate<='".$today."' and ( utg.endDate='0000-00-00 00:00:00' or utg.endDate>='".$today."' ) order by utg.id desc";
echo $sql;
$q=mysql_query($sql);
$row=mysql_fetch_array($q);*/
$sql="select ug.id,ug.user_group_id,ug.startDate, ug.endDate, g.code as user_group from users_group g, users_to_group ug where ug.user_id='".$_REQUEST['u']."' and ug.user_group_id=g.id order by ug.id desc";
$gq=mysql_query($sql);
$gr=mysql_fetch_array($gq);
if($gr['user_group_id']>0)
{
	if($ctime>=strtotime($gr['startDate']) && $ctime<=strtotime($gr['endDate']))
	{	
		//$u['user_group']=$gr['user_group'];
	}
	else
	{
		$sql="select id from users_group where code='rookie'";
		$rq=mysql_query($sql);
		$rrow=mysql_fetch_array($rq);
		$ex_date=date(((int)date('Y')+1).'-m-d H:i:s');
		$sql="insert into users_to_group set user_id='".$_REQUEST['u']."', user_group_id='".$rrow['id']."', startDate='".$today."', endDate='".$ex_date."'";
		mysql_query($sql);
		$gr['user_group']='rookie';
	}
}
$t=array();
$i=0;
if($gr['user_group']=='admin')
$sql="select * from team where endDate='0000-00-00 00:00:00' order by title asc";
else
$sql="select * from team where endDate='0000-00-00 00:00:00' and added_by='".$_REQUEST['u']."' order by title asc";

$q=mysql_query($sql);
while($r=mysql_fetch_array($q))
{
	$t[$i]['id']=$r['id'];
	$t[$i]['title']=$r['title'];
	$i++;
}
echo json_encode($t);
?>