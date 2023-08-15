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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'jieun1' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '1234' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         '_kRI=c]fRlBax.-;!4@+ant/FMbGL.rROg/=pe&R/FB8nbURO1<$S_mHgqWr$Vze' );
define( 'SECURE_AUTH_KEY',  ']87ck[l;j+T(#?0JbswQ<tQ!#+E*yz!/o/IznhCoNko%mFlTeB2e&P6lt>FqRkoe' );
define( 'LOGGED_IN_KEY',    'bEez?7UI!5O]HKPiJep!PR<R>d7sVENV5c+mN.Ri-^Y-}ui/8F{/}h5Tog3<{qN0' );
define( 'NONCE_KEY',        'gDq?gmW.7]c1.ZXK5Vj5Irx*gXFqDdV08jh>VPU}1rXDr+o:?/dI854|QZ^%(Zcl' );
define( 'AUTH_SALT',        '~{!gn$i+mC$PlV&fv)es^hSgrAI0j/d-)MCY1(HoT.q+_$HSx/y0z#:WAl]+s#{0' );
define( 'SECURE_AUTH_SALT', 'n$,^y6O[=a%4V@rvyv$[dOAZVh!Dc[=x{3<Q5m|2ps(c9!!Cn+KB{CdQglnQiUqG' );
define( 'LOGGED_IN_SALT',   'Y(!J Aiht|<0|[]!yKTG6i:#u^&K oGJ#oZpwiSw@i$a*f%xq-:?R-qA_ .1?zm]' );
define( 'NONCE_SALT',       'y_6U&n[&Cn@j8e;O|5j163/SeX*Zq{F94#:1dt7TMW86^+l%a?3l9* >pw1=|vzm' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
