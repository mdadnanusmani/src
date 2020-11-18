<?php
define('WP_CACHE', true); // Added by WordPress Framework
define('WPF_CACHE_TIMEOUT', 3600); // Added by WordPress Framework
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
define('DB_NAME', 'srcocoms_wp196');

/** MySQL database username */
define('DB_USER', 'srcocoms_wp196');

/** MySQL database password */
define('DB_PASSWORD', '71pS.N358(');

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
define('AUTH_KEY',         'mj1daoyomaen6lgwem3nkxzdwnbnpksd1qx0n1ge1aby7k95kxaemt8w7owmbjvm');
define('SECURE_AUTH_KEY',  'alhiybicdbpbcrowhjyiigswvniu1dgwelpf4k7t01mianxzcxmzf7ibyyadwzfg');
define('LOGGED_IN_KEY',    'kmqrsdj4zsno3ldirnebtgdas11seinmhzy7seyexsozvqzyidyve8afyftxh8fw');
define('NONCE_KEY',        'm4cua9ek0rhr1sg9oghwopvltscg3buz8acdws9fyzdenzi2eqqzy14rjypb6wce');
define('AUTH_SALT',        '14kzsfjlldbpctqur6wyylvwjluebd1ubgxqb910njedyi9azzusuw9jmfwzkl4d');
define('SECURE_AUTH_SALT', 'tin62mtec1avxedefmxmioadr2zweddkcxplelzg4msgcb3yudsfl9atlmb5obzy');
define('LOGGED_IN_SALT',   'ufuggvddr4vgnh20wl98fsmxgarm9ekhr5wscwfiz0wkqopgqvwscegrtrbizucv');
define('NONCE_SALT',       'scafcn90gor5ju5vr0lpikn6a3g6bvudiygkrkol8fzz49f1k6dqxtw3mdiispkh');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpti_';

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
define('WP_DEBUG',         true);
define('WP_DEBUG_LOG',     true);
define('WP_DEBUG_DISPLAY', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */

define('WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST']);
define('WP_HOME', 'https://' . $_SERVER['HTTP_HOST']);
require_once(ABSPATH . 'wp-settings.php');
