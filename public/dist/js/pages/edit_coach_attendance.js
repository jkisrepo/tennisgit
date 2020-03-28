$('#datetimepicker1').datetimepicker({
    format: DATETIME_FORMAT,
    maxDate: 'now'
});

$('#coaches').chosen();
if ($(".absent_type").attr('style') !== "display:none;") {
    $("#absent_type").chosen();
}
$("#attendance").chosen().change(function () {
    if ($(this).val() == 0) {
        $(".absent_type").show();

        $("#absent_type").attr('required', true);
        $("#absent_type").chosen();
    } else {
        $(".absent_type").hide();
        $("#absent_type").attr('required', false);
    }

});
