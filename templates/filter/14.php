<!-- สถิตแรงงานต่างด้าว VIEW_GIS_DOE_FOREIGN_WORKER -->
<?php
require_once ("../../config/database.php");
require_once ("../../config/static.php");
require_once ("../../helpers/search.php");
$year = get_year_list(14);

$conn = connectionOracleDBUTF();

$FOREIGN_TYPE_CODE = [];
$sql = 'SELECT DISTINCT PROVINCE_GROUP_CODE,PROVINCE_GROUP_DESC FROM  DB_MOL.STD_LOCATION WHERE PROVINCE_GROUP_CODE IS NOT NULL ORDER BY PROVINCE_GROUP_DESC';
$result2 = oci_parse($conn, $sql);
oci_execute($result2);
while(($row = oci_fetch_array($result2, OCI_BOTH)) != false){
  $PROVINCE_GROUP_CODE[$row["PROVINCE_GROUP_CODE"]] = $row["PROVINCE_GROUP_DESC"];
}
oci_free_statement($result2);
oci_close($conn);
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
			ภาค<br> <select class="form-control " id="PROVINCE_GROUP_CODE"
				name="PROVINCE_GROUP_CODE" onchange="">
				
				<?php foreach($region_name as $k => $v){?><option
					value="<?php echo $k?>"><?php echo $v?></option><?php }?>
				

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
<input id="formSearch" name="formSearch" type="hidden" value="14">
<input type="hidden" name="province" id="province" value="">
<input type="hidden" name="amphur" id="amphur" value="">
