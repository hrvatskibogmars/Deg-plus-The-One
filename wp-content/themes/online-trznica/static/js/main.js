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

    //PAGINATION
    function pagination_articles() {
        $('.pag-articles').on('click', 'li', function(e){
            e.preventDefault();
            var $self = $(this);
            if($self.hasClass('processing')) {
                return;
            } else {
                $self.addClass('processing');
            }
            var $pager = $('#pager');
            //$("#preloader").show();

            var selectedPage;
            if($self.data('val') == 'prev') {
                if($pager.val() == 1) {
                    $self.removeClass('processing');
                    return;
                }
                selectedPage = parseInt($pager.val()) - 1;
            } else if($self.data('val') == 'next') {
                if($pager.data('max') == $pager.val()) {
                    $self.removeClass('processing');
                    return;
                }
                selectedPage = parseInt($pager.val()) + 1;
            } else {
                selectedPage = $self.data('val');
            }
            var data = {
                action: 'my_pagination_articles',
                page: selectedPage,
            };
            $.post(ajaxurl, data, function(response) {
                $('#nav-main').fadeOut(0, function(){
                    $(this).html(response.nav).fadeIn(500);
                });
                $('.pagination-item').removeClass('active');
                $("#" + selectedPage).addClass('active');
                $('#article-list').fadeOut(0, function(){
                    $(this).html(response).fadeIn(500);
                });
                $pager.val(selectedPage);
                //$("#preloader").hide();

                $self.removeClass('processing');
                return false;
            }, 'json');
        });
    }

    function getAllDataPag(action, page) {
        var food = $('#food').val();
        var decor = $('#decor').val();
        var service = $('#service').val();
        var cost = $('#cost').val();
        var tag = [];
        var type = [];
        var loc = [];
        $('.active-checked').each(function () {
            if($(this).hasClass('location')) {
                if($.inArray($(this).val(), loc) == -1 ) {
                    loc.push($(this).val());
                }
            } else if($(this).hasClass('cuisine')) {
                if($.inArray($(this).val(), type) == -1 ) {
                    type.push($(this).val());
                }
            } else {
                if($.inArray($(this).val(), tag) == -1 ) {
                    tag.push($(this).val());
                }
            }
        });
        if(loc.length == 0) {
            loc.push($( "#select-regions option:selected" ).val());
        }

        var data = {
            action: action,
            food: food,
            decor: decor,
            service: service,
            cost: cost,
            page: page,
            tag: tag,
            type: type,
            loc: loc,
            update_numbers: 'true'
        };

        return data;

    }

    //PAGINATION
    function pagination_main() {
        $('#nav-main').on('click', 'li', function(e){
            e.preventDefault();
            var $self = $(this);
            if($self.hasClass('processing')) {
                return;
            } else {
                $self.addClass('processing');
            }
            var $pager = $('#page');
            //$("#preloader").show();

            var selectedPage;
            if($self.data('val') == 'prev') {
                if($pager.val() == 1) {
                    $self.removeClass('processing');
                    return;
                }
                selectedPage = parseInt($pager.val()) - 1;
            } else if($self.data('val') == 'next') {
                if($pager.data('max') == $pager.val()) {
                    $self.removeClass('processing');
                    return;
                }
                selectedPage = parseInt($pager.val()) + 1;
            } else {
                selectedPage = $self.data('val');
            }
            var data = getAllDataPag('filter_update', selectedPage);
            $.post(ajaxurl, data, function(response) {
                $('#nav-main').fadeOut(0, function(){
                    $(this).html(response.nav).fadeIn(500);
                });
                $('.pagination-item').removeClass('active');
                $("#" + selectedPage).addClass('active');
                $('#main-items').fadeOut(0, function(){
                    $(this).html(response.main).fadeIn(500);
                });
                $pager.val(selectedPage);
                //$("#preloader").hide();

                $self.removeClass('processing');
                return false;
            }, 'json');
        });
    }

    return {
        pageLoader: pageLoader,
        waypointAnimation: waypointAnimation,
        pagination_articles: pagination_articles,
        pagination_main: pagination_main
    };


})(window, document);

$(function () {
    webJS.common.pageLoader();
    webJS.common.pagination_articles();
    webJS.common.pagination_main();
    //webJS.common.waypointAnimation();
});

//SVG XUSE POLYFILL

/*!
 * @copyright Copyright (c) 2016 IcoMoon.io
 * @license   Licensed under MIT license
 *            See https://github.com/Keyamoon/svgxuse
 * @version   1.1.7
 */
/*jslint browser: true */
/*global XDomainRequest, MutationObserver, window */
(function () {
    'use strict';
    if (window && window.addEventListener) {
        var cache = Object.create(null); // holds xhr objects to prevent multiple requests
        var checkUseElems,
            tid; // timeout id
        var debouncedCheck = function () {
            clearTimeout(tid);
            tid = setTimeout(checkUseElems, 100);
        };
        var unobserveChanges = function () {
            return;
        };
        var observeChanges = function () {
            var observer;
            if (window.MutationObserver) {
                observer = new MutationObserver(debouncedCheck);
                observer.observe(document.documentElement, {
                    childList: true,
                    subtree: true,
                    attributes: true
                });
                unobserveChanges = function () {
                    try {
                        observer.disconnect();
                    } catch (ignore) {}
                };
            } else {
                document.documentElement.addEventListener('DOMSubtreeModified', debouncedCheck, false);
                unobserveChanges = function () {
                    document.documentElement.removeEventListener('DOMSubtreeModified', debouncedCheck, false);
                };
            }
        };
        var xlinkNS = 'http://www.w3.org/1999/xlink';
        checkUseElems = function () {
            var base,
                bcr,
                fallback = '', // optional fallback URL in case no base path to SVG file was given and no symbol definition was found.
                hash,
                i,
                Request,
                inProgressCount = 0,
                isHidden,
                url,
                uses,
                xhr;
            if (window.XMLHttpRequest) {
                Request = new XMLHttpRequest();
                if (Request.withCredentials !== undefined) {
                    Request = XMLHttpRequest;
                } else {
                    Request = XDomainRequest || undefined;
                }
            }
            if (Request === undefined) {
                return;
            }
            function observeIfDone() {
                // If done with making changes, start watching for chagnes in DOM again
                inProgressCount -= 1;
                if (inProgressCount === 0) { // if all xhrs were resolved
                    observeChanges(); // watch for changes to DOM
                }
            }
            function onload(xhr) {
                return function () {
                    var body = document.body;
                    var x = document.createElement('x');
                    var svg;
                    xhr.onload = null;
                    x.innerHTML = xhr.responseText;
                    svg = x.getElementsByTagName('svg')[0];
                    if (svg) {
                        svg.style.position = 'absolute';
                        svg.style.width = 0;
                        svg.style.height = 0;
                        body.insertBefore(svg, body.firstChild);
                    }
                    observeIfDone();
                };
            }
            function onErrorTimeout(xhr) {
                return function () {
                    xhr.onerror = null;
                    xhr.ontimeout = null;
                    observeIfDone();
                };
            }
            unobserveChanges(); // stop watching for changes to DOM
            // find all use elements
            uses = document.getElementsByTagName('use');
            for (i = 0; i < uses.length; i += 1) {
                try {
                    bcr = uses[i].getBoundingClientRect();
                } catch (ignore) {
                    // failed to get bounding rectangle of the use element
                    bcr = false;
                }
                url = uses[i].getAttributeNS(xlinkNS, 'href').split('#');
                base = url[0];
                hash = url[1];
                isHidden = bcr && bcr.left === 0 && bcr.right === 0 && bcr.top === 0 && bcr.bottom === 0;
                if (bcr && bcr.width === 0 && bcr.height === 0 && !isHidden) {
                    // the use element is empty
                    // if there is a reference to an external SVG, try to fetch it
                    // use the optional fallback URL if there is no reference to an external SVG
                    if (fallback && !base.length && hash && !document.getElementById(hash)) {
                        base = fallback;
                    }
                    if (base.length) {
                        xhr = cache[base];
                        if (xhr !== true) {
                            uses[i].setAttributeNS(xlinkNS, 'xlink:href', '#' + hash);
                        }
                        if (xhr === undefined) {
                            xhr = new Request();
                            cache[base] = xhr;
                            xhr.onload = onload(xhr);
                            xhr.onerror = onErrorTimeout(xhr);
                            xhr.ontimeout = onErrorTimeout(xhr);
                            xhr.open('GET', base);
                            xhr.send();
                            inProgressCount += 1;
                        }
                    }
                } else {
                    // remember this URL if the use element was not empty and no request was sent
                    if (!isHidden && cache[base] === undefined) {
                        cache[base] = true;
                    }
                }
            }
            uses = '';
            inProgressCount += 1;
            observeIfDone();
        };
        // The load event fires when all resources have finished loading, which allows detecting whether SVG use elements are empty.
        window.addEventListener('load', function winLoad() {
            window.removeEventListener('load', winLoad, false); // to prevent memory leaks
            checkUseElems();
        }, false);
    }
}());