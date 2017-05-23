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
  <style>
    .nav-mol{
      height: 86px;
      background-image: url(assets/images/header_b.png);
      background-repeat: repeat-x;
      background-color: transparent;
      border-color: transparent;
    }

    .nav-mol-r{
      background-image: url(assets/images/header_r.png);
      background-repeat: no-repeat;
      height: 86px !important;
      width: 636px;
    }

    .pace {
      -webkit-pointer-events: none;
      pointer-events: none;

      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;

      z-index: 2000;
      position: fixed;
      margin: auto;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      height: 10px;
      width: 200px;
      background: #fff;
      border: 1px solid #29d;

      overflow: hidden;
    }

    .pace .pace-progress {
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      -ms-box-sizing: border-box;
      -o-box-sizing: border-box;
      box-sizing: border-box;

      -webkit-transform: translate3d(0, 0, 0);
      -moz-transform: translate3d(0, 0, 0);
      -ms-transform: translate3d(0, 0, 0);
      -o-transform: translate3d(0, 0, 0);
      transform: translate3d(0, 0, 0);

      max-width: 200px;
      position: fixed;
      z-index: 2000;
      display: block;
      position: absolute;
      top: 0;
      right: 100%;
      height: 100%;
      width: 100%;
      background: #29d;
    }

    .pace.pace-inactive {
      display: none;
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
      <ul class="nav navbar-nav navbar-right nav-mol-r">
      </ul>
    </div>
  </nav>
  

  <div class="row">
    <div class="col-md-8 col-sm-8" id="map" style="padding-top:86px;">
      
    </div>

    <div class="col-md-4 col-sm-4" style="padding-top:95px;padding-right:40px;">
      <h4 class="text-center">รายงานเชิงวิเคราะห์</h4>
      <p>เรื่อง การคาดการณ์ผู้สมัครพัฒนาฝีมือแรงงาน</p>

      <form>
        <div class="form-group">
          <label for="category">เรื่อง</label>
          <select id="category" class="form-control">
            <option value="train">การฝึกอบรมฝีมือแรงงาน</option>
            <option value="test">การทดสอบมาตรฐานฝีมือแรงงาน</option>
          </select>
        </div>
        <div class="form-group">
          <label for="branchOccupation">กลุ่มสาขาอาชีพ</label>
          <select id="branchOccupation" class="form-control">
          </select>
        </div>
        <div class="form-group">
          <label for="occupation">กลุ่มอาชีพ</label>
          <select id="occupation" class="form-control">
          </select>
        </div>       
        <div class="form-group">
          <label for="year">ปีฐาน</label>
          <select id="year" class="form-control">
          </select>
        </div> 
        <div class="form-group">
          <label for="predictNum">ค่าคาดการณ์ผู้จบ</label>
          <input type="text" id="predictNum" class="form-control">
        </div>          

        <div class="form-group">
          <button type="button" class="btn btn-primary">ยืนยัน</button>
          <button type="button" class="btn btn-danger">ล้างข้อมูล</button>
        </div>
      </form>
    </div>
  </div>

  <script src="vendor/assets/javascripts/lodash.min.js"></script>
  <script src="vendor/assets/javascripts/pace.min.js"></script>
  <script src="vendor/assets/javascripts/ol-4.1.0/ol.js"></script>
  <script src="vendor/assets/javascripts/ol3-popup/src/ol3-popup.js"></script>
  <script src="vendor/assets/javascripts/jquery/jquery.min.js"></script>
  
  <script>

    var getInitData = function () {
      $("#occupation").empty();
      $.ajax({
        url: 'controllers/what_if/branch_occupation.php',
        type: 'GET',
        dataType: 'JSON', 
        success: function (res) {
          $("#branchOccupation").empty();
          $("#branchOccupation").append("<option>กรุณาเลือก</option>");
          _.each(res, function (row) {
            $("#branchOccupation").append($("<option>",{
              text: row.name,
              value: row.code
            }));
          });          
        }
      });

      $.ajax({
        url: 'controllers/what_if/year.php',
        type: 'GET',
        dataType: 'JSON', 
        success: function (res) {
          $("#year").empty();
          $("#year").append("<option>กรุณาเลือก</option>");
          _.each(res, function (row) {
            $("#year").append($("<option>",{
              text: row.name,
              value: row.code
            }));
          });
        }
      });
    }

    var map = new ol.Map({
      target: "map",
      view: new ol.View({
        center: [11302896.246585583, 1477374.8826958865],
        zoom: 6,
      }),
      layers: [
        new ol.layer.Tile({
          source: new ol.source.OSM({
            url: "https://mts1.googleapis.com/vt?lyrs=m@230022547&src=apiv3&hl=th-TH&x={x}&y={y}&z={z}&style=59,37%7Csmartmaps"
          }),
          opacity: 1,
          visible: true
        })
      ]
    });


    $(function(){
      getInitData();
      $("#category").change(function () {
        getInitData();
      });
      $("#branchOccupation").change(function () {
        var category = $("#category").val();
        $.ajax({
          url: 'controllers/what_if/occupation.php',
          dataType: 'JSON',
          type: 'GET',
          data: {
            category: $("#category").val(),
            branch: this.value
          },
          success: function (res) {
            $("#occupation").empty();
            $("#occupation").append("<option>กรุณาเลือก</option>");
            _.each(res, function (row) {
              $("#occupation").append($("<option>",{
                text: row.name,
                value: row.code
              }));
            });
          }
        })
      })
    });

    window.addEventListener("resize", function () {
      document.getElementById('map').style.height = window.innerHeight+'px';
      map.updateSize();
    });
    window.dispatchEvent(new Event('resize'));


  </script>


</body>
</html>