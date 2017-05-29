<!-- คนพิการมีงานทำ VIEW_GIS_DOE_DISABILITY-->
<?php
require_once ("../../config/database.php");
$conn = connectionOracleDBUTF();

$DISABILTIY_TYPE = [];
$GRAD_EDU = [];
$sql = 'SELECT DISTINCT DIS_TYPE AS DISABILTIY_TYPE FROM DB_MOL.CRIPPLE ORDER BY DIS_TYPE';
$result1 = oci_parse($conn, $sql);
oci_execute($result1);
while(($row = oci_fetch_array($result1, OCI_BOTH)) != false){
  $DISABILTIY_TYPE[] = $row["DISABILTIY_TYPE"];
}

$sql = 'SELECT DISTINCT N_EDU AS GRAD_EDU FROM DB_MOL.CRIPPLE ORDER BY N_EDU';
$result2 = oci_parse($conn, $sql);
oci_execute($result2);
while(($row = oci_fetch_array($result2, OCI_BOTH)) != false){
  $GRAD_EDU[] = $row["GRAD_EDU"];
}
oci_free_statement($result1);
oci_free_statement($result2);
oci_close($conn);

?>
<div class="row">
	<div class="form-group col-md-12">
		<div class="col-md-12">
			ประเภทของความพิการ<br> <select class="form-control "
				id="DISABILTIY_TYPE" name="DISABILTIY_TYPE">
				<option value="">เลือกข้อมูล</option>
				<?php foreach($DISABILTIY_TYPE as $k =>$v){?>
				<option value="<?php echo $v?>"><?php echo $v?></option>
				<?php }?>
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="form-group col-md-12">
		<div class="col-md-12">
			วุฒิการศึกษา<br> <select class="form-control " id="GRAD_EDU"
				name="GRAD_EDU">
				<option value="">เลือกข้อมูล</option>
				<?php foreach($GRAD_EDU as $k =>$v){?>
				<option value="<?php echo $v?>"><?php echo $v?></option>
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
		<button type="button" id="clearLayer" class="btn btn-danger">ล้างข้อมูล</button>
	</div>
</div>
<input id="formSearch" name="formSearch" type="hidden" value="1">
<input type="hidden" name="province" id="province" value="">
<input type="hidden" name="amphur" id="amphur" value="">