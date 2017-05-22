<?php
  
  include '../../config/database.php';
  $conn = connectionOracleDB();


  if ($_REQUEST["category"] == 'train') {
    $sql = "SELECT DISTINCT(TRAIN_OCCUPATION_GROUP_CODE) AS CODE,TRAIN_OCCUPATION_GROUP_NAME as NAME FROM DB_MOL.STD_TRAIN_COURSE";
    $sql .= " WHERE TRAIN_OCCUPATION_GROUP_NAME != 'NULL'";
    $sql .= " AND LAW_OCCUPATION_CODE = '". $_REQUEST['branch'] ."'";
    $sql .= " ORDER BY TRAIN_OCCUPATION_GROUP_CODE";
  }

  if ($_REQUEST["category"] == 'test') {
    $sql = "SELECT TEST_COURSE_CODE as CODE,TEST_COURSE_NAME as NAME FROM DB_MOL.STD_TEST_COURSE WHERE TEST_COURSE_CODE != 'NULL'";
    $sql .= " AND TEST_COURSE_NAME != 'NULL'";
    $sql .= " AND LAW_OCCUPATION_CODE = '".$_REQUEST['branch']."'";
  }

  $result = oci_parse($conn, $sql);
  oci_execute($result);
  $res = array();
  while (($row = oci_fetch_array($result, OCI_BOTH)) != false) {
    $res[] =  array(
      "code" => iconv('tis-620', 'utf-8', $row["CODE"]),
      "name" => iconv('tis-620', 'utf-8', $row["NAME"])
    );
  }
  echo json_encode($res);
  oci_free_statement($result);
  oci_close($conn);

?>