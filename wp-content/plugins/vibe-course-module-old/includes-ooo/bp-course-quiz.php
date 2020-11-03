<?php
if ( ! defined( 'ABSPATH' ) ) exit;




if(!class_exists('WPLMS_Course_Quiz'))
{   
    class WPLMS_Course_Quiz
    {
        public static $instance;
        public static function init(){
            if ( is_null( self::$instance ) )
                self::$instance = new WPLMS_Course_Quiz();
            return self::$instance;
        }

        function __construct(){

            
            add_filter('wplms_unit_classes',array($this,'wplms_unit_classes'),10,2);
            
            add_action('wplms_front_the_quiz',array($this,'add_react_app_single_quiz'));

            add_action('wplms_inside_quiz_main_unit_content',array($this,'add_react_app_course_status'));

            add_action('wplms_after_start_course',array($this,'add_react_scripts_course_status'));

            add_action('wplms_submit_quiz',array($this,'reset_quiz_saved_answers'),10,2);
            add_action('wplms_quiz_retake',array($this,'reset_quiz_saved_answers'),10,2);
            add_action('wplms_quiz_reset',array($this,'reset_quiz_saved_answers'),10,2);
            add_action('wplms_quiz_course_retake_reset',array($this,'reset_quiz_saved_answers'),10,2);
            

            add_filter('bp_course_get_quiz_results_meta',array($this,'check_manual_quiz_meta'),10,4);
            add_action('wplms_quiz_retake',array($this,'reset_manual_quiz_meta'),10,2);
            add_action('wplms_quiz_reset',array($this,'reset_manual_quiz_meta'),10,2);
            add_action('wplms_quiz_course_retake_reset',array($this,'reset_manual_quiz_meta'),10,2);

            if(class_exists('BP_Course_Action')){
                $actions = BP_Course_Action::init();
                remove_action('wplms_after_quiz_message',array($actions,'show_quiz_results_after_quiz_message'),10,2);
            }
        }

        function reset_quiz_saved_answers($quiz_id,$user_id){
            delete_user_meta($user_id,'quiz_saved_answers'.$quiz_id);
        }

        function reset_manual_quiz_meta($quiz_id,$user_id){
            delete_user_meta($user_id,'manual_intermediate_results'.$quiz_id);
        }

        function check_manual_quiz_meta($result,$quiz_id,$user_id,$activity_id){
            if(!empty($result))
                return $result;
            $check_meta = get_user_meta($user_id,'manual_intermediate_results'.$quiz_id,true);
            if(!empty($check_meta)){
                $result = $check_meta;
            } 
            return $result;
        }

        function add_react_scripts_course_status(){
            ?>
            <script>
                jQuery()
                jQuery('.unit_content').on('unit_traverse',function(){
                    var postevent = new CustomEvent('userLoaded', { "detail":''});
                    document.dispatchEvent(postevent);
                });
                document.addEventListener('react_quiz_submitted',function(e){
                    $ = jQuery;
                    var nextunit = (e.detail && e.detail.next_unit)?e.detail.next_unit:0;
                    
                    if(nextunit){
                        $('#next_unit').removeClass('hide');
                        $('#next_unit').attr('data-unit',nextunit);  
                        $('#next_quiz').removeClass('hide');
                        $('#next_quiz').attr('data-unit',nextunit); 
                        $('#unit'+nextunit).find('a').addClass('unit');
                        $('#unit'+nextunit).find('a').attr('data-unit',nextunit);
                    }else{ 
                        if(nextunit != 0){ 
                            $('#next_unit').removeClass('hide');
                        }
                    }

                    $('.in_quiz').trigger('question_loaded');
                    
                    
                    $('#unit'+$('#unit.quiz_title').attr('data-unit')).addClass('done');
                    $('body').find('.course_progressbar').removeClass('increment_complete');
                    $('body').find('.course_progressbar').trigger('increment');
                     
                });
            </script>
            <?php
            $this->wplms_quiz(null,false,true);
        }

        function wplms_unit_classes($unit_class,$id){
            $react_quizzes = apply_filters('wplms_use_react_quizzes',1);
            if($react_quizzes){
                $unit_class .= ' react_quiz';
            }
            return $unit_class;
        }
        
        function add_react_app_single_quiz($quiz_id){
            echo '<div id="wplms_quiz" data-id="'.$quiz_id.'"></div>';
            wp_nonce_field('security','hash');
            $this->wplms_quiz($quiz_id,false,false);
            ?>
            <script>
                jQuery('body').delegate('input[name="initiate_retake"]','click',function(e){
                    e.preventDefault();
                    $ = jQuery;
                    $.ajax({
                        type: "POST",
                        url: ajaxurl,
                        data: { action: 'retake_inquiz', 
                              security: $('#hash').val(),
                              quiz_id:'<?php echo $quiz_id;?>',
                            },
                        cache: false,
                        success: function (html) {
                            window.location.reload();
                        }
                    });
                });
                jQuery('body').delegate('#prev_results a','click',function(event){
                      event.preventDefault();
                      jQuery(this).toggleClass('show');
                      jQuery('.prev_quiz_results').toggleClass('show');
                });
            </script>
            <?php
        }

        function add_react_app_course_status($quiz_id){
           
            echo '<div id="wplms_quiz" data-id="'.$quiz_id.'" data-type="incourse"></div>';
            
            
        }

        function wplms_quiz($quiz_id,$ajax=false,$in_course){
            $is_take_course = 0;
            if(!is_singular('quiz')){
                $is_take_course =1;
            }
            
            $user_id = get_current_user_id();
            
            $token= '';
            if(!empty($user_id)){
                $tokens  = get_user_meta($user_id,'access_tokens',true);
                if(!empty($tokens) && !empty($tokens)){
                    $token = $tokens[0];
                }
                if(empty($token) && class_exists('BP_Course_Action')){
                    $generated_token = BP_Course_Action::generate_token($user_id,'wplms_generated_for_quiz_'.$quiz_id);
                    $token = $generated_token['access_token'];
                }
            }
            
            $wplms_quiz_data = apply_filters('wplms_wplms_quiz_tab_settings',array(

                'api_url'=> get_rest_url(null,BP_COURSE_API_NAMESPACE),
                'user_id'=>get_current_user_id(), 
                'timestamp'=>time(),
                'token'=>$token,
                'quiz_id'=>$quiz_id,
                'in_course' =>$in_course,
                'start_popup'=>false,
                'submit_popup'=>false,
                'translations'=>array(
                    'date'=>_x('Date','react quiz','wplms'),
                    'is_take_course'=>$is_take_course,
                    'select_option'=>_x('Select Option','react quiz','wplms'),
                    'course'=>_x('Course','react quiz','wplms'),
                    'quiz'=>_x('Quiz','react quiz','wplms'),
                    'true' => _x('True','react quiz','wplms'),
                    'false' => _x('False','react quiz','wplms'),
                    'start'=>_x('Start Quiz','react quiz','wplms'),
                    'continue'=>_x('Continue Quiz','react quiz','wplms'),
                    'submit'=>_x('Submit Quiz','react quiz','wplms'),
                    'reset'=>_x('Reset','react quiz','wplms'),
                    'start_quiz'=>_x('Start quiz','react quiz','wplms'),
                    'continue_quiz'=>_x('Start quiz','react quiz','wplms'),
                    'check_answer'=>_x('Check Answer','react quiz','wplms'),
                    'expired' => _x('Expired','react quiz','wplms'),
                    'days' => _x('Days','react quiz','wplms'),
                    'hours' => _x('Hours','react quiz','wplms'),
                    'minutes' => _x('Minutes','react quiz','wplms'),
                    'seconds' => _x('Seconds','react quiz','wplms'),
                    'correct_answer' => _x('Correct Answer','react quiz','wplms'),
                    'question' => _x('QUESTION','react quiz','wplms'),
                    'check_results' => _x('Check Results','react quiz','wplms'),
                    'save_quiz' => _x('Save Quiz','react quiz','wplms'),
                    'yes'=>_x('Yes','react quiz','wplms'),
                    'no'=>_x('No','react quiz','wplms'),
                    'start_quiz_confirm'=>_x('Do you really want to start the quiz?','react quiz','wplms'),
                    'submit_quiz_confirm'=>_x('Do you really want to submit the quiz?','react quiz','wplms'),
                    'unanswered_confirm'=>_x('You have some unanswered questions.','react quiz','wplms'),
                    'total_marks' => _x('Total Marks','react quiz','wplms'),
                    'unattempted' =>_x('Unattempted','react quiz','wplms'),
                    'correct' => _x('Correct','react quiz','wplms'),
                    'correct_percentage' => _x('Correct Percentage','react quiz','wplms'),
                    'incorrect'=>_x('Incorrect','react quiz','wplms'),
                    'historical' => _x('Overall correct percentages by each question','react quiz','wplms'),
                    'q' => _x('Q','Advance stats for question in quiz result react quiz','wplms'),
                ),
            ));
            
            if(function_exists('bp_wplms_get_theme_color') && !empty(bp_wplms_get_theme_color())){
                $color = bp_wplms_get_theme_color();
            }
            if($ajax){
                echo '<script>var wplms_course_data = '.json_encode(WPLMS_Course_Component_Init::get_wplms_course_data()).'</script>';


                echo '<script type="text/javascript" src="'.plugins_url('/../../../assets/js/quiz.js',__FILE__).'?ver='.WPLMS_PLUGIN_VERSION.'"></script>';

                echo '<link rel="stylesheet" id="wplms-wplms_quiz-circle-css-css"  href="'.plugins_url('../includes/css/circle.css',__FILE__).'?ver='.WPLMS_PLUGIN_VERSION.'" type="text/css" media="all" />';
            }else{
                wp_enqueue_script('wplms-quiz-js',plugins_url('/../../../assets/js/quiz.js',__FILE__),array('wp-element'),WPLMS_PLUGIN_VERSION,true);

                wp_localize_script('wplms-quiz-js','wplms_course_data',WPLMS_Course_Component_Init::get_wplms_course_data());
                wp_enqueue_style( 'wplms-wplms_quiz-css', plugins_url('/../../../assets/css/wplms.css',__FILE__),array(),WPLMS_PLUGIN_VERSION);
            }
        }
    }
    add_action('init',function(){
        WPLMS_Course_Quiz::init();
    });
}
