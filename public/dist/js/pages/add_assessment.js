$(function () {
    $('.rating-select .btn').on('click', function () {

        var rate = $(this).find('span').data('value');
        $(this).parent().find(".rate").val(rate);

        $(this).removeClass('btn-default').addClass('btn-warning');
        $(this).prevAll().removeClass('btn-default').addClass('btn-warning');
        $(this).nextAll().removeClass('btn-warning').addClass('btn-default');
    });
});
