<?php
define('FORCE_SSL_ADMIN', true);
define('WP_HOME','https://dervalart.com');
define('WP_SITEURL','https://dervalart.com');

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
define( 'DB_NAME', 'dfairwea_wp2' );

/** MySQL database username */
define( 'DB_USER', 'dfairwea_wp2' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Q.2nB9eQZ6QE609sF0P31' );

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
define('AUTH_KEY',         '48CcaXyK9wRmPt5cngSbNYmbkEwHytF2ispTUJKXqEgWsTc4P2w9g6gG38gYHAJi');
define('SECURE_AUTH_KEY',  'BkbEUizULYliExUlldEVN6ghPGZjQy95YWgtmFi7N5zjXZfwNtoz9TPJbWJc92jC');
define('LOGGED_IN_KEY',    'lbvn4U21asYFV6GNRaXMpgGO0FVy9dzx6jJonA7UnHn9p5DSHZW86CRuIZlPlqpI');
define('NONCE_KEY',        'ZZjbjTNwWEE5bswh3bVajgoMnC0kzkqKKn0mkysVUgcy85UjvnEHODHYcjOvEs1B');
define('AUTH_SALT',        '4cfKGBYU6SGFavwTKTZ56Vt8UF4EJWgcZIfcBIu1trbt4VJ0BCfxMQ2RSJEUjlNN');
define('SECURE_AUTH_SALT', 'FB23YQVakbDn7WNWjaeh45OvvMY9okroVjQ9rORrcSLrInaAC7TQlyPOqLKsSc0F');
define('LOGGED_IN_SALT',   'LCG16b5FDn9HVn88RIuz2MERCZozTuWdPcTWGxJdTMSLXvJmTb9tCTGV9NC648Ns');
define('NONCE_SALT',       'xMDYAJfOYwaLTepDUDdYf0YPy3jMKYS7eLfphm97GUhoKZRkXmHbQ7KBx2XFDYz9');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');
define('FS_CHMOD_DIR',0755);
define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed externally by Installatron.
 * If you remove this define() to re-enable WordPress's automatic background updating
 * then it's advised to disable auto-updating in Installatron.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);

/**
 * Multi-site
 *
 */
define('WP_ALLOW_MULTISITE', true);
define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
$base = '/';
define('DOMAIN_CURRENT_SITE', 'www.dervalart.com');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);



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
define( 'WP_DEBUG', isset($_GET['bug']) ? true : false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
