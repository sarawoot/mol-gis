<?php
header('Content-type: text/plain; charset=utf-8');
include ("../config/database.php");
require_once ('../config/static.php');

$conn = connectionOracleDBUTF();

$sql = 'SELECT DISTINCT MONTH_CODE,MONTH_ABBR_TH FROM VIEW_GIS_STAT_NSO_MONTHLY WHERE YEARS = ' . (( int ) $_GET['YEARS']) . ' ORDER BY MONTH_CODE';
$result = oci_parse($conn, $sql);
oci_execute($result);
echo '<option value="">เลือกเดือน</option>';
while($row = oci_fetch_array($result, OCI_BOTH)){
  echo '<option value="' . $row['MONTH_CODE'] . '">' . ($month_conf[($row['MONTH_CODE'] < 10 ? '0' . $row['MONTH_CODE'] : $row['MONTH_CODE'])]) . '</option>';
}

oci_free_statement($result);
oci_close($conn);
?>