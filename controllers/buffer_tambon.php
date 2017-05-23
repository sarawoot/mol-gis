<?php
  require "../helpers/app.php";
  echo CallAPI('POST', 'http://gis.nlic.mol.go.th:6080/arcgis/rest/services/BufferTumbom/BufferTumbom/MapServer/0/query', $_POST);
  
?>