<?php
function genSql($param){
  $sql = '';
  $param['formSearch'] = ( int ) $param['formSearch'];
  $tbl = '';
  if ($param['formSearch'] == 7){
    $select = 'STD_LOCATION.province_code AS CWT_CODE,STD_LOCATION.province_name AS CWT_DESC
            ,COUNT(CMN_PERSONAL.PERSONAL_ID) AS cnt';
    $where = '';
    $group_by = ' STD_LOCATION.province_code,STD_LOCATION.province_name';
    if (isset($param["CWT_CODE"]))
      if (! empty($param["CWT_CODE"]))
        $where .= " AND province_code = '" . ( int ) $param["CWT_CODE"] . "'";
    
    if (isset($param["province"])){
      if (! empty($param["province"])){
        $where .= " AND province_code = '" . ( int ) $param["province"] . "'";
        $select = " STD_LOCATION.province_code AS CWT_CODE,STD_LOCATION.province_name AS CWT_DESC
                  ,STD_LOCATION.amphur_code AS AMP_CODE, STD_LOCATION.amphur_name AS AMP_DESC,COUNT(CMN_PERSONAL.PERSONAL_ID) AS cnt";
        $group_by = ' STD_LOCATION.province_code,STD_LOCATION.province_name
                      ,STD_LOCATION.amphur_code, STD_LOCATION.amphur_name';
      }
    }
    
    if (isset($param['amphur'])){
      if (! empty($param["amphur"])){
        $select = "STD_LOCATION.province_code AS CWT_CODE,STD_LOCATION.province_name AS CWT_DESC
                    ,STD_LOCATION.amphur_code AS AMP_CODE, STD_LOCATION.amphur_name AS AMP_DESC
                    ,STD_LOCATION.tumbon_code AS TMB_CODE, STD_LOCATION.tumbon_name AS TMB_DESC
                    ,COUNT(CMN_PERSONAL.PERSONAL_ID) AS CNT";
        $group_by = " STD_LOCATION.province_code,STD_LOCATION.province_name,STD_LOCATION.amphur_code, STD_LOCATION.amphur_name,
            STD_LOCATION.tumbon_code , STD_LOCATION.tumbon_name";
        $where .= " AND amphur_code = '" . ( int ) $param["amphur"] . "'";
      }
    }
    
    if (isset($_GET['ap_idn'])){
      if (! empty($_GET['ap_idn'])){
        $ap_idn = substr($_GET['ap_idn'], 2, strlen($_GET['ap_idn']) - 2);
        $select = "STD_LOCATION.province_code AS CWT_CODE,STD_LOCATION.province_name AS CWT_DESC
                ,STD_LOCATION.amphur_code AS AMP_CODE, STD_LOCATION.amphur_name AS AMP_DESC
                ,COUNT(CMN_PERSONAL.PERSONAL_ID) AS CNT";
        $group_by = ' STD_LOCATION.province_code,STD_LOCATION.province_name
                      ,STD_LOCATION.amphur_code, STD_LOCATION.amphur_name';
        $where .= " AND amphur_code = '" . ( int ) $ap_idn . "'";
      }
    }
    
    $sql = "SELECT $select
            FROM CMN_PERSONAL@L_DBMOL
            INNER JOIN CMN_PERSONAL_ADDRESS@L_DBMOL ON CMN_PERSONAL.PERSONAL_ID = CMN_PERSONAL_ADDRESS.PERSONAL_ID
            INNER JOIN STD_LOCATION@L_DBMOL ON CMN_PERSONAL_ADDRESS.addr_register_location = STD_LOCATION.location_code
            WHERE (EXTRACT(YEAR FROM sysdate)+543) - personal_birthday_yearthai >59 $where
            and personal_birthday_yearthai not between 0 and 2439
            and CMN_PERSONAL.record_use_status =1
            and CMN_PERSONAL.record_cleansing_status ='A'
            and length(personal_birthday_yearthai) = 4
            AND STD_LOCATION.province_code NOT IN (00,99)
            GROUP BY $group_by";
    // echo $sql;
  }elseif ($param['formSearch'] == 14){
    $select = 'SL.PROVINCE_CODE AS CWT_CODE,SL.PROVINCE_NAME AS CWT_DESC
            ,COUNT(TDR.PERSONAL_ID) AS cnt';
    $where = '';
    $group_by = ' SL.province_code,SL.province_name';
    
    if (isset($param["YEARS"])){
      if (! empty($param["YEARS"])){
        $where .= " AND (EXTRACT(YEAR FROM TDR.PROCESS_DATE) + 543 ) = " . ( int ) $param["YEARS"];
        ;
      }
    }
    
    $pcode = '';
    if (isset($param["CWT_CODE"]) || isset($param['province'])){
      if (! empty($param["CWT_CODE"])){
        $pcode = $param["CWT_CODE"];
      }
      
      if (! empty($param["province"])){
        $pcode = $param["province"];
      }
      
      if ($pcode != ''){
        $select = 'SL.PROVINCE_CODE ,SL.PROVINCE_NAME,SL.AMPHUR_CODE ,SL.AMPHUR_NAME ,COUNT(TDR.PERSONAL_ID) AS cnt';
        $group_by = 'SL.PROVINCE_CODE ,SL.PROVINCE_NAME,SL.AMPHUR_CODE ,SL.AMPHUR_NAME ';
        require_once ("../config/static.php");
        $where .= " AND SL.PROVINCE_CODE = " . ( int ) $pcode;
        if (isset($param['ap_idn'])){
          if (! empty($param['ap_idn'])){
            $where .= " AND SL.AMPHUR_CODE = '" . substr($param['ap_idn'], 2, 2) . "'";
          }
        }
      }
    }
    
    if (isset($param["PROVINCE_GROUP_CODE"]) && $pcode == ''){
      if (! empty($param["PROVINCE_GROUP_CODE"])){
        require_once ("../config/static.php");
        $where .= " AND SL.PROVINCE_CODE IN (" . implode(',', $province_id_array[$param["PROVINCE_GROUP_CODE"]]) . ") ";
      }
    }
    
    if (isset($_GET['pop'])){
      if ($_GET['pop'] == 1){
        if (isset($_GET['prov_code'])){
          if (! empty($_GET['prov_code'])){
            $select = 'SL.PROVINCE_CODE AS CWT_CODE,SL.PROVINCE_NAME AS CWT_DESC
            ,COUNT(TDR.PERSONAL_ID) AS cnt';
            $group_by = ' SL.PROVINCE_CODE,SL.PROVINCE_NAME';
          }
        }
      }
    }
    
    $sql = "SELECT $select FROM DB_MOL.TRT_DOAE_REGISTER TDR 
            INNER JOIN DB_MOL.CMN_PERSONAL_ADDRESS CPA ON TDR.PERSONAL_ID = CPA.PERSONAL_ID 
            INNER JOIN DB_MOL.STD_LOCATION SL ON CPA.ADDR_REGISTER_LOCATION = SL.LOCATION_CODE 
            WHERE  1=1 $where
            GROUP BY $group_by ";
    // echo $sql;
  }else{
    switch($param['formSearch']){
      case 1 :
        $tbl = 'VIEW_GIS_DOE_DISABILITY';
        $sum_field = 'DISABILITY_AMT';
        break;
      case 2 :
        $tbl = 'VIEW_GIS_DSD_PASS_TRAINING';
        $sum_field = 'PASS_TRAIN_AMT';
        break;
      case 3 :
        $tbl = 'VIEW_GIS_DSD_PASS_TESTING';
        $sum_field = 'PASS_TEST_AMT';
        break;
      case 4 :
        $tbl = 'VIEW_GIS_DOE_JOB_VACANCY';
        $sum_field = 'VACANCY_AMT';
        break;
      case 5 :
        $tbl = 'VIEW_GIS_SSO_INSURED_M33';
        $sum_field = 'M33_AMT';
        break;
      case 6 :
        $tbl = 'VIEW_GIS_SSO_INSURED_M40';
        $sum_field = 'M40_AMT';
        break;
      case 8 :
        $tbl = 'VIEW_GIS_STAT_NSO_DISABILITY';
        $sum_field = 'WEIGHT_AMT';
        break;
      case 9 :
        $tbl = 'VIEW_GIS_STAT_NSO_ELDER';
        $sum_field = 'WEIGHT_AMT';
        break;
      case 10 :
        $tbl = 'VIEW_GIS_STAT_NSO_MONTHLY';
        $sum_field = 'WEIGHT_AMT';
        break;
      case 11 :
        $tbl = 'VIEW_GIS_STAT_NSO_QUARTER';
        $sum_field = 'WEIGHT_AMT';
        break;
      case 12 :
        $tbl = 'VIEW_GIS_STAT_NSO_INFORMAL_WK';
        $sum_field = 'WEIGHT_AMT';
        break;
      case 13 :
        $tbl = 'VIEW_GIS_DOE_FOREIGN_WORKER';
        $sum_field = 'FOREIGN_AMT';
        break;
      
      default :
        $tbl = 'VIEW_GIS_STAT_NSO_DISABILITY';
        $sum_field = 'WEIGHT_AMT';
        break;
    }
    $form_array = [
        1,2,3,4,5,6,7,8,9,10,11,12,13
    ];
    
    switch(true){
      case (in_array($param['formSearch'], $form_array)) :
      default :
        $sql = " SELECT  sum($sum_field)cnt ,CWT_CODE,CWT_DESC FROM $tbl WHERE 1=1 ";
        
        if (isset($param["MONTH_CODE"])){
          if (! empty($param["MONTH_CODE"]))
            $sql .= " AND MONTH_CODE = '" . replace_str($param["MONTH_CODE"]) . "'";
        }
        if (isset($param["GRAD_EDU"])){
          if (! empty($param["GRAD_EDU"]))
            $sql .= " AND GRAD_EDU = '" . replace_str($param["GRAD_EDU"]) . "'";
        }
        if (isset($param["DISABILTIY_TYPE"])){
          if (! empty($param["DISABILTIY_TYPE"]))
            $sql .= " AND DISABILTIY_TYPE = '" . replace_str($param["DISABILTIY_TYPE"]) . "'";
        }
        if (isset($param["FOREIGN_TYPE_CODE"])){
          if (! empty($param["GRFOREIGN_TYPE_CODEAD_EDU"]))
            $sql .= " AND FOREIGN_TYPE_CODE = '" . replace_str($param["FOREIGN_TYPE_CODE"]) . "'";
        }
        if (isset($param["LAW_OCCUPATION_CODE"])){
          if (! empty($param["LAW_OCCUPATION_CODE"]))
            $sql .= " AND LAW_OCCUPATION_CODE = '" . ( int ) $param["LAW_OCCUPATION_CODE"] . "'";
        }
        
        if (isset($param["TRAIN_ACTIVITY_CODE"])){
          if (! empty($param["TRAIN_ACTIVITY_CODE"]))
            $sql .= " AND TRAIN_ACTIVITY_CODE = '" . ( int ) $param["TRAIN_ACTIVITY_CODE"] . "'";
        }
        
        if (isset($param["CWT_CODE"])){
          if (! empty($param["CWT_CODE"]))
            $sql .= " AND CWT_CODE = '" . ( int ) $param["CWT_CODE"] . "'";
        }
        
        if (isset($param["YEAR_TH"])){
          if (! empty($param["YEAR_TH"]))
            $sql .= " AND YEAR_TH = '" . ( int ) $param["YEAR_TH"] . "'";
        }
        if (isset($param["YEARS"])){
          if (! empty($param["YEARS"]))
            $sql .= " AND YEARS = '" . ( int ) $param["YEARS"] . "'";
        }
        if (isset($param["DISABILITY_GROUP_CODE"])){
          if (! empty($param["DISABILITY_GROUP_CODE"]))
            $sql .= " AND DISABILITY_GROUP_CODE = '" . replace_str($param["DISABILITY_GROUP_CODE"]) . "'";
        }
        
        if (isset($param["DISABILITY_TYPE_CODE"])){
          if (! empty($param["DISABILITY_TYPE_CODE"]))
            $sql .= " AND DISABILITY_TYPE_CODE = '" . replace_str($param["DISABILITY_TYPE_CODE"]) . "'";
        }
        
        if (isset($param["MONTH_CODE"])){
          if (! empty($param["MONTH_CODE"]))
            $sql .= " AND MONTH_CODE = " . ( int ) $param["MONTH_CODE"];
        }
        
        if (isset($param["QUARTER"])){
          if (! empty($param["QUARTER"]))
            $sql .= " AND QUARTER = " . ( int ) $param["QUARTER"];
        }
        
        $sql .= " GROUP BY CWT_CODE,CWT_DESC";
        break;
    }
  }
  // echo $sql;
  // exit();
  return $sql;
}
function get_year_list($formSearch = 1){
  global $conn;
  if (! isset($conn)){
    require_once ("../../config/database.php");
    $conn = connectionOracleDBUTF();
  }
  $YEARS = [
      2 => 'VIEW_GIS_DSD_PASS_TRAINING',3 => 'VIEW_GIS_DSD_PASS_TESTING',4 => 'VIEW_GIS_DOE_JOB_VACANCY',5 => 'VIEW_GIS_SSO_INSURED_M33',6 => 'VIEW_GIS_SSO_INSURED_M40',10 => 'VIEW_GIS_STAT_NSO_MONTHLY',11 => 'VIEW_GIS_STAT_NSO_QUARTER',12 => 'VIEW_GIS_STAT_NSO_INFORMAL_WK',
      13 => 'VIEW_GIS_DOE_FOREIGN_WORKER'
  ];
  $YEAR_TH = [
      8 => 'VIEW_GIS_STAT_NSO_DISABILITY',9 => 'VIEW_GIS_STAT_NSO_ELDER'
  ];
  $f = 'YEARS';
  $fs = 'YEARS';
  $tbl = '';
  if (array_key_exists($formSearch, $YEARS)){
    $tbl = $YEARS[$formSearch];
  }
  if (array_key_exists($formSearch, $YEAR_TH)){
    $tbl = $YEAR_TH[$formSearch];
    $f = 'YEAR_TH';
    $fs = 'YEAR_TH';
  }
  
  if ($formSearch == 14){
    $tbl = "DB_MOL.TRT_DOAE_REGISTER";
    $f = '(EXTRACT(YEAR FROM PROCESS_DATE) + 543 ) AS YEARS';
  }
  
  $sql = " SELECT  DISTINCT $f FROM $tbl ORDER BY $fs DESC";
  $result = oci_parse($conn, $sql);
  oci_execute($result);
  $y = [];
  while(($row = oci_fetch_array($result, OCI_BOTH)) != false){
    $y[] = $row[$fs];
  }
  return $y;
}

?>