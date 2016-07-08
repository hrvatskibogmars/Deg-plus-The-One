;// first line so some shitty script does not break everything
/**
 * first way of creating module 
 */
(function( Application ) {
    // strict javascript usage, a must!
    'use strict';
    // define module name
    var moduleName =    'custommap';
    // configuration variable
    var config =    {
        id: 'map',
        lat     : 0.0,
        lng     : 0.0,
        zoom    : 17,
        markers : [],
        gmap    : null
    };

    var stylesArray = [{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"on"},{"saturation":-100},{"lightness":20}]},{"featureType":"road","elementType":"all","stylers":[{"visibility":"on"},{"saturation":-100},{"lightness":40}]},{"featureType":"water","elementType":"all","stylers":[{"visibility":"on"},{"saturation":-10},{"lightness":30}]},{"featureType":"landscape.man_made","elementType":"all","stylers":[{"visibility":"simplified"},{"saturation":-60},{"lightness":10}]},{"featureType":"landscape.natural","elementType":"all","stylers":[{"visibility":"simplified"},{"saturation":-60},{"lightness":60}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"},{"saturation":-100},{"lightness":60}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"},{"saturation":-100},{"lightness":60}]}];


    /**
     * create new module
     *
     * @type {BaseApplicationModule}
     */
    var module =    Application.createModule( moduleName, config );

    module.init =   function( elem, opts ) {
        module.config = $.extend( Object.cloneFrom( config ), opts || {} );

        // Create a new StyledMapType object, passing it the array of styles,
        // as well as the name to be displayed on the map type control.
        var styledMap = new google.maps.StyledMapType(stylesArray,
            {name: "Ultimate croatia"});

        var mapDiv = typeof elem == 'undefined' ?
            document.getElementById( module.config.id ) : elem;

        if(mapDiv.length == null) return false;

        var data = __parseLocationFromDataAttr( mapDiv, module.config.lat, module.config.lng );

        module.config.gmap = new google.maps.Map(mapDiv, {
            center: {lat: data.lat, lng: data.lng},
            zoom: module.config.zoom,
            scrollwheel: false
        });

        //Associate the styled map with the MapTypeId and set it to display.
        module.config.gmap.mapTypes.set('map_style', styledMap);
        module.config.gmap.setMapTypeId('map_style');

        __addMarker( module.config.gmap, data.lat, data.lng, module.config.markers );

        return true;
    };

    var __parseLocationFromDataAttr = function( elem ){
        if(typeof elem == 'undefined') return false;
        var $elem = $(elem);
        var location = $elem.data('location');
        if(location) {
            var locationData = location.split(':');
            var lat = parseFloat(locationData[0]);
            var lng = parseFloat(locationData[1]);
        }

        return {
            lat: lat,
            lng: lng
        };
    }

    var CustomIcon = function(url, sizeX, sizeY) {
        this.url = '../../wp-content/themes/ultimate-croatia/static/ui/map_icon_pbz.png';
        this.size = new google.maps.Size(sizeX, sizeY);
        this.origin = new google.maps.Point(0, 0);
        this.anchor = new google.maps.Point(sizeX / 2, sizeY);
    };
    // usage for instantiating custom icon
    // must be used after maps have been loaded - e.g. inside __addMarker function
    // var pbzIcon = new CustomIcon('../../wp-content/themes/ultimate-croatia/static/ui/map_icon_pbz.png', 30, 40);

    
    var __addMarker = function(gmap, lat, lng, markers) {
        var myLatLng = {lat: lat, lng: lng};
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: gmap
        });

        markers.push( marker );
    }

})( WebJS );

