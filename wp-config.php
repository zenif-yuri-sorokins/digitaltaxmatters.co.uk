<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

define('WP_AUTO_UPDATE_CORE', 'minor');
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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dtml18ad_v4IRfOz2W' );

/** MySQL database username */
define( 'DB_USER', 'dtml18ad_O66sgVE' );

/** MySQL database password */
define( 'DB_PASSWORD', 'tES]+pSH^euy' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '$l4rC]tvur8=$m){$+VPr]P8}**9/)/^x2M3`!v;!)6{(^6Epk0_V&EHd`WG5Cga' );
define( 'SECURE_AUTH_KEY',  '3cJA=wOdFc3R+kCQ?yqM8}a,H|RYx8QtjEn=)hkz!};}ibUQA=]/ihrdNkfp(EvU' );
define( 'LOGGED_IN_KEY',    't[mc5s/,1kBmx.9:b@(}{j%fMWevp_B-.,<gk%E!g4<6CP G2v8JEspE/tGqf7.G' );
define( 'NONCE_KEY',        '-sY7vHLN+FBvD/MxO;@yv~1Ps+MFQtgQ>c-W0%S2NX#/*4h~C2=EN%GXBeF(/s)F' );
define( 'AUTH_SALT',        'rPS}Q,9`e29==PSx@_c0c?Q_Nj8d&5C.JI.xtD1a%$Xiq$QZ[om}n1J8;#TBi#20' );
define( 'SECURE_AUTH_SALT', 'GZv~CqH=#?|indz#:;%4n=:}X]2L;krQz#UoB8sBd/fGc{@p-b9.><u*#f(4]Ayh' );
define( 'LOGGED_IN_SALT',   '` S$$~Xyca@T&%_[/k:[U[%%u(CgIbhqOvgyg)3@vQG33qS,.I}v*CM/c}WkPm3V' );
define( 'NONCE_SALT',       'hU[@>N~ES$8`{&fzfe.Iu-%turEF-P?)@76%~,D/hh=Os)Su(wM>q>nI9e6SYH{#' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
