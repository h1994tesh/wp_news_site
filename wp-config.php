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
define('DB_NAME', 'wp_news_site');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '8+p,PBm<rXH{2_]D|@O&G,qnRu]$5B.3vaG:CbU:thCT!+zV1UhRywIM,uk~?kyi');
define('SECURE_AUTH_KEY',  'D$_.wcG-)ug[(<NX-Yq-I~(a1LGNu+w[;{e%9.+1v52sOy@S^+lG-)#Iq||DvOe_');
define('LOGGED_IN_KEY',    'gM^9~faLGd0j&~.TX{7Q{1St%>(k#$M/e96z$41PYnjOi#g}G3FQxzj:S+Y;ga-~');
define('NONCE_KEY',        '{dR%%c?Y&,]fP4_eG&W>EljgUr_;8n7=11cIMK>=cr;US#-E>d1|=J<Ds4CSXEM8');
define('AUTH_SALT',        '@.[i4L}w({8e*HKIp?Q6Gis=]Y^r^xk]+l@22,Y/e9Gx1k+RM.[5n3!aG:p?dVKO');
define('SECURE_AUTH_SALT', ',$XcVoY9DJCKRn`kj~brFvx]{QQZ!<nXqL6CmwV+.2tOg)&sF3%_;K+D:-ciOHM#');
define('LOGGED_IN_SALT',   '0(sKIMtNDf*T=OC+R)PnWi{gx8_.3#mB1_<a{2$3AHq#BFfa&wr~qS/#O<Bj(1j8');
define('NONCE_SALT',       '4}Dj$F^.>yHjFM<TdY&RAVu]<<WMh^cFG)vX#hyC[efWKy[Gr.?01:LJ-HG>> $[');

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
