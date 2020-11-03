<?php

add_action( 'widgets_init', 'wplms_customize_instructor_users' );

function wplms_customize_instructor_users() {
    register_widget('wplms_customize_instructor_users');
}

class wplms_customize_instructor_users extends WP_Widget {

    /** constructor -- name this the same as the class above */
    function __construct() {
        $widget_ops = array( 'classname' => 'wplms_customize_instructor_users', 'description' => __('Customize Instructor Users widget', 'wplms-dashboard') );
        $control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'wplms_customize_instructor_users' );
        parent::__construct( 'wplms_customize_instructor_users', __(' DASHBOARD : Customize Instructor Users', 'wplms-dashboard'), $widget_ops, $control_ops );

        add_action('wp_ajax_instructor_load_more_students',array($this,'instructor_load_more_students'));
        
    }
        
    function widget( $args, $instance ) {

        extract( $args );

        if(!is_user_logged_in() || !current_user_can('edit_posts'))
            return;


        //Our variables from the widget settings.
        $title = apply_filters('widget_title', $instance['title'] );
        $width =  $instance['width'];
        
        echo '<div class="'.$width.'">
                <div class="dash-widget">'.$before_widget;
        if ( $title ) {
            echo '<div class="instructor_customize_three_part">';
            echo '<span class="instructor_user_active"><i class="fa fa-users" aria-hidden="true"></i></span>';
            echo '<p>'.$title.'</p>'; 
            echo '<strong class="instructor_load_more_users">'.__('More', 'vibe').'</strong>'; ?>
            <script>
				(function($) {
					$('.instructor_load_more_users').on('click',function(){                    
                        $(".spinner-loading").css('display', 'block');
						
                        $.ajax({
                            type: "POST",
                            url: ajaxurl,
                            data: { action: 'instructor_load_more_students',
                                    security:'<?php echo wp_create_nonce('instructor_load_more_students'); ?>',
                                    courses: '<?php echo $inst_courses; ?>',
                                },
                            cache: false,
                            success: function (html) {
								$(".spinner-loading").css('display', 'none');
                                $('.instructor_users_list').replaceWith(html);
                            }
                        });
					});
				})(jQuery);              
            </script>        
        <?php
            echo '</div>';
        }

        $students = $this->get_course_students();

        echo '<ul class="widget_users_list"><li class="customize_bp_user_title"><p>User Name</p><p>Role</p><p>Request</p></li>';        
        echo '<div class="instructor_users_list">';		
		echo '<div class="spinner-loading" role="status" style="display: none;">';
		echo '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>';
		echo '<span class="sr-only">Loading...</span>';
		echo '</div>';
		
        foreach ($students as $key => $student) {
			$user_meta = get_userdata($student['id']);
			$user_roles = $user_meta->roles; 
			
            echo '<li>'.bp_core_fetch_avatar( array( 'item_id' => $student['id'],'type'=>'thumb')).'';
            echo '<div class="customize_bp_user_info"><p>'.bp_core_get_user_displayname($student['id']).'</p><p>'.$student['email'].'</p></div>';
            echo '<p class="customize_bp_user_role">'.$user_roles[0].'</p><p class="customize_bp_user_request">Active</p></li>';
        }
        echo '</div>';
        echo '</ul>';        
        echo '</div></div></div><div class="clearfix"></div>';
    
    }

    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {   
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['width'] = $new_instance['width'];
        return $instance;
    }
 
    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {  
        $defaults = array( 
                        'title'  => __('Instructor Students','wplms-dashboard'),
                        'width' => 'col-md-6 col-sm-12'
                    );
        $instance = wp_parse_args( (array) $instance, $defaults );
        $title  = esc_attr($instance['title']);
        $width = esc_attr($instance['width']);
        ?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','wplms-dashboard'); ?></label> 
          <input class="regular_text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
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

    // Get the students of instructor's course
    function get_course_students() {
        global $wpdb;
        $user_id = get_current_user_id();
        $query = apply_filters('wplms_dashboard_courses_instructors',$wpdb->prepare("
                SELECT posts.ID as course_id
                  FROM {$wpdb->posts} AS posts
                  WHERE   posts.post_type   = 'course'
                  AND   posts.post_author   = %d
              ",$user_id));
  
          $instructor_courses = $wpdb->get_results($query,ARRAY_A);
          $course_ids = array();
          if(isset($instructor_courses) && count($instructor_courses)) {
            foreach($instructor_courses as $key => $value) {
                $course_ids[]=$value['course_id'];
            }
          }
        $course_ids_string = implode(',',$course_ids);		
        $course_students = $wpdb->get_results("
          SELECT rel.user_id, user.user_email
            FROM {$wpdb->usermeta} as rel LEFT JOIN {$wpdb->users} as user ON rel.user_id = user.id
            WHERE  rel.meta_key  IN ($course_ids_string)
            AND   rel.meta_value >= 0
        ",ARRAY_A);
  
        $unique = array();
        $mycourse_students = array();
        if ( isset($course_students) && is_array( $course_students) ) {
            foreach ( $course_students as $user ) {
                if(!in_array($user['user_id'],$unique)) {
                    $mycourse_students[] = array(
                        'id' => $user['user_id'],
                        'email' => $user['user_email'],
                        'pic' => bp_core_fetch_avatar( array( 'item_id' => $user['user_id'],'type'=>'thumb')),
                        'name' => bp_core_get_user_displayname($user['user_id']),
                    );
                    $unique[] = $user['user_id'];
                }
            }
        }

        return $mycourse_students;
    }

    function instructor_load_more_students(){

        if ( !isset($_POST['security']) || !wp_verify_nonce($_POST['security'],'instructor_load_more_students') || !current_user_can('edit_posts')){
             echo '<p class="message">'.__('Security error','wplms-dashboard').'</p>';
             die();
        }
		
		echo '<div class="instructor_users_list">';
        echo '<div class="spinner-loading" role="status" style="display: none;">';
		echo '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>';
		echo '<span class="sr-only">Loading...</span>';
		echo '</div>';
		
		$students = $this->get_course_students();
        foreach ($students as $key => $student) {
			$user_meta = get_userdata($student['id']);
			$user_roles = $user_meta->roles; 
			
            echo '<li>'.bp_core_fetch_avatar( array( 'item_id' => $student['id'],'type'=>'thumb')).'';
            echo '<div class="customize_bp_user_info"><p>'.bp_core_get_user_displayname($student['id']).'</p><p>'.$student['email'].'</p></div>';
            echo '<p class="customize_bp_user_role">'.$user_roles[0].'</p><p class="customize_bp_user_request">Active</p></li>';
        }
		echo '</div>';

        die();
    }
} 

?>