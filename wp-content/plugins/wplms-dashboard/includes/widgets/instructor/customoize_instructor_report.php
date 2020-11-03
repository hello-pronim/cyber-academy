<?php

add_action( 'widgets_init', 'wplms_customize_instructor_report' );

function wplms_customize_instructor_report() {
    register_widget('wplms_customize_instructor_report');
}

class wplms_customize_instructor_report extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function __construct() {
        $widget_ops = array( 'classname' => 'wplms_customize_instructor_report', 'description' => __('Instructor User Report for Graph', 'wplms-dashboard') );
        $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wplms_customize_instructor_report' );
        parent::__construct( 'wplms_customize_instructor_report', __(' DASHBOARD : Instructor User Report', 'wplms-dashboard'), $widget_ops, $control_ops );
    }
        
 
    /** @see WP_Widget::widget -- do not rename this */
    function widget( $args, $instance ) {
        extract( $args );

        //Our variables from the widget settings.
        $title = apply_filters('widget_title', $instance['title'] );
        $num =  $instance['number'];

        if(!is_numeric($num))
            $num=5;

        $user_id= apply_filters('wplms_dashboard_student_id',bp_displayed_user_id());
        $width =  $instance['width'];
        echo '<div class="'.$width.'"><div class="customize_instructor_report dash-widget">'.$before_widget;

        if ( $title ) {
            echo '<div class="instructor_report_title">';
            echo $before_title . $title . $after_title;
			echo '<div class="report_action"><div class="start_activity">';
			echo '<i class="fa fa-calendar" aria-hidden="true"></i>';
			echo '<div class="report_date"><p>'.__('Start Date','wplms-dashboard').'</p><input type="text" /></div>';
			echo '</div><div class="end_activity">';
			echo '<i class="fa fa-calendar" aria-hidden="true"></i>';
			echo '<div class="report_date"><p>'.__('End Date','wplms-dashboard').'</p><input type="text"/></div>';
			echo '</div><input type="button" value="'.__('Show','wplms-dashboard').'"/></div>';
            echo '<strong>'.__('More','wplms-dashboard').'</strong>';
            echo '</div>';
        }
            
        echo '<div id="vibe-tabs-student-activity" class="tabs tabbable">';

        // Display the widget title 
        
        global $wpdb,$bp;

//         $activities=apply_filters('wplms_dashboard_activity', $wpdb->get_results($wpdb->prepare("
//             SELECT *
//             FROM {$bp->activity->table_name} AS activity
//             WHERE 	activity.user_id IN (%d)
//             AND     (activity.action != '' OR activity.action IS NOT NULL)
//             ORDER BY activity.date_recorded DESC
//             LIMIT 0,$num
//         ",$user_id)));

            
        echo '<div id="tab-activity" class="tab-pane student_activity">';

        if(isset($activities) && is_array($activities)) {
            echo '<ul class="instructor-activities">';
            foreach($activities as $activity){
                if(isset($activity->action) && $activity->action != '') {
                    echo '<li class="'.$activity->component.' '.$activity->type.'">
                            <div class="instructor-activity">
                                '.bp_core_fetch_avatar( array( 'item_id' => $user_id,'type'=>'thumb')).'
                                <strong>'.$activity->action.'</strong>
                                <p>'.$activity->date_recorded.'</p>
                            </div>
                        </li>';
                }			  
            }	
            echo '</ul>';
        } else {
            echo '<div class="message error">'.__('No report found','wplms-dashboard').'</div>';
        }

        echo '</div></div>'.$after_widget.'</div></div>';
                
    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {   
	    $instance = $old_instance;
	    $instance['title'] = strip_tags($new_instance['title']);
	    $instance['number'] = $new_instance['number'];
	    $instance['width'] = $new_instance['width'];
	    return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {  
        $defaults = array( 
                        'title'  => __('Instructor User Report','wplms-dashboard'),
                        'number'  => 5,
                        'friends' => 1,
                        'width' => 'col-md-6 col-sm-12'
                    );
  		$instance = wp_parse_args( (array) $instance, $defaults );
        $title  = esc_attr($instance['title']);
        $number = esc_attr($instance['number']);
        $width = esc_attr($instance['width']);
        ?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','wplms-dashboard'); ?></label> 
          <input class="regular_text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of items','wplms-dashboard'); ?></label> 
          <input class="regular_text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Select Width','wplms-dashboard'); ?></label> 
          <select id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>">
          	<option value="col-md-3 col-sm-6" <?php selected('col-md-3 col-sm-6',$width); ?>><?php _e('One Fourth','wplms-dashboard'); ?></option>
          	<option value="col-md-4 col-sm-6" <?php selected('col-md-4 col-sm-6',$width); ?>><?php _e('One Third','wplms-dashboard'); ?></option>
          	<option value="col-md-6 col-sm-12" <?php selected('col-md-6 col-sm-12',$width); ?>><?php _e('One Half','wplms-dashboard'); ?></option>
            <option value="col-md-8 col-sm-12" <?php selected('col-md-8 col-sm-12',$width); ?>><?php _e('Two Third','wplms-dashboard'); ?></option>
             <option value="col-md-9 col-sm-12" <?php selected('col-md-9 col-sm-12',$width); ?>><?php _e('Three Fourth','wplms-dashboard'); ?></option>
          	<option value="col-md-12" <?php selected('col-md-12',$width); ?>><?php _e('Full','wplms-dashboard'); ?></option>
          </select>
        </p>
        <?php 
    }
} 

?>