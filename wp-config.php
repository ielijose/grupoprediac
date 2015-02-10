<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'grupopre_inmobi');

/** MySQL database username */
define('DB_USER', 'grupopre_inmobi');

/** MySQL database password */
define('DB_PASSWORD', 'g^LVm4~K#FO,q)~F$?');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '~>j:]df/Ve=W36TR^>(k@?(&zt_e(%sio/#Ccllmd|@3p_yFfQ|o/w8,TNs>gWZ-');
define('SECURE_AUTH_KEY',  'OV2+MKdy2nX4&2}3+#Nwye+l#m%nWM//Np$Bm;kN6XK2kC`Y[ rVx^T|DT/M~&gX');
define('LOGGED_IN_KEY',    'Te_I{Jt:8t-YJ|ELf;M#709Xw-!A`*fdJ|xH952?hgj|w[ob0zI;1$uya-TrT<(0');
define('NONCE_KEY',        'Oy.kb!6/%G?<|hp1n3CY|`SaaKtTPIR<.hzcF$V?pZ-;9-b57)7@1FWn1gE)&M=}');
define('AUTH_SALT',        'Yzx5- im_88-<OO&)(c>g|KdV+m8|rtF4rfDaVi8`g5f2j8IHFT!ZNs*r}d:b[-A');
define('SECURE_AUTH_SALT', '9~,B[J|*/!i&YK@!99Oz+5=3j|yprXYR|q-g9z #!(94v3TjI&O.Gik2fW2aeqKj');
define('LOGGED_IN_SALT',   'yJ/ea&L+Qwf~H+|3`~Ur|1:xEtyfp+C6?Q>+k9c_$IWGvL+,Wsb:rDEztba*qj!R');
define('NONCE_SALT',       'b8x|bT)FG&:} T^.V}PDnz)uIxIUFxVSx-:467@%t%>7.1m,p):S-:gtC;@;?dji');


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'inm_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
