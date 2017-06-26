<?php
  
  include '../../config/database.php';
  include '../../helpers/share_func.php';
  $conn = connectionOracleDB();

  if ($_REQUEST['type'] == 'tambon') {
    $province_code = substr($_REQUEST['code'], 0,2);
    $amphoe_code = substr($_REQUEST['code'], 2,2);
  }


  if ($_REQUEST['type'] == 'province') {
    $sql = "SELECT WhatIFTest.PROVINCE_CODE AS CODE ";
  }

  if ($_REQUEST['type'] == 'amphoe') {
    $sql = "SELECT WhatIFTest.AMPHUR_CODE AS CODE";
  }

  if ($_REQUEST['type'] == 'tambon') {
    $sql = "SELECT WhatIFTest.TUMBON_CODE AS CODE";
  }

  $sql .= ",ROUND((((PEOPLE / TOTAL)* ".$_REQUEST['num'].") / ((GRADUATE / ATTEND) * 100)) * 100) AS CNT ";

  if ($_REQUEST['type'] == 'province') {
    $sql .= "FROM(SELECT MSC.PROVINCE_CODE,SUM(MSC.MALE_QUANTITY + MSC.FEMALE_QUANTITY) AS PEOPLE ";
  }
  if ($_REQUEST['type'] == 'amphoe') {
    $sql .= "FROM(SELECT MSC.AMPHUR_CODE,SUM(MSC.MALE_QUANTITY + MSC.FEMALE_QUANTITY) AS PEOPLE ";
  }
  if ($_REQUEST['type'] == 'tambon') {
    $sql .= "FROM(SELECT MSC.TUMBON_CODE,SUM(MSC.MALE_QUANTITY + MSC.FEMALE_QUANTITY) AS PEOPLE ";
  }

  $sql .= ",(SELECT SUM(MALE_QUANTITY + FEMALE_QUANTITY) ";

  if ($_REQUEST['type'] == 'province') {
    $sql .= "FROM VIEW_STAT_MOE_CITIZEN@L_STMOL ";
    $sql .= "WHERE ACADEMIC_YEAR = (SELECT MAX(ACADEMIC_YEAR) FROM VIEW_STAT_MOE_CITIZEN@L_STMOL) ";
    $sql .= "AND AGE BETWEEN 15 AND 60 AND PROVINCE_CODE in (21,20,24) ) TOTAL ";
  }
  if ($_REQUEST['type'] == 'amphoe') {
    $sql .= "FROM VIEW_STAT_MOE_CITIZEN@L_STMOL ";
    $sql .= "WHERE ACADEMIC_YEAR = (SELECT MAX(ACADEMIC_YEAR) FROM VIEW_STAT_MOE_CITIZEN@L_STMOL ";
    $sql .= " where PROVINCE_CODE=".$_REQUEST['code'].") ";
    $sql .= "AND AGE BETWEEN 15 AND 60 AND PROVINCE_CODE = ".$_REQUEST['code'].") TOTAL";
  }
  if ($_REQUEST['type'] == 'tambon') {
    $sql .= "FROM VIEW_STAT_MOE_CITIZEN@L_STMOL ";
    $sql .= "WHERE ACADEMIC_YEAR = (SELECT MAX(ACADEMIC_YEAR) FROM VIEW_STAT_MOE_CITIZEN@L_STMOL ";
    $sql .= " where AMPHUR_CODE=".$amphoe_code." and PROVINCE_CODE = ".$province_code.") ";
    $sql .= "AND AGE BETWEEN 15 AND 60 AND AMPHUR_CODE = ".$amphoe_code." and PROVINCE_CODE = ".$province_code.") TOTAL";
  }

  $sql .= ",(SELECT COUNT(TDT.PERSONAL_ID) AS CATT FROM DB_MOL.TRT_DSD_TESTING TDT ";
  $sql .= "LEFT JOIN DB_MOL.LKU_DSD_TESTING_COURSE LDTC ";
  $sql .= "ON TDT.TESTING_ID = LDTC.TESTING_ID LEFT JOIN DB_MOL.LKU_DSD_DEPT LDD ON LDTC.DEPT_CODE = LDD.DEPT_ID ";
  $sql .= "LEFT JOIN DB_MOL.STD_TEST_COURSE STC ON LDTC.TEST_COURSE_CODE = STC.TEST_COURSE_CODE ";
  $sql .= "WHERE TDT.STATUS_ATTEND = '1' ";
  $sql .= "AND LDTC.TARGET_BUDGET_YEAR = '".$_REQUEST['year']."' ";
  $sql .= "AND STC.LAW_OCCUPATION_CODE = '".$_REQUEST['branch']."' ";
  $sql .= "AND LDTC.TEST_COURSE_CODE = '".$_REQUEST['occupation']."') ATTEND ";
  $sql .= ",(SELECT COUNT(TDT.PERSONAL_ID) AS CGRA FROM DB_MOL.TRT_DSD_TESTING TDT ";
  $sql .= "LEFT JOIN DB_MOL.LKU_DSD_TESTING_COURSE LDTC ON TDT.TESTING_ID = LDTC.TESTING_ID ";
  $sql .= "LEFT JOIN DB_MOL.LKU_DSD_DEPT LDD ON LDTC.DEPT_CODE = LDD.DEPT_ID LEFT JOIN DB_MOL.STD_TEST_COURSE STC ";
  $sql .= "ON LDTC.TEST_COURSE_CODE = STC.TEST_COURSE_CODE ";
  $sql .= "WHERE TDT.STATUS_GRADUATE = '1' ";
  $sql .= "AND LDTC.TARGET_BUDGET_YEAR = '".$_REQUEST['year']."' ";
  $sql .= "AND STC.LAW_OCCUPATION_CODE = '".$_REQUEST['branch']."' ";
  $sql .= "AND LDTC.TEST_COURSE_CODE = '".$_REQUEST['occupation']."') GRADUATE ";

  if ($_REQUEST['type'] == 'province') {
    $sql .= " FROM VIEW_STAT_MOE_CITIZEN@L_STMOL MSC ";
    $sql .= " WHERE MSC.ACADEMIC_YEAR = (SELECT MAX(ACADEMIC_YEAR) FROM VIEW_STAT_MOE_CITIZEN@L_STMOL";
    $sql .= "  where PROVINCE_CODE in (21,20,24)) and PROVINCE_CODE in (21,20,24)";
    $sql .= " AND MSC.AGE BETWEEN 15 AND 60 ";
    $sql .= " GROUP BY MSC.PROVINCE_CODE) WhatIFTest ";
  }
  if ($_REQUEST['type'] == 'amphoe') {
    $sql .= " FROM VIEW_STAT_MOE_CITIZEN@L_STMOL MSC ";
    $sql .= " WHERE MSC.ACADEMIC_YEAR = (SELECT MAX(ACADEMIC_YEAR) FROM VIEW_STAT_MOE_CITIZEN@L_STMOL";
    $sql .= "  where PROVINCE_CODE=".$_REQUEST['code'].") and PROVINCE_CODE=".$_REQUEST['code'];
    $sql .= " AND MSC.AGE BETWEEN 15 AND 60 ";
    $sql .= " GROUP BY MSC.AMPHUR_CODE) WhatIFTest ";
  }
  if ($_REQUEST['type'] == 'tambon') {
    $sql .= " FROM VIEW_STAT_MOE_CITIZEN@L_STMOL MSC ";
    $sql .= " WHERE MSC.ACADEMIC_YEAR = (SELECT MAX(ACADEMIC_YEAR) FROM VIEW_STAT_MOE_CITIZEN@L_STMOL";
    $sql .= "  where AMPHUR_CODE=".$amphoe_code." and PROVINCE_CODE = ".$province_code.") and AMPHUR_CODE=".$amphoe_code. " and PROVINCE_CODE = ".$province_code;
    $sql .= " AND MSC.AGE BETWEEN 15 AND 60 ";
    $sql .= " GROUP BY MSC.TUMBON_CODE) WhatIFTest ";
  } 

  $result = oci_parse($conn, $sql);
  $r = oci_execute($result);
  if (!$r) {
    echo "[]";
    exit();
  }

  $res = array();

  while (($row = oci_fetch_array($result, OCI_BOTH)) != false) {
    if (!isset($minVal)) {
      $minVal = intval($row["CNT"]);
      $maxVal = intval($row["CNT"]);
    }
    if (intval($row["CNT"]) > $maxVal) {
      $maxVal = intval($row["CNT"]);
    }
    if (intval($row["CNT"]) < $minVal) {
      $minVal = intval($row["CNT"]);
    }

    $res[] =  array(
      "code" => $_REQUEST['code'].$row["CODE"],
      "cnt" => $row["CNT"]
    );
  }

  if (count($res) == 0) {
    echo "[]";
  } else {
    echo json_encode(array(
      'data' => $res,
      'intervals' => IntervalInt($minVal, $maxVal, 5)
    ));
  }

  oci_free_statement($result);
  oci_close($conn);                        
?>