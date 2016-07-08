;// first line so some shitty script does not break everything
/**
 * first way of creating module
 */
(function( Application ) {
    // strict javascript usage, a must!
    'use strict';
    // define module name
    var moduleName =    'custommenu';
    // configuration variable
    var config =    {
        box1: 'box1',
        box2: 'box2',
        box3: 'box3',
        box4: 'box4',
        box5: 'box5',
        box6: 'box6',
        primary: '.primary li',
        nav: '.mobile-navigation',
        burger: 'burger',
        top: '.navigation-wrapper',
        body: 'body'
    };

    /**
     * create new module
     *
     * @type {BaseApplicationModule}
     */
    var module =    Application.createModule( moduleName, config );

    module.init =   function( opts ) {
        module.config = $.extend( Object.cloneFrom( config ), opts || {} );

        var box1 = $.js(module.config.box1),
            box2 = $.js(module.config.box2),
            box3 = $.js(module.config.box3),
            box4 = $.js(module.config.box4),
            box5 = $.js(module.config.box5),
            box6 = $.js(module.config.box6),
            primary = $(module.config.primary),
            nav = $(module.config.nav),

            height = window.innerHeight
            || document.documentElement.clientHeight
            || document.body.clientHeight,

            menuHeight = $(module.config.top).outerHeight();

        // __showMenu(box1, box2, box3, box4, box5, box6, nav, primary);
        // __hideMenu(box1, box2, box3, box4, box5, box6, nav, primary);

        var toggles = document.querySelectorAll(".c-hamburger");

        for (var i = toggles.length - 1; i >= 0; i--) {
            var toggle = toggles[i];
            toggleHandler(toggle);
        };

        function toggleHandler(toggle) {
            toggle.addEventListener( "click", function(e) {
                e.preventDefault();
                if(this.classList.contains("is-active") === true) {
                    this.classList.remove("is-active");
                    __hideMenu(box1, box2, box3, box4, box5, box6, nav, primary);
                } else {
                    this.classList.add("is-active");
                    __showMenu(box1, box2, box3, box4, box5, box6, nav, primary);
                    __setMenuHeight(nav, height, menuHeight);
                }
                // shorts
                // (this.classList.contains("is-active") === true) ? this.classList.remove("is-active"): this.classList.add("is-active");
            });
        }

        $(window).resize(function () {

            height = window.innerHeight
                || document.documentElement.clientHeight
                || document.body.clientHeight,

            __setMenuHeight(nav, height, menuHeight);
        });
    };

    /**
     *
     * @private
     */

    var __showMenu = function(box1, box2, box3, box4, box5, box6, nav, primary) {

        var timeline = new TimelineLite({
                paused: !0
            }),
            time = .25;

        timeline.kill(), timeline.call(function () {
            nav.addClass("ready");
            $('body').addClass("is-fixed");
            TweenLite.to($('html, body'), 1, {scrollTop: $('body').offset().top, ease: Power4.easeInOut});
        }), timeline.set(primary, {
            autoAlpha: 0
        }), timeline.set(nav, {
            autoAlpha: 1
        }), timeline.add([TweenLite.fromTo(box1, time, {
            autoAlpha: 0,
            x: 20,
            y: 20,
            rotationY: 20
        }, {
            autoAlpha: 1,
            x: 0,
            y: 0,
            rotationY: 0,
            delay: 0,
            ease: Linear.easeNone,
            force3D: !0
        })], [TweenLite.fromTo(box2, time, {
            autoAlpha: 0,
            x: 20,
            y: 20,
            rotationY: 20
        }, {
            autoAlpha: 1,
            x: 0,
            y: 0,
            rotationY: 0,
            delay: .1,
            ease: Linear.easeNone,
            force3D: !0
        })], [TweenLite.fromTo(box3, time, {
            autoAlpha: 0,
            x: 20,
            y: 20,
            rotationY: 20
        }, {
            autoAlpha: 1,
            x: 0,
            y: 0,
            rotationY: 0,
            delay: .2,
            ease: Linear.easeNone,
            force3D: !0
        })], [TweenLite.fromTo(box4, time, {
            autoAlpha: 0,
            x: 20,
            y: 20,
            rotationY: 20
        }, {
            autoAlpha: 1,
            x: 0,
            y: 0,
            rotationY: 0,
            delay: .3,
            ease: Linear.easeNone,
            force3D: !0
        })], [TweenLite.fromTo(box5, time, {
            autoAlpha: 0,
            x: 20,
            y: 20,
            rotationY: 20
        }, {
            autoAlpha: 1,
            x: 0,
            y: 0,
            rotationY: 0,
            delay: .4,
            ease: Linear.easeNone,
            force3D: !0
        })], [TweenLite.fromTo(box6, time, {
            autoAlpha: 0,
            x: 20,
            y: 20,
            rotationY: 20
        }, {
            autoAlpha: 1,
            x: 0,
            y: 0,
            rotationY: 0,
            delay: .5,
            ease: Linear.easeNone,
            force3D: !0
        })]),
            timeline.add([TweenMax.staggerFromTo(primary, time + .2, {
            y: 10
        }, {
            autoAlpha: 1,
            y: 0,
            ease: Power3.easeOut,
            force3D: !0
        }, .05)], "+=.25"),
            timeline.restart(), timeline.call(function () {
            nav.css('background', '#ffffff');
        })
    };

    /**
    *
    * @private
    **/
    var __hideMenu = function(box1, box2, box3, box4, box5, box6, nav, primary) {

        var timeline = new TimelineLite({
                paused: !0
            }),
            time = .25;

        timeline.kill(), timeline.call(function () {
           nav.css('background', 'transparent');
        }), timeline.add([TweenMax.staggerFromTo(primary, time + .2, {
            y: 0
        }, {
            autoAlpha: 0,
            y: -10,
            ease: Power3.easeOut,
            force3D: !0
        }, .05)]), timeline.add([TweenLite.fromTo(box6, time, {
            autoAlpha: 1,
            x: 0,
            y: 0,
            rotationY: 0
        }, {
            autoAlpha: 0,
            x: 20,
            y: 20,
            rotationY: 20,
            delay: 0,
            ease: Linear.easeNone,
            force3D: !0
        })], [TweenLite.fromTo(box5, time, {
            autoAlpha: 1,
            x: 0,
            y: 0,
            rotationY: 0
        }, {
            autoAlpha: 0,
            x: 20,
            y: 20,
            rotationY: 20,
            delay: .1,
            ease: Linear.easeNone,
            force3D: !0
        })], [TweenLite.fromTo(box4, time, {
            autoAlpha: 1,
            x: 0,
            y: 0,
            rotationY: 0
        }, {
            autoAlpha: 0,
            x: 20,
            y: 20,
            rotationY: 20,
            delay: .2,
            ease: Linear.easeNone,
            force3D: !0
        })], [TweenLite.fromTo(box3, time, {
            autoAlpha: 1,
            x: 0,
            y: 0,
            rotationY: 0
        }, {
            autoAlpha: 0,
            x: 20,
            y: 20,
            rotationY: 20,
            delay: .3,
            ease: Linear.easeNone,
            force3D: !0
        })], [TweenLite.fromTo(box2, time, {
            autoAlpha: 1,
            x: 0,
            y: 0,
            rotationY: 0
        }, {
            autoAlpha: 0,
            x: 20,
            y: 20,
            rotationY: 20,
            delay: .4,
            ease: Linear.easeNone,
            force3D: !0
        })], [TweenLite.fromTo(box1, time, {
            autoAlpha: 1,
            x: 0,
            y: 0,
            rotationY: 0
        }, {
            autoAlpha: 0,
            x: 20,
            y: 20,
            rotationY: 20,
            delay: .5,
            ease: Linear.easeNone,
            force3D: !0
        })]), timeline.set(nav, {
            autoAlpha: 0
        }), timeline.call(function () {
            nav.removeClass("ready");
            $('body').removeClass("is-fixed");
        }), timeline.restart()
    }

    /**
     *
     * @private
     **/ 
    var __setMenuHeight = function (nav, height, menuHeight) {
        nav.css('padding-top', menuHeight);
        nav.find('.primary').css('height', height).css('height', '-='+ menuHeight +'');
    }

})( WebJS );

