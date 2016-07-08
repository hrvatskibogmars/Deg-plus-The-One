;// first line so some shitty script does not break everything
/**
 * base application ( function that is to be instantiated )
 */
var BaseApplication = function() { 
	/** 
	 * @type {BaseApplication}
	 */ 
	var self =	this;
	/**
	 * reserved names
	 */
	this.reserved = '^' + String([
		'extend',
		'get',
		'init',
		'is'
	].join( '|' ) ) + '$';
	/**
	 * @param moduleName
	 * @param initialConfig
	 *
	 * @returns {BaseApplicationModule}
	 */
	this.createModule =   function( moduleName, initialConfig ) {
		// is reserved keyword?
		if ( moduleName.match( this.reserved ) !== null ) {
			console.log( 'Reserved name ' + moduleName );
			return null;
		}
		// module already exists?
		else if ( self.is( moduleName ) === true ) {
			console.log( 'Module with name ' + moduleName + ' already exists.' );
			return null;
		}
		// create module
		this[ moduleName ] =  new BaseApplicationModule( moduleName, initialConfig );
		// and return module
		return this[ moduleName ];
	};
	/**
	 * @param moduleName
	 *
	 * @returns {BaseApplicationModule}
	 */
	this.get =  function( moduleName ) {
		// check if you're requesting application at all
		if ( this.is( moduleName ) === true ) {
			return this[ moduleName ];
		}
		// throw log into console
		console.log( 'Unknown module ' + moduleName );
	};
	/**
	 * for this to work init method must be declared in requested module
	 * @param moduleName
	 * @param opts
	 * @returns {BaseApplicationModule}
	 */
	this.init = function( moduleName, opts ) {
		// check if you're requesting application at all
		if ( this.is( moduleName ) === true ) {
			// has init in module?
			if ( typeof( this[ moduleName ].init ) !== 'function' ) {
				console.log( 'Module ' + moduleName + ' does not have initialization method.' );
				return null;
			}
			// initialize module
			this[ moduleName ].init( opts );
			// and then return it so it can be used as plain variable
			return this[ moduleName ];
		}
		// throw log into console
		console.log( 'Unknown module ' + moduleName );
	};
	/**
	 *
	 * @param moduleName
	 * @returns {boolean}
	 */
	this.is =   function( moduleName ) {
		return !( typeof( this[ moduleName ] ) === 'undefined' );
	};
};
/**
 * base application module ( function that is to be instantiated )
 */
var BaseApplicationModule = function( moduleName, initialConfig ) {
	/**
	 * better to use self than this since this is overwritten alot
	 * @type {BaseApplicationModule}
	 */
	var self =  this;
	/**
	 * set module name
	 * @type {string}
	 */
	this.name = moduleName;
	/**
	 * add initial config
	 * @type {{}}
	 */
	this.config =   Object.create( initialConfig ) || {};
	/**
	 *
	 * @type {{}}
	 */
	this.configuration =    {}; 
	/**
	 *
	 * @param opts
	 * @returns {BaseApplicationModule}
	 */
	this.init =         function( opts ) {
		self.config =   $.extend( Object.create( module.config ), opts );
		// return thyself
		return self;
	};
	/**
	 * extend initial config
	 * @param config
	 */
	this.extendConfig = function( config ) {
		self.config = $.extend( self.config, config || {} );
	};
	/**
	 * just overwrite modules config
	 * @param config
	 */
	this.setConfig =    function( config ) {
		self.config =   config || {};
	};
	/**
	 * get modules config
	 * @returns {*}
	 */
	this.getConfig =    function() {
		// return config variable
		return self.config;
	};
	/**
	 * @param methodName
	 * @param callback
	 */
	this.extend =   function( methodName, callback ) {
		// method exists?
		if ( typeof( self[ methodName ] ) !== 'undefined' ) {
			// throw stuff in console
			console.log( 'Module ' + self.name + ' already has attribute or method called ' + methodName );
			return;
		}
		// extend this module with new method
		self[ name ] =  callback;
	};
};