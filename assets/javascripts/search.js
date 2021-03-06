var colors = [ "#38a800", "#9fd900", "#fcfc00", "#ff950a", "#e60000" ];
var center_region = [ '', [ 11089400.34029035, 1942472.3409269839 ],
    [ 11502771.789256584, 1829957.0352912042 ],
    [ 11162779.88744412, 1565790.6655376353 ],
    [ 11331552.845897788, 1450829.3749967301 ],
    [ 11079616.400669849, 907820.7260588383 ] ];
var callback = function(evt) {
  searchdataDbl(evt);
};

function searchdataDbl(evt) {
  var lonlat = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
  var getUrlInfo = function(layerInfo) {
    var view = map.getView();
    var viewResolution = view.getResolution();
    var source = layerInfo.getSource();
    var url = source.getGetFeatureInfoUrl(evt.coordinate, viewResolution, view
        .getProjection(), {
      'INFO_FORMAT' : 'application/json',
      'FEATURE_COUNT' : 1
    });
    return url;
  };
  var url = getUrlInfo(provinceLayer);
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
    async : false,
    success : function(res) {
      if (res.features.length > 0) {
        if ($('#province').val() == '') {
          var prov_code = res.features[0].properties.prov_code;

          $('#province').val(prov_code);
        } else {
          var ap_idn = res.features[0].properties.ap_idn.substring(2, 4);
          if (ap_idn[0] == '0') {
            ap_idn = ap_idn[1];
          }
          $('#amphur').val(ap_idn);
        }
        // alert(prov_code);
        centermap = true
        var formData = $('#searchForm').serialize();
        var data = searchdata.getData(formData);
        searchdata.addLayer(data);
        CenterMap(lonlat[0], lonlat[1], centermap)
      }
    }
  });

}
var searchdata = {
  init : function() {
    data = this.getData();
    this.addLayer(data);
    this.setup();
    mapMode = 'search';
  },

  setup : function(formData) {

    if (mapMode == 'search') {
      map.un('dblclick', searchdataDbl);
      map.on('dblclick', searchdataDbl);

    }

  },

  addLayer : function(res) {
    $("#panelResult").show();
    setTimeout(function() {
      $('#collapseResult div').load(
          'templates/filter/result.php?intervals=' + res.intervals + '&'
              + $('#searchForm').serialize());
      if (!$("#collapseResult").is(":visible")) {
        $("#headingResult a").click();
      }
    }, 500);
    map.removeLayer(provinceLayer);
    sld_body = this.generate_xml(res);

    if ($('#province').val() != "") {
      if ($('#amphur').val() != "" && $('#formSearch').val() != 14) {
        layer_name = 'mol:tambons';
      } else {
        layer_name = 'mol:amphoes';
      }
    } else {
      layer_name = 'mol:provinces';
    }
    provinceLayer = new ol.layer.Tile({
      source : new ol.source.TileWMS({
        url : config.geoserverUrl + "/mol/wms",
        params : {
          LAYERS : layer_name,
          STYLES : '',
          SLD_BODY : sld_body,
          TILED : true
        },

        serverType : 'geoserver',
        tileLoadFunction : this.tileLoadFunction

      })
    });

    // layer.set("id", 'prov_code');
    map.addLayer(provinceLayer);
    if ($('#formSearch').val() == 14) {
      if ($('#PROVINCE_GROUP_CODE').val() != '') {

        map.getView().setCenter(center_region[$('#PROVINCE_GROUP_CODE').val()]);
        map.getView().setZoom(7);
      }
    }
  },

  getData : function(param) {
    var json = [];
    $.ajax({
      url : "controllers/search.php?" + param,
      dataType : "json",
      type : "get",
      async : false,
      beforeSend : function() {
        $('#loads').show();
      },
      complete : function() {
        $('#loads').hide();
      },
      success : function(data) {
        json = data;
      },
      error : function(xhr, status, e) {
        console.log('error  ' + e);
      }
    });
    return json;
  },

  generate_xml : function(res) {
    var sld_body = '';
    var title = '';
    var layer_name = '';
    var id_name = '';

    if ($('#province').val() != "") {
      if ($('#amphur').val() != "" && $('#formSearch').val() != 14) {
        title = 'Tambons';
        layer_name = 'mol:tambons';
        id_name = 'tb_idn';

      } else {
        title = 'Amphurs';
        layer_name = 'mol:amphoes';
        id_name = 'ap_idn';
      }
    } else {
      title = 'Provinces';
      layer_name = 'mol:provinces';
      id_name = 'prov_code';
    }
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
              sld_body += item.id_code
                  + '</ogc:Literal></ogc:PropertyIsEqualTo></ogc:Filter><PolygonSymbolizer><Fill>';
              _
                  .each(
                      res.intervals,
                      function(interval, idx) {
                        if (item.cnt >= interval[0] && item.cnt <= interval[1]) {
                          sld_body += '<CssParameter name="fill">'
                              + colors[idx] + '</CssParameter>';
                          sld_body += '<CssParameter name="fill-opacity">0.9</CssParameter>';

                        } else if (item.cnt == 0) {

                          sld_body += '<CssParameter name="fill">#333333</CssParameter>';
                          sld_body += '<CssParameter name="fill-opacity">0.5</CssParameter>';
                        }
                      })
              sld_body += '</Fill><Stroke><CssParameter name="stroke">#FFFFFF</CssParameter><CssParameter name="stroke-width">2</CssParameter></Stroke></PolygonSymbolizer><TextSymbolizer><Label>'
                  + number_format(item.cnt)
                  + '</Label><Font><CssParameter name="font-family">Tahoma</CssParameter><CssParameter name="font-size">13.0</CssParameter><CssParameter name="font-style">normal</CssParameter><CssParameter name="font-weight">bold</CssParameter></Font><LabelPlacement><PointPlacement><AnchorPoint><AnchorPointX>0.5</AnchorPointX><AnchorPointY>0.5</AnchorPointY></AnchorPoint><Displacement><DisplacementX>0.0</DisplacementX><DisplacementY>0.0</DisplacementY></Displacement></PointPlacement></LabelPlacement><Fill><CssParameter name="fill">#3D3D3D</CssParameter></Fill><Halo><CssParameter name="fill">#FFFFFF</CssParameter></Halo></TextSymbolizer></Rule>';
            });
    sld_body += '<Rule><Name>rule1</Name><Title>Rule 1</Title><Abstract>Rule 1</Abstract><PolygonSymbolizer><Fill><CssParameter name="fill-opacity">0</CssParameter></Fill><Stroke><CssParameter name="stroke">#3D3D3D</CssParameter></Stroke></PolygonSymbolizer></Rule></FeatureTypeStyle></UserStyle></NamedLayer></StyledLayerDescriptor>';

    return sld_body;
  },

  tileLoadFunction : function(image, src) {
    var img = image.getImage();
    if (typeof window.btoa === 'function') {
      var xhr = new XMLHttpRequest();
      var dataEntries = src.split("&");
      var url;
      var params = "";
      for (var i = 0; i < dataEntries.length; i++) {
        if (i === 0) {
          url = dataEntries[i];
        } else {
          params = params + "&" + dataEntries[i];
        }
      }
      xhr.open('POST', url, true);
      xhr.responseType = 'arraybuffer';
      xhr.onload = function(e) {
        if (this.status === 200) {
          var uInt8Array = new Uint8Array(this.response);
          var i = uInt8Array.length;
          var binaryString = new Array(i);
          while (i--) {
            binaryString[i] = String.fromCharCode(uInt8Array[i]);
          }
          var data = binaryString.join('');
          var type = xhr.getResponseHeader('content-type');
          if (type.indexOf('image') === 0) {
            img.src = 'data:' + type + ';base64,' + window.btoa(data);
          }
        }
      };
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.send(params);
    } else {
      img.src = src;
    }
  },
};

var provinceLayer = new ol.layer.Tile({
  source : new ol.source.TileWMS({
    url : config.geoserverUrl + "/mol/wms",
    params : {
      LAYERS : 'mol:provinces',
      STYLES : undefined,
      TILED : true
    },
    serverType : 'geoserver',
    tileLoadFunction : searchdata.tileLoadFunction
  })
});

function CenterMap(long, lat, amphur) {
  map.getView().setCenter(
      ol.proj.transform([ long, lat ], 'EPSG:4326', 'EPSG:3857'));
  map.getView().setZoom((amphur ? 7 : 11));

}

map.on('singleclick', function(evt) {
  if (mapMode == 'search') {
    var coordinate = evt.coordinate;

    var xy = String(coordinate).split(',');
    // content.innerHTML = '';
    var getUrlInfo = function(layerInfo) {
      var view = map.getView();
      var viewResolution = view.getResolution();
      var source = layerInfo.getSource();
      var url = source.getGetFeatureInfoUrl(evt.coordinate, viewResolution,
          view.getProjection(), {
            'INFO_FORMAT' : 'application/json',
            'FEATURE_COUNT' : 1
          });
      return url;
    };
    var url = getUrlInfo(provinceLayer);
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
      async : false,
      success : function(res) {
        var prov_code = '';
        var ap_idn = '';
        var tb_idn = '';
        if (res.features.length > 0) {
          if ($('#province').val() == '') {
            prov_code = res.features[0].properties.prov_code;
          } else if ($('#amphur').val() == '') {
            ap_idn = res.features[0].properties.ap_idn;
          } else {
            tb_idn = res.features[0].properties.tb_idn;
            if (!tb_idn)
              tb_idn = '';
          }
          var param = 'pop=1&prov_code=' + prov_code + '&ap_idn=' + ap_idn
              + '&tb_idn=' + tb_idn + '&' + $('#searchForm').serialize();

          $.ajax({
            url : 'controllers/popupdetail.php',
            type : 'GET',
            data : param,
            success : function(res) {
              popup.show([ xy[0], xy[1] ], res)
            }
          });

        }
      }

    });
  }

});

function hideResultPanel(obj) {
  setTimeout(function() {
    if ($("#collapseResult").is(":visible")) {
      $("#headingResult a").click();
    }
  }, 500);
}

function clearSearchResult() {
  map.removeLayer(provinceLayer);
  map.getView().setZoom(6);
  map.getView().setCenter([ 11302896.246585583, 1477374.8826958865 ]);
  $('#collapseResult div').html('');
  $('#province').val('');
  $('#amphur').val('');
}

function number_format(str) {
  str = String(str);
  var idex = str.indexOf('.');
  if (idex == -1) {
    return numeral(str).format('0,0')
  } else {
    return numeral(str).format('0,0.00')
  }

}

// searchdata.init();
