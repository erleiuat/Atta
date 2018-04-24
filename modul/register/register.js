$(document).ready(function(){

    $('#registerButton').click(function(event){

        $('#errorAlert').fadeOut('fast');
        $(this).prop('disabled', true);
        event.preventDefault();

        var firstname = $('#inputFirstname').val();
        var lastname = $('#inputLastname').val();
        var email = $('#inputMail').val();
        var password = $('#inputPassword').val();
        var password2 = $('#inputPasswort2').val();

        var error = "";

        if(firstname < 2){
            error += "<li>Please enter your Firstname</li>";
        }

        if(lastname < 2){
            error += "<li>Please enter your Lastname</li>";
        }

        if(email < 2){
            error += "<li>Please enter a correct E-Mail</li>";
        }

        if(password < 6){
            error += "<li>Please use a password with at least 8 digits</li>";
        } else {
            if(password != password2){
                error += "<li>The passwords are not similar</li>";
            }
        }

        if(error != ""){

            $('#errorText').html(error);
            $('#errorAlert').fadeIn('fast');
            $(this).prop('disabled', false);

        } else {

            $.ajax({
                type: "POST",
                data: {firstname: firstname, lastname:lastname, email:email, password:password, password2:password2},
                url: "modul/register/sendRegistration.php",
                success: function(data){
                    if(data){
                        $('#errorText').html(data);
                        $('#errorAlert').fadeIn('fast');
                        $('#registerButton').prop('disabled', false);
                    } else {
                        $('#successText').html("Successfully Registered. You can now Login.");
                        $('#successAlert').fadeIn('fast');
                        $('#regForm').slideUp('fast');
                    }
                }
            });

        }

    });

});
