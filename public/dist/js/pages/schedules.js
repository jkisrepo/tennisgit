 $(".assessment").click(function () {


     var match = $(this).data('match-id');
     var player1 = $(this).data('player1');
     var player2 = $(this).data('player2');


     var params = {
         match: match,
         player1: player1,
         player2: player2
     };

     var assessmentUrl = window['base_url'] + '/players';
     var coachUrl = window['base_url'] + '/playerscoach';
     $.get(coachUrl, params, function (data) {

         console.log(data);
         $(".modal-body").html("");
         $('#myModal').modal('show');

         $.each(data, function (_, player) {

             var linkUrl = assessmentUrl + "/" + player.id + "/assessments/create?match_id=" + match;

             var link = $("<a>", {
                 href: linkUrl
             }).html('<b>' + player.name + '</b>');

             $(".modal-body").append(link);
             $(".modal-body").append("<br>");
         });

     });
 });

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



 $(".winner").click(function () {
     var match = $(this).data('match-id');
     var player1 = $(this).data('player1');
     var player2 = $(this).data('player2');
     var player1_name = $(this).data('player1-name');
     var player2_name = $(this).data('player2-name');

     var winner = $(this).data('winner');

     if (player1 == winner) {
         $("#player1").attr('checked', true);
     } else if (player2 == winner) {
         $("#player2").attr('checked', true);
     } else if (winner == -1) {
         $('#draw').attr('checked', true);
     }

     $("#match_id").val(match);
     $(".Modal1").modal('show');

     $('#winner_' + 0).html(player1_name);
     $('#winner_' + 1).html(player2_name);
     $($('input[name="player"]')[0]).val(player1);
     $($('input[name="player"]')[1]).val(player2);
 });


 $("#winner_form").submit(function (e) {
     e.preventDefault();
     var datastring = $("#winner_form").serialize();
     var url = window['base_url'] + "/schedules" + "/" + $('#match_id').val() + "/winner";
     $.ajax({
         type: "POST",
         url: url,
         data: datastring,
         dataType: "json",
         success: function (data) {
             console.log(data);
             $('#winner_update').show();
             $('#winner_update').html('Updated!');
             setTimeout(function () {
                 location.reload();
             }, 2000);

         },
         error: function (res) {
             console.log(res);
         }
     });
 });

 $('.delete').on('click', function (e) {
     var matchId = $(this).attr('id');
     var url = window['base_url'] + "/schedules" + "/" + matchId + "/delete";
     e.preventDefault();
     $('#confirm').modal({
             backdrop: 'static',
             keyboard: false
         })
         .one('click', '#delete', function (e) {

             $.ajax({
                 type: "post",
                 url: url,
                 dataType: "text",
                 success: function (data) {

                     $(".tr_" + matchId).fadeOut();
                     var find = $('.alert').length;

                     if (find == 0) {
                         var resultString = window['success_strings']["match_deleted"];
                         $(".box-body").before('</br><div class="alert alert-success" role="alert">' + resultString + '</div>');
                     }

                 },
                 error: function (data) {
                     console.log(data);
                 }
             });
         });

 });
