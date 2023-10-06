<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'poker_a' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '}}>$01Vc4wj,vl[m4Se@W[dx.dMXlyrqI.u$*yl2B%OD(bxL.k&A(`1rbuk!$bqj' );
define( 'SECURE_AUTH_KEY',  ')g`(s:D~#z,QeaCAs!_*H$Ze4|P|55R.<vR/xr5ZhWNezW*N!; C;PaqM D?-[Hr' );
define( 'LOGGED_IN_KEY',    'H1@c<Bn|!@k)fjeQ]V21h&i^Mt2}AFE{,F_JVO?|!m?2~u A4H5#TTG^I3X,SEi5' );
define( 'NONCE_KEY',        'v#7LJslf]rc0.4EbUGu3w|tCRGc-8&Dgva`$s`>F,&@Cb`j28XY8kq.7/?fn*!.x' );
define( 'AUTH_SALT',        'F.DJ+:8{7i8:*i#`*t,k41i5DqHB@(>@>LsZ{>vN;`&GWcDO3uch9Q|=0}/NL;1-' );
define( 'SECURE_AUTH_SALT', '@kI!tL4,;8Ti,F6rwmpsPS=LW<w[[S^ahOplmStZD1l0QneQW$#PX96foGtl*H^m' );
define( 'LOGGED_IN_SALT',   '9DZ}X|`Uyj~V]m!m__DjcJ(d.Q/vn}&=~]6@wTLGP*;81t{wB9cRS qCam#.zm|<' );
define( 'NONCE_SALT',       'N&:`mm21,>YUd^#Z}V6K1 oQjvea:{[@X&Te,K}n=3].KR5D3nHDTGx{7BGW^4Qr' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
