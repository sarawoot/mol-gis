<?php
header('Content-type: text/plain; charset=utf-8');
include ("../config/database.php");
require ("../helpers/share_func.php");
require ("../helpers/search.php");
require_once ('../config/static.php');

$conn = connectionOracleDBUTF();

$param = array_merge($_GET, [
    'CWT_CODE' => $_GET['prov_code'],'ap_idn' => $_GET['ap_idn']
]);

$sql = genSql($param);
$result = oci_parse($conn, $sql);
oci_execute($result);

$row = oci_fetch_array($result, OCI_BOTH);
$n = explode('.', $row['CNT']);

$k_province = '';
if (isset($_GET['prov_code'])){
  if (! empty($_GET['prov_code'])){
    $k_province = $_GET['prov_code'];
  }
}
if (isset($_GET['province'])){
  if (! empty($_GET['province'])){
    $k_province = $_GET['province'];
  }
}

$ampur = '';
if (isset($row['AMP_DESC'])){
  $ampur = 'อำเภอ' . $row['AMP_DESC'] . ' ';
}

$tumbol = '';
if (isset($row['TMB_DESC'])){
  $tumbol = 'ตำบล' . $row['TMB_DESC'] . ' ';
}

echo $tumbol, $ampur, 'จังหวัด', $procince_conf[$k_province], ' : ', number_format((( int ) $n[0])), (isset($n[1]) ? '.' . ($n[1]) : '');
oci_free_statement($result);
oci_close($conn);
?>