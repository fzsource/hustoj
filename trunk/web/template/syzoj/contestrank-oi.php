<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" href="../../favicon.ico">

<title><?php echo $OJ_NAME?></title>  
<?php include("template/$OJ_TEMPLATE/css.php");?>	    


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="template/<?php echo $OJ_TEMPLATE?>/js/html5shiv.js"></script>
<script src="template/<?php echo $OJ_TEMPLATE?>/js/respond.min.js"></script>
<![endif]-->
</head>
<?php include(dirname(__FILE__)."/header.php");?>	

<div class="container">
<div class="jumbotron">
<?php
$rank=1;
?>
<center><h3>OI Mode RankList -- <?php echo $title?></h3>
<a href="contestrank.xls.php?cid=<?php echo $cid?>" >Download</a>
<?php
if($OJ_MEMCACHE){
	?>
		<a href="contestrank2.php?cid=<?php echo $cid?>" >Replay</a>

		<?php
}
?>
</center>
<div style="overflow: auto">
<table id=rank><thead><tr class=toprow align=center><td class="{sorter:'false'}" width=5%>Rank<th width=10%>User</th><th width=10%>Nick</th><th width=5%>Solved</th><th width=5%>Penalty</th><th align="center">Mark</th>
<?php
for ($i=0;$i<$pid_cnt;$i++)
echo "<td><a href=problem.php?cid=$cid&pid=$i>$PID[$i]</a></td>";
echo "</tr></thead>\n<tbody>";
for ($i=0;$i<$user_cnt;$i++){
	if ($i&1) echo "<tr class=oddrow align=center>\n";
	else echo "<tr class=evenrow align=center>\n";
	echo "<td>";
	$uuid=$U[$i]->user_id;
	$nick=$U[$i]->nick;
	if($nick[0]!="*")
		echo $rank++;
	else
		echo "*";
	$usolved=$U[$i]->solved;
	if(isset($_GET['user_id'])&&$uuid==$_GET['user_id']) echo "<td bgcolor=#ffff77>";
	else echo"<td>";
	echo "<a name=\"$uuid\" href=userinfo.php?user=$uuid>$uuid</a>";
	echo "<td><a href=userinfo.php?user=$uuid>".htmlentities($U[$i]->nick,ENT_QUOTES,"UTF-8")."</a>";
	echo "<td><a href=status.php?user_id=$uuid&cid=$cid>$usolved</a>";
	echo "<td>".sec2str($U[$i]->time);
	echo "<td>".($U[$i]->total);
	for ($j=0;$j<$pid_cnt;$j++){
		$bg_color="eeeeee";
		if (isset($U[$i]->p_ac_sec[$j])&&$U[$i]->p_ac_sec[$j]>0){
			$aa=0x33+$U[$i]->p_wa_num[$j]*32;
			$aa=$aa>0xaa?0xaa:$aa;
			$aa=dechex($aa);
			$bg_color="$aa"."ff"."$aa";
			//$bg_color="aaffaa";
			if($uuid==$first_blood[$j]){
				$bg_color="aaaaff";
			}
		}else if(isset($U[$i]->p_wa_num[$j])&&$U[$i]->p_wa_num[$j]>0) {
			$aa=0xaa-$U[$i]->p_wa_num[$j]*10;
			$aa=$aa>16?$aa:16;
			$aa=dechex($aa);
			$bg_color="ff$aa$aa";
		}
		echo "<td class=well style='background-color:#$bg_color'>";
		if(isset($U[$i])){
			if (isset($U[$i]->p_ac_sec[$j])&&$U[$i]->p_ac_sec[$j]>0)
				echo 100;
				//echo sec2str($U[$i]->p_ac_sec[$j]);
			else if (isset($U[$i]->p_wa_num[$j])&&$U[$i]->p_wa_num[$j]>0)
				echo "(+"+$U[$i]->p_pass_rate[$j]*100+")";
		}
	}
	echo "</tr>\n";
}
echo "</tbody></table>";
?>
</div>
</div>

</div> <!-- /container -->
<?php include(dirname(__FILE__)."/footer.php");?>	
</html>
