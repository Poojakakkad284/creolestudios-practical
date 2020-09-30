<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Public Class
 *
 * Manage Front Panel Class
 *
 * @package EVENTORG
 * @since 1.0.0
 */
class Eventorg_Public {

 
	//class constructor
    function __construct() {
	
    }
	
	/**
	* Shortcode template define
	*
	* @package EVENTORG
	* @since 1.0.0
	*/
	
	
	public function eventorg_event_shortcode($atts) {
		ob_start();
		include_once( EVENTORG_INC_DIR.'/event-template.php' );
		return ob_get_clean();
	}
	
	
	/**
	* Enqueue Styles for Event list
	*
	* @package EVENTORG
	* @since 1.0.0
	*/
	
	public function eventorg_public_styles() {
		wp_register_style('eventorg-custom-styles', EVENTORG_URL . 'includes/css/custom.css', array(), time());
        wp_enqueue_style('eventorg-custom-styles');
	}
	
  

    /**
     * Adding Hooks
     *
     * @package EVENTORG
     * @since 1.0.0
     */
    function add_hooks() {
		
		// Shortcode for event list
		add_shortcode( 'event-list', array($this,'eventorg_event_shortcode') );
		
		// style for front event list
		add_action('wp_enqueue_scripts', array($this, 'eventorg_public_styles'));
		
    }

}

?>