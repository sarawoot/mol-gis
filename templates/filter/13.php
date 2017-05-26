<!-- สถิตแรงงานต่างด้าว -->
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
	<label for="monthFilter" class="col-md-2 col-md-offset-2 control-label">เดือน</label>
	<div class="col-md-8">
			<select class="form-control " id="yearFilter">
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
	<label for="yearFilter" class="col-md-2 col-md-offset-2 control-label" >สัญชาติ</label>
	<div class="col-md-8">
			<select class="form-control" id="yearFilter">
				<option value="1">พม่า</option>
				<option value="2">ลาว</option>
				<option value="3">เวียดนาม</option>
				<option value="4">มาเลเซีย</option>
				<option value="5">อินโดนีเซีย</option>
				<option value="6">ไทย</option>
			</select>
	</div>
	</div>
</div>
<div class="row">
  <div class="form-group col-md-12">
	<label for="howFilter" class="col-md-3 col-md-offset-1 control-label" >จำนวนแรงงานนอกระบบ</label>
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
	<input type="button" id="searchLayer" onclick="ClickSearchLayer()" class="btn btn-primary" value="ค้นหา"/>
	<input type="button" id="clearLayer" class="btn btn-danger" value="ล้างข้อมูล"/>
	</div>
</div>
<input id="formSearch" name="formSearch" type="hidden" value="13">
<input type="hidden" name="province" id="province" value="">
<input type="hidden" name="amphur" id="amphur" value="">
