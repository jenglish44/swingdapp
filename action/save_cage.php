<?php
include_once("connect.php");
$h=stripslashes($_REQUEST['h']);
$hitter=json_decode($h,true);
//echo json_decode($_REQUEST['h'],true);
foreach($hitter as $item)
{
	//print_r($hitter);
	$sql="insert into cage_bat set ";
	$sql.="player_id='".$item['id']."', ";
	$sql.="game_note='".$item['game_note']."', ";
	$sql.="pitch_type='".$item['ptype']."', ";
	/*$sql.="pitch1='".$item[pitch][1]."', ";
	$sql.="pitch2='".$item[pitch][2]."', ";
	$sql.="pitch3='".$item[pitch][3]."', ";
	$sql.="pitch4='".$item[pitch][4]."', ";
	$sql.="pitch5='".$item[pitch][5]."', ";
	$sql.="pitch6='".$item[pitch][6]."', ";
	$sql.="pitch7='".$item[pitch][7]."', ";
	$sql.="pitch8='".$item[pitch][8]."', ";
	$sql.="pitch9='".$item[pitch][9]."', ";
	$sql.="pitch10='".$item[pitch][10]."', ";
	$sql.="pitch11='".$item[pitch][11]."', ";
	$sql.="pitch12='".$item[pitch][12]."', ";
	$sql.="pitch13='".$item[pitch][13]."', ";
	$sql.="pitch14='".$item[pitch][14]."', ";
	$sql.="pitch15='".$item[pitch][15]."', ";*/
	$sql.="bat_date='".$item['edate']."', ";
	$sql.="add_date='".date('Y-m-d')."'";
	//print $sql;
	mysql_query($sql) or die(mysql_error());
	$gid=mysql_insert_id();
	for($i=1;$i<=count($item['pitch']);$i++)
	{
		$sql="insert into pitch_result set ";
		$sql.="game_id='".$gid."', ";
		$sql.="pitch_no='".$i."', ";
		$sql.="result='".$item['pitch'][$i]."'";
		mysql_query($sql) or die(mysql_error());
	}
}

$result = array();
$result['success']=1;
echo json_encode($result);
?>