(function ($) {
	"use strict";

    jQuery(document).ready(function($){


        $(".embed-responsive iframe").addClass("embed-responsive-item");
        $(".carousel-inner .item:first-child").addClass("active");
        
        $('[data-toggle="tooltip"]').tooltip();
        

        var contador = 1;
        var ancho = $(document).width();


    $('.menu-toggle').click(function(){
        
        if (contador == 1){
            $('.mdisplay').animate({
                left: '0'
            });
            contador = 0;
        } else {
            contador = 1;
            $('.mdisplay').animate({
                left: '-100%'
            });
        };
        
    });


    });


    jQuery(window).load(function(){

        jQuery(".industry-slide-preloader, .preloader-circle-wrapper").fadeOut(500);
        jQuery(".preloader, .spinner").delay(500).fadeOut(500);

    });


}(jQuery));	