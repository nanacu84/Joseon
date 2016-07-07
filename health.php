<?php
$db = new SQLite3('db.sqlite');
if ($_GET['M'] == 'H') {
	$db -> query("UPDATE health SET `current` = '$_GET[hp]' WHERE `name` = '$_GET[pc]' ") or print "우리에겐 뭔가 문제가 있다: ".$db->lastErrorMsg();
	}
if ($_GET['M'] == 'E') {
	$db -> query("UPDATE health SET `equips` = '$_GET[equips]' WHERE `name` = '$_GET[pc]' ") or print "우리에겐 뭔가 문제가 있다: ".$db->lastErrorMsg();
}
if ($_GET['M'] == 'C') {
	$db -> query("UPDATE parties SET `commonwealth` = '$_GET[equips]' WHERE `members` LIKE '%$_GET[pc]%' ") or print "우리에겐 뭔가 문제가 있다: ".$db->lastErrorMsg();
}
$db -> close();
header('location:index.php?pc='.$_GET[pc]);
?>