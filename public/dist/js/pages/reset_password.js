        $("input[name='confirm_password']").keyup(function () {
            alert('sdfsd');
            var confirm_password = $(this).val();
            var password = $("input[name='password']").val();



            var str = $(this).parent().html();

            if (str.indexOf("span") == -1) {
                $(this).after("<span id='checkPass'></span>");
            }
            if (confirm_password == "") {

                $("span#checkPass").text("");
                $("button[type='submit']").attr('disabled', false);
            } else
            if (password == "") {
                $("span#checkPass").html("<p class='text-danger'>Please enter password first</p>");
                $("button[type='submit']").attr('disabled', true);
            } else
            if (password == confirm_password) {
                $("span#checkPass").html("<p class='text-success'>Passwords matched</p>");
                $("button[type='submit']").attr('disabled', false);
            } else {
                $("span#checkPass").html("<p class='text-danger'>Passwords does not match</p>");
                $("button[type='submit']").attr('disabled', true);
            }
        });
