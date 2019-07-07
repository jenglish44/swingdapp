<?php
include_once("connect.php");

$arr=array();
/*$i=0;
$sql="select * from player where tdate='0000-00-00 00:00:00' and added_by='".$_REQUEST['u']."' order by batting_order,lastname asc";
$q=mysql_query($sql);
while($r=mysql_fetch_array($q))
{
	$p[$i]['id']=$r['id'];
	$p[$i]['name']=$r['lastname'].' '.$r['middlename'].' '.$r['firstname'];
	$p[$i]['team_id']=$r['team_id'];
	$p[$i]['bo']=$r['batting_order'];
	$i++;
}*/
//for(var $i=0;$i<count($_REQUEST);$i++)
foreach($_REQUEST as $r=> $val)
{
	if(strpos($r,'bo_')!==false)
	{
		$pid=str_replace('bo_','',$r);
		//echo $pid.'--';
		$sql="update player set batting_order='".$val."' where id='".$pid."'";
		mysql_query($sql);
	}
	$arr['success']=1;
}
echo json_encode($arr);
?>