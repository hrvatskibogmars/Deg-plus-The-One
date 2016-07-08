;// first line so some shitty script does not break everything
/**
 * @author bruno.zoric@gmail.com
 * @version 1.0.0
 */
(function( O ) {
	/**
	 * return first item from object, whatever it is
	 * @returns {*}
	 */
	O.defineProperty( O, 'first', {
		enumerable: false,
		value:      function() {
			var keys =   O.keys( this );
			if ( keys.length > 0 ) {
				var key =   keys[ 0 ];
				if ( key ) {
					return this[ key ];
				}
			}
			// nothing found
			return null;
		}
	});
	/**
	 * checks for anything in object
	 * if nothing there, it is empty ( true )
	 * @returns {boolean}
	 */
	O.defineProperty( O, 'empty', {
		enumerable: false,
		value:      function() {
			return Number( O.keys( this ).length ) === 0;
		}
	});
	/**
	 * returns number of keys in object
	 * @returns {numeric}
	 */
	O.defineProperty( O.prototype, 'length', {
		enumerable: false,
		get:  function() {
			return Number( O.keys( this ).length );
		},
		set:    function( value ) {
			console.log( 'Should never happen.' );
		}
	});
	/**
	 *
	 */
	O.defineProperty( O, 'cloneFrom', {
		enumerable: false,
		value:  function( obj ) {
			return JSON.parse( JSON.stringify( obj ) );
		}
	});
})( Object );