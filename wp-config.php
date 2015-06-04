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
define('DB_NAME', 'ayoaycoc_upbeat_db');

/** MySQL database username */
define('DB_USER', 'ayoaycoc');

/** MySQL database password */
define('DB_PASSWORD', 'P455w0rd!');

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
define('AUTH_KEY',         '9hn_|#7]`o3ztQ@(rm,{qf?@7I(7-Ilp_vF6J$M?W6d8-P(w.2wDddH*FNcevtp.');
define('SECURE_AUTH_KEY',  '0u.OYJN3cvpj FXfHq!j[8s[pIN>w-d!(4!<}/c7ly:@a57+3_HRk|C*(}XR[b6=');
define('LOGGED_IN_KEY',    'gec:skV>O[_.3=|2c?VAM8|yL|3D)m,H/`-@RVflg%Ag`)2b/.r0KSbB{[EGt yt');
define('NONCE_KEY',        'pC3hXje4opzthQ`Lx@X{fx%|/;+&ZmYW`Hwx5:qf;lEo/Xb:RV7.;BSD<[139@w7');
define('AUTH_SALT',        'w|m#H2,eK$heiPd8Ah^dN^.AJJEM/(K,%A FzJMkUYHuCm).RI7$=70},RXU,9{S');
define('SECURE_AUTH_SALT', 'd{.!+}QO-U]3-g)GqUwApa`uN*oYa4sQ3~.&Nu9FC,%+![~kK_:XRvo2U3=}{cd0');
define('LOGGED_IN_SALT',   'OLwPT4VldFiqJ%l)o_cHC*)4-iqn;1BG%E(#xoEL$B.~tcn]XTiR/)@1#``7Mx[5');
define('NONCE_SALT',       'B_uX&;:@pNgf9$$?O%0>]|}L?]U<).3}07ylD/QQrW}_?O@?J Jz&4_O|M1CCy2B');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'upbeat_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

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
