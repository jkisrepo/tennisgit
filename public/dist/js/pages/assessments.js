 $('#datetimepicker1').datetimepicker({
     format: 'DD/MM/YYYY'
 });
 $('.delete').on('click', function (e) {
     var playerId = $(this).data('player-id');
     var assessmentId = $(this).data('assessment-id');

     var url = window['base_url'] + "/players" + "/" + playerId + "/assessments/" + assessmentId + "/delete";

     e.preventDefault();
     $('#confirm').modal({
             backdrop: 'static',
             keyboard: false
         })
         .one('click', '#delete', function (e) {

             $.ajax({
                 type: "post",
                 url: url,
                 data: {
                     'player': playerId,
                     'assessment': assessmentId
                 },
                 dataType: "text",

                 success: function (data) {

                     if (data == "true") {
                         $(".tr_" + assessmentId).fadeOut();
                         var find = $('.alert').length;

                         if (find == 0) {
                             var resultString = window['success_strings']["assessment_delete"];
                             $(".box-body").before('</br><div class="alert alert-success" role="alert">' + resultString + '</div>');
                         }


                     }

                 },
                 error: function (data) {
                     console.log(data);
                 }
             });
         });

 });

 $('#toggle').on('change', function () {

     var onData = $("#toggle").attr('data-on');
     var offData = $("#toggle").attr('data-off');
     var value = $("#toggle").attr('value');
 });

 $(".charts").click(function () {
     $("#myModal2").modal('show');
 });
