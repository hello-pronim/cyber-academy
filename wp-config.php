<?php


define('FS_METHOD', 'direct');
define('FORCE_SSL_ADMIN', true);


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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'db791745971' );

/** MySQL database username */
define( 'DB_USER', 'dbo791745971' );

/** MySQL database password */
define( 'DB_PASSWORD', 'yxLTyEOmRItwnLCvFasA' );

/** MySQL hostname */
define( 'DB_HOST', 'db791745971.hosting-data.io' );

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
define('AUTH_KEY',         ':oVF$Ab*Q:0Yw!Q7{I@e4}3*nZv(DZ{2Kq5V(kOBAf|:A%hJLB.,L%O#V5LFj)D1');
define('SECURE_AUTH_KEY',  ' !qNs2]cR!4|x}9X)o[yIH%2uSS+v)rO#3oWzX i]S#%=Vq+eu`i?,x|*3l%LvXk');
define('LOGGED_IN_KEY',    'Z^NN=~1wW=aO(|EifL&-i0E-Mv9e9~q0Olv_MWlp4wWHfnZ |Vq|_w)pT8[KVEZt');
define('NONCE_KEY',        ',*=/3UxuusYWQg~|D#qH190ine|sv;W0_(EEW.3<dPyv<3*9vH9W;|L-qc]}e/+O');
define('AUTH_SALT',        '.?aL.Y%2Z`+</jnf~Poa,vxO+=g5O+-H7a2t~DF`F/DGaw+u&DT;<9Rvv$sR%)`s');
define('SECURE_AUTH_SALT', 'o9B4w_)t})<2u+RWX+2;S S]2L}|$2Nt?Q@F3wh+(qUm>tqPer feo.LoS#,8{4G');
define('LOGGED_IN_SALT',   'u|WGvP$z%{+28dn9i7eA~bCq}!:oN[yC93G>j.wUQ9(YnyI2iUOXHVh+594-!%v5');
define('NONCE_SALT',       'ph-|MNLrrM^pkbp/YOZvz[t8Oz*Vt[_+pNG?]W7Hl1#M$ ]L0K37dIgL+TCwyN5y');


/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'esalSKkO';

define( 'WP_MEMORY_LIMIT', '3004M' );
@ini_set( 'upload_max_filesize' , '3000M' );
@ini_set( 'post_max_size', '3000M');
@ini_set( 'memory_limit', '3000M' );
@ini_set( 'max_execution_time', '300' );
@ini_set( 'max_input_time', '300' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';