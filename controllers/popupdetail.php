<?php
header('Content-type: text/plain; charset=utf-8');
include ("../config/database.php");
require ("../helpers/share_func.php");
require ("../helpers/search.php");
require_once ('../config/static.php');

$conn = connectionOracleDBUTF();

$param = array_merge($_GET, [
    'CWT_CODE' => $_GET['prov_code']
]);

$sql = genSql($param);
$result = oci_parse($conn, $sql);
oci_execute($result);

$row = oci_fetch_array($result, OCI_BOTH);
$n = explode('.', $row['CNT']);
echo $procince_conf[$_GET['prov_code']], ' : ', number_format((( int ) $n[0])), '.', (( int ) $n[1]);
oci_free_statement($result);
oci_close($conn);
?>