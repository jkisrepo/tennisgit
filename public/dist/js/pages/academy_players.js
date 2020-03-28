 $('.delete').on('click', function (e) {
     var playerId = $(this).attr('id');
     var url = window['base_url'] + "/players" + "/" + playerId + "/delete";
     e.preventDefault();
     $('#confirm').modal({
             backdrop: 'static',
             keyboard: false
         })
         .one('click', '#delete', function (e) {
             $.ajax({
                 type: "post",
                 url: url,
                 data: playerId,
                 dataType: "text",
                 success: function (data) {

                     $(".tr_" + playerId).fadeOut();
                     $("#player_delete").show();
                     $("#player_delete").before('</br>');
                     var resultString = window['success_strings']["player_deleted"];
                     $('#player_delete').html(resultString);
                     window.location.reload();
                 },
                 error: function (data) {
                     console.log(data);
                 }
             });
         });

 });
