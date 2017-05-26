<!-- สถิติผู้สูงอายุ (ราย 3 ปี) VIEW_GIS_STAT_NSO_ELDER-->
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
	<label for="WEIGHT_AMT" class="col-md-3 col-md-offset-1 control-label" >จำนวนผู้สูงอายุ</label>
	<div class="col-md-8">
			<select class="form-control " id="WEIGHT_AMT" name="WEIGHT_AMT">
				<option value="0:180000">น้อยกว่า 180000</option>
				<option value="180001:360000">180001-360000</option>
				<option value="360001:540000">360001-540000</option>
				<option value="540000:720000">540000-720000</option>
				<option value="720001:900000">720001-900000</option>
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
<input id="formSearch" type="hidden" value="9">
<input type="hidden" name="province" id="province" value="">
<input type="hidden" name="amphur" id="amphur" value="">