function openDayCal(dayID){
    $('.removableEntry').each(function(){
        if($(this).attr('dayID') == dayID){
            $(this).slideToggle('slow');
        }
    });
}
$(document).ready(function(){

    $('.deleteCalEntry').each(function(){
        $(this).click(function(){

            var entryID = $(this).attr('id');

            $.ajax({
                type: "POST",
                data: {entryID:entryID},
                url: "modul/calories/modify.php",
                success: function(data){
                    if(data){
                        $('#errorText').html(data);
                        $('#errorAlert').fadeIn('fast');
                    } else {
                        $('.removableEntry').each(function(){
                            if($(this).attr('id') == entryID){
                                $(this).slideUp('slow');
                            }
                        });
                    }
                }
            });

        });
    });

});
