<!-- ผู้ประกันตน ม.40 -->
<?php
require_once ("../../config/static.php");
require_once ("../../helpers/search.php");

$year = get_year_list(6);
?>
<div class="row">
	<div class="form-group col-md-12">
		<div class="col-md-12">
			ปี<br> <select class="form-control " id="YEARS" name="YEARS">
				<option value="">เลือกข้อมูล</option>
				<?php
    if (count($year) > 0){
      foreach($year as $k => $v){
        ?>
				<option value="<?php echo $v?>"><?php echo $v?></option>
				<?php
      }
    }
    ?>
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group col-md-12">
		<div class="col-md-12">
			เดือน<br> <select class="form-control " id="MONTH_CODE"
				name="MONTH_CODE">
				<option value="">เลือกข้อมูล</option>
				<?php foreach($month_conf as $k=>$v){?>
				<option value="<?php echo $k?>"><?php echo $v?></option>
				<?php }?>
			</select>
		</div>
	</div>
</div>
<br />
<div class="row">
	<div class="col-md-12 text-center">
		<input type="button" id="searchLayer" onclick="ClickSearchLayer()"
			class="btn btn-primary" value="ค้นหา" />
		<button type="reset" id="clearLayer" class="btn btn-danger"
			onclick="clearSearchResult()">ล้างข้อมูล</button>
	</div>
</div>
<input id="formSearch" name="formSearch" type="hidden" value="6" />
<input type="hidden" name="province" id="province" value="" />
<input type="hidden" name="amphur" id="amphur" value="" />