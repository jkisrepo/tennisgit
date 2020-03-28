 $('.delete').on('click', function (e) {
     var userId = $(this).attr('id');

     var url = window['base_url'] + "/users" + "/" + userId + "/delete";

     e.preventDefault();
     $('#confirm').modal({
             backdrop: 'static',
             keyboard: false
         })
         .one('click', '#delete', function (e) {

             $.ajax({
                 type: "post",
                 url: url,
                 data: userId,
                 dataType: "text",

                 success: function (data) {
                     var find = $('.alert').length;

                     if (find == 0) {

                         if (data == "true") {
                             $(".tr_" + userId).fadeOut();
                             var resultString = window['success_strings']["user_deleted"];
                             $(".box-body").before('</br><div class="alert alert-success" role="alert">' + resultString + '</div>');

                         } else {
                             var resultString = window['warning_strings']["atlist_on_admin"];
                             $(".box-body").before('</br><div class="alert alert-warning" role="alert">' + resultString + '</div>');
                         }
                     }


                 },
                 error: function (data) {
                     console.log(data);
                 }
             });
         });

 });
