$('#datetimepicker1').datetimepicker({
    format: 'DD/MM/YYYY hh:mm A'
});
$('#player2').chosen();
$("#court").chosen();
$("#player1").chosen().change(function (e) {
    var player1 = $(this).val();

    $.ajax({
        type: 'get',
        url: window['base_url'] + "/players",
        data: {
            except: player1
        },
        success: function (players) {
            $('#player2').find('option').remove();
            var empty = $('<option>', {
                value: "",
                selected: true,
                disabled: true
            }).html("Select Player 2");
            $('#player2').append(empty);
            $('#player2').attr('disabled', false);
            $('#player2').attr('required', true);
            $.each(players, function (index, player) {
                var option = $('<option>', {
                    value: player.id
                }).html(player.name);
                $('#player2').append(option);
            });

            $("#player2").trigger("chosen:updated");
        },
        error: function (res) {
            console.log(res);
        }
    });


});

$('#academy').chosen().change(function () {
    var academy = $(this).val();
    $('#court').find('option').remove();
    $('#court').append($("<option>", {
        value: "",
        selected: true,
        disabled: true
    }).html('Please Select Court'));
    $("#court").attr('disabled', false);
    $("#court").attr('required', true);
    $.get(window['base_url'] + "/academies", {
        academy: academy
    }, function (data) {
        $.each(data, function (index, court) {
            var option = $('<option>', {
                value: court.court_id
            }).html(court.court_type);
            $('#court').append(option);
        });

        $("#court").trigger("chosen:updated");
    });
});
