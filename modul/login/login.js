$(document).ready(function(){

    $('#loginButton').click(function(event){

        $('#errorAlert').fadeOut('fast');
        $(this).prop('disabled', true);
        event.preventDefault();

        var email = $('#inputMail').val();
        var password = $('#inputPassword').val();

        var error = "";

        if(email < 2){
            error += "<li>Please enter your E-Mail</li>";
        }

        if(password < 8){
            error += "<li>Please enter a correct Password</li>";
        }

        if($('#inputKeep').is(':checked')){
            var keepLogin = true;
        } else {
            var keepLogin = false;
        }

        if(error != ""){

            $('#errorText').html(error);
            $('#errorAlert').fadeIn('fast');
            $(this).prop('disabled', false);

        } else {

            $.ajax({
                type: "POST",
                data: {email:email, password:password, keepLogin:keepLogin},
                url: "modul/login/loginUser.php",
                success: function(data){
                    if(data){
                        $('#errorText').html(data);
                        $('#errorAlert').fadeIn('fast');
                        $('#loginButton').prop('disabled', false);
                    } else {
                        $('#successText').html("Successfully Loggedin.");
                        $('#successAlert').fadeIn('fast');
                        parent.window.location.reload();
                    }
                }
            });

        }

    });

});
