function reload(onstart){
    $('#facts').load( "modul/dashboard/getFacts.php", function(){
        if(onstart){
            $('#facts').slideDown('slow');
        }
    });
    $('#entries').load( "modul/dashboard/getEntries.php", function(){
        if(onstart){
            $('#entries').slideDown('slow');
        }
    });
}

function delEntry(entryID){

    $.ajax({
        type: "POST",
        data: {entryID:entryID},
        url: "modul/dashboard/removeWeight.php",
        success: function(data){
            if(data){
                $('#errorText').html(data);
                $('#errorAlert').fadeIn('fast');
            } else {
                $('#successText').html("Successfully Removed.");
                $('#successAlert').fadeIn('fast').delay(2000).fadeOut('fast');
                reload();
            }
        }
    });

}

function timeStamp() {

    var now = new Date();

    var date = [ now.getFullYear(), now.getMonth() + 1, now.getDate() ];
    var time = [ now.getHours(), now.getMinutes(), now.getSeconds() ];

    for ( var i = 1; i < 3; i++ ) {
        if ( time[i] < 10 ) {
            time[i] = "0" + time[i];
        }
    }

    return date.join("-") + " " + time.join(":");

}

function setTimestamp() {
    setTimeout(function () {
        $('#inputDate').val(timeStamp());
        setTimestamp();
    }, 1000);
    setTimeout(function () {
        $('#inputCalDate').val(timeStamp());
        setTimestamp();
    }, 1000);
}

$(document).ready(function(){

    function addCalEntry(){

        $('#errorAlert').fadeOut('fast');
        $('#addCalButton').prop('disabled', true);

        var title = $('#inputCalTitle').val();
        var date = $('#inputCalDate').val();
        var amount = $('#inputCalAmount').val();
        var calories = $('#inputCal').val();
        var error = "";

        if(date < 8){
            error += "<li>Please enter a Date</li>";
        }

        if(amount < 0){
            error += "<li>Please enter a correct Amount</li>";
        }

        if(calories < 1){
            error += "<li>Please enter Calories</li>";
        }

        if(error != ""){

            $('#errorText').html(error);
            $('#errorAlert').fadeIn('fast');
            $('#addCalButton').prop('disabled', false);

        } else {

            $.ajax({
                type: "POST",
                data: {date:date, amount:amount, title:title, calories:calories},
                url: "modul/dashboard/addCalories.php",
                success: function(data){
                    if(data){
                        $('#errorText').html(data);
                        $('#errorAlert').fadeIn('fast');
                        $('#addCalButton').prop('disabled', false);
                    } else {
                        $('#successText').html("Successfully Added.");
                        $('#successAlert').fadeIn('fast').delay(2000).fadeOut('fast');

                        reload();

                        $('#inputCalTitle').val("");
                        $('#inputCalDate').val("");
                        $('#inputCalAmount').val("1");
                        $('#inputCal').val("");
                        $('#addCalButton').prop('disabled', false);

                    }
                }
            });

        }

    }

    function addEntry(){

        $('#errorAlert').fadeOut('fast');
        $('#addEntryButton').prop('disabled', true);

        var date = $('#inputDate').val();
        var weight = $('#inputWeight').val();
        var error = "";

        if(date < 2){
            error += "<li>Please enter a correct Date</li>";
        }

        if(weight < 8){
            error += "<li>Please enter a weight</li>";
        }

        if(error != ""){

            $('#errorText').html(error);
            $('#errorAlert').fadeIn('fast');
            $('#addEntryButton').prop('disabled', false);

        } else {

            $.ajax({
                type: "POST",
                data: {date:date, weight:weight},
                url: "modul/dashboard/addWeight.php",
                success: function(data){
                    if(data){
                        $('#errorText').html(data);
                        $('#errorAlert').fadeIn('fast');
                        $('#addEntryButton').prop('disabled', false);
                    } else {
                        $('#successText').html("Successfully Added.");
                        $('#successAlert').fadeIn('fast').delay(2000).fadeOut('fast');

                        reload();

                        $('#inputWeight').val("");
                        $('#inputDate').val()
                        $('#addEntryButton').prop('disabled', false);

                    }
                }
            });

        }


    }

    reload(1);
    $('#addEntryBox').slideDown('fast');

    setTimestamp();

    /*$(document).keypress(function(e) {  ---> To be fixed
        if(e.which == 13) {
            addEntry();
        }
    });*/

    $('#addEntryButton').click(function(event){
        event.preventDefault();
        addEntry();
    });

    $('#addCalButton').click(function(event){
        event.preventDefault();
        addCalEntry();
    });

});
