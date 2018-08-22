$(document).ready(function(){

    $('.fDelete').each(function(){
        $(this).click(function(){

            var objectID = $(this).attr('objectID');

            $.ajax({
                type: "POST",
                data: {objectID:objectID},
                url: "modul/objects/call/removePreset.php",
                success: function(data){
                    if(data){
                        $('#errorText').html(data);
                        $('#errorAlert').fadeIn('fast');
                    } else {
                        $('#successText').html("Successfully Removed.");
                        $('#successAlert').fadeIn('fast').delay(2000).fadeOut('fast');

                        $('.singleObjectEntry').each(function(){
                            if($(this).attr('objectID') == objectID){
                                $(this).slideUp('slow', function(){
                                    $(this).remove();
                                });
                            }
                        });

                    }
                }
            });

        });
    });

    $('#searchInput').on('keyup', function(){

        var input, filter, ul, li, a, i;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("searchList");
        li = ul.getElementsByClassName("searchRow");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByClassName("searchFor")[0];
            if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }

    });

    $('.objectHeader').each(function(){
        $(this).click(function(){

            var objectID = $(this).attr("objectID");

            $('.objectContent').each(function(){

                if($(this).attr("objectID") == objectID){

                    $(this).slideToggle('fast');

                } else if($(this).attr("objectID") != objectID){

                    if($(this).css('display') != 'none'){
                        $(this).slideUp('fast');
                    }

                }

            });

        });
    });

});
