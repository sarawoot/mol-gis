<!-- สถิติการสำรวจประชากร (รายไตรมาส) VIEW_GIS_STAT_NSO_QUARTER -->
<?php
require_once ("../../config/static.php");

$year_start = date('Y') + 543;
$year_end = 2544;
?>
<div class="row">
	<div class="form-group col-md-12">
		<div class="col-md-12">
			ปี<br> <select class="form-control " id="YEARS" name="YEARS">
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
			ไตรมาส<br> <select class="form-control " id="QUARTER" name="QUARTER">
				<option value="">เลือกข้อมูล</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
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
<input id="formSearch" name="formSearch" type="hidden" value="11">
<input type="hidden" name="province" id="province" value="">
<input type="hidden" name="amphur" id="amphur" value="">