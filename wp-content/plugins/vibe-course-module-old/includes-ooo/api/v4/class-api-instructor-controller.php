<?php

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'BP_Course_Rest_Instructor_Controller' ) ) {
	
	class BP_Course_Rest_Instructor_Controller extends BP_Course_New_Rest_Controller {

		public function register_routes() {
			// instructor app
			$this->type= 'instructor';
			register_rest_route( $this->namespace, '/' . $this->type . '/courses', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_instructor_courses' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			
			register_rest_route( $this->namespace, '/' . $this->type . '/course/(?P<id>\d+)?', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_course_by_id' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/members', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_course_members' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/(?P<cpt>\w+)/activity', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_activity' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/remove_member', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'remove_member_from_course' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/reset_course', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'reset_course_for_member' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/get_course_user_stats', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_course_user_stats' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/complete_course_curriculum', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'complete_course_curriculum' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/uncomplete_course_curriculum', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'uncomplete_course_curriculum' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/search_students_to_add', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'search_students_to_add' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/add_members', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'add_member_to_course' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/update_course_status', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'update_course_status_member' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/extend_course_subscription', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'extend_course_subscription_members' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/assign_badge_certificate', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'assign_badge_course_certificate' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );

			/* SUBMISSIONS */

			
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/getSubmissionTabs', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_submission_tabs' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/' . $this->type . '/getSubmissions/', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_submissions' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/' . $this->type . '/resetSubmission', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'reset_submission' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/get_admin_page_tabs', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_admin_page_tabs' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/' . $this->type . '/getStructure', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_submission_structure' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/evaluate_quiz_question', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'evaluate_quiz_question' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/evaluate_quiz_question', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'evaluate_quiz_question' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/set_complete_course_marks', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'set_complete_course_marks' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/set_complete_assignment_marks', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'set_complete_assignment_marks' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/update_user_marks_remarks', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'update_user_marks_remarks' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			// for getting all unit which have some discussion/reply
			register_rest_route( $this->namespace, '/' . $this->type . '/get_units_discussion', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_units_discussion' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			// get discussion by unit id
			register_rest_route( $this->namespace, '/' . $this->type . '/get_units_discussion_page', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_units_discussion_page' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/create_unit_comments', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'create_unit_comments' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );

			/* New endpoints */
			register_rest_route( $this->namespace, '/' . $this->type . '/quizzes', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_instructor_quizzes' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/quiz', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_instructor_quiz' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/questions', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_instructor_questions' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/import_questions', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'import_instructor_questions' ),
				'permission_callback' 		=> array( $this, 'get_post_instructor_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/' . $this->type . '/import_students', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'import_instructor_students' ),
				'permission_callback' 		=> array( $this, 'get_post_instructor_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/' . $this->type . '/assignments', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_instructor_assignments' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/assignment', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_instructor_assignment' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/' . $this->type . '/stats', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_statistics' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			
			register_rest_route( $this->namespace, '/' . $this->type . '/leaderboard', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_leaderboard' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );

			/* Manage Students */

			register_rest_route( $this->namespace, '/' . $this->type . '/manageStudents/getTabs', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'student_tabs' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/' . $this->type . '/manageStudents/fetchTab', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'student_tab' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/manageStudents/changedata', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'change_student_data' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			
			/* Manage Students */
			register_rest_route( $this->namespace, '/' . $this->type . '/comments', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_questions' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/' . $this->type . '/getReports', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_reports' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/' . $this->type . '/getReport', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'getReport' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/getReportFilters', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'getReportFilters' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/getcoursestats', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'getcoursestats' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/recalculatestats', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'recalculatestats' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			
			register_rest_route( $this->namespace, '/' . $this->type . '/generatestats', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'generatestats' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/' . $this->type . '/addnews', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'addnews' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );


			register_rest_route( $this->namespace, '/' . $this->type . '/manageapplication', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'manageapplication' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			
		}
		/************ Public Function ***************/
		public function prepare_data_for_response( $course,$request ,$extra) {
			$context = $extra['context'];

			switch($context){
				case 'full':
					$data = array(
						'data'				=> array(
							'id'                    => $course->ID,
							'name'                  => $course->post_title,
							'date_created'          => strtotime( $course->post_date_gmt ),
							'status'                => $course->post_status,	
							'price'                 => $this->get_price($course),
							'price_html'            => $this->get_price_html($course),
							'total_students'        => (int) get_post_meta( $course->ID, 'vibe_students', true ), 
							'seats'                 => bp_course_get_max_students($course->ID),
							'start_date'            => $this->get_course_start_date($course),
							'average_rating'        => $this->get_average_rating($course),
							'rating_count'          => $this->get_rating_count($course),
							'featured_image'		=> $this->get_course_featured_image($course),	
							'categories'			=> $this->get_taxonomy_terms($course,'course-cat'),	
							'instructor'            => $this->get_course_instructor($course->post_author),	
							'menu_order'            => $course->menu_order,
							),
						'description'			=> do_shortcode($course->post_content),
						'curriculum'            => $this->get_curriculum( $course ),
						'reviews'				=> $this->get_reviews($course),
						'instructors'			=> $this->get_course_instructors($course),
					);
					$data['purchase_link'] = $this->get_purchase_link($course);
					$data['post_content'] = $this->get_Video_Iframe_Audio_Content_from_post_content($course->post_content);
					// tab
					$data['is_instructor'] = $this->check_user_is_instructor($course->ID,$this->user);  // check for instructor cap


					if($data['is_instructor']){
						$data['tabs'] = $this->get_instructor_tabs($course->ID);
					}
					$data = apply_filters('wplms_fetch_course_api_full',$data,$course,$request);
				break;
				case 'view':
					$data = array(
						'data'				=> array(
							'id'                    => $course->ID,
							'name'                  => $course->post_title,
							'date_created'          => strtotime( $course->post_date_gmt ),
							'status'                => $course->post_status,	
							'price'                 => $this->get_price($course),
							'price_html'            => $this->get_price_html($course),
							'total_students'        => (int) get_post_meta( $course->ID, 'vibe_students', true ), 
							'seats'                 => bp_course_get_max_students($course->ID),
							'start_date'            => $this->get_course_start_date($course),
							'average_rating'        => $this->get_average_rating($course),
							'rating_count'          => $this->get_rating_count($course),
							'featured_image'		=> $this->get_course_featured_image($course),	
							'categories'			=> $this->get_taxonomy_terms($course,'course-cat'),	
							'instructor'            => $this->get_course_instructor($course->post_author),	
							'menu_order'            => $course->menu_order,
							),
						'description'			=> do_shortcode($course->post_content),
						'curriculum'            => $this->get_curriculum( $course ),
						'reviews'				=> $this->get_reviews($course),
						'instructors'			=> $this->get_course_instructors($course),
					);
					$data['purchase_link'] = $this->get_purchase_link($course);
					$data['post_content'] = $this->get_Video_Iframe_Audio_Content_from_post_content($course->post_content);
					$data = apply_filters('wplms_fetch_course_instructor_api_view',$data,$course,$request);
				break;
				case 'loggedin':
					$data = array(
						'data'				=> array(
							'id'                    => $course->ID,
							'name'                  => $course->post_title,
							'excerpt'               => $course->post_excerpt,
							'date_created'          => strtotime( $course->post_date_gmt ),
							'link'					=> get_permalink($course->ID),
							'status'                => $course->post_status,	
							'price'                 => $this->get_price($course),
							'price_html'            => $this->get_price_html($course),
							'total_students'        => (int) get_post_meta( $course->ID, 'vibe_students', true ), 
							'seats'                 => bp_course_get_max_students($course->ID),
							'start_date'            => $this->get_course_start_date($course),
							'average_rating'        => $this->get_average_rating($course),
							'rating_count'          => $this->get_rating_count($course),
							'featured_image'		=> $this->get_course_featured_image($course),	
							'categories'			=> $this->get_taxonomy_terms($course,'course-cat'),	
							'instructor'            => $this->get_course_instructor($course->post_author),	
							'menu_order'            => $course->menu_order,
							'user_status'			=>bp_course_get_user_course_status($this->user_id,$course->ID),
							'user_expiry'			=>bp_course_get_user_expiry_time($this->user_id,$course->ID),
							),
						'curriculum'            => $this->get_curriculum( $course ),
						'reviews'				=> $this->get_reviews($course),
						'instructors'			=> $this->get_course_instructors($course),
					);
					$data['purchase_link'] = $this->get_purchase_link($course);
					$data['post_content'] = $this->get_Video_Iframe_Audio_Content_from_post_content($course->post_content);
					// tab
					$data['is_instructor'] = $this->check_user_is_instructor($course->ID,$this->user_id);  // check for instructor cap
					if($data['is_instructor']){
						$data['tabs'] = $this->get_instructor_tabs($course->ID);
					}
					$data = apply_filters('wplms_fetch_course_instructor_api_loggedin',$data,$course,$request,$this->user_id);
				break;
				default:
					if(empty($data)){
						$data = array(
							'id'                    => $course->ID,
							'name'                  => $course->post_title,
							'date_created'          => strtotime( $course->post_date_gmt ),
							'status'                => $course->post_status,	
							'price'                 => $this->get_price($course),
							'price_html'            => $this->get_price_html($course),
							'total_students'        => (int) get_post_meta( $course->ID, 'vibe_students', true ), 
							'seats'                 => bp_course_get_max_students($course->ID),
							'start_date'            => $this->get_course_start_date($course),
							'average_rating'        => $this->get_average_rating($course),
							'rating_count'          => $this->get_rating_count($course),
							'featured_image'		=> $this->get_course_featured_image($course),	
							'categories'			=> $this->get_taxonomy_terms($course,'course-cat'),	
							'instructor'            => $this->get_course_instructor($course->post_author),	
							'menu_order'            => $course->menu_order,	
						);
					}
					$data = apply_filters('wplms_fetch_course_instructor_api',$data,$course,$request);
				break;
			}
			return $data;
		}	

		function get_member($user_id){
			$field = 'Location';
			if(function_exists('vibe_get_option'))
			$field = vibe_get_option('student_field');

			return array(
				'id'     => $user_id, 
				'name'   => bp_core_get_user_displayname($user_id),
				'avatar' => bp_course_get_instructor_avatar_url($user_id),
				'sub'    => (bp_is_active('xprofile')?bp_get_profile_field_data('field='.$field.'&user_id='.$user_id):''),
			);
		}

		public function get_price($course){
			$price = false;

			$free = get_post_meta($course->ID,'vibe_course_free',true);
			
			if(!empty($free) && $free == 'S'){
				$course->price = 0;
				return 0;
			}

			if(function_exists('wc_get_product')){
				$product_id = get_post_meta($course->ID,'vibe_product',true);
				if(get_post_type($product_id) == 'product'){
					$product = wc_get_product($product_id);
					$course->product = $product;
					$price = $product->get_price();
				}
				
			}
			return $price;
		}

		public function get_average_rating($course){
			$rating=get_post_meta($course->ID,'average_rating',true);
			if(empty($rating)){$rating = 0;}
			return $rating;
		}

		public function get_rating_count($course){
			$count=get_post_meta($course->ID,'rating_count',true);
			if(empty($count)){$count = 0;}
			return $count;	
		}

		public function get_course_featured_image($course){

			$post_thumbnail_id = get_post_thumbnail_id( $course );
			if(!empty($post_thumbnail_id)){
				$image = wp_get_attachment_image_src($post_thumbnail_id,'medium');
				$image = $image[0];
			}

			if(empty($image)){
                $image = vibe_get_option('default_course_avatar');
                if(empty($image)){
                    $image = VIBE_URL.'/assets/images/avatar.jpg';
                }
            }

            return $image;
		}

		public function get_price_html($course){

			$free = get_post_meta($course->ID,'vibe_course_free',true);
			if(isset($free) && $free != 'H'){
				return _x('FREE','REST API FREE course label','wplms');
			}
			$price_html =array();
			$single_price = '';

			$version =  bp_course_get_setting( 'app_version', 'api','number' ); 
			
			if(function_exists('WC')){
				$cart_url =  get_permalink( wc_get_page_id( 'cart' ) );
				$woo_price = array();
				$product_id = get_post_meta($course->ID,'vibe_product',true);
				if(is_numeric($product_id)){
					$product = wc_get_product($product_id);
					if(is_object($product)){

						if($product->is_type( 'variable' )){

							$variations = $product->get_available_variations();
							foreach($variations as $variation){
								$cart_url = $cart_url.'?add-to-cart='.$product_id.'&variation_id='.$variation['variation_id'];
		    					foreach($variation['attributes'] as $key => $value){
		    						$cart_url = $cart_url.'&'.$key.'='.$value;
		    					}
		    					$variable_is_wplms = get_post_meta($variation['variation_id'],'variable_is_wplms',true);
		    					
		    					if(!empty($variable_is_wplms) && $variable_is_wplms == 'on'){
			    					
			    					$course_subscription_ed = get_post_meta($variation['variation_id'],'vibe_subscription',true);

			    					if(!empty($course_subscription_ed)){
			    						$duration = get_post_meta($variation['variation_id'],'vibe_duration',true);
			  							$product_duration_parameter = apply_filters('vibe_product_duration_parameter',86400,$variation['variation_id']);
			  							if(!empty($duration)){
			  								$course_subscription =  $duration*$product_duration_parameter;
			  							}
			    					}else{
			    						$course_subscription = bp_course_get_course_duration($course->ID);
			    					}
			    					$course_retakes = '';
			    					$quiz_retakes = '';
			    					$course_certificate = get_post_meta($variation['variation_id'],'vibe_enable_certificate',true);
			    					$course_badge = get_post_meta($variation['variation_id'],'vibe_enable_badge',true);
			    					$course_retake = get_post_meta($variation['variation_id'],'vibe_enable_course_retakes',true);
			    					$quiz_retake = get_post_meta($variation['variation_id'],'vibe_enable_quiz_retakes',true);

			    					if(!empty($course_retake) && $course_retake == 'S'){
			    						 $course_retakes = get_post_meta($variation['variation_id'],'vibe_course_retakes',true); 
			    					}
			    					if(!empty($quiz_retake) && $quiz_retake == 'S'){
			    						$quiz_retakes = get_post_meta($variation['variation_id'],'vibe_quiz_retakes',true);
			    					}

			    					$min_price = $variation['display_price'];

			    					$var_price = array(	
											'type' => 'inapp',
											'source' => 'woocommerce',
											'value' => $min_price,
											'html'=> $variation['price_html'],
											'link'=> $cart_url,
											'extras'=>array(
													array('id'=>'subscription','value' => $course_subscription,'label'=>_x('Subscription','','wplms')),
													array('id'=>'course_certificate','value' => $course_certificate,'label'=>_x('Course Certificate','','wplms')),
													array('id'=>'course_badge','value' => $course_badge,'label'=>_x('Course Badge','','wplms')),
													array('id'=>'course_retakes','value' => $course_retakes,'label'=>_x('Course Retakes','','wplms')),
													array('id'=>'quiz_retakes','value' => $quiz_retakes,'label'=>_x('Quiz Retakes','','wplms')),
													
												),
										);
			    					if(function_exists('groups_get_group')){
			    						$batch_id = get_post_meta($variation['variation_id'],'vibe_course_batches',true);
				    					$batch = groups_get_group( array( 'group_id' => $batch_id) );
				    					array_push($var_price['extras'],array('id'=>'batch','value' =>  $batch->name,'label'=>_x('Batch','','wplms')));
			    					}

									array_push($price_html,$var_price);

			    				}
							}

						}else{
							
							if($version > 1){
								$cart_url = $cart_url.'?add-to-cart='.$product_id;
								array_push($price_html,array(	
												'type' => 'inapp',
												'source' => 'woocommerce',
												'value' =>  $product->get_price(),
												'html'=> $product->get_price_html(),
												'link'=> $cart_url,
												'extras'=>array(
													array(
														'id'=>'subscription',
														'value' => bp_course_get_course_duration($course->ID),
														'label'=>_x('Subscription','','wplms')
													),
												),
											));
							}else{
								$single_price = $product->get_price_html();
							}
						}

					}
				}
			}

			if(function_exists('pmpro_getAllLevels')){
				$pmpro_price = array();
				$membership_ids = get_post_meta($course->ID,'vibe_pmpro_membership',true);
				if(isset($membership_ids) && is_array($membership_ids) && count($membership_ids)){
				//$membership_id = min($membership_ids);
				$levels=pmpro_getAllLevels();
					foreach($levels as $level){
						if(in_array($level->id,$membership_ids)){
							$link = get_option('pmpro_levels_page_id');
							$link = get_permalink($link).'#'.$level->id;
							$pmpro_price = array(	
											'type' => 'inapp',
											'source' => 'pmpro_membership',
											'value' =>  '',
											'html'=> $level->name,
											'link'=> $link,
											'id'=>$level->id,
											'extras'=>array(),
										);
							
							array_push($price_html,$pmpro_price);
						}
					}
			    }
			}

			if(function_exists('mycred')){
				$mycred_price  = array();
				$points=get_post_meta($course->ID,'vibe_mycred_points',true);
				if(isset($points) && is_numeric($points)){
					$mycred = mycred();
					
					$subscription = get_post_meta($course->ID,'vibe_mycred_subscription',true);
					if(isset($subscription) && $subscription && $subscription !='H'){
						$duration = get_post_meta($course->ID,'vibe_mycred_duration',true);
						$duration_parameter = get_post_meta($course->ID,'vibe_mycred_duration_parameter',true);
						$duration = $duration*$duration_parameter;

					}
						$mycred_price = array(	
											'type' => 'post',
											'source' => 'mycred',
											'value' =>  $points,
											'html'=> $points,
											'link'=> $link,
											'extras'=>array(),
										);
					if(function_exists('tofriendlytime')){
						$points_html .= ' <span class="subs"> '.$mycred->format_creds($points).' '.__('per','wplms').' '.tofriendlytime($duration).'</span>';
						$mycred_price['html']  = $points_html;
						
					}
					array_push($price_html,$mycred_price);
				}
			}

			if(empty($price_html)){

				if($version > 1){
					$coming_soon = get_post_meta($course->ID,'vibe_coming_soon',true);
					if(!empty($coming_soon) && function_exists('vibe_validate') && vibe_validate($coming_soon)){
						array_push($price_html,
							array(	
								'type' => 'na',
								'source' => 'na',
								'value' =>  '',
								'html'=> __('Coming Soon','wplms'),
								'extras'=>array(),
							)
						);
					}else{
						array_push($price_html,
							array(	
								'type' => 'na',
								'source' => 'na',
								'value' =>  '',
								'html'=> __('Private','wplms'),
								'extras'=>array(),
							)
						);
					}
				}
			}

			

			//currently bailing out multiple pricing if product is not variable 
			if(!empty($single_price)){
				return $single_price;
			}
			return $price_html;

		}

		public function get_course_start_date($course){

			$start_date = bp_course_get_start_date($course->ID);
			return strtotime($start_date);
		}

		public function is_online($course){
			$check = get_post_meta( $course->ID, 'vibe_course_offline', true );
			if(!empty($check) && $check == 'S'){
				return true;
			}
			return false;
		}

		public function get_taxonomy_terms($course,$taxonomy = 'course-cat'){

			$args = array("fields" => "all");
			$course_terms = wp_get_post_terms($course->ID,$taxonomy);
			$terms = array();

			foreach($course_terms as $term){
				
				if($taxonomy == 'course-cat'){
					$thumbnail_id = get_term_meta( $term->term_id, 'course_cat_thumbnail_id', true );	
				}else{
					$thumbnail_id = false;
				}
				
                if ( $thumbnail_id ) {
                    $image = wp_get_attachment_image_src( $thumbnail_id,'medium' );
                    if(!empty($image) && !is_wp_error($image)){
                    	$image=$image[0];	
                    }
                }

                if(empty($image)){
                    $image = vibe_get_option('default_avatar');
                    if(empty($image)){
                        $image = VIBE_URL.'/assets/images/avatar.jpg';
                    }
                }
				$terms[] = array(
					'id'   => $term->term_id,
					'name' => $term->name,
					'slug' => $term->slug,
					'image'=> $image
				);	
			}
			
			return $terms;
		}

		public function get_purchase_link($course){
			if(function_exists('WC')){
				$product_id = get_post_meta($course->ID,'vibe_product',true);
				$courses = get_post_meta($product_id,'vibe_courses',true);
				if(is_array($courses) && in_array($course->ID,$courses)){
					return get_permalink($product_id).'?redirect';
				}else if($courses == $course->ID){
					return get_permalink($product_id).'?redirect';
				}
			}
			return false;
		}

		public function get_curriculum($course){

			$curriculum = bp_course_get_curriculum($course->ID);
			if(empty($curriculum))
				return false;

			$curriculum_arr = array();
			foreach($curriculum as $key => $item){
				if(is_numeric($item)){
					if(bp_course_get_post_type($item) == 'unit'){
						$curriculum_arr[] = apply_filters('bp_course_api_course_curriculum_unit',array(
							'key'		=> $key,
							'id'		=> $item,
							'type'		=> 'unit',
							'title'		=> get_the_title($item),
							'duration'	=> bp_course_get_unit_duration($item),
							'meta'		=> array()
						));
					}else if(bp_course_get_post_type($item) == 'quiz'){
						$curriculum_arr[] = apply_filters('bp_course_api_course_curriculum_quiz',array(
							'key'		=> $key,
							'id'		=> $item,
							'type'		=> 'quiz',
							'title'		=> get_the_title($item),
							'duration'	=> bp_course_get_quiz_duration($item),
							'meta'		=> array(),
						));
					}

				}else{
					$curriculum_arr[] = apply_filters('bp_course_api_course_curriculum_section',array(
						'key'		=> $key,
						'id'		=> 0,
						'type'		=> 'section',
						'title'		=> $item,
						'duration'	=> 0,
						'meta'		=> array()
					));
				}
			}	

			return $curriculum_arr;
		}

		public function get_reviews($course){
			$reviews = array();
			$args = apply_filters('bp_course_api_course_reviews',array(
				'post_id' 	=> $course->ID,
				'status' => 'approve',
				'orderby'	=> 'comment_date',
				'order'		=> 'DESC',
				'number'	=> 5,
				));
			$comments = get_comments($args);
			if(!empty($comments)){
	            foreach($comments as $comment){
	            	$title =  get_comment_meta( $comment->comment_ID, 'review_title',true);
	            	$rating = get_comment_meta( $comment->comment_ID, 'review_rating',true);	
	            	$review = array(
	            		'id' 		=> $comment->comment_ID,
	            		'title'		=> $title,
	            		'content'	=> $comment->comment_content,
	            		'rating'	=> $rating,
	            		'member'	=> $this->get_member($comment->user_id)
		        	);
		        	array_push($reviews, $review);
	            }
	            
	        }
			return $reviews;
		}

		public function get_course_instructors($course){
			$authors = array();
			$course_authors = apply_filters('wplms_course_instructors',array($course->post_author),$course->ID);
			if(!empty($course_authors)){
				if(function_exists('vibe_get_option')){
					$field = vibe_get_option('instructor_field');		
					$biofield = vibe_get_option('instructor_about');	
				}
				if(empty($biofield)){$biofield = 'Bio';}
				if(empty($field)){$field = 'Speciality';}
	            foreach($course_authors as $author_id){
	            	$author = array(
	            		'id'     => $author_id, 
						'name'   => bp_core_get_user_displayname($author_id),
						'avatar' => bp_course_get_instructor_avatar_url($author_id),
						'sub'    => (bp_is_active('xprofile')?bp_get_profile_field_data('field='.$field.'&user_id='.$author_id):''),
						'average_rating' => wplms_plugin_get_instructor_average_rating($author_id),
						'student_count'=> wplms_plugin_get_instructor_student_count($author_id),
						'course_count'=>bp_course_get_instructor_course_count_for_user($author_id),
						'bio'=> (bp_is_active('xprofile')?bp_get_profile_field_data('field='.$biofield.'&user_id='.$author_id):''),
		        	);
		        	array_push($authors, $author);
	            }    
	        }
			return $authors;
		}

		public function get_course_instructor($instructor_id){

			$field = 'Speciality';
			if(function_exists('vibe_get_option'))
			$field = vibe_get_option('instructor_field');

			return array(
				'id'     => $instructor_id, 
				'name'   => bp_core_get_user_displayname($instructor_id),
				'avatar' => bp_course_get_instructor_avatar_url($instructor_id),
				'sub'    => (bp_is_active('xprofile')?bp_get_profile_field_data('field='.$field.'&user_id='.$instructor_id):''),
			);
		}
		/************ Public Function ***************/

		function get_instructor_permissions_check($request){
			
			$body = json_decode($request->get_body(),true);
			
			if(!empty($body['token'])){
	            $this->user = apply_filters('vibebp_api_get_user_from_token','',$body['token']);
	            if(!empty($this->user)){
	            	//User->roles , user->caps can be checked
	                return true;
	            }
	        }

	        return false;
		}
		function get_post_instructor_permissions_check($request){
			
			$body =json_decode(stripslashes($_POST['body']),true);
			
			if(!empty($body['token'])){
	            $this->user = apply_filters('vibebp_api_get_user_from_token','',$body['token']);
	            if(!empty($this->user)){
	            	//User->roles , user->caps can be checked
	            	$this->user_id =$this->user->ID;
	                return true;
	            }
	        }

	        return false;
		}


		function get_user_from_token($token){
			global $wpdb;
			$user_id = $wpdb->get_var(apply_filters('wplms_usermeta_direct_query',"SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = '$token'"));
			if(is_numeric($user_id)){
				return $user_id;
			}
			return false;
		}

		function get_item_permissions_check($request){
			$headers = vibe_getallheaders();
			if(isset($headers['Authorization'])){
				$token = $headers['Authorization'];
				$this->token = $token;
				$this->user_id = $this->get_user_from_token($token);
				if($this->user_id){
					return $this->user_id;
				}
			}
			return 0;
		}

		

		function get_instructor_courses($request){

			$body = json_decode($request->get_body(),true);
			$filter = $body['filter'];

			$courses = array();
			
			$query_args = array(
				'post_type'=>'course',
				'orderby' => $filter['orderby'] ? $filter['orderby']: 'DESC',
				"order" => $filter['order'] ? $filter['order']: 'DESC',
				'paged'=>$filter['paged'] ? $filter['paged']: 1,
				'posts_per_page'=> 12,
				's' =>$filter['search_terms'] ? $filter['search_terms']: '',
			);
			
			if(!in_Array('manage_options',array_keys((Array)$this->user->caps))){ //Not administrator
				if ( function_exists('get_coauthors')) {
					$author_names = array();
					$instructor_name = get_the_author_meta('user_nicename',$this->user->id);
					$author_names[] = $instructor_name;

					// return $author_names;
					$query_args['tax_query']= array(
						'relation' => 'AND',
						array(
							'taxonomy'=>'author',
							'field'=>'name',
							'terms' => $author_names,
						)
					);
				}else{
					$query_args['author']=$this->user->id;
				}
			}
			
			$query_args = apply_filters('wplms_plugin_instructor_courses',$query_args,$this->user);
			$query = new WP_Query($query_args);
			if ( $query->have_posts() ):
				while ( $query->have_posts() ) : $query->the_post();
					global $post;
					$courses[]=$this->prepare_data_for_response($post,$request,array('context'=>'view'));
				endwhile;	
			endif;

			if(empty($courses)){
				$data = array(
					'status' => 0,
					'message' => _x('Courses not found!','Courses not found!','wplms'),
					'courses' => [],
					'total'	=> 0
				);
			}else{
				$data = array(
					'status' => 1,
					'message' => _x('Courses found !','Courses found!','wplms'),
					'courses'=>$courses,
					'args'=>$query_args,
					'total'=>$query->found_posts
				);
			}
			
			$data = apply_filters('vibe_get_instructor_course',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}
		
		function get_course_by_id($request){
			$course_id = $request['id'];
			if(!empty($course_id)){ 
				$post  = get_post( $course_id );
				if($post->post_type && in_array( $post->post_type, $this->registered_post_types) ) {
					$user_id =  $this->set_current_user_id_by_token($request);

					if($this->user_id){
						$course = $this->prepare_data_for_response($post,$request,array('context'=>'loggedin'));
					}else{
						$course = $this->prepare_data_for_response($post,$request,array('context'=>'view'));
					}
					if(!empty($course)){
						$data = array(
							'status' => 1,
							'message' => _x('Course found!','Course found!','wplms'),
							'data'=> $course
						);
					}else{
						$data = array(
							'status' => 0,
							'message' => _x('Course Not found!','Course Not found!','wplms'),
							'data'=> null
						);
					}
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('Post Type Not matched','Post Type Not matched','wplms'),
						'data'=> null
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Course Not found!','Course Not found!','wplms'),
					'data'=> []
				);
			}
			$data = apply_filters('vibe_get_instructor_course_by_id',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function get_course_members($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$filter = $post->filter;
			$members = array();  // response

			if(empty($this->user)){
				$current_user_id = $this->set_current_user_id_by_token($request);
			}else{
				$current_user_id = $this->user->id;
			}
			

			if(!empty($filter) && !empty($course_id)){ 

				$is_instructor = $this->check_user_is_instructor($course_id,$this->user); // instructor set

				global $wpdb,$bp;
		        $query = " SELECT DISTINCT u.ID as id FROM {$wpdb->users} as u "; 
		        $total_count_query = " SELECT COUNT(DISTINCT u.ID) as total FROM {$wpdb->users} as u "; 
		        $join = " ";
		        // where query manipulation
		       	if(!empty($filter->active_status)){
		       		$where = " where 1 ";
		       	}else{
		       		$where = " where m2.meta_key = 'course_status{$course_id}' ";
		       	}
				$orderby = " "; 
				$limit = " ";
				$join .= " LEFT JOIN {$wpdb->usermeta} as m2 ON u.ID = m2.user_id ";
				$per_page = (!empty($filter->per_page)) ? ($filter->per_page<20?$filter->per_page:20) : 20;
				$paged_temp = (!empty($filter->paged)) ? ($filter->paged<20?$filter->paged:1) : 1;
				$paged = $per_page*($paged_temp-1);
				if(!empty($filter->search_terms)){
					$where .= " AND (user_login LIKE '%{$filter->search_terms}%' OR user_nicename LIKE '%{$filter->search_terms}%' OR display_name LIKE '%{$filter->search_terms}%' OR user_email LIKE '%{$filter->search_terms}%') ";
				}
				if(!empty($filter->order)){
					switch ($filter->order) {
						case 'alphabetical':
							$orderby = "ORDER BY u.display_name ASC";
							break;
						case 'toppers':
							$orderby = "ORDER BY m2.meta_value DESC";
							break;
						case 'recent':
							$orderby = "ORDER BY m2.umeta_id DESC";
						default:
							break;
					}
					
				}
				if(!empty($filter->active_status)){
					$time = time();
					if($filter->active_status == "active"){
                    	$where .= "  AND (m2.meta_key = {$course_id} AND m2.meta_value > {$time}) ";
	                }else{
	                    $where .= "  AND (m2.meta_key = {$course_id} AND m2.meta_value <= {$time}) ";
	                }
				}
				// it can be 0 too for start course then 1,2,3
				if(!empty($filter->course_status)){
					$join .= " LEFT JOIN {$wpdb->usermeta} as m3 ON u.ID = m3.user_id ";
                    $where .= "  AND (m3.meta_key = 'course_status{$course_id}' AND m3.meta_value = {$filter->course_status}) ";
				}

				$limit .= " LIMIT {$per_page} OFFSET {$paged} ";
				$query = $query . $join . $where . $orderby .$limit;

				$total_count_query = $total_count_query . $join . $where . $orderby.' LIMIT  0,9999';
				// return $query;

				$member_ids = $wpdb->get_results($query,ARRAY_A);
				$count= 0;
				if(!empty($member_ids)){
					$count = $wpdb->get_var($total_count_query);
					foreach ($member_ids as $member_id) {
						$member = $this->get_user_by_ID($member_id['id']);
						$member['progress']= get_user_meta($member_id['id'],'progress'.$course_id,true);
						if($member['progress'] < 100){
							$member['expiry']= intval(get_user_meta($member_id['id'],$course_id,true)) - time();
						}
						$members[] = apply_filters('wplms_course_admin_member',$member,$course_id);
					}
					$data = array(
						'status' => 1,
						'message' =>  _x('Members found','Members found','wplms'),
						'data'=>$members,
						'total'=>$count,
						'is_instructor' => $is_instructor
					);
				}else{
					$data = array(
						'status' => 0,
						'total'	=> $count,
						'message' =>  _x('Members not found','Members not found','wplms'),
						'data'=>$members,
						'is_instructor' => $is_instructor
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Filter or Course Not found!','Filter or Course Not found!','wplms'),
					'data'=>$members,
					'is_instructor' => $is_instructor
				);
			}
			$data = apply_filters('vibe_get_course_members',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}


		function access_activity_check($scope,$is_instructor,$current_user_id){
			if($is_instructor){
				if($scope == 'personal'){return $current_user_id;}
				return $scope;
			}
			return false;	
		
		}

		function get_activity($request){
			
			$post = json_decode($request->get_body());
			$id = $post->id;
			$cpt = $request->get_param('cpt');

			$filter = $post->filter;
			$activity = array();  // response

			if(empty($this->user_id)){
				$current_user_id = $this->set_current_user_id_by_token($request);	
			}else{
				$current_user_id = $this->user->id;
			}
			

			if(!empty($filter) && !empty($id)){

				$is_instructor = $this->check_user_is_instructor($id,$current_user_id); // instructor set
				$args = array(
					
					'page' => (!empty($filter->paged)) ? $filter->paged:1,
					'per_page' => (!empty($filter->per_page)) ? ($filter->per_page<20?$filter->per_page:20) : 20,
					'search_terms' => (!empty($filter->search_terms)) ? $filter->search_terms:false,
					'sort' => (!empty($filter->order)) ? $filter->order:false,
				);

				if($cpt == 'course'){
					$args['filter']= array(
						'primary_id' => $id,
						'object'=>'course',
						'action' => (!empty($filter->action)) ? $filter->action:false,		
						'user_id' => (!empty($filter->scope))?$this->access_activity_check($filter->scope,$is_instructor,$current_user_id):false
					);
				}else{
					$args['filter']= array(
						'secondary_id' => $id,
						'object'=>'course',
					);

					(!empty($filter->action)) ? $args['filter']['action']=$filter->action:'';
					($filter->scope == 'personal') ? $args['filter']['user_id']=$this->user->id:'';	
				}

				$activity_id = array();
				$run = bp_activity_get($args);

				if(!empty($run)){
					$data = array(
						'status' => 1,
						'message' => _x('Activity found!','Activity found!','wplms'),
						'data' => $run,
						'is_instructor'=>$is_instructor
					);
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('Activity not found!','Activity not found!','wplms'),
						'data' => []
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Not found!','Filter or Course Not found!','wplms'),
				);
			}
			$data = apply_filters('vibe_get_course_activities',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function remove_member_from_course($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$member_id = $post->member_id;

			$current_user_id = $this->set_current_user_id_by_token($request);

			if(!empty($course_id) && !empty($member_id)){ 

				$is_instructor = $this->check_user_is_instructor($course_id,$this->user); // instructor set
				if($is_instructor){
					$is_remove = $this->remove_member_from_course_by_id($member_id,$course_id);
					if($is_remove){
						$data = array(
							'status' => 1,
							'message' => _x('Member removed','Member removed','wplms'),
							'data'=>$member_id
						);
					}else{
						$data = array(
							'status' => 0,
							'message' => _x('Member not removed','Member not removed','wplms'),
							'data'=>null
						);
					}
				}else{
					$data = array(
							'status' => 0,
							'message' => _x('You are not instructor','You are not instructor','wplms'),
							'data'=>null
						);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Member Not removed','Member Not removed','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_remove_member_from_course',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function remove_member_from_course_by_id($user_id,$course_id){
			$is_user_member = bp_course_is_member($course_id, $user_id);
			if($is_user_member){
				bp_course_remove_user_from_course($user_id,$course_id);
		        $students=get_post_meta($course_id,'vibe_students',true);
		        if($students >= 1){
		          $students--;
		          update_post_meta($course_id,'vibe_students',$students);
		        }
		        return true;
			}else{
				return false;
			}
		}


		function reset_course_for_member($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$member_id = $post->member_id;

			$current_user_id = $this->set_current_user_id_by_token($request);

			if(!empty($course_id) && !empty($member_id)){
				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
				if($is_instructor){
					$is_reset = $this->reset_course_for_member_by_id((int)$member_id,(int)$course_id);
					if($is_reset){
						$data = array(
							'status' => 1,
							'message' => _x('Course reset successfull','Course reset sucessfull','wplms'),
							'data'=>$member_id
						);
					}else{
						$data = array(
							'status' => 0,
							'message' => _x('Course reset unsuccessfull','Course reset unsucessfull','wplms'),
							'data'=>null
						);
					}
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('You are not instructor','You are not instructor','wplms'),
						'data'=>null
					);
				}	
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_reset_course_for_member',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}


		function reset_course_for_member_by_id($user_id,$course_id){

			$is_user_member = bp_course_is_member($course_id, $user_id);
			// check user is member 
			if($is_user_member){
				//delete_user_meta($user_id,$course_id) // DELETE ONLY IF USER SUBSCRIPTION EXPIRED
				$status = bp_course_get_user_course_status($user_id, $course_id);
				if (isset($status) && is_numeric($status)) { // Necessary for continue course

					bp_course_update_user_course_status($user_id, $course_id, 1); // New function

					$course_curriculum = bp_course_get_curriculum($course_id);

					bp_course_update_user_progress($user_id, $course_id, 0);

					//NEw drip feed use case
					delete_user_meta($user_id, 'start_course_'.$course_id);
					do_action('wplms_student_course_reset', $course_id, $user_id);

					foreach($course_curriculum as $c) {
						if (is_numeric($c)) {
							if (bp_course_get_post_type($c) == 'quiz') {

								bp_course_remove_user_quiz_status($user_id, $c);
								bp_course_reset_quiz_retakes($c, $user_id);

								$questions = bp_course_get_quiz_questions($c, $user_id);
								if (isset($questions) && is_array($questions) && is_Array($questions['ques'])) {
									foreach($questions['ques'] as $question) {
										global $wpdb;
										if (isset($question) && $question != '' && is_numeric($question)) {
											bp_course_reset_question_marked_answer($c, $question, $user_id);
										}
									}
								}
								do_action('wplms_quiz_course_retake_reset', $c, $user_id);
							} else {
								bp_course_reset_unit($user_id, $c, $course_id);
							}
						}
					}

					/*=== Fix in 1.5 : Reset  Badges and CErtificates on Course Reset === */
					$user_badges = vibe_sanitize(get_user_meta($user_id, 'badges', false));
					$user_certifications = vibe_sanitize(get_user_meta($user_id, 'certificates', false));

					if (isset($user_badges) && is_Array($user_badges) && in_array($course_id, $user_badges)) {
						$key = array_search($course_id, $user_badges);
						unset($user_badges[$key]);
						$user_badges = array_values($user_badges);
						update_user_meta($user_id, 'badges', $user_badges);
					}

					if (isset($user_certifications) && is_Array($user_certifications) && in_array($course_id, $user_certifications)) {
						$key = array_search($course_id, $user_certifications);
						unset($user_certifications[$key]);
						$user_certifications = array_values($user_certifications);

						global $wpdb;
						$certificate_name = 'certificate_'.$course_id.'_'.$user_id;
						$attachment_id = $wpdb-> get_var($wpdb-> prepare("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_name = %s AND post_parent = %d AND post_author = %d", $certificate_name, $course_id, $user_id));
						if (is_numeric($attachment_id)) {
							wp_delete_attachment($attachment_id);
						}

						update_user_meta($user_id, 'certificates', $user_certifications);
					}
					// course_reset successfull
					do_action('wplms_course_reset', $course_id, $user_id);
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

		function get_course_user_stats($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$user_id = $post->user_id;

			if(!empty($course_id) && !empty($user_id)){
				$current_user_id = $this->set_current_user_id_by_token($request);
				$is_instructor = $this->check_user_is_instructor($course_id,$this->user); // instructor set
				if($is_instructor){
					// do here for structure
     				$stats_structure = $this->get_curriculum_stats_structure($course_id,$user_id);
     				// return $stats_structure;
     				if(empty($stats_structure['course_status'])){
			    		$data = array(
			    			'status' => 1,
							'message' => _x('User Not started the course yet','User Not started the course yet','wplms'),
							'data'=> $stats_structure
			    		);
			  		}else{
						$data = array(
							'status' => 1,
							'message' => _x('Course Stats Found For user Found','Course Stats Found For user Found','wplms'),
							'data'=>  $stats_structure
						);
					}	
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('You are not instructor','You are not instructor','wplms'),
						'data'=>null
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_get_course_user_stats',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function get_curriculum_stats_structure($course_id,$user_id){
			// do here for structure
			$course_status = bp_course_get_user_course_status($user_id,$course_id);
			$data = array();
			if(empty($course_status)){
	    		$data = array(
	    			'user_id' => $user_id,
					'course_status' => 0	
	    		);
	  		}else{
	  			global $wpdb,$bp;
      			$start = $wpdb->get_var($wpdb->prepare("SELECT date_recorded FROM {$bp->activity->table_name} WHERE type ='start_course' AND item_id=%d AND component='course' AND user_id=%d ORDER BY id DESC LIMIT 1", $course_id,$user_id));
	  			$marks=0;
		        if($course_status > 3){
		          	$marks = get_post_meta($course_id,$user_id,true);
		    		if(empty($marks)){$marks=0;};
		        }  
    			$total = 0;
    			$complete = 0;
		    	$course_curriculum = bp_course_get_curriculum($course_id);
		    	$curriculum = array();
		    	if(!empty($course_curriculum)){
	    			foreach($course_curriculum as $c){
	    				if(is_numeric($c)){
	    					$c = (int)$c;
	    					$total++;
			                $type = bp_course_get_post_type($c);
							if($type == 'unit'){
							  	if(bp_course_get_user_unit_completion_time($user_id,$c,$course_id)){
							      	$complete++;
							      	$curriculum[]=array(
							      		'id' => $c,
							      		'title'=>get_the_title($c),
							      		'type' => 'unit',
							      		'completed' => true
							      	);
							  	}else{
							  		$curriculum[]=array(
							      		'id' => $c,
							      		'title'=>get_the_title($c),
							      		'type' => 'unit',
							      		'completed' => false
							      	);
							  	}
							}
	  						if($type == 'quiz'){
	  							$marks = (int)get_post_meta($c,$user_id,true);
	  							$status = (int)bp_course_get_user_quiz_status($user_id,$c);
			                	if(!empty($status) && $status == 4){
			                    	$complete++;
			                    	$curriculum[]=array(
							      		'id' => $c,
							      		'title'=>get_the_title($c),
							      		'type' => 'quiz',
							      		'marks' => (int)$marks,
							      		'status' => $status,
							      		'completed' => true
							      	);
			                    }else{
			                        $curriculum[]=array(
							      		'id' => $c,
							      		'title'=>get_the_title($c),
							      		'type' => 'quiz',
							      		'status' => $status,
							      		'marks' => $marks,
							      		'completed' => false
							      	);
			                    }
			                }
			            }else{
			            	$curriculum[] = array(
					      		'title'=>$c,
					      		'type' => 'section',
					      	);
			            } 		
			    	}
		    	}
		      	if(empty($complete)){$complete = 0;}
				$data = array(
					'user_id' => $user_id,
					'curriculum' => $curriculum,
					'complete' => (int)$complete,
					'total' => (int)$total,
					'course_status' => (int)$course_status,
					'marks' => (int)$marks,
					'start' => !empty($start)?strtotime($start):0
				);
			}
			return apply_filters('vibe_get_curriculum_stats_structure',$data);
		}

		function complete_course_curriculum($request){

			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$user_id = $post->user_id;
			$item_id = $post->item_id; //unit_id/quiz_id/assignment_id
			if(!empty($course_id) && !empty($user_id) && !empty($item_id)){
				$current_user_id = $this->user->id;
				$is_instructor = $this->check_user_is_instructor($course_id,$this->user); // instructor set
				if($is_instructor){
					if(bp_course_is_member($course_id,$user_id)){
				       	$completed = $this->complete_course_curriculum_by_id($user_id,$course_id,$item_id);
				       	if(!empty($completed)){
					        $data = array(
					        	'status' => 1,
								'message' => sprintf(_x('%s completed for user ','Completed','wplms'),get_the_title($item_id)),
								'rtm'=>array('user_id'=>$user_id,'message'=>sprintf(__('Instructor marked unit %s complete in course %s for you.','wplms'),get_the_title($item_id),get_the_title($course_id)))
					        );
				       	}else{
				       		 $data = array(
					        	'status' => 0,
								'message' => _x('Not Completed','Not Completed','wplms'),
					        );
				       	}
				    }else{
				    	$data = array(
				    		'status' => 0,
							'message' => _x('User is not course member','User is not course member','wplms'),
							'data'=>null
				    	);
				    }
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('You are not instructor','You are not instructor','wplms'),
						'data'=>null
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_complete_course_curriculums',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function complete_course_curriculum_by_id($user_id,$course_id,$item_id){

			$time = apply_filters('wplms_force_complete_unit',time(),$item_id,$course_id,$user_id);

        	update_user_meta($user_id,$item_id,$time);
            update_post_meta($item_id,$_user_id,0);

            $post_type = bp_course_get_post_type($item_id);
			if($post_type == 'unit'){
				bp_course_update_user_unit_completion_time($user_id,$item_id,$course_id,$time);

			}else if($post_type == 'quiz'){
				bp_course_update_user_quiz_status($user_id,$item_id,4);
				do_action('wplms_quiz_course_retake_reset',$item_id,$user_id);
			}else if($post_type == 'wplms-assignment'){
				$user = get_userdata($user_id);
				$assignment_title = get_the_title($item_id);
				$args = array(
				        'comment_post_ID' => $item_id,
				        'comment_author' => $user->display_name,
				        'comment_author_email' => $user->user_email,
				        'comment_content' => $assignment_title.' - '.$user->display_name,
				        'comment_date' => current_time('mysql'),
				        'comment_approved' => 1,
				        'comment_parent' => 0,
				        'user_id' => $user_id
				);
				wp_insert_comment($args);
			}
	        $curriculum = bp_course_get_curriculum_units($course_id);
	        $per = round((100/count($curriculum)),2);
	        $progress = bp_course_get_user_progress($user_id,$course_id);
	        $new_progress = $progress+$per;
	        if($new_progress > 100){
	          $new_progress = 100;
	        }
	        bp_course_update_user_progress($user_id,$course_id,$new_progress);
	        do_action('wplms_unit_instructor_complete',$item_id,$user_id,$course_id);
	        return true;
		}

		function uncomplete_course_curriculum($request){

			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$user_id = $post->user_id;
			$item_id = $post->item_id; //unit_id/quiz_id/assignment_id
			if(!empty($course_id) && !empty($user_id) && !empty($item_id)){
				$current_user_id = $this->user->id;
				$is_instructor = $this->check_user_is_instructor($course_id,$this->user); // instructor set
				if($is_instructor){
					if(bp_course_is_member($course_id,$user_id)){
				       	// do here item uncomplete
			       		$uncompleted = $this->uncomplete_course_curriculum_by_id($user_id,$course_id,$item_id);
			       		if(!empty($uncompleted)){
					        $data = array(
					        	'status' => 1,
								'message' => sprintf(_x('Unit %s marked incomplete for student','UnCompleted','wplms'),get_the_title($item_id)),
								'rtm'=>array('user_id'=>$user_id,'message'=>sprintf(__('Instructor marked unit %s incomplete in course %s for you.','wplms'),get_the_title($item_id),get_the_title($course_id)))
				        	);
			       		}else{
			       			$data = array(
					        	'status' => 0,
								'message' => _x('Unable to mark unit incomplete.','Not UnCompleted','wplms'),
				        	);
			       		}
				    }else{
				    	$data = array(
				    		'status' => 0,
							'message' => _x('User is not course member','User is not course member','wplms'),
							'data'=>null
				    	);
				    }
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('You are not instructor','You are not instructor','wplms'),
						'data'=>null
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_complete_course_curriculums',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}


		function uncomplete_course_curriculum_by_id($user_id,$course_id,$item_id){
			bp_course_reset_unit($user_id,$item_id,$course_id);
			$curriculum=bp_course_get_curriculum_units($course_id);
			if(empty($curriculum)){$curriculum=array(1);}
			$per = round((100/count($curriculum)),2);
			$progress = bp_course_get_user_progress($user_id,$course_id);
			$new_progress = intval($progress) - $per;
			if($new_progress < 0){
				$new_progress = 0;
			}
			bp_course_update_user_progress($user_id,$course_id,$new_progress);
			$post_type = bp_course_get_post_type($item_id);
			if($post_type == 'quiz'){
				bp_course_update_user_quiz_status($user_id,$item_id,0);
          	}
          	do_action('wplms_unit_instructor_uncomplete',$item_id,$user_id,$course_id);
          	return true;
		}


		function add_member_to_course($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$members = $post->members;
			
			$current_user_id = $this->set_current_user_id_by_token($request);

			$members_added = array();	
			if(!empty($course_id) && !empty($members)){

				$is_instructor = $this->check_user_is_instructor($course_id,$this->user); // instructor set
				if($is_instructor){
					if(is_array($members) && (count($members) > 0)){
						$rtm = array();
						foreach ($members as $member_id) {
							$is_member =  bp_course_is_member($course_id, $member_id);
							if(!$is_member){
								$added = bp_course_add_user_to_course($member_id,$course_id,$duration = NULL,$force = NULL,$args=null);
								if($added){
									$members_added[] = $this->get_user_by_ID($member_id);
								}
								$rtm[]=array('user_id'=>$member_id,'message'=>sprintf(__('You are now enrolled in course %s','wplms'),get_the_title($course_id)));
							}
						}
						if(is_array($members_added) && (count($members_added) > 0)){
							$data = array(
								'status' => 1,
								'message' => _x('Members added','Members added','wplms'),
								'rtm'=>$rtm,
								'data'=>$members_added
							);
						}else{
							$data = array(
								'status' => 0,
								'message' => _x('Members not added','Members not added','wplms'),
								'data'=>null
							);
						}
					}else{
						$data = array(
							'status' => 0,
							'message' => _x('Members not send','Members not found','wplms'),
							'data'=>null
						);
					}
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('You are not instructor','You are not instructor','wplms'),
						'data'=>null
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_add_member_to_course',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function search_students_to_add($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$student_name = $post->student_name;

			$current_user_id = $this->set_current_user_id_by_token($request);

			$searched_users = array(); // response
			$length = apply_filters('vibe_search_student_to_add_string_length',4);
			if(!empty($course_id) && !empty($student_name) && (strlen($student_name)>=$length)){

				$is_instructor = $this->check_user_is_instructor($course_id,$this->user); // instructor set
				if($is_instructor){
					global $wpdb;
					$term = $student_name;
					$meta_query = apply_filters('wplms_usermeta_direct_query',"SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = 'course_status$course_id'");
					$query = "SELECT ID FROM {$wpdb->users} WHERE ( user_login LIKE '%$term%' OR user_nicename LIKE '%$term%' OR user_email LIKE '%$term%' OR user_url LIKE '%$term%' OR display_name LIKE '%$term%' ) AND ID NOT IN ( ".$meta_query.")";
					$users = $wpdb->get_results($query,ARRAY_A);
					if(!empty($users) && is_array($users)){
						foreach ($users as $user) {
							$searched_users[] = $this->get_user_by_ID($user['ID']);
						}
						$data = array(
							'status' => 1,
							'message' => _x('Users found','Users found','wplms'),
							'data'=> $searched_users
						);
					}else{
						$data = array(
							'status' => 0,
							'message' => _x('Users not found','Users not found','wplms'),
							'data'=>$searched_users
						);
					}
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('You are not instructor','You are not instructor','wplms'),
						'data'=>null
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_search_student_to_add',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function update_course_status_member($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$members = $post->members;
			$status_action = $post->status_action;
			$data =  $post->data;

			$current_user_id = $this->user->id;

			$updated_members = array();
			if(!empty($course_id) && !empty($members) && !empty($status_action)){
				if(is_array($members) && (count($members) > 0)){
					$is_instructor = $this->check_user_is_instructor($course_id,$this->user); // instructor set
					if($is_instructor){
						$rtm = array();
						foreach ($members as $member_id) {
							$updated =  $this->update_member_status_by_id((int)$member_id,$course_id,$status_action,$data);
							if($updated){
								$updated_members[] = $this->get_user_by_ID($member_id);
								$rtm[]=array('user_id'=>$member_id,'message'=>sprintf(__('Status updated for course %s','wplms'),get_the_title($course_id)));
							}
							
						}
						//actual return after all check and process
						if(is_array($updated_members) && (count($updated_members) > 0)){
							$data = array(
								'status' => 1,
								'message' => _x('Members status updated','Members status updated','wplms'),
								'data'=>$updated_members,
								'rtm'=>$rtm
							);
						}else{
							$data = array(
								'status' => 0,
								'message' => _x('Members status not updated','Members status not updated','wplms'),
								'data'=>null
							);
						}
					}else{
						$data = array(
							'status' => 0,
							'message' => _x('You are not instructor','You are not instructor','wplms'),
							'data'=>null
						);
					}
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('Members not found','Members not found','wplms'),
						'data'=>null
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_update_course_status_member',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}


		// member_id(int) , course_id , status_action , $data = marks(when finish course)
		function update_member_status_by_id($member,$course_id,$status_action,$data=NULL){
			$is_member =  bp_course_is_member($course_id, $member);
			if($is_member){
	    		if (is_numeric($member) && bp_course_get_post_type($course_id) == 'course') {
    				$status = intval($status_action);

					
	    			
	    			if (is_numeric($status)) {
	    				bp_course_update_user_course_status($member, $course_id, $status);
	    				if ($status == 4 && isset($data) && is_numeric($data)) {
	    					//print_r($course_id.','. $member.','. $data);
	    					update_post_meta($course_id, $member, $data);
	    				}
	    				return true;
	    			}else{
	    				return false;
	    			}
	    		}else{
	    			return false;
	    		}  
			}else{
				return false;
			}
		}

		function extend_course_subscription_members($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$members = $post->members;
			

			$current_user_id = $this->set_current_user_id_by_token($request);

			if(!empty($course_id) && !empty($members) && !empty($post->course_duration_parameter_type) && !empty($post->extend_amount)){
				if(is_array($members) && (count($members) > 0)){
					$is_instructor = $this->check_user_is_instructor($course_id,$this->user); // instructor set
					if($is_instructor){
						$rtm = array();
						foreach ($members as $member_id) {
							$is_member =  bp_course_is_member($course_id, $member_id);
							// check here user is a member 
							if($is_member){

								$time = get_user_meta($member_id,$course_id,true);
								if($time < time()){
									$time = time();
								}
								$exx = intval($post->course_duration_parameter_type)*intval($post->extend_amount);
								$expiry = $time + $exx;
								$updated = update_user_meta($member_id,$course_id,$expiry);

								if($updated){
									$updated_members[] = $this->get_user_by_ID($member_id);
									$rtm[]=array('user_id'=>$member_id,'message'=>sprintf(__('Subscription cahnged course %s','wplms'),get_the_title($course_id)));
								}
							}
						}
						//actual return after all check and process
						if(is_array($updated_members) && (count($updated_members) > 0)){
							$data = array(
								'status' => 1,
								'message' => sprintf(_x('Subscription time extended for users %d','Members time extended','wplms'),count($updated_members)),
								'data'=>$updated_members,
								'rtm'=>$rtm
							);
						}else{
							$data = array(
								'status' => 0,
								'message' => _x('Members time not extended','Members time not extended','wplms'),
								'data'=>null
							);
						}
					}else{
						$data = array(
							'status' => 0,
							'message' => _x('You are not instructor','You are not instructor','wplms'),
							'data'=>null
						);
					}
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('Members not found','Members not found','wplms'),
						'data'=>null
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_extend_course_subscription_members',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}


		function assign_badge_course_certificate($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$members = $post->members;
			$assign_action = $post->assign_action;

			$current_user_id = $this->set_current_user_id_by_token($request);

			if(!empty($course_id)&&!empty($members)&&!empty($assign_action)){
				if(is_array($members) && (count($members) > 0)){

					$is_instructor = $this->check_user_is_instructor($course_id,$this->user); // instructor set
					if($is_instructor){
						$rtm = array();
						$action_text = __('Action','wplms');
						switch($assign_action){
							case 'add_badge':
								$action_text=__('Badge awarded','wplms');
							break;
							case 'add_certificate':
								$action_text=__('Certificate awarded','wplms');
							break; 
							case 'remove_badge':
								$action_text=__('Badge removed','wplms');
							break;
							case 'remove_certificate':
								$action_text=__('Certificate Removed','wplms');
							break;
						}
						foreach ($members as $member_id) {
							$updated =  $this->assign_badge_course_certificate_by_id((int)$member_id,(int)$course_id,$assign_action);
							if($updated){
								$updated_members[] = $this->get_user_by_ID($member_id);
								$rtm[]=array('user_id'=>$member_id,'message'=>sprintf(__('%s for course %s','wplms'),$action_text,get_the_title($course_id)));
							}
							
						}
						//actual return after all check and process
						if(is_array($updated_members) && (count($updated_members) > 0)){
							$data = array(
								'status' => 1,
								'message' => sprintf(_x('%s to %s members in course','bulk action','wplms'),$action_text,count($updated_members),get_the_title($course_id)),
								'data'=>$updated_members,
								'rtm'=>$rtm
							);
						}else{
							$data = array(
								'status' => 0,
								'message' => _x('Not Assigned','Not Assigned','wplms'),
								'data'=>null
							);
						}
					}else{
						$data = array(
							'status' => 0,
							'message' => _x('You are not instructor','You are not instructor','wplms'),
							'data'=>null
						);
					}
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('Members not found','Members not found','wplms'),
						'data'=>null
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_assign_badge_course_certificate',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function assign_badge_course_certificate_by_id($member,$course_id,$assign_action){
			$is_member =  bp_course_is_member($course_id, $member);
			if($is_member){
	          	if (is_numeric($member) && bp_course_get_post_type($course_id) == 'course') {
	          		switch ($assign_action) {
	          			case 'add_badge':
	          				$badges = vibe_sanitize(get_user_meta($member, 'badges', false));
	          				if (isset($badges) && is_array($badges)) {
	          					if (!in_array($course_id, $badges))
	          						$badges[] = $course_id;
	          				} else {
	          					$badges = array($course_id);
	          				}
	          				update_user_meta($member, 'badges', $badges);
	          				break;
	          			case 'add_certificate':
	          				$certificates = vibe_sanitize(get_user_meta($member, 'certificates', false));
	          				if (isset($certificates) && is_array($certificates)) {
	          					if (!in_array($course_id, $certificates))
	          						$certificates[] = $course_id;
	          				} else {
	          					$certificates = array($course_id);
	          				}
	          				update_user_meta($member, 'certificates', $certificates);
	          				break;
	          			case 'remove_badge':
	          				$badges = vibe_sanitize(get_user_meta($member, 'badges', false));
	          				if (isset($badges) && is_array($badges)) {
	          					$k = array_search($course_id, $badges);
	          					if (isset($k)) {
	          						unset($badges[$k]);
	          					}
	          					$badges = array_values($badges);
	          					update_user_meta($member, 'badges', $badges);
	          				}
	          				break;
	          			case 'remove_certificate':
	          				$certificates = vibe_sanitize(get_user_meta($member, 'certificates', false));
	          				$k = array_search($course_id, $certificates);
	          				if (isset($k)) {
	          					unset($certificates[$k]);
	          					global $wpdb;
	          					$user_id = $member;
	          					$certificate_name = 'certificate_'.$course_id.'_'.$user_id;
	          					$attachment_id = $wpdb-> get_var($wpdb-> prepare("SELECT ID FROM {$wpdb->posts} WHERE post_type = 'attachment' AND post_name = %s AND post_parent = %d AND post_author = %d", $certificate_name, $course_id, $user_id));
	          					if (is_numeric($attachment_id)) {
	          						wp_delete_attachment($attachment_id);
	          					}
	          				}
	          				$certificates = array_values($certificates);
	          				update_user_meta($member, 'certificates', $certificates);
	          				break;
	          			default:
	          					return false;
	          				break;
	          		}
	          		return true;
	          	}else{
		          	return false;
	          	}  
			}else{
				return false;
			}
		}

		function get_admin_page_tabs($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$current_user_id = $this->set_current_user_id_by_token($request);
			if(!empty($course_id)){
				$data = array(
					'status' => 1,
					'message' => _x('Tabs found','Tabs found','wplms'),
					'data'=>$this->get_instructor_admin_tabs($course_id) 
				);
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_get_admin_page_tabs',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function get_submission_tabs($request){
			$post = json_decode($request->get_body());

			$course_id = $post->course_id;

			if(!empty($course_id)){
				

				$tabs =  array(
					array(
						'value'=>'course',
						'label'=>_x('Course','api','wplms'),
						'status'=>array(
							3 => _x('Pending evaluation','submission status','wplms'),
                         	4 => _x('Evaluation complete','submission status','wplms'),
						)
					)
				);

				$quizzes = bp_course_get_curriculum_quizes($course_id);
				global $wpdb;
				if(!empty($quizzes)){
					$results = $wpdb->get_results("SELECT ID,post_title FROM {$wpdb->posts} WHERE ID IN (".implode($quizzes,',').") AND post_type = 'quiz'");
					$quiz = array();
					if(!empty($results)){
						foreach($results as $result){
							$quiz[]=array('value'=>$result->ID,'label'=>$result->post_title);
						}
					}
					$tabs[] =array(
							'value'=>'quiz',
							'label'=>_x('Quiz','api','wplms'),
							'elements'=>$quiz,
							'status'=>array(
								3 => _x('Pending evaluation','submission status','wplms'),
	                         	4 => _x('Evaluation complete','submission status','wplms'),
							)

						);
				}
				if(class_exists('WPLMS_Assignments')){
					$results = $wpdb->get_results("SELECT ID,post_title FROM {$wpdb->posts} as p INNER JOIN {$wpdb->postmeta} as m ON m.post_id = p.ID 
						WHERE p.post_type = 'wplms-assignment' AND m.meta_key= 'vibe_assignment_course' AND m.meta_value = $course_id");

					$assignments = array();
					if(!empty($results)){
						foreach($results as $result){
							$assignments[]=array('value'=>$result->ID,'label'=>$result->post_title);
						}
					
						$tabs[] = array(
							'value'=>'assignment',
							'label'=>_x('Assignment','api','wplms'),
							'elements'=>$assignments,
							'status'=>array(
								0 => _x('Pending evaluation','submission status','wplms'),
	                         	1 => _x('Evaluation complete','submission status','wplms'),
	                        	2 => _x('Unsubmitted','submission status','wplms')
							)
						);
					}
				}
				$apply = get_post_meta($course_id,'vibe_course_apply',true);
				if(!empty($apply)){
					$results = $wpdb->get_results(apply_filters('wplms_usermeta_direct_query',$wpdb->prepare("SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = %s AND meta_value = %d",'apply_course'.$course_id,$course_id)));
					$users = array();
					if(!empty($results)){
						foreach ($results as $key => $result) {
							$users[] = $this->get_user_by_ID($result->user_id);
						}
					}
					$tabs[] = array(
						'value'=>'applications',
						'label'=>_x('Applications','api','wplms'),
						'elements' => $users,
						
					);
				}
				

				$tabs = apply_filters('bp_course_api_get_instructor_submission_tabs',$tabs,$course_id);
					$data = array(
						'status' => 1,
						'message' => _x('Tabs found','course submissions api call','wplms'),
						'data'=>array(
							'tabs' => $tabs,
						)
						
					);
				
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_get_submission_page_tabs',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		
		function get_submissions($request){

			$body = json_decode($request->get_body(),true);
			if(empty($body['parentId'])){
				$course_id = $body['parentId'];
			}
			
			$id = $body['id'];
			$type = $body['type'];
			$status = $body['status'];
			$paged= $body['paged'];
			$per_page = 20;
			$parentId = $body['parentId'];
			$s = $body['s'];
			
			$orderby = 'ORDER BY meta_id DESC';
			$join = '';
			$where = '';

			if(!empty($body['orderby'])){
				switch ($body['orderby']) {
					case 'alphabetical':
						$join .= ' INNER JOIN {$wpdb->users} as u ON m.user_id = u.ID ';
						$orderby = 'ORDER BY a.display_name';
					break;
				}
				
			}else{
				$orderby = 'ORDER BY m.umeta_id';
			}
			if(!empty($body['order'])){
				$orderby .= ' '.$body['order'];
			}else{
				$orderby .= ' DESC';
			}
			if(!empty($s)){
				$join .= ' INNER JOIN {$wpdb->users} as u ON m.user_id = u.ID ';
				$where .= ' AND ( u.display_name LIKE "%'.$s.'%" OR u.user_email LIKE "%'.$s.'%" OR u.user_user_login LIKE "%'.$s.'%")';
			}
			global $wpdb;
			if(!empty($id) && !empty($type) && isset($status)){
				switch($type){
					case 'course':
						global $wpdb;
				        $q = $wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS m.user_id as user_id FROM {$wpdb->usermeta} as m $join where m.meta_key = %s AND m.meta_value = %d $where $orderby LIMIT %d,%d",'course_status'.$id,$status,($paged-1)*$per_page,$per_page);
				        
				        $members = $wpdb->get_results( apply_filters('wplms_usermeta_direct_query',$q), ARRAY_A);
				        $total = $wpdb->get_var("SELECT FOUND_ROWS();");
					break;
					case 'quiz':
						$q = $wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS m.user_id as user_id FROM {$wpdb->usermeta} as m $join where m.meta_key = %s AND m.meta_value = %d $where $orderby LIMIT %d,%d",'quiz_status'.$id,$status,($paged-1)*$per_page,$per_page);
				         $members = $wpdb->get_results( apply_filters('wplms_usermeta_direct_query',$q), ARRAY_A);
				         $total = $wpdb->get_var("SELECT FOUND_ROWS();");
					break;
					case 'assignment':


				        $q = $wpdb->prepare("SELECT SQL_CALC_FOUND_ROWS m.meta_key as user_id FROM {$wpdb->postmeta} as m WHERE m.post_id = %d
		                  AND m.meta_value = 0
		                  AND m.meta_key REGEXP '^[0-9]+$' $where LIMIT %d,%d",$id,($paged-1)*$per_page,$per_page);
				        $total = $wpdb->get_var("SELECT FOUND_ROWS();");
				        $members = $wpdb->get_results( apply_filters('wplms_usermeta_direct_query',$q), ARRAY_A);
				     
					break;
					default:
						$members = apply_filters('wplms_submission_members',array(),$body);
						$total = apply_filters('wplms_submission_total_members',0,$body);
					break;
				}

				if(!empty($members)){
					$users = array();

					foreach ($members as $member) {

						$users[] = $this->get_user_by_ID($member['user_id']); 
					}
					$data = array(
						'status' => 1,
						'message' => _x('Members found','Members found','wplms'),
						'data'=>$users,
						'total'=>$total
					);
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('Members not found','Members not found','wplms'),
						'data'=>null
					);
				}
			
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('wplms_get_submissions',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}


		function reset_submission($request){

			$post = json_decode($request->get_body());
			
			$course_id = $post->course_id;

			if(empty($course_id) && !empty($post->parentId)){
				$course_id = $post->parentId;
			}
			$quiz_id = $post->quiz_id;
			if(empty($quiz_id) && !empty($post->id)){
				$quiz_id = $post->id;
			}
			$user_id = $post->user_id;

			$per_page = (!empty($filter->per_page)) ? ($filter->per_page<20?$filter->per_page:20) : 20;
			$paged_temp = (!empty($filter->paged)) ? ($filter->paged<20?$filter->paged:1) : 1;
			$paged = $per_page*($paged_temp-1);

			$members = array();
			$current_user_id = $this->user->id;

			if(!empty($course_id) && !empty($quiz_id)&& !empty($user_id)){
				
				//check if quiz is in the course or not
				if(get_post_type($quiz_id)=='wplms-assignment'){
					$this->remove_user_from_item($user_id, $quiz_id);
				}
				bp_course_remove_user_quiz_status($user_id, $quiz_id);
				bp_course_reset_quiz_retakes($quiz_id, $user_id);
				$questions = bp_course_get_quiz_questions($quiz_id, $user_id);
				if (!empty($questions) && is_array($questions['ques'])) {
					foreach($questions['ques'] as $question) {
						bp_course_reset_question_marked_answer($quiz_id, $question, $user_id);
					}
				}
				delete_user_meta($user_id, 'quiz_questions'.$quiz_id);
				do_action('wplms_quiz_reset', $quiz_id, $user_id);
				$data = array(
					'status' => 1,
					'message' => _x('Reset completed','Quiz reset completed','wplms'),
					'data'=>$quiz_id
				);
				
				
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_course_quiz_reset',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		



		function get_submission_structure($request){
			
			$body = json_decode($request->get_body(),true);

			if($body['type'] == 'quiz'){

				$course_id = $body['parentId'];
				$quiz_id = $body['id'];
				$user_id = $body['user_id'];
				

				if(!empty($quiz_id) && !empty($user_id)){
					if(!empty($course_id)){
						$is_instructor = $this->check_user_is_instructor($course_id,$this->user); 
					}else{
						$is_instructor = $this->check_user_is_instructor($quiz_id,$this->user); 
					}
					
					if($is_instructor){
						$structure = $this->get_quiz_structure($course_id,$quiz_id,$user_id);
				        $data = array(
							'status' => 1,
							'message' => _x('Structure Found','Structure Found','wplms'),
							'data'=>  $structure
						);
					}else{
						$data = array(
							'status' => 0,
							'message' => _x('You are not instructor','You are not instructor','wplms'),
							'data'=>null
						);
					}
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('Data missing','Data missing','wplms'),
						'data'=>null
					);
				}
			}

			if($body['type'] == 'assignment'){

				$course_id = $body['parentId'];
				$assignment_id = $body['id'];
				$user_id = $body['user_id'];
				

				if(!empty($assignment_id) && !empty($user_id)){
					if(!empty($course_id)){
						$is_instructor = $this->check_user_is_instructor($course_id,$this->user); 
					}else{
						$is_instructor = $this->check_user_is_instructor($assignment_id,$this->user); 
					}
					
					if($is_instructor){
						$structure = $this->get_assignment_structure($course_id,$assignment_id,$user_id);
				        $data = array(
							'status' => 1,
							'message' => _x('Structure Found','Structure Found','wplms'),
							'data'=>  $structure
						);
					}else{
						$data = array(
							'status' => 0,
							'message' => _x('You are not instructor','You are not instructor','wplms'),
							'data'=>null
						);
					}
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('Data missing','Data missing','wplms'),
						'data'=>null
					);
				}
			}

			if($body['type'] == 'course'){

				$course_id = $body['id'];
				$user_id = $body['user_id'];


				if(!empty($course_id) && !empty($user_id)){
					$is_instructor = $this->check_user_is_instructor($course_id,$this->user); // instructor set
					if($is_instructor){
						$sum = 0;
						$max_sum = 0;
						$curriculum_data = array();
			       		$curriculum= bp_course_get_curriculum($course_id);
			       		$existing_marks = get_post_meta($course_id,$user_id,true); 
				        foreach($curriculum as $c){
					        if(is_numeric($c)){
					            if(bp_course_get_post_type($c) == 'quiz'){
					                $status = get_user_meta($user_id,$c,true);   // means pending or done
					                $marks=(int)get_post_meta($c,$user_id,true);   // fetch marks
					                $sum += intval($marks);
					                $qmax = bp_course_get_quiz_questions($c,$user_id);
					                if($qmax && $qmax['marks']){$max=array_sum($qmax['marks']);}
					                $max_sum +=$max;
					                
					                $curriculum_data[] = array(
						            	'title'=> get_the_title($c),
						            	'status' => (isset($status) && $status !='')? true:false,
						            	'marks'=> $marks,
						            	'max' => $max,
						            	'type' => 'quiz',
						            	'icon'=>wplms_get_element_icon(wplms_get_element_type($c,'quiz')),
						            	'id' => (int)$c
					       			);
					            }elseif(bp_course_get_post_type($c) == 'wplms-assignment'){
					            	$status = get_user_meta($user_id,$c,true); 
					                $curriculum_data[] = array(
					                	'id' => (int)$c,
						            	'title'=> get_the_title($c),
						            	'status' => (!empty($status))? true:false,
						            	'type' => 'assignment',
						            	'icon'=>wplms_get_element_icon(wplms_get_element_type($c,'assignment')),
					       			);
					            }else{ 
					                $status = bp_course_get_user_unit_completion_time($user_id,$c,$course_id);   // means pending or done
					                $curriculum_data[] = array(
					                	'id' => (int)$c,
						            	'title'=> get_the_title($c),
						            	'status' => (isset($status) && $status !='')? true:false,
						            	'type' => 'unit',
						            	'icon'=>wplms_get_element_icon(wplms_get_element_type($c,'unit')),
					       			);
					            } 

					        }

				        }
				        

				        $structure = array(
				        	'user_id' => $user_id,
				        	'total_get' => $sum,
				        	'total_marks' => $max_sum,
				        	'curriculum_data' => $curriculum_data,
				        	'marks' => (int)get_post_meta($course_id,$user_id,true)
				        );

				        $data = array(
							'status' => 1,
							'message' => _x('Structure Found','Structure Found','wplms'),
							'data'=>  $structure
						);

					}else{
						$data = array(
							'status' => 0,
							'message' => _x('You are not instructor','You are not instructor','wplms'),
							'data'=>null
						);
					}
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('Data missing','Data missing','wplms'),
						'data'=>null
					);
				}
				$data = apply_filters('vibe_get_course_structure',$data,$request);
			}
			$data = apply_filters('vibe_get_course_structure',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function get_assignment_structure($course_id,$assignment_id,$user_id){
			$assignment_id=intval($assignment_id);
			$user_id=intval($user_id);
			$structure = array();
			$instructor_id = get_post_field('post_author',$assignment_id);
            $assignment_post=get_post($assignment_id);
            
            $structure['content'] = apply_filters('the_content',$assignment_post->post_content);

            $answers=get_comments(array(
              'post_id' => $assignment_id,
              'status' => 'approve',
              'number' => 1,
              'user_id' => $user_id
              ));

            //$type=get_post_meta($assignment_id,'vibe_assignment_submission_type',true);

            if(isset($answers) && is_array($answers) && count($answers)){
                $answer = end($answers);
                $structure['comment_ID'] = $answer->comment_ID;
                $structure['comment_content'] =  nl2br($answer->comment_content);
                $attachment_id=get_comment_meta($answer->comment_ID, 'attachmentId',true);
                if(!empty($attachment_id)){
                	$structure['attachments'] =array();
                  	if(is_array($attachment_id)){
                    	foreach($attachment_id as $attachid){
                    		$structure['attachments'][] = array('id'=>$attachid,'url'=>wp_get_attachment_url($attachid));
                    	}
                  	}else{
                  		$structure['attachments'][] = array('id'=>$attachment_id,'url'=>wp_get_attachment_url($attachment_id));
                  	}
                }
            }
            $type =  get_post_meta($assignment_id,'vibe_assignment_submission_type',true);

            $structure['total_marks'] =  get_post_meta($assignment_id,'vibe_assignment_marks',true);
            $structure['user_marks'] = $structure['marks']  = get_post_meta($assignment_id,$user_id,true);
            $course_id = get_post_meta($assignment_id,'vibe_assignment_course',true);
         
            
            if(class_exists('WPLMS_Assignments') &&  $type == 'upload'){
				$assignments = WPLMS_Assignments::init();  
				$structure['permit_mime']=$assignments->getAllowedMimeTypes($assignment_id);
				$structure['permit_size']=$assignments->getmaxium_upload_file_size($assignment_id) * 1048576;
			}
           
            return $structure;		
		}

		function get_quiz_structure($course_id,$quiz_id,$user_id){

			$quiz_id=intval($quiz_id);
			$user_id=intval($user_id);
			
			$structure = array();
	  		$results = $questions = array();
			$activity_id =0;
			global $wpdb,$bp;
			if(function_exists('bp_is_active') && bp_is_active('activity')){
				$evaluate_activity_date = 0 ; $start_activity_date = 0;
				$evaluate_activity = $wpdb->get_results($wpdb->prepare("
					SELECT id,date_recorded
					FROM {$bp->activity->table_name}
					WHERE secondary_item_id = %d
					AND type = 'quiz_evaluated'
					AND user_id = %d
					ORDER BY date_recorded DESC
					LIMIT 0,1
				  	",$quiz_id,$user_id));
	  
				
				if(!empty($evaluate_activity[0])){
		            $evaluate_activity_date = $evaluate_activity[0]->date_recorded;
		        }

		        $start_activity = $wpdb->get_results($wpdb->prepare( "
		                        SELECT id,date_recorded 
		                        FROM {$bp->activity->table_name}
		                        WHERE secondary_item_id = %d
		                      AND type = 'start_quiz'
		                      AND user_id = %d
		                      ORDER BY date_recorded DESC
		                      LIMIT 0,1
		                    " ,$quiz_id,$user_id));
		        if(!empty($start_activity[0])){
		            $start_activity_date = $start_activity[0]->date_recorded;
		        }
		        if(!empty($evaluate_activity_date) && !empty($start_activity_date) && strtotime($start_activity_date) <= strtotime($evaluate_activity_date)){

		            $activity_id = $evaluate_activity[0]->id;
		        }else{
		            $activity_id = 'no_activity';
		        }
				$results = bp_course_get_quiz_results_meta($quiz_id,$user_id,$activity_id);
				if(!is_array($results)){
					$results = unserialize($results);
				}
			}
			if(!empty($results)){
				$sum=$max_sum=0;
          		foreach($results as $question_key=>$question){
	            	if(isset($question) && $question && is_numeric($question_key)){
	            		$temp = array(
	            			'question_id' =>  isset($question_key)?$question_key:0,
	            			'content' =>  isset($question['content'])?$question['content']:'',
	            			'explaination' =>  isset($question['explaination'])?$question['explaination']:'',
	            			'marked_answer' =>  isset($question['marked_answer'])?$question['marked_answer']:'',
	            			'marks' => isset($question['marks'])?$question['marks']:0,
	            			'max_marks' => isset($question['max_marks'])?$question['max_marks']:0,
	            			'correct_answer' => isset($question['correct_answer'])?$question['correct_answer']:'',
	            			'type' => isset($question['type'])?$question['type']:''
	            		);
	            		$structure['questions'][]=$temp;
	            	}
				}
				//instructor remark 
				$instructor_remarks = get_user_meta($user_id,'quiz_remarks'.$quiz_id,true);
				$structure['instructor_remarks']=(!empty($instructor_remarks))?$instructor_remarks:'';

				$structure['activity_id']=isset($activity_id)?$activity_id:0;
				$structure['user_marks']=isset($results['user_marks'])?$results['user_marks']:0;
				$structure['total_marks']=isset($results['total_marks'])?$results['total_marks']:0;

			}
			// return $results;		
	  		return $structure;		
		}

		function evaluate_quiz_question($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$user_id = $post->user_id;
			$quiz_id = $post->quiz_id;
			$activity_id = $post->activity_id;
			$question_id = $post->question_id;
			$marks = $post->marks;

			$current_user_id = $this->set_current_user_id_by_token($request);
			if(!empty($course_id) && !empty($user_id) && !empty($quiz_id)  && !empty($activity_id) && isset($post->question_id) && !empty($marks)){
				$current_user_id = $this->set_current_user_id_by_token($request);
				$is_instructor = $this->check_user_is_instructor($course_id,$this->user); // instructor set
				if($is_instructor){
			       	// do here quiz evaluation
					// from function give_marks(){
					if(!empty($activity_id)){
						if(!empty($quiz_id) && !empty($user_id)){
							$results = bp_course_get_quiz_results_meta($quiz_id,$user_id,$activity_id);
							if(!empty($results)){
								if(!is_array($results)){
									$results = unserialize($results);
								}
								if(!empty($results[$question_id])){
								    $results[$question_id]['marks'] = $marks;
								    if(isset($results[$question_id]['raw']) && !empty($results[$question_id]['raw'])){
						                if(is_object($results[$question_id]['raw'])){
						                  $results[$question_id]['raw']->user_marks =  $marks;
						                  $results[$question_id]['raw']->status =  1;
						                }else{
						                  $results[$question_id]['raw']['user_marks'] =  $marks;
						                  $results[$question_id]['raw']['status'] =  1;
						                }
						                
						            }

								    bp_course_generate_user_result($quiz_id,$user_id,$results,$activity_id);
								}
							}
						}
					}else{
						if(is_numeric($question_id) && is_numeric($marks)){
							update_comment_meta( $question_id, 'marks',$marks);
						}
					}
					// end evaluation

			       	$data = array(
			       		'status' => 1,
			       		'message' => _x('Marks Changed','Marks Changed','wplms'),
			       		'data' => $post
			       	);
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('You are not instructor','You are not instructor','wplms'),
						'data'=>null
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_set_complete_course_marks',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}


		function set_complete_assignment_marks($request){
			$post = json_decode($request->get_body());
			$assignment_id = $post->id;
			$user_id = $post->user_id;
			$marks = $post->marks;
			$answer_id = $post->comment_ID;
			$remarks = $post->instructor_remarks;
			if(!empty($user_id) && !empty($marks)){
				$current_user_id = $this->set_current_user_id_by_token($request);
				$value=$marks;
				
				if(is_numeric($answer_id) && is_numeric($value)){
				  update_comment_meta( $answer_id, 'marks',$value);
			      update_post_meta($assignment_id,$user_id,$value);

			      $assignment_duration=get_post_meta($assignment_id,'vibe_assignment_duration',true);
			      $assignment_duration_parameter = apply_filters('vibe_assignment_duration_parameter',86400,$assignment_id);
			      $time = time() - ($assignment_duration*$assignment_duration_parameter);
			      
			      update_user_meta($user_id,$assignment_id,$time);
			      
			      $max_marks = get_post_meta($assignment_id,'vibe_assignment_marks',true);
			      $marks = $value;
			      $message = sprintf(_x('You\'ve obtained %s out of %s in Assignment : %s Check Results %s. %s Additional Remarks from Instructor %s %s %s','wplms-assignments'),$value,$max_marks,'<a href="'.get_permalink($assignment_id).'">'.get_the_title($assignment_id).'</a>
			      <a href="'.bp_core_get_user_domain( $user_id).'course/course-results/?action='.$assignment_id.'">','</a>',
			      '<h3>','</h3>','<br />',$remarks);
			      $message_id='';
			      if(function_exists('messages_new_message')){
			        $message_id=messages_new_message( array('sender_id' => $current_user_id, 'subject' => __('Assignment results available','wplms-assignments'), 'content' => $message,   'recipients' => $user_id) );
			      }


			      	$args = array(
					    'status' => 'approve', 
					    'number' => '1',
					    'parent' => $answer_id,
					    'user_id'=>$current_user_id,
					    'type'=>'remarks',
					);
					$comments = get_comments($args);
					if(!empty($comments) && count($comments)){
						$com_id = $comments[0]->comment_ID;
					}
					if(!empty($com_id)){
						$_comment = get_comment($com_id,ARRAY_A);
						$_comment['comment_content'] = $remarks;
						$_comment['comment_type'] = 'remarks';
						wp_update_comment($_comment);

					}else{
						$_comment = array(
							'comment_parent' => $answer_id,
							'comment_content'=>$remarks,
							'comment_approved'=>1,
							'comment_author'=>bp_core_get_user_displayname($current_user_id),
							'comment_type'=>'remarks',
							'user_id' => $current_user_id,
						);
						wp_insert_comment($_comment);
					}
			      	do_action('wplms_evaluate_assignment',$assignment_id,$marks,$user_id,$max_marks,$message_id);
			      	$data = array(
						'status' => 1,
						'message' => _x('Assigment Completed','Assigment Completed','wplms'),
						'data'=>array(
							'course_id' =>$assignment_id,
							'user_id' =>$user_id
						)
					);
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('User Comment Data missing','Data missing','wplms'),
						'data'=>null
					);
				}
				
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_set_complete_assignment_marks',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function set_complete_course_marks($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$user_id = $post->user_id;
			$marks = $post->marks;

			

			if(!empty($course_id) && !empty($user_id) && !empty($marks)){
				$current_user_id = $this->set_current_user_id_by_token($request);
				$is_instructor = $this->check_user_is_instructor($course_id,$this->user); // instructor set
				if($is_instructor){
			        $badge_per = get_post_meta($course_id, 'vibe_course_badge_percentage', true);
			        $passing_per = get_post_meta($course_id, 'vibe_course_passing_percentage', true);
			        $badge_filter = 0;
			        if (isset($badge_per) && $badge_per && $marks >= $badge_per){
			        	$badge_filter = 1;
			        }
			        $badge_filter = apply_filters('wplms_course_student_badge_check', $badge_filter, $course_id, $user_id, $marks, $badge_per);
			        if ($badge_filter) {
			        	$badges = vibe_sanitize(get_user_meta($user_id, 'badges', false));
			        	if (is_array($badges)) {
			        		if (!in_array($course_id, $badges))
			        			$badges[] = $course_id;
			        	} else {
			        		$badges = array();
			        		$badges[] = $course_id;
			        	}
			        	update_user_meta($user_id, 'badges', $badges);
			        	do_action('wplms_badge_earned', $course_id, $badges, $user_id, $badge_filter);
			        }

			        $passing_filter = 0;
			        if (isset($passing_per) && $passing_per && $marks >= $passing_per){
			        	$passing_filter = 1;
			        }
			        $passing_filter = apply_filters('wplms_course_student_certificate_check', $passing_filter, $course_id, $user_id, $marks, $passing_per);
			        if ($passing_filter) {
			        	$pass = vibe_sanitize(get_user_meta($user_id, 'certificates', false));
			        	if (is_array($pass)) {
			        		if (!in_array($course_id, $pass))
			        			$pass[] = $course_id;
			        	} else {
			        		$pass = array();
			        		$pass[] = $course_id;
			        	}
			        	update_user_meta($user_id, 'certificates', $pass);
			        	do_action('wplms_certificate_earned', $course_id, $pass, $user_id, $passing_filter);
			        }
			        update_post_meta($course_id, $user_id, $marks);
			        $course_end_status = apply_filters('wplms_course_status', 4);
			        update_user_meta($user_id, 'course_status'.$course_id, $course_end_status); //EXCEPTION
			        do_action('wplms_evaluate_course', $course_id, $marks, $user_id);

			        $data = array(
						'status' => 1,
						'message' => _x('Course Completed','Course Completed','wplms'),
						'data'=>array(
							'course_id' =>$course_id,
							'user_id' =>$user_id
						)
					);
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('You are not instructor','You are not instructor','wplms'),
						'data'=>null
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_set_complete_course_marks',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function update_user_marks_remarks($request){
			$post = json_decode($request->get_body());
			$course_id = (int)$post->course_id;
			$quiz_id = (int)$post->quiz_id;
			$user_id = (int)$post->user_id;
			$marks = (int)$post->user_marks;
			$instructor_remarks = $post->instructor_remarks;
			$activity = $post->activity;

			if(!empty($course_id) && !empty($user_id) && !empty($quiz_id) && isset($marks) && isset($instructor_remarks)){
				$current_user_id = $this->set_current_user_id_by_token($request);
				$is_instructor = $this->check_user_is_instructor($course_id,$this->user); // instructor set
				if($is_instructor){
					// from function save_quiz_marks(){
					$questions = bp_course_get_quiz_questions($quiz_id,$user_id);
					// $max = 0;
					if(!empty($questions) && is_array($questions)){
						$max= array_sum($questions['marks']);
					}
					update_post_meta( $quiz_id, $user_id,$marks);
					bp_course_update_user_quiz_status($user_id,$quiz_id,4);
					bp_course_set_quiz_remarks($quiz_id,$user_id,$instructor_remarks);
					do_action('wplms_evaluate_quiz',$quiz_id,$marks,$user_id,$max);
					if(!empty($activity)){
						global $wpdb,$bp;
						$activity_id = $wpdb->get_var($wpdb->prepare( "
						            SELECT id
						            FROM {$bp->activity->table_name}
						            WHERE secondary_item_id = %d
						          AND type = 'quiz_evaluated'
						          AND user_id = %d
						          ORDER BY date_recorded DESC
						          LIMIT 0,1
						        " ,$quiz_id,$user_id));
						if($activity == 'no_activity'){
							$results = get_user_meta($user_id,'manual_intermediate_results'.$quiz_id,true);
							if(!empty($results)){
								bp_course_generate_user_result($quiz_id,$user_id,$results,$activity_id);
							}
						}else{
							$results = bp_course_get_quiz_results_meta($quiz_id,$user_id,$activity);
							if(!is_array($results)){
								$results = unserialize($results);
							}
							if(!empty($results)){
								bp_course_generate_user_result($quiz_id,$user_id,$results,$activity_id);
							}
						}
						$data = array(
							'status' => 1,
							'message' => _x('Quiz marks and remarks updated','Quiz marks and remarks updated','wplms'),
							'data'=>array(
								'course_id' =>$course_id,
								'user_id' =>$user_id,
								'quiz_id' =>$quiz_id,
								'user_marks' => $user_marks,
								'instructor_remarks' => $instructor_remarks,
								'activity' => $activity
							)
						);
					}else{
						$data = array(
							'status' => 0,
							'message' => _x('Quiz marks and remarks not updated','Quiz marks and remarks not updated','wplms'),
							'data'=>array(
								'course_id' =>$course_id,
								'user_id' =>$user_id,
								'quiz_id' =>$quiz_id,
								'user_marks' => $user_marks,
								'instructor_remarks' => $instructor_remarks,
								'activity' => $activity
							)
						);
					}
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('You are not instructor','You are not instructor','wplms'),
						'data'=>null
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Data missing','Data missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_update_user_marks_remarks',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function get_units_discussion($request){
			$post = json_decode($request->get_body());
			$instructor_id = $this->set_current_user_id_by_token($request);
			$filter = $post->filter;

			if(!empty($instructor_id)){
				$uncom = array();
				if(!empty($filter)){
					$filternew = array(
						'paged'=>$filter->paged ? $filter->paged: 1,
						'per_page'=>($filter->per_page && $filter->per_page<=20 )? $filter->per_page: 20
					);
					//computing offset
					$offset = $filternew['per_page']*($filternew['paged']-1);

					global $wpdb;
					// first fetching user's unit ids then selected last comment(nesting)
					$query = apply_filters('get_units_discussion_query',
								$wpdb->prepare("SELECT comment_post_ID as unit_id, MAX(comment_ID) as comment_ID from wp_comments as com 
									WHERE com.comment_parent = 0 AND com.comment_post_ID IN 
									(SELECT pos.ID FROM wp_posts as pos WHERE pos.post_author = %d AND  pos.post_type = 'unit' AND pos.post_status = 'publish')         
									GROUP by com.comment_post_ID
									LIMIT %d OFFSET %d
								",$instructor_id,$filternew['per_page'],$offset
								)
							,$request);
					$qds = $wpdb->get_results($query,ARRAY_A);
					if(!empty($qds) && is_array($qds)){
						foreach ($qds as $key => $value) {
							$uncom[] = array(
								'unit' => get_post(intval($value['unit_id'])),
								'comment' => get_comment( intval($value['comment_ID']) )
							);
						}
					}
				}
				if(!empty($uncom)){
					$data = array(
						'status' => 1,
						'message' => _x('Units last comment found','Unit last comment found','wplms'),
						'data'=>$uncom
					);
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('Units last comment not found','Unit last comment not found','wplms'),
						'data'=>[]
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('User not matched','User not matched','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_get_units_discussion',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function get_units_discussion_page($request){
			$post = json_decode($request->get_body());
			$unit_id = $post->unit_id;
			$filter = $post->filter;
			if(!empty($unit_id)){
				$instructor_id = $this->set_current_user_id_by_token($request);
				if(!empty($instructor_id )){
					$post_author_id = get_post_field( 'post_author', $unit_id );
					if(($post_author_id == $instructor_id) || user_can($instructor_id,'manage_options')){
						$filternew = array(
							'paged'=>$filter->paged ? $filter->paged: 1,
							'per_page'=>($filter->per_page && $filter->per_page<=20 )? $filter->per_page: 20
						);
						//computing offset
						$offset = $filternew['per_page']*($filternew['paged']-1);
						$comments = get_comments(apply_filters('vibe_inst_api_get_unit_comments_args',array(
							'post_id' => $unit_id,
							'status'=>'approve',
							'number'=>$filternew['per_page'],
							'offset'=>$offset,
							'parent' => 0
						)));
						if(!empty($comments) && count($comments)){
							foreach ($comments as $key => $comment) {
								$comment->user = $this->get_user_by_ID($comment->user_id);
								$comment_tree[]=$comment;
								$child_comments = $this->get_comment_child($comment->comment_ID);
								if(!empty($child_comments)){
									$comment_tree = array_merge($comment_tree,$child_comments);
								}
							}
							$data = array(
								'status' => 1,
								'message' => _x('Comments found','Comments found','wplms'),
								'data'=>$comment_tree
							);
						}else{
							$data = array(
								'status' => 0,
								'message' => _x('Comments not found','Comments not found','wplms'),
								'data'=>[]
							);
						}
					}else{
						$data = array(
							'status' => 0,
							'message' => _x('Author not matched','Author not matched','wplms'),
							'data'=>null
						);
					}
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('User Not Found','User Not Found','wplms'),
						'data'=>null
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Unit Not Found','Unit Not Found','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_get_units_discussion',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function get_comment_child($comment_id){	
			$comment_tree = [];
			$comments=get_comments(array(
				'parent'=>$comment_id,
				'status'=>'approve',
				'number'=>999,
			));
			foreach($comments as $comment){
				$comment->user = $this->get_user_by_ID($comment->user_id);
				$comment_tree[]=$comment;
				$child_comments = $this->get_comment_child($comment->comment_ID);
				if(!empty($child_comments)){
					$comment_tree = array_merge($comment_tree,$child_comments);
				}
			}
			return $comment_tree;
		}
	

		function create_unit_comments($request){
			$post = json_decode($request->get_body());
			$unit_id = $post->unit_id;
			$content = $post->content;
			$type = $post->type;
			if(!empty($unit_id) && !empty($type)){
				$instructor_id = $this->set_current_user_id_by_token($request);
				if(!empty($instructor_id )){
					$post_author_id = get_post_field( 'post_author', $unit_id );
					switch ($type) {
						case 'edit':
							$comment_ID = $post->comment_id;
							if(!empty($comment_ID)){
								$comment = get_comment($comment_ID, ARRAY_A);
								if(($comment['comment_post_ID']==$unit_id) && (($post_author_id == $instructor_id) || ($comment['user_id'] == $instructor_id)  || user_can($instructor_id,'manage_options'))){
									//Now you can update comment
									$newcomment = array(
										'comment_ID' => $comment_ID,
										'comment_content' => $content
									);
									if(wp_update_comment($newcomment)){
										$up_comment = get_comment($comment_ID, OBJECT);
										$up_comment->user=$this->get_user_by_ID($up_comment->user_id);
										$data = array(
											'status' => 1,
											'message' => _x('Comment updated','Comment updated','wplms'),
											'data'=>$up_comment
										);
									}else{
										$data = array(
											'status' => 0,
											'message' => _x('Comment not updated','Comment not updated','wplms'),
											'data'=>null
										);
									}
								}else{
									$data = array(
										'status' => 0,
										'message' => _x('Not access to edit comment','Not access to edit comment','wplms'),
										'data'=>null
									);
								}
							}else{
								$data = array(
									'status' => 0,
									'message' => _x('Comment id not found for Edit','Comment id not found for Edit','wplms'),
									'data'=>null
								);
							}
							break;
						case 'reply':
							$comment_parent = !empty($post->comment_parent)?$post->comment_parent:0;
							$new_comment = array(
							    'comment_post_ID' => $unit_id,
							    'comment_content' => $content,
							    'comment_type' => 'public',
							    'user_id' => $instructor_id,
							    'comment_parent'=>$comment_parent,	    
							);
							$new_comment_id=wp_insert_comment($new_comment);
							if(!empty($new_comment_id)){
								$up_comment = get_comment($new_comment_id, OBJECT);
								$up_comment->user=$this->get_user_by_ID($up_comment->user_id);
								$data = array(
									'status' => 1,
									'message' => _x('Replied','Replied','wplms'),
									'data'=>$up_comment
								);
							}else{
								$data = array(
									'status' => 0,
									'message' => _x('Not Replied','Not Replied','wplms'),
									'data'=>null
								);
							}
							break;
					case 'new':
						$comment_parent = !empty($post->comment_parent)?$post->comment_parent:0;
						$new_comment = array(
							'comment_post_ID' => $unit_id,
							'comment_content' => $content,
							'comment_type' => 'public',
							'user_id' => $instructor_id,
							'comment_parent'=>$comment_parent,	    
						);
						$new_comment_id=wp_insert_comment($new_comment);
						if(!empty($new_comment_id)){
							$up_comment = get_comment($new_comment_id, OBJECT);
							$up_comment->user=$this->get_user_by_ID($up_comment->user_id);
							$data = array(
								'status' => 1,
								'message' => _x('Added new comment','Added new comment','wplms'),
								'data'=>$up_comment
							);
						}else{
							$data = array(
								'status' => 0,
								'message' => _x('Not added new comment','Not added new comment','wplms'),
								'data'=>null
							);
						}
						break;	
						default:
							$data = array(
								'status' => 0,
								'message' => _x('Type not matched','Type not matched','wplms'),
								'data'=>null
							);
						break;
					}
				}else{
					$data = array(
						'status' => 0,
						'message' => _x('User Not Found','User Not Found','wplms'),
						'data'=>null
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Parameter missing','Parameter missing','wplms'),
					'data'=>null
				);
			}
			$data = apply_filters('vibe_create_unit_comments',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		// New tabs * //

		function get_instructor_quiz($request){
			$args = json_decode($request->get_body(),true);
			$instructor_id =  $this->user->id;
			$id = $args['quiz_id'];
			if(is_numeric($id)){
				$type = wplms_get_element_type($id,'quiz');
				$marks = $time = $attempts = 0;
				if($type == 'dynamic'){
					
					$tags =get_post_meta($id,'vibe_quiz_tags',true);
					if(is_array($tags)){
						foreach($tags['number'] as $i=>$num){
							$marks +=$num*$tags['marks'][$i];
						}
					}
				}else{
					$questions =get_post_meta($id,'vibe_quiz_questions',true);
					if(is_array($questions)){
						$marks = array_sum($questions['marks']);
					}
				};
				if(function_exists('bp_is_active') && bp_is_active('activity')){
					global $wpdb,$bp;
					$attempts = $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM {$bp->activity->table_name} WHERE secondary_item_id = %d or primary_item_id = %d AND type = %s",$id,$id,'quiz_evaluated'));
				}
				$duration = get_post_meta($id,'vibe_duration',true);
				$parameter = get_post_meta($id,'vibe_duration_parameter',true);
				if(is_numeric($duration) && is_numeric($parameter)){
					$time = $duration*$parameter;
				}
				$course_id = get_post_meta(get_the_ID(),'vibe_quiz_course',true);
					
				$quiz  = array(
					'id'=>$id,
					'title'=>get_the_title($id),
					'created'=>get_the_date($id),
					'type'=>$type,
					'marks'=>$marks,
					'timer'=>$time,
					'attempts'=>$attempts,
					'course'=>empty($course_id)?'':get_the_title($course_id),
					'quiz-type'=> wp_get_object_terms($id,'quiz-type',array('fields'=>'names'))
				);
				$return = array('status'=>1,'quiz'=>$quiz);
			}else{
				$return = array('status'=>0,'message'=>__('Invalid quiz','wplms'));
			}
			return new WP_REST_Response($return, 200);
		}

		function get_instructor_quizzes($request){
			$args = json_decode($request->get_body(),true);
			$instructor_id =  $this->user->id;
			
			$query_args = array(
				'post_type'=>'quiz',
				"orderby" => $args['orderby'],
				"order" => $args['order'],
				'paged'=>$args['paged'],
				'per_page'=>12,
				's' =>$args['s'],
				'author'=>$instructor_id
			);

			if(in_Array('manage_options',array_keys((Array)$this->user->caps))){ //if administrator
				unset($query_args['author_id']);
			}
			$total=0;
			$quizzes = new WP_Query($query_args);
			if($quizzes->have_posts()){
				$quizz = array();				
				$total = $quizzes->found_posts;
				while($quizzes->have_posts()){
					$quizzes->the_post();
					
					$type = wplms_get_element_type(get_the_ID(),'quiz');
					$marks = $time = $attempts = 0;
					if($type == 'dynamic'){
						$tags =get_post_meta(get_the_ID(),'vibe_quiz_tags',true);
						if(is_array($tags)){
							foreach($tags['number'] as $i=>$num){
								$marks +=$num*$tags['marks'][$i];
							}
						}
					}else{
						$questions =get_post_meta(get_the_ID(),'vibe_quiz_questions',true);
						if(is_array($questions)){
							$marks = array_sum($questions['marks']);
						}
					};
					if(function_exists('bp_is_active') && bp_is_active('activity')){
						global $wpdb,$bp;
						$attempts = $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM {$bp->activity->table_name} WHERE secondary_item_id = %d or primary_item_id = %d AND type = %s",get_the_ID(),get_the_ID(),'quiz_evaluated'));
					}
					$duration = get_post_meta(get_the_ID(),'vibe_duration',true);
					$parameter = get_post_meta(get_the_ID(),'vibe_duration_parameter',true);
					if(is_numeric($duration) && is_numeric($parameter)){
						$time = $duration*$parameter;
					}
					$course_id = get_post_meta(get_the_ID(),'vibe_quiz_course',true);
					$quizz[] = array(
						'id'=>get_the_ID(),
						'title'=>get_the_title(),
						'created'=>get_the_date(),
						'type'=>$type,
						'marks'=>$marks,
						'timer'=>strtotime($time),
						'attempts'=>empty($attempts)?0:$attempts,
						'course'=>empty($course_id)?'':get_the_title($course_id),
						'quiz-type'=> wp_get_object_terms(get_the_ID(),'quiz-type',array('fields'=>'names'))
					);
				}
				$return = array('status'=>1,'quizzes'=>$quizz,'total'=>$total);
			}else{
				$return=array('status'=>0,'message'=>__('No quizzes published by instructor.','wplms'));
			}
			return new WP_REST_Response($return, 200);
		}


		function get_instructor_assignment($request){
			$args = json_decode($request->get_body(),true);
			$instructor_id =  $this->user->id;
			$id = $args['assignment_id'];
			if(is_numeric($id)){
				$marks = $time = $attempts = 0;
				$type = get_post_meta($id,'vibe_assignment_submission_type',true);
				$marks = get_post_meta($id,'vibe_assignment_marks',true);
				if(function_exists('bp_is_active') && bp_is_active('activity')){
					global $wpdb,$bp;
					$attempts = $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM {$bp->activity->table_name} WHERE secondary_item_id = %d or primary_item_id = %d AND type = %s",$id,$id,'evaluate_assignment'));
				}
				$duration = get_post_meta($id,'vibe_duration',true);
				$parameter = get_post_meta($id,'vibe_quiz_duration_parameter',true);
				if(is_numeric($duration) && is_numeric($parameter)){
					$time = $duration*$parameter;
				}
				$assignment  = array(
					'id'=>$id,
					'title'=>get_the_title($id),
					'created'=>get_the_date($id),
					'type'=>$type,
					'marks'=>$marks,
					'timer'=>$time,
					'attempts'=>$attempts,
					'assignment-type'=> wp_get_object_terms($id,'assignment-type',array('fields'=>'names'))
				);
				$return = array('status'=>1,'assignment'=>$assignment);
			}else{
				$return = array('status'=>0,'message'=>__('Invalid quiz','wplms'));
			}
			return new WP_REST_Response($return, 200);
		}

		function get_instructor_assignments($request){

			$args = json_decode($request->get_body(),true);
			$instructor_id =  $this->user->id;
			
			$query_args = array(
				'post_type'=>'wplms-assignment',
				"orderby" => $args['orderby'],
				"order" => $args['order'],
				'paged'=>$args['paged'],
				'per_page'=>12,
				's' =>$args['s'],
				'author'=>$instructor_id
			);

			if(in_Array('manage_options',array_keys((Array)$this->user->caps))){ //if administrator
				unset($query_args['author']);
			}
			$total=0;
			$assignments_query = new WP_Query($query_args);
			if($assignments_query->have_posts()){
				$assignments = array();				
				$total = $assignments_query->found_posts;
				while($assignments_query->have_posts()){
					$assignments_query->the_post();
					$type = get_post_meta(get_the_ID(),'vibe_assignment_submission_type',true);
					if(empty($type)){
						$type = 'upload';
					}
					$marks = $time = $attempts = 0;
					if(function_exists('bp_is_active') && bp_is_active('activity')){
						global $wpdb,$bp;
						$attempts = $wpdb->get_var($wpdb->prepare("SELECT count(*) FROM {$bp->activity->table_name} WHERE secondary_item_id = %d or primary_item_id = %d AND type = %s",get_the_ID(),get_the_ID(),'evaluate_assignment'));
					}
					$duration = get_post_meta(get_the_ID(),'vibe_duration',true);
					$parameter = get_post_meta(get_the_ID(),'vibe_assignment_duration_parameter',true);
					$marks = get_post_meta(get_the_ID(),'vibe_assignment_marks',true);
					if(is_numeric($duration) && is_numeric($parameter)){
						$time = $duration*$parameter;
					}
					$course_id = get_post_meta(get_the_ID(),'vibe_assingment_course',true);
					$assignments[] = array(
						'id'=>get_the_ID(),
						'title'=>get_the_title(),
						'created'=>get_the_date(),
						'type'=>$type,
						'marks'=>$marks,
						'timer'=>strtotime($time),
						'attempts'=>empty($attempts)?0:$attempts,
						'course'=>empty($course_id)?'':get_the_title($course_id),
						'assignment-type'=> wp_get_object_terms(get_the_ID(),'assignment-type',array('fields'=>'names'))
					);
				}
				$return = array('status'=>1,'assignments'=>$assignments,'total'=>$total);
			}else{
				$return=array('status'=>0,'message'=>__('No assignments published by instructor.','wplms'));
			}
			return new WP_REST_Response($return, 200);
		}


		function get_instructor_questions($request){

			$args = json_decode($request->get_body(),true);
			$instructor_id =  $this->user->id;
			
			$query_args = array(
				'post_type'=>'question',
				"orderby" => $args['orderby'],
				"order" => $args['order'],
				'paged'=>$args['paged'],
				'per_page'=>12,
				's' =>$args['s'],
				'author'=>$instructor_id
			);

			if(in_Array('manage_options',array_keys((Array)$this->user->caps))){ //if administrator
				unset($query_args['author_id']);
			}

			
			$question_types = apply_filters('wplms_question_types',array(
	              array( 'label' =>__('True or False','wplms'),'value'=>'truefalse'),  
	              array( 'label' =>__('Multiple Choice','wplms'),'value'=>'single'),
	              array( 'label' =>__('Multiple Correct','wplms'),'value'=>'multiple'),
	              array( 'label' =>__('Sort Answers','wplms'),'value'=>'sort'),
	              array( 'label' =>__('Match Answers','wplms'),'value'=>'match'),
	              array( 'label' =>__('Fill in the Blank','wplms'),'value'=>'fillblank'),
	              array( 'label' =>__('Dropdown Select','wplms'),'value'=>'select'),
	              array( 'label' =>__('Small Text','wplms'),'value'=>'smalltext'),
	              array( 'label' =>__('Large Text','wplms'),'value'=>'largetext'),
	              array( 'label' =>__('Survey type','wplms'),'value'=>'survey')
	            ));

			$questions_query = new WP_Query($query_args);
			$total = 0;

			$columns = array(
				array('title'=>_x('Question ID','question list','wplms'),'field'=>'id'),
				array('title'=>_x('Question Title','question list','wplms'),'field'=>'title'),
				array('title'=>_x('Question Type','question list','wplms'),'field'=>'type'),
				array('title'=>_x('Created','question list','wplms'),'field'=>'created'),
				array('title'=>_x('Question Tags','question list','wplms'),'field'=>'tags'),
				array('title'=>_x('Correct Attempts','question list','wplms'),'field'=>'correct_count'),
				array('title'=>_x('Total Attempts','question list','wplms'),'field'=>'total'),
				array('title'=>_x('Flagged','question list','wplms'),'field'=>'flag')
			);

			if($questions_query->have_posts()){
				$questions = array();				
				$total = $questions_query->found_posts;
				while($questions_query->have_posts()){
					$questions_query->the_post();
					$type = get_post_meta(get_the_ID(),'vibe_question_type',true);
					$correct_count = get_post_meta(get_the_ID(),'correct_count',true);
					$incorrect_count = get_post_meta(get_the_ID(),'incorrect_count',true);
					$flag_count = get_post_meta(get_the_ID(),'flag_count',true);
					foreach($question_types as $qt){
						if($type == $qt['value']){
							$type = $qt;
							break;
						}
					}

					$questions[] = array(
						'id'=>get_the_ID(),
						'title'=>get_the_title(),
						'created'=>get_the_date(),
						'type'=>!empty($type['label'])?$type['label']:'',
						'correct_count'=>intval($correct_count),
						'total'=>intval($incorrect_count)+intval($correct_count),
						'flag'=>$flag_count,
						'tags'=> wp_get_object_terms(get_the_ID(),'question-tag',array('fields'=>'names'))
					);
				}

				
				$return = array('status'=>1,'questions'=>$questions,'columns'=>$columns,'total'=>$total);
			}else{
				$return=array('status'=>1,'columns'=>$columns,'message'=>__('No questions found.','wplms'));
			}
			return new WP_REST_Response($return, 200);
		}


		function import_instructor_questions($request){
			$body =json_decode(stripslashes($_POST['body']),true);
			if(!empty($_FILES['file'])){
				global $wpdb;	
				if(!class_exists('wplms_import')){
					include_once(WPLMS_PLUGIN_DIR.'includes/vibe-customtypes/includes/class.import.php');
				}			
				if(class_exists('wplms_import')){
					$wplms_import = new wplms_import(); 
					if($wplms_import->process_csv($_FILES['file']['tmp_name'])){
						$return=array('status'=> 1,'message'=>_x('Imported successfully','wplms'));
					}
				}
			}else{
            	$return=array('status'=> 0,'message'=>_x('File not found','wplms'));
        	}
        	return new WP_REST_Response( $return, 200 );
		}

		function import_instructor_students($request){
			$body =json_decode(stripslashes($_POST['body']),true);
			$course_id = $body['course_id'];
			if($this->check_user_is_instructor($course_id,$this->user)){
				if(!empty($_FILES['file'])){
					global $wpdb;	

					$file = $_FILES['file']['tmp_name'];

					$labels = 0;
					
					if (($handle = fopen($file, "r")) !== FALSE) {
					    while ( ($data = fgetcsv($handle,1000,",") ) !== FALSE ) {
					    	if($labels){

					    		$email = $data[0];
					    		if(!empty($email) && strpos($email, '@') !== false){
					    			$name = $data[1];
						    		$course_status = $data[2];
						    		if(!isset($course_status) ){
						    			if($course_status > 4){
						    				$course_status = 4;
						    			}else{
						    				$course_status = 1;
						    			}
						    			
						    		}
						    		$expiry = $data[3];
						    		if(empty($expiry)){
						    			$expiry = bp_course_get_course_duration($course_id);
						    			$expiry = time()+intval($expiry);
						    		}
						    		$marks = $data[4];
						    		if(!isset($marks)){
						    			$marks = 0;
						    		}

						    		$user_id = $this->check_user($email,$name);
						    		if($user_id){
						    			bp_course_update_user_course_status($user_id,$course_id,$course_status);
						    			bp_course_update_user_expiry_time($user_id,$course_id,$expiry);
						    			update_post_meta($course_id,$user_id,$marks);
						    		}
					    		}
					    		
					    	}else{ //Skips the first row/
					    		$labels = 1;
					    	}
					    }
					    fclose($handle);
					    $return=array('status'=> 1,'message'=>_x('Users Imported','wplms'));
					}



					$this->check_user($email,$name);
				}else{
	            	$return=array('status'=> 0,'message'=>_x('File not found','wplms'));
	        	}
			}else{
	            	$return=array('status'=> 0,'message'=>_x('You are not instructor of the course','wplms'));
			}
			
        	return new WP_REST_Response( $return, 200 );
		}
		
		function check_user($email,$name){
			$exists = email_exists($email);
			if($exists){
				return $exists;// Map new user via Email
			}else{
				$username = sanitize_title($name);
				if(username_exists($username))
					$username.=rand(1,99);

				$default_pass = apply_filters('wplms_user_pass',$username);
				$userdata = array(
				    'user_login'  =>  $username,
				    'user_email'  =>  $email,
				    'display_name' => $name,
				    'display_name' => $name,
				    'user_nicename' => $name,
				    'user_pass'   =>  $default_pass,  // When creating an user, `user_pass` is expected.
				);
				$user_id = wp_insert_user( $userdata ) ;
				if(is_numeric($user_id)){
					$id_map[$data[1]] = $user_id; // Add to mapping
					if(function_exists('bp_update_user_last_activity')){
						bp_update_user_last_activity( $user_id, bp_core_current_time() );
					}
					return $user_id;
				}
			}
			return false;
		}

		function get_statistics($request){

			
			$body = json_decode($request->get_body(),true);
			$args = $body['args'];
			$return=array('status'=>0,'message'=>__('Invalid data.','wplms'));
			global $wpdb,$bp;
			$statistics = array();
			if(is_numeric($args['id'])){

				if($args['cpt'] == 'quiz' || $args['cpt'] == 'assignment'){

					

					$type = $args['cpt'];
					if($args['cpt'] == 'assignment'){
						$type = 'wplms-assignment';
					}
					$q = apply_filters('wplms_cpt_stats_graph_query',$wpdb->prepare("
			            SELECT count(m.meta_value) as count,
			            	MAX(m.meta_value) as max,MIN(m.meta_value) as min, AVG(m.meta_value) as avg,
			             SUM(CASE WHEN m.meta_value <= 25 THEN 1 ELSE 0 END) as 'less_25',
			             SUM(CASE WHEN m.meta_value > 25 and m.meta_value <=50 THEN 1 ELSE 0 END) as '25_50',
			             SUM(CASE WHEN m.meta_value > 50 and m.meta_value <=75 THEN 1 ELSE 0 END) as '50_75',
			             SUM(CASE WHEN m.meta_value > 75 and m.meta_value <=100 THEN 1 ELSE 0 END) as '75_100'
			            FROM {$bp->activity->table_name_meta} as m
			            INNER JOIN {$bp->activity->table_name} as a 
			            ON a.id = m.activity_id
			            WHERE m.meta_key = 'percentage'
			            AND a.secondary_item_id = %d 
			            LIMIT 0,999",
		            $args['id']),$type,$args['id']);

		          	$results = $wpdb->get_results($q,ARRAY_A);
		          	
		         	if(!empty($results)){
		         		$count = $results[0]['count'];
		         		$max = $results[0]['max'];
		         		$min = $results[0]['min'];
		         		$avg = $results[0]['avg'];
		         		unset($results[0]['count']);
		         		unset($results[0]['max']);
		         		unset($results[0]['min']);
		         		unset($results[0]['avg']);
						$statistics = array(
							'vitals'=>array(
								array(
									'label'=>_x('Average Score','statistics api','wplms'),
									'value'=>$avg,
								),
								array(
									'label'=>_x('High Score','statistics api','wplms'),
									'value'=>$max,
								),
								array(
									'label'=>_x('Low Score','statistics api','wplms'),
									'value'=>$min,
								),
								array(
									'label'=>_x('Total Submissions','statistics api','wplms'),
									'value'=>$count,
								),
							),
							'data'=>array(
					            'labels'=>array(
					            	_x('Less than 25','statistics api','wplms'),
					              	_x('More than 25 Less than 50','statistics api','wplms'),
					              	_x('More than 50 Less than 75','statistics api','wplms'),
					              	_x('More than 75 Less than 100','statistics api','wplms')
					            ),
					            'data'=>array_values($results[0])
					          )
						);
					}else{
						$return=array('status'=>0,'message'=>__('No Quiz evaluated !','wplms'));
					}
				}

				$return = array('status'=>1,'statistics'=>$statistics);
			}


			return new WP_REST_Response($return, 200);
		}


		function get_leaderboard($request){

			$body = json_decode($request->get_body(),true);
			$args = $body['args'];
			$return=array('status'=>0,'message'=>__('Invalid data.','wplms'));
			global $wpdb,$bp;
			$leaderboard = array();
			if(is_numeric($args['id'])){

				if($args['cpt'] == 'quiz' || $args['cpt'] == 'assignment'){

					$type = $args['cpt'];
					if($args['cpt'] == 'assignment'){
						$type = 'wplms-assignment';
					}
					$q = "SELECT SQL_CALC_FOUND_ROWS a.user_id as user_id,m.meta_value as score,UNIX_TIMESTAMP(a.date_recorded) as date_recorded
			            FROM {$bp->activity->table_name_meta} as m
			            INNER JOIN {$bp->activity->table_name} as a 
			            ON a.id = m.activity_id";
			            
		            $where = " WHERE m.meta_key = 'percentage'
			            AND a.secondary_item_id = ".$args['id'];
		            $orderby ='';
					switch($args['orderby']){
						case 'score':
							$orderby .= ' ORDER BY m.meta_value';
						break;
						default:
							$orderby .= ' ORDER BY a.date_recorded';
						break;
					}
					
		            
		          	if(!empty($args['s'])){
		          		$s ='%'.$args["s"].'%';
		          		$q .=" INNER JOIN {$wpdb->users} as u ON a.user_id = u.ID";
		          		$where .= " AND ( u.user_login LIKE '$s' OR u.user_email LIKE '$s' OR u.display_name LIKE '$s' ) ";
		          	}

		          	
		          	if($args['order'] == 'alphabetical'){
		          		if(empty($args['s'])){
		          			$q .=" INNER JOIN {$wpdb->users} as u ON a.user_id = u.ID";
		          		}
		          		$orderby .= " ORDER BY u.display_name";
		          	}

		          	if($args['order']){
						$orderby .= ' '.$args['order'];
					}else{
						$orderby .= ' DESC';
					}

$q .= $where.$orderby. " LIMIT ".intval($args['paged']-1)*intval($args['per_page']).",".intval($args['per_page'])."";
		          	
		          	$q = apply_filters('wplms_cpt_stats_leaderboard_query',$q);


		          	
		          	$results = $wpdb->get_results($q,ARRAY_A);
		          	if(!empty($results)){
		          		$total = $wpdb->get_var('SELECT FOUND_ROWS();');
		          		$return = array('status'=>1,'members'=>$results,'total'=>$total);
		          	}

	          	}
          	}

          	return new WP_REST_Response($return, 200);
		}

		/* === STUDENT TABS === */

		function student_tabs($request){
			$body = json_decode($request->get_body(),true);
			
			global $wpdb;
			$results = $wpdb->get_results($wpdb->prepare("SELECT ID,post_type,post_title FROM {$wpdb->posts} WHERE post_author = %d AND post_type IN ('course','quiz','wplms-assignment') AND post_status = 'publish' ORDER BY ID DESC LIMIT 0,999",$this->user->id),ARRAY_A);

			$posts=array(
				'course'=>array(),
				'quiz'=>array(),
				'wplms-assignment'=>array(),
			);
			if(!empty($results)){
				foreach($results as $result){
					$posts[$result['post_type']][] = array('id'=>$result['ID'],'title'=>$result['post_title']);
				}
			}
			$return=apply_filters('wplms_instructor_student_tabs',array('status'=>1,'tabs'=>array(
				array('key'=>'course','label'=>_x('Course','manage student','wplms'),'items'=>$posts['course']),
				array('key'=>'quiz','label'=>_x('Quiz','manage student','wplms'),'items'=>$posts['quiz']),
				array('key'=>'assignment','label'=>_x('Assignment','manage student','wplms'),'items'=>$posts['wplms-assignment']),
			)),$request,$this->user->id);

			return new WP_REST_Response($return, 200);
		}

		function change_student_data($request){
			$body = json_decode($request->get_body(),true);
			$student_id = $body['student'];
			$action = $body['action'];
			$data = $body['data'];
			$item_id = $body['item_id'];
			$user_id = $this->user->ID;
			$return = array('status'=>false);
			if(!empty($item_id)){
				switch ($action) {
					case 'change_marks':
						$response = $this->change_user_marks($student_id,$item_id,$data['marks']);
						$return['data'] = $data;
						$return['data']['status'] = $response['status'];
						$return['data']['marks'] = $response['marks'];
						break;
					
					case 'change_status':
						$response = $this->change_user_status($student_id,$item_id,$data['status'],$data['marks']);
						$return['data'] = $data;
						break;

					case 'remove_user':
						$this->remove_user_from_item($student_id,$item_id);
						$return['data'] = array($item_id);
						break;
					default:
						do_action('wplms_manage_students_change_student_data',$request,$user_id,$body);
						break;
				}
				$return['status'] = true;
			}else{
				$return['status'] = false;
				$return['message'] = _x('Module ID missing','','wplms');
			}

			
			return new WP_REST_Response($return, 200);
		}

		function remove_user_from_item($student_id,$item_id){
			$type = get_post_type($item_id);
			global $wpdb;
			switch ($type) {
				case 'quiz':
					bp_course_remove_user_quiz_status($student_id, $item_id);
					bp_course_reset_quiz_retakes($item_id, $student_id);
					$questions = bp_course_get_quiz_questions($item_id, $student_id);
					if (!empty($questions) && is_array($questions['ques'])) {
						foreach($questions['ques'] as $question) {
							bp_course_reset_question_marked_answer($item_id, $question, $student_id);
						}
					}
					delete_user_meta($student_id, 'quiz_questions'.$item_id);
				break;
				
				case 'wplms-assignment':
					delete_user_meta($user_id,$item_id);
	                delete_post_meta($item_id,$student_id);
	                $wpdb->query($wpdb->prepare("UPDATE $wpdb->comments SET comment_approved='trash' WHERE comment_post_ID=%d AND user_id=%d",$item_id,$student_id));

				break;
				
				case 'course':
					bp_course_remove_user_from_course($student_id,$item_id);
			        $students=get_post_meta($item_id,'vibe_students',true);
			        if($students >= 1){
			          $students--;
			          update_post_meta($course_id,'vibe_students',$students);
			        }

				break;
			}
		}

		function change_user_status($student_id,$item_id,$data,$marks=null){
			$type = get_post_type($item_id);
			
			switch ($type) {
				case 'quiz':
					
					if($data==4){
						bp_course_update_user_quiz_status($student_id,$item_id,4);
						if($marks!==null){
							update_post_meta($item_id,$student_id,$marks);
							update_user_meta($student_id,$item_id,time());
						}

					}elseif($data==1 || $data==2){
						$quiz_duration_parameter = apply_filters('vibe_quiz_duration_parameter',60,$item_id);
		              	$quiz_duration = get_post_meta($item_id,'vibe_duration',true) * $quiz_duration_parameter; // Quiz duration in seconds
						bp_course_update_user_quiz_status($student_id,$item_id,2);
						$expire=time()+$quiz_duration;
		              	update_user_meta($student_id,$item_id,$expire);
		              	//do_action('wplms_start_quiz',$item_id,$student_id);
					}else{
						bp_course_update_user_quiz_status($student_id,$item_id,$data);
						update_user_meta($student_id,$item_id,time());
					}
					break;
				
				case 'wplms-assignment':
					if($data==4 || $data==3){
						if($marks!==null && $data==4){
							update_post_meta($item_id,$student_id,$marks);
						}
						$args = array(  
						    'number' => '1',
						    'user_id' => $student_id,
						    'post_id' => $item_id,
						);
						$comments = get_comments($args);
						if(empty($comments)){
							$us = get_user_by('id',$student_id);
							$comment_data = array(
				    				'comment_post_ID' => $item_id,
				    				'comment_content' => get_the_title($item_id).' - '.bp_core_get_user_displayname($student_id),
				    				'user_id' => $student_id,
				    				'comment_approved' => 1,
				    				'comment_author'=> $us->data->user_nicename,
				    				'comment_author_email'=> $us->data->user_email
								);
				            $comment_id=wp_insert_comment($comment_data);
						}
						update_user_meta($student_id,$item_id,time());
					}elseif($data==1 || $data==2){
						$vibe_assignment_duration=get_post_meta($item_id,'vibe_assignment_duration',true);
						$vibe_assignment_duration_parameter=get_post_meta($item_id,'vibe_assignment_duration_parameter',true);
						$duration=intval($vibe_assignment_duration)*intval($vibe_assignment_duration_parameter);
						if(empty($duration)){$duration=86400;}
						update_post_meta($item_id,$student_id,0);
						update_user_meta($student_id,$item_id,time());
					}
					break;

				case 'course':
					if($data==4){
						if($marks!==null){
							update_post_meta($item_id,$student_id,$marks);
						}
					}
					bp_course_update_user_course_status($student_id,$item_id,$data);
					break;
				default:
					do_action('wplms_manage_students_change_student_data_change_user_status',$student_id,$item_id,$data);
					break;
			}
			return $data;
		}

		function change_user_marks($student_id,$item_id,$data){
			$type = get_post_type($item_id);
			$response = [];
			switch ($type) {
				case 'quiz':
					bp_course_update_user_quiz_status($student_id,$item_id,4);

					update_post_meta($item_id,$student_id,$data);
					update_user_meta($student_id,$item_id,time());
					break;
				
				case 'wplms-assignment':
					if($data>0){
						$args = array(  
						    'number' => '1',
						    'user_id' => $student_id,
						    'post_id' => $item_id,
						);
						$comments = get_comments($args);
						if(empty($comments)){
							$us = get_user_by('id',$student_id);
							$comment_data = array(
				    				'comment_post_ID' => $item_id,
				    				'comment_content' => get_the_title($item_id).' - '.bp_core_get_user_displayname($student_id),
				    				'user_id' => $student_id,
				    				'comment_approved' => 1,
				    				'comment_author'=> $us->data->user_nicename,
				    				'comment_author_email'=> $us->data->user_email
								);
				            $comment_id=wp_insert_comment($comment_data);
						}
						update_user_meta($student_id,$item_id,time());
						update_post_meta($item_id,$student_id,$data);
					}else{
						$response['status'] = 0;
					}
					
					break;

				case 'course':
					bp_course_update_user_course_status($student_id,$item_id,4);

					update_post_meta($item_id,$student_id,$data);
					break;
				default:
					do_action('wplms_manage_students_change_student_data_change_user_marks',$student_id,$item_id,$data);
					break;
			}

			if(!isset($response['status'])){
				$response['status'] = 4;
			}
			$response['marks'] = $data;
			return $response;
			
			
		}

		function student_tab($request){

			$body = json_decode($request->get_body(),true);
			$args = $body['args'];
			$return = apply_filters('wplms_instructor_student_tab',array(),$request,$this->user->id);
			if(empty($return)){
				switch($body['tab']){
					case 'course':
						$meta_key = 'course_status'.$args['id'];
					break;
					case 'quiz':
						$meta_key = 'quiz_status'.$args['id'];
					break;
					case 'assignment':
						$meta_key = $args['id'];
					break;
					default:
				}
				// $body['tab'];
				// $body['args']; 
				// s:'',paged:1,id:'',orderby:'',order:'DESC'
				// total students
				global $wpdb;
				$q = $wpdb->prepare("SELECT m.user_id as id,m.meta_value as status,u.display_name as name,pm.meta_value as marks
					FROM {$wpdb->usermeta} as m
					INNER JOIN {$wpdb->users} as u
					ON u.id = m.user_id
					INNER JOIN {$wpdb->postmeta} as pm 
					ON pm.meta_key = m.user_id
					WHERE m.meta_key = %s AND pm.post_id = %d",$meta_key,$args['id']);
				if(!empty($args['s'])){
					$q .= " AND (u.user_login LIKE '%".$args['s']."%' OR u.user_email LIKE '%".$args['s']."%' OR u.display_name LIKE '%".$args['s']."%' )";
				}	

				if(!empty($args['orderby'])){
					if($args['orderby'] == 'alphabetical'){
						$q.= " ORDER BY u.display_name";
					}
				}else{
					$q .=" ORDER BY u.id";
				}

				if(!empty($args['order'])){
					$q.= " ".$args['order'];
				}else{
					$q .=" DESC";
				}

				$q .= " LIMIT ".(($args['paged']-1)*intval($args['per_page'])).",".intval($args['per_page']);
				$columns = array();
				$results = $wpdb->get_results($q,ARRAY_A);
				if(!empty($results)){
					$students = array();
					$columns = array(
						array('title'=>_x('Student','','wplms'),'field'=>'student', 'formatter'=>'html'),
						array('title'=>_x('Status','','wplms'),'field'=>'status'),
						array('title'=>_x('Marks','','wplms'),'field'=>'marks'),
						array('title'=>'','field'=>'change_marks'),
						array('title'=>'','field'=>'change_status'),
						array('title'=>'','field'=>'remove_user'),
					);
					foreach($results as $result){
						/*$students[]=array(
							'student'=>$result['id'],
							'name'=>$result['name'],
							'img'=>bp_core_fetch_avatar(array('item_id' => $result['id'],'type'=>'thumb', 'html' => false)),
							'details'=>apply_filters('wplms_instructor_student_tab_student_details',array($status),$result['id'],$args['id']),
							'actions'=>apply_filters('wplms_instructor_student_tab_student_actions',array(
								array(
									'icon'=>'vicon vicon-close',
									'title'=>__('Remove User','wplms'),
									'key'=>'remove'
								),
							
							),$result['id'],$args['id']),
							'marks' => $result['marks'],
						);*/
						$status = apply_filters('wplms_instructor_student_tab_student_details',$result['status'],$result['id'],$args['id']);
						if(is_array($status )){
							$status = implode(',', $status );
						}
						$students[]=array(
							'id'=> $result['id'],
							'student'=>$result['name'],
							'status'=>$status,
							'raw_status'=>$result['status'],
							'change_status'=>__('Change Status','wplms'),
							'change_marks'=>__('Change Marks','wplms'),
							'remove_user'=>__('Remove user','wplms'),
							'marks' => $result['marks'],
						);
					}
					$return = array('status'=>1,'message'=>__('Data loaded','wplms'),'students'=>$students,'columns'=>$columns);
				}else{
					$return = array('status'=>0,'message'=>__('No Students','wplms'));
				}
			}

			return new WP_REST_Response($return, 200);
		}

		function get_questions($request){
			
			$body = json_decode($request->get_body(),true);

			$args = array(
				'search' => $body['s'],
				'number'=>20,
				'status'=>'approve',
				'paged'=>$body['page'],
				'meta_query'=>array(
					'relation'=>'AND',
					array(
						'key'=>'question',
						'value'=>1,
						'type'=>'numeric',
						'compare'=>'='
					)
				)
			);

			if(!empty($body['insturctor'])){
				$args['meta_query'][]=array(
						'key'=>'instructor',
						'value'=>$body['instructor'],
						'type'=>'numeric',
						'compare'=>'='
					);
			}
			if(!empty($body['course'])){
				$args['meta_query'][]=array(
						'key'=>'course_id',
						'value'=>$body['course'],
						'type'=>'numeric',
						'compare'=>'='
					);
			}
			if($body['type'] == 'answered'){
				$args['meta_query'][1]['value']=0;
			}
			$comments_query = new WP_Comment_Query;
			$args = apply_filters('wplms_get_instructor_qna',$args,$body,$this->user->id);

			if(!empty($body['course'])){
				$units = bp_course_get_curriculum_units($body['course']);
				$args['post__in'] = $units;
			}

			$comment_results = $comments_query->query($args);


			if ( !empty($comment_results ) ){
				$comments = array();
				$loaded_discussion_chain = array();
				$cargs = $args;
				$cargs['count']=1;
				$total = $comments_query->query($cargs);

			
			    foreach ( $comment_results as $comment_result ) {

			    	$comment=array(
		    			'id'=>$comment_result->comment_ID,
		    			'comment_content'=>$comment_result->comment_content,
		    			'comment_date'=>strtotime($comment_result->comment_date),
		    			'user_id'=>$comment_result->user_id,
		    		);
			    	$course_id = get_comment_meta($comment_result->comment_ID,'course_id',true);
			    	$comment['course']=array('id'=>$course_id,'title'=>get_the_title($course_id));
	    			$comment['unit']=array('id'=>$comment_result->comment_post_ID,'title'=>get_the_title($comment_result->comment_post_ID),'icon'=>wplms_get_element_icon(wplms_get_element_type($comment_result->comment_post_ID,'unit')));
	    			
    				$nargs = array(
			            'parent' => $comment_result->comment_ID,
			            'hierarchical' => true,
		           	);
		           	
			        $chain = get_comments($nargs);
			        if(!empty($chain)){
			        	foreach($chain as $el){
			        		$loaded_discussion_chain[] = $el->comment_ID;
			        	}
			        }
			        $comment['chain'] = $chain;
			    	$comments[]=$comment;
			    }

			    $return = array('status'=>1,'comments'=>$comments);
			} else {
			    $return = array('status'=>0,'message'=>__('No questions found.','wplms'));
			}

			return new WP_REST_Response( $return, 200 );
		}

		function get_reports($request){
			$body = json_decode($request->get_body(),true);
			$filter = $body['filter'];

			$courses = array();
			
			$query_args = array(
				'post_type'=>'report',
				'orderby' => $body['orderby'],
				"order" => $body['order'],
				'paged'=>$body['paged'],
				'per_page'=>12,
				's' =>$body['s'],
			);
			
			if ( function_exists('get_coauthors')) {
				$author_names = array();
				$instructor_name = get_the_author_meta('user_login',$this->user->id);
				$author_names[] = 'cap-'.$instructor_name;

				// return $author_names;
				$query_args['tax_query']= array(
					'relation' => 'AND',
					array(
						'taxonomy'=>'author',
						'field'=>'name',
						'terms' => $author_names,
					)
				);
			}else{
				$query_args['author']=$this->user->id;
			}

			$query = new WP_Query($query_args);
			$reports = array();
			if ( $query->have_posts() ):
				while ( $query->have_posts() ) : $query->the_post();
					global $post;
					$reports[] = array(
						'id'			=> $post->ID,
						'title'			=> $post->post_title,
						'date'			=> strtotime($post->post_date)
					);
				endwhile;	
			endif;

			if(empty($courses)){
				$data = array(
					'status' => 0,
					'message' => _x('No reports found!','reports','wplms'),
				);
			}else{
				$data = array(
					'status' => 1,
					'reports'=>$reports,
					'total'=>$query->found_posts
				);
			}
			return new WP_REST_Response($data, 200);
		}

		function get_report($request){

		}

		function getReportFilters($request){
			$body = json_decode($request->get_body(),true);
			$item = $body['item'];
			$values = array();
			switch($item['from']){
				case 'taxonomy':
					$terms = get_terms( array(
						'taxonomy' => $item['key'],
					    'hide_empty' => false,
					));
					if(!empty($terms)){
						foreach($terms as $term){
							$values[$term->term_id]=$term->name;
						}
					}
				break;
			}


			return new WP_REST_Response(array('status'=>1,'values'=>$values), 200);
		}
			
		function manageapplication($request){
			$body = json_decode($request->get_body(),true);
			$course_id = $body['course_id'];
			$user_id = $body['user_id'];
			$action = $body['action'];
			$return = array('status'=>false);

			if(!empty(!empty($course_id)) && !empty($user_id)){
				$is_isnt = $this->check_user_is_instructor($course_id,$this->user->id); 
				if(!$is_isnt){
					$return = array('status'=>false,'message' => _x('Action cant be performed since you are not instructor of the course','','wplms'));
				}else{
					switch($action){
			          case 'approve':
			            bp_course_add_user_to_course($user_id,$course_id);
			            $return = array('status'=>true,'message' => _x('Application approved for user','','wplms'));
			          break;
			          case 'reject':
			            	$return = array('status'=>true,'message' => _x('Application rejected for user','','wplms'));
			          break;
			          default:
			          break;
			        }
			        delete_user_meta($user_id,'apply_course'.$course_id);
			        do_action('wplms_manage_user_application',$action,$course_id,$user_id);
				}
				
			}else{
				$return = array('status'=>false,'message' => _x('Missing data','','wplms'));
			}
			return new WP_REST_Response($return, 200);

		}

		function recalculatestats($request){
			$body = json_decode($request->get_body(),true);
			$course_id = $body['course_id'];
			$return = array('status'=>false,'message'=>_x('Error Occured','','wplms'));


			if(!empty($course_id)){
				$return['status'] = true;
			  	$badge=$pass=$total_qmarks=$gross_qmarks=0;
		        $users=array();
		    	global $wpdb;

		    	$badge_val=get_post_meta($course_id,'vibe_course_badge_percentage',true);
		    	$pass_val=get_post_meta($course_id,'vibe_course_passing_percentage',true);

		    	$members_course_grade = $wpdb->get_results(apply_filters('wplms_usermeta_direct_query', $wpdb->prepare("SELECT meta_value,meta_key FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key IN (SELECT DISTINCT user_id FROM {$wpdb->usermeta} WHERE meta_key = %s)",$course_id,'course_status'.$course_id)), ARRAY_A);
		      
		    	if(count($members_course_grade)){
		        $cmarks=$i=0;
		    		foreach($members_course_grade as $meta){
		    			if(is_numeric($meta['meta_key']) && $meta['meta_value'] > 2){
		           
		    						if($meta['meta_value'] >= $badge_val)
		    							$badge++;

		    						if($meta['meta_value'] >= $pass_val)
		    							$pass++;

		    						$users[]=$meta['meta_key'];

		                if(isset($meta['meta_value']) && is_numeric($meta['meta_value']) && $meta['meta_value'] > 2 && $meta['meta_value']<101){
		                  $cmarks += $meta['meta_value'];
		                  $i++;
		                }
		    					}
		    			}  // META KEY is NUMERIC ONLY FOR USERIDS
		    	}

		    	if($pass)
		    		update_post_meta($course_id,'pass',$pass);


		    	if($badge)
		    		update_post_meta($course_id,'badge',$badge);

		    	if($i==0)$i=1;
		        $avg = round(($cmarks/$i));

			    update_post_meta($course_id,'average',$avg);

			    if($flag !=1){
			    	$curriculum=bp_course_get_curriculum($course_id);
			    		foreach($curriculum as $c){
			    			if(is_numeric($c)){

			    				if(bp_course_get_post_type($c) == 'quiz'){
			              $i=$qmarks=0;

			    					foreach($users as $user){
			    						$k=get_post_meta($c,$user,true);
			                if(is_numeric($k)){
			      						$qmarks +=$k;
			                  $i++;
			      						$gross_qmarks +=$k;
			                }
			    					}
			              if($i==0)$i=1;
			    					
			              $qavg=round(($qmarks/$i),1);

			    					if($qavg)
			    						update_post_meta($c,'average',$qavg);
			    					else{
			    						$flag=1;
			    						break;
			    					}
			    				}
			    			}
			    	}
			    }

			    if(function_exists('assignment_comment_handle')){ // Assignment is active
			      $assignments_query = $wpdb->get_results( $wpdb->prepare("select post_id from {$wpdb->postmeta} where meta_value = %d AND meta_key = 'vibe_assignment_course'",$course_id), ARRAY_A);
			      foreach($assignments_query as $assignment_query){
			        $assignments[]=$assignment_query['post_id'];
			      }

			      if(count($assignments)){ // If any connected assignments
			        $assignments_string = implode(',',$assignments);
			        $assignments_marks_query = $wpdb->get_results("select post_id,meta_value from {$wpdb->postmeta} where post_id IN ($assignments_string) AND meta_key REGEXP '^[0-9]+$' AND meta_value REGEXP '^[0-9]+$'", ARRAY_A);
			        
			        foreach($assignments_marks_query as $marks){
			          $user_assignments[$marks['post_id']]['total'] += $marks['meta_value'];
			          $user_assignments[$marks['post_id']]['number']++;
			        }

			        foreach($user_assignments as $key=>$user_assignment){
			          if(isset($user_assignment['number']) && $user_assignment['number']){
			            $avg = $user_assignment['total']/$user_assignment['number'];  
			            update_post_meta($key,'average',$avg);
			          }
			        }
			      }
			    }
			    $return['message']  = _x('Stats refreshed','','wplms');
			}
			return new WP_REST_Response($return, 200);
		}

		function getcoursestats($request){
			$body = json_decode($request->get_body(),true);
			$course_id = $body['course_id'];
			$return = array('status'=>false);


			if(!empty($course_id)){
				$return['status'] = true;
				
				$students=get_post_meta($course_id,'vibe_students',true);
				$avg=get_post_meta($course_id,'average',true);
				$pass=get_post_meta($course_id,'pass',true);
				$badge=get_post_meta($course_id,'badge',true);
				$return['data'] = array();
				$return['general'] = apply_filters('wplms_course_stats_general_info',array(
					array('label'=>'Total Students in course','id'=>'vibe_students','value'=>(empty($students)?0:$students)),
					array('label'=>'Average marks in course','id'=>'average','value'=>(empty($avg)?0:$avg)),
					array('label'=>'Total certificates awarded in course','id'=>'pass','value'=>(empty($pass)?0:$pass)),
					array('label'=>'Total badges awarded in course','id'=>'vibe_students','value'=>(empty($badge)?0:$badge)),
				));
				$stats_array = apply_filters('wplms_course_stats_list',array(
			      'stats_student_start_date' => __('Date (Joining)','wplms'),
			      'stats_student_completion_date' => __('Date (Finish)','wplms'),
			      'stats_student_id' => __('ID','wplms'),
			      'stats_student_name' => __('Student Name','wplms'),
			      'stats_student_unit_status' => __('Units Status','wplms'),
			      'stats_student_quiz_score' => __('Quiz scores','wplms'),
			      'stats_student_badge' => __('Badge','wplms'),
			      'stats_student_certificate' => __('Certificate','wplms'),
			      'stats_student_certificate_code' => __('Certificate Code','wplms'),
			      'stats_student_progress' => __('Course Progress','wplms'),
			      'stats_student_marks' => __('Course Marks','wplms')
			    ));
				$_stats_array = [];
				foreach ($stats_array as $key => $stat) {
					if(!is_array($stat)){
						$_stat = array(
							'label'=>$stat,
							'id'=>$key,
							'type'=>'checkbox'
						);
					}else{
						$_stat = $stat;
					}
					
					
					$_stats_array[] = $_stat;
				}
				$return['download_options'] = $_stats_array;

				$return['download_student_options'] = apply_filters('wplms_course_download_student_options',array(
					array('value'=>'all_students' ,'label'=>_x('All students','','wplms')),
					array('value'=>'finished_students' ,'label'=>_x('Students who finished the course','','wplms')),
					array('value'=>'pursuing_students' ,'label'=>_x('Students pursuing the course','','wplms')),
					array('value'=>'badge_students' ,'label'=>_x('Students who got a badge in the course','','wplms')),

					array('value'=>'certificate_students' ,'label'=>_x('Students who got a certificate in the course','','wplms'))
 				));

			}

			return new WP_REST_Response(array('status'=>1,'data'=>$return), 200);

		}

		function generateStats($request){
			$return  = array('status'=>false);
			$body = json_decode($request->get_body(),true);
			$course_id = $body['course_id'];
			$fields = $body['stats_options'];
			$type = $body['stats_student_option'];
			$return = array('status'=>false);
			$users = array();
			$ccsv = [];
		    $csv = array();$csv_title=array();
		      global $wpdb,$bp;

		      switch($type){
		        case 'all_students':
		          $users = $wpdb->get_results(apply_filters('wplms_usermeta_direct_query',$wpdb->prepare("SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key  = %s ",'course_status'.$course_id)),ARRAY_A);
		        break;
		        case 'expired_students':
		          $users = $wpdb->get_results(apply_filters('wplms_usermeta_direct_query',$wpdb->prepare("SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key  = %s AND meta_value = %d",'course_status'.$course_id,4)),ARRAY_A);
		        break;
		        case 'finished_students':
		          $users = $wpdb->get_results(apply_filters('wplms_usermeta_direct_query',$wpdb->prepare("SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key  = %s AND meta_value = %d",'course_status'.$course_id,4)),ARRAY_A);
		        break;
		        case 'pursuing_students':
		          $users = $wpdb->get_results(apply_filters('wplms_usermeta_direct_query',$wpdb->prepare("SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = %s AND meta_value < %d",'course_status'.$course_id,4)),ARRAY_A);
		        break;
		        case 'badge_students':
		          $users = $wpdb->get_results(apply_filters('wplms_usermeta_direct_query',$wpdb->prepare("SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = %s AND meta_value LIKE %s",'badges',"%$course_id%")),ARRAY_A);
		        break;
		        case 'certificate_students':
		          $users = $wpdb->get_results(apply_filters('wplms_usermeta_direct_query',$wpdb->prepare("SELECT user_id FROM {$wpdb->usermeta} WHERE meta_key = %s AND meta_value LIKE %s",'certificates',"%$course_id%")),ARRAY_A);
		        break;
		      }
		      if(count($users)){ 
		      	$i=0;
		        foreach($users as $user){
		        	$k=0;
		          $user_id = $user['user_id'];
		          
		          	foreach($fields as $k=>$field){
			          	if(!isset($ccsv[$i])){
			          		$ccsv[$i] = array('id'=>$i+1);
			          	}
			            switch($field){
			              case 'stats_student_start_date':
			                $title=__('START DATE','wplms');
			                if(!in_array($title,$csv_title))
			                  $csv_title[$k]=array('title'=>$title,'field'=>'stats_student_start_date');

			                $date = $wpdb->get_results($wpdb->prepare("SELECT date_recorded FROM {$bp->activity->table_name} WHERE type=%s AND user_id = %d and item_id = %d ORDER BY date_recorded DESC",'start_course',$user_id,$course_id));
			                if(is_array($date) && is_object($date[0]) && isset($date[0]->date_recorded)){
			                  $csv[$i][]=$date[0]->date_recorded;
			                  $ccsv[$i]['stats_student_start_date'] =  $date[0]->date_recorded;
			                }
			                else{
			                  $csv[$i][]=__('N.A','wplms');
			                  $ccsv[$i]['stats_student_start_date'] = __('N.A','wplms');
			                }

			              break;
			              case 'stats_student_completion_date':
			                $title=__('COMPLETION DATE','wplms');
			                if(!in_array($title,$csv_title))
			                  $csv_title[$k]=array('title'=>$title,'field'=>'stats_student_completion_date');


			                $date = $wpdb->get_results($wpdb->prepare("SELECT date_recorded FROM {$bp->activity->table_name} WHERE type=%s AND user_id = %d and item_id = %d ORDER BY date_recorded DESC",'submit_course',$user_id,$course_id));
			                if(is_array($date) && is_object($date[0]) && isset($date[0]->date_recorded)){
			                  $csv[$i][]=$date[0]->date_recorded;
			                  $ccsv[$i]['stats_student_completion_date'] = $date[0]->date_recorded;
			                }
			                else{

			                  $csv[$i][]=__('N.A','wplms');
			                  $ccsv[$i]['stats_student_completion_date'] = __('N.A','wplms');
			                }
			              break;
			              case 'stats_student_id':
			                $title=__('ID','wplms');
			                if(!in_array($title,$csv_title))
			                 $csv_title[$k]=array('title'=>$title,'field'=>'stats_student_id');
			             	$ccsv[$i]['stats_student_id'] = $user_id;
			                $csv[$i][] = $user_id;
			              break;
			              case 'stats_student_name':
			                $title=__('NAME','wplms');
			                if(!in_array($title,$csv_title))
			                  $csv_title[$k]=array('title'=>$title,'field'=>'stats_student_name');
			              	$ccsv[$i]['stats_student_name'] = bp_core_get_user_displayname($user_id);
			                $csv[$i][] = bp_core_get_user_displayname($user_id);
			              break;
			              case 'stats_student_unit_status':
			                $units=bp_course_get_curriculum_units($course_id);
			                foreach($units as $unit_id){
			                  if(bp_course_get_post_type($unit_id) == 'unit'){

			                  $title=get_the_title($unit_id);
			                  if(!in_array($title,$csv_title))
			                  $csv_title[$k]=array('title'=>$title,'field'=>'unit_'.$unit_id);
			                  $unit_completion_time = bp_course_get_user_unit_completion_time($user_id,$unit_id,$course_id);//get_user_meta($user_id,$unit_id,true);
			                  if(!empty($unit_completion_time)){
			                    $csv[$i][] = date("Y-m-d H:i", $unit_completion_time);
			                    $ccsv[$i]['unit_'.$unit_id] = date("Y-m-d H:i", $unit_completion_time);
			                  }else{
			                    $csv[$i][] = 0;
			                    $ccsv[$i]['unit_'.$unit_id] = 0;
			                  }
			                  $k++;
			                  }
			                }
			                
			              break;
			              case 'stats_student_quiz_score':
			                $units=bp_course_get_curriculum_units($course_id);

			                foreach($units as $unit_id){
			                  if(bp_course_get_post_type($unit_id) == 'quiz'){

			                    $title=get_the_title($unit_id);
			                    if(!in_array($title,$csv_title))
			                      $csv_title[$k]=array('title'=>$title,'field'=>'quiz_'.$unit_id);

			                    $score = get_post_meta($unit_id,$user_id,true);
			                    if(!isset($score) || !$score){
			                      $csv[$i][] = __('N.A','wplms');
			                      $ccsv[$i]['quiz_'.$unit_id] = __('N.A','wplms');
			                    }
			                    else{
			                      $csv[$i][] = $score;
			                      $ccsv[$i]['quiz_'.$unit_id] = $score;
			                    }

			                    $k++;
			                  }
			                }
			              break;
			              case 'stats_student_badge':
			                $title=__('BADGE','wplms');
			                  if(!in_array($title,$csv_title))
			                 $csv_title[$k]=array('title'=>$title,'field'=>'stats_student_badge');
			                $check = $wpdb->get_results(apply_filters('wplms_usermeta_direct_query',$wpdb->prepare("SELECT COUNT(meta_key) as count FROM {$wpdb->usermeta} WHERE meta_key = %s AND user_id = %d AND meta_value LIKE %s",'badges',$user_id,"%$course_id%")),ARRAY_A);
			                if(isset($check) && is_array($check)){
			                   if($check[0]['count']){
			                   		$csv[$i][]= 1;
			                      	$ccsv[$i]['stats_student_badge'] =  1;
			                   } 
			                    else{

			                      $csv[$i][]= 0;
			                      $ccsv[$i]['stats_student_badge'] =  0;
			                    }
			                }
			              break;
			              case 'stats_student_certificate':
			                $title=__('CERTIFICATE','wplms');
			                if(!in_array($title,$csv_title))
			                $csv_title[$k]=array('title'=>$title,'field'=>'stats_student_certificate');
			                $check = $wpdb->get_results(apply_filters('wplms_usermeta_direct_query',$wpdb->prepare("SELECT COUNT(meta_key) as count FROM {$wpdb->usermeta} WHERE meta_key = %s AND user_id = %d AND meta_value LIKE %s",'certificates',$user_id,"%$course_id%")),ARRAY_A);
			                if(isset($check) && is_array($check)){
			                   if($check[0]['count']){
			                   	$csv[$i][]= 1;
			                   	$ccsv[$i]['stats_student_certificate'] =  1;
			                   }
			                    else{
			                      $csv[$i][]= 0;
			                      $ccsv[$i]['stats_student_certificate'] =  0;
			                    }
			                }
			              break;
			              case 'stats_student_certificate_code':
			                $title=__('CERTIFICATE CODE','wplms');
			                if(!in_array($title,$csv_title))
			                $csv_title[$k]=array('title'=>$title,'field'=>'stats_student_certificate_code');
			                $check = $wpdb->get_results($wpdb->prepare("SELECT COUNT(meta_key) as count FROM {$wpdb->usermeta} WHERE meta_key = %s AND user_id = %d AND meta_value LIKE %s",'certificates',$user_id,"%$course_id%"),ARRAY_A);
			                if(isset($check) && is_array($check)){
			                   if($check[0]['count']){
			                      if(empty($this->certificate_template)){
			                        $this->certificate_template = get_post_meta($course_id,'vibe_certificate_template',true);
			                        if(empty($this->certificate_template) || !is_numeric($this->certificate_template)){
			                          $this->certificate_template  = vibe_get_option('certificate_page');
			                        }
			                      }
			                      $csv[$i][]= apply_filters('wplms_certificate_code',$this->certificate_template.'-'.$course_id.'-'.$user_id,$course_id,$user_id);
			                      $ccsv[$i]['stats_student_certificate_code'] =  apply_filters('wplms_certificate_code',$this->certificate_template.'-'.$course_id.'-'.$user_id,$course_id,$user_id);
			                   }else{
			                      $csv[$i][]= 'N.A';
			                      $ccsv[$i]['stats_student_certificate_code'] =  'N.A';
			                   }
			                      
			                }
			              break;
			              case 'stats_student_progress':
			                $title=__('PROGRESS','wplms');
			                  if(!in_array($title,$csv_title)){
			                    $csv_title[$k]=array('title'=>$title,'field'=>'stats_student_progress');
			                  }
			                  $ccsv[$i]['stats_student_progress'] =  bp_course_get_user_progress($user_id,$course_id);
			                  $csv[$i][]= bp_course_get_user_progress($user_id,$course_id);
			                  
			              break;
			              case 'stats_student_marks':
			              $title=__('SCORE','wplms');
			              if(!in_array($title,$csv_title))
			                $csv_title[$k]=array('title'=>$title,'field'=>'stats_student_marks');

			              $score = get_post_meta($course_id,$user_id,true);
			              $csv[$i][]=$score;
			              $ccsv[$i]['stats_student_marks'] = $score;
			              break;
			              default;
			              do_action_ref_array('wplms_course_stats_process', array( &$csv_title, &$csv,&$i,&$course_id,&$user_id,&$field,&$ccsv,&$k));
			              break;
			            }
		            	$k++;
		          	}
		          $i++;
		        }
		      }  

		    if(!count($csv) || !is_array($csv[0])){
		        $return['message'] = _x('No stats found','','wplms');
		     
		    }else{
		    	
		    	$return['status'] = true;
		    	$return['columns'] = $csv_title;
		    	$return['data'] = $ccsv;
		    	$return['users'] = $users;
		    }



			return new WP_REST_Response($return, 200);

		}

		function addnews($request){

	        $args = json_decode($request->get_body(),true);

	        
	        $news_args = array(
	            'post_type'=>'news',
	            'post_status'=>'publish',
	            'post_title'=>$args['post_title'],
	            'post_content'=>$args['post_content'],
	            'post_author'=>$this->user->id
	        );

	        if(!empty($args['id'])){

	            if($this->user->id !== get_post_field('post_author',$args['id'])){
	                return new WP_REST_Response(array('status'=>0,'message'=>__('News author does not match.','wplms')), 200);
	            }
	            $news_args['ID'] = intval($args['id']);
	            $update = wp_update_post($news_args);
	            if(is_numeric($args['type'])){
	                wp_set_post_terms($args['id'],array($args['type']),'news-tag');    
	            }
	            
	            
	            if(empty($update)){
	                return new WP_REST_Response(array('status'=>0,'message'=>__('News could not be updated.','wplms')),200);
	            }
	            update_post_meta($args['id'],'raw',$args['raw']);
	        }else{
	            $post_id = wp_insert_post($news_args);

	            

	            if(empty($post_id)){
	                return new WP_REST_Response(array('status'=>0,'message'=>__('News could not be created.','wplms')),200);
	            }

	            if(is_numeric($args['type'])){
	                wp_set_post_terms($post_id,array($args['type']),'news-tag');
	            }
	            
	            $news_args['id'] = $post_id;
	            update_post_meta($post_id,'raw',$args['raw']);    
	            update_post_meta($post_id,'vibe_news_course',$args['course']);    
	        }

	        return new WP_REST_Response(array('status'=>1,'news'=>$news_args,'followermessage'=>sprintf(__('%s published a new article %s','vibekb'),$this->user->display_name,get_the_title($news_args['id']))), 200);
		}

	}


}