jQuery(function($) {
    'use strict';

    (function() {
        $(window).on('load', function() {

            /*
            =========================================================================================
            1. Spinner 
            =========================================================================================
            */
            $(".outslider_loading").fadeOut("slow");

        });
    }());
    (function() {
        $(window).on('scroll', function() 
		{
            /*
            =========================================================================================
            2. NAVBAR 
            =========================================================================================
            */

            if ($(window).scrollTop() > 10) {
                $(".header-area").addClass("ds_padding");
            } else {
                $(".header-area").removeClass("ds_padding");
            }

            var topHeight = $(".rev_slider_wrapper").outerHeight();
            var windowScroll = $(window).scrollTop();

            if (windowScroll > topHeight) {
                $(".onepage nav").addClass("navbar-fixed-top");
            } else {
                $(".onepage nav").removeClass("navbar-fixed-top");
            }

            var topHeight2 = $(".v3-header-top").outerHeight();
            var windowScroll2 = $(window).scrollTop();

            if (windowScroll2 > topHeight2) {
                $(".v3-header nav").addClass("navbar-fixed-top");
            } else {
                $(".v3-header nav").removeClass("navbar-fixed-top");
            }

            if ($(window).scrollTop() > topHeight2) {
                $(".v3-header-bg").addClass("ds_padding");
            } else {
                $(".v3-header-bg").removeClass("ds_padding");
            }
            var topHeight3 = $(".v3-header-top2").outerHeight();
            var windowScroll3 = $(window).scrollTop();


            if (windowScroll3 > topHeight3) {
                $(".v3-header nav").addClass("navbar-fixed-top");
            } else {
                $(".v3-header nav").removeClass("navbar-fixed-top");
            }
            if ($(window).scrollTop() > topHeight3) {
                $(".rev_slider_wrapper11").addClass("rev-margin");
            } else {
                $(".rev_slider_wrapper11").removeClass("rev-margin");
                $(".rev_slider_wrapper11").css("margin-top","0");                
            }
            if ($(window).scrollTop() > 10) {
                $(".v15-header").addClass("toogle_logo");
            } else {
                $(".v15-header").removeClass("toogle_logo");
            }

            $(".page").each(function() {
                var bb = $(this).attr("id");
                var hei = $(this).outerHeight();
                var grttop = $(this).offset().top - 80;
                if ($(window).scrollTop() > grttop - 1 && $(window).scrollTop() < grttop + hei - 1) {
                    var uu = $(".one-page > li >a[href='#" + bb + "']").parent().addClass("active");
                } else {
                    var uu = $(".one-page > li >a[href='#" + bb + "']").parent().removeClass("active");
                }
            });

            if ($(window).scrollTop() > 10) {
                $(".p-title-header-area").css("background-color", "#222");
            } else {
                $(".p-title-header-area").css("background-color", "transparent");
            }

            if ($(window).scrollTop() > 10) {
                $(".header-12-bg").addClass("menuzord-12");
            } else {
                $(".header-12-bg").removeClass("menuzord-12");
            }

            if ($(window).scrollTop() > 30) {
                $(".header-13").css("padding-top", "0px");
            } else {
                $(".header-13").css("padding-top", "30px");
            }

            /*
            =========================================================================================
            3. PROGRESS BAR
            =========================================================================================
            */

            $(".progress_cont").each(function() {
                var base = $(this);
                var windowHeight = $(window).height();
                var itemPos = base.offset().top;
                var scrollpos = $(window).scrollTop() + windowHeight - 100;
                if (itemPos <= scrollpos) {
                    var auptcoun = base.find(".progress-bar").attr("aria-valuenow");
                    base.find(".progress-bar").css({
                        "width": auptcoun + "%"
                    });
                    var str = base.find(".skill>span").text();
                    var res = str.replace("%", "");
                    if (res == 0) {
                        $({
                            countNumber: 0
                        }).animate({
                            countNumber: auptcoun
                        }, {
                            duration: 4000,
                            easing: 'linear',
                            step: function() {
                                base.find(".skill>span").text(Math.ceil(this.countNumber) + "%");
                            }
                        });
                    }
                }
            });

        });
    }());



    (function() {
        /*
        =========================================================================================
        3. TOOLTIP
        =========================================================================================
        */
        $('[data-toggle="tooltip"]').tooltip();
        /*
        =========================================================================================
        4. MEGA MENU
        =========================================================================================
        */
        $("#menuzord").menuzord();

        $(".menuzord-menu > li >a").click(function() {
            $(this).parent().addClass("active");
            $(".menuzord-menu > li >a").not(this).parent().removeClass("active");
            var TargetId = $(this).attr('href');
            $('html, body').animate({
                scrollTop: $(TargetId).offset().top - 50
            }, 1000, 'swing');
            return false;
        });

        $(".history-panel-title a").on('click', function() {
            $(this).find('.arrow-minus').toggleClass();
        });


    }());
});