$(document).ready(function()
{
    $("#sbmenu_btn").click(function(){

        if($(window).width() > 568 )
            ToggleMenu();
        
        else
        {
            if($("#submenu").hasClass("submenu_small"))
                ToggleMenu();
                

            $("#submenu").animate({width:'toggle'},350);
        }
        
    });

    function ToggleMenu()
    {
        $("#submenu").toggleClass("submenu_small");
        $("#submenu").toggleClass("pure-u-sm-1-4 pure-u-md-1-4 pure-u-lg-1-6");
        $("#submenu").toggleClass("pure-u-sm-2-24 pure-u-md-2-24 pure-u-lg-1-24");
        $("#bdysbncontent").toggleClass("pure-u-sm-21-24 pure-u-md-22-24 pure-u-lg-23-24");
        $("#bdysbncontent").toggleClass("pure-u-sm-22-24 pure-u-md-18-24 pure-u-lg-20-24");


        $(".icono_sbmenu").toggleClass("pure-u-3-24");
        $(".icono_sbmenu").toggleClass("pure-u-1");
        $(".subitems_menu").hide();
    }

    $(".item_sb").click(function()
    {
        $(this).children(".subitems_menu").slideToggle();
    });


    $(window).resize(function(){
        CheckSubMenu();
    });
    
    function CheckSubMenu()
    {
        if($(window).width() <= 568 )
        {
            if( $("#submenu").is(":visible") )
                $("#submenu").hide();
            
                
        }
        else
        {
            if( ! $("#submenu").is(":visible") )
                $("#submenu").show();
        }
    }

    CheckSubMenu();
});