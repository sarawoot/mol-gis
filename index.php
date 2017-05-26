<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>.: MOL-EDW Template :.</title>
  <link rel="shortcut icon" href="assets/images/favicon.ico">
  <link rel="stylesheet" href="vendor/assets/javascripts/bootstrap-3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="vendor/assets/javascripts/bootstrap-3.3.7/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="vendor/assets/javascripts/ol-4.1.0/ol.css">
  <link rel="stylesheet" href="vendor/assets/javascripts/ol3-popup/src/ol3-popup.css">
  <link rel="stylesheet" href="vendor/assets/stylesheets/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="vendor/assets/javascripts/jstree/dist/themes/proton/style.min.css">
  <link rel="stylesheet" href="assets/stylesheets/menu.css">
  <link rel="stylesheet" href="assets/stylesheets/style.css">
  <style>
    .ol-popup {
      bottom: 40px !important;
    }

    .mouse-position{
      position: absolute;
      z-index: 1000;
      bottom: 60px;
      right: 80px;
      width: 250px;
    }
  </style>
</head>
<body>
  <?php require 'templates/nav.php'; ?>

  <div class="row main-row">
    <div class="col-sm-5 col-md-4 sidebar sidebar-left pull-left">
      <div class="panel-group sidebar-body">
        <div class="panel-group" id="leftMenu" role="tablist" aria-multiselectable="true">

           <?php require 'templates/layer_panel.php'; ?>
           <?php require 'templates/buffer_panel.php'; ?>
           <?php require 'templates/what_if_panel.php'; ?>
           <?php require 'templates/result_panel.php'; ?>
           <?php require 'templates/layer_search.php'; ?>

        </div>
      </div>
    </div>
  </div>
  <div class="mini-submenu mini-submenu-left pull-left">
    <i class="fa fa-list-alt"></i>
  </div>

  <div id="map"></div>
  <?php require 'templates/map_tools.php'; ?>

  <div class="mouse-position" id="mapPosition"></div>

  <!-- script -->
  <script src="vendor/assets/javascripts/lodash.min.js"></script>
  <script src="vendor/assets/javascripts/pace.min.js"></script>
  <script src="vendor/assets/javascripts/ol-4.1.0/ol.js"></script>
  <script src="vendor/assets/javascripts/ol3-popup/src/ol3-popup.js"></script>
  <script src="vendor/assets/javascripts/jquery/jquery.min.js"></script>  
  <script src="vendor/assets/javascripts/jstree/dist/jstree.js"></script>
  <script src="vendor/assets/javascripts/bootstrap-3.3.7/js/bootstrap.min.js"></script>
  <script src="assets/javascripts/config.js"></script>
  <script src="assets/javascripts/share.js"></script>
  <script src="assets/javascripts/menu.js"></script>
  <script src="assets/javascripts/map.js"></script>
  <script src="assets/javascripts/measure.js"></script>
  <script src="assets/javascripts/layer_switcher.js"></script>
  <script src="assets/javascripts/buffer.js"></script>
  <script src="assets/javascripts/what_if.js"></script>
  <script src="assets/javascripts/map_tool.js"></script>
  <script src="assets/javascripts/layer_search.js"></script>
  <script src="assets/javascripts/search.js"></script>
</body>
</html>