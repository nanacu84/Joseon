<?php
function dice($rolls) {
	$dice = explode('d', $rolls);
	$roll = rand(1*$dice[0], $dice[1]*$dice[0]);
	return $roll;
}

$now = date('Y-m-d H:i:s', strtotime("+30 minutes")); 
$d20 = dice('1d20');

if($_GET['dam']) {
	if ($d20 > 1 ) {
		$damroll = dice($_GET['dam']);
		$versa = dice($_GET['vdam']);
		}
	if ($d20 == 20) {
		$damroll = $damroll + dice($_GET['dam']);
		$versa = $versa + dice($_GET['vdam']);
		}
	} 

//echo "공격굴림 $d20 . 피해는 $damroll 점입니다.";

$db = new SQLite3('db.sqlite');
$db -> query("INSERT INTO rhist (`d20`, `time`, `char`, `weapon`, `subject`, `versa`) VALUES ('$d20', '$now', '$_GET[charname]', '$damroll', '$_GET[subject]', '$versa' )") or print "우리에겐 뭔가 문제가 있다: ".$db->lastErrorMsg();
$db -> close();
header('location:index.php?pc='.$_GET['charname']);
?>