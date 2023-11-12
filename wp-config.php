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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define( 'AUTH_KEY',         '&zh)QLx2|d`VG0O[s[{+a6ZQ]]tV:=JeyN3O>;,&m~|f_Q6e jd,?zcmV@>q_e7z' );
define( 'SECURE_AUTH_KEY',  '8R-[yYvFNb[gv1hgN]a9nz$Z-|=Zm!B.A|P4!#i hoR0OOB<gPusxpv{%46Y`bCb' );
define( 'LOGGED_IN_KEY',    '&r@T36D13iJ1QS075yc}Z@&VMMs}5O$]cye+M?s$<`lciRO2]>1xtHFm#l@ksrK.' );
define( 'NONCE_KEY',        '[Q[[UfTy5aA`*N>]FLtQhf<YiKF>hVt.Czrs_hW?-x{aS?:RbQU<v6H0Ty.I?ac-' );
define( 'AUTH_SALT',        'te>|3+jJ]*7pqw}uP(.Q8tD6lNhIiH`7vHr00KE3/k c,v*>2nz](^$xhDj9ZZ!6' );
define( 'SECURE_AUTH_SALT', 'E$ ;U|D1}jS/>3PmFoli`>6KDCKs}!?:0Ng/@.@LrxHiN6^mWt/1m7.Hj~Hwjc%M' );
define( 'LOGGED_IN_SALT',   '>#zZ<!QQj|nQGe9_<pzn+<QUN%pQ`HDTOU%IJ(><x.W&~?_Z0t_b[KvCKfD6ZTjf' );
define( 'NONCE_SALT',       'FSK$Hxy<bG5~Ji;DPXBB/BcR:TWl)h_*.F`yX{LY!mWWK=QNC1Sg 6Fo#39qh0/s' );

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
