<!-- คนพิการมีงานทำ -->
<div class="row">
	<label for="yearFilterSwitcher">ปี</label> <select class="form-control"
		id="yearFilterSwitcher">
		<option value="2017">2017</option>
		<option value="2016">2016</option>
		<option value="2015">2015</option>
		<option value="2014">2014</option>
	</select>
</div>
<label for="typeFilterSwitcher">หลักสูตร</label>
<select class="form-control" id="typeFilterSwitcher">
	<option value="01">ความพิการทางการมองเห็น</option>
	<option value="01">ความพิการทางการได้ยินและสื่อความหมาย</option>
	<option value="01">ความพิการทางการเคลื่อนไหวหรือทางร่างกาย</option>
	<option value="01">ความพิการทางจิตใจหรือพฤติกรรม</option>
	<option value="01">ความพิการทางสติปัญญา</option>
</select>

<label for="howFilterSwitcher">จำนวนผู้ผ่านการฝึกอบรม</label>
<select class="form-control" id="howFilterSwitcher">
	<option value="00">น้อยกว่า 20</option>
	<option value="20">20-50</option>
	<option value="51">51-100</option>
	<option value="101">101-150</option>
</select>
<br />
<button type="button" class="btn btn-primary">ค้นหา</button>
<button type="button" class="btn btn-danger">ล้างข้อมูล</button>