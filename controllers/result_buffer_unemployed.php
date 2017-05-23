<?php
  include '../config/database.php';
  $conn = connectionOracleDB();
  $sql = "SELECT TDRJP.OCCUPATION_CODE ,NVL(SO.OCCUPATION_NAME,'No Data') AS OCCUPATION_NAME,COUNT(*) AS COU_P";
  $sql .= " FROM DB_MOL.TRT_DOE_REQUEST_JOB TDRJ INNER JOIN DB_MOL.TRT_DOE_REQUEST_JOB_POSITION TDRJP";
  $sql .= " ON TDRJ.PERSONAL_ID = TDRJP.PERSONAL_ID";
  $sql .= " LEFT JOIN DB_MOL.STD_OCCUPATION SO";
  $sql .= " ON SO.OCCUPATION_SOURCE = TDRJP.OCCUPATION_CODE WHERE";
  $sql .= " TDRJ.LOCATION_CODE in (".$_REQUEST['codes'].")";
  $sql .= " GROUP BY TDRJP.OCCUPATION_CODE,SO.OCCUPATION_NAME";
  
  $result = oci_parse($conn, $sql);
  oci_execute($result);
  $res = array();
  while (($row = oci_fetch_array($result, OCI_BOTH)) != false) {
    $res[] =  array(
      "OCCUPATION_CODE" => iconv('tis-620', 'utf-8', $row["OCCUPATION_CODE"]),
      "OCCUPATION_NAME" => iconv('tis-620', 'utf-8//IGNORE', $row["OCCUPATION_NAME"]),
      "COU_P" => iconv('tis-620', 'utf-8', $row["COU_P"])
    );
  }
  
  echo json_encode($res);
  oci_free_statement($result);
  oci_close($conn);
?>



