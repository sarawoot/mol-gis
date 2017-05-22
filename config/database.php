<?php
  function connectionOracleDB() {
    putenv("NLS_LANG=AMERICAN_AMERICA.TH8TISASCII");
    $conn = oci_connect('DB_MOL', 'DBMOL', '192.168.0.167/molorcl');
    if (!$conn) {
      echo "Oracle error occurred.\n";
      exit;
    }
    return $conn;
  }
?>