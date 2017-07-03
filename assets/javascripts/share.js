if (Array.prototype.remove === undefined) {
  Array.prototype.remove = function(from, to) {
    var rest = this.slice((to || from) + 1 || this.length);
    this.length = from < 0 ? this.length + from : from;
    return this.push.apply(this, rest);
  };
}

if (ol.Map.prototype.getLayer === undefined) {
  ol.Map.prototype.getLayer = function(id) {
    var layer;
    this.getLayers().forEach(function(lyr) {
      if (id == lyr.get('id')) {
        layer = lyr;
      }
    });
    return layer;
  };
}

var removeOtherInteraction = function() {
  var sl = [];
  _.each(map.getInteractions().a, function(item, i) {
    if (i > 8) {
      sl.push(item);
    }
  });
  _.each(sl, function(item) {
    map.removeInteraction(item);
  });
}

var clearMap = function() {
  features.clear();
  map.getOverlays().clear();
  map.addOverlay(popup);
  map.removeLayer(provinceLayer);
  whatIf.clearWhatIf();
  popup.hide();
  $("#panelBuffer").hide();
  $("#panelResult").hide();
  $("#panelWhatIf").hide();
  $('#panelSearch').hide();
  if (!$("#collapseLayer").is(":visible")) {
    $("#headingLayer a").click();
  }
  map.getView().setZoom(6);
  map.getView().setCenter([ 11302896.246585583, 1477374.8826958865 ]);
  
}

function tileLoadFunction(image, src) {
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
}

function delimitNumbers(str) {
  return (str + "").replace(/\b(\d+)((\.\d+)*)\b/g, function(a, b, c) {
    return (b.charAt(0) > 0 && !(c || ".").lastIndexOf(".") ? b.replace(/(\d)(?=(\d{3})+$)/g, "$1,") : b) + c;
  });
}
