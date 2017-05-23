var whatIf = (function () {
  
  var setup = function () {
    clearMap();
    
    $("#whatIfOccupation").empty();
    $.ajax({
      url: 'controllers/what_if/branch_occupation.php',
      type: 'GET',
      dataType: 'JSON', 
      success: function (res) {
        $("#whatIfBranchOccupation").empty();
        $("#whatIfBranchOccupation").append("<option>กรุณาเลือก</option>");
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
        $("#wharIfYear").empty();
        $("#wharIfYear").append("<option>กรุณาเลือก</option>");
        _.each(res, function (row) {
          $("#wharIfYear").append($("<option>",{
            text: row.name,
            value: row.code
          }));
        });
      }
    });
    $("input[name=mapTool][value=pan]").parent().click();
    $("#panelWhatIf").show();
    setTimeout(function () {
      if (!$("#collapseWhatIf").is(":visible")) {
        $("#headingWhatIf a").click();
      }  
    },500);
  }



  $("#whatIfCategory").change(function () {
    setup();
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
        $("#whatIfOccupation").append("<option>กรุณาเลือก</option>");
        _.each(res, function (row) {
          $("#whatIfOccupation").append($("<option>",{
            text: row.name,
            value: row.code
          }));
        });
      }
    })
  })

  return {
    setup: setup
  }
})();