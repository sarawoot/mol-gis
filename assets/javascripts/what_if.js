var whatIf = (function () {
  var colors = ["#38a800", "#9fd900", "#fcfc00", "#ff950a", "#e60000"];  
  var init = function () {
    $("#whatIfCategory").change(function () {
      categoryChange();
    });

    $("#whatIfBranchOccupation").change(function () {
      var category = $("#whatIfCategory").val();
      $.ajax({
        url: 'controllers/what_if/occupation.php',
        dataType: 'JSON',
        type: 'GET',
        data: {
          category: $("#whatIfCategory").val(),
          branch: this.value
        },
        success: function (res) {
          $("#whatIfOccupation").empty();
          $("#whatIfOccupation").append("<option value=''>กรุณาเลือก</option>");
          _.each(res, function (row) {
            $("#whatIfOccupation").append($("<option>",{
              text: row.name,
              value: row.code
            }));
          });
        }
      })
    })

    $("#whatIfconfirm").click(function () {
      generateMap('province');
    }) 
  }
  
  var categoryChange = function () {
    $("#whatIfOccupation").empty();
    $.ajax({
      url: 'controllers/what_if/branch_occupation.php',
      type: 'GET',
      dataType: 'JSON', 
      success: function (res) {
        $("#whatIfBranchOccupation").empty();
        $("#whatIfBranchOccupation").append("<option value=''>กรุณาเลือก</option>");
        _.each(res, function (row) {
          $("#whatIfBranchOccupation").append($("<option>",{
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
        $("#whatIfYear").empty();
        $("#whatIfYear").append("<option value=''>กรุณาเลือก</option>");
        _.each(res, function (row) {
          $("#whatIfYear").append($("<option>",{
            text: row.name,
            value: row.code
          }));
        });
      }
    });
  }

  var setup = function () {
    $("#whatIfPredictNum").val('');
    $("input[name=mapTool][value=pan]").parent().click();
    $("#panelWhatIf").show();
    setTimeout(function () {
      if (!$("#collapseWhatIf").is(":visible")) {
        $("#headingWhatIf a").click();
      }  
    },500);
    mapMode = 'what-if';
    categoryChange();
  }

  var generateXML = function (res, title, layer_name, id_name) {
    
    var sld_body = '';

    sld_body = '<?xml version="1.0" encoding="UTF-8"?><StyledLayerDescriptor version="1.0.0" xsi:schemaLocation="http://www.opengis.net/sld StyledLayerDescriptor.xsd" xmlns="http://www.opengis.net/sld" xmlns:ogc="http://www.opengis.net/ogc" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">';
    sld_body += '<NamedLayer><Name>' + layer_name + '</Name><UserStyle><Title>'
        + title + '</Title><Abstract>' + title
        + '</Abstract><FeatureTypeStyle>';
    _
        .each(
            res.data,
            function(item) {
              sld_body += '<Rule><ogc:Filter><ogc:PropertyIsEqualTo><ogc:PropertyName>'
                  + id_name + '</ogc:PropertyName><ogc:Literal>';
              sld_body += item.code
                  + '</ogc:Literal></ogc:PropertyIsEqualTo></ogc:Filter><PolygonSymbolizer><Fill>';
              _
                  .each(
                      res.intervals,
                      function(interval, idx) {
                        if (item.cnt >= interval[0] && item.cnt <= interval[1]) {
                          sld_body += '<CssParameter name="fill">'
                              + whatIf.colors[idx] + '</CssParameter>';
                          sld_body += '<CssParameter name="fill-opacity">0.9</CssParameter>';
                        } else if (item.cnt == 0) {

                          sld_body += '<CssParameter name="fill">#333333</CssParameter>';
                          sld_body += '<CssParameter name="fill-opacity">0.5</CssParameter>';
                        }
                      })
              sld_body += '</Fill><Stroke><CssParameter name="stroke">#FFFFFF</CssParameter><CssParameter name="stroke-width">2</CssParameter></Stroke></PolygonSymbolizer><TextSymbolizer><Label>'
                  + delimitNumbers(item.cnt)
                  + '</Label><Font><CssParameter name="font-family">Tahoma</CssParameter><CssParameter name="font-size">13.0</CssParameter><CssParameter name="font-style">normal</CssParameter><CssParameter name="font-weight">bold</CssParameter></Font><LabelPlacement><PointPlacement><AnchorPoint><AnchorPointX>0.5</AnchorPointX><AnchorPointY>0.5</AnchorPointY></AnchorPoint><Displacement><DisplacementX>0.0</DisplacementX><DisplacementY>0.0</DisplacementY></Displacement></PointPlacement></LabelPlacement><Fill><CssParameter name="fill">#3D3D3D</CssParameter></Fill><Halo><CssParameter name="fill">#FFFFFF</CssParameter></Halo></TextSymbolizer></Rule>';
            });
    sld_body += '<Rule><Name>rule1</Name><Title>Rule 1</Title><Abstract>Rule 1</Abstract><PolygonSymbolizer><Fill><CssParameter name="fill-opacity">0</CssParameter></Fill><Stroke><CssParameter name="stroke">#3D3D3D</CssParameter></Stroke></PolygonSymbolizer></Rule></FeatureTypeStyle></UserStyle></NamedLayer></StyledLayerDescriptor>';
    
    return sld_body;
  }

  var generateMap = function (type, params) {
    clearWhatIf();
    $("#panelResult").hide();
    var branch = $("#whatIfBranchOccupation").val();
    var occupation = $("#whatIfOccupation").val();
    var year = $("#whatIfYear").val();
    var num = Number($("#whatIfPredictNum").val());
    var category = $("#whatIfCategory").val();

    if ( branch == null || branch == '' ||
         occupation == null || occupation == '' ||
         year == null || year == '' ||
         num <= 0 || isNaN(num) ) {
      alert('กรุณาเลือกข้อมูลได้ถูกต้อง');
      return false;
    }
    var data = {
      branch: branch,
      occupation: occupation,
      year: year,
      num: num,
      category: category
    };
    if (params) {
      data = _.merge(data, params)
    }
    data.type = type
    var url = 'controllers/what_if/what_if.php'
    if (category == 'test_economy_east') {
      url = 'controllers/what_if/what_if_test_economy_east.php'
    }
    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'JSON',
      data: data,
      success: $.proxy(function (res) {

        var div = $("#collapseResult div");
        div.empty();
        if (res.length == 0) {
          alert("ไม่พบข้อมูล")
          return false;
        }
        var title = 'Provinces';
        var layer_name = 'mol:provinces'
        var id_name = 'prov_code';
        if (type == 'amphoe') {
          title = 'Amphurs';
          layer_name = 'mol:amphoes'
          id_name = 'ap_idn';
        }
        if (type == 'tambon') {
          title = 'Tambons';
          layer_name = 'mol:tambons'
          id_name = 'tb_idn';          
        }

        var sld = this.generateXML(res, title, layer_name, id_name);
        var layer = new ol.layer.Tile({
          source : new ol.source.TileWMS({
            url : config.geoserverUrl + "/mol/wms",
            params : {
              LAYERS : layer_name,
              STYLES : '',
              SLD_BODY : sld,
              TILED : true
            },
            serverType : 'geoserver',
            tileLoadFunction : tileLoadFunction
          }),
          name: 'what-if',
          type: this.type,
          category: 'result'
        });
        map.addLayer(layer);

        $("#panelResult").show();
        div.load('templates/what_if/legend_train_province.php', {
          intervals: res.intervals,
          colors: whatIf.colors,
          occupation: $("#whatIfOccupation option:selected").text(),
          year: $("#whatIfYear option:selected").text(),
          category: $("#whatIfCategory").val()
        });
        if (!$("#collapseResult").is(":visible")) {
          $("#headingResult a").click();
        } 

      },{generateXML: generateXML, type: type})
    })    
  }

  var clearWhatIf = function () {
    var layerTmps = [];
    _.each(map.getLayers().getArray(), function(layer) { 
      if ( layer.get('name') == 'what-if' ) {
        layerTmps.push(layer);
      }
    });
    _.each(layerTmps, function (layer) {
      map.removeLayer(layer);
    })
  }

  var getLayer = function () {
    var layerTmps;
    _.each(map.getLayers().getArray(), function(layer) { 
      if ( layer.get('name') == 'what-if' ) {
        layerTmps = layer;
      }
    });
    return layerTmps;
  }

  var getProvincePoint = function (evt) {
    var layer = getLayer();
    if (layer.get('type') == 'tambon') {
      return;
    }
    
    var getUrlInfo = function(layer){
      var view = map.getView();
      var viewResolution = view.getResolution();
      var source = layer.getSource();
      var url = source.getGetFeatureInfoUrl(
        evt.coordinate, viewResolution, view.getProjection(),
        {'INFO_FORMAT': 'application/json', 'FEATURE_COUNT': 1});
      return url;
    };

    if (layer) {
      var url = getUrlInfo(layer);
      var dataEntries = url.split("&");
      var params = "";
      for (var i = 0; i < dataEntries.length; i++) {
        if (i === 0) {
          url = dataEntries[i];
        } else if (!/SLD_BODY/.test(dataEntries[i])) {
          params = params + "&" + dataEntries[i];
        }
      }
      $.ajax({
        url : url,
        dataType : 'json',
        type : 'POST',
        data : params,
        success: $.proxy(function (res) {
          if (this.layer.get('type') == 'province' ) {
            if (res.features[0]) {
              generateMap('amphoe', {
                code: res.features[0].properties.prov_code
              })
            }
          }
          if (this.layer.get('type') == 'amphoe' ) {
            if (res.features[0]) {
              generateMap('tambon', {
                code: res.features[0].properties.ap_idn
              })
            }
          }          
        },{layer: layer})
      });
    }
  }

  return {
    setup: setup,
    init: init,
    clearWhatIf: clearWhatIf,
    colors: colors,
    getProvincePoint: getProvincePoint
  }
})();

whatIf.init();