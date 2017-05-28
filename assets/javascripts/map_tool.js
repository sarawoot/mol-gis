var mapMode = '';
var mapTool = (function () {
  var init = function () {
    initTool();
    $('[data-toggle="tooltip"]').tooltip({
      template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner large"></div></div>'
    });
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
          clearMap();
          mapMode = 'buffer';
          $("#bufferDistance").val('');
          $("#collapseResult div").empty();
        }

        if (this.value == 'what-if') {
          clearMap();
          whatIf.setup();
        }
        if (this.value == 'search') {
           clearMap();
           mapMode = 'search';
           searchtool.showPanel();
           searchtool.init();
           
           setTimeout(function () {
             if (!$("#collapseLayerSearch").is(":visible")) {
               $("#headingLayer a").click();
             }  
             if ($("#collapseLayerSearch").is(":hidden")) {
               $("#headingLayerSearch a").click();
             }  
             
           },500);
        }

      }

    });
  }

  var zoomToThai = function () {
    map.getView().setZoom(6);
    map.getView().setCenter([11302896.246585583, 1477374.8826958865]);
  }

  return {
    init: init
  }
})()
mapTool.init();