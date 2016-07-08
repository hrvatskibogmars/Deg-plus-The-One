<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'onlinetrznica');

/** MySQL database username */
define('DB_USER', 'root');


switch($_SERVER['SERVER_ADMIN']) {
	case "vilim.stubican@online-trznica.loc":
		define('DB_PASSWORD', 'toor');
		break;
	default:
		define('DB_PASSWORD', 'root');
}
/** MySQL database password */


/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '$r$fF~3W#!oS|F!vZ<A2QHJL@j~M!UfrX>7xv?unz}a#]M&!?-D^:mYiV5+a.hR/');
define('SECURE_AUTH_KEY',  'rk2iwx9r{sI0;Zs]%U|h <qr9Ovl[`6,-{HVZxnD&X{q!A+$ugw{s(0MYQ*t2daj');
define('LOGGED_IN_KEY',    '4](Q-$@>/a02#KbP(!EhKm+{*=SD}:Xel{`JQ7>m]{9*ld4EJ<FMw_uhNLrkQx|F');
define('NONCE_KEY',        '#B?W5{nZkcla9GZ!qEbTu}S_~C|Gh(!<) Q?]xP;]Yf`3DH@yk[K45L(OyFU=SwN');
define('AUTH_SALT',        'p90]hK0WQ{3TF^$yS<e$Kl$L2%)z0}l7bE%FLD!a Bls#uUvxqF*`;nqsnYS6 s.');
define('SECURE_AUTH_SALT', 'B~znRiqv{yL~&U[5Q[e.QUHSM#EuILUEkSV?]#g}FMVQTAm]uh1}/j4dFOj)u0[c');
define('LOGGED_IN_SALT',   '5SfBcereYQ]a7~$@+`*$2r2,{p.4DkfZ/FytG}7G*-#`5=/}5w2*Mg5uu&G0hauX');
define('NONCE_SALT',       'bLVGOo4}NzRBKX,E4{jD&yjJ?9)e{l,lpx= oZonq7Sz<UQu8I}4mRMc`Kv$1F%9');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
