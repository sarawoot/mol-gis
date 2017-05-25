<!-- ผู้ประกันตน ม.33 -->
<div class="row">
  <div class="form-group col-md-12">
	<label for="yearFilter" class="col-md-2 col-md-offset-2 control-label" >ปี</label>
	<div class="col-md-8">
			<select class="form-control " id="yearFilter">
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
	<label for="howFilter" class="col-md-3 col-md-offset-1 control-label" >จำนวน</label>
	<div class="col-md-8">
			<select class="form-control " id="howFilter">
				<option value="00">น้อยกว่า 20</option>
				<option value="20">20-50</option>
				<option value="51">51-100</option>
				<option value="101">101-150</option>
			</select>
	</div>
	</div>
</div>
<br />
<div class="row">
  <div class="col-md-12 text-center">
	<input type="button" id="searchLayer" onclick="searchLayer()" class="btn btn-primary" value="ค้นหา"/>
	<button type="button" id="clearLayer" class="btn btn-danger">ล้างข้อมูล</button>
	</div>
</div>
<input id="formSearch" type="hidden" value="8"/>
<input type="hidden" name="province" id="province" value=""/>
<input type="hidden" name="amphur" id="amphur" value=""/>