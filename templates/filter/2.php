<!-- ผู้ผ่านการฝึกอบรม VIEW_GIS_DSD_PASS_TRAINING-->
<?php
require_once ("../../config/database.php");
require_once ("../../config/static.php");
$conn = connectionOracleDBUTF();

$TRAIN_ACTIVITY_CODE = [];
$LAW_OCCUPATION_CODE = [];
$sql = 'SELECT DISTINCT TRAIN_ACTIVITY_CODE,TRAIN_ACTIVITY_NAME FROM DB_MOL.STD_TRAIN_ACTIVITY ORDER BY TRAIN_ACTIVITY_NAME';
$result1 = oci_parse($conn, $sql);
oci_execute($result1);
while(($row = oci_fetch_array($result1, OCI_BOTH)) != false){
  $TRAIN_ACTIVITY_CODE[$row["TRAIN_ACTIVITY_CODE"]] = $row["TRAIN_ACTIVITY_NAME"];
}

$sql = 'SELECT * FROM DB_MOL.STD_LAW_OCCUPATION  WHERE LAW_OCCUPATION_CODE > 0 ORDER BY LAW_OCCUPATION_CODE';
$result2 = oci_parse($conn, $sql);
oci_execute($result2);
while(($row = oci_fetch_array($result2, OCI_BOTH)) != false){
  $LAW_OCCUPATION_CODE[$row["LAW_OCCUPATION_CODE"]] = $row["LAW_OCCUPATION_NAME"];
}
oci_free_statement($result1);
oci_free_statement($result2);
oci_close($conn);

$year_start = date('Y') + 543;
$year_end = 2551;
?>
<div class="row">
	<div class="form-group col-md-12">
		<div class="col-md-12">ปี<br>
			<select class="form-control " id="YEARS" name="YEARS">
				<option value="">เลือกข้อมูล</option>
				<?php for($i = $year_start ; $i >= $year_end;$i--){?>
				<option value="<?php echo $i?>"><?php echo $i?></option>
				<?php }?>
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group col-md-12">
		<div class="col-md-12">
			เดือน<br> <select class="form-control " id="MONTH_CODE"
				name="MONTH_CODE">
				<option value="">เลือกข้อมูล</option>
				<?php foreach($month_conf as $k=>$v){?>
				<option value="<?php echo $k?>"><?php echo $v?></option>
				<?php }?>
				
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group col-md-12">
		<div class="col-md-12">
			กิจกรรมการฝึกอบรม<br> <select class="form-control "
				id="TRAIN_ACTIVITY_CODE" name="TRAIN_ACTIVITY_CODE">
				<option value="">เลือกข้อมูล</option>
				<?php foreach($TRAIN_ACTIVITY_CODE as $k=>$v){?>
					<option value="<?php echo $k;?>"><?php echo $v;?></option>
				<?php }?>
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group col-md-12">
		<div class="col-md-12">
			กลุ่มสาขาอาชีพ<br> <select class="form-control "
				id="LAW_OCCUPATION_CODE" name="LAW_OCCUPATION_CODE">
				<option value="">เลือกข้อมูล</option>
				<?php foreach($LAW_OCCUPATION_CODE as $k=>$v){?>
					<option value="<?php echo $k;?>"><?php echo $v;?></option>
				<?php }?>
			</select>
		</div>
	</div>
</div>
<br />
<div class="row">
	<div class="col-md-12 text-center">
		<input type="button" id="searchLayer" onclick="ClickSearchLayer()"
			class="btn btn-primary" value="ค้นหา" />
		<button type="reset" id="clearLayer" class="btn btn-danger" onclick="clearSearchResult()">ล้างข้อมูล</button>
	</div>
</div>
<input id="formSearch" name="formSearch" type="hidden" value="2" />
<input type="hidden" name="province" id="province" value="" />
<input type="hidden" name="amphur" id="amphur" value="" />