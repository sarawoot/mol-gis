var baseLayers = [
  {
    name: "Google Road",
    layer: new ol.layer.Tile({source: new ol.source.OSM({url: "https://mts1.googleapis.com/vt?lyrs=m@230022547&src=apiv3&hl=th-TH&x={x}&y={y}&z={z}&style=59,37%7Csmartmaps"}),opacity: 1, visible: true})
  }, {
    name: "Google Satellite",
    layer: new ol.layer.Tile({source: new ol.source.OSM({url: "http://mt.google.com/vt/lyrs=s&z={z}&x={x}&y={y}&hl=th"}),opacity: 1, visible: false})
  }, {
    name: "Google Hybrid",
    layer: new ol.layer.Tile({source: new ol.source.OSM({url: "http://mt.google.com/vt/lyrs=y&z={z}&x={x}&y={y}&hl=th"}),opacity: 1, visible: false})
  }, {
    name: "Google Terrain",
    layer: new ol.layer.Tile({source: new ol.source.OSM({url: "http://mt.google.com/vt/lyrs=t&z={z}&x={x}&y={y}&hl=th"}),opacity: 1, visible: false})
  }, {
    name: "Open Street Map",
    layer: new ol.layer.Tile({ source: new ol.source.OSM(), visible: false })
  }, {
    name: "Bing Road",
    layer: new ol.layer.Tile({
      visible: false,
      preload: Infinity,
      source: new ol.source.BingMaps({
        key: 'Ain9zviHZUQq1V7lzjLAeLUMUJyz3pgVE0zZnt4Sqg0BPehKC8Hj0jSPmzqVetC6',
        imagerySet: 'Road'
      })
    })
  }, {
    name: "Bing Aerial",
    layer: new ol.layer.Tile({
      visible: false,
      preload: Infinity,
      source: new ol.source.BingMaps({
        key: 'Ain9zviHZUQq1V7lzjLAeLUMUJyz3pgVE0zZnt4Sqg0BPehKC8Hj0jSPmzqVetC6',
        imagerySet: 'Aerial'
      })
    })
  }, {
    name: "Bing Aerial with labels",
    layer: new ol.layer.Tile({
      visible: false,
      preload: Infinity,
      source: new ol.source.BingMaps({
        key: 'Ain9zviHZUQq1V7lzjLAeLUMUJyz3pgVE0zZnt4Sqg0BPehKC8Hj0jSPmzqVetC6',
        imagerySet: 'AerialWithLabels'
      })
    })
  }
]

var map = new ol.Map({
  target: "map",
  view: new ol.View({
    center: [11302896.246585583, 1477374.8826958865],
    zoom: 6,
  })
});

var mousePosition = new ol.control.MousePosition({
  coordinateFormat: function(coordinate) {
    return ol.coordinate.format(coordinate, 'ลองติจูด: {x}, ละติจูด: {y}', 4);
  },
  projection: 'EPSG:4326',
  target: document.getElementById('mapPosition'),
  undefinedHTML: '&nbsp;'
});

map.addControl(mousePosition);

$.each(baseLayers, function(i, item){
  layer = item.layer
  layer.set("mapType", "baseLayer");
  map.addLayer(layer);
  if (layer.getVisible()) {
    $("[data-type=label_layer]").html(item.name);
  }
  var li = $("<li>");
  var a = $("<a>", {
    text: item.name,
    "data-idx":  i,
    click: function(){
      var baseLayer = baseLayers[$(this).data("idx")];
      $.each(baseLayers, function(i, item){
        var layer = item.layer;
        layer.setVisible(false);
      });
      baseLayer.layer.setVisible(true);
      $("[data-type=label_layer]").html(baseLayer.name);
    }
  });
  li.append(a);
  $("[data-type=container_layers]").append(li);
});

var features = new ol.Collection();
var featureOverlay = new ol.layer.Vector({
  source: new ol.source.Vector({features: features}),
  style: function(feature, resolution){
    if (feature.get('type') == 'measure') {
      return [new ol.style.Style({
        fill: new ol.style.Fill({
          color: 'rgba(255, 255, 255, 0.5)'
        }),
        stroke: new ol.style.Stroke({
          color: "#ffcc33",
          width: 2
        }),
        image: new ol.style.Circle({
          radius: 7,
          fill: new ol.style.Fill({
            color:  "#ffcc33" 
          })
        })
      })];
    } else if (feature.get('type') == 'bufferPoint') {
      return [new ol.style.Style({
        fill: new ol.style.Fill({
          color: '#ff0000'
        }),
        stroke: new ol.style.Stroke({
          color: "#ff0000",
          width: 2
        }),
        image: new ol.style.Icon(({
          anchor: [0.5, 32],
          anchorXUnits: 'fraction',
          anchorYUnits: 'pixels',
          src: 'assets/images/pin.png'
        }))
      })];  
    } else if (feature.get('type') == 'bufferArea') {
      return [new ol.style.Style({
        fill: new ol.style.Fill({
          color: 'rgba(0, 0, 255, 0.1)'
        }),
        stroke: new ol.style.Stroke({
          color: 'rgba(0, 0, 255, 1)',
          width: 2
        }),
        image: new ol.style.Circle({
          radius: 7,
          fill: new ol.style.Fill({
            color:  'rgba(0, 0, 255, 0.1)' 
          })
        })
      })];
    } else if (feature.get('type') == 'bufferHospital') {
      return [new ol.style.Style({
        fill: new ol.style.Fill({
          color: '#ff0000'
        }),
        stroke: new ol.style.Stroke({
          color: "#ff0000",
          width: 2
        }),
        image: new ol.style.Icon(({
          anchor: [0.5, 32],
          anchorXUnits: 'fraction',
          anchorYUnits: 'pixels',
          src: 'assets/images/pharmacy-pin.png'
        }))
      })];  
    } else if (feature.get('type') == 'bufferUnemployed') {
      return [new ol.style.Style({
        fill: new ol.style.Fill({
          color: 'rgba(99, 40, 13, 0.5)'
        }),
        stroke: new ol.style.Stroke({
          color: 'rgba(0, 0, 0, 0.5)',
          width: 2
        }),
        image: new ol.style.Circle({
          radius: 7,
          fill: new ol.style.Fill({
            color:  'rgba(0, 0, 255, 0.5)' 
          })
        })
      })];
    } 

  }
});
featureOverlay.setMap(map);

var popup = new ol.Overlay.Popup();
map.addOverlay(popup);


map.on('singleclick', function(evt) {
  var feature = map.forEachFeatureAtPixel(evt.pixel,
    function(feature) {
      return feature;
    });
  if (feature && feature.get('type') == 'bufferHospital') {
    popup.show(feature.getGeometry().getCoordinates(), '<div><p>' + feature.get('HospitalNa') + '</p></div>');
    return false;
  }
  var coordinate = evt.coordinate;
  if (mapMode == 'buffer') {
    buffer.setup(coordinate);
  }
  if (mapMode == 'what-if') {
    whatIf.getProvincePoint(evt);
  }
});
