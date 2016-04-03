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
define('DB_NAME', 'iid_db');

/** MySQL database username */
define('DB_USER', 'mmounirf');

/** MySQL database password */
define('DB_PASSWORD', 'lpl]lkdv4ldwghp4Ever2gether');

/** MySQL hostname */
define('DB_HOST', 'inerdegcom.ipagemysql.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'dYZUO98X?bCD6;N%rpCI5fx3aziNK.Qgy)noqgi:#1[*P@m)Nr8ejp(kd{K4[Xn~');
define('SECURE_AUTH_KEY',  'AV-$wn/V:kFgA-nh/E;jm9X.P<6SxKnUBff*hlO=[+?GhQih6^] eTv!]Vi;r$gU');
define('LOGGED_IN_KEY',    '|FI!oM0A-*Ofd-QK5JH>EnR,d%22 )sLq&/A-+=>sKm{vvkQdu_p*C3%$aj|[D2x');
define('NONCE_KEY',        'D1o5y!$)Eamc{R:{Pv^EmTNe=a{H*W-&d-=h`x}_U+wg|%:lE]9|W-BD[Bn}LOKH');
define('AUTH_SALT',        'x;iMs~g).W3!?-am<HgMpeh?`+Tx-Jiy|p)N p:9L(&J .DMgu$@ODUr`P{QG$)s');
define('SECURE_AUTH_SALT', 's1fB<~Gy.|}L_1dx[@}`+,+@0VW2!kZTj!9;JgONxCUe?-pRBzDtM[HBR:F6j3l ');
define('LOGGED_IN_SALT',   'N!!ST8k$/75]yb}+U,!nPneC-=Iz;Oc##P<X;[qL%s18(w+~Q2(L5uFi%.uW~Xm&');
define('NONCE_SALT',       '3V/6oG>voBX0OhL2$78=>e(rZvlCh-.,:iHRUvj0+7XkA*Jo}(oK}yX!25`!H) ;');

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
