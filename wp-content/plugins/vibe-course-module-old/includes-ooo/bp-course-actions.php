<?php
/**
 * Action functions for Course Module
 *
 * @author      VibeThemes
 * @category    Admin
 * @package     Vibe Course Module
 * @version     2.0
 */

 if ( ! defined( 'ABSPATH' ) ) exit;

class BP_Course_Action{

    public static $instance;
    public static function init(){
    if ( is_null( self::$instance ) )
        self::$instance = new BP_Course_Action();

        return self::$instance;
    }

    private function __construct(){

		add_action('bp_activity_register_activity_actions',array($this,'bp_course_register_actions'));
		add_filter( 'woocommerce_get_price_html', array($this,'course_subscription_filter'),100,2 );
		add_action('woocommerce_after_add_to_cart_button',array($this,'bp_course_subscription_product'));
		add_action( 'woocommerce_order_status_completed',array($this, 'bp_course_convert_customer_to_student' ));
		add_action('woocommerce_order_status_completed',array($this,'bp_course_enable_access'));
		add_action('woocommerce_order_status_cancelled',array($this,'bp_course_disable_access'),10,1);
		add_action('woocommerce_order_status_refunded',array($this,'bp_course_disable_access'),10,1);
		add_action('woocommerce_restock_refunded_item',array($this,'bp_course_check_partial_disable_access'),10,4);

		add_action('bp_members_directory_member_types',array($this,'bp_course_instructor_member_types'));
		add_filter('wplms_course_credits',array($this,'wplms_show_new_course_student_status'),20,2);	
        

		add_action('wp_head',array($this,'remove_woocommerce_endactions'));

		// Dynamic Quiz v2
		remove_action('wplms_before_quiz_begining','wplms_dynamic_quiz_select_questions',10,1);
		add_action('wplms_before_quiz_begining',array($this,'set_dynamic_question_set'),10,2);


        //News course news for students
        add_action( 'pre_get_posts',array($this,'check_course_news_for_students'));

		//Save certificate image 
		add_action('wp_ajax_save_certificate_image',array($this,'save_certificate_image'));

        //for news permalink
        add_action('bp_course_plugin_template_content',array($this,'wplms_course_show_news'));
        add_action('wplms_load_templates',array($this,'wplms_course_show_news'));
        //Save News from Front End 
        add_action('wp_ajax_save_news_front_end',array($this,'save_news_front_end'));
        //Edit News from Front End 
        add_action('wp_ajax_edit_news_front_end',array($this,'edit_news_front_end'));
        //Delete News from Front End 
        add_action('wp_ajax_delete_news_front_end',array($this,'delete_news_front_end'));


        // Subscribe to partial free course for free.
        add_action('template_redirect',array($this,'subscribe_course_for_free'),8);
        add_action('wplms_course_subscribed',array($this,'check_user_purchased_full_course'),10,4);

        add_action('wplms_course_unsubscribed',array($this,'remove_partial_user_meta'),10,2);
        add_action('woocommerce_order_status_completed',array($this,'partial_free_course_change_duration'),1);

        //prepare data for scorm package lms api
       

        //reset scorm data
        add_action('wplms_course_retake',array($this,'delete_scorm_data'),10,2);
        add_action('wplms_quiz_retake',array($this,'delete_scorm_data'),10,2);
        add_action('wplms_course_reset',array($this,'delete_scorm_data_and_curriculum'),10,2);
        

        add_action('wp_footer',function(){

            if(is_singular('course') || is_user_logged_in())
            return;

            if(bp_course_is_member(get_the_ID(),get_current_user_id())){
            ?>
            jQuery(document).ready(function(){
                jQuery('.course_lesson td+td').on('click',function(){jQuery('input.course_button[type="submit"]').trigger('click'); });
            });
            <?php
            }

        });

        add_action('wplms_course_submission_applications_tab_content',array($this,'get_course_applications'),10,1);


        add_action('wplms_before_course_main_content',array($this,'before_course_main_content'));
        add_action('wplms_before_course_main_content',array($this,'is_take_course'));
        add_action('wplms_unit_content',array($this,'unit_content'));
        add_action('wplms_unit_controls',array($this,'unit_controls'));
        add_action('wplms_unit_controls',array($this,'check_unit_controls_for_partial_free_course'),1,3);
        add_action('wplms_course_action_points',array($this,'course_action_points'));
	}

    function course_action_points(){

        $user_id = get_current_user_id();
        do_action('course_action_points',$this->status_course_id,$this->status_unit_id,$user_id);
        ?>
            <div class="course_action_points">
                <h1><?php echo get_the_title($this->status_course_id); ?></h1>
                <?php
               
                ?>
                <div class="course_time">
                    <?php
                        the_course_time("course_id=$this->status_course_id&user_id=$user_id");
                    ?>
                </div>
                <?php 

                do_action('wplms_course_start_after_time',$this->status_course_id,$this->status_unit_id);  
            ?>
            </div>
            <?php
                echo the_course_timeline($this->status_course_id,$this->status_unit_id);
                do_action('wplms_course_start_after_timeline',$this->status_course_id,$this->status_unit_id);

                if(isset($this->status_course_curriculum) && is_array($this->status_course_curriculum)){
                    ?>
                    <div class="more_course">
                        <a href="<?php echo get_permalink($this->status_course_id); ?>" class="unit_button full button"><?php _e('BACK TO COURSE','vibe'); ?></a>
                        <form action="<?php echo get_permalink($this->status_course_id); ?>" method="post">
                        <?php
                        $finishbit=bp_course_get_user_course_status($user_id,$this->status_course_id);
                        if(is_numeric($finishbit)){
                            if($finishbit < 4){
                                $comment_status = get_post_field('comment_status',$this->status_course_id);
                                if($comment_status == 'open'){
                                    echo '<input type="submit" name="review_course" class="review_course unit_button full button" value="'. __('REVIEW COURSE ','vibe').'" />';
                                }
                                echo '<input type="submit" name="submit_course" class="review_course unit_button full button" value="'. __('FINISH COURSE ','vibe').'" />';
                            }
                        }
                        ?>  
                        <?php wp_nonce_field($this->status_course_id,'review'); ?>
                        </form>
                    </div>
                   <?php
                }
            ?>  
        <?php
    }

    function unit_controls(){

        if(is_wplms_4_0('course'))
            return;

        $react_quizzes = apply_filters('wplms_use_react_quizzes',1);
        $user_id = get_current_user_id();
        if($this->status_unit_id ==''){
            echo  '<div class="unit_prevnext"><div class="col-md-3"></div><div class="col-md-6">
                          '.'<a href="#" data-unit="'.$this->status_units[0].'" class="unit unit_button start_course">'.__('Start Course','vibe').'</a>'.
                        '</div></div>';
        }else{

            if(is_array($this->status_units)){
                $k = array_search($this->status_unit_id,$this->status_units);
            }else{
                return;
            }
            $quiz_passing_flag = true;
            $quiz_passing_flag = apply_filters('wplms_next_unit_access',true,$this->status_units[($k)],$user_id);
                  
            if(empty($k)){$k = 0;}

            $next = $k+1;
            $prev = $k-1;
            $max = count($this->status_units)-1;

            if(defined('WPLMS_PLUGIN_VERSION') && version_compare(WPLMS_PLUGIN_VERSION,'2.3') >= 0){
                $done_flag = bp_course_check_unit_complete($this->status_unit_id,$user_id,$this->status_course_id);            
            }else{
                $done_flag = get_user_meta($user_id,$this->status_unit_id,true);      
            }
            echo  '<div class="unit_prevnext"><div class="col-md-3">';
            if($prev >=0){
                if(get_post_type($this->status_units[$prev]) == 'quiz'){
                    echo '<a href="#" id="prev_quiz" data-unit="'.$this->status_units[$prev].'" class="unit unit_button"><span>'.__('Previous Quiz','vibe').'</span></a>';
                }else{
                    if(get_post_type($this->status_units[$prev]) == 'unit'){
                        echo '<a href="#" id="prev_unit" data-unit="'.$this->status_units[$prev].'" class="unit unit_button"><span>'.__('Previous Unit','vibe').'</span></a>';
                    }
                    if(get_post_type($this->status_units[$prev]) == 'wplms-assignment'){
                        echo '<a href="#" id="prev_unit" data-unit="'.$this->status_units[$prev].'" class="unit unit_button"><span>'.__('Previous Assignment','vibe').'</span></a>';
                    }

                }
            }
            do_action('wplms_after_previous_button_course_status',$this->status_units[$prev],$this->status_unit_id,$this->status_units,$user_id,$this->status_course_id);
            echo '</div>';
            echo  '<div class="col-md-6">';

            
            if(!isset($done_flag) || !$done_flag){
                if(get_post_type($this->status_units[($k)]) == 'quiz'){
                    if(empty($react_quizzes)){
                        $quiz_status = get_user_meta($user_id,$this->status_units[($k)],true);
                        $quiz_class = apply_filters('wplms_in_course_quiz','');
                        if(is_numeric($quiz_status)){
                            if($quiz_status < time()){ 
                                echo '<a href="'.bp_loggedin_user_domain().BP_COURSE_SLUG.'/'.BP_COURSE_RESULTS_SLUG.'/?action='.$this->status_units[($k)].'" class="quiz_results_popup"><span>'.__('Check Results','vibe').'</span></a>';
                            }else{
                                echo '<a href="'.get_permalink($this->status_units[($k)]).'" class=" unit_button '.$quiz_class.' continue"><span>'.__('Continue Quiz','vibe').'</span></a>';
                            }
                        }else{
                            echo apply_filters('wplms_start_quiz_button','<a href="'.get_permalink($this->status_units[($k)]).'" class="unit_button '.$quiz_class.'" data-quiz="'.$this->status_units[($k)].'"> <span>'.__('Start Quiz','vibe').'</span></a>',$this->status_units[($k)]);
                        }
                    }
                }else{
                    echo apply_filters('wplms_unit_mark_complete','<a href="#" id="mark-complete" data-unit="'.$this->status_units[($k)].'" class="unit_button"><span>'.__('Mark this Unit Complete','vibe').'</span></a>',$this->status_unit_id,$this->status_course_id);
                }
            }else{
                if(get_post_type($this->status_units[($k)]) == 'quiz'){

                    if(empty($react_quizzes)){
                        $quiz_status = get_user_meta($user_id,$this->status_units[($k)],true);
                        $quiz_class = apply_filters('wplms_in_course_quiz','');
                        
                        if(is_numeric($quiz_status)){
                            if($quiz_status < time()){ 
                                echo '<a href="'.bp_loggedin_user_domain().BP_COURSE_SLUG.'/'.BP_COURSE_RESULTS_SLUG.'/?action='.$this->status_units[($k)].'" class="quiz_results_popup"><span>'.__('Check Results','vibe').'</span></a>';
                            }else{
                                echo '<a href="'.get_permalink($this->status_units[($k)]).'" class=" unit_button '.$quiz_class.' continue"><span>'.__('Continue Quiz','vibe').'</span></a>';
                            }
                        }else{
                            echo '<a href="'.bp_loggedin_user_domain().BP_COURSE_SLUG.'/'.BP_COURSE_RESULTS_SLUG.'/?action='.$this->status_units[($k)].'" class="quiz_results_popup"><span>'.__('Check Results','vibe').'</span></a>';
                        }
                    }
                }
                // If unit does not show anything
            }
            echo '</div>';
            echo  '<div class="col-md-3">';

            $nextflag=1;
            if($next <= $max){

                $nextunit_access = apply_filters('bp_course_next_unit_access',true,$this->status_course_id);
                    
                if(isset($nextunit_access) && $nextunit_access){
                   
                    for($i=0;$i<$next;$i++){
                        $status = get_post_meta($this->status_units[$i],$user_id,true);
                        if(!empty($status) && (!isset($done_flag) || !$done_flag)){
                            $nextflag=0;
                            break;
                        }
                    }
                }
                $class = 'unit unit_button';
                

                if($nextflag){
                    $hide_unit=0;
                    if(!$nextunit_access && (!isset($done_flag) || !$done_flag) || !$quiz_passing_flag){
                        $class .=' hide';
                        $hide_unit=1;
                    }

                    if(get_post_type($this->status_units[$next]) == 'quiz'){
                        
                            echo '<a href="#" id="next_quiz" '.(($hide_unit)?'':'data-unit="'.$this->status_units[$next].'"').' class="'.$class.'"><span>'.__('Next Quiz','vibe').'</span></a>';
                    }else{
                        
                            if(get_post_type($this->status_units[$next]) == 'unit'){ //Display Next unit link because current unit is a quiz on Page reload
                                echo '<a href="#" id="next_unit" '.(($hide_unit)?'':'data-unit="'.$this->status_units[$next].'"').' class="'.$class.'"><span>'.__('Next Unit','vibe').'</span></a>';
                            }
                            if(get_post_type($this->status_units[$next]) == 'wplms-assignment'){
                                echo '<a href="#" id="next_unit" '.(($hide_unit)?'':'data-unit="'.$this->status_units[$next].'"').' class="'.$class.'"><span>'.__('Next Assignment','vibe').'</span></a>';

                            }
                      
                            
                    }
                }else{
                        echo '<a href="#" id="next_unit" class="unit unit_button hide"><span>'.__('Next Unit','vibe').'</span></a>';
                }
                do_action('wplms_after_next_button_course_status',$this->status_units[$next],$this->status_unit_id,$this->status_units,$user_id,$this->status_course_id);
            }

            echo '</div></div>';

        } // End the Bug fix on course begining
       ?>
            </div>
            <?php
                wp_nonce_field('security','hash');
                echo '<input type="hidden" id="course_id" name="course" value="'.$this->status_course_id.'" />';
                if(function_exists('vibe_get_option')){
                    $unit_comments = vibe_get_option('unit_comments');
                }
            ?>
            <div id="ajaxloader" class="disabled"></div>
                <div class="side_comments"><a id="all_comments_link" data-href="<?php if(isset($unit_comments) && is_numeric($unit_comments)){echo get_permalink($unit_comments);} ?>"><?php _e('SEE ALL','vibe'); ?></a>
                    <ul class="main_comments">
                        <li class="hide">
                            <div class="note">
                            <?php
                            $author_id = get_current_user_id();
                            echo get_avatar($author_id).' <a href="'.bp_core_get_user_domain($author_id).'" class="unit_comment_author"> '.bp_core_get_user_displayname( $author_id) .'</a>';
                            
                            $link = vibe_get_option('unit_comments');
                            if(isset($link) && is_numeric($link))
                                $link = get_permalink($link);
                            else
                                $link = '#';
                            ?>
                            <div class="unit_comment_content"></div>
                            <ul class="actions">
                                <li><a class="tip edit_unit_comment" title="<?php _e('Edit','vibe'); ?>"><i class="icon-pen-alt2"></i></a></li>
                                <li><a class="tip public_unit_comment" title="<?php _e('Make Public','vibe'); ?>"><i class="icon-fontawesome-webfont-3"></i></a></li>
                                <li><a class="tip private_unit_comment" title="<?php _e('Make Private','vibe'); ?>"><i class="icon-fontawesome-webfont-4"></i></a></li>
                                <li><a class="tip reply_unit_comment" title="<?php _e('Reply','vibe'); ?>"><i class="icon-curved-arrow"></i></a></li>
                                <li><a class="tip instructor_reply_unit_comment" title="<?php _e('Request Instructor reply','vibe'); ?>"><i class="icon-forward-2"></i></a></li>
                                <li><a data-href="<?php echo $link; ?>" class="popup_unit_comment" title="<?php _e('Open in Popup','vibe'); ?>" target="_blank"><i class="icon-windows-2"></i></a></li>
                                <li><a class="tip remove_unit_comment" title="<?php _e('Remove','vibe'); ?>"><i class="icon-cross"></i></a></li>
                            </ul>
                            </div>
                        </li>
                    </ul>

                    <a class="add-comment"><?php _e('Add a Note','vibe');?></a>
                    <div class="comment-form">
                        <?php
                        echo get_avatar($author_id); echo ' <span>'.__('YOU','vibe').'</span>';
                        ?>
                        <article class="live-edit" data-model="article" data-id="1" data-url="/articles">
                            <div class="new_side_comment" data-editable="true" data-name="content" data-text-options="true">
                            <?php _e('Add your Comment','vibe'); ?>
                            </div>
                        </article>
                        <ul class="actions">
                            <li><a class="post_unit_comment tip" title="<?php _e('Post','vibe'); ?>"><i class="icon-fontawesome-webfont-4"></i></a></li>
                            <li><a class="remove_side_comment tip" title="<?php _e('Remove','vibe'); ?>"><i class="icon-cross"></i></a></li>
                        </ul>
                    </div>       
                </div>
            </div>
        <?php        
    }

    function check_unit_controls_for_partial_free_course(){

        if(is_wplms_4_0('course'))
            return;
        
        if( $this->status_unit_id == '' || $this->status_course_id == '' )
            return;

        //Check for free course
        $free = get_post_meta($this->status_course_id,'vibe_course_free',true);
        if( vibe_validate($free) )
            return;
        
        //Check Partial free course setting.
        $partial_free_course = get_post_meta($this->status_course_id,'vibe_partial_free_course',true);
        if( !vibe_validate($partial_free_course) )
            return;

        //Check if already purchased the course.
        $user_id = get_current_user_id();
        $check_partial_free_course_purchased = get_user_meta($user_id,'user_subscribed_to_partial_free_course_'.$this->status_course_id,true);
        if( $check_partial_free_course_purchased == 2 )
            return;

        if( !empty($this->status_course_curriculum) ){
            $unit_accessible = array();
            foreach ($this->status_course_curriculum as $key => $value) {
                if($key != 0){
                    if( !is_numeric($value) )
                        break;

                    $unit_accessible[] = $value;
                }
            }

            if( in_array($this->status_unit_id, $unit_accessible) )
                return;
            else
                remove_action('wplms_unit_controls',array($this,'unit_controls'));
                wp_nonce_field('security','hash');
                echo '<input type="hidden" id="course_id" name="course" value="'.$this->status_course_id.'" />';
        }
    }

    function unit_content(){

        //if(is_wplms_4_0('course'))
           // return;

        $user_id = apply_filters('wplms_current_user_id',get_current_user_id());
        $post_type = get_post_type($this->status_unit_id);
        $react_quizzes = '';


        $react_quizzess = apply_filters('wplms_use_react_quizzes',1);

        if($react_quizzess){
          $react_quizzes = 'react_quiz';
        }
        // Check For partially free course
        $check_partial_free_course = apply_filters('wplms_check_partial_free_course_access',1,$this->status_unit_id);
        if( !$check_partial_free_course )
            return;
        ?>
        <div class="unit_wrap <?php echo $this->status_class; ?>">
            <div id="unit_content" class="unit_content <?php echo $react_quizzes;?>">
            
            <div id="unit" class="<?php echo $post_type; ?>_title <?php echo ($post_type=='wplms-assignment'?'unit_title':''); ?>" data-unit="<?php if(isset($this->status_unit_id)) echo $this->status_unit_id; ?>">
                <div class="unit_title_extras">
                <?php 
                // Check For partially free course
                $check_partial_free_course = apply_filters('wplms_check_partial_free_course_access',1,$this->status_unit_id);

                do_action('wplms_unit_header',$this->status_unit_id,$this->status_course_id);

                if( $check_partial_free_course ) { 

                    $duration = get_post_meta($this->status_unit_id,'vibe_duration',true);
                    $unit_duration_parameter = apply_filters('vibe_unit_duration_parameter',60,$this->status_unit_id);

                    if($duration){
                      do_action('wplms_course_unit_meta',$this->status_unit_id);
                      echo '<span class="unit_duration" data-duration="'. $unit_duration_parameter*$duration.'"><i class="icon-clock"></i> '.(($duration<9999)?tofriendlytime(($unit_duration_parameter*$duration)):__('Unlimited','vibe')).'</span>';
                    }

                    ?>
                    <br /></div><h1><?php 
                    if(isset($this->status_course_id)){
                        echo get_the_title($this->status_unit_id);
                    }else{
                        the_title();
                    }
                     ?></h1>
                    <?php
                    if(isset($this->status_course_id)){
                        the_sub_title($this->status_unit_id);
                    }else{
                        the_sub_title();    
                    }   
                    ?>  
                    </div>
                    <?php

                    if(isset($this->status_course_taken) && $this->status_course_taken && $this->status_unit_id !=''){
                        if(isset($this->status_course_curriculum) && is_array($this->status_course_curriculum)){
                            the_unit($this->status_unit_id);
                        }else{
                            echo '<h3>';
                            _e('Course Curriculum Not Set.','vibe');
                            echo '</h3>';
                        }
                    }else{
                        the_content(); 
                        if(isset($this->status_course_id) && is_numeric($this->status_course_id)){ 
                            $course_instructions = get_post_meta($this->status_course_id,'vibe_course_instructions',true); 
                            echo (empty($course_instructions)?'':do_shortcode($course_instructions)); 
                        }
                    }
                }

            $units = array();
            if(isset($this->status_course_curriculum) && is_array($this->status_course_curriculum) && count($this->status_course_curriculum)){
              foreach($this->status_course_curriculum as $key => $curriculum){
                if(is_numeric($curriculum)){
                    $units[] = $curriculum;
                }
              }
            }else{
                echo '<div class="error"><p>'.__('Course Curriculum Not Set','vibe').'</p></div>';
            } 
            $this->status_units = $units;
    }

    function is_take_course(){
        $course_id = 0;
        $upload_type = 0;
        if(!is_user_logged_in())
            return;
        if(isset($_POST) && isset($_POST['course_id'])){
            $course_id = $_POST['course_id'];
        }
        if(empty($course_id ) && !empty($_COOKIE['course'])){
            $course_id = $_COOKIE['course'];
        }
        if(!empty($course_id)){
            $upload_package = get_post_meta($course_id,'vibe_course_package',true);
            if(!empty($upload_package) && is_array($upload_package) && isset($upload_package['path'])){
                $upload_type = 1;
            }
        }
        $user = wp_get_current_user();
        $user_id = $user->ID;
        $token = '';
        $tokens  = get_user_meta($user_id,'access_tokens',true);
        
        if(!empty($tokens) && !empty($tokens)){
            $token = $tokens[0];
        }
        if(empty($token)){
            $generated_token = $this->generate_token($user_id,'wplms_generated_for_scorm'.$user_id);
            $token = $generated_token['access_token'];
        }
        $json_data = apply_filters('wplms_add_data_for_scorm',
            array(
                'type'=>'course',
                'user_id'=>$user_id,
                'course_id'=>$course_id,
                'user_email'=>$user->user_email,
                'token'=>$token,
                'user_name' => $user->user_email,//$user->display_name,
                'security_nonce'=>wp_create_nonce('wplms_scorm_security'),
                'ajaxurl' => admin_url('admin-ajax.php'),
                'api_url'=>home_url().'/wp-json/'.BP_COURSE_API_NAMESPACE.'/',
                'translations' => array(
                    'content_finish' => _x('Content Finishing...','','vibe'),
                ),
            )
        );
        ?>
        <script>
            window.is_take_course = 1;
            window.is_upload_type_course = <?php echo $upload_type;?>;
            
        </script>
        <?php
        if($upload_type){
        ?>
        <script>var scorm_wplms_data = <?php echo json_encode($json_data);?>;</script>
        <?php
        }
    }

    function before_course_main_content(){

        $user_id = get_current_user_id();  
        if(isset($_POST['course_id'])){
            $course_id=$_POST['course_id'];
            $coursetaken=get_user_meta($user_id,$course_id,true);
        }else if(isset($_POST['no_ajax_course_id'])){
            $course_id=$_POST['no_ajax_course_id'];
            $coursetaken=get_user_meta($user_id,$course_id,true);
        }else if(isset($_COOKIE['course'])){
              $course_id=$_COOKIE['course'];
              $coursetaken=1;
        }

        if(!isset($course_id) || !is_numeric($course_id))
            wp_die(__('INCORRECT COURSE VALUE. CONTACT ADMIN','vibe'));

        $course_curriculum = bp_course_get_curriculum($course_id);

        $unit_id = wplms_get_course_unfinished_unit($course_id);

        $unit_comments = vibe_get_option('unit_comments');
        $class= '';
        if(isset($unit_comments) && is_numeric($unit_comments)){
            $class .= 'enable_comments';
            add_action('wp_footer',function(){echo "<script>jQuery(document).ready(function($){ $('.unit_content').trigger('load_comments'); });</script>";});
        }

        $class= apply_filters('wplms_unit_wrap',$class,$unit_id,$user_id);

        do_action('wplms_before_start_course_content',$course_id,$unit_id);

        $this->status_course_curriculum = $course_curriculum;
        $this->status_course_id = $course_id;
        $this->status_course_taken = $coursetaken;
        $this->status_unit_id = $unit_id;
        $this->status_class = $class;
    }

    function get_course_applications($course_id){
        global $wpdb;

        $users = $wpdb->get_results(apply_filters('wplms_usermeta_direct_query',$wpdb->prepare("SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = %s AND meta_value = %d",'apply_course'.$course_id,$course_id)));

        if(count($users)){
            echo '<ul>';
            foreach($users as $user){
            ?>
                <li class="user clear" data-id="<?php echo $user->user_id; ?>" data-course="<?php echo $course_id; ?>" data-security="<?php echo wp_create_nonce('security'.$course_id.$user->user_id); ?>">
                    <?php echo get_avatar($user->user_id).bp_core_get_userlink( $user->user_id );?>
                    <?php do_action('wplms_course_application_submission_users',$user->user_id,$course_id); ?>
                    <span class="reject"><?php echo _x('Reject','reject user application for course','wplms'); ?></span>
                    <span class="approve"><?php echo _x('Approve','approve user application for course','wplms'); ?></span>
                </li>
            <?php
            }
            echo '</ul>';
        }else{
            ?>
            <div class="message">
                <p><?php echo _x('No applications found !','No applications found in course, error on course submissions','wplms'); ?></p>
            </div>
            <?php
        }
    }

    function delete_scorm_data_and_curriculum($course_id,$user_id){
        if(!empty($course_id) && !empty($user_id)){
            global $wpdb;
            $meta_key = 'wplms_scorm_'.$module_id.'%';

            $wpdb->query("DELETE FROM {$wpdb->usermeta} WHERE meta_key LIKE '{$meta_key}' AND user_id = {$user_id}");
            $curriculum = bp_course_get_curriculum($course_id);
            if(empty($curriculum))
                return false;

            foreach($curriculum as $key => $item){
                if(is_numeric($item)){
                    global $wpdb;
                    $meta_key = 'wplms_scorm_'.$item.'%';

                    $wpdb->query("DELETE FROM {$wpdb->usermeta} WHERE meta_key LIKE '{$meta_key}' AND user_id = {$user_id}");
                }
            }
        }
    }

    function delete_scorm_data($module_id,$user_id){

        if(!empty($module_id) && !empty($user_id)){
            global $wpdb;
            $meta_key = 'wplms_scorm_'.$module_id.'%';

            $wpdb->query("DELETE FROM {$wpdb->usermeta} WHERE meta_key LIKE '{$meta_key}' AND user_id = {$user_id}");
        }
    }

    function generate_token($user_id,$client_id){

        $access_token = wp_generate_password(40);
        do_action( 'wplms_auth_set_access_token', array(
            'access_token' => $access_token,
            'client_id'    => $client_id,
            'user_id'      => $user_id
        ) );

        $expires = time()+86400*7;
        $expires = date( 'Y-m-d H:i:s', $expires );

        $tokens = get_user_meta($user_id,'access_tokens',true);
        if(empty($tokens)){$tokens = array();}else if(in_array($access_token,$tokens)){$k = array_search($access_token, $tokens);unset($tokens[$k]);delete_user_meta($user_id,$access_token);
        }
        
        $tokens[] = $access_token;
        update_user_meta($user_id,'access_tokens',$tokens);

        $token = array(
            'access_token'=> $access_token,
            'client_id' => $client_id,
            'user_id'   =>  $user_id,
            'expires'   => $expires,
            'scope'     => $scope,
            );
        
        update_user_meta($user_id,$access_token,$token);

        return $token;
    }

    function partial_free_course_change_duration($order_id){
        $order = new WC_Order( $order_id );
        $items = $order->get_items();
        $user_id=$order->get_user_id();
        $order_total = $order->get_total();

        foreach($items as $item_id=>$item){

        
            $courses=get_post_meta($item['product_id'],'vibe_courses',true);

            $product_id = apply_filters('bp_course_product_id',$item['product_id'],$item);
            

            if(isset($courses) && is_array($courses)){
            
                $process_item = apply_filters('bp_course_order_complete_item_subscribe_user',true,$item_id,$product_id,$item,$order_id);

                foreach($courses as $course){
                    if($process_item){ // gift course 
                        $partial_free_course = get_post_meta($course,'vibe_partial_free_course',true);
                        $check_partial_meta = get_user_meta($user_id,'user_subscribed_to_partial_free_course_'.$course,true);
                        if( vibe_validate($partial_free_course) && $check_partial_meta){
                            delete_user_meta($user_id,$course);
                        }
                    }
                }
            }//End If courses
        }// End Item for loop
    }

    function remove_partial_user_meta($course_id,$user_id){
        if(!empty($course_id) && !empty($user_id)){
            delete_user_meta($user_id,'user_subscribed_to_partial_free_course_'.$course_id);
        }
    }
    
    function check_user_purchased_full_course($course_id,$user_id,$group_id,$args){

        //Check for free course
        $free = get_post_meta($course_id,'vibe_course_free',true);
        if( vibe_validate($free) )
            return;

        //Check Partial free course setting.
        $partial_free_course = get_post_meta($course_id,'vibe_partial_free_course',true);
        if( !vibe_validate($partial_free_course) )
            return;

        //Check if already purchased the course.
        $check_partial_free_course_purchased = get_user_meta($user_id,'user_subscribed_to_partial_free_course_'.$course_id,true);
        if( empty($check_partial_free_course_purchased) ){
            update_user_meta($user_id,'user_subscribed_to_partial_free_course_'.$course_id,1);
        }else{
            update_user_meta($user_id,'user_subscribed_to_partial_free_course_'.$course_id,2);
        }

    }

    function subscribe_course_for_free(){
        global $post;
        if(isset($_GET['subscribe'])){
            //Check for free course
            $free = get_post_meta($post->ID,'vibe_course_free',true);
            if( vibe_validate($free) )
                return;

            // Partial Free course check
            $partial_free_course = get_post_meta($post->ID,'vibe_partial_free_course',true);
            if(vibe_validate($partial_free_course)){
                $user_id = get_current_user_id(); 
                //Check if already subscribed in the course.
                $check_partial_free_course_purchased = get_user_meta($user_id,'user_subscribed_to_partial_free_course_'.$post->ID,true);
                if( $check_partial_free_course_purchased )
                    return;

                $date = get_post_meta($post->ID,'vibe_start_date',true);
                if( empty($date) || (!empty($date) && strtotime($date) < current_time('timestamp')) ){
                    bp_course_add_user_to_course($user_id,$post->ID);
                    add_action('wplms_course_before_front_main_description',array($this,'free_subscribed'));
                }else{
                    add_action('wplms_course_before_front_main_description',array($this,'free_not_subscribed'));    
                }
            }
        }
    }

    function free_subscribed(){
        echo '<div class="message success"><p>'.__('Congratulations ! You\'ve been subscribed to the course','wplms').'</p></div>';
    }

    function free_not_subscribed(){
        echo '<div class="message"><p>'.__('Course not available for subscription.','wplms').'</p></div>';
    }

    function save_news_front_end(){
        
        $course_id = $_POST['id'];
        if ( !isset($_POST['security']) || !wp_verify_nonce($_POST['security'],'front_end_news_vibe_'.$course_id) || !is_user_logged_in()){
            _e('Security check Failed. Contact Administrator.','wplms');
            die();
        }

        $title = $_POST['news_title'];
        $sub_title = $_POST['news_sub_title'];
        $news_format = $_POST['news_format'];
        $content = $_POST['news_content'];
        $news_id = $_POST['news'];

        if(!empty($news_id) && is_numeric($news_id)){
            $course = get_post_meta($news_id,'vibe_news_course',true);
            if($course != $course_id){
                _e('Security check Failed. Contact Administrator.','wplms');
                die();
            }
            $args = array(
                        'ID' => $news_id,
                        'post_title' => $title,
                        'post_content' => $content,
                    );
            wp_update_post($args);
            switch ($news_format) {
                case 'post-format-aside':
                    $format = 'aside';
                    break;

                case 'post-format-image':
                    $format = 'image';
                    break;

                case 'post-format-quote':
                    $format = 'quote';
                    break;

                case 'post-format-status':
                    $format = 'status';
                    break;

                case 'post-format-video':
                    $format = 'video';
                    break;

                case 'post-format-audio':
                    $format = 'audio';
                    break;

                case 'post-format-chat':
                    $format = 'chat';
                    break;

                case 'post-format-gallery':
                    $format = 'gallery';
                    break;

                default:
                    $format = 0;
                    break;
            }
            if($format){
                set_post_format($news_id,$format);
            }
            update_post_meta($news_id,'vibe_subtitle',$sub_title);
            
            die();
        }

        $args = array(
                    'post_title' => $title,
                    'post_content' => $content,
                    'post_type' => 'news',
                    'post_status' => 'publish'
                );
        $news_id = wp_insert_post($args);
        update_post_meta($news_id,'vibe_news_course',$course_id);
        update_post_meta($news_id,'vibe_subtitle',$sub_title);

        switch ($news_format) {
            case 'post-format-aside':
                $format = 'aside';
                break;

            case 'post-format-image':
                $format = 'image';
                break;

            case 'post-format-quote':
                $format = 'quote';
                break;

            case 'post-format-status':
                $format = 'status';
                break;

            case 'post-format-video':
                $format = 'video';
                break;

            case 'post-format-audio':
                $format = 'audio';
                break;

            case 'post-format-chat':
                $format = 'chat';
                break;

            case 'post-format-gallery':
                $format = 'gallery';
                break;

            default:
                $format = 0;
                break;
        }
        if($format){
            set_post_format($news_id,$format);
        }
        if(!empty($news_id) && get_post_type($news_id) == 'news'){
            $news_post = get_post($news_id);
            do_action('publish_news',$news_id, $news_post);
        }
        
        die();
    }

    function edit_news_front_end(){

        $course_id = $_POST['id'];
        if ( !isset($_POST['security']) || !wp_verify_nonce($_POST['security'],'front_end_news_vibe_'.$course_id) || !is_user_logged_in() || !isset($_POST['news'])){
            _e('Security check Failed. Contact Administrator.','wplms');
            die();
        }

        $news_id = $_POST['news'];
        $news = get_post($news_id);
        $subtitle = get_post_meta($news_id,'vibe_subtitle',true);
        $term = wp_get_post_terms($news_id, 'post_format');
        $format = $term[0]->slug;
        if(empty($format)){
            $format = 'post-format-0';
        }
        $json = array(
                    'title' => $news->post_title,
                    'subtitle' => $subtitle,
                    'format' => $format,
                    'content' => $news->post_content,
                    'text' => __('Update News','wplms')
                );
        print_r(json_encode($json));

        die();
    }

    function delete_news_front_end(){
        $course_id = $_POST['id'];
        if ( !isset($_POST['security']) || !wp_verify_nonce($_POST['security'],'front_end_news_vibe_'.$course_id) || !is_user_logged_in() || !isset($_POST['news'])){
            _e('Security check Failed. Contact Administrator.','wplms');
            die();
        }

        $news_id = $_POST['news'];
        if(!empty($news_id) && is_numeric($news_id)){
            $course = get_post_meta($news_id,'vibe_news_course',true);
            if($course != $course_id){
                _e('Security check Failed. Contact Administrator.','wplms');
                die();
            }
            wp_delete_post($news_id, false);
        }
        die();
    }

    function wplms_course_show_news(){

        if(function_exists('vibe_get_option')){
            $show_news = vibe_get_option('show_news');
            if(!empty($show_news)){
                $action = '';
                if(function_exists('bp_current_action')){
                    $action = bp_current_action();
                }
                if(empty($action)){
                    $action = $_GET['action'];
                }
                if($action != 'news')
                    return;
                require_once('templates/course/single/news.php');
            }
        }
    }

	//Save certificate image
	function save_certificate_image(){

        $user_id = $_POST['user_id'];
        $course_id = $_POST['course_id'];

        if(!is_numeric($user_id) && !is_numeric($course_id) && strpos($_POST['image'], 'data:image/jpeg;base64') === false){
            die();
        }

		if(is_user_logged_in() && wp_verify_nonce($_POST['security'],$user_id)){

			$file_name = $course_id.'-'.$user_id.'.jpeg';
			$upload_dir = wp_upload_dir();
			$file_path = $upload_dir['path'].'/'.$file_name;
			$file = $upload_dir['url'].'/'.$file_name;
			if(file_exists($file_path)){
            	global $wpdb;
            	$attachment_id = $wpdb->get_var($wpdb->prepare("SELECT id from {$wpdb->posts} WHERE guid = %s AND post_type = %s",$file,'attachment'));
            	if(is_numeric($attachment_id)){
            		wp_delete_attachment($attachment_id,true);
            	}
            }

			$upload = wp_upload_bits( $file_name, 0, '');
            if ( $upload['error'] ) {
                return new WP_Error( 'upload_dir_error', $upload['error'] );
            }

            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        	WP_Filesystem();
            global $wp_filesystem;
            $img = $_POST['image'];

             if(function_exists('getimagesize')){
                // validate the image
                $tmp = getimagesize($img);
                if(!$tmp){ 
                    die();
                }    
            }
            
			$img = str_replace('data:image/jpeg;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$fileData = base64_decode($img);
            $wp_filesystem->put_contents( $upload['file'],$fileData);

            $user = get_userdata($user_id);
            $guid = str_replace($upload_dir['path'], $upload_dir['url'], $upload['file']);
            $message = sprintf(__('Certificate for User %s','wplms'),$user->data->display_name);
			$post_id = wp_insert_attachment( array('post_title'=>$message,'post_name'=>'certificate_'.$course_id.'_'.$user_id,'post_content'=>$message,'guid'=>$guid,'post_status'=>'inherit','post_mime_type'=>'image/jpeg','post_author'=>$user_id), $upload['file'],$course_id);

			if($post_id) {
                $url = wp_get_attachment_url($post_id);
                echo $url;
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				wp_update_attachment_metadata( $post_id, wp_generate_attachment_metadata( $post_id, $upload['file'] ) );
			}
        }
		die();
	}

	function remove_woocommerce_endactions(){
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	}

    
	function bp_course_register_actions(){
		global $bp; 
		$bp_course_action_desc=bp_course_activity_actions();
		foreach($bp_course_action_desc as $key => $value){
			bp_activity_set_action($bp->activity->id,$key,$value);	
		}
	}

	function course_subscription_filter($price,$product){

        if(method_exists($product,'get_id')){
            $product_id = $product->get_id();
        }else{
            $product_id = $product->id;
        }
        $subscription=get_post_meta($product_id,'vibe_subscription',true);

            if(vibe_validate($subscription)){
                $duration = intval(get_post_meta($product_id,'vibe_duration',true));

                $product_duration_parameter = apply_filters('vibe_product_duration_parameter',86400,$product_id);
                $t=$duration * $product_duration_parameter;
                if($duration == 1){
                    $price = $price .'<span class="subs"> '.__('per','wplms').' '.tofriendlytime($t,$product_duration_parameter).'</span>';
                }else{
                    $price = $price .'<span class="subs"> '.__('per','wplms').' '.tofriendlytime($t,$product_duration_parameter).'</span>';
                }
            }
            return $price;
    }

    function bp_course_subscription_product(){
        global $product;
        if(method_exists($product,'get_id')){
            $product_id = $product->get_id();
        }else{
            $product_id = $product->id;
        }
        $check_susbscription=get_post_meta($product_id,'vibe_subscription',true);
        if(vibe_validate($check_susbscription)){
            $duration=intval(get_post_meta($product_id,'vibe_duration',true));  
            
            $product_duration_parameter = apply_filters('vibe_product_duration_parameter',86400,$product_id);
            $t=tofriendlytime($duration*$product_duration_parameter);
            echo '<div id="duration"><strong>'.__('SUBSCRIPTION FOR','wplms').' '.$t.'</strong></div>';
        }
    }

	function bp_course_convert_customer_to_student( $order_id ) {
	    $order = new WC_Order( $order_id );
	    if ( $order->get_user_id() > 0 ) {
	        $user = new WP_User( $order->get_user_id() );
	        $user->remove_role( 'customer' ); 
	        $user->add_role( 'student' );
	    }
	}

	function bp_course_enable_access($order_id){

		$order = new WC_Order( $order_id );
		$items = $order->get_items();
		$user_id=$order->get_user_id();
		$order_total = $order->get_total();
		$commission_array=array();
        $currency = '';
        if(method_exists($order,'get_currency'))
            $currency = $order->get_currency();
		foreach($items as $item_id=>$item){

		  $instructors=array();
		
		  $courses=get_post_meta($item['product_id'],'vibe_courses',true);

		  $product_id = apply_filters('bp_course_product_id',$item['product_id'],$item);
		  $subscribed=get_post_meta($product_id,'vibe_subscription',true);

		  if(isset($courses) && is_array($courses)){
            
            $process_item = apply_filters('bp_course_order_complete_item_subscribe_user',true,$item_id,$product_id,$item,$order_id);

			if(vibe_validate($subscribed) ){

				$duration = get_post_meta($product_id,'vibe_duration',true);
				$product_duration_parameter = apply_filters('vibe_product_duration_parameter',86400,$product_id);
                $total_duration = 0;
                if(is_numeric($duration) && is_numeric($product_duration_parameter)){
                    $total_duration = $duration*$product_duration_parameter;
                }
				foreach($courses as $course){
					if($process_item){ // gift course 
                        bp_course_add_user_to_course($user_id,$course,$total_duration,1);    
                    }
			        $instructors[$course]=apply_filters('wplms_course_instructors',get_post_field('post_author',$course),$course);
			        do_action('wplms_course_product_puchased',$course,$user_id,$total_duration,1,$product_id,$item_id);
				}
			}else{	
				if(isset($courses) && is_array($courses)){
				foreach($courses as $course){
						if($process_item){ //Gift course
                            bp_course_add_user_to_course($user_id,$course,'',1);
                        }
		        		$instructors[$course]=apply_filters('wplms_course_instructors',get_post_field('post_author',$course,'raw'),$course);
			        	do_action('wplms_course_product_puchased',$course,$user_id,0,0,$product_id,$item_id);
					}
				}
			}//End Else

				$line_total=$item['line_total'];

			//Commission Calculation
			$commission_array[$item_id]=array(
				'instructor'=>$instructors,
				'course'=>$courses,
				'total'=>$line_total,
                'currency'=>$currency
			);

		  }//End If courses
		}// End Item for loop
		
		if(function_exists('vibe_get_option'))
	      $instructor_commission = vibe_get_option('instructor_commission');
	    
	    if($instructor_commission == 0)
	      		return;
	      	
	    if(!isset($instructor_commission) || !$instructor_commission)
	      $instructor_commission = 70;

	    $commissions = get_option('instructor_commissions');
		foreach($commission_array as $item_id=>$commission_item){

			foreach($commission_item['course'] as $course_id){
				
				if(count($commission_item['instructor'][$course_id]) > 1){     // Multiple instructors
					
					$calculated_commission_base=round(($commission_item['total']*($instructor_commission/100)/count($commission_item['instructor'][$course_id])),0); // Default Slit equal propertion

					foreach($commission_item['instructor'][$course_id] as $instructor){
						if(empty($commissions[$course_id][$instructor]) && !is_numeric($commissions[$course_id][$instructor])){
							$calculated_commission_base = round(($commission_item['total']*$instructor_commission/100),2);
						}else{
							$calculated_commission_base = round(($commission_item['total']*$commissions[$course_id][$instructor]/100),2);
						}
						$calculated_commission_base = apply_filters('wplms_calculated_commission_base',$calculated_commission_base,$instructor);

                        bp_course_record_instructor_commission($instructor,$calculated_commission_base,$course_id,array('origin'=>'woocommerce','order_id'=>$order_id,'item_id'=>$item_id,'currency'=>$commission_item['currency']));
                        
					}
				}else{
					if(is_array($commission_item['instructor'][$course_id]))                                    // Single Instructor
						$instructor=$commission_item['instructor'][$course_id][0];
					else
						$instructor=$commission_item['instructor'][$course_id]; 
					
					if(isset($commissions[$course_id][$instructor]) && is_numeric($commissions[$course_id][$instructor]))
						$calculated_commission_base = round(($commission_item['total']*$commissions[$course_id][$instructor]/100),2);
					else
						$calculated_commission_base = round(($commission_item['total']*$instructor_commission/100),2);

					$calculated_commission_base = apply_filters('wplms_calculated_commission_base',$calculated_commission_base,$instructor);

                    bp_course_record_instructor_commission($instructor,$calculated_commission_base,$course_id,array('origin'=>'woocommerce','order_id'=>$order_id,'item_id'=>$item_id,'currency'=>$commission_item['currency']));
				}   
			}

		} // End Commissions_array  
	}

	function bp_course_disable_access($order_id){
		$order = new WC_Order( $order_id );

		$items = $order->get_items();
		$user_id=$order->user_id;
		foreach($items as $item_id => $item){
			$product_id = $item['product_id'];
			$subscribed=get_post_meta($product_id,'vibe_subscription',true);
			$courses=vibe_sanitize(get_post_meta($product_id,'vibe_courses',false));
			if(isset($courses) && is_array($courses)){

				$process_item = apply_filters('bp_course_order_complete_item_subscribe_user',true,$item_id,$product_id,$item,$order_id);

                if($process_item){
                    if($user_id == get_current_user_id()){
    					return; // Do not run when user herself cancels an order because we are not sure if it is the same order.
    				}
                }
                
				foreach($courses as $course){

                    if($process_item){ // gift course 
                        bp_course_remove_user_from_course($user_id,$course);
                    }

					if(function_exists('vibe_get_option'))
				      $instructor_commission = vibe_get_option('instructor_commission');
				    
				    if(empty($instructor_commission))
				      		return;
					$instructors = apply_filters('wplms_course_instructors',get_post_field('post_author',$course,'raw'),$course);
					if(is_array($instructors)){
						foreach($instructors as $instructor){
                            if(function_exists('wc_update_order_item_meta')){
                                wc_update_order_item_meta( $item_id, '_commission'.$instructor,0);//Nulls the commission
                            }else{
                                woocommerce_update_order_item_meta( $item_id, '_commission'.$instructor,0);//Nulls the commission
                            }
						}
					}
				}
			}
		} 
	}
	//Partial refund use case
	function bp_course_check_partial_disable_access($product_id, $old_stock, $new_quantity, $order ){
		$user_id=$order->user_id;
		$courses=vibe_sanitize(get_post_meta($product_id,'vibe_courses',false));
		if(isset($courses) && is_array($courses)){
			foreach($courses as $course){
				bp_course_remove_user_from_course($user_id,$course);
				if(function_exists('vibe_get_option'))
			      	$instructor_commission = vibe_get_option('instructor_commission');
			    
			    if(empty($instructor_commission))
		      		return;

		      	$order_items = $order->get_items();
		      	foreach ($order_items as $order_item_id => $order_item) { 
		      		if($order_item['product_id'] == $product_id){
		      			$item_id = $order_item_id;
		      			break;
		      		}
				}
				
				$instructors = apply_filters('wplms_course_instructors',get_post_field('post_author',$course),$course);
				if(!is_array($instructors)){
					$instructors = array($instructors);
				}
				if(is_array($instructors)){
					foreach($instructors as $instructor){
                        if(function_exists('wc_update_order_item_meta')){
                            wc_update_order_item_meta( $item_id, '_commission'.$instructor,0);//Nulls the commission
                        }else{
                            woocommerce_update_order_item_meta( $item_id, '_commission'.$instructor,0);//Nulls the commission
                        }
					}
				}
			}
		}
	}

	function bp_course_instructor_member_types(){
		?>
			<li id="members-instructors"><a href="#"><?php printf( __( 'All Instructors <span>%s</span>', 'wplms' ), bp_get_total_instructor_count() ); ?></a></li>
		<?php
	}

	function wplms_show_new_course_student_status($credits,$course_id){

	  if(is_user_logged_in() && !is_singular('course')){
	    $user_id=get_current_user_id();
	    $check=get_user_meta($user_id,$course_id,true);
	    if(isset($check) && $check){
	      if($check < time()){
	        return '<a href="'.get_permalink($course_id).'"><strong>'.sprintf(__('EXPIRED %s COURSE','wplms'),'<span class="subs">').'</span></strong></a>';
	      }

	      $check_course= bp_course_get_user_course_status($user_id,$course_id);
	      $new_check_course = get_user_meta($user_id,'course_status'.$course_id,true);
	      if(isset($new_check_course) && is_numeric($new_check_course) && $new_check_course){
	  	      switch($check_course){
		        case 1:
		        $credits ='<a href="'.get_permalink($course_id).'"><strong>'.sprintf(__('START %s COURSE','wplms'),'<span class="subs">').'</span></strong></a>';
		        break;
		        case 2:
		        $credits ='<a href="'.get_permalink($course_id).'"><strong>'.sprintf(__('CONTINUE %s COURSE','wplms'),'<span class="subs">').'</span></strong></a>';
		        break;
		        case 3:
		        $credits ='<a href="'.get_permalink($course_id).'"><strong>'.sprintf(__('UNDER %s EVALUATION','wplms'),'<span class="subs">').'</span></strong></a>';
		        break;
		        case 4:
		        $credits ='<a href="'.get_permalink($course_id).'"><strong>'.sprintf(__('FINISHED %s COURSE','wplms'),'<span class="subs">').'</span></strong></a>';
		        break;
		        default:
		        $credits =apply_filters('wplms_course_status_display','<a href="'.get_permalink($course_id).'"><strong>'.sprintf(__('COURSE %s ENABLED','wplms'),'<span class="subs">').'</span></strong></a>',$course_id);
		        break;
		      }
	      }else{
	      		switch($check_course){
		        case 0:
		        $credits ='<a href="'.get_permalink($course_id).'"><strong>'.__('START','wplms').'<span class="subs">'.__('COURSE','wplms').'</span></strong></a>';
		        break;
		        case 1:
		        $credits ='<a href="'.get_permalink($course_id).'"><strong>'.__('CONTINUE','wplms').'<span class="subs">'.__('COURSE','wplms').'</span></strong></a>';
		        break;
		        case 2:
		        $credits ='<a href="'.get_permalink($course_id).'"><strong>'.__('UNDER','wplms').'<span class="subs">'.__('EVALUATION','wplms').'</span></strong></a>';
		        break;
		        default:
		        $credits ='<a href="'.get_permalink($course_id).'"><strong>'.__('FINISHED','wplms').'<span class="subs">'.__('COURSE','wplms').'</span></strong></a>';
		        break;
		      }	
	      }
	    }
	  }

	  return $credits;
	}

	function get_quiz_item($post,$user_id){
		$value = get_post_meta($post->ID,$user_id,true);
		$questions = bp_course_get_quiz_questions($post->ID,$user_id);
		if(is_Array($questions['marks']) && isset($questions['marks']))
			$max = array_sum($questions['marks']);
		else
			$max = 0; 
		?>
		<li><i class="icon-task"></i>
			<a href="<?php echo apply_filters('wplms_user_quiz_results_link_action','?action='.$post->ID); ?>"><?php echo $post->post_title; ?></a>
			<span><?php	
			$status = bp_course_get_user_quiz_status($user_id,$post->ID);
			if($status > 0){
				echo '<i class="icon-check"></i> '.__('Results Available','wplms');
			}else{
				echo '<i class="icon-alarm"></i> '.__('Results Awaited','wplms');
			}
			?></span>
			<span><?php
			$newtime=get_user_meta($user_id,$post->ID,true);
			if(!empty($newtime) && is_numeric($newtime)){
				$diff = time() - $newtime;
				if($diff > 0){
					echo '<i class="icon-clock"></i> '.__('Submitted ','wplms').tofriendlytime($diff) .__(' ago','wplms');
				}else{
					echo '<i class="icon-clock"></i> '.__(' Pending Submission','wplms');
				}
			}
			?></span>
			<?php
			if($status > 0)
				echo '<span><strong>'.$value.' / '.$max.'</strong></span>';
			?>
		</li>
		<?php
	}

	function set_dynamic_question_set($quiz_id=NULL,$user_id=NULL){

	  	if(!isset($quiz_id)){
	    	global $post;  
	    	$quiz_id = $post->ID;
	  	}
        
	  	if(empty($quiz_id))
	  		return;


        if(empty($user_id) && !is_user_logged_in())
            return;

        if(empty($user_id)){
            $user_id = get_current_user_id();
        }

	    	
        
	    
	    $quiz_questions = array('ques'=>array(),'marks'=>array()); 
        $quiz_dynamic = get_post_meta($quiz_id,'vibe_quiz_dynamic',true);
	    if($quiz_dynamic=='S' || $quiz_dynamic=='dynamic'){ 
            $quiz_questions = bp_course_get_quiz_questions($quiz_id,$user_id); 
            $quiztaken=get_user_meta($user_id,$quiz_id,true); 
            if(isset($quiz_questions) && $quiz_questions && is_array($quiz_questions) && count($quiz_questions['ques']) && !empty($quiztaken)){
                return;
            }
            if(empty($quiz_questions)){
                $quiz_questions = array('ques'=>array(),'marks'=>array()); 
            }
	    	// DYNAMIC QUIZ QUIZ
	        $alltags = get_post_meta($quiz_id,'vibe_quiz_tags',true);

            if(!isset($alltags['marks'])) {
                $marks = get_post_meta($quiz_id,'vibe_quiz_marks_per_question',true);    
            }

	        if(is_array($alltags) && !empty($alltags) && isset($alltags['tags']) && isset($alltags['numbers'])){
	        	
	        	//DYNAMIC QUIZ V 2
	        	foreach($alltags['tags'] as $key=>$tags){
	        		
	        		if(!is_array($tags)){
	        			$tags = unserialize($tags);
	        		}
	        		$number = $alltags['numbers'][$key];
                    if(isset($alltags['marks'][$key]))
                        $marks = $alltags['marks'][$key];

	        		if(empty($number)){
	        			$number = get_post_meta($quiz_id,'vibe_quiz_number_questions',true);
	        			if(empty($number)){
	        				$number = 0;
	        			}
	        		}

	        		$args = apply_filters('bp_course_dynamic_quiz_tag_questions',array(
		                'post_type' => 'question',
		                'orderby' => 'rand', 
		                'posts_per_page' => $number,
		                'tax_query' => array(
		                  	array(
		                    	'taxonomy' => 'question-tag',
		                    	'field' => 'id',
		                    	'terms' => $tags,
		                    	'operator' => 'IN'
		                  	),
		                )
			        ),$alltags);

	        		if(!empty($quiz_questions['ques'])){
	        			$args['post__not_in'] = $quiz_questions['ques'];
	        		}

			        if($number){
			        	$the_query = new WP_Query( $args );
			        	if($the_query->have_posts()){
			        		while ( $the_query->have_posts() ) {
					            $the_query->the_post();

					            $quiz_questions['ques'][]=get_the_ID();
					            $quiz_questions['marks'][]=$marks;
					        }
			        	}
				        wp_reset_postdata();
			        }
	        	}

	        }else{

	        	//DYNAMIC QUIZ V 1
	        	
	        	$tags = $alltags;
	        	$number = get_post_meta($quiz_id,'vibe_quiz_number_questions',true);	
	        	if(!isset($number) || !is_numeric($number)) $number=0;
	        	$args = array(
	                'post_type' => 'question',
	                'orderby' => 'rand', 
	                'posts_per_page' => $number,
	                'tax_query' => array(
	                  	array(
	                    	'taxonomy' => 'question-tag',
	                    	'field' => 'id',
	                    	'terms' => $tags
	                  	),
	                )
		        );
		        $the_query = new WP_Query( $args );
		        while ( $the_query->have_posts() ) {
		            $the_query->the_post();
		            $quiz_questions['ques'][]=get_the_ID();
		            $quiz_questions['marks'][]=$marks;
		        }
		        wp_reset_postdata();
	        }

	    }else{

	    	// STATIC QUIZ
	    	if(empty($quiz_questions) || empty($quiz_questions['ques']))
	        	$quiz_questions = vibe_sanitize(get_post_meta($quiz_id,'vibe_quiz_questions',false));

	        $randomize=get_post_meta($quiz_id,'vibe_quiz_random',true);
	        if(isset($randomize) && $randomize == 'S'){ // If Radomise is not set.
	            if(isset($quiz_questions['ques']) && is_array($quiz_questions['ques']) && count($quiz_questions['ques']) > 1){
	                $randomized_keys = array_rand($quiz_questions['ques'], count($quiz_questions['ques'])); 
	                shuffle($randomized_keys);
	                foreach($randomized_keys as $current_key) { 
	                    $rand_quiz_questions['ques'][] = $quiz_questions['ques'][$current_key];
	                    $rand_quiz_questions['marks'][] = $quiz_questions['marks'][$current_key]; 
	                }
	            }
	            $quiz_questions = $rand_quiz_questions;   
	        }
	    }
	    bp_course_update_quiz_questions($quiz_id,$user_id,$quiz_questions);
	}

    //Check course news for students
    function check_course_news_for_students($query){
      if(!is_post_type_archive('news') || !$query->is_main_query())
        return $query;

      if(!is_user_logged_in())
        return $query;

      $user_id = get_current_user_id();
    
      if(current_user_can('manage_options')){
        return $query;
      }

      if(current_user_can('edit_posts')){  
        $query->set('author',$user_id);
      }else{
        $course_ids = bp_course_get_user_courses($user_id);
        $query->set('meta_query', array(
                array(
                'meta_key' => 'vibe_news_course',
                'compare' => 'IN',
                'value' => $course_ids,
                'type' => 'numeric'
                ),
            ) );
      }
    }

    //Get Nav only when required
    function get_nav(){
        if(class_exists('Vibe_CustomTypes_Permalinks')){
            $x = Vibe_CustomTypes_Permalinks::init();
            $this->nav = $x->permalinks;
        }else{
            $this->nav = get_option('vibe_course_permalinks');
        }

        return apply_filters('vibe_course_permalinks',$this->nav);
    }
}

BP_Course_Action::init();

function bp_course_get_nav_permalinks(){
	$action = BP_Course_Action::init();
	return $action->get_nav();
}


