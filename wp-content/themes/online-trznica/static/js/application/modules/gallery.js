;// first line so some shitty script does not break everything
/**
 * first way of creating module 
 */
(function( Application ) {
    // strict javascript usage, a must!
    'use strict';
    // define module name
    var moduleName =    'gallery';
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

    module.init =   function( opts ) {
        module.config = $.extend( Object.cloneFrom( config ), opts || {} );

        $.js(module.config.el).lightGallery({
            mode: 'lg-zoom-out-in',
            selector: ".gallery__item"
        });
    };

})( WebJS );

