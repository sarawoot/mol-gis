<!-- สถิติผู้สูงอายุ (ราย 3 ปี) VIEW_GIS_STAT_NSO_ELDER-->
<?php
$year_start = date('Y') + 543;
$year_end = 2554;
?>
<div class="row">
	<div class="form-group col-md-12">
		<div class="col-md-12">
			ปี<br> <select class="form-control " id="YEAR_TH" name="YEAR_TH">
				<option value="">เลือกข้อมูล</option>
				<?php for($i = $year_start ; $i >= $year_end;$i--){?>
				<option value="<?php echo $i?>"><?php echo $i?></option>
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
		<button type="button" id="clearLayer" class="btn btn-danger">ล้างข้อมูล</button>
	</div>
</div>
<input id="formSearch" name="formSearch" type="hidden" value="9">
<input type="hidden" name="province" id="province" value="">
<input type="hidden" name="amphur" id="amphur" value="">