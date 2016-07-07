<?php include("header.php"); ?>

<div class="row profile">
<img src="<?php echo $char['prf']; ?>" alt="" class="img-circle" width="116" height="116" />
<h2 class="serif"><?php echo $char['name']; ?></h2>
<p class="sans-serif"><?php echo $char['hd']; ?>단계 <?php echo ($char['fct'] ? $char['fct'].'의 ': ''); echo $class[$char['class']].'('.$char['bkg'].')'; ?></p>
	<?php echo $race[$char['race']].', '.$char['al'].' : '.$char['exp'].'/'.$leveling[$char['hd']+1]; ?> <br />
	<p>"<?php echo $char['motto']; ?>"</p>
</div>

<?php
$health = $db -> query("SELECT * FROM health WHERE `name` = '$char[name]'") or print "문제: ".$db->lastErrorMsg();
$health = $health -> fetcharray(SQLITE3_ASSOC);
$health_percent = $health['current'] / $health['max'] * 100;
?>
<?php
if ($char['armor'] == true) {
	$wearing = explode(" ", $char['armor']);
	$shiled = ($wearing[1] == 13 ? 2 : 0);
	$armor = $wearing[0];

	if ($armor > 8) { $armor_dex_mod = 0; }
	else if ($armor > 3 ) { $armor_dex_mod = ( floor($stat[1]/2-5) > 2 ? 2: floor($stat[1]/2-5 )); }
	else { $armor_dex_mod = floor($stat[1]/2-5); }

	$armor = $db -> query("SELECT * FROM armor WHERE rowid = $armor") or print "문제: ".$db->lastErrorMsg();
	$armor = $armor -> fetcharray(SQLITE3_ASSOC);

} else {
	$armor['ac'] = 10;
}
$ac = $armor['ac'] + $shiled + $armor_dex_mod + $magicWeapon;
?>

<div class="row">
<div class="col-xs-4 col-sm-2">
		<form action="health.php" method="get">
		<div class="input-group" style="width: 100%;">
		<input type="hidden" name="pc" value="<?php echo $char['name']; ?>">
		<input type="hidden" name="M" value="H">
		<span class="glyphicon glyphicon-heart"></span> HP
 		<input type="number" step="1" min="0" max="<?php echo $health['max']; ?>" class="currhp center form-control" name="hp" value="<?php echo $health['current']; ?>">
	<p class="sans-serif sml center h2rows"> <?php echo $health['max'].' ('.'d'.$hd[$char['class']].')'; ?> </p>
   	</div>
	</form>
</div>

<div class="col-xs-4 col-sm-2">
	<span class="glyphicon glyphicon-cd"></span> AC
	<p class="bigstat center"><?php echo $ac; ?> </p>
	<p class="sans-serif sml center h2rows"><?php echo ( $char['armor'] == true ? $armor['armor'] : '');echo ($shiled > 0 ? ", 방패": ""); ?> </p>
</div>
<div class="col-xs-4 col-sm-2">
	<span class="glyphicon glyphicon-blackboard"></span> 숙련
	<p class="bigstat center"><?php echo $prof; ?></p>
	<p class="sans-serif sml center h2rows"><?php echo $char['hd']; ?>단계</p>
</div>
<div class="col-xs-4 col-sm-2">
	<span class="glyphicon glyphicon-eye-open"></span> 감각
	<p class="bigstat center"><?php echo $stat_mod[4]; ?></p>
	<p class="sans-serif sml center h2rows">WIS</p>
</div>
<div class="col-xs-4 col-sm-2">
	<span class="glyphicon glyphicon-tasks"></span> 우선권
	<p class="bigstat center"><?php echo $stat_mod[1]; ?></p>
	<p class="sans-serif sml center h2rows">DEX</p>
</div>
<div class="col-xs-4 col-sm-2">
	<span class="glyphicon glyphicon-send"></span> 이동력
	<p class="bigstat center"><?php echo $base_speed[$char['race']]; ?></p>
	<p class="sans-serif sml center h2rows">ft.</p>
</div>
</div>

<!-- 능력치 -->
<?php
echo '<div class="col-xs-6 col-sm-4 abil"><table class="table table-striped"><tr><th></th><th>능력</th><th>점수</th><th>수정치</th></tr>';
for ( $i = 0 ; $i < count($stat) ; $i++) {
	echo '<tr><td>';
		if (in_array($i, $prof_abilities[$char['class']])) { echo '<span class="glyphicon glyphicon-asterisk"></span>'; }
	echo '</td>';
	echo '<td><a href="dice.php?charname='.$char['name'].'&subject='.$ability_name[$i].'">'.$ability_name[$i] . '</a></td><td> ' . $stat[$i] . '</td><td>' . $stat_mod[$i] .'</td></tr>';
	}
echo '</table>';
?>
<!-- 공격 -->
  <ul class="list-group"><li class="list-group-item list-group-item-info">근거리 무기</li>
<?php
	$equip_hands = explode(" ", $char['weapons']);
	$melee_weapon = array(1,2,3,4,5,6,7,8,9,10,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,38);
	$ranged_weapon = array(11,12,13,14,33,34,35,36,37);

	$melee = array_diff($equip_hands, $ranged_weapon);
	$melee = array_values($melee);
	$ranged = array_diff($equip_hands, $melee_weapon);
	$ranged = array_values($ranged);

	for ($i = 0 ; $i < count($melee) ; $i++ ) {
		$weapon = $db -> query("SELECT * FROM weapon WHERE rowid = $melee[$i]") or print "문제: ".$db->lastErrorMsg();
		$weapon = $weapon -> fetcharray (SQLITE3_ASSOC);
		$finesse = strpos ($weapon['prop'], 'Finesse');
		$versatile = strpos ($weapon['prop'], 'Versatile');
			if($versatile === true ) {} else {	preg_match('/[1-2]d[0-9]+/', $weapon['prop'], $v_roll);	}
?>
	  <a href="dice.php?charname=<?php echo $char['name']; ?>&subject=<?php echo $weapon['name']; ?>&dam=<?php echo $weapon['dmg']; ?><?php echo ($versatile === true ? : "&vdam=$v_roll[0]") ?>"><li class="list-group-item">
			<?php echo $weapon['name']; ?>.</strong>
			<?php echo '+ '; if ($finesse === false ) { echo $prof + $stat_mod[0]; } else { echo $prof + max ( $stat_mod[0], $stat_mod[1] ) ; }	?> to hit,
			<?php echo $weapon['dmg']; ?> + <?php if ($finesse === false ) { echo $stat_mod[0]; } else { echo max ( $stat_mod[0], $stat_mod[1] ) ; } echo ' '.$weapon['type'];	?> 피해 /
			<?php echo $weapon['prop']; ?>
		</li></a>
	<?php	} ?>
  </ul>

  <ul class="list-group"><li class="list-group-item list-group-item-info">원거리 무기</li>
<?php
	for ($i = 0 ; $i < count($ranged) ; $i++ ) {
		$weapon = $db -> query("SELECT * FROM weapon WHERE rowid = $ranged[$i]") or print "문제: ".$db->lastErrorMsg();
		$weapon = $weapon -> fetcharray (SQLITE3_ASSOC);
?>
	  <a href="dice.php?charname=<?php echo $char['name']; ?>&subject=<?php echo $weapon['name']; ?>&dam=<?php echo $weapon['dmg']; ?>"><li class="list-group-item">
			<?php echo $weapon['name']; ?>.</strong>
			<?php echo '+ '.($prof + $stat_mod[1]); ?> to hit,
			<?php echo $weapon['dmg']; ?> + <?php echo $stat_mod[1]; ?> 피해 /
			<?php echo $weapon['prop']; ?>
		</li></a>
	<?php	} ?>
  </ul>
<!-- 주문 -->
<?php
$spell = $db -> query("SELECT * FROM prepare WHERE `name` = '$char[name]'") or print "문제: ".$db -> lastErrorMsg();
$spell = $spell -> fetchArray (SQLITE3_ASSOC);

if ($spell) {
?>
  <ul class="list-group"><li class="list-group-item list-group-item-info">주문<span class="badge"><?php echo $spell[qt]; ?></span></li>
<?php
$prepared = explode(",", $spell['list']);
	for ($i = 0 ; $i < count($prepared); $i++ ) {
		$prepared[$i] = trim($prepared[$i]);
		$spelldesc = $db -> query ("SELECT * FROM spell WHERE `name` = '$prepared[$i]' COLLATE NOCASE") or print "문제: ".$db -> lastErrorMsg();
		$spelldesc = $spelldesc -> fetchArray(SQLITE3_ASSOC);
		/*
		$spelldesc['range']
		$spelldesc['compo']
		$spelldesc['dura']
		*/
		echo '<li class="list-group-item" data-container="body" data-toggle="popover" data-placement="top" title="'.$spelldesc['name'].'" data-content="'.$spelldesc['desc'].'<br />'.$spelldesc['higher'].'">'.strtoupper($prepared[$i]).' <small>'.$spelldesc['lv'].' 등급 '.$spelldesc['sch'].'/'.$spelldesc['ctime'].'</small></li>';
	}
?>

  	<li class="list-group-item needrub">
<table class="table table-striped">
	<tr>
		<th>1 등급</th>
		<th>2 등급</th>
		<th>3 등급</th>
		<th>4 등급</th>
		<th>5 등급</th>
		<th>6 등급</th>
		<th>7 등급</th>
		<th>8 등급</th>
		<th>9 등급</th>
	</tr>
	<tr>
		<td><?php echo $spell['1st']; ?></td>
		<td><?php echo $spell['2nd']; ?></td>
		<td><?php echo $spell['3rd']; ?></td>
		<td><?php echo $spell['4th']; ?></td>
		<td><?php echo $spell['5th']; ?></td>
		<td><?php echo $spell['6th']; ?></td>
		<td><?php echo $spell['7th']; ?></td>
		<td><?php echo $spell['8th']; ?></td>
		<td><?php echo $spell['9th']; ?></td>
	</tr>
</table>
</li>

<?php
$cantrips = explode(",", $spell['cantrip']);
	for ($i = 0 ; $i < count($cantrips); $i++ ) {
		$cantrips[$i] = trim($cantrips[$i]);
		$spelldesc = $db -> query ("SELECT * FROM spell WHERE `name` = '$cantrips[$i]' COLLATE NOCASE") or print "문제: ".$db -> lastErrorMsg();
		$spelldesc = $spelldesc -> fetchArray(SQLITE3_ASSOC);
		echo '<li class="list-group-item" data-container="body" data-toggle="popover" data-placement="top" title="'.$spelldesc['name'].'" data-content="'.$spelldesc['desc'].'<br />'.$spelldesc['higher'].'">'.strtoupper($cantrips[$i]).' <small>'.$spelldesc['lv'].' 등급 '.$spelldesc['sch'].'/'.$spelldesc['ctime'].'</small></li>';
	}
}
?>
  </ul>
<!-- 주사위 굴림 -->
<ul class="list-group">
<?php
$rhist = $db -> query("SELECT * FROM rhist ORDER by rowid DESC LIMIT 10") or print "우리에겐 뭔가 문제가 있다: ".$db->lastErrorMsg();
while($recent_roll = $rhist -> fetchArray()){
	echo '<li class="list-group-item">'.$recent_roll['char'].' + '.$recent_roll['subject'].': <strong>'.$recent_roll['d20'].'</strong>, '.$recent_roll['weapon'];
	echo ($recent_roll['versa'] == true ? ' (양손: '.$recent_roll['versa'].')' :  '');
	echo ' <span style="color: rgba(0,0,0,0.2);">'.$recent_roll['time'].'</span></li>';
} ?>
</ul>
</div>
<!-- 기술 -->
<?php
$skills = array('체술','곡예','손장난','잠행','비전','역사','조사','박물','종교','동물다루기','통찰','의료','감각','생존','기만','협박','공연','설득');
$prof_skills = explode(" ", $char['skills']);
/*
근력 0
민첩 1 2 3
건강
지능 4 5 6 7 8
지혜 9 10 11 12 13
매력 14 15 16 17
*/
	echo '<div class="col-xs-6 col-sm-4 skill"><table class="table table-striped"><tr><th></th><th>기술</th><th></th></tr>';

for ( $i = 0; $i < count($skills) ; $i++ ) {
	switch ($i) {
		case 0:
			$ability_bonus = $stat_mod[0];
			break;
		case 1:
		case 2:
		case 3:
			$ability_bonus = $stat_mod[1];
			break;
		case 4:
		case 5:
		case 6:
		case 7:
		case 8:
			$ability_bonus = $stat_mod[3];
			break;
		case 9:
		case 10:
		case 11:
		case 12:
		case 13:
			$ability_bonus = $stat_mod[4];
			break;
		case 14:
		case 15:
		case 16:
		case 17:
			$ability_bonus = $stat_mod[5];
			break;
				}
?>

<?php
				echo '<tr><td>';
	if (in_array($i, $prof_skills)) { echo '<span class="glyphicon glyphicon-asterisk"></span>'; }
	echo '</td><td><a href="dice.php?charname='.$char['name'].'&subject='.$skills[$i].'">'.$skills[$i].'</a></td><td>';
	if (in_array($i, $prof_skills)) { echo $prof + $ability_bonus; } else { echo $ability_bonus; }
	echo '</td></tr>';
}
echo '</table>';
?>

<!-- 소지품 -->
<ul class="list-group equips"><li class="list-group-item list-group-item-info">소지품</li>
<li class="list-group-item">
<?php
preg_match_all('/[0-9]+(?=cp)/', $health['equips'], $cp);
preg_match_all('/[0-9]+(?=sp)/', $health['equips'], $sp);
preg_match_all('/[0-9]+(?=ep)/', $health['equips'], $ep);
preg_match_all('/[0-9]+(?=gp)/', $health['equips'], $gp);
preg_match_all('/[0-9]+(?=pp)/', $health['equips'], $pp);
$cp = array_sum($cp[0]);
$sp = array_sum($sp[0]);
$ep = array_sum($ep[0]);
$gp = array_sum($gp[0]);
$pp = array_sum($pp[0]);
?>
<div class="coinage"><span class="itl">cp</span><p class="sans-serif wt7"><?php echo $cp; ?><p></div>
<div class="coinage"><span class="itl">sp</span><p class="sans-serif wt7"><?php echo $sp; ?><p></div>
<div class="coinage"><span class="itl">ep</span><p class="sans-serif wt7"><?php echo $ep; ?><p></div>
<div class="coinage"><span class="itl">gp</span><p class="sans-serif wt7"><?php echo $gp; ?><p></div>
<div class="coinage"><span class="itl">pp</span><p class="sans-serif wt7"><?php echo $pp; ?><p></div>
<form action="health.php" method="get"><input type="hidden" name="M" value="E"><input type="hidden" name="pc" value="<?php echo $char['name']; ?>"><textarea name="equips" rows=8><?php echo $health['equips']; ?></textarea><button type="submit" class="btn btn-default">수정</button></form>
</li>
</ul>

<!-- 공용품 -->
<ul class="list-group equips"><li class="list-group-item list-group-item-info">공용품</li>
<li class="list-group-item">
<?php
$party = $db -> query("SELECT * FROM parties WHERE `members` LIKE '%$char[name]%'") or print "파티를 불러오는데 문제가 발생하였습니다: ".$db->lastErrorMsg();
$party = $party -> fetcharray(SQLITE3_ASSOC);
preg_match_all('/[0-9]+(?=cp)/', $party['commonwealth'], $cp);
preg_match_all('/[0-9]+(?=sp)/', $party['commonwealth'], $sp);
preg_match_all('/[0-9]+(?=ep)/', $party['commonwealth'], $ep);
preg_match_all('/[0-9]+(?=gp)/', $party['commonwealth'], $gp);
preg_match_all('/[0-9]+(?=pp)/', $party['commonwealth'], $pp);
$cp = array_sum($cp[0]);
$sp = array_sum($sp[0]);
$ep = array_sum($ep[0]);
$gp = array_sum($gp[0]);
$pp = array_sum($pp[0]);
?>
<div class="coinage"><span class="itl">cp</span><p class="sans-serif wt7"><?php echo $cp; ?><p></div>
<div class="coinage"><span class="itl">sp</span><p class="sans-serif wt7"><?php echo $sp; ?><p></div>
<div class="coinage"><span class="itl">ep</span><p class="sans-serif wt7"><?php echo $ep; ?><p></div>
<div class="coinage"><span class="itl">gp</span><p class="sans-serif wt7"><?php echo $gp; ?><p></div>
<div class="coinage"><span class="itl">pp</span><p class="sans-serif wt7"><?php echo $pp; ?><p></div>
<form action="health.php" method="get"><input type="hidden" name="M" value="C"><input type="hidden" name="pc" value="<?php echo $char['name']; ?>"><textarea name="equips" rows=8><?php echo $party['commonwealth']; ?></textarea><button type="submit" class="btn btn-default">수정</button></form>
</li>
</ul>
</div>

<!-- 언어 -->
<div class="col-xs-6 col-sm-4 languages">
	<ul class="list-group"><li class="list-group-item list-group-item-info">언어</li>
		<?php echo '<li class="list-group-item">'.$health['languages'].'</li>'; ?></ul>
</div>

<!-- 능력 -->
<div class="col-xs-12 col-sm-4">
  <ul class="list-group"><li class="list-group-item list-group-item-info">능력</li>
<?php
$feature = explode(",", $health['feature']);
	for ($i = 0 ; $i < count($feature); $i++ ) {
		$feature[$i] = trim($feature[$i]);
		$featuredesc = $db -> query ("SELECT * FROM feature WHERE `name` = '$feature[$i]' COLLATE NOCASE") or print "문제: ".$db -> lastErrorMsg();
		$featuredesc = $featuredesc -> fetchArray(SQLITE3_ASSOC);
		echo '<li class="list-group-item" ><b>'.strtoupper($feature[$i]).'</b><br />'.$featuredesc['desc'].'</li>';
	}
?>
  </ul>
</div>

</div>
<?php include("footer.php"); ?>