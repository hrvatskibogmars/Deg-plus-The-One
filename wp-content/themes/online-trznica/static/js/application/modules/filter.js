;// first line so some shitty script does not break everything
/**
 * first way of creating module 
 */
(function( Application ) {
    // strict javascript usage, a must!
    'use strict';
    // define module name
    var moduleName =    'filter';
    // configuration variable
    var config =    {
        filterSlider: 'filterslider',
        // default slider config
        start: 0,
        step: 1,
        min: 0,
        max: 5
    };
    /**
     * create new module
     * 
     * @type {BaseApplicationModule}
     *
     */
    var module =    Application.createModule( moduleName, config );

    module.customUiSlider =   function( opts ) {
        module.config = $.extend( Object.cloneFrom( config ), opts || {} );

        // sliders in filter section
        var $slider =  $.js(module.config.filterSlider);

        var noUiSliders = [];

        // create N sliders in filter section
        $slider.each(function() {
            var $self = $(this),
                $nbr = $self.prev().find('strong'),
                $input = $self.next();

            // if settings are not defined on slider, use defaults
            noUiSlider.create(this, {
                start: ($self.data('start') ? $self.data('start'):module.config.start),
                step: ($self.data('step') ? $self.data('step'):module.config.step),
                range: {
                    'min': ($self.data('min') ? $self.data('min'):module.config.min),
                    'max': ($self.data('max') ? $self.data('max'):module.config.min),
                }
            });

            var timer;                //timer identifier
            var doneInterval = 1000;  //time in ms

            this.noUiSlider.on('slide', function( values, handle ) {
                // update nbr in a label
                $nbr.html(parseInt(values[handle]));
                // update hidden input
                $input.val(values[handle]);
                clearTimeout(timer);
                timer = setTimeout(doneUpdate, doneInterval);

            });
            noUiSliders[$input.data('id')] = this;
        });

        function sliderReset(slider) {
            for (var key in noUiSliders) {
                if(slider == 'all' || slider == key) {
                    if(key == 'cost') {
                        $('[data-id=' + key + ']').val(5);
                        $('[data-name=' + key + ']').text(5);
                        noUiSliders[key].noUiSlider.set(5);
                    } else {
                        $('[data-id=' + key + ']').val(0);
                        $('[data-name=' + key + ']').text(0);
                        noUiSliders[key].noUiSlider.set(0);
                    }

                }
            }
        }

        var selectRegion = $('#select-regions');
        var type = selectRegion.data('type');
        selectRegion.change(function() {
            $('.location').removeClass('active-checked');
            var data = {
                action: 'region_change',
                id: this.value,
                type: type
            };
            $.post(ajaxurl, data, function(response) {
                $('#region-locations-checkboxes').fadeOut(0, function(){
                    $(this).html(response.main).fadeIn(500);
                });
                $('#regions-modal').html(response.popup);
                return false;
            }, 'json');
            doneUpdate();
        });

        $(document).on('click', '.checkbox', function () {
            var self = $(this);
            addCheckboxActive(self);
            doneUpdate();
        });

        $(document).on('click', '.clear-all', function (e) {
            e.preventDefault();
            sliderReset('all');
            $('.x-tag').remove();
            $('.location').removeClass('active-checked').prop('checked', false);
            $('.checkbox').removeClass('active-checked').prop('checked', false);
            $('.checkbox-popup').removeClass('active-checked').prop('checked', false);
            $('[data-id=food]').val(0);
            $('[data-id=decor]').val(0);
            $('[data-id=cost]').val(5);
            $('[data-id=service]').val(0);
            $('#all-regions').prop('selected', true);

            doneUpdate();
        });

        $(document).on('click', '.checkbox-popup', function () {
            var self = $(this);
            addCheckboxActive(self);
        });

        $(document).on('click', '.done-popup', function () {
            doneUpdate();
        });

        $(document).on('click', '.tags__delete', function (e) {
            e.preventDefault();
            var self = $(this).find('.x-tag');
            var id = self.attr('data-id');
            if($.isNumeric(id)) {
                $('[data-id=' + id + ']').removeClass('active-checked').prop('checked', false);
                if(self.data('type') == 'regions') {
                    $('#all-regions').prop('selected', true);
                }
            } else {
                sliderReset(id);
            }
            self.remove();
            doneUpdate();
        });

        function doneUpdate() {
            if($('#type').val() == 'wine') {
                ajax(getAllDataWines('filter_update_wines'));
                numbers(getAllDataWines('number_update_wines'));
            } else {
                ajax(getAllData('filter_update'));
                numbers(getAllData('number_update'));
            }

        }

        function addCheckboxActive(self) {
            if(self.hasClass('active-checked')) {
                self.removeClass('active-checked');
                $(':checkbox[value=' + self.val() + ']').removeClass('active-checked').prop('checked', false);
            } else {
                self.addClass('active-checked');
                $(':checkbox[value=' + self.val() + ']').addClass('active-checked').prop('checked', true);
            }
        }

        function getAllData(action) {
            var food = $('#food').val();
            var decor = $('#decor').val();
            var service = $('#service').val();
            var cost = $('#cost').val();
            var page = 1;
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

        function getAllDataWines(action) {
            var page = 1;
            var type = [];
            var loc = [];
            $('.active-checked').each(function () {
                if($(this).hasClass('location')) {
                    if($.inArray($(this).val(), loc) == -1 ) {
                        loc.push($(this).val());
                    }
                } else if($(this).hasClass('wines')) {
                    if($.inArray($(this).val(), type) == -1 ) {
                        type.push($(this).val());
                    }
                }
            });
            if(loc.length == 0) {
                loc.push($( "#select-regions option:selected" ).val());
            }

            var data = {
                action: action,
                page: page,
                type: type,
                loc: loc,
                update_numbers: 'true'
            };

            return data;
        }

        function ajax(data) {
            $.post(ajaxurl, data, function(response) {
                $('#main-items').fadeOut(0, function(){
                    $(this).html(response.main).fadeIn(500);
                });
                $('#tags').fadeOut(0, function(){
                    $(this).html(response.tags).fadeIn(500);
                });
                $('#nav-main').fadeOut(0, function(){
                    $(this).html(response.nav).fadeIn(500);
                });
                $('#listed-count').text( function(i,txt) {return txt.replace(/\d+/,response.count); });
                $('#page').attr('data-max', response.max);

                return false;
            }, 'json');
        }

        function numbers(data) {
            $.post(ajaxurl, data, function(response) {
                $('.numbers').text('(0)');
                if(response.numbers) {
                    response.numbers.forEach(handleTaxNumbers)
                }
                return false;
            }, 'json');
        }


        function handleTaxNumbers(element, index, array) {
            $('.' + element.slug).text('(' + element.numbers + ')');
        }
    };

})( WebJS );