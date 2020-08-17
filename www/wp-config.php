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

define('DB_NAME', "docker");


/** MySQL database username */

define('DB_USER', "docker");


/** MySQL database password */

define('DB_PASSWORD', "8G5jcfZsxE4pz36T");


/** MySQL hostname */

define( 'DB_HOST', "database" );


/** Database Charset to use in creating database tables. */

define( 'DB_CHARSET', 'utf8mb4' );


/** The Database Collate type. Don't change this if in doubt. */

define( 'DB_COLLATE', '' );
define('WP_REDIS_HOST', 'redis');
define('WP_CACHE', true);

/**#@+

 * Authentication Unique Keys and Salts.

 *

 * Change these to different unique phrases!

 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}

 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.

 *

 * @since 2.6.0

 */

define( 'AUTH_KEY',         'Ecr;/7x=z[KHN?I_OrKY:}b`jHw5zeQ9y{J^nezPG9aiXf^.SWuzl1FPyucZ+VH&' );

define( 'SECURE_AUTH_KEY',  'JV*a.8:{|$rYi|q%SBxds7[S0.BdA,e7ly{m/bZ?z*_w|<S?4&v=1Rhv?P|i5]&)' );

define( 'LOGGED_IN_KEY',    ')MASMTcxA|Gf$VDFtwmi%qt6ObsT3(+GY&z-4bfTF.1)]z=N=tD-23VM V&j)9Am' );

define( 'NONCE_KEY',        '[@le3@*$Pob!ll,Hj0aXm-s$8#_<I^su#31w@?Z>gEWhYl07N.RUU[,c*Hr^cc_Z' );

define( 'AUTH_SALT',        'cw&77@3YrDO|]iK&k551[*}<SFvSd3HJoATi0Z!FtOFsf=k]U4o0Ag<-PvZl:eM-' );

define( 'SECURE_AUTH_SALT', 'XO3KOA9pH<TWOn4W`xpq>X~a3(2)l(2z,TQ,jDjK)}2UBmZ~p5[cB>8e!D)^b>?g' );

define( 'LOGGED_IN_SALT',   '`;3.|PP{=:~RgtRqyJP.n}D;/,z{XF~^$:.3>-{@micoJP:]}qOo-*X,1bKqB}/S' );

define( 'NONCE_SALT',       'z;9kKOBe,x3FdY=.2hC[!Nxc?M0^GEgd2]3 h3]<j(?7(7=U7[_c>=4(~Kr7y?@u' );


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

 * visit the Codex.

 *

 * @link https://codex.wordpress.org/Debugging_in_WordPress

 */

define( 'WP_DEBUG', false );


/* That's all, stop editing! Happy publishing. */


/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

}


/** Sets up WordPress vars and included files. */

require_once( ABSPATH . 'wp-settings.php' );
