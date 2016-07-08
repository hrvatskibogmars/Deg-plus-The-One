;// first line so some shitty script does not break everything
/**
 * first way of creating module
 */
(function( Application ) {
    // strict javascript usage, a must!
    'use strict';
    // define module name
    var moduleName =    'videos';
    // configuration variable
    var config =    {
        wrapper: 'video-wrapper'
    };
    /**
     * create new module
     *
     * @type {BaseApplicationModule}
     */
    var module =    Application.createModule( moduleName, config );

    module.playVideo =   function( opts ) {
        module.config = $.extend( Object.cloneFrom( config ), opts || {} );

        $.js(module.config.wrapper).each(function () {
            var $self = $(this);

            $self.find('a').on('click', function(e) {
                e.preventDefault();
                __removeVideoOverlay($(this));
                $self.find('iframe')[0].src += "&autoplay=1";
            });
        });

    };

    function __removeVideoOverlay(link) {

        TweenLite.to(link, 1, { ease: Bounce.easeOut, y: '100%', onComplete: function() {
            TweenLite.to(link, 0.6, { autoAlpha: 0 });
            TweenLite.to(link.parent(), 0.6, { autoAlpha: 0 });
        } });
    }

})( WebJS );

