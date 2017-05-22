if (Array.prototype.remove === undefined) {
  Array.prototype.remove = function(from, to) {
    var rest = this.slice((to || from) + 1 || this.length);
    this.length = from < 0 ? this.length + from : from;
    return this.push.apply(this, rest);
  };
}

if (ol.Map.prototype.getLayer === undefined) {
  ol.Map.prototype.getLayer = function (id) {
    var layer;
    this.getLayers().forEach(function (lyr) {
        if (id == lyr.get('id')) {
          layer = lyr;
        }
    });
    return layer;
  };
}

var removeOtherInteraction = function () {
  var sl = [];
  _.each(map.getInteractions().a, function(item, i){
    if (i > 8) {
      sl.push(item);
    }
  });
  _.each(sl, function(item){
    map.removeInteraction(item);
  });
}

var clearMap = function (){
  features.clear();  
  map.getOverlays().clear();
  popup.hide();
  $("#panelBuffer").hide();
  $("#panelResult").hide();
  if (!$("#collapseLayer").is(":visible")) {
    $("#headingLayer a").click();
  }
}