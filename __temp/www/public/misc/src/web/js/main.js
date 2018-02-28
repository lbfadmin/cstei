


$(document).ready(function(){
    $(".more").on("click",function(){
        $(this).children('.childerenul').stop(true,true).slideToggle()
    });

    $(".childerenul").children("li").hover(function(){
        $(this).parents(".more ").addClass("childerenulhover")
    },function(){
        $(this).parents(".more ").removeClass("childerenulhover")
    })

//    mobile
    $(".mobile_menu").on("click",function(){
        $(".memu").toggleClass("fadeInDown");
        setTimeout(function(){
            $(".innermuneheader").toggleClass('hideheader');
        },80)

    })
    $(".innermuneheader").on("click",function(){
        $(".innermunecon").toggleClass("fadeInDown2")
    })
});
