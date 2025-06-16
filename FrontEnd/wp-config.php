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
define( 'DB_NAME', 'buenbuceo' );

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
define( 'AUTH_KEY',         'dc7&@kWOnf{dN;r}7mf}/GlS}kI43f[i=Qg)Ln2OUW<&Sdx2fo9% dV:54xoku.r' );
define( 'SECURE_AUTH_KEY',  'Op,n+Y5,pwb]b_j^N6kG{~0p4<n}$fP4SWbje:Fr_?|F:{n#4?ZOZOgH9t{5xGm ' );
define( 'LOGGED_IN_KEY',    'Sx2r5PYL}YiRU9dv5qn^BY$8z.>CrF=yHT^n$a0v/[O+dAwa{.I/e1+$(vC:D2a~' );
define( 'NONCE_KEY',        '~fL;<+78/g=2@.umAV@h_yr~E@t].<*vhxMU Az(o-Ok2-v08-s<N|oYQP=)=l!a' );
define( 'AUTH_SALT',        '3o~>4Snlp)A|eB;zq79zc51/@B,2@swHPM`[S26YN>?/tYR4,-^;yj#i%9B(n{gR' );
define( 'SECURE_AUTH_SALT', '*Df=tYXP3_b*yB,Qdx>}6$@dW!Z)gz,CZgNY1V,-TEGTO^#RX}xhMI}.2>W(ZI~V' );
define( 'LOGGED_IN_SALT',   'auRl*)</t8cS^p[P-GM(iVJ)Cx^_VGI{(zD.bZPJ7O.E@4Ho=-Wh. *1l2?Kcgzv' );
define( 'NONCE_SALT',       '/:>8ay,2g6e!`fh%?~NPwVxsWax)5}Tu~{$uQylz)fv]WNJ2I1B-STp`gmV:IT9q' );

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
