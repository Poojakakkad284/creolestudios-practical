<?php

// Export Event Page HTML

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


$current_date = date('Y-m-d');

$args  = array( 
    'post_type' => 'events', 
    'posts_per_page' => -1,
    'post_status' => 'publish',
	'meta_query' => array(
		'relation' => 'AND',
		array(
			'key'        => 'start_date',
			'compare'    => '<',
			'value'      => $current_date,
            ),
	)
);

$events = get_posts($args);
$number_event = count($events);
?>
<div class="wrap">
    <h1><?php _e( 'Export Past Events', 'eventorg'); ?></h1>
    <form method="post" action="">

        <?php settings_fields( 'eventorg_settings_options' ); ?>

        <div id="eventorg-settings" class="post-box-container">
            <div class="metabox-holder">
                <div class="meta-box-sortables ui-sortable">
                    <div id="eventorg-settings-postbox" class="postbox">	
                       
                        <div class="inside">
                            <div class="eventorg-general-main-warp">
                                <table class="form-table">
                                    <tbody>
                                        <tr>
                                            <th scope="row">
                                                <label for="wptap_register_page"><?php _e('There are '.$number_event.' past events can be export', 'eventorg'); ?></label>
                                            </th>
                                           
                                        </tr>
                                       <?php if($number_event > 0) { ?>
                                        <tr>
                                            <td>
                                                <input type="submit" class="button button-primary left" name="eventorg_export" id="save_settings_eventorg" value="<?php _e( 'Export Events', 'eventorg' );?>" />
                                            </td>
                                        </tr> 
									   <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
