(function() {
    var init = function() {
        var dataTmp = getData();
        var data = [];
        $('#layerSearchSelectForm').append($('<option>', {
            value: '-1',
            text: 'กรุณาเลือก'
        }));
        $.each(dataTmp, function(i, item) {

            $('#layerSearchSelectForm').append($('<option>', {
                value: item.id,
                text: item.text
            }));
        });

    };


    $('#layerSearchSelectForm').on('change', function() {
        // alert(this.value);
        $('#layerSearchForm').load("templates/filter/1.php");
    });


    var getData = function() {
        var json = [];
        $.ajax({
            url: "assets/javascripts/layers.json",
            dataType: "json",
            type: "get",
            async: false,
            success: function(data) {
                json = data;
            },
            error: function(xhr, status, e) {
                console.log('erroe  ' + e);
            }
        });
        return json;
    };

    return {
        init: init
    };
})().init();

function searchLayer() {
    var data = searchdata.getData();
    searchdata.addLayer(data);
};