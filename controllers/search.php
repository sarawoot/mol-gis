<?php
header('');
require ("../config/database.php");
require ("../helpers/share_func.php");
require ("../helpers/search.php");
$conn = connectionOracleDBUTF();

$sql = "";
$num_min = 0;
$num_max = 0;
$level = 5;
$intervals = array();
$result = array();

$sql = genSql($_GET);

if ($sql != ""){
  $result = oci_parse($conn, $sql);
  oci_execute($result);
  
  $sql_min = "SELECT MIN(CNT) AS MIN_CNT FROM (" . $sql . ")";
  $result_min = oci_parse($conn, $sql_min);
  oci_execute($result_min);
  $row = oci_fetch_array($result_min, OCI_BOTH);
  $num_min = isset($row["MIN_CNT"]) ? $row["MIN_CNT"] : 0;
  
  $sql_max = "SELECT MAX(CNT) AS MAX_CNT FROM (" . $sql . ")";
  $result_max = oci_parse($conn, $sql_max);
  oci_execute($result_max);
  $row = oci_fetch_array($result_max, OCI_BOTH);
  $num_max = isset($row["MAX_CNT"])?$row["MAX_CNT"] : 0;;
  
  oci_free_statement($result_min);
  oci_free_statement($result_max);
}
if ($num_max > 0){
  $intervals = IntervalInt($num_min, $num_max, $level);
}

$data = array(
    "intervals" => $intervals,"data" => array()
);

while(($row = oci_fetch_array($result, OCI_BOTH)) != false){
  $data["data"][] = array(
      "id_code" => $row["CWT_CODE"],"cnt" => $row["CNT"]
  );
}

if (isset($result)){
  oci_free_statement($result);
}

echo json_encode($data);

oci_close($conn);
?>