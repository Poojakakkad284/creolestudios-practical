<?php
/*
 *Plugin Name: Events Organizer
 *Description: Organize the event by date, location etc.
 *Version: 1.0.0
 *Author: Pooja Kakkad
 */

/**
 * Basic plugin definitions 
 * 
 * @package EVENTORG
 * @since 1.0.0
 */
global  $wpdb;
if( !defined( 'EVENTORG	_DIR' ) ) {
  define( 'EVENTORG_DIR', dirname( __FILE__ ) );      // Plugin dir
}
if( !defined( 'EVENTORG_VERSION' ) ) {
  define( 'EVENTORG_VERSION', '1.0.0' );      // Plugin Version
}
if( !defined( 'EVENTORG_URL' ) ) {
  define( 'EVENTORG_URL', plugin_dir_url( __FILE__ ) );   // Plugin url
}
if( !defined( 'EVENTORG_INC_DIR' ) ) {
  define( 'EVENTORG_INC_DIR', EVENTORG_DIR.'/includes' );   // Plugin include dir
}
if( !defined( 'EVENTORG_INC_URL' ) ) {
  define( 'EVENTORG_INC_URL', EVENTORG_URL.'includes' );    // Plugin include url
}
if( !defined( 'EVENTORG_ADMIN_DIR' ) ) {
  define( 'EVENTORG_ADMIN_DIR', EVENTORG_INC_DIR.'/admin' );  // Plugin admin dir
}
if(!defined('EVENTORG_PREFIX')) {
  define('EVENTORG_PREFIX', '_eventorg_'); // Plugin Prefix
}



/**
 * Load Text Domain
 *
 * This gets the plugin ready for translation.
 *
 * @package EVENTORG
 * @since 1.0.0
 */
load_plugin_textdomain( 'eventorg', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

/**
 * Activation Hook
 *
 * Register plugin activation hook.
 *
 * @package EVENTORG
 * @since 1.0.0
 */
register_activation_hook( __FILE__, 'eventorg_install' );

function eventorg_install () {

}

/**
 * Deactivation Hook
 *
 * Register plugin deactivation hook.
 *
 * @package EVENTORG
 * @since 1.0.0
 */
register_deactivation_hook( __FILE__, 'eventorg_uninstall');

function eventorg_uninstall(){
  
}

// Global variables
global $eventorg_admin, $eventorg_public;



// Admin class handles most of admin panel functionalities of plugin
include_once( EVENTORG_ADMIN_DIR.'/class-eventorg-admin.php' );
$eventorg_admin = new Eventorg_Admin();
$eventorg_admin->add_hooks();



// Public class handles most of front panel functionalities of plugin
include_once( EVENTORG_INC_DIR.'/class-eventorg-public.php' );
$eventorg_public = new Eventorg_Public();
$eventorg_public->add_hooks();
