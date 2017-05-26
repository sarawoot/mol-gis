<!-- สถิตแรงงานนอกระบบ  VIEW_GIS_STAT_NSO_INFORMAL_WK-->
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
	<label for="WEIGHT_AMT" class="col-md-3 col-md-offset-1 control-label" >จำนวนแรงงานนอกระบบ</label>
	<div class="col-md-8">
			<select class="form-control " id="WEIGHT_AMT" name="WEIGHT_AMT">
				<option value="0:320000">น้อยกว่า 320000</option>
				<option value="320001:640000">320001:640000</option>
				<option value="640001:960000">640001:960000</option>
				<option value="960001:1280000">960001:1280000</option>
				<option value="1280001:1600000">1280001:1600000</option>
			</select>
	</div>
	</div>
</div>
<br />
<div class="row">
  <div class="col-md-12 text-center">
	<input type="button" id="searchLayer" onclick="ClickSearchLayer()" class="btn btn-primary" value="ค้นหา"/>
	<input type="button" id="clearLayer" class="btn btn-danger" value="ล้างข้อมูล"/>
	</div>
</div>
<input id="formSearch" name="formSearch" type="hidden" value="12">
<input type="hidden" name="province" id="province" value="">
<input type="hidden" name="amphur" id="amphur" value="">
