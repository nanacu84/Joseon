<?php
include("header.php");

if ($_GET['mode'] == 'write') {
$hp = $hd[$_GET['class']] + floor($_GET[con]/2-5);
$db -> query("INSERT INTO char VALUES ('$_GET[name]', '$_GET[race]', '$_GET[al]', '$_GET[bkg]', '$_GET[fct]', '$_GET[pst]', '$_GET[idl]', '$_GET[bnd]', '$_GET[flw]', '$_GET[str]', '$_GET[dex]', '$_GET[con]', '$_GET[int]', '$_GET[wis]', '$_GET[cha]', '$_GET[class]', '$_GET[hd]', '$_GET[exp]', '$_GET[weapons]', '$_GET[armor]', '$_GET[skills]', '$_GET[sex]', '$_GET[prf]', '$_GET[motto]' )") or print "char에 새 영웅을 기록하는데 문제가 발생하였습니다: ".$db->lastErrorMsg();
$db -> query("INSERT INTO health (`name`, `max`, `current`, `equips`) VALUES ('$_GET[name]','$hp','$hp','$_GET[equips]')") or print "health에 새 영웅을 기록하는데 문제가 발생하였습니다: ".$db->lastErrorMsg();
$db -> close();
header('location:index.php?pc='.$_GET['name']);
}
?>

<div class="writingCharacter">
<form action="newchar.php" method="get" class="form-horizontal">
	<input type="hidden" name="mode" value="write">

	<div class="input-group">
		<span class="input-group-addon">이름</span>
 			<input type="text" name="name" class="form-control">
	</div>
	
	<div class="row">
		<div class="col-xs-4 col-sm-2">
			<div class="input-group">
				<span class="input-group-addon">힘</span>
	 			<input type="text" name="str" class="form-control">
			</div>
		</div>
		<div class="col-xs-4 col-sm-2">
			<div class="input-group">
				<span class="input-group-addon">민첩</span>
	 			<input type="text" name="dex" class="form-control">
			</div>
		</div>
		<div class="col-xs-4 col-sm-2">
			<div class="input-group">
				<span class="input-group-addon">건강</span>
	 			<input type="text" name="con" class="form-control">
			</div>
		</div>
		<div class="col-xs-4 col-sm-2">
			<div class="input-group">
				<span class="input-group-addon">지능</span>
	 			<input type="text" name="int" class="form-control">
			</div>
		</div>
		<div class="col-xs-4 col-sm-2">
			<div class="input-group">
				<span class="input-group-addon">지혜</span>
	 			<input type="text" name="wis" class="form-control">
			</div>
		</div>
		<div class="col-xs-4 col-sm-2">
			<div class="input-group">
				<span class="input-group-addon">매력</span>
	 			<input type="text" name="cha" class="form-control">
			</div>
		</div>
	</div>

	<div class="input-group">
		<span class="input-group-addon">종족</span>
		<div class="form-control ">
			<?php for ($i = 0 ; $i < count($race) ; $i ++ ) {
					echo '<label><input name="race" type="radio" value='.$i.'> '.$race[$i].' </label>'; } ?>
		</div>
	</div>

	<div class="input-group">
		<span class="input-group-addon">직업</span>
		<div class="form-control">
			<?php for ($i = 0 ; $i < count($class) ; $i ++ ) {
					echo '<label><input name="class" type="radio" value="'.$i.'"> '.$class[$i].' </label>'; } ?>
		</div>
	</div>

	<div class="input-group">
		<span class="input-group-addon">단계</span>
			<input type="text" name="hd" class="form-control">
	</div>

	<div class="input-group">
		<span class="input-group-addon">경험치</span>
			<input type="text" name="exp" class="form-control">
	</div>

	<div class="input-group">
		<span class="input-group-addon">무기</span>
			<input type="text" name="weapons" class="form-control">
	</div>
	<div class="input-group">
		<span class="input-group-addon">방어구</span>
			<input type="text" name="armor" class="form-control">
	</div>
	<div class="input-group">
		<span class="input-group-addon">기술</span>
			<input type="text" name="skills" class="form-control">
	</div>
	<div class="input-group">
		<span class="input-group-addon">성별</span>
			<input type="text" name="sex" class="form-control">
	</div>
	<div class="input-group">
		<span class="input-group-addon">이미지</span>
			<input type="text" name="prf" class="form-control">
	</div>
	<div class="input-group">
		<span class="input-group-addon">한마디</span>
			<input type="text" name="motto" class="form-control">
	</div>

	<div class="input-group">
		<span class="input-group-addon">가치관</span>
 			<input type="text" name="al" class="form-control">
	</div>

	<div class="input-group">
		<span class="input-group-addon">배경</span>
 			<input type="text" name="bkg" class="form-control">
	</div>

	<div class="input-group">
		<span class="input-group-addon">조직</span>
 			<input type="text" name="fct" class="form-control">
	</div>

	<div class="input-group">
		<span class="input-group-addon">개성</span>
 			<input type="text" name="pst" class="form-control">
	</div>

	<div class="input-group">
		<span class="input-group-addon">이상</span>
 			<input type="text" name="idl" class="form-control">
	</div>

	<div class="input-group">
		<span class="input-group-addon">집착</span>
 			<input type="text" name="bnd" class="form-control">
	</div>

	<div class="input-group">
		<span class="input-group-addon">결점</span>
 			<input type="text" name="flw" class="form-control">
	</div>

	<div class="input-group">
		<span class="input-group-addon">소지품</span>
 			<input type="text" name="equips" class="form-control">
	</div>

	<div class="input-group">
		<span class="input-group-addon">언어</span>
 			<input type="text" name="languages" class="form-control">
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