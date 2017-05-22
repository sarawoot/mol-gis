<?php
  
  include '../../config/database.php';
  $conn = connectionOracleDB();
  $sql = "SELECT DISTINCT(TARGET_BUDGET_YEAR) AS TBY FROM DB_MOL.LKU_DSD_TRAINING_COURSE ORDER BY TARGET_BUDGET_YEAR DESC";

  $result = oci_parse($conn, $sql);
  oci_execute($result);
  $res = array();
  while (($row = oci_fetch_array($result, OCI_BOTH)) != false) {
    $res[] =  array(
      "code" => iconv('tis-620', 'utf-8', $row["TBY"]),
      "name" => iconv('tis-620', 'utf-8', $row["TBY"])
    );
  }
  echo json_encode($res);
  oci_free_statement($result);
  oci_close($conn);
  
?>          