<?php
include("header.php");

$logs = $db -> QUERY("SELECT rowid, * FROM log ORDER BY rowid DESC") or print "로그를 불러오는데 문제가 발생하였습니다: ".$db->lastErrorMsg();
if ($_GET['mode'] == 'update') {
	$db -> QUERY("UPDATE log SET `date`='$_GET[date]', `time`='$_GET[time]', `chars`='$_GET[chars]', `desc`='$_GET[desc]', `enm`='$_GET[enm]', `note`='$_GET[note]', `xps`='$_GET[xps]', `loot`='$_GET[loot]' WHERE `rowid` = '$_GET[rowid]'") or print "기록을 수정하는데 문제가 발생하였습니다: ".$db->lastErrorMsg();
	}
if ($_GET['mode'] == 'insert') {
	$db -> QUERY("INSERT INTO log VALUES ('$_GET[date]', '$_GET[time]', '$_GET[chars]', '$_GET[desc]', '$_GET[enm]', '$_GET[note]', '$_GET[xps]', '$_GET[loot]') ") or print "새 기록을 하는데 문제가 발생하였습니다: ".$db->lastErrorMsg();
	header('location:logs.php');
	}
?>

<div class="col-sx-12">
	<a href="?mode=new"><span class="glyphicon glyphicon-plus"></span> 새 일지 기록</a>
</div>

<?php if ($_GET['mode'] == 'new') { ?>
<form action="logs.php" method="get" class="form-horizontal">
	<input type="hidden" name="mode" value="insert">
	<div class="form-group">
		<label class="col-sm-2 control-label">날짜</label>
		<div class="col-sm-10">
 			<input type="number" name="date" class="form-control" >
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">시간</label>
		<div class="col-sm-10">
			<input type="text" name="time" class="form-control" >
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">관련 인물</label>
		<div class="col-sm-10">
			<input type="text" name="chars" class="form-control" >
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">일지</label>
		<div class="col-sm-10">
 	 		<textarea name="desc" class="form-control" rows="7"></textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">적</label>
		<div class="col-sm-10">
			<input type="text" name="enm" class="form-control" >
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">노트</label>
		<div class="col-sm-10">
			<input type="text" name="note" class="form-control" >
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">경험치</label>
		<div class="col-sm-10">
			<input type="number" name="xps" class="form-control" >
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">노획물</label>
		<div class="col-sm-10">
			<input type="text" name="loot" class="form-control" >
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label"></label>
		<div class="col-sm-10">
		  	<button class="btn btn-default" type="submit">입력</button>
		 </div>
	</div>
</form>
<?php } ?>

<?php WHILE ($log = $logs -> fetchArray(SQLITE3_ASSOC))	{ ?>

<?php
if ($_GET['mode'] == 'modify') {
	if ($_GET['log'] == $log['rowid']) {
	?>

<form action="logs.php" method="get" class="form-horizontal">
	<input type="hidden" name="mode" value="update">
	<input type="hidden" name="rowid" value="<?php echo $log['rowid']; ?>">
	<div class="form-group">
		<label class="col-sm-2 control-label">날짜</label>
		<div class="col-sm-10">
 			<input type="number" name="date" class="form-control" value="<?php echo $log['date']; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">시간</label>
		<div class="col-sm-10">
			<input type="text" name="time" class="form-control" value="<?php echo $log['time']; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">관련 인물</label>
		<div class="col-sm-10">
			<input type="text" name="chars" class="form-control" value="<?php echo $log['chars']; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">일지</label>
		<div class="col-sm-10">
 	 		<textarea name="desc" class="form-control" rows="7"><?php echo $log['desc']; ?></textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">적</label>
		<div class="col-sm-10">
			<input type="text" name="enm" class="form-control" value="<?php echo $log['enm']; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">노트</label>
		<div class="col-sm-10">
			<input type="text" name="note" class="form-control" value="<?php echo $log['note']; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">경험치</label>
		<div class="col-sm-10">
			<input type="number" name="xps" class="form-control" value="<?php echo $log['xps']; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">노획물</label>
		<div class="col-sm-10">
			<input type="text" name="loot" class="form-control" value="<?php echo $log['loot']; ?>">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label"></label>
		<div class="col-sm-10">
		  	<button class="btn btn-default" type="submit">입력</button>
		 </div>
	</div>
</form>
	<?php
}}
?>
<div class="row">
<div class="col-sm-2">
<?php echo '<h1>'.$log['date'].'<small>일 째 '.$log['time']; ?>	<a href="?mode=modify&log=<?php echo $log['rowid']; ?>"><span class="glyphicon glyphicon-pencil"></span></a></small></h1>
  	<p class="sans-serif sml wt7">	<?php echo $log['chars']; ?></p>
</div>

<div class="col-sm-7">
  <p class="desc"><?php echo nl2br($log['desc']); ?></p>
</div>

<div class="col-sm-3">
<p class="sans-serif sml wt7"><?php echo $log['enm'].' (총 경험치: '.$log['xps'].')'; ?></p>
<p class="serif sml itl"><?php echo $log['note']; ?></p><hr />
<p class="sans-serif sml"><?php echo $log['loot']; ?></p>
</div>
</div>

<div class="center">
<hr class="logSeperator"/>
<img src="seperator.svg" width="auto" height="20px" style="width: 60px; height: 60px; display: block; margin:0 auto; padding: 20px; position: relative; top: -50px;"/>
</div>

<?php } ?>
</div>

<?php
$db -> close();
include("footer.php");
?>
