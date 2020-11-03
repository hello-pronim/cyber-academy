<?php

add_action( 'widgets_init', 'wplms_dash_student_customize_progress' );

function wplms_dash_student_customize_progress() {
    register_widget('wplms_student_customize_progress');
}

class wplms_student_customize_progress extends WP_Widget {
 
    /** constructor -- name this the same as the class above */
    function __construct() {
        $widget_ops = array( 'classname' => 'wplms_student_customize_progress', 'description' => __('Customize Student Progress in Courses', 'wplms-dashboard') );
        $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wplms_student_customize_progress' );
        parent::__construct( 'wplms_student_customize_progress', __(' DASHBOARD : Student Progress', 'wplms-dashboard'), $widget_ops, $control_ops );

        //Start recording Course Progress
        add_action('wplms_student_course_reset',array($this,'wplms_student_course_reset'),10,2);
        add_action('wplms_student_course_remove',array($this,'wplms_student_course_remove'),10,2);
        add_action( 'wp_ajax_reset_course_user', array($this,'reset_course_user'),20 ); // RESETS COURSE FOR USER

    }        
 
    /** @see WP_Widget::widget -- do not rename this */
    function widget( $args, $instance ) {
        extract( $args );

        //Our variables from the widget settings.
        $title = apply_filters('widget_title', $instance['title'] );
        $num =  $instance['number'];
        $finished =  $instance['finished'];
        $width =  $instance['width'];
        echo '<div class="'.$width.'">
                <div class="dash-widget">'.$before_widget;

        // Display the widget title 
        if ( $title ) {
            echo '<p class="profile-title">' . $title . '</p>';          
			
            global $wpdb,$bp;
            $user_id = get_current_user_id();
			
			// Get the courses count
			$course_completed = $wpdb->get_results(sprintf("
                SELECT rel.post_id as id,rel.meta_value as val
                    FROM {$wpdb->posts} AS posts
                    LEFT JOIN {$wpdb->postmeta} AS rel ON posts.ID = rel.post_id
                    WHERE   posts.post_type   = 'course'
                    AND   posts.post_status   = 'publish'
                    AND   rel.meta_key   = %d
                    AND   rel.meta_value > 2
                ",$user_id));			
            $course_count = count($course_completed);
            			
			// Get the units count
             $marks_old = $wpdb->get_var($wpdb->prepare("
                SELECT count(meta_key) as count
                    FROM {$wpdb->posts} AS posts
                    LEFT JOIN {$wpdb->usermeta} AS rel ON posts.ID = rel.meta_key
                    WHERE   posts.post_type   = %s
                    AND   posts.post_status   = %s
                    AND   rel.user_id = %d
                    AND   rel.meta_value > 0",'unit','publish',$user_id));

             $marks_new = $wpdb->get_var($wpdb->prepare("
                SELECT count(meta_value) as count
                    FROM {$wpdb->usermeta}
                    WHERE user_id = %d
                    AND   meta_key LIKE %s",$user_id,'%complete_unit_%'));
            
             $units_count = $marks_new + $marks_old;

            // Get the `in progress` units count
            $inprogress_count = $marks_old;

            // Get the units for `To begin`
            $course_tobegin = $wpdb->get_var($wpdb->prepare("
                SELECT count(meta_key) as count
                    FROM {$wpdb->posts} AS posts
                    LEFT JOIN {$wpdb->usermeta} AS rel ON posts.ID = rel.meta_key
                    WHERE   posts.post_type   = %s
                    AND   posts.post_status   = %s
                    AND   rel.meta_value > 0",'unit','publish'));

            // Get the number of course completed
            $course_completed = $wpdb->get_results(sprintf("
                    SELECT rel.post_id as id,rel.meta_value as val
                      FROM {$wpdb->posts} AS posts
                      LEFT JOIN {$wpdb->postmeta} AS rel ON posts.ID = rel.post_id
                      WHERE   posts.post_type   = 'course'
                      AND   posts.post_status   = 'publish'
                      AND   rel.meta_key   = %d
                      AND   rel.meta_value > 2
                  ",$user_id));
            $course_completed_count = count($course_completed);
			
			
			
			 
				
			$course_active = bp_course_get_total_course_count_for_user($user_id);		
			
			

            // Get the to begin percentage
            $course_percent = $course_tobegin > 0 ? ceil(($course_completed / $course_tobegin) * 100) : 0;
            $progress_percent = $units_count > 0 ? ceil(($inprogress_count / $units_count) * 100) : 0;
            $completed_percent = $course_tobegin > 0 ? ceil(($course_completed_count / $course_tobegin) * 100) : 0;
			
            echo '<div class="course_progress">
                <ul class="dash-courses-progress">
                    <li> 
                        <p>Active Courses</p>
                        <p>'.$course_active.'</p>
                    </li>
                    <li>
                        <p>Active Units</p>
                        <p>'.$units_count.'</p>
                    </li>
                    <li>
                        <p>To begin</p>
                        <div class="row"> 
                            <p class="col-md-4 col-sm-4 col-xs-4">'.$course_tobegin.'</p>
                            <div class="col-md-6 col-sm-6 progress course_progress" style="background-color: #ff7058b3;padding: 0;width: 45%;">
                                <div class="bar animate stretchRight" style="width: '.$course_percent.'%; background-color:black;"></div>
                            </div>
                            <strong class="col-md-2 col-sm-2"><span>'.$course_percent.'%</span></strong>
                        </div>
                    </li>
                    <li>
                        <p>In progress</p>
                        <div class="row"> 
                            <p class="col-md-4 col-sm-4 col-xs-4">'.$inprogress_count.'</p>
                            <div class="col-md-6 col-sm-6 progress course_progress" style="background-color: #f7f755c4;padding: 0;width: 45%;">
                                <div class="bar animate stretchRight" style="width: '.$progress_percent.'%; background-color:black;"></div>
                            </div>
                            <strong class="col-md-2 col-sm-2"><span>'.$progress_percent.'%</span></strong>
                        </div>
                    </li>
                    <li>
                        <p>Completed</p>
                        <div class="row"> 
                            <p class="col-md-4 col-sm-4 col-xs-4">'.$course_completed_count.'</p>
                            <div class="col-md-6 col-sm-6 progress course_progress" style="background-color: #44ff0080;padding: 0;width: 45%;">
                                <div class="bar animate stretchRight" style="width: '.$completed_percent.'%; background-color:black;"></div>
                            </div>
                            <strong class="col-md-2 col-sm-2"><span>'.$completed_percent.'%</span></strong>
                        </div>
                    </li>
                    </ul>
            </div>';
        }
        echo $after_widget.'</div></div>';
    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {   
	    $instance = $old_instance;
	    $instance['title'] = strip_tags($new_instance['title']);
	    $instance['number'] = $new_instance['number'];
	    $instance['finished'] = $new_instance['finished'];
	    $instance['width'] = $new_instance['width'];
	    return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {  
        $defaults = array( 
                        'title'  => __('Course Progress','wplms-dashboard'),
                        'number'  => 5,
                        'finished' => 1,
                        'width' => 'col-md-6 col-sm-12'
                    );

  		$instance = wp_parse_args( (array) $instance, $defaults );
        $title  = esc_attr($instance['title']);
        $finished = esc_attr($instance['finished']);
        $number = esc_attr($instance['number']);
        $width = esc_attr($instance['width']);
        ?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','wplms-dashboard'); ?></label> 
          <input class="regular_text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of activities in one screen','wplms-dashboard'); ?></label> 
          <input class="regular_text" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('finished'); ?>"><?php _e('Show Finished Courses','wplms-dashboard'); ?></label> 
          <input class="checkbox" id="<?php echo $this->get_field_id( 'finished' ); ?>" name="<?php echo $this->get_field_name( 'finished' ); ?>" type="checkbox" value="1"  <?php checked($finished,1,true) ?>/>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Select Width','wplms-dashboard'); ?></label> 
          <select id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>">
          	<option value="col-md-3 col-sm-6" <?php selected('col-md-3 col-sm-6',$width); ?>><?php _e('One Fourth','wplms-dashboard'); ?></option>
          	<option value="col-md-4 col-sm-6" <?php selected('col-md-4 col-sm-6',$width); ?>><?php _e('One Third','wplms-dashboard'); ?></option>
          	<option value="col-md-6 col-sm-12" <?php selected('col-md-6 col-sm-12',$width); ?>><?php _e('One Half','wplms-dashboard'); ?></option>
            <option value="col-md-8 col-sm-12" <?php selected('col-md-8 col-sm-12',$width); ?>><?php _e('Two Third','wplms-dashboard'); ?></option>
             <option value="col-md-8 col-sm-12" <?php selected('col-md-9 col-sm-12',$width); ?>><?php _e('Three Fourth','wplms-dashboard'); ?></option>
          	<option value="col-md-12" <?php selected('col-md-12',$width); ?>><?php _e('Full','wplms-dashboard'); ?></option>
          </select>
        </p>
        <?php 
    }

    
    function wplms_student_course_reset($course_id,$user_id) {
      $progress='progress'.$course_id;
      update_user_meta($user_id,$progress,0);
    }

    function wplms_student_course_remove($course_id,$user_id) {
      $progress='progress'.$course_id;
      delete_user_meta($user_id,$progress);
    }

    function calculate_course_progress($course_id) {
      $user_id = get_current_user_id();
      $progress='progress'.$course_id;
      $curriculum=bp_course_get_curriculum_units($course_id);
      $base = count($curriculum);
      foreach($curriculum as $key=>$unit){
        $check = get_user_meta($user_id,$unit,true);
        if(!isset($check) || !$check)
          break;
      }   
      if(!$base)$base=1;
      $course_progress = round((100*($key/$base)),0);
      update_user_meta($user_id,$progress,$course_progress);
      return $course_progress;
    }

    function reset_course_user() {
      $course_id = $_POST['id'];
      $user_id = $_POST['user'];

      if ( !isset($_POST['security']) || !wp_verify_nonce($_POST['security'],'vibe_security') ){
          echo '<p>'.__('Security check failed !','wplms-dashboard').'</p>';
          die();
      }

      if ( !isset($user_id) || !is_numeric($user_id) || !$user_id){
          echo '<p>'.__(' Incorrect User selected.','wplms-dashboard').'</p>';
          die();
      }
      $progress='progress'.$course_id;
      update_user_meta($user_id,$progress,0);
      die();
    }
} 

?>