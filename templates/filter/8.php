<!-- สถิติผู้พิการ (ราย 5 ปี) VIEW_GIS_STAT_NSO_DISABILITY-->
<?php
require_once ("../../config/database.php");
require_once ("../../config/static.php");
$conn = connectionOracleDBUTF();

$DISABILITY_GROUP_CODE = [];


$sql = 'SELECT DISTINCT DISABILITY_GROUP_CODE,DISABILITY_GROUP_NAME FROM LKU_NSO_DISABILITY_TYPE
ORDER BY DISABILITY_GROUP_NAME';
$result2 = oci_parse($conn, $sql);
oci_execute($result2);
while(($row = oci_fetch_array($result2, OCI_BOTH)) != false){
  $DISABILITY_GROUP_CODE[$row["DISABILITY_GROUP_CODE"]] = $row["DISABILITY_GROUP_NAME"];
}
oci_free_statement($result2);
oci_close($conn);

$year_start = date('Y') + 543;
$year_end = 2550;
?>
<div class="row">
	<div class="form-group col-md-12">
		<div class="col-md-12">
		ปี<br>
			<select class="form-control " id="YEAR_TH" name="YEAR_TH">
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
		ประเภทลักษณะความบกพร่อง<br>
			<select class="form-control " id="DISABILITY_GROUP_CODE"
				name="DISABILITY_GROUP_CODE" onchange="$('#DISABILITY_TYPE_CODE').load('controllers/group_disable_type.php?YEAR='+ $('#YEAR_TH').val() +'&DISABILITY_GROUP_CODE=' + this.value);">
				<option value="">เลือกข้อมูล</option>
				<?php foreach($DISABILITY_GROUP_CODE as $k=>$v){?>
					<option value="<?php echo $k;?>"><?php echo $v;?></option>
				<?php }?>
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group col-md-12">
		<div class="col-md-12">
			ลักษณะความบกพร่อง<br>
			<select class="form-control " id="DISABILITY_TYPE_CODE"
				name="DISABILITY_TYPE_CODE">
				<option value="">เลือกข้อมูล</option>
			</select>
		</div>
	</div>
</div>
<br />
<div class="row">
	<div class="col-md-12 text-center">
		<input type="button" id="searchLayer" onclick="ClickSearchLayer()"
			class="btn btn-primary" value="ค้นหา" />
		<button type="button" id="clearLayer" class="btn btn-danger">ล้างข้อมูล</button>
	</div>
</div>
<input id="formSearch" name="formSearch" type="hidden" value="8" />
<input type="hidden" name="province" id="province" value="" />
<input type="hidden" name="amphur" id="amphur" value="" />