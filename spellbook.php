<?php include("header.php"); ?>

<div class="row profile">
<img src="http://vignette2.wikia.nocookie.net/tokyoghoul/images/3/31/SaikoYonebayashi.png/revision/latest?cb=20141220155858" alt="" class="img-circle" width="116" height="116" />
<h2 class="serif">벨라도르란</h2>
<p>"내 책이에요. 건들지마요. 저리 꺼져요."</p>
</div>

<h1>벨라도르란의 주문서</h1>
<p>여기서 우리는 게으른 마법사 벨라도르란의 주문서를 잠깐 훔쳐볼 수 있다.</p>

<?php
for($i = 0; $i < 10; $i++){
echo '<div class="col-sm-4">
<ul class="list-group">
	<li class="list-group-item list-group-item-info"><b>'.$i.' 등급</b></li>';

$spells = $db -> query("SELECT name FROM spell WHERE lv = '$i' ORDER BY name") or print "우리에겐 뭔가 문제가 있다: ".$db->lastErrorMsg();
while($spell = $spells -> fetchArray(SQLITE3_ASSOC))	{
	print '<li class="list-group-item">'.strtoupper($spell[name]).'</li>';
}
echo '
</ul></div>';
}
?>

</div>

<?php
$db -> close();
include("footer.php");
?>
