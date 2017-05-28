
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
			<select id="layerSearchSelectForm" class="form-control"></select> <br />
			<form name="searchForm" id="searchForm">
				<div id="layerSearchForm"></div>
			</form>
			<div id="loads"
				style="width: 100%;  display: none; position: fixed; top: 50%; left: 50%; margin-top: -50px; margin-left: -50px; width: 100px; height: 100px;">
				<center>
					<p>
						<img src="assets/images/loading-bar.gif">
					</p>
				</center>
			</div>
		</div>
	</div>
</div>