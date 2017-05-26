<!-- สถิติการสำรวจประชากร (รายไตรมาส) VIEW_GIS_STAT_NSO_QUARTER -->
<div class="row">
  <div class="form-group col-md-12">
	<label for="YEARS" class="col-md-2 col-md-offset-2 control-label" >ปี</label>
	<div class="col-md-8">
			<select class="form-control " id="YEARS" name="YEARS">
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
	<label for="QUARTER" class="col-md-2 col-md-offset-2 control-label">ไตรมาส</label>
	<div class="col-md-8">
			<select class="form-control " id="QUARTER" name="QUARTER">
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
			</select>
	</div>
	</div>
</div>
<div class="row">
  <div class="form-group col-md-12">
	<label for="WEIGHT_AMT" class="col-md-3 col-md-offset-1 control-label" >จำนวนผู้อยู่ในวัยทำงาน อายุ 15 ปี ขึ้นไป</label>
	<div class="col-md-8">
			<select class="form-control " id="WEIGHT_AMT" name="WEIGHT_AMT">
			  <option value="0:1800000">น้อยกว่า 1800000</option>
				<option value="1800001:3600000">1800001-3600000</option>
				<option value="3600001:5400000">3600001-5400000</option>
				<option value="5400000:7200000">5400000-7200000</option>
				<option value="7200001:9000000">7200001-9000000</option>
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
<input id="formSearch" type="hidden" value="11">
<input type="hidden" name="province" id="province" value="">
<input type="hidden" name="amphur" id="amphur" value="">