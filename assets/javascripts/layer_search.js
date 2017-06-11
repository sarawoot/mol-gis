var searchtool = (function() {
  var init = function() {
    // var dataTmp = getData();
    // var data = [];
    //
    // $('#layerSearchSelectForm').append($('<option>', {
    // value : '-1',
    // text : 'กรุณาเลือก'
    // }));
    // $.each(dataTmp, function(i, item) {
    //
    // $('#layerSearchSelectForm').append($('<option>', {
    // value : item.id,
    // text : item.text
    // }));
    // });

  };

  $('#layerSearchSelectForm').on('change', function() {
    clearSearchResult();
    $('#layerSearchForm').load("templates/filter/" + this.value + ".php");
  });
  var showPanel = function() {
    $("#panelSearch").show();
    setTimeout(function() {
      if (!$("#collapseLayerSearch").is(":visible")) {
        $("#searchLayer a").click();
        $("#headingLayer a").click();
      }
    }, 500);

  }
  var closePanel = function() {
    $('#panelSearch').css('display', 'none');
  }
  var getData = function() {
    var json = [];
    $.ajax({
      url : "assets/javascripts/layers1.json",
      dataType : "json",
      type : "get",
      async : false,
      success : function(data) {
        json = data;
      },
      error : function(xhr, status, e) {
        console.log('erroe  ' + e);
      }
    });
    return json;
  };

  return {
    init : init,
    showPanel : showPanel,
    closePanel : closePanel
  };
})();
searchtool.init();

function ClickSearchLayer() {
  var formData = $('#searchForm').serialize()
  // console.log(formData);
  //
  // console.log(mapMode);
  // var monthValue = getDataDropdown("monthFilter");
  // var yearValue = getDataDropdown("yearFilter");
  // var addressValue = getDataDropdown("addressFilter");
  // var courseValue = getDataDropdown("courseFilter");
  // var eduValue = getDataDropdown("eduFilter");
  // var howValue = getDataDropdown("howFilter");
  // var province = $('#formSearch').val();
  // var amphur = $('#formSearch').val();
  // var typeValue = getDataDropdown("typeFilter");
  // var posEmtyValue = getDataDropdown("posEmtyFilter");
  // var posValue = getDataDropdown("posFilter");
  // var defValue = getDataDropdown("defFilter");
  // var monthValue = getDataDropdown("monthFilter");
  // var quarterValue = getDataDropdown("quarterFilter");

  var data = searchdata.getData(formData);
  searchdata.setup(data);
  searchdata.addLayer(data);
};

// function getDataDropdown(input) {
// var monthValue = "";
// var monthFilter = document.getElementById(input);
// if (monthFilter) {
// console.log(input + "::" +
// monthFilter.options[monthFilter.selectedIndex].value);
// return monthFilter.options[monthFilter.selectedIndex].value;
// }

// }
