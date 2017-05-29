
<div class="panel panel-default" id="panelSearch" style="display: none;">
	<div class="panel-heading" role="tab" id="headingLayerSearch">

		<h4 class="panel-title">
			<a onclick="hideResultPanel(this)" data-toggle="collapse"
				data-parent="#leftMenuSearch" href="#collapseLayerSearch"
				aria-expanded="false" aria-controls="collapseLayerSearch"> <i
				class="fa fa-search"></i> ค้นหา
			</a>
			<!--<span class="pull-right slide-submenu">
                  <i class="fa fa-chevron-left"></i>
                </span>-->
		</h4>
	</div>
	<div id="collapseLayerSearch" class="panel-collapse collapse"
		role="tabpanel" aria-labelledby="searchLayer">
		<div class="panel-body"
			style="height: 500px; overflow: auto; padding: 1px">
			<select id="layerSearchSelectForm" class="form-control">
				<option value="-1">กรุณาเลือก</option>
				<option value="1">คนพิการมีงานทำ</option>
				<option value="2">ผู้ผ่านการฝึกอบรม</option>
				<option value="3">ผู้ผ่านการทดสอบ</option>
				<option value="4">ตำแหน่งงานว่าง</option>
				<option value="5">ผู้ประกันตน ม.33</option>
				<option value="6">ผู้ประกันตน ม.40</option>
				<option value="7">ผู้สูงอายุ</option>
				<option value="8">สถิติผู้พิการ (รายปี)</option>
				<option value="9">สถิติผู้สูงอายุ (รายปี)</option>
				<option value="10">สถิติการสำรวจประชากร (รายเดือน)</option>
				<option value="11">สถิติการสำรวจประชากร (รายไตรมาส)</option>
				<option value="12">สถิตแรงงานนอกระบบ</option>
				<option value="13">สถิตแรงงานต่างด้าว</option>
			</select> <br />
			<form name="searchForm" id="searchForm">
				<div id="layerSearchForm"></div>
			</form>
			<div id="loads"
				style="width: 100%; display: none; position: fixed; top: 50%; left: 50%; margin-top: -50px; margin-left: -50px; width: 100px; height: 100px;">
				<center>
					<p>
						<img src="assets/images/loading-bar.gif">
					</p>
				</center>
			</div>
		</div>
	</div>
</div>