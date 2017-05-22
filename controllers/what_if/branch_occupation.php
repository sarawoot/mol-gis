<?php
  
  include '../../config/database.php';
  $conn = connectionOracleDB();
  $sql = "SELECT LAW_OCCUPATION_CODE,LAW_OCCUPATION_NAME FROM DB_MOL.STD_LAW_OCCUPATION ORDER BY LAW_OCCUPATION_CODE ASC";

  $result = oci_parse($conn, $sql);
  oci_execute($result);
  $res = array();
  while (($row = oci_fetch_array($result, OCI_BOTH)) != false) {
    $res[] =  array(
      "code" => iconv('tis-620', 'utf-8', $row["LAW_OCCUPATION_CODE"]),
      "name" => iconv('tis-620', 'utf-8', $row["LAW_OCCUPATION_NAME"])
    );
  }
  echo json_encode($res);
  oci_free_statement($result);
  oci_close($conn);

?>