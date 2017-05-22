(function(){
  var init = function(){
    var dataTmp = getData();
    var data = [];

    _.each(dataTmp, function (row) {
      data.push(row)
      if (row.data.legend) {
        _.each(row.data.legend, function (l) {
          id = new Date().getTime() + Math.floor((Math.random() * 1000000) + 1);
          data.push({
            "id": id.toString(),
            "text": l.text,
            "parent": row.id,
            "data": {
              "category": "folder",
              "id": id.toString(),
              "color": l.color
            },
            "state": {
              "checkbox_disabled": true,
              "disabled": true
            }
          })
          
        });
      }
    });

    $('#layerSwitcher').jstree({
      plugins: ["wholerow", "checkbox", "search"],
      core: {
        data: data,
        themes: {
          name: 'proton',
          responsive: true
        }
      }
    }).bind('changed.jstree', function (evt, data) {
      selected_id = [];
      _.each(data.selected, function(item) {
        attr = data.instance.get_node(item).data;
        if (!$.isEmptyObject(attr)) {
          if (attr.id) {
            selected_id.push(attr.id);
            if (attr.layer && _.indexOf(addLayer.cache, attr.id) == -1) {
              layer = addLayer(attr);
              if (layer) {
                map.addLayer(layer);
                addLayer.cache.push(attr.id);
              }
            }
          }
        }
      });
      remove_layers = [];
      _.each(map.getLayers().getArray(), function(item) {
        if( _.indexOf( selected_id, item.get("id") ) == -1  && 
            item.get("mapType") != "baseLayer" ) {
          remove_layers.push(item);
        }
      });
      _.each(remove_layers, function(item) {
        map.removeLayer(item);
        idx = _.indexOf(addLayer.cache, item.get("id"));
        if (idx != -1) {
          addLayer.cache.remove(idx);
        }
      });
    })
    // .on('loaded.jstree', function() {
    //   $("#layerSwitcher").jstree("open_all");
    // });
    // .bind("select_node.jstree", function (evt, data) {
    // });

    var to = false;
    $('#searchLayerSwitcher').keyup(function () {
      if(to) { clearTimeout(to); }
      to = setTimeout(function () {
        var v = $('#searchLayerSwitcher').val();
        $('#layerSwitcher').jstree(true).search(v);
      }, 250);
    });
  };

  var addLayer =  function(attr) {
    var layer;

    if (attr.category == "arcgis") {
      layer = new ol.layer.Tile({
        opacity: 1,
        source: new ol.source.TileArcGISRest({
          url: attr.url
        })
      })
    }

    if (attr.category == "tile") {
      layer = new ol.layer.Tile({
        source: new ol.source.OSM({
          url: attr.url
        }),
        opacity: 1
      });
    }
    if (attr.category == "tile_wms") {
      layer = new ol.layer.Tile({
        source: new ol.source.TileWMS({
          url: attr.url,
          params: {
            tiled: true
          },
        })
      })
    }

    if (attr.category == "wms") {
      layer = new ol.layer.Image({
        source: new ol.source.ImageWMS({
          url: attr.url,
          params: {},
        })
      })
    }
    if (attr.category == "kml") {
      layer = new ol.layer.Vector({
        source: new ol.source.Vector({
          url: attr.url,
          format: new ol.format.KML(),
        })
      });
    }
    if (attr.category == "sharding-json") {

      var featuresTmp = new ol.Collection();
      layer = new ol.layer.Vector({
        source: new ol.source.Vector({features: featuresTmp}),
        style: function(feature, resolution){
          
          return [
            new ol.style.Style({
              fill: new ol.style.Fill({
                color: feature.get("color")
              }),
              stroke: new ol.style.Stroke({
                color: '#00000',
                width: 1
              }),
              image: new ol.style.Circle({
                radius: 7,
                fill: new ol.style.Fill({
                  color:  feature.get("color")
                })
              }),
              text: new ol.style.Text({
                text: feature.get("str").toString(),
                scale: 1.3,
                fill: new ol.style.Fill({
                  color: '#000000'
                }),
                stroke: new ol.style.Stroke({
                  color: '#FFFF99',
                  width: 3.5
                })
              })
            })
          ];
        }
      });

      $.ajax({
        url: attr.url,
        type: 'GET',
        dataType: 'JSON',
        success: $.proxy(function (res) {
          var attrTmp = this.attr
          _.each(res.features, function (feature) {
            var color='';
            var str='';
            _.each(attrTmp.legend, function (l) {
              str = feature.attributes[attrTmp.field];
              if (l.min && l.max) {
                if (_.inRange(feature.attributes[attrTmp.field], l.min, l.max)) {
                  color = l.color;
                }
              }
              if (l.min && !l.max && feature.attributes[attrTmp.field] >= l.min) {
                color = l.color;
              }
              if (!l.min && l.max && feature.attributes[attrTmp.field] <= l.max) {
                color = l.color;
              }
            })
            featuresTmp.push(  
              new ol.Feature({
                color: color,
                str: str,
                geometry: new ol.geom.Polygon(feature.geometry.rings)
            }));
          });
        }, {attr: attr})
      })




    }
    if (layer) {
      layer.set("id", attr.id);
    }
    return layer;
  };
  addLayer.cache = [];
  var getData = function(){
    var json = [];
    $.ajax({
      url:  "assets/javascripts/layers.json",
      dataType: "json",
      type: "get",
      async: false,
      success: function(data) {
        json = data;
      },
      error: function (xhr, status, e) {
        console.log('erroe  '+e );
      }
    });
    return json;
  }; 

  return {
    init: init
  };
})().init();