$(document).ready(function(){

    $('#saveButton').click(function(){

        $('#errorAlert').fadeOut('fast');
        $(this).prop('disabled', true);
        event.preventDefault();

        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var age = $('#age').val();
        var height = $('#height').val();
        var aim_date = $('#aim_date').val();
        var aim_weight = $('#aim_weight').val();
        var gender = $('#gender').val();
        var error = "";

        if(firstname < 2){
            error += "<li>Please enter a Firstname</li>";
        }

        if(lastname < 8){
            error += "<li>Please enter a Lastname</li>";
        }

        if(age < 8){
            error += "<li>Please enter your Age</li>";
        }

        if(height < 8){
            error += "<li>Please enter your Height</li>";
        }

        if(aim_date != "" || aim_weight != ""){
            if(aim_date < 8){
                error += "<li>Please enter a Aim-Date</li>";
            }

            if(aim_weight < 8){
                error += "<li>Please enter a Aim-Weight</li>";
            }
        }

        if(gender < 0 || gender > 1){
            error += "<li>Please select a gender</li>";
        }

        if(error != ""){

            $('#errorText').html(error);
            $('#errorAlert').fadeIn('fast');
            $(this).prop('disabled', false);

        } else {

            $.ajax({
                type: "POST",
                data: {firstname:firstname, lastname:lastname, age:age, height:height, aim_date:aim_date, aim_weight:aim_weight, gender:gender},
                url: "modul/settings/updateEntry.php",
                success: function(data){
                    if(data){
                        $('#errorText').html(data);
                        $('#errorAlert').fadeIn('fast');
                        $('#saveButton').prop('disabled', false);
                    } else {
                        $('#successText').html("Successfully Saved.");
                        $('#successAlert').fadeIn('fast').delay(2000).fadeOut('fast');
                        $('#saveButton').prop('disabled', false);
                    }
                }
            });

        }

    });

});
