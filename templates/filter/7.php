<!-- ผู้สูงอายุ -->
<div class="row">
	<div class="form-group col-md-12">
		<div class="col-md-10">
			ปี<br>
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
		<div class="col-md-10">
			ประเภทความพิการ<br> <select class="form-control "
				id="DISABILITY_GROUP_CODE" name="DISABILITY_GROUP_CODE">
				<option value="01">ความพิการทางการมองเห็น</option>
				<option value="02">ความพิการทางการได้ยินและสื่อความหมาย</option>
				<option value="03">ความพิการทางการเคลื่อนไหวหรือทางร่างกาย</option>
				<option value="04">ความพิการทางจิตใจหรือพฤติกรรม</option>
				<option value="05">ความพิการทางสติปัญญา</option>
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
<input id="formSearch" name="formSearch" type="hidden" value="7" />
<input type="hidden" name="province" id="province" value="" />
<input type="hidden" name="amphur" id="amphur" value="" />