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
define('DB_NAME', 'i968572_wp1');

/** MySQL database username */
define('DB_USER', 'i968572_wp1');

/** MySQL database password */
define('DB_PASSWORD', 'P(k868yTPZ82[[1');

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
define('AUTH_KEY',         'REQk0C7rvTlk17BEomsZuIZwgokyeLwvdVek12zBGuAAxKlARQIu4AfrjAE8rubw');
define('SECURE_AUTH_KEY',  '87ll38Ts29skB18pb9waIRLcXzJ3HgLhuuDVoOZa1XRrZlcAPTtxipqElbpy5jf6');
define('LOGGED_IN_KEY',    'A7BavJxgmuLQyVUnHu9cXiQFyzv5dpblXjjcP3haTG1fYpHwp6TXRjvAxmhEIVSH');
define('NONCE_KEY',        'ARrPQmAW61zJGg7qVrTc7IHbk1mFOWKKmDnZviGvOwuEl1DcWp5upbe8mMxqfwx4');
define('AUTH_SALT',        'H1bdm6XkLe2Z2OaS7wcNGvrkh5iwoEidl8i8y6a8aNRmxMOCiE4SmqfrzRtQG2KY');
define('SECURE_AUTH_SALT', '2ADgTATp0RKdiivdFcwxzLZfhMvFg0nM67ea7yb0F1oLXdDaltEGHWy6RzhQKks9');
define('LOGGED_IN_SALT',   'O7THNbBmf30TEB2dKgCxn8XQGvDqv6Dge1MY7AJjt8De6CvWUKh6Yhr3G6XCgDV0');
define('NONCE_SALT',       'NNgbg5t0AVuSZghuQrUh054M4E39TPTourHCNEOaiHS1mOCsnqwnKOZYdtIjbrUW');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
