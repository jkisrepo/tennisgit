$('#datetimepicker1').datetimepicker({
    format: 'DD/MM/YYYY hh:mm A',
    maxDate: new Date()
});
$('#coaches').chosen();
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
