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
  <nav class="navbar navbar-fixed-top navbar-default nav-mol" role="navigation" >
    <div class="navbar-header">
      <a href="./">
        <img src="assets/images/header_l.png">
      </a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav navbar-right nav-mol-basemap nav-mol-r">
        <li class="dropdown" style="float: right;">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span data-type="label_layer"></span> <b class="caret"></b></a>
          <ul class="dropdown-menu" data-type="container_layers" style="z-index:46;">
            
          </ul>
        </li>
      </ul>
    </div>
  </nav>

  <div class="row main-row">
    <div class="col-sm-4 col-md-3 sidebar sidebar-left pull-left">
      <div class="panel-group sidebar-body">
        <div class="panel-group" id="leftMenu" role="tablist" aria-multiselectable="true">
          <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingLayer">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#leftMenu" href="#collapseLayer" aria-expanded="true" aria-controls="collapseLayer">
                  <i class="fa fa-list-alt"></i>
                  ชั้นข้อมูล
                </a>
                <span class="pull-right slide-submenu">
                  <i class="fa fa-chevron-left"></i>
                </span>
              </h4>
            </div>
            <div id="collapseLayer" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingLayer">
              <div class="panel-body" style="height:350px;overflow:auto;padding:1px">
                <input type="text" class="form-control" placeholder="ค้นหา" id="searchLayerSwitcher">
                <div id="layerSwitcher"></div>
              </div>
            </div>
          </div>

          <div class="panel panel-default" id="panelBuffer" style="display: none;">
            <div class="panel-heading" role="tab" id="headingBuffer">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#leftMenu" href="#collapseBuffer" aria-expanded="true" aria-controls="collapseBuffer">
                  <i class="fa fa-list-alt"></i>
                  วิเคราะห์ข้อมูล
                </a>

              </h4>
            </div>
            <div id="collapseBuffer" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingBuffer">
              <div class="panel-body" style="height:450px;overflow:auto;">
                
                <form>
                  <div class="form-group">
                    <label for="bufferType">เลือกข้อมูล</label>
                    <select id="bufferType" class="form-control">
                      <option value="hospital">ตำแหน่งโรงพยาบาล</option>
                      <option value="unemployed">ลงทะเบียนหางาน</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="bufferLat">ละติจูด</label>
                    <input type="text" class="form-control" id="bufferLat" placeholder="ละติจูด">
                  </div>
                  <div class="form-group">
                    <label for="bufferLat">ลองติจูด</label>
                    <input type="text" class="form-control" id="bufferLng" placeholder="ลองติจูด">
                  </div>
                  <div class="form-group">
                    <label for="bufferLat">กำหนดรัศมี</label>
                    <div class="input-group">
                      <input type="text" class="form-control" id="bufferDistance" placeholder="รัศมี">
                      <span class="input-group-addon">กิโลเมตร</span>
                    </div>
                  </div>                
                  
                  <button type="button" class="btn btn-primary" id="confirmBuffer">ยืนยัน</button> 
                </form>

              </div>
            </div>
          </div>

          <div class="panel panel-default" id="panelResult" style="display: none;">
            <div class="panel-heading" role="tab" id="headingResult">
              <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#leftMenu" href="#collapseResult" aria-expanded="true" aria-controls="collapseResult">
                  <i class="fa fa-list-alt"></i>
                  ผลลัพธ์
                </a>

              </h4>
            </div>
            <div id="collapseResult" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingResult">
              <div class="panel-body" style="height:450px;overflow:auto;padding:0px;">
                
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <div class="mini-submenu mini-submenu-left pull-left">
    <i class="fa fa-list-alt"></i>
  </div>
  <div id="map"></div>
  <div id="mapToolbar" style="z-index:45;position:absolute;top:95px;right:10px">
    <div class="btn-group" data-toggle="buttons">
      <label class="btn btn-default icom-sm" data-toggle="tooltip" data-placement="bottom" title="กลับสู่ประเทศไทย">
        <input type="radio" name="mapTool" autocomplete="off" value="home">
        <span class="glyphicon icon-home"></span>
      </label>
      <label class="btn btn-default icom-sm active" data-toggle="tooltip" data-placement="bottom" title="Pan">
        <input type="radio" name="mapTool" autocomplete="off" checked value="pan">
        <span class="glyphicon icon-pan"></span>
      </label>
      <label class="btn btn-default icom-sm" data-toggle="tooltip" data-placement="bottom" title="ล้างค่า">
        <input type="radio" name="mapTool" autocomplete="off" value="clear">
        <span class="glyphicon icon-clear"></span>
      </label>
      <label class="btn btn-default icom-sm" data-toggle="tooltip" data-placement="bottom" title="วัดระยะทาง">
        <input type="radio" name="mapTool" autocomplete="off" value="measure-distance">
        <span class="glyphicon icon-measure-distance"></span>
      </label>
      <label class="btn btn-default icom-sm" data-toggle="tooltip" data-placement="bottom" title="วัดขนาดพื้นที่">
        <input type="radio" name="mapTool" autocomplete="off" value="measure-area">
        <span class="glyphicon icon-measure-area"></span>
      </label>
      <label class="btn btn-default icom-sm" data-toggle="tooltip" data-placement="bottom" title="ค้นหาข้อมมูล">
        <input type="radio" name="mapTool" autocomplete="off" value="search">
        <span class="glyphicon icon-search"></span>
      </label>
      <label class="btn btn-default icom-sm" data-toggle="tooltip" data-placement="bottom" title="รายงานเชิงวิเคราะห์">
        <input type="radio" name="mapTool" autocomplete="off" value="what-if">
        <span class="glyphicon icon-what-if"></span>
      </label>
      <label class="btn btn-default icom-sm" data-toggle="tooltip" data-placement="bottom" title="วิเคราะห์ข้อมูล">
        <input type="radio" name="mapTool" autocomplete="off" value="buffer">
        <span class="glyphicon icon-buffer"></span>
      </label>

    </div>      
  </div>

  <div class="mouse-position" id="mapPosition"></div>

  <!-- script -->
  <script src="vendor/assets/javascripts/lodash.min.js"></script>
  <script src="vendor/assets/javascripts/pace.min.js"></script>
  <script src="vendor/assets/javascripts/ol-4.1.0/ol.js"></script>
  <script src="vendor/assets/javascripts/ol3-popup/src/ol3-popup.js"></script>
  <script src="vendor/assets/javascripts/jquery/jquery.min.js"></script>  
  <script src="vendor/assets/javascripts/jstree/dist/jstree.js"></script>
  <script src="vendor/assets/javascripts/bootstrap-3.3.7/js/bootstrap.min.js"></script>
  <script src="assets/javascripts/share.js"></script>
  <script src="assets/javascripts/menu.js"></script>
  <script src="assets/javascripts/map.js"></script>
  <script src="assets/javascripts/measure.js"></script>
  <script src="assets/javascripts/layer_switcher.js"></script>
  <script src="assets/javascripts/map_tool.js"></script>
</body>
</html>