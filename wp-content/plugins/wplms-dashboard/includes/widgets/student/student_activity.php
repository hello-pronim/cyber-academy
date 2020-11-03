<?php

add_action( 'widgets_init', 'wplms_student_activity' );

function wplms_student_activity() {
    register_widget('wplms_student_activity');
}

class wplms_student_activity extends WP_Widget {
 
 
    /** constructor -- name this the same as the class above */
    function __construct() {
        $widget_ops = array( 'classname' => 'wplms_student_activity', 'description' => __('Student Customize activity', 'wplms-dashboard') );
        $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wplms_student_activity' );
        parent::__construct( 'wplms_student_activity', __(' DASHBOARD : Student Customize Activity', 'wplms-dashboard'), $widget_ops, $control_ops );
    }
        
 
    /** @see WP_Widget::widget -- do not rename this */
    function widget( $args, $instance ) {
        extract( $args );

        //Our variables from the widget settings.
        $title = apply_filters('widget_title', $instance['title'] );
        $num =  $instance['number'];
        $activity =  $instance['activity'];
        $messages =  $instance['messages'];
        $friends =  $instance['friends'];

        if(!is_numeric($num))
            $num=5;

        $user_id= apply_filters('wplms_dashboard_student_id', bp_displayed_user_id());
        $width =  $instance['width'];
        echo '<div class="'.$width.'"><div class="dash-widget">'.$before_widget;

        if ( $title ) {
            echo '<p class="profile-title">' . $title . '</p>';    

            $calendar_icon = '<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
            width="50" height="50"
            viewBox="0 0 172 172"
            style=" fill:#000000;"><defs><linearGradient x1="22.9835" y1="48.9555" x2="149.69017" y2="141.49867" gradientUnits="userSpaceOnUse" id="color-1_WpQIVxfhhzqt_gr1"><stop offset="0" stop-color="#70dfff"></stop><stop offset="1" stop-color="#70afff"></stop></linearGradient><linearGradient x1="23.005" y1="23.67867" x2="147.62617" y2="49.02" gradientUnits="userSpaceOnUse" id="color-2_WpQIVxfhhzqt_gr2"><stop offset="0" stop-color="#00c6ff"></stop><stop offset="1" stop-color="#0072ff"></stop></linearGradient></defs><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g><path d="M21.5,143.33333v-100.33333h129v100.33333c0,3.94167 -3.225,7.16667 -7.16667,7.16667h-114.66667c-3.94167,0 -7.16667,-3.225 -7.16667,-7.16667z" fill="url(#color-1_WpQIVxfhhzqt_gr1)"></path><path d="M150.5,28.66667v21.5h-129v-21.5c0,-3.94167 3.225,-7.16667 7.16667,-7.16667h114.66667c3.94167,0 7.16667,3.225 7.16667,7.16667z" fill="url(#color-2_WpQIVxfhhzqt_gr2)"></path><path d="M127.20833,44.79167v0c-5.93758,0 -10.75,-4.81242 -10.75,-10.75v-12.54167h21.5v12.54167c0,5.93758 -4.81242,10.75 -10.75,10.75z" fill="#000000" opacity="0.05"></path><path d="M127.20833,42.10417v0c-4.45408,0 -8.0625,-3.60842 -8.0625,-8.0625v-12.54167h16.125v12.54167c0,4.45408 -3.60842,8.0625 -8.0625,8.0625z" fill="#000000" opacity="0.07"></path><path d="M44.79167,44.79167v0c-5.93758,0 -10.75,-4.81242 -10.75,-10.75v-12.54167h21.5v12.54167c0,5.93758 -4.81242,10.75 -10.75,10.75z" fill="#000000" opacity="0.05"></path><path d="M44.79167,42.10417v0c-4.45408,0 -8.0625,-3.60842 -8.0625,-8.0625v-12.54167h16.125v12.54167c0,4.45408 -3.60842,8.0625 -8.0625,8.0625z" fill="#000000" opacity="0.07"></path><path d="M44.79167,39.41667v0c-2.967,0 -5.375,-2.408 -5.375,-5.375v-14.33333c0,-2.967 2.408,-5.375 5.375,-5.375v0c2.967,0 5.375,2.408 5.375,5.375v14.33333c0,2.967 -2.408,5.375 -5.375,5.375z" fill="#3ccbf4"></path><path d="M136.16667,69.875v10.75c0,0.989 -0.80267,1.79167 -1.79167,1.79167h-10.75c-0.989,0 -1.79167,-0.80267 -1.79167,-1.79167v-10.75c0,-0.989 0.80267,-1.79167 1.79167,-1.79167h10.75c0.989,0 1.79167,0.80267 1.79167,1.79167zM107.5,69.875v10.75c0,0.989 -0.80267,1.79167 -1.79167,1.79167h-10.75c-0.989,0 -1.79167,-0.80267 -1.79167,-1.79167v-10.75c0,-0.989 0.80267,-1.79167 1.79167,-1.79167h10.75c0.989,0 1.79167,0.80267 1.79167,1.79167zM78.83333,69.875v10.75c0,0.989 -0.80267,1.79167 -1.79167,1.79167h-10.75c-0.989,0 -1.79167,-0.80267 -1.79167,-1.79167v-10.75c0,-0.989 0.80267,-1.79167 1.79167,-1.79167h10.75c0.989,0 1.79167,0.80267 1.79167,1.79167z" fill="#ffffff"></path><path d="M136.16667,94.95833v10.75c0,0.989 -0.80267,1.79167 -1.79167,1.79167h-10.75c-0.989,0 -1.79167,-0.80267 -1.79167,-1.79167v-10.75c0,-0.989 0.80267,-1.79167 1.79167,-1.79167h10.75c0.989,0 1.79167,0.80267 1.79167,1.79167zM107.5,94.95833v10.75c0,0.989 -0.80267,1.79167 -1.79167,1.79167h-10.75c-0.989,0 -1.79167,-0.80267 -1.79167,-1.79167v-10.75c0,-0.989 0.80267,-1.79167 1.79167,-1.79167h10.75c0.989,0 1.79167,0.80267 1.79167,1.79167zM78.83333,94.95833v10.75c0,0.989 -0.80267,1.79167 -1.79167,1.79167h-10.75c-0.989,0 -1.79167,-0.80267 -1.79167,-1.79167v-10.75c0,-0.989 0.80267,-1.79167 1.79167,-1.79167h10.75c0.989,0 1.79167,0.80267 1.79167,1.79167zM50.16667,94.95833v10.75c0,0.989 -0.80267,1.79167 -1.79167,1.79167h-10.75c-0.989,0 -1.79167,-0.80267 -1.79167,-1.79167v-10.75c0,-0.989 0.80267,-1.79167 1.79167,-1.79167h10.75c0.989,0 1.79167,0.80267 1.79167,1.79167z" fill="#ffffff"></path><path d="M107.5,120.04167v10.75c0,0.989 -0.80267,1.79167 -1.79167,1.79167h-10.75c-0.989,0 -1.79167,-0.80267 -1.79167,-1.79167v-10.75c0,-0.989 0.80267,-1.79167 1.79167,-1.79167h10.75c0.989,0 1.79167,0.80267 1.79167,1.79167zM78.83333,120.04167v10.75c0,0.989 -0.80267,1.79167 -1.79167,1.79167h-10.75c-0.989,0 -1.79167,-0.80267 -1.79167,-1.79167v-10.75c0,-0.989 0.80267,-1.79167 1.79167,-1.79167h10.75c0.989,0 1.79167,0.80267 1.79167,1.79167zM50.16667,120.04167v10.75c0,0.989 -0.80267,1.79167 -1.79167,1.79167h-10.75c-0.989,0 -1.79167,-0.80267 -1.79167,-1.79167v-10.75c0,-0.989 0.80267,-1.79167 1.79167,-1.79167h10.75c0.989,0 1.79167,0.80267 1.79167,1.79167z" fill="#ffffff"></path><path d="M127.20833,39.41667v0c-2.967,0 -5.375,-2.408 -5.375,-5.375v-14.33333c0,-2.967 2.408,-5.375 5.375,-5.375v0c2.967,0 5.375,2.408 5.375,5.375v14.33333c0,2.967 -2.408,5.375 -5.375,5.375z" fill="#3ccbf4"></path></g></g></svg>';

            $clock_icon = '<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
            width="50" height="50"
            viewBox="0 0 172 172"
            style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#267ab7"><path d="M86,6.88c-43.65603,0 -79.12,35.46397 -79.12,79.12c0,43.65603 35.46397,79.12 79.12,79.12c43.65603,0 79.12,-35.46397 79.12,-79.12c0,-43.65603 -35.46397,-79.12 -79.12,-79.12zM86,13.76c39.93779,0 72.24,32.30221 72.24,72.24c0,39.93779 -32.30221,72.24 -72.24,72.24c-39.93779,0 -72.24,-32.30221 -72.24,-72.24c0,-39.93779 32.30221,-72.24 72.24,-72.24zM85.94625,24.03297c-1.89722,0.02966 -3.41223,1.58976 -3.38625,3.48703v48.75797c-4.12064,1.45686 -6.87671,5.35144 -6.88,9.72203c0.00314,1.53746 0.34976,3.05478 1.01453,4.4411l-20.64672,20.64672c-0.89867,0.86281 -1.26068,2.14404 -0.94641,3.34956c0.31427,1.20552 1.2557,2.14696 2.46122,2.46122c1.20552,0.31427 2.48675,-0.04774 3.34956,-0.94641l20.64672,-20.64672c1.38631,0.66477 2.90364,1.01139 4.4411,1.01453c5.69958,0 10.32,-4.62042 10.32,-10.32c-0.00613,-4.36813 -2.76169,-8.25927 -6.88,-9.71531v-48.76469c0.01273,-0.92983 -0.35149,-1.82522 -1.00967,-2.48214c-0.65819,-0.65692 -1.55427,-1.01942 -2.48408,-1.00489z"></path></g></g></svg>';
			
			$chart_icon = '<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
            width="50" height="50"
            viewBox="0 0 172 172"
            style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g><path d="M157.66667,28.66667v118.25h-28.66667v-118.25c0,-1.978 1.60533,-3.58333 3.58333,-3.58333h21.5c1.978,0 3.58333,1.60533 3.58333,3.58333z" fill="#267ab7"></path><path d="M129,53.75v93.16667h-28.66667v-93.16667z" fill="#35c1f1"></path><path d="M100.33333,46.58333v100.33333h-28.66667v-100.33333c0,-1.978 1.60533,-3.58333 3.58333,-3.58333h21.5c1.978,0 3.58333,1.60533 3.58333,3.58333z" fill="#199be2"></path><path d="M71.66667,71.66667v75.25h-28.66667v-75.25z" fill="#0078d4"></path><path d="M43,60.91667v86h-28.66667v-86c0,-1.978 1.60533,-3.58333 3.58333,-3.58333h21.5c1.978,0 3.58333,1.60533 3.58333,3.58333z" fill="#0d62ab"></path></g></g></svg>';
            
            global $wpdb,$bp;
            // Get last accessed date.
            $last_login_time = get_user_meta($user_id,'last_login_time',true);
            $last_access_date = date('m / d / Y', strtotime($last_login_time));

            // Get the activity time
            $last_activity = get_user_meta($user_id,'last_activity',true);
            $activity_time = date('h:i A', strtotime($last_activity));

            // Get the last login number for this week.
            $login_week_number = $wpdb->get_var($wpdb->prepare("
                SELECT count(id) as number
                    FROM {$wpdb->prefix}aiowps_login_activity AS activity
                    WHERE activity.user_id = %d AND activity.login_date > DATE_SUB(NOW(), INTERVAL 1 WEEK)", $user_id));	
            $login_2week_number = $wpdb->get_var($wpdb->prepare("
                    SELECT count(id) as number
                        FROM {$wpdb->prefix}aiowps_login_activity AS activity
                        WHERE activity.user_id = %d AND activity.login_date > DATE_SUB(NOW(), INTERVAL 2 WEEK)", $user_id));	
            
            $login_2last_week = ($login_2week_number - $login_week_number);
            $login_week_percent = $login_week_number > 0 ? ceil((($login_week_number - $login_2last_week) / $login_week_number) * 100) : 0;
            $login_week_percent = $login_week_percent > 0 ? '+'.$login_week_percent.'%' : $login_week_percent.'%'; 
            $login_week_color = $login_week_percent > 0 ? 'lightgreen' : 'red';

            // Get the last login number for this month
            $login_month_number = $wpdb->get_var($wpdb->prepare("
                SELECT count(id) as number
                    FROM {$wpdb->prefix}aiowps_login_activity AS activity
                    WHERE activity.user_id = %d AND activity.login_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)", $user_id));
            $login_2month_number = $wpdb->get_var($wpdb->prepare("
                SELECT count(id) as number
                    FROM {$wpdb->prefix}aiowps_login_activity AS activity
                    WHERE activity.user_id = %d AND activity.login_date > DATE_SUB(NOW(), INTERVAL 2 MONTH)", $user_id));
            
            $login_2last_month = ($login_2month_number - $login_month_number);
            $login_month_percent = $login_month_number > 0 ? ceil((($login_month_number - $login_2last_month) / $login_month_number) * 100) : 0;
            $login_month_percent = $login_month_percent > 0 ? '+'.$login_month_percent.'%' : $login_month_percent.'%';
            $login_month_color = $login_month_percent > 0 ? 'lightgreen' : 'red';

            echo '<div class="student_activity col-md-12 col-sm-12">
                <div class="row access_date_time">
                    <div class="col-md-3 col-sm-3">
                        <ul>
                            <li>'.$calendar_icon.'</li>
                            <li>
                                <p class="activity_title">Last access date</p>
                            </li>
                            <li>'.$last_access_date.'</li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <ul>
                            <li>'.$clock_icon.'</li>
                            <li>
                                <p class="activity_title">At time</p>
                            </li>
                            <li>'.$activity_time.'</li>
                        </ul>
                    </div>
					<div class="col-md-3 col-sm-3">
                        <ul>
							<li>'.$chart_icon.'</li>
                            <li class="activity_title">Login this week</li>
                            <li>'.$login_week_number.' <strong style="color: '.$login_week_color.';">'.$login_week_percent.'</strong></li>
                        </ul>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <ul>
						   	<li>'.$chart_icon.'</li>
                            <li class="activity_title">Login this month</li>
                            <li>'.$login_month_number.' <strong style="color: '.$login_month_color.';">'.$login_month_percent.'</strong></li>
                        </ul>
                    </div>
                </div>
               
                    
                
            </div>';
            
        }
        echo '</div></div>'.$after_widget.'</div></div>';                
    }
 
    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {   
	    $instance = $old_instance;
	    $instance['title'] = strip_tags($new_instance['title']);
	    $instance['number'] = $new_instance['number'];
	    $instance['activity'] = $new_instance['activity'];
        $instance['messages'] = $new_instance['messages'];
        $instance['friends'] = $new_instance['friends'];
        $instance['width'] = $new_instance['width'];
        return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {  
        $defaults = array( 
                        'title'  => __('Student Customize Activity','wplms-dashboard'),
                        'number'  => 5,
                        'friends' => 1,
                        'width' => 'col-md-6 col-sm-12'
                    );
  		$instance = wp_parse_args( (array) $instance, $defaults );
        $title  = esc_attr($instance['title']);
        $number = esc_attr($instance['number']);
        $activity = esc_attr($instance['activity']);
        $messages = esc_attr($instance['messages']);
        $friends = esc_attr($instance['friends']);
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
          <label for="<?php echo $this->get_field_id('messages'); ?>"><?php _e('Show recent messages','wplms-dashboard'); ?></label> 
          <input class="checkbox" id="<?php echo $this->get_field_id( 'messages' ); ?>" name="<?php echo $this->get_field_name( 'messages' ); ?>" type="checkbox" value="1"  <?php checked($messages,1,true) ?>/>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('activity'); ?>"><?php _e('Show recent activity','wplms-dashboard'); ?></label> 
          <input class="checkbox" id="<?php echo $this->get_field_id( 'activity' ); ?>" name="<?php echo $this->get_field_name( 'activity' ); ?>" type="checkbox" value="1"  <?php checked($activity,1,true) ?>/>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('friends'); ?>"><?php _e('Show online Friends','wplms-dashboard'); ?></label> 
          <input class="checkbox" id="<?php echo $this->get_field_id( 'friends' ); ?>" name="<?php echo $this->get_field_name( 'friends' ); ?>" type="checkbox" value="1"  <?php checked($friends,1,true) ?>/>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('Select Width','wplms-dashboard'); ?></label> 
          <select id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>">
          	<option value="col-md-3 col-sm-6" <?php selected('col-md-3 col-sm-6',$width); ?>><?php _e('One Fourth','wplms-dashboard'); ?></option>
          	<option value="col-md-4 col-sm-6" <?php selected('col-md-4 col-sm-6',$width); ?>><?php _e('One Third','wplms-dashboard'); ?></option>
          	<option value="col-md-6 col-sm-12" <?php selected('col-md-6 col-sm-12',$width); ?>><?php _e('One Half','wplms-dashboard'); ?></option>
            <option value="col-md-8 col-sm-12" <?php selected('col-md-8 col-sm-12',$width); ?>><?php _e('Two Third','wplms-dashboard'); ?></option>
             <option value="col-md-8 col-sm-12" <?php selected('col-md-9 col-sm-12',$width); ?>><?php _e('Three Fourth','wplms-dashboard'); ?></option>
          	<option value="col-md-12 col-sm-12" <?php selected('col-md-12 col-sm-12',$width); ?>><?php _e('Full','wplms-dashboard'); ?></option>
          </select>
        </p>
        <?php 
    }
} 

?>