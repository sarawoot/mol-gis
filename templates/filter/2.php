<!-- ผู้ผ่านการฝึกอบรม VIEW_GIS_DSD_PASS_TRAINING-->
<div class="row">
  <div class="form-group col-md-12">
	<label for="YEARS" class="col-md-2 col-md-offset-2 control-label" >ปี</label>
	<div class="col-md-8">
			<select class="form-control " id="YEARS"  name="YEARS">
				<option value="2017">2017</option>
				<option value="2016">2016</option>
				<option value="2015">2015</option>
				<option value="2014">2014</option>
			</select>
	</div>
	</div>
</div>
<div class="row">
  <div class="form-group col-md-12">
	<label for="MONTH_CODE" class="col-md-2 col-md-offset-2 control-label">เดือน</label>
	<div class="col-md-8">
			<select class="form-control " id="MONTH_CODE" name="MONTH_CODE">
				<option value="1">มกราคม</option>
				<option value="2">กุมภาพันธ์</option>
				<option value="3">มีนาคม</option>
				<option value="4">เมษายน</option>
				<option value="5">พฤษภาคม</option>
				<option value="6">มิถุนายน</option>
				<option value="7">กรกฎาคม </option>
				<option value="8">สิงหาคม</option>
				<option value="9">กันยายน</option>
				<option value="10">ตุลาคม</option>
				<option value="11">พฤศจิกายน</option>
				<option value="12">ธันวาคม</option>
			</select>
	</div>
	</div>
</div>
<div class="row">
  <div class="form-group col-md-12">
	<label for="TRAIN_ACTIVITY_CODE" class="col-md-3 col-md-offset-1 control-label" >กิจกรรมการฝึกอบรม</label>
	<div class="col-md-8">
			<select class="form-control " id="TRAIN_ACTIVITY_CODE" name="TRAIN_ACTIVITY_CODE">
				<option value="1">การฝึกเตรียมเข้าทำงาน</option>
				<option value="2">การฝึกยกระดับฝีมือ</option>
				<option value="3">การฝึกอาชีพเสริมการฝึกอาชีพเสริม</option>
				</select>
	</div>
	</div>
</div>
<div class="row">
  <div class="form-group col-md-12">
	<label for="LAW_OCCUPATION_CODE" class="col-md-3 col-md-offset-1 control-label" >กลุ่มสาขาอาชีพ</label>
	<div class="col-md-8">
			<select class="form-control " id="LAW_OCCUPATION_CODE" name="LAW_OCCUPATION_CODE">
				<option value="1">ช่างก่อสร้าง</option>
				<option value="2">ช่างอุตสาหการ</option>
				<option value="3">ช่างเครื่องกล</option>
				<option value="4">ช่างไฟฟ้า อิเล็กทรอนิกส์และคอมพิวเตอร์</option>
				<option value="5">ช่างอุตสาหกรรมศิลป์</option>
				<option value="6">เกษตรอุตสาหกรรม</option>
				<option value="7">ภาคบริการ</option>
			</select>
	</div>
	</div>
</div>
<br />
<div class="row">
  <div class="col-md-12 text-center">
	<input type="button" id="searchLayer" onclick="ClickSearchLayer()" class="btn btn-primary" value="ค้นหา"/>
	<button type="button" id="clearLayer" class="btn btn-danger">ล้างข้อมูล</button>
	</div>
</div>
<input id="formSearch" name="formSearch"   type="hidden" value="2"/>
<input type="hidden" name="province" id="province" value=""/>
<input type="hidden" name="amphur" id="amphur" value=""/>