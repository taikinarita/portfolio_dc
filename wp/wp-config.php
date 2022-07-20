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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'bcdhm_3kr8fdyn' );

/** MySQL database username */
define( 'DB_USER', 'bcdhm_work26' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Fg3!nHxp' );

/** MySQL hostname */
define( 'DB_HOST', 'mysql34.conoha.ne.jp' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '@>XYmg!|#bkk@L+1.N#7[YCe?s#h_?xb6u!dr@!^4g]qA&@z5MIeyiG1!R.UU#.E' );
define( 'SECURE_AUTH_KEY',   '^X:{Vd =$0pfS9b [o.`c[F%BH088cf<sMP[74:Rf=AoLL.[T=xy4E)B`bw96FCv' );
define( 'LOGGED_IN_KEY',     '$JZHqC]lwQ;.,1LQ<;::o_t=j:ApY_J{y9Epq%fu?]|4x+fk;GTu4zj}T-lF{iu<' );
define( 'NONCE_KEY',         '($%Gh<=4O*S~PGGk5b9kL4sEb~#UKxofq{j3=n( Q6I;rhM|RX{A9C`-upx;VM&4' );
define( 'AUTH_SALT',         'Rz:v96%%XjJsduhOb#Ln?#R*xu Wmmjc`ZB8g]Cf#e@$NFmndT/!7V*GM**~-s:!' );
define( 'SECURE_AUTH_SALT',  'H`}b#OsT>lhqKq_r$)wSmKcLbR!wrB&;()l9{8U^km:_Wj7HX cPszBxq^s0>;|]' );
define( 'LOGGED_IN_SALT',    'Y>!iM1tl5>(pH8Rf_O{<+Mkzh~Ds sVzQwZl-}D6{h. CU|Im8D*7k6I;zs*Hg*.' );
define( 'NONCE_SALT',        'UJ<WP?8;K]4YW%nfB_</1MP#1en4Y_,Ozsb!ibkr[}GY}]#vq[ l==C~2FQZeZTH' );
define( 'WP_CACHE_KEY_SALT', 'dXEy&Bxg>;pY-}|Sv*w`&bh4[H]0i.:9sr%{sU5A$=ERR=<tj_dbzj@fFFw{*R7z' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === "https") {
    $_SERVER['HTTPS'] = 'on';
    define('FORCE_SSL_LOGIN', true);
    define('FORCE_SSL_ADMIN', true);
}




define( 'CW_DASHBOARD_PLUGIN_SID', 'SWAItOpQDJPO0OeO89zRhVGBogLttFME6iirhtXF9CVheJi4x1wLpSrzJ9ckbAKJaD6M-gIfrBHxfA_hmx_JUEcdVGOgxSnLa6VBqJYyrVQ.' );
define( 'CW_DASHBOARD_PLUGIN_DID', 'S_iw_MXE1hvQPbPvr6V315731qlZmCSU-cJ09nTO4UMtQEAhR3K9l8H0pkLzxoWB2WAxEL-lgThXVI-ExfQbO8A5bulRJbZ-V0VJGYQQpac.' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
