var searchdata = {
  init : function() {
    data = this.getData();
    this.addLayer(data);
    this.setup();
  },

  setup : function() {
    map.on('dblclick', function(evt) {
      var lonlat = ol.proj.transform(evt.coordinate, 'EPSG:3857', 'EPSG:4326');
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
          if (res.features.length > 0) {
            var prov_code = res.features[0].properties.prov_code;
            $('#province').val(prov_code);
            centermap = true
            searchdata.init();
            CenterMap(lonlat[0], lonlat[1], centermap)
          }
        }
      });

    });
  },

  addLayer : function(res) {
    sld_body = this.generate_xml(res);

    provinceLayer = new ol.layer.Tile({
      source : new ol.source.TileWMS({
        url : config.geoserverUrl + "/mol/wms",
        params : {
          LAYERS : 'mol:provinces',
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
  },

  getData : function(data) {
    var json = [];
    $.ajax({
      url : "controllers/search.php",
      dataType : "json",
      type : "get",
      async : false,
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
    var colors = [ "#B2FF66", "#80FF00", "#336600", "#193300", "#193300" ];

    var sld_body = '';
    var title = 'Provinces';
    var layer_name = 'mol:provinces';
    var id_name = 'prov_code';
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
                          sld_body += '<CssParameter name="fill-opacity">1.0</CssParameter>';

                        }
                      })
              sld_body += '</Fill><Stroke><CssParameter name="stroke">#FFFFFF</CssParameter><CssParameter name="stroke-width">2</CssParameter></Stroke></PolygonSymbolizer><TextSymbolizer><Label>'
                  + item.cnt
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
    url : config.geoserverUrl + "/oae/wms",
    params : {
      LAYERS : 'oae:provinces',
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

searchdata.init();
