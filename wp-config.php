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
define( 'DB_NAME', 'eventmanager' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '4r1siSDR8ZcvY D3MsrEB$}v*t<qu(nn1auy#1nv3*9M7LIA}2A=y)Al:}A)voym' );
define( 'SECURE_AUTH_KEY',  'hX0i^1/?ELNG88I<M*/aO?d_1%]:f``^Rqv#7-[v=e&.NADnm)Ca+j#v>H``Yw-?' );
define( 'LOGGED_IN_KEY',    'Q7!TO%;+0/:X4XThDXNt#4R[/(T0b_p0tge/U;zxER;^epeI6!:WWvH.5I(lG3H{' );
define( 'NONCE_KEY',        'NCF*R)ti?8/)17D-6xd:45s]R(*~~/H{/[%eO)D#w]&kZor+S*H{T:v|>bHW?crI' );
define( 'AUTH_SALT',        '.@76Rp88g7r/Ts*Y]h|rqfh.?pS4/Kpv&v7.!T.&M[(SN>S|[.Ce.|3onQs)iTg#' );
define( 'SECURE_AUTH_SALT', '>,#L@YnEM-STvRUq[KUBK=3CG^{DIHAdzJHWr}(9m%zS0V#,2^%Fhf}(!B$;U,!~' );
define( 'LOGGED_IN_SALT',   'zQMB5MgI?e}Fj8_=OD1zJTEm~wt!QpWO<Nhzvek 5IggF|-]zsT5a}aG^%tNQ_34' );
define( 'NONCE_SALT',       'I!4aT*<K>&_G0c`m3+x.n@&HPOW[N{=Ze=MaUA.QcZ$/-M|SoQmto!_nuI)BqmwX' );

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
