$("#searchColumn").change(function () {
    var value = $(this).val();

    if (value == "date_time") {
        $('#datetimepicker1').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    } else {
        $('#datetimepicker1').data("DateTimePicker").destroy();
    }
    $('#datetimepicker1').val("");

});

$('.delete').on('click', function (e) {
    var attendanceId = $(this).attr('id');

    var url = window['base_url'] + "/attendance" + "/" + attendanceId + "/coaches/delete";

    e.preventDefault();
    $('#confirm').modal({
            backdrop: 'static',
            keyboard: false
        })
        .one('click', '#delete', function (e) {

            $.ajax({
                type: "post",
                url: url,
                data: attendanceId,
                dataType: "text",

                success: function (data) {

                    $(".tr_" + attendanceId).fadeOut();
                    var find = $('.alert').length;

                    if (find == 0) {
                        var resultString = window['success_strings']["attendance_deleted"];
                        $(".box-body").before('</br><div class="alert alert-success" role="alert">' + resultString + '</div>');
                    }

                },
                error: function (data) {
                    console.log(data);
                }
            });
        });

});
$(".charts").click(function () {
    $("#myModal2").modal('show');
});
