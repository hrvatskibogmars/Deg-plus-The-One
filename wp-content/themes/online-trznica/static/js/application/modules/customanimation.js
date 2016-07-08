;// first line so some shitty script does not break everything
/**
 * first way of creating module
 */
(function( Application ) {
    // strict javascript usage, a must!
    'use strict';
    // define module name
    var moduleName =    'customanimation'; 
    // configuration variable
    var config =    {
        el: 'detail-gallery'
    };
    /**
     * create new module
     *
     * @type {BaseApplicationModule}
     */
    var module =    Application.createModule( moduleName, config );

    module.scrollTo = function (scroolToAnchor) {
        module.config = $.extend( Object.cloneFrom( config ), scroolToAnchor || {} );

        //activate scroll to
        $(document).on('click', '[data-scroll-to="on"]', function (e) {
            e.preventDefault();
            var scroolToAnchor = $(this).data('scroll-to-target');
            TweenMax.to($('html, body'), 1, {scrollTop: $(scroolToAnchor).offset().top, ease: Power4.easeInOut});
        });

    };

    module.hoverGoToTop = function (opts) {
        module.config = $.extend( Object.cloneFrom( config ), opts || {} );

        var tl = new TimelineMax({ paused: true }),
            link = '.copy__gototop',
            el = '.icon-up',
            anim1 = '-10x',
            anim2 = '10px',
            anim3 = '0px';

        __doHoverTranslate(tl, link, el, anim1, anim2, anim3);
    };

    module.hoverPlay = function (opts) {
        module.config = $.extend( Object.cloneFrom( config ), opts || {} );

        var tl = new TimelineMax({ paused: true }),
            link = '.video__link',
            el = '.icon-play',
            anim1 = '-11x',
            anim2 = '11px',
            anim3 = '0px';

        __doHoverTranslate(tl, link, el, anim1, anim2, anim3);
    };

    function __doHoverTranslate(timeline, link, el, anim1, anim2, anim3) {

        timeline.add('start')
            .to(el, 0.3, { y: anim1, opacity: 0 })
            .to(el, 0, { y: anim2, opacity: 0 })
            .to(el, 0.3, { y: anim3, opacity: 1 });

        $(document).on('mouseenter', link, function () {
            if(timeline.progress() < 1){
                timeline.play();
            } else {
                timeline.restart();
            }
        });

        $(document).on('mouseleave', link, function () {
            if(timeline.progress() < 1){
                timeline.reverse();
            } else {
                timeline.restart();
            }
        });
    }

})( WebJS );

