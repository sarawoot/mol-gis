<?php
function connectionOracleDB(){
  putenv("NLS_LANG=AMERICAN_AMERICA.TH8TISASCII");
  $conn = oci_connect('ST_MOL', 'STMOL', '192.168.0.167/molorcl');
  if (! $conn){
    echo "Oracle error occurred.\n";
    exit();
  }
  return $conn;
}
function connectionOracleDBUTF(){
  putenv("NLS_LANG=AMERICAN_AMERICA.TH8TISASCII");
  $conn = oci_connect('ST_MOL', 'STMOL', '192.168.0.167/molorcl','AL32UTF8');
  if (! $conn){
    echo "Oracle error occurred.\n";
    exit();
  }
  return $conn;
}
function connectionDB(){
  $conn_string = "host=192.168.0.202 port=5432 dbname=oae user=postgres password=P@ssw0rd";
  $conn = pg_connect($conn_string);
  if (! $conn){
    echo "Postgresql error occurred.\n";
    exit();
  }
  return $conn;
}
?>