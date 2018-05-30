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

            var itemID = $(this).attr('id');

            $('.removableEntry').each(function(){
                if($(this).attr('id') == itemID){
                    $(this).slideUp('slow');
                }
            });

        });
    });

});
