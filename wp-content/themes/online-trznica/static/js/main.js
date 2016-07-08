var webJS = {
    common: {}
};

webJS.common = (function (window, document) {

    //VARIABLES

    //general
    var w = $(window);
    var body = $('body');

    var $loaderWrapper = $('.loader-wrapper');
    var $loader = $('.loader');

    //LOADER
    function pageLoader() {
        var tl = new TimelineMax({repeat: -1});

        tl.to($loader, 0.8, {
                rotation: 360,
                ease: Linear.easeNone
            });

        function closeLoader() {
            TweenMax.to($loaderWrapper, 0.6, {
                top: "-100%",
                onComplete: function() {
                    $loaderWrapper.remove();
                }
            });
        }

        $( document ).ready(function() {
            setTimeout(function(){
                closeLoader();
            }, 1600);
        });
    }

    //HEADER PARALLAX EFFECT
    function headerParallax() {
        
        var $parallaxContainer = $('.header-bg');
        var $homeHeaderHeading = $('.header-heading-wrapper');
        var $parallaxItems = $parallaxContainer.find('.cloud');
        var fixer = 0.0002;

        var $inspection = $homeHeaderHeading.find('.subheading');
        var $introText = $homeHeaderHeading.find('.intro');

        //PARALLAX ON MOUSEMOVE
        $(document).on("mousemove", function(event){

            var pageX =  event.pageX - ($parallaxContainer.width() * 0.5);

            var pageY =  event.pageY - ($parallaxContainer.height() * 0.5);

            $parallaxItems.each(function(){

                var item = $(this);
                var speedX = item.data("speed-x");
                var speedY = item.data("speed-y");

                var container = $parallaxContainer;
                var containerspeedX	= container.data("speed-x");
                var containerspeedY	= container.data("speed-y");

                TweenMax.to(item, 0.5, {
                    x: (item.position().left + pageX * speedX )*fixer,
                    y: (item.position().top + pageY * speedY)*fixer
                });

                TweenMax.to(container, 0.5, {
                    x: (item.position().left + pageX * containerspeedX )*fixer,
                    y: (item.position().top + pageY * containerspeedY)*fixer
                });

            });

        });

        //PARALLAX ON SCROLL
        function parallaxScroll(){
            var scrolled = $(window).scrollTop();

            TweenMax.to($homeHeaderHeading, 1.2, {
                y: 0-(scrolled * 0.24),
                ease: Elastic.easeOut
            });

            TweenMax.to($inspection, 1.2, {
                y: 0-(scrolled * 0.06),
                ease: Elastic.easeOut
            });

            TweenMax.to($introText, 0, {
                opacity: 1 - (scrolled / 200),
                y: 0-(scrolled * 0.28)
            });

            // TweenMax.to($parallaxContainer, 0.4, {
            //     opacity: 1 - (scrolled / 1000)
            // });

            //BLUR BG ON SCROLL
            // TweenMax.to($parallaxContainer, 0.4, {
            //     css: {
            //         "-webkit-filter" : "blur("+ (scrolled / 70) +"px)",
            //         "filter" : "blur("+ (scrolled / 70) +"px)"
            //     }
            // });
        }

        w.bind('scroll',function(e){
            parallaxScroll();
        });

    }

    function waypointAnimation() {


        // MOBILE BREAKPOINT

        var mobile_breakpoint = 640;

        // GET WINDOW WIDTH (WITHOUT SCROLLBARS)

        var win_width = window.innerWidth;

        // MARKUP EXAMPLE (SET ANIMATION - NO MOBILE ANIMATION)
        // <i data-animation-set='{"autoAlpha":"0"}'></i>
        // <i data-animation-set='{"autoAlpha":"0","top":"20px"}'></i>

        // MARKUP EXAMPLE (SET ANIMATION - WITH MOBILE ANIMATION)
        // <i data-animation-mobile data-animation-set='{"autoAlpha":"0"}'></i>
        // <i data-animation-mobile data-animation-set='{"autoAlpha":"0","top":"20px"}'></i>

        // SET ANIMATION

        $('[data-animation-set]').each(function () {

            var $el = $(this);

            var animation_option = $el.data('animation-set');
            var animation_mobile = $el.data('animation-mobile');

            if (animation_mobile == undefined) {
                if (win_width >= mobile_breakpoint) {
                    TweenMax.set($el, animation_option);
                }
            }
            else {
                TweenMax.set($el, animation_option);
            }

        });

        // MARKUP EXAMPLE
        // <i data-waypoint-offset="120%" data-animation='{"autoAlpha":"1"}' data-animation-seconds="2"></i>

        // WAYPOINT ANIMATE

        $('[data-animation]').each(function () {

            var $el = $(this);

            var el_offset = $el.data('waypoint-offset');

            var animation_options = $el.data('animation');
            var animation_seconds = $el.data('animation-seconds');

            if (animation_seconds == undefined) {
                var animation_seconds = 1;
            }

            $el.waypoint(function () {
                TweenMax.to($el, animation_seconds, animation_options);
                this.destroy();
            }, {
                offset: el_offset
            });

        });

    }

    return {
        pageLoader: pageLoader,
        headerParallax: headerParallax,
        waypointAnimation: waypointAnimation
    };


})(window, document);

$(function () {
    $(".tables__anchor").on("click",function(e){
        e.preventDefault();
        if(!$(this).hasClass("tables__anchor--occupied")){
            $(this).addClass("tables__anchor--active");
        }
    })
    $(".reset__anchor").on("click",function(e){
        e.preventDefault();
        $(".tables__anchor--active").each(function(i,e){
            $(e).removeClass("tables__anchor--active");
        })
    })
    $(".offer__form").submit(function(e){
        e.preventDefault();
       var inst= $('[data-remodal-id=thanks]').remodal();
        inst.open();
    })
    $(document).on('closed', '.remodal-thanks', function (e) {
        window.location="http://localhost:63342/deg-1/"
    });
    //webJS.common.waypointAnimation();
});
