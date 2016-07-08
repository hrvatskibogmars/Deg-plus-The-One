;// first line so some shitty script does not break everything
/**
 * @author bruno.zoric@gmail.com
 * @version 1.0.0
 */
(function( O, D) {
	/**
	 * find first element matching given class name
	 * or return null
	 * @param className
	 * @returns {*}
	 */
	O.defineProperty( D.prototype, 'getElementByClassName', {
		enumerable: false,
		value:      function( className ) {
			// find all items that match given class name
			var items =     this.getElementsByClassName( className );
			// any items found
			if ( items.length > 0 ) {
				// return first element found
				return items[ 0 ];
			}
			// return null since no element was found
			return null;
		}
	});
})( Object, Document );