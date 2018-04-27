function makeDynamic(objectThis){
    var href = $(objectThis).attr('href');

    $(objectThis).click(function(event){
        event.preventDefault();
        $("#pageContent").fadeOut(50, function(){
            var newUrl = href.replace('modul/','').replace('.php','');
            goBack(href);
        });
    });
}

function goBack(href){
    if (href){

        $("#pageContent").load(href, function(response, status, xhr){

            if ( status == "error" ) {
                var msg = "makeDynamic Error";
                console.log( msg + xhr.status + " " + xhr.statusText );
                window.location.replace("logout.php");
            } else {
                $('#pageContent').fadeTo(50, 1);
            }

        });
    }
}

$(document).ready(function(){

    $(window).on('popstate',function(event) {

        var href = history.state["info"];

        $("#pageContent").fadeOut("fast", function(){
            goBack(href);
        });

    });

    $('.navbar-collapse a').click(function(event){
        event.preventDefault;
        $(".navbar-collapse").collapse('hide');
    });

    $("#pageContent").load($("#pageContent").attr("page"), function(){

        var state = {info: $("#pageContent").attr("page")};
        history.pushState(state, "index.php");

    });

    $(".nav-link").each(function(){
        makeDynamic(this);
    });

    $(".navbar-brand").each(function(){
        makeDynamic(this);
    });

});
