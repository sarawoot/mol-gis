var whatIf = (function () {

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
      $.ajax({
        url: 'controllers/what_if/train_province.php',
        type: 'GET',
        dataType: 'JSON',
        data: {
          branch: branch,
          occupation: occupation,
          year: year,
          num: num,
          category: category
        },
        success: function (res) {
          
        }
      })
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
    $("input[name=mapTool][value=pan]").parent().click();
    $("#panelWhatIf").show();
    setTimeout(function () {
      if (!$("#collapseWhatIf").is(":visible")) {
        $("#headingWhatIf a").click();
      }  
    },500);
    categoryChange();
  }


  return {
    setup: setup,
    init: init
  }
})();

whatIf.init();