<?php
header('Content-type: text/plain; charset=utf-8');
include ("../config/database.php");
require_once ('../config/static.php');

$conn = connectionOracleDBUTF();
$_GET['region'] = ( int ) $_GET['region'];
$where = '';
switch($_GET['region']){
  case 4 :
    $where = " AND PROVINCE_CODE NOT IN 
              ( SELECT DISTINCT PROVINCE_CODE FROM DB_MOL.STD_LOCATION WHERE  PROVINCE_GROUP_DESC like 'ภาคตะวันออกเฉียงเหนือ%')";
    break;
  case 2 :
    $where = " AND PROVINCE_CODE NOT IN
              ( SELECT DISTINCT PROVINCE_CODE FROM DB_MOL.STD_LOCATION WHERE  PROVINCE_GROUP_DESC like 'ภาคตะวันออกเฉียงเหนือ%')";
    break;
}

$sql = "SELECT DISTINCT PROVINCE_CODE,PROVINCE_NAME FROM DB_MOL.STD_LOCATION   
    WHERE PROVINCE_GROUP_DESC LIKE '" . $region_name[$_GET['region']] . "%'  $where
        
    ORDER BY PROVINCE_NAME";
$result = oci_parse($conn, $sql);
oci_execute($result);
echo '<option value="">เลือกจังหวัด</option>';
while($row = oci_fetch_array($result, OCI_BOTH)){
  echo '<option value="' . $row['PROVINCE_CODE'] . '">' . $row['PROVINCE_NAME'] . '</option>';
}

oci_free_statement($result);
oci_close($conn);
?>