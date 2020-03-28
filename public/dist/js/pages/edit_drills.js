$(".close").click(function () {
    var id = $(this).data('id');
    $(this).closest('.col-sm-2').remove();
    var url = window['base_url'] + "/drills" + "/" + "image/" + id + "/delete";
    $.ajax({
        type: "POST",
        url: url,
        data: id,
        dataType: "json",
        success: function (data) {
            console.log(data);

        },
        error: function (res) {
            console.log(res);
        }
    });
});
