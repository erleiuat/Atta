function delEntry(entryID){

    $.ajax({
        type: "POST",
        data: {entryID:entryID},
        url: "modul/weights/removeWeight.php",
        success: function(data){
            if(data){
                $('#errorText').html(data);
                $('#errorAlert').fadeIn('fast');
            } else {
                $('#successText').html("Successfully Removed.");
                $('#successAlert').fadeIn('fast').delay(2000).fadeOut('fast');

                $('.deletableEntry').each(function(){
                    if($(this).attr("entryID") == entryID){
                        $(this).slideUp('slow');
                    }
                });

            }
        }
    });

}
