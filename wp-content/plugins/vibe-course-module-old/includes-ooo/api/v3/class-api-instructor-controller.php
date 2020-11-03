<?php

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'BP_Course_Rest_Instructor_Controller' ) ) {
	
	class BP_Course_Rest_Instructor_Controller extends BP_Course_Rest_Controller {

		public function register_routes() {
			// instructor app
			$this->type= 'instructor';
			register_rest_route( $this->namespace, '/' . $this->type . '/courses', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_instructor_course' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/course/(?P<id>\d+)?', array(
				'methods'                   =>  'GET',
				'callback'                  =>  array( $this, 'get_course_by_id' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/members', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_course_members' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/activity', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_course_activity' ),
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
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/get_quiz_submissions', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_quiz_submissions' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/course_quiz_reset', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'course_quiz_reset' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/get_course_submissions', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_course_submissions' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/get_admin_page_tabs', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_admin_page_tabs' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/get_submission_page', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_submission_page' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/get_evaluate_quiz_structure', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_evaluate_quiz_structure' ),
				'permission_callback' 		=> array( $this, 'get_instructor_permissions_check' ),
			) );
			register_rest_route( $this->namespace, '/' . $this->type . '/courses/get_evaluate_course_structure', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_evaluate_course_structure' ),
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
					$data['is_instructor'] = $this->check_user_is_instructor($course->ID,$this->user_id);  // check for instructor cap
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
							'user_status'			=>bp_course_get_user_course_status($this->user_id,$course->ID),
							'user_expiry'			=>bp_course_get_user_expiry_time($this->user_id,$course->ID),
							),
						'description'			=> do_shortcode($course->post_content),
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

		function get_instructor_permissions_check(){
			
			return true;
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

		function get_instructor_course($request){
			$post = json_decode($request->get_body());
			$instructor_id =  $this->user->id;
			$filter = $post->filter;
			$courses = array();
			$extra = array();
			$query_args = array(
				'post_type'=>'course',
				"order" => $filter->order ? $filter->order: 'DESC',
				'paged'=>$filter->paged ? $filter->paged: 1,
				'per_page'=>$filter->per_page ? $filter->per_page: 5,
				'search_terms' =>$filter->search_terms ? $filter->search_terms: ''
			);
			if(!empty($instructor_id)){
				if ( function_exists('get_coauthors') && 0) {
					$author_names = array();
					$instructor_name = get_the_author_meta('user_login',$instructor_id);
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
					$query_args['author__in']=$instructor_id;
				}
			}

			if ( bp_course_has_items( $query_args ) ):
				while ( bp_course_has_items() ) : bp_course_the_item();
					global $post;
					$courses[]=$this->prepare_data_for_response($post,$request,array('context'=>'view'));
				endwhile;	
			endif;

			if(empty($courses)){
				$data = array(
					'status' => 0,
					'message' => _x('Courses not found!','Courses not found!','wplms'),
					'courses' => [],
				);
			}else{
				$data = array(
					'status' => 1,
					'message' => _x('Courses found!','Courses found!','wplms'),
					'courses'=>$courses,
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
					$user_id =  $this->user->id;
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

			$current_user_id = $this->user->id;
			// return $current_user_id;



			if(!empty($filter) && !empty($course_id)){ 

				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set

				global $wpdb,$bp;
		        $query = " SELECT SQL_CALC_FOUND_ROWS DISTINCT u.ID as id FROM {$wpdb->users} as u "; 
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
					if($filter->active_status == 1){
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
				// return $query;
				$member_ids = $wpdb->get_results($query,ARRAY_A);

				if(!empty($member_ids)){
					foreach ($member_ids as $member_id) {
						$members[] = $this->get_user_by_ID($member_id['id']);
					}
					$data = array(
						'status' => 1,
						'message' =>  _x('Members found','Members found','wplms'),
						'data'=>$members,
						'is_instructor' => $is_instructor
					);
				}else{
					$data = array(
						'status' => 0,
						'message' =>  _x('Members not found','Members not found','wplms'),
						'data'=>$members,
					);
				}
			}else{
				$data = array(
					'status' => 0,
					'message' => _x('Filter or Course Not found!','Filter or Course Not found!','wplms'),
					'data'=>$members,
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

		function get_course_activity($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$filter = $post->filter;
			$activity = array();  // response

			$current_user_id = $this->user->id;

			if(!empty($filter) && !empty($course_id)){

				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
				
				$args = array(
					'primary_id' => $course_id,
					'page' => (!empty($filter->paged)) ? $filter->paged:1,
					'per_page' => (!empty($filter->per_page)) ? ($filter->per_page<20?$filter->per_page:20) : 20,
					'search_terms' => (!empty($filter->search_terms)) ? $filter->search_terms:false,
					'sort' => (!empty($filter->order)) ? $filter->order:false,
					'action' => (!empty($filter->action)) ? $filter->action:false,
					'user_id' => (!empty($filter->scope))?$this->access_activity_check($filter->scope,$is_instructor,$current_user_id):false
				);
				$activity_id = array();
				// Activity Loop
				if ( bp_has_activities( $args ) ) : 
				    while ( bp_activities() ) : bp_the_activity(); 
				    	$activity[] = $this->get_activity_in_loop();
				    endwhile; 
				endif;
				if(!empty($activity)){
					$data = array(
						'status' => 1,
						'message' => _x('Activity found!','Activity found!','wplms'),
						'data' => $activity,
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
					'message' => _x('Filter or Course Not found!','Filter or Course Not found!','wplms'),
					'data'=>$members,
				);
			}
			$data = apply_filters('vibe_get_course_activities',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}
		function get_activity_in_loop(){
			$activity = array(
	    		'acvity_id' =>  bp_get_activity_id(),
	    		'member' => bp_get_activity_member_display_name(),
	    		'content' =>  bp_get_activity_content_body(),
	    		'timestamp' => strtotime(bp_get_activity_date_recorded())
	    	);
	    	return $activity;
		}

		function remove_member_from_course($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$member_id = $post->member_id;

			$current_user_id = $this->user->id;

			if(!empty($course_id) && !empty($member_id)){

				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
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

			$current_user_id = $this->user->id;

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
				$current_user_id = $this->user->id;
				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
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
				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
				if($is_instructor){
					if(bp_course_is_member($course_id,$user_id)){
				       	$completed = $this->complete_course_curriculum_by_id($user_id,$course_id,$item_id);
				       	if(!empty($completed)){
					        $data = array(
					        	'status' => 1,
								'message' => _x('Completed','Completed','wplms'),
								'data'=> $this->get_curriculum_stats_structure($course_id,$user_id)
					        );
				       	}else{
				       		 $data = array(
					        	'status' => 0,
								'message' => _x('Not Completed','Not Completed','wplms'),
								'data'=> $this->get_curriculum_stats_structure($course_id,$user_id)
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
				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
				if($is_instructor){
					if(bp_course_is_member($course_id,$user_id)){
				       	// do here item uncomplete
			       		$uncompleted = $this->uncomplete_course_curriculum_by_id($user_id,$course_id,$item_id);
			       		if(!empty($uncompleted)){
					        $data = array(
					        	'status' => 1,
								'message' => _x('Uncompleted','UnCompleted','wplms'),
								'data'=> $this->get_curriculum_stats_structure($course_id,$user_id)
				        	);
			       		}else{
			       			$data = array(
					        	'status' => 0,
								'message' => _x('Not Uncompleted','Not UnCompleted','wplms'),
								'data'=> $this->get_curriculum_stats_structure($course_id,$user_id)
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
			$per = round((100/count($curriculum)),2);
			$progress = bp_course_get_user_progress($user_id,$course_id);
			$new_progress = $progress - $per;
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
			
			$current_user_id = $this->user->id;

			$members_added = array();	
			if(!empty($course_id) && !empty($members)){

				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
				if($is_instructor){
					if(is_array($members) && (count($members) > 0)){
						foreach ($members as $member_id) {
							$is_member =  bp_course_is_member($course_id, $member_id);
							if(!$is_member){
								$added = bp_course_add_user_to_course($member_id,$course_id,$duration = NULL,$force = NULL,$args=null);
								if($added){
									$members_added[] = $this->get_user_by_ID($member_id);
								}
							}
						}
						if(is_array($members_added) && (count($members_added) > 0)){
							$data = array(
								'status' => 1,
								'message' => _x('Members added','Members added','wplms'),
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

			$current_user_id = $this->user->id();

			$searched_users = array(); // response
			$length = apply_filters('vibe_search_student_to_add_string_length',4);
			if(!empty($course_id) && !empty($student_name) && (strlen($student_name)>=$length)){

				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
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
					'message' => _x('User not found.','Data missing','wplms'),
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
					$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
					if($is_instructor){
						foreach ($members as $member_id) {
							$updated =  $this->update_member_status_by_id((int)$member_id,$course_id,$status_action,$data);
							if($updated){
								$updated_members[] = $this->get_user_by_ID($member_id);
							}
							
						}
						//actual return after all check and process
						if(is_array($updated_members) && (count($updated_members) > 0)){
							$data = array(
								'status' => 1,
								'message' => _x('Members status updated','Members status updated','wplms'),
								'data'=>$updated_members
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
		function update_member_status_by_id($member,$course_id,$status_action='',$data=NULL){
			$is_member =  bp_course_is_member($course_id, $member);
			if($is_member){
	    		if (is_numeric($member) && bp_course_get_post_type($course_id) == 'course') {
	    			switch ($status_action) {
	    				case 'start_course':
	    					$status = 1;
	    					break;
	    				case 'continue_course':
	    					$status = 2;
	    					break;
	    				case 'under_evaluation':
	    					$status = 3;
	    					break;
	    				case 'finish_course':
	    					$status = 4;
	    					break;
	    				default:
	    					return false;	
	    					break;
	    			}
	    			$status = apply_filters('wplms_course_status', $status, $status_action);
	    			if (is_numeric($status)) {
	    				bp_course_update_user_course_status($member, $course_id, $status);
	    				if ($status == 3 && isset($data) && is_numeric($data)) {
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
			$course_duration_parameter_type = $post->course_duration_parameter_type;
			$extend_amount =  $post->extend_amount;

			$current_user_id = $this->user->id;

			if(!empty($course_id)&&!empty($members)&&!empty($course_duration_parameter_type)&& !empty($extend_amount)){
				if(is_array($members) && (count($members) > 0)){
					$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
					if($is_instructor){
						foreach ($members as $member_id) {
							$is_member =  bp_course_is_member($course_id, $member_id);
							// check here user is a member
							if($is_member){
								$updated =  $this->extend_course_subscription_by_id((int)$member_id,$course_id,$course_duration_parameter_type,$extend_amount);
								if($updated){
									$updated_members[] = $this->get_user_by_ID($member_id);
								}
							}
						}
						//actual return after all check and process
						if(is_array($updated_members) && (count($updated_members) > 0)){
							$data = array(
								'status' => 1,
								'message' => _x('Members time extended','Members time extended','wplms'),
								'data'=>$updated_members
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

		function extend_course_subscription_by_id($member,$course_id,$course_duration_parameter_type,$extend_amount){
			$is_member =  bp_course_is_member($course_id, $member);
			if($is_member){
				if (is_numeric($member) && bp_course_get_post_type($course_id) == 'course' && !empty($course_duration_parameter_type) && is_numeric($extend_amount)) {
					switch ($course_duration_parameter_type) {
						case 'seconds':
							$course_duration_parameter = 1;
							break;
						case 'minutes':
							$course_duration_parameter = 60;
							break;
						case 'hours':
							$course_duration_parameter = 3600;
							break;	
						case 'days':
							$course_duration_parameter = 86400;
							break;
						case 'weeks':
							$course_duration_parameter = 604800;
							break;
						case 'months':
							$course_duration_parameter = 2629746;
							break;
						case 'years':
							$course_duration_parameter = 31556952;
							break;
						default:
							$course_duration_parameter = 1;
							break;		
					}
					// do process
					$course_duration_parameter = apply_filters('vibe_course_duration_parameter_ins',$course_duration_parameter);
					$extend_amount_seconds = $extend_amount*$course_duration_parameter;
					$expiry = get_user_meta($member,$course_id,true);
					if(isset($expiry) && $expiry){
						if($expiry < time()){
							$expiry = time();
						}
						$expiry = $expiry + $extend_amount_seconds;
						update_user_meta($member,$course_id,$expiry);
					}
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}

		function assign_badge_course_certificate($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$members = $post->members;
			$assign_action = $post->assign_action;

			$current_user_id = $this->user->id;

			if(!empty($course_id)&&!empty($members)&&!empty($assign_action)){
				if(is_array($members) && (count($members) > 0)){

					$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
					if($is_instructor){
						foreach ($members as $member_id) {
							$updated =  $this->assign_badge_course_certificate_by_id((int)$member_id,(int)$course_id,$assign_action);
							if($updated){
								$updated_members[] = $this->get_user_by_ID($member_id);
							}
							
						}
						//actual return after all check and process
						if(is_array($updated_members) && (count($updated_members) > 0)){
							$data = array(
								'status' => 1,
								'message' => _x('SuceessFull','SuceessFull','wplms'),
								'data'=>$updated_members
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
			$current_user_id = $this->user->id();
			if(!empty($course_id)){
				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
				if($is_instructor){
					$data = array(
						'status' => 1,
						'message' => _x('Tabs found','Tabs found','wplms'),
						'data'=>$this->get_instructor_admin_tabs($course_id)
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
			$data = apply_filters('vibe_get_admin_page_tabs',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function get_submission_page($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$current_user_id = $this->user->id;
			if(!empty($course_id)){
				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
				if($is_instructor){

					$data = array(
						'status' => 1,
						'message' => _x('Tabs found','Tabs found','wplms'),
						'data'=>array(
							'tabs' => $this->get_instructor_submission_tabs($course_id),
							'extension' => array(
								'quiz'=> $this->get_submission_quiz_page($course_id),
								'course'=>true
							)
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
			$data = apply_filters('vibe_get_submission_page_tabs',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		// return quizess and ids 
		function get_submission_quiz_page($course_id){
			// for quiz data
			$quizes = array();
			$r = array();
			$quizes = bp_course_get_curriculum_quizes($course_id);

			if(!empty($quizes)){
				$quiz_ids = implode(',',$quizes);
				global $wpdb;
				$count_array = array();
		  		$submissions = $wpdb->get_results(apply_filters('wplms_usermeta_direct_query',$wpdb->prepare("SELECT count(*) as count,u.meta_key as quiz_id,u.user_id as user_id FROM {$wpdb->postmeta} as p LEFT JOIN {$wpdb->usermeta} as u ON p.meta_key = u.user_id WHERE p.meta_value LIKE '0' AND u.meta_key = p.post_id AND u.meta_value < %d AND p.post_id IN ($quiz_ids) GROUP BY u.meta_key",time())));
	            
	            if(!empty($submissions)){
	                foreach($submissions as $submission){
	                    $quiz_status = bp_course_get_user_quiz_status($submission->user_id,$submission->quiz_id);
	                    if($quiz_status != 4 ) {
	                        $count_array[$submission->quiz_id]=$submission->count;
	                    }
	                }   
	            }
	            foreach($quizes as $quiz_id){
	            	$r[] = array(
	            		'quiz_id' => $quiz_id,
	            		'title' =>get_the_title($quiz_id),
	            		'count'=> (empty($count_array[$quiz_id])?0:$count_array[$quiz_id])
	            	);
				}
			}
			return $r;
		}
		function get_quiz_submissions($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$quiz_id = $post->quiz_id;
			$filter = $post->filter;

			$members = array();
			$current_user_id = $this->user->id;

			if(!empty($course_id)&&!empty($quiz_id)&&!empty($filter)){

				// params check and initialize
				$quiz_status = (!empty($filter->quiz_status)) ? $filter->quiz_status : 0;  //by default 3 when empty(pending evaluation)
				$per_page = (!empty($filter->per_page)) ? ($filter->per_page<20?$filter->per_page:20) : 20;
				$paged_temp = (!empty($filter->paged)) ? ($filter->paged<20?$filter->paged:1) : 1;
				$paged = $per_page*($paged_temp-1);
				$limit = " LIMIT {$per_page} OFFSET {$paged} ";
				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
				if($is_instructor){
					//check if quiz is in the course or not
					$quizes = bp_course_get_curriculum_quizes($course_id);
					if(!empty($quizes) && in_array($quiz_id, $quizes)){
						global $wpdb;
						switch ($quiz_status) {
						  	case 0:
								$members = $wpdb->get_results(apply_filters('wplms_usermeta_direct_query', $wpdb->prepare("SELECT DISTINCT u.user_id  FROM {$wpdb->postmeta} as p LEFT JOIN {$wpdb->usermeta} as u ON p.meta_key = u.user_id WHERE p.meta_value LIKE '0' AND u.meta_key = p.post_id AND u.meta_value < %d AND p.post_id = %d {$limit}", time(), $quiz_id)), ARRAY_A); // Internal Query
						      break;
						  	case 1:
								$members = $wpdb->get_results(apply_filters('wplms_usermeta_direct_query', $wpdb->prepare("SELECT DISTINCT u.user_id  FROM {$wpdb->postmeta} as p LEFT JOIN {$wpdb->usermeta} as u ON p.meta_key = u.user_id WHERE p.meta_value NOT LIKE '0' AND u.meta_key = p.post_id AND u.meta_value < %d AND p.post_id = %d {$limit}", time(), $quiz_id)), ARRAY_A); // Internal Query
								
								break;
							default : 
								break;
									
						}
						if(!empty($members)){
							$user = array();
							foreach ($members as $member) {
								$user[] = $this->get_user_by_ID($member['user_id']); 
							}
							$data = array(
								'status' => 1,
								'message' => _x('Members found','Members found','wplms'),
								'data'=>$user
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
							'message' => _x('Quiz is not in the course','Quiz is not in the course','wplms'),
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
			$data = apply_filters('vibe_get_course_quiz_submission',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}


		function course_quiz_reset($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$quiz_id = $post->quiz_id;
			$user_id = $post->user_id;

			$per_page = (!empty($filter->per_page)) ? ($filter->per_page<20?$filter->per_page:20) : 20;
			$paged_temp = (!empty($filter->paged)) ? ($filter->paged<20?$filter->paged:1) : 1;
			$paged = $per_page*($paged_temp-1);

			$members = array();
			$current_user_id = $this->user->id;

			if(!empty($course_id)&&!empty($quiz_id)&&!empty($user_id)){
				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
				if($is_instructor){
					//check if quiz is in the course or not
					$quizes = bp_course_get_curriculum_quizes($course_id);
					if(!empty($quizes) && in_array($quiz_id, $quizes)){
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
							'message' => _x('Quiz reset completed','Quiz reset completed','wplms'),
							'data'=>$quiz_id
						);
					}else{
						$data = array(
							'status' => 0,
							'message' => _x('Quiz is not in the course','Quiz is not in the course','wplms'),
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
			$data = apply_filters('vibe_course_quiz_reset',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function get_course_submissions($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$filter = $post->filter;

			$members = array();
			$current_user_id = $this->user->id;

			if(!empty($course_id)&&!empty($filter)){
				// params check and initialize
				$course_status = (!empty($filter->course_status)) ? $filter->course_status : 3;  //by default 3 when empty(pending evaluation)
				$per_page = (!empty($filter->per_page)) ? ($filter->per_page<20?$filter->per_page:20) : 20;
				$paged_temp = (!empty($filter->paged)) ? ($filter->paged<20?$filter->paged:1) : 1;
				$paged = $per_page*($paged_temp-1);
				$limit = " LIMIT {$per_page} OFFSET {$paged} ";
				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set

				if($is_instructor){
					global $wpdb;
			        $student_field=vibe_get_option('student_field');
			        if($course_status == 4){
			          $members = $wpdb->get_results( apply_filters('wplms_usermeta_direct_query',$wpdb->prepare("SELECT user_id FROM {$wpdb->usermeta} where meta_key = %s AND meta_value = %d {$limit}",'course_status'.$course_id,4)), ARRAY_A);
			        }else{
			          $members = $wpdb->get_results( apply_filters('wplms_usermeta_direct_query',$wpdb->prepare("SELECT user_id  FROM {$wpdb->usermeta} where meta_key = %s AND meta_value = %d {$limit}",'course_status'.$course_id,3)), ARRAY_A);
			        }
		        	if(!empty($members)){
						$user = array();
						foreach ($members as $member) {
							$user[] = $this->get_user_by_ID($member['user_id']); 
						}
						$data = array(
							'status' => 1,
							'message' => _x('Members found','Members found','wplms'),
							'data'=>$user
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
			$data = apply_filters('vibe_course_quiz_reset',$data,$request);
	    	return new WP_REST_Response($data, 200);
		}

		function get_evaluate_course_structure($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$user_id = $post->user_id;
			$current_user_id = $this->user->id;

			if(!empty($course_id) && !empty($user_id)){
				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
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
					            	'id' => (int)$c
				       			);
				            }else{ 
				                $status = bp_course_get_user_unit_completion_time($user_id,$c,$course_id);   // means pending or done
				                $curriculum_data[] = array(
				                	'id' => (int)$c,
					            	'title'=> get_the_title($c),
					            	'status' => (isset($status) && $status !='')? true:false,
					            	'type' => 'unit'
				       			);
				            } 

				        }

			        }
			        do_action('wplms_course_manual_evaluation',$course_id,$user_id);

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
	    	return new WP_REST_Response($data, 200);
		}



		function get_evaluate_quiz_structure($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$quiz_id = $post->quiz_id;
			$user_id = $post->user_id;
			$current_user_id = $this->user->id;

			if(!empty($quiz_id) && !empty($course_id) && !empty($user_id)){
				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
				if($is_instructor){

					// find structure
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
			$data = apply_filters('vibe_get_course_structure',$data,$request);
	    	return new WP_REST_Response($data, 200);
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
	  
				
				$activity_id = $evaluate_activity[0]->id;
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

				$structure['activity_id']=isset($activity_id)?(int)$activity_id:0;
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

			$current_user_id = $this->user->id;

			if(!empty($course_id) && !empty($user_id) &&!empty($quiz_id)  && !empty($activity_id) && !empty($question_id) && !empty($marks)){
				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
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


		function set_complete_course_marks($request){
			$post = json_decode($request->get_body());
			$course_id = $post->course_id;
			$user_id = $post->user_id;
			$marks = $post->marks;

			

			if(!empty($course_id) && !empty($user_id) && !empty($marks)){
				$current_user_id = $this->user->id;
				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
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
				$current_user_id = $this->user->id;
				$is_instructor = $this->check_user_is_instructor($course_id,$current_user_id); // instructor set
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
			$instructor_id = $this->user->id;
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
				$instructor_id = $this->user->id;
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
				$instructor_id = $this->user->id;
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
	}	
}