<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

/**
 * Admin Class
 *
 * Manage Admin Panel Class
 *
 * @package EVENTORG
 * @since 1.0.0
 */
class Eventorg_Admin {

 
	//class constructor
    function __construct() {

    }

	/**
	* Event Post Type, Taxonomy, Export Event
	*
	* @package EVENTORG
	* @since 1.0.0
	*/
	
	public function eventorg_event_manage () {
		
		// Post type labels
		$labels = array(
			'name'                => _x( 'Events', 'Post Type General Name', 'eventorg' ),
			'singular_name'       => _x( 'Event', 'Post Type Singular Name', 'eventorg' ),
			'menu_name'           => __( 'Events', 'eventorg' ),
			'parent_item_colon'   => __( 'Parent Event', 'eventorg' ),
			'all_items'           => __( 'All Events', 'eventorg' ),
			'view_item'           => __( 'View Event', 'eventorg' ),
			'add_new_item'        => __( 'Add New Event', 'eventorg' ),
			'add_new'             => __( 'Add New', 'eventorg' ),
			'edit_item'           => __( 'Edit Event', 'eventorg' ),
			'update_item'         => __( 'Update Event', 'eventorg' ),
			'search_items'        => __( 'Search Event', 'eventorg' ),
			'not_found'           => __( 'Not Found', 'eventorg' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'eventorg' ),
		);
		 
		
		$args = array(
			'label'               => __( 'events', 'eventorg' ),
			'description'         => __( 'Events', 'eventorg' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' => false,
	 	);
     
		// Register post type
		register_post_type( 'events', $args );
		
		
		// Taxonomy for the Events CPT		
		  $labels = array(
			'name' => _x( 'Event Types', 'taxonomy general name' ),
			'singular_name' => _x( 'Event Type', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Event Types' ),
			'all_items' => __( 'All Event Types' ),
			'parent_item' => __( 'Parent Event Type' ),
			'parent_item_colon' => __( 'Parent Event Type:' ),
			'edit_item' => __( 'Edit Event Type' ), 
			'update_item' => __( 'Update Event Type' ),
			'add_new_item' => __( 'Add New Event Type' ),
			'new_item_name' => __( 'New Event Type Name' ),
			'menu_name' => __( 'Event Types' ),
		  );    
		 
		// register the taxonomy
		  register_taxonomy('event_types',array('events'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'event_types' ),
		  ));
		  
		  
		  
		  // Event Export functionality
		  
		  $current_date = date('Y-m-d');
		  
		  if(isset($_REQUEST['eventorg_export'])) {
			$args  = array( 
				'post_type' => 'events', 
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'order' => 'DESC',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key'        => 'start_date',
						'compare'    => '<',
						'value'      => $current_date,
						),
				)
			);
	  
			
			$events = new WP_Query( $args );
			if ($events) {
	  
				header('Content-type: text/csv');
				header('Content-Disposition: attachment; filename="Events.csv"');
				header('Pragma: no-cache');
				header('Expires: 0');
	  
				$file = fopen('php://output', 'w');
	  
				fputcsv($file, array('Event Title', 'Summary', 'Categories', 'Start Date', 'End Date', 'Location'));
	  
				while ( $events->have_posts() ) { $events->the_post();
					  
					$categories =  get_the_terms( get_the_ID(), 'event_types' );
					$cats = array();
					if (!empty($categories)) {
						foreach ( $categories as $category ) {
							$cats[] = $category->name;
						}
					}
	  					
					$eventid = get_the_ID();
					$start_date = get_post_meta( $eventid, 'start_date', true );
					$formatdate = date('F j, Y', strtotime($start_date));
					
					$end_date = get_post_meta( $eventid, 'end_date', true );
					$formatenddate = date('F j, Y', strtotime($end_date));
					
					$location = get_post_meta( $eventid, 'location', true );	
	  
					fputcsv($file, array(get_the_title(), get_the_excerpt(), implode(",", $cats), $formatdate, $formatenddate, $location));
				}
				wp_reset_postdata();
	  
				exit();
			}
		}
		
		
	}
	
	
	/**
	* Event Export Menu page
	*
	* @package EVENTORG
	* @since 1.0.0
	*/
	
	public function eventorg_export_events() {
		add_submenu_page('edit.php?post_type=events', __('Export Past Events','eventorg'), __('Export Past Events','eventorg'), 'manage_options', 'export_events', array( $this, 'eventorg_export_event_function'));
	}  
	
	
	/**
	* Export Events Page Structure
	*
	* @package EVENTORG
	* @since 1.0.0
	*/
	public function eventorg_export_event_function() {
		
		// Event export page
		include_once( EVENTORG_ADMIN_DIR.'/eventorg-export-html.php' );
		
	}
	
	
	/**
	* Events Additional Meta Box Define
	*
	* @package EVENTORG
	* @since 1.0.0
	*/
	
	public function eventorg_events_metabox() {
		
		add_meta_box('eventorg-meta', __( 'Events Additional Information', 'eventorg' ), array( $this, 'eventorg_metafield_function' ), 'events', 'advanced', 'default' );
		
	}
	
	
	
	/**
	* Events Additional Meta Box Structure Define
	*
	* @param $postid   The current post id
	*
	* @package EVENTORG
	* @since 1.0.0
	*/
	
	
	public function eventorg_metafield_function($postid) {
		
		// Nonce field for security
        wp_nonce_field( 'eventorg_nonce', 'eventorg_nonce' );
		
		$start_date = get_post_meta( $postid->ID, 'start_date', true );		
		$end_date = get_post_meta( $postid->ID, 'end_date', true );		
		$location = get_post_meta( $postid->ID, 'location', true );		
		echo '<strong><label for="start_date">'. esc_html__('Start Date ', 'eventorg') .'</label></strong><br/>';
		echo '<input type="date" name="start_date" id="start_date"  value="'. esc_attr($start_date) .'" style="width:100%"/>';
		echo '<br/>';
		echo '<strong><label for="end_date">'. esc_html__('End Date ', 'eventorg') .'</label></strong><br/>';
		echo '<input type="date" name="end_date" id="end_date"  value="'. esc_attr($end_date) .'" style="width:100%"/>';
		echo '<br/>';
		echo '<strong><label for="location">'. esc_html__('Location ', 'eventorg') .'</label></strong><br/>';
		echo '<input type="text" name="location" id="location"  value="'. esc_attr($location) .'" style="width:100%"/>';
		
	}
	
	
	/**
	* Save Events Additional Meta fields
	*
	* @param $post_id   The current post id
	* @param $post  The current post.
	*
	* @package EVENTORG
	* @since 1.0.0
	*/
	public function eventorg_save_events_metabox($post_id, $post) {
		
		// Check nonce
        $nonce_name   = isset( $_POST['eventorg_nonce'] ) ? $_POST['eventorg_nonce'] : '';
        $nonce_action = 'eventorg_nonce';
 
        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
            return;
        }
 
        // Check user permissions
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
 
        // Check autosave.
        if ( wp_is_post_autosave( $post_id ) ) {
            return;
        }
 
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }
		
		
		// Check if post
		if ( isset( $_POST['post_type'] ) && $_POST['post_type'] == 'events') {
			
			if(isset($_POST['start_date'])){ 
				update_post_meta($post_id, 'start_date', $_POST['start_date']);
			}
			
			if(isset($_POST['end_date'])){ 
				update_post_meta($post_id, 'end_date', $_POST['end_date']);
			}
			
			if(isset($_POST['location'])){ 
				update_post_meta($post_id, 'location', $_POST['location']);
			}
 
		}
	}
	

  

    /**
     * Adding Hooks
     *
     * @package EVENTORG
     * @since 1.0.0
     */
    function add_hooks() {
		
		// Initialize custom post, export event
		add_action( 'init', array($this,'eventorg_event_manage'), 10 );
		
		// Register export event page
		add_action('admin_menu', array($this,'eventorg_export_events')); 
		
		// Action for add meta box in post
		add_action( 'add_meta_boxes', array($this, 'eventorg_events_metabox') );
		
		// Action for save meta box of post
		add_action( 'save_post', array($this, 'eventorg_save_events_metabox'), 10, 2 );
		
		
    }

}

?>