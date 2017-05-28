<?php
function genSql($param){
  $sql = '';
  $param['formSearch'] = ( int ) $param['formSearch'];
  $tbl = '';
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
  // echo $sql;
  return $sql;
}

?>