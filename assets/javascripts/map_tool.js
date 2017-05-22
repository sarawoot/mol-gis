var mapMode = '';
var mapTool = (function () {
  var init = function () {
    initTool();
    $('[data-toggle="tooltip"]').tooltip({
      template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner large"></div></div>'
    });

    $("#confirmBuffer").click(function () {
      confirmBuffer();
    })
  }

  var initTool = function () {
    $("input[name=mapTool]").on("change", function() {
      if (this.checked) {
        mapMode = '';
        removeOtherInteraction();
        if (this.value == 'home') { zoomToThai(); }

        if (this.value == 'clear') { 
          clearMap();
          $("input[name=mapTool][value=pan]").parent().click();
        }
      
        if (this.value == 'measure-distance') {
          measureTool.addInteraction("LineString");
        }
        
        if (this.value == 'measure-area') {
          measureTool.addInteraction("Polygon");
        }

        if (this.value == 'buffer') {
          mapMode = 'buffer';
          $("#bufferDistance").val('');
          $("#collapseResult div").empty();
        }
      }

    });
  }

  var zoomToThai = function () {
    map.getView().setZoom(6);
    map.getView().setCenter([11302896.246585583, 1477374.8826958865]);
  }


  var buffer = function (coordinate) {
    clearBuffer();
    var bufferDistance = Number($("#bufferDistance").val());
    var featureTmp = createBufferPoint(coordinate);
    var epsg4326 = ol.proj.transform(coordinate, 'EPSG:3857', 'EPSG:4326');

    $("#panelBuffer").show();
    if (!$("#collapseBuffer").is(":visible") && !bufferDistance) {
      $("#headingBuffer a").click();
    }
    
    $("#bufferLat").val(epsg4326[1]);
    $("#bufferLng").val(epsg4326[0]);
    
    if (bufferDistance) {
      getBufferArea(featureTmp);
    }
  }

  var clearBuffer = function () {
    var featureTmp = [];
    _.each(features.getArray(), function(f){
      if (f.get('type') == 'bufferPoint' || 
          f.get('type') == 'bufferArea' ||
          f.get('type') == 'bufferHospital' ||
          f.get('type') == 'bufferUnemployed') {
        featureTmp.push(f)
      }
    });
    _.each(featureTmp, function(f){
      features.remove(f);
    });
    popup.hide();
  }

  var createBufferPoint = function (coordinate) {
    var featureTmp = new ol.Feature({
        type: "bufferPoint",
        geometry: new ol.geom.Point(coordinate)
    });
    features.push(featureTmp);
    return featureTmp;
  }

  var confirmBuffer = function () {
    clearBuffer()
    var bufferLat = Number($("#bufferLat").val());
    var bufferLng = Number($("#bufferLng").val());
    var bufferDistance = Number($("#bufferDistance").val());
    if (bufferLat && bufferLng && bufferDistance) {
      var coordinate = ol.proj.transform([bufferLng, bufferLat], 'EPSG:4326', 'EPSG:3857');
      var featureTmp = createBufferPoint(coordinate);
      getBufferArea(featureTmp);
    }
  }

  var getBufferArea = function (featureTmp) {
    if (featureTmp) {
      var coordinate = featureTmp.getGeometry().getCoordinates();
      $.ajax({
        url: 'http://gis.nlic.mol.go.th:6080/arcgis/rest/services/Utilities/Geometry/GeometryServer/buffer',
        type: 'GET',
        dataType: 'JSON',
        data: {
          f: 'json',
          unit: 9036,
          unionResults: false,
          geodesic: false,
          geometries: JSON.stringify({
            geometryType: "esriGeometryPoint",
            geometries: [
              {
                x: coordinate[0],
                y: coordinate[1],
                spatialReference: {
                  wkid: 3857
                }
              }
            ]
          }),
          inSR: 3857,
          distances: Number($("#bufferDistance").val()),
          outSR: 3857
        },
        success: function (res) {
          var geom = new ol.geom.Polygon(res.geometries[0].rings);
          map.getView().fit(geom.getExtent(), map.getSize());
          features.push(  
            new ol.Feature({
              type: "bufferArea",
              geometry: geom
          })) 
          if ($("#bufferType").val() == 'hospital') {
            getBufferHospital(res.geometries[0].rings);
          } else if ($("#bufferType").val() == 'unemployed') {
            getBufferUnemployed(res.geometries[0].rings);
          }
                   
        }
      })
    }
  }

  var getBufferHospital = function (rings) {
    $.ajax({
      url: 'controllers/buffer_hospital.php',
      type: 'POST',
      dataType: 'JSON',
      data: {
        f: 'json',
        where: '',
        returnGeometry: true,
        spatialRel: 'esriSpatialRelIntersects',
        geometryType: 'esriGeometryPolygon',
        inSR: 3857,
        outFields: '*',
        outSR: 3857,
        geometry: JSON.stringify({
          rings: rings,
          spatialReference: {
            wkid: 3857
          }
        })
      },
      success: function (res) {
        var tb = $("<table>",{
          class: 'table table-bordered table-hover table-striped'
        });
        var div = $("#collapseResult div");
        div.empty();
        div.append(tb);
        var th =  $("<thead>");
        th.append("<tr><th>ชื่อ</th><th>ที่อยู่</th></tr>");
        tb.append(th);
        var tbody =  $("<tbody>");
        tb.append(tbody);
        _.each(res.features, function(feature) {
          var tr = $("<tr>",{
            click: $.proxy(function () {
              popup.show([this.feature.geometry.x, this.feature.geometry.y], '<div><p>' + this.feature.attributes.HospitalNa + '</p></div>');
            }, {feature: feature}) 
          }).append("<td>"+feature.attributes.HospitalNa+"</td><td>"+feature.attributes.AreaName+"</td>")
          tbody.append(tr);
          features.push(  
            new ol.Feature({
              type: "bufferHospital",
              HospitalNa: feature.attributes.HospitalNa,
              geometry: new ol.geom.Point([feature.geometry.x, feature.geometry.y])
          }));
        })
        $("#panelResult").show();
        if (!$("#collapseResult").is(":visible")) {
          $("#headingResult a").click();
        }        
      }
    });
  }

  var getBufferUnemployed = function (rings) {
    $.ajax({
      url: 'controllers/buffer_tambon.php',
      type: 'POST',
      dataType: 'JSON',
      data: {
        f: 'json',
        where: '',
        returnGeometry: true,
        spatialRel: 'esriSpatialRelIntersects',
        geometryType: 'esriGeometryPolygon',
        inSR: 3857,
        outFields: '*',
        outSR: 3857,
        geometry: JSON.stringify({
          rings: rings,
          spatialReference: {
            wkid: 3857
          }
        })
      },
      success: function (res) {
        var codes = [];
        _.each(res.features, function(feature) {
          codes.push(feature.attributes.TAMBON_IDN)
          
          features.push(  
            new ol.Feature({
              type: "bufferUnemployed",
              geometry: new ol.geom.Polygon(feature.geometry.rings)
          }));
        })
        if (codes.length > 0) {
          getResultBufferUnemployed(codes);
        }
        $("#panelResult").show();
        if (!$("#collapseResult").is(":visible")) {
          $("#headingResult a").click();
        }
      }
    });
  }

  var getResultBufferUnemployed = function (codes) {
    $.ajax({
      url: 'controllers/result_buffer_unemployed.php',
      type: 'POST',
      dataType: 'JSON',
      data: {
        codes: codes.join(',')
      },
      success: function(res){

      }
    });
  }

  return {
    init: init,
    buffer: buffer
  }
})()
mapTool.init();