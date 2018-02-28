


$(document).ready(function(){
    $(".more").on("click",function(){
        $(this).children('.childerenul').stop(true,true).slideToggle()
    });
});
