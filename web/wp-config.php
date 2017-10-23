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
define('DB_NAME', 'sheridan_1');

/** MySQL database username */
define('DB_USER', 'sheridan_xuda');

/** MySQL database password */
define('DB_PASSWORD', '2181022xurfF');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
define('WP_MEMORY_LIMIT', '64M');


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'nSbMkOs~8>2Oic]QGJj17f{ISC7_e(%qr~0^L.b,:3v$Xcv&Bg5kQ^c$3Jk#&ElU');
define('SECURE_AUTH_KEY',  'w?[KvWU)Uc}0 -ScHd3$ 05[o<0iCc//iV..bH5=6g~hV0lqcHR~sCPevpxBl6bI');
define('LOGGED_IN_KEY',    ' 5-4DH]/,(tiSOF?%qE+GhPq(Y^NS})Lhw$b#@tysNhA|UCG-K6VTTZ2-mtIy`kl');
define('NONCE_KEY',        'Dv8LZ!S/9KD.2y(-KRO[lXi0:5xK=??DB/g9A;g313qSKc^[6P8VSOq%`PZZUNCf');
define('AUTH_SALT',        '9i0u7>+EGXtCG,VG|??rC3TpE~m*K~h|tfPM!hlZ/uspHlni(L;~Go)*80*If:Lj');
define('SECURE_AUTH_SALT', 'WzWvMRq0<Jo=Y9U;A{+<7.BG5PDv}|F>F1.|5?1$9QF/tuio]R_A2`x0tE868pV,');
define('LOGGED_IN_SALT',   '<S|,$0N-yq0AR`5sOs^Pex 5CbGz%,Z2Bt^Dz^f6I^2!WMj.`ALN0DN#~}=`oykp');
define('NONCE_SALT',       '/n`FOso::PHb(Z#yHC;EHM)E.RXeroNvn`@NXYEJ-E8pm)d],%S%w;>+W)k&fr*7');

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
