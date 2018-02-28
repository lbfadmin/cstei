


$(document).ready(function(){
    $(".more").on("click",function(){
        $(this).children('.childerenul').stop(true,true).slideToggle()
    });

    $(".childerenul").children("li").hover(function(){
        $(this).parents(".more ").addClass("childerenulhover")
    },function(){
        $(this).parents(".more ").removeClass("childerenulhover")
    })
});
