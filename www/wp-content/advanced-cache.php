<?php 
defined( 'ABSPATH' ) || exit;
define( 'SC_ADVANCED_CACHE', true );
if ( is_admin() ) { return; }
$plugin_path = defined( 'WP_PLUGIN_DIR' ) ? WP_PLUGIN_DIR : WP_CONTENT_DIR . '/plugins/';
include_once( $plugin_path . '/simple-cache/inc/pre-wp-functions.php' );
$GLOBALS['sc_config'] = sc_load_config();
if ( empty( $GLOBALS['sc_config'] ) || empty( $GLOBALS['sc_config']['enable_page_caching'] ) ) { return; }
if ( @file_exists( $plugin_path . '/simple-cache/inc/dropins/file-based-page-cache.php' ) ) { include_once( $plugin_path . '/simple-cache/inc/dropins/file-based-page-cache.php' ); }
