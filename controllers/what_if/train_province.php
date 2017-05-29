<?php
  
  include '../../config/database.php';
  include '../../helpers/share_func.php';
  $conn = connectionOracleDB();

  $sql = "SELECT WhatIFTrain.PROVINCE_CODE ";
  $sql .= ",ROUND((((PEOPLE / TOTAL)* ".$_REQUEST['num'].") / ((GRADUATE / ATTEND) * 100)) * 100) AS VALTRAIN ";
  $sql .= "FROM(SELECT MSC.PROVINCE_CODE,SUM(MSC.MALE_QUANTITY + MSC.FEMALE_QUANTITY) AS PEOPLE ";
  $sql .= ",(SELECT SUM(MALE_QUANTITY + FEMALE_QUANTITY) ";
  $sql .= "FROM VIEW_STAT_MOE_CITIZEN@L_STMOL ";
  $sql .= "WHERE ACADEMIC_YEAR = (SELECT MAX(ACADEMIC_YEAR) FROM VIEW_STAT_MOE_CITIZEN@L_STMOL) ";
  $sql .= "AND AGE BETWEEN 15 AND 60) TOTAL ";
  $sql .= ",(SELECT COUNT(TDT.PERSONAL_ID) from DB_MOL.TRT_DSD_TRAINING TDT ";
  $sql .= "LEFT JOIN DB_MOL.LKU_DSD_TRAINING_COURSE LDTC ON TDT.TRAINING_ID = LDTC.TRAINING_ID ";
  $sql .= "LEFT JOIN DB_MOL.STD_TRAIN_COURSE STC ON LDTC.TRAIN_COURSE_CODE = STC.TRAIN_COURSE_CODE ";
  $sql .= "WHERE TDT.STATUS_ATTEND = '1' ";
  $sql .= "AND LDTC.TARGET_BUDGET_YEAR = '".$_REQUEST['year']."' ";
  $sql .= "AND STC.LAW_OCCUPATION_CODE = '".$_REQUEST['branch']."' ";
  $sql .= "AND STC.TRAIN_OCCUPATION_GROUP_CODE = '".$_REQUEST['occupation']."') ATTEND ";
  $sql .= ",(SELECT COUNT(TDT.PERSONAL_ID) from DB_MOL.TRT_DSD_TRAINING TDT ";
  $sql .= "LEFT JOIN DB_MOL.LKU_DSD_TRAINING_COURSE LDTC ON TDT.TRAINING_ID = LDTC.TRAINING_ID ";
  $sql .= "LEFT JOIN DB_MOL.STD_TRAIN_COURSE STC ON LDTC.TRAIN_COURSE_CODE = STC.TRAIN_COURSE_CODE ";
  $sql .= "WHERE TDT.STATUS_GRADUATE = '1' ";
  $sql .= "AND LDTC.TARGET_BUDGET_YEAR = '".$_REQUEST['year']."' ";
  $sql .= "AND STC.LAW_OCCUPATION_CODE = '".$_REQUEST['branch']."' ";
  $sql .= "AND STC.TRAIN_OCCUPATION_GROUP_CODE = '".$_REQUEST['occupation']."') GRADUATE ";
  $sql .= "FROM VIEW_STAT_MOE_CITIZEN@L_STMOL MSC ";
  $sql .= "WHERE MSC.ACADEMIC_YEAR = (SELECT MAX(ACADEMIC_YEAR) FROM VIEW_STAT_MOE_CITIZEN@L_STMOL)  ";
  $sql .= "AND MSC.AGE BETWEEN 15 AND 60 ";
  $sql .= "GROUP BY MSC.PROVINCE_CODE) WhatIFTrain ";
  $sql .= "RIGHT JOIN DB_MOL.GIS_PROVINCE GP ON WhatIFTrain.PROVINCE_CODE = GP.PROVINCE_CODE ";
  $sql .= "ORDER BY WhatIFTrain.PROVINCE_CODE ";

  $result = oci_parse($conn, $sql);
  $r = oci_execute($result);
  if (!$r) {
    echo "[]";
    exit();
  }

  $res = array();

  while (($row = oci_fetch_array($result, OCI_BOTH)) != false) {
    if (!isset($minVal)) {
      $minVal = intval($row["VALTRAIN"]);
      $maxVal = intval($row["VALTRAIN"]);
    }
    if (intval($row["VALTRAIN"]) > $maxVal) {
      $maxVal = intval($row["VALTRAIN"]);
    }
    if (intval($row["VALTRAIN"]) < $minVal) {
      $minVal = intval($row["VALTRAIN"]);
    }
    $res[] =  array(
      "code" => $row["PROVINCE_CODE"],
      "cnt" => $row["VALTRAIN"]
    );
  }

  echo json_encode(array(
    'data' => $res,
    'intervals' => IntervalInt($minVal, $maxVal, 5)
  ));
  oci_free_statement($result);
  oci_close($conn);                        
?>