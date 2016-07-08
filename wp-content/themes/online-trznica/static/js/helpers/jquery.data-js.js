;// first line so some shitty script does not break everything
/**
 * data-js function from: https://toddmotto.com/data-js-selectors-enhancing-html5-development-by-separating-css-from-javascript/
 */
(function( $ ) {
	// strict javascript usage
	'use strict';
	// variable that will hold all items having data-js attribute
	var items = null;
	var callbacks = [];
	/**
	 * @type {jQuery}
	 */
	var $body = $( 'body' );
	/**
	 * @type {{}}
	 */
	var attachedEventsToBody =  {};
	/**
	 * actual function to retrieve elements with given data-js attribute
	 * @param name
	 * @param reindex
	 *
	 * @returns {*}
	 */
	$.js =  function( name, reindex ) {
		// if is first time running this function populate items variable with all items that have data-js attribute
		if ( items === null || reindex === true ) {
			items = $( '[data-js]' );
		}
		var selector =  __generateSelector( name );
		// return filtered items from list
		return items.filter( selector );
	};
	/**
	 *
	 * @param name
	 * @param callback
	 * @param unbind
	 * @param dataToPass
	 *
	 * @returns {*}
	 */
	$.jsClick =	function( name, callback, unbind, dataToPass ) {
		// need to unbind some event?
		unbind =	unbind === true || false;
		// already attached event to body?
		if ( is.undefined( attachedEventsToBody[ name ] ) === false ) {
			return $body;
		}
		// make it attached
		attachedEventsToBody[ name ] =  true;
		// fetch filtered items
		var selector =      __generateSelector( name );
		// do we need to unbind?
		// it is done here
		if ( unbind === true ) {
			//console.log( 'unbinding')
			$body.off( 'click', selector );
		}
		//
		// var context = this;
		function callbackWrapper(){
			callback.apply( this, arguments );
			callJsClick(name, this);
		}
		// return filtered elements with click bound
		return $body.on( 'click', selector, dataToPass, callbackWrapper );
	};
	/**
	 *
	 * @param name
	 * @param cont
     */
	function callJsClick( name, cont ) {
		if( is.not.undefined( callbacks[ name ] ) === true ){
			callbacks[ name ].forEach(function(fun){
				var context = cont;
				if(fun.context) {
					context = fun.context;
				}
				fun.callback.apply( context, fun.dataToPass );
			});
		}
	}
	/**
	 *
	 * @param name
	 * @param callback
	 * @param context
	 * @param dataToPass
	 */
	$.onJsClick = function( name, callback, context, dataToPass ) {
		//
		if( is.undefined( callbacks[ name ] ) === true ){
			callbacks[ name ] = [];
		}
		//
		callbacks[ name ].push({
			callback : callback,
			dataToPass : dataToPass,
			context : context
		});
	};

	$.jsKeyUp =	function( name, callback, unbind ) {
		// need to unbind some event?
		unbind =	unbind === true || false;
		// already attached event to body?
		if ( is.undefined( attachedEventsToBody[ name ] ) === false ) {
			return $body;
		}
		// make it attached
		attachedEventsToBody[ name ] =  true;
		// fetch filtered items
		var selector =      __generateSelector( name );
		// do we need to unbind?
		// it is done here
		if ( unbind === true ) {
			//console.log( 'unbinding')
			$body.off( 'keyup', selector );
		}
		// return filtered elements with click bound
		return $body.on( 'keyup', selector, callback );
	};
	/**
	 *
	 * @param name
	 * @returns {string}
	 * @private
	 */
	function __generateSelector( name ) {
		return '[data-js=' + name + ']';
	}
})( jQuery );