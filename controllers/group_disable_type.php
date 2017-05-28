<?php
header('Content-type: text/plain; charset=utf-8');
include ("../config/database.php");
require ("../helpers/share_func.php");
require ("../helpers/search.php");
require_once ('../config/static.php');

$conn = connectionOracleDBUTF();

$sql = "SELECT  DISABILITY_TYPE_CODE,DISABILITY_TYPE_NAME 
FROM LKU_NSO_DISABILITY_TYPE WHERE DISABILITY_GROUP_CODE ='" . $_GET['DISABILITY_GROUP_CODE'] . "' 
    AND YEAR = " . (( int ) $_GET['YEAR']) . " ORDER BY DISABILITY_GROUP_NAME";
echo $sql;
$result = oci_parse($conn, $sql);
oci_execute($result);
echo '<option value="">เลือกข้อมูล</option>';
while($row = oci_fetch_array($result, OCI_BOTH)){
  echo '<option value="' . $row['DISABILITY_TYPE_CODE'] . '">' . $row['DISABILITY_TYPE_NAME'] . '</option>';
}

oci_free_statement($result);
oci_close($conn);
?>