<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u125990890_parasol_new' );

/** Database username */
define( 'DB_USER', 'u125990890_parasolusrd_1' );

/** Database password */
define( 'DB_PASSWORD', 'xyjIw4Ne6N9C3tlMXxmQ' );

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
define('AUTH_KEY',         ',G-}a-TNHO!P%,u(MXU})7$|>{n[!=k{2pI;/1YCroc Qv5<gp>_r5y[4RG;*^;7');
define('SECURE_AUTH_KEY',  'vzykYG72dn%*rORz51VDRjX)|#t-|fM1oLM|&. <;I-m|QcCSDtT5GI;!>?;Vdc#');
define('LOGGED_IN_KEY',    'V0K8;~J[jeMQ[70B{)zTHByTU1Qh|]W.{%+/Q+/M5|-nVMl`*V6irC+e*LvpcLWS');
define('NONCE_KEY',        ':-<Ihv>v5lmKJMO)*+(io1+8j*Dn_8gYBd:ZLo}{~|HN_/]8+6fwDu6a8HPL{YW8');
define('AUTH_SALT',        '/]<~NLeJ,[i{I`3M$yz_S-GQV&|hJFd UM,E!0,ijy5q9eqNw,9ZX`T%*b[!R7/G');
define('SECURE_AUTH_SALT', '7dO.s4l|>Cv[,R-p5K.0wD--aX*NlhA<ix-%#=^C=31jv$uot.8;[xODP8UFZNRT');
define('LOGGED_IN_SALT',   '=)_pUa^&V:+R{4QaPVpv=/VJ(6XspJDX5IJ]fjy!dibQd|Z!W$??3@4-vPpj7j~L');
define('NONCE_SALT',       '@8JdI-BoH7( ,smNL`_Q~%4(e%oChj?`[_7H<>D=x#ccafeU[hh~3sM26t7@0?8*');
/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
