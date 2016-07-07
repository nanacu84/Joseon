<?php
include("header.php");

if ($_GET['mode'] == 'write') {
$db -> query("INSERT INTO spell VALUES ('$_GET[name]', '$_GET[lv]', '$_GET[sch]', '$_GET[ctime]', '$_GET[range]', '$_GET[compo]', '$_GET[dura]', '$_GET[desc]', '$_GET[higher]')") or print "주문을 기록하는데 문제가 발생하였습니다: ".$db->lastErrorMsg();
$db -> close();
}
?>

<form action="scribing.php" method="get" class="form-horizontal">
	<input type="hidden" name="mode" value="write">

	<div class="form-group">
		<label class="col-sm-2 control-label">주문의 이름</label>
		<div class="col-sm-10">
 			<input type="text" name="name" class="form-control" >
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">주문 등급</label>
		<div class="col-sm-10">
			<input list="lv" name="lv" class="form-control">
 			<datalist id="lv">
 				<option value="0">
				<option value="1">
				<option value="2">
				<option value="3">
				<option value="4">
				<option value="5">
				<option value="6">
				<option value="7">
				<option value="8">
				<option value="9">
			</datalist>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">주문 학파</label>
		<div class="col-sm-10">
			<input list="sch" name="sch" class="form-control">
			<datalist id="sch">
				<option value="abjuration">
				<option value="conjuration">
				<option value="divination">
				<option value="enchantment">
				<option value="evocation">
				<option value="illusion">
				<option value="necromancy">
				<option value="transmutation">
			</datalist>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">시전 시간</label>
		<div class="col-sm-10">
			<input type="text" name="ctime" class="form-control">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">유효 범위</label>
		<div class="col-sm-10">
			<input type="text" name="range" class="form-control">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">구성 요소</label>
		<div class="col-sm-10">
 			<input type="text" name="compo" class="form-control">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">지속 시간</label>
		<div class="col-sm-10">
 			<input type="text" name="dura" class="form-control">
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">설명</label>
		<div class="col-sm-10">
 	 		<textarea name="desc" class="form-control" rows="7"></textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label">더 높은 등급에서는…</label>
		<div class="col-sm-10">
 			<textarea name="higher" class="form-control" rows="3"></textarea>
		</div>
	</div>

	<div class="form-group">
		<label class="col-sm-2 control-label"></label>
		<div class="col-sm-10">
		  	<button class="btn btn-default" type="submit">입력</button>
		 </div>
	</div>

</form>
</div>

<?php include("footer.php"); ?>
