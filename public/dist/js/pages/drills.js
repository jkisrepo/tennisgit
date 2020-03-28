$('.delete').on('click', function (e) {
    var drillId = $(this).attr('id');

    var url = window['base_url'] + "/drills" + "/" + drillId + "/delete";
    e.preventDefault();
    $('#confirm').modal({
            backdrop: 'static',
            keyboard: false
        })
        .one('click', '#delete', function (e) {

            $.ajax({
                type: "post",
                url: url,
                data: drillId,
                dataType: "text",

                success: function (data) {

                    $(".tr_" + drillId).fadeOut();

                    var find = $('.alert').length;

                    if (find == 0) {
                        var resultString = window['success_strings']["drill_deleted"];
                        $(".box-body").before('</br><div class="alert alert-success" role="alert">' + resultString + '</div>');
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

});
