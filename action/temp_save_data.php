<?php
include_once("connect.php");
$h=stripslashes($_REQUEST['h']);
$hitter=json_decode($h,true);
$g=stripslashes($_REQUEST['g']);
$game=json_decode($g,true);
//echo json_decode($_REQUEST['h'],true);
if(count($hitter)>0)
{
	foreach($hitter as $item)
	{
		//print_r($hitter);
		$sql="insert into batting_practice set ";
		$sql.="player_id='".$item['pid']."', ";
		$sql.="team_id='".$item['tid']."', ";
		$sql.="game_note='".$item['game_note']."', ";
		$sql.="pitch_distance='".$item['pdistance']."', ";
		$sql.="vflex='".$item['vflex']."', ";
		$sql.="session_key='".$item['skey']."', ";
		$sql.="bat_date='".$item['edate']."', ";
		$sql.="add_date='".date('Y-m-d')."', ";
		$sql.="added_by='".$_REQUEST['u']."'";
		//print $sql;
		mysql_query($sql) or die(mysql_error());
		$pid=mysql_insert_id();
		for($i=1;$i<=count($item['pitch']);$i++)
		{
			$sql="insert into practice_detail set ";
			$sql.="pid='".$pid."', ";
			$sql.="pitch_no='".$i."', ";
			$sql.="result='".$item['pitch'][$i]."'";
			//echo $sql;
			mysql_query($sql) or die(mysql_error());
		}
	}
}
if(count($game)>0)
{
	//print_r($game);
 	//$balls=array('BSM','BFB','BGBO','BFBO','BLDO','BHGB','BFBH','BLFB','BLDH','BSH','BWH','BB','BW','HBP','BBC');
	//$strikes=array('SSM','SFB','SGBO','SFBO','SLDO','SHGB','SFBH','SLFB','SLDH','SSH','SWH','CS','SOL','SBC');
	foreach($game as $item)
	{
		//team
		if($item['otherteam']!="")
		{
			$htq=mysql_query("select * from team where title='".addslashes($item['otherteam'])."' and added_by='".$_REQUEST['u']."' and endDate='0000-00-00 00:00:00'");
			$ht_row=mysql_fetch_array($htq);
			if($ht_row['id']>0)
			{
				$hteam=$ht_row['id'];
			}
			else
			{
				mysql_query("insert into team set title='".addslashes($item['otherteam'])."', added_by='".$_REQUEST['u']."', startDate='".date('Y-m-d H:i:s')."'");
				//echo "insert into team set title='".addslashes($item['team'])."'";
				$hteam=mysql_insert_id();
				//echo 'inserted hteam'.$hteam;
			}
		}
		else
			$hteam=$item['team'];
		if($item['othervteam']!="")
		{
			$vtq=mysql_query("select * from team where title='".addslashes($item['othervteam'])."' and added_by='".$_REQUEST['u']."' and endDate='0000-00-00 00:00:00'");
			$vt_row=mysql_fetch_array($vtq);
			if($vt_row['id']>0)
			{
				$vteam=$vt_row['id'];
			}
			else
			{
				mysql_query("insert into team set title='".addslashes($item['othervteam'])."', added_by='".$_REQUEST['u']."', startDate='".date('Y-m-d H:i:s')."'");
				//echo "insert into team set title='".addslashes($item['team'])."'";
				$vteam=mysql_insert_id();
				//echo 'inserted hteam'.$hteam;
			}
		}
		else
			$vteam=$item['vteam'];
		/*$htq=mysql_query("select * from team where title='".addslashes($item['team'])."'");
		//echo "select * from team where title='".addslashes($item['team'])."'";
		$ht_row=mysql_fetch_array($htq);
		if($ht_row['id']>0)
		{
			$hteam=$ht_row['id'];
			//echo 'got hteam - '.$hteam;
		}
		else
		{
			mysql_query("insert into team set title='".addslashes($item['team'])."'");
			//echo "insert into team set title='".addslashes($item['team'])."'";
			$hteam=mysql_insert_id();
			//echo 'inserted hteam'.$hteam;
		}
		$vtq=mysql_query("select * from team where title='".$item['vteam']."'");
		$vt_row=mysql_fetch_array($vtq);
		if($vt_row['id']>0)
		{
			$vteam=$vt_row['id'];
			//echo 'got vteam - '.$vteam;
			//echo 'inserted vteam'.$vteam;
		}
		else
		{
			mysql_query("insert into team set title='".addslashes($item['vteam'])."'");
			$vteam=mysql_insert_id();
		}*/

		$sql="insert into game set ";
		$sql.="hteam='".$hteam."', ";
		$sql.="vteam='".$vteam."', ";
		$sql.="ishteam='".$item['ishteam']."', ";
		$sql.="game_date='".$item['edate']."', ";
		$sql.="add_date='".date('Y-m-d')."', ";
		$sql.="added_by='".$_REQUEST['u']."'";
		mysql_query($sql) or die(mysql_error());
		$gid=mysql_insert_id();
		
		//stat
		foreach($item['stat'] as $srl => $r)
		{
			$t='';
			$sql="insert into game_detail set ";
			$sql.="game_id='".$gid."', ";
			if($r['t']==$item['vteam'])
				$t=$vteam;
			else
				$t=$hteam;
			$sql.="team_id='".$t."', ";
			$sql.="inning='".$r['i']."', ";
			$sql.="batter='".$r['b']."', ";
			$sql.="ball='".$r['bl']."', ";
			$sql.="strike='".$r['s']."', ";
			$sql.="outs='".$r['o']."', ";
			$sql.="result='".$r['r1']."', ";
			$sql.="outcome='".$r['r']."'";
			
			//echo $sql;
			mysql_query($sql);
		}
		/*//inning
		$inn_batter=array();
		foreach($item['inning'] as $inn => $b)
		{
			$batters=explode(',',$b);
			foreach($batters as $bt)
				$inn_batter[$bt]=$inn;
		}
		//
		foreach($item['batter'] as $bid =>$b)
		{
			$arr=explode(',',$b);
			$gc_ball=$gc_strike=0;
			foreach($arr as $pr)
			{
				if(in_array($pr,$balls))
					$gc_ball++;
				if(in_array($pr,$strikes))
					$gc_strike++;
			$sql="insert into game_detail set ";
			$sql.="batter='".$bid."', ";
			$sql.="inning='".$inn_batter[$bid]."', ";
			$sql.="outcome='".$pr."', ";
			$sql.="game_count='".$gc_ball.'-'.$gc_strike."', ";
			$sql.="count_group='', ";
			$sql.="game_id='".$gid."'";
			mysql_query($sql) or die(mysql_error());
			}
		}*/
	}
}

$result = array();
$result['success']=1;
echo json_encode($result);
?>