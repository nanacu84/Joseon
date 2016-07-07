<?php $db = new SQLite3('db.sqlite'); ?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<title>전국조선</title>
	<link rel="icon" type="image/png" href="ICON.PNG" />
	<link rel="apple-touch-icon" href="ICON.PNG" />

<?php
if (!$_GET['pc']) {
	$_GET['pc'] = '찬달';
}

$char = $db -> query("SELECT * FROM char WHERE `name` = '$_GET[pc]'") or print "$_GET[pc]을(를) 불러오지 못했습니다: ".$db->lastErrorMsg();
$char = $char -> fetchArray(SQLITE3_ASSOC);

$stat = array($char['str'], $char['dex'], $char['con'], $char['int'], $char['wis'], $char['cha']);
	for ($i = 0; $i < 6 ; $i ++)	{	$stat_mod[$i] = floor($stat[$i]/2-5);	}
$ability_name = array('STR','DEX','CON','INT','WIS','CHA');
$class = array('야만전사', '음유시인', '성직자', '신령', '전사', '수도승', '성기사', '순찰자', '도적', '주술사', '마도사', '마법사');
$hd = array(12, 8, 8, 8, 10, 8, 10, 10, 8, 6, 8, 6);
$prof_abilities = array(array(0,2),array(1,5));
$prof_abilities[4] = array(0,2);
$prof_abilities[6] = array(4,5);
$prof_abilities[7] = array(0,1);
$prof_abilities[11] = array(3,4);
$race = array('난쟁이', '요정', '반쪽이', '인간', '용가리', '땅요정', '반요정', '반오크', '악마새끼');
$base_speed = array(25, 30, 25, 30, 30, 25, 30, 30, 30);
$prof = floor(($char['hd']-1)/4)+2;
$leveling = array(-100,0,300,900,2700,6500,14000,23000,34000,48000,64000,85000,100000,120000,140000,165000,195000,225000,265000,305000,355000);
?>

<meta property="og:url" content="http://parkjinho.pe.kr/joseon/; ?>">
<meta property="og:title" content="<?php echo $_GET['pc'].': 전국조선의'.$class[$char['class']]; ?>">
<meta property="og:type" content="website">
<meta property="og:image" content="<?php echo $char['prf']; ?>">
</head>

<body>	
  <nav class="navbar serif">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
            <span class="sr-only">토글 네비게이션</span>
          </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
          		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">영웅열전<span class="caret"></span></a>
		   			<ul class="dropdown-menu">
			<?php
				$pc = $db -> query("SELECT name FROM char");
				while ($result = $pc -> fetchArray(SQLITE3_ASSOC)){
					echo '<li class="';
					echo ($result['name'] == $_GET['pc'] ? 'active' : '');
					echo '"><a href="index.php?pc='.$result['name'].'">'.$result['name'].'</a></li>';
				}
			?>
	        <li role="separator" class="divider"></li>
            <li class="disabled"><a href="#">사망유희</a></li>
		   			</ul>
			</li>

			<li class=""><a href="spellbook.php">주문목록</a></li>
			<li class=""><a href="logs.php">모험일지</a></li>
          </ul>
        </div>
    </nav>
<div class="container">    