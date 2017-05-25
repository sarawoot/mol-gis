<?php
function genSql(){
  $sql = '';
  $_GET['form'] = ( int ) $_GET['form'];
  $tbl = '';
  switch($_GET['form']){
    case 8 :
      $tbl = 'VIEW_GIS_STAT_NSO_DISABILITY';
      break;
    case 9 :
      $tbl = 'VIEW_GIS_STAT_NSO_ELDER';
      break;
    case 10 :
      $tbl = 'VIEW_GIS_STAT_NSO_MONTHLY';
      break;
    case 11 :
      $tbl = 'VIEW_GIS_STAT_NSO_QUARTER';
      break;
    case 12 :
      $tbl = 'VIEW_GIS_STAT_NSO_INFORMAL_WK';
      break;
    default :
      $tbl = 'VIEW_GIS_STAT_NSO_DISABILITY';
      break;
  }
  
  switch($_GET['form']){
    case 8 :
    case 9 :
    case 10 :
    case 11 :
    case 12 :
    default :
      $sql = " SELECT  sum(WEIGHT_AMT)cnt ,CWT_CODE,CWT_DESC FROM $tbl WHERE 1=1 ";
      
      if (isset($_GET["YEAR_TH"])){
        $sql .= " AND YEAR_TH = '" . ( int ) $_GET["YEAR_TH"] . "'";
      }
      if (isset($_GET["DISABILITY_GROUP_CODE"])){
        $sql .= " AND DISABILITY_GROUP_CODE = '" . replace_str($_GET["DISABILITY_GROUP_CODE"]) . "'";
      }
      
      if (isset($_GET["DISABILITY_TYPE_CODE"])){
        $sql .= " AND DISABILITY_TYPE_CODE = '" . replace_str($_GET["DISABILITY_TYPE_CODE"]) . "'";
      }
      
      if (isset($_GET["MONTH_CODE"])){
        $sql .= " AND MONTH_CODE = " . ( int ) $_GET["MONTH_CODE"];
      }
      
      if (isset($_GET["QUARTER"])){
        $sql .= " AND QUARTER = " . ( int ) $_GET["QUARTER"];
      }
      
      $sql .= " GROUP BY CWT_CODE,CWT_DESC";
      break;
  }
  return $sql;
}

?>