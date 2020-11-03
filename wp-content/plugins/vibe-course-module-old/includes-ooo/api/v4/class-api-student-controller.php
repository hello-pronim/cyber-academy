<?php

defined( 'ABSPATH' ) or die();

if ( ! class_exists( 'BP_Course_Rest_Student_Controller' ) ) {
	
	class BP_Course_Rest_Student_Controller extends BP_Course_New_Rest_Controller {

		public function register_routes() {
			// instructor app
			$this->type= 'student';


			register_rest_route( $this->namespace, '/'.$this->type.'/courses', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_student_courses' ),
				'permission_callback' 		=> array( $this, 'get_student_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/'.$this->type.'/getcourseTabs', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_course_tabs' ),
				'permission_callback' 		=> array( $this, 'get_student_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/'.$this->type.'/courseTab', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_course_tab' ),
				'permission_callback' 		=> array( $this, 'get_student_permissions_check' ),
			) );
			
			register_rest_route( $this->namespace, '/'.$this->type.'/quiz', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_student_quizzes' ),
				'permission_callback' 		=> array( $this, 'get_student_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/'.$this->type.'/assignments', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_student_assignments' ),
				'permission_callback' 		=> array( $this, 'get_student_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/'.$this->type.'/badges', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_student_badges' ),
				'permission_callback' 		=> array( $this, 'get_student_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/'.$this->type.'/certificates', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_student_certificates' ),
				'permission_callback' 		=> array( $this, 'get_student_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/'.$this->type.'/finishedCourses', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_student_results' ),
				'permission_callback' 		=> array( $this, 'get_student_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/'.$this->type.'/comments', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'get_student_comments' ),
				'permission_callback' 		=> array( $this, 'get_student_permissions_check' ),
			) );

			register_rest_route( $this->namespace, '/'.$this->type.'/askQuestion', array(
				'methods'                   =>  'POST',
				'callback'                  =>  array( $this, 'ask_question' ),
				'permission_callback' 		=> array( $this, 'get_student_permissions_check' ),
			) );


			register_rest_route( $this->namespace, '/'. $this->type .'/announcement', array(
				array(
					'methods'                   =>  'POST',
					'permission_callback' 		=> array( $this, 'get_student_permissions_check' ),
					'callback'                  =>  array( $this, 'get_announcement' )
				),
			));

			register_rest_route( $this->namespace, '/'. $this->type .'/news', array(
				array(
					'methods'                   =>  'POST',
					'permission_callback' 		=> array( $this, 'get_student_permissions_check' ),
					'callback'                  =>  array( $this, 'get_news' )
				),
			));
			
			register_rest_route( $this->namespace, '/' . $this->type.'/courseButton', array(
				array(
					'methods'                   =>  'POST',
					'callback'                  =>  array( $this, 'course_button' ),
					'permission_callback' => array( $this, 'get_student_permissions_check' ),
				),
			));

			register_rest_route( $this->namespace, '/' . $this->type.'/courseButton/applycourse', array(
				array(
					'methods'                   =>  'POST',
					'callback'                  =>  array( $this, 'apply_course' ),
					'permission_callback' => array( $this, 'get_student_permissions_check' ),
				),
			));
		}

		function get_student_permissions_check($request){
			$body = json_decode($request->get_body(),true);
			
			if(!empty($body['token'])){
	            $this->user = apply_filters('vibebp_api_get_user_from_token','',$body['token']);
	            if(!empty($this->user)){
	                return true;
	            }
	        }

	        return false;
		}

		function get_student_courses($request){

			$args = json_decode($request->get_body(),true);

			$return = array('status'=>0,'message'=>__('No Courses found.','wplms'));
			
			if(empty($args['access'])){
				$args['access'] = 'active';
			}
			global $wpdb;
			
			if($args['access'] == 'active'){
				$courses_with_types = apply_filters('wplms_usermeta_direct_query',$wpdb->prepare("
		  		SELECT posts.ID as id
		      	FROM {$wpdb->posts} AS posts
		      	LEFT JOIN {$wpdb->usermeta} AS meta ON posts.ID = meta.meta_key
		      	WHERE   posts.post_type   = %s
		      	AND   posts.post_status   = %s
		      	AND   meta.user_id   = %d
		      	AND   meta.meta_value > %d
		      	",'course','publish',$this->user->id,time()));
			}else{
				$courses_with_types = apply_filters('wplms_usermeta_direct_query',$wpdb->prepare("
		  		SELECT posts.ID as id
		      	FROM {$wpdb->posts} AS posts
		      	LEFT JOIN {$wpdb->usermeta} AS meta ON posts.ID = meta.meta_key
		      	WHERE   posts.post_type   = %s
		      	AND   posts.post_status   = %s
		      	AND   meta.user_id   = %d
		      	AND  meta.meta_value < %d
		      	",'course','publish',$this->user->id,time()));
			}
			if(!empty($args['post__in'])){
				$courses_with_types.=' AND posts.ID IN ('.implode(',',$args['post__in']).')';

			}
			
			$courses_with_types = $wpdb->get_results($courses_with_types);
			
			if(!empty($courses_with_types) || !empty($args['post__in'])){
				$course_ids = $statuses = array();
				if(empty($args['post__in'])){
					foreach($courses_with_types as $course){
						$args['post__in'][]=$course->id;
						$type = bp_course_get_user_course_status($this->user->id,$course->id);
						
						$statuses[$course->id]= intval($type);
					}
				}else{
					foreach($args['post__in'] as $id){
						$type = bp_course_get_user_course_status($this->user->id,$id);
						$statuses[$id]= intval($type);
					}
				}

				$query_args = apply_filters('wplms_mycourses',array(
					'post_type'=>'course',
					'posts_per_page'=>12,
					'paged'=>$args['paged'],
					's'=>$args['s'],
					'post__in'=>$args['post__in']
				),$this->user->id);

				
				$course_query = new WP_Query($query_args);
				global $bp,$wpdb;


				if($course_query->have_posts()){
					$return['status']=1;
					$courses = array();
					while($course_query->have_posts()){
						$course_query->the_post();
						global $post;


						$retakes = apply_filters('wplms_course_retake_count',get_post_meta($post->ID,'vibe_course_retakes',true),$post->ID,$this->user->id);
			            $table_name = $bp->activity->table_name;
			            $course_retakes = $wpdb->get_results($wpdb->prepare( "
			                                SELECT activity.content FROM {$table_name} AS activity
			                                WHERE   activity.component  = 'course'
			                                AND     activity.type   = 'retake_course'
			                                AND     user_id = %d
			                                AND     item_id = %d
			                                ORDER BY date_recorded DESC
			                            " ,$this->user->id,$post->ID));
			            if(empty($course_retakes)){
			                $course_retakes = array();
			            }

						$authors=array($post->post_author);
						$authors = apply_filters('wplms_course_instructors',$authors,$post->ID);
						$progress = bp_course_get_user_progress($this->user->id,$post->ID);
						if($statuses[$post->ID]>2){$progress = 100;}
						$start_date = bp_course_get_start_date($post->ID,$this->user->id);
						if(strpos($start_date,'-') !== false){
							$start_date = strtotime($start_date);
						}


						$_course_data = array(
							'id'                    => $post->ID,
							'name'                  => $post->post_title,
							'excerpt'				=> $post->post_excerpt,
							'description'			=> $post->post_content,
							'user_progress'         => empty($progress)?0:intval($progress),
							'user_status'           => $statuses[$post->ID],
							'duration'				=> bp_course_get_course_duration($post->ID,$this->user->id),
							'user_expiry'           => bp_course_get_user_expiry_time($this->user->id,$post->ID),
							'start_date'            => $start_date,
							'display_start_date'    => $start_date?date(get_option('date_format'),$start_date):'',
							'featured_image'		=> $this->get_course_featured_image($post->ID),	
							'instructor'            => $authors,	
							'menu_order'            => $post->menu_order,
							'link'					=> get_permalink($post->ID),
							'course_retakes'        => intval($retakes),
							'user_retakes'        	=> count($course_retakes),
						);

						


						$stop_course_status = apply_filters('wplms_before_course_status_api',false,$post->ID,$this->user->id);

						if($stop_course_status && is_array($stop_course_status) && !empty($stop_course_status['error_code'])){
							$_course_data['error'] = $stop_course_status;

						}


						$courses[]=$_course_data;

					}
					unset($return['message']);
					$return['courses']=$courses;
					$return['total']=$course_query->found_posts;
				}
			}
			

		    return new WP_REST_Response( $return, 200 );
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

		function get_student_quizzes($request){

			$args = json_decode($request->get_body(),true);

			$return = array('status'=>0,'message'=>__('Data missing','wplms'));
			if(!function_exists('bp_is_active')){
				$return = array('status'=>0,'message'=>__('BuddyPress not active.','wplms'));
				return new WP_REST_Response( $return, 200 );
			}
			if(!bp_is_active('activity')){
				$return = array('status'=>0,'message'=>__('BuddyPress Activity not active.','wplms'));
				return new WP_REST_Response( $return, 200 );
			}

			$user_id = $this->user->id;

			global $bp,$wpdb;
			$activity_ids = get_user_meta($user_id,'quiz_cached_results',true);
			if(empty($activity_ids)){
				$activity_ids = $wpdb->get_results($wpdb->prepare( "
					SELECT a.secondary_item_id,MAX(a.id) AS id,a.date_recorded as attempted_date, am.meta_value as result
					FROM {$bp->activity->table_name} AS a
					LEFT JOIN {$bp->activity->table_name_meta}  AS am
					ON a.id = am.activity_id
					WHERE a.type = 'quiz_evaluated'
					AND a.user_id = %d
					AND am.meta_key = 'quiz_results'
					AND am.meta_value IS NOT NULL
					GROUP BY a.secondary_item_id
					ORDER BY a.date_recorded DESC
					LIMIT 0,999
				" ,$user_id));
				update_user_meta($user_id,'quiz_cached_results',$activity_ids);
			}
			
			
			if(!empty($activity_ids)){
			    
			    $quiz_ids = $aids = $attempts= $results = array();
				foreach($activity_ids as $activity_id){
					$quiz_ids[] = $activity_id->secondary_item_id;
					$aids[$activity_id->secondary_item_id] = $activity_id->id;
					$attempts[$activity_id->secondary_item_id] = $activity_id->attempted_date;
					$results[$activity_id->secondary_item_id] = unserialize($activity_id->result);
				}
				$args = apply_filters('wplms_my_quizzes',array(
			    	'post_type'=>'quiz',
			    	'post_status'=>'publish',
			    	's'=>$args['s'],
			    	'post__in'=>$quiz_ids,
			    	'paged'=>$args['page']?$args['page']:1,
			    	'per_page'=>$args['per_page']?$args['per_page']:12,
			    ),$this->user);
			    
			    $quizzes = new WP_Query($args);
			    $all_quiz=array();
			    if($quizzes->have_posts()){
			    	while($quizzes->have_posts()){
			    		$quizzes->the_post();
			    		$marks = $max = $count = 0;
			    		if(!empty($results[get_the_ID()])){
			    			foreach($results[get_the_ID()] as $result){
				    			$marks+=$result['marks'];
				    			$max+=$result['max_marks'];
				    			$count++;
				    		}
			    		}
			    		

			    		$quiz = array(
			    			'id'=>get_the_ID(),
			    			'activity_id'=>$aids[get_the_ID()],
			    			'title'=>get_the_title(),
			    			'quiz-type'=>wp_get_object_terms(get_the_ID(),'quiz-type',array('fields'=>'names')),
			    			'attempted_date'=>$attempts[get_the_ID()],
			    			'count'=>$count,
			    			'marks'=>$marks,
			    			'max'=>$max,
			    			'result'=>$results[get_the_ID()]
			    		);
			    		$all_quiz[]=$quiz;
			    	}
			    	$return = array('status'=>1,'quizzes'=>$all_quiz,'args'=>$args,'total'=>$quizzes->found_posts);
			    }else{
			    	$return = array('status'=>1,'message'=>__('No Quizzes found, matching your criteria.','wplms'));
			    }
		    }else{
		    	$return = array('status'=>1,'message'=>__('No Quizzes found.','wplms'));
		    }

		    return new WP_REST_Response( $return, 200 );
		}


		function get_student_assignments($request){

			$args = json_decode($request->get_body(),true);

			if(!function_exists('bp_is_active')){
				$return = array('status'=>0,'message'=>__('BuddyPress not active.','wplms'));
				return new WP_REST_Response( $return, 200 );
			}
			if(!bp_is_active('activity')){
				$return = array('status'=>0,'message'=>__('BuddyPress Activity not active.','wplms'));
				return new WP_REST_Response( $return, 200 );
			}

			$return = array('status'=>0,'message'=>__('Data missing','wplms'));

			$query_args =array(
            'post_type'=>'wplms-assignment',
            'post_status'=>'publish',
            's'=>$args['s'],
	    	'paged'=>$args['page']?$args['page']:1,
	    	'per_page'=>$args['per_page']?$args['per_page']:12,
            'meta_query'=>array(
                array(
                    'key' => $this->user->id,
                    'compare' => 'EXISTS'
                    ),
                ),
            );
            
			$assignments_query=new WP_QUERY($query_args);
			$assignments=array();
		    if($assignments_query->have_posts()){
		    	$aids = array();
		    	while($assignments_query->have_posts()){
		    		$assignments_query->the_post();

		    		$aids[]=get_the_ID();
		    		$assignment = array(
		    			'id'=>get_the_ID(),
		    			'title'=>get_the_title(),
		    			'assignment-type'=>wp_get_object_terms(get_the_ID(),'assignment-type',array('fields'=>'names')),
		    			'attempted_date'=>$attempts[get_the_ID()],
		    			'count'=>(is_array($questions) && is_array($questions['ques']))?array_sum($questions['ques']):0,
		    			'marks'=>intval(get_post_meta($activity_id->secondary_item_id,$user_id,true)),
		    			'max'=>(is_array($questions) && is_array($questions['marks']))?array_sum($questions['marks']):0,
		    		);
		    		$assignments[]=$assignment;
		    	}

		    	if(function_exists('bp_is_active') && bp_is_active('activity')){
		    		global $wpdb,$bp;
	    			$attempts = $wpdb->get_results($wpdb->prepare("
	    				SELECT date_recorded 
	    				FROM {$bp->activity->table_name} 
	    				WHERE secondary_item_id IN (".implode(',', $aids).")
	    				AND component = %s AND type = %s 
	    				AND user_id = %d LIMIT0,999",
	    				'course','assignment_started',$this->user->id),ARRAY_A);
	    		}
		    	$return = array('status'=>1,'assignments'=>$assignments,'total'=>$assignments_query->found_posts);
		    }else{
		    	$return = array('status'=>1,'message'=>__('No assignments found!','wplms'));
		    }
			return new WP_REST_Response( $return, 200 );
		}
		

		function get_student_badges($request){

			$all_badges = bp_course_get_user_badges($this->user->id);
			$badges = array();
			if(!empty($all_badges)){
				foreach($all_badges as $badge_course_id){
					$b=bp_get_course_badge($badge_course_id);
					
            		$b_title = get_post_meta($badge_course_id,'vibe_course_badge_title',true);
            		$badges[]=array('value'=>$b['url'],'label'=>$b_title);
				}
			}
			return new WP_REST_Response( array('status'=>1,'badges'=>$badges), 200 );
		}

		function get_student_certificates($request){
			$user_certificates = bp_course_get_user_certificates($this->user->id);
			$certificates = array();
			foreach($user_certificates as $certificate){
				$certificates[]=array('label'=>get_the_title($certificate),'value'=>bp_get_course_certificate(array('user_id'=>$this->user->id,'course_id'=>$certificate)));
			}
			return new WP_REST_Response( array('status'=>1,'certificates'=>$certificates), 200 );
		}

		function get_student_results($request){
			
			$args = json_decode($request->get_body(),true);
			$finished_courses = bp_course_get_user_courses($this->user->id,'course_evaluated');

			if(!empty($finished_courses)){
				
				
				$query_args = array(
					'post_type'=>'course',
					'post_status'=>'publish',
					's'=>$args['s'],
					'page'=>$agrs['page'],
					'posts_per_page'=>12,
					'orderby'=>$args['orderby'],
					'order'=>$args['order'],
					'post__in'=>$finished_courses
				);
				$results  = new WP_query($query_args);

				
				
				$courses = array();
				if($results->have_posts()){
					$badges = bp_course_get_user_badges($this->user->id); 
					$certificates = bp_course_get_user_certificates($this->user->id);


					while($results->have_posts()){
						$results->the_post();
						$marks = bp_course_get_marks($this->user->id,get_the_ID());
						$has_certificate = (!empty($certificates) && in_Array(get_the_ID(),$certificates))?1:0;
						$has_badge = (!empty($badges) && in_array(get_the_ID(),$badges)?1:0);

						
						$grade = array(
							'label'=>'',
							'key'=>'',
							'value'=>$marks
						);
						if($has_certificate){
							$grade['label']= _x('Passed','certificate status','wplms');
							$grade['key']= 'passed';
						}
						if($has_badge){
							$grade['label'] .= ' '._x('Excelled','certificate status','wplms');
							$grade['key'] .= 'excel';
						}
						$courses[]=array(
							'id'=>get_the_ID(),
							'img'=>get_the_post_thumbnail_url(),
							'title'=>get_the_title(),
							'instructor'=>apply_filters('wplms_course_instructor',get_the_author_id()),
							'certificate'=>$has_certificate,
							'badge'=>$has_badge,
							'grade'=>$grade,
						);
					}
				}else{
					return new WP_REST_Response( array('status'=>0,'message'=>__('No courses','wplms')), 200 );
				}
				$return = array('status'=>1,'courses'=>$courses,'total'=>$results->found_posts);
			}else{
				$return = array('status'=>0,'message'=>__('No finished courses','wplms'));
			}


			return new WP_REST_Response( $return, 200 );
		}

		function get_student_comments($request){
			
			$body = json_decode($request->get_body(),true);

			$args = array(
				'search' => $body['s'],
				'number'=>20,
				'status'=>'approve',
				'paged'=>$body['page'],
				'parent'=>0,
				'user_id'=>$this->user->id
			);

			if($body['type'] == 'discussions'){
				$args['type'] = 'public';
				$args['post_type'] = 'unit';
			}

			if($body['type'] == 'notes'){
				$args['type'] = 'note';
				$args['post_type'] = 'unit';
			}

			if($body['type'] == 'reviews'){
				//$args['type'] = 'public';
				$args['post_type'] = 'course';
			}

			if(!empty($body['post_id'])){
				$args['post_id']=$body['post_id'];
			}



			$comments_query = new WP_Comment_Query;
			$args = apply_filters('wplms_get_student_comments',$args,$body,$this->user->id);
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

			    	if(!empty($body['fetch_meta'])){
						foreach($body['fetch_meta'] as $meta_key){
							$comment[$meta_key] = get_comment_meta($comment_result->comment_ID,$meta_key,true);
						}
					}
			    	if($body['type'] == 'notes'){
		    			$comment['unit']=array('id'=>$comment_result->comment_post_ID,'title'=>get_the_title($comment_result->comment_post_ID),'icon'=>wplms_get_element_icon(wplms_get_element_type($comment_result->comment_post_ID,'unit')));
		    			$comment['context'] = get_comment_meta($comment_result->comment_ID,'context',true);
			    	}
			    	if($body['type'] == 'discussions'){


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
					    
			    	}
			    	if($body['type'] == 'reviews'){
		    			$comment['course']=array('id'=>$comment_result->comment_post_ID,'title'=>get_the_title($comment_result->comment_post_ID));
		    			$comment['rating'] = get_comment_meta($comment_result->comment_ID,'review_rating',true);
		    			$comment['title'] = get_comment_meta($comment_result->comment_ID,'review_title',true);

		    			$nargs = array(
				            'parent' => $comment_result->comment_ID,
				            'hierarchical' => true,
			           	);
			           	
				        $chain = get_comments($nargs);
				        if(!empty($chain)){
				        	foreach($chain as $k=>$el){
				        		$chain[$k]['comment_date']=strtotime($comment_result->comment_date);
				        	}
				        }
				        $comment['chain'] = $chain;
			    	}

			    	$comments[]=$comment;
			    }

			    $return = array('status'=>1,'comments'=>$comments);
			} else {
				if($body['type'] == 'reviews'){
					$message = __('No reviews found.','wplms');
				}else if($body['type'] == 'discussions'){
					$message = __('No discussions found.','wplms');
				}else{
					$message = __('No notes found.','wplms');
				}
			    $return = array('status'=>0,'message'=>$message);
			}

			return new WP_REST_Response( $return, 200 );
		}

		function get_course_tabs($request){
			$body = json_decode($request->get_body(),true);
			$course_id = $body['courseId'];

			$tabs = array(
                'overview'=>__('Overview','wplms'),
                'curriculum'=>__('Curriculum','wplms'),
                'announcementsnews'=>__('Announcements & News','wplms'),
                'qna'=>__('QnA','wplms'),
                'notes'=>__('Notes','wplms'),
            );

			if(function_exists('bp_is_active') && bp_is_active('groups')){
				$group_id = get_post_meta($course_id,'vibe_group',true);
				if(!empty($group_id) && is_numeric($group_id)){
					$tabs['external__groups_view_'.$group_id] = __('Group','wplms');	
				}
			}

			if(function_exists('bbpress')){
				$forum_id = get_post_meta($course_id,'vibe_forum',true);
				if(!empty($forum_id) && is_numeric($forum_id)){
					$tabs['external__forums_forums_'.$forum_id] = __('Forum','wplms');
				}
			}			
            
			$tabs = apply_filters('wplms_get_course_tabs',$tabs,$course_id,$this->user->id);
			$curriculum = bp_course_get_curriculum($course_id);
			if(empty($curriculum)){
				unset($tabs['curriculum']);
			}
            
            return new WP_REST_Response( array('status'=>1,'tabs'=>$tabs), 200 );
		}

		function get_course_tab($request){
			$body = json_decode($request->get_body(),true);

			$course_id = $body['courseId'];
			if($body['tab'] == 'curriculum'){
				$curriculum_items = bp_course_get_curriculum($body['courseId']);
				if(empty($curriculum_items)){
					return new WP_REST_Response( array('status'=>0,'curriculum'=>false), 200 );
				}
				$curriculum = array();
				foreach($curriculum_items as $kk => $item){

					if(is_numeric($item)){
						$type = bp_course_get_post_type($item);
						if($type == 'unit'){

							$user_progress = bp_course_check_unit_complete($item,$this->user->id,$course_id);
							if($user_progress == 1){$user_progress = 100;}
	                        
	                    }else if($type == 'quiz'){

	                    	$status = bp_course_get_user_quiz_status($this->user->id,$item);
	                    	switch($status){
	                    		case 1:
	                    			$user_progress = 10;
	                    		break;
	                    		case 2:
	                    			$user_progress = 50;
	                    		break;
	                    		case 3:
	                    		case 4:
	                    			$user_progress = 100;
	                    		break;
	                    		default:
	                    			$user_progress = 0;
	                    		break;
	                    	}
	                    	
	                        
	                    }else if($type == 'wplms-assignment'){
	                    	$unittaken = get_post_meta($item,$this->user->id,true);
	                    	if($unittaken == 0){
								$user_progress = 50;
	                    	}else if($unittaken > 0){
	                			$user_progress = 100;
	                    	}else{
	                    		$user_progress = 0;
	                    	}
	                    }

	                    $duration = get_post_meta($item,'vibe_duration',true);
						if( empty($duration) )
							$duration = 0;
						$_type = $type;
						if($_type=='wplms-assignment'){
							$_type = 'assignment';
						}
						
						$duration_parameter = apply_filters("vibe_".$_type."_duration_parameter",60,$item);
						$total_duration = $duration*$duration_parameter;

						$curriculum[]=array(
							'key' => $kk,
							'type'=>$type,
							'label'=>get_the_title($item),
							'duration'=>$total_duration,
							'icon'=>wplms_get_element_icon(wplms_get_element_type($item,bp_course_get_post_type($item))),
							'progress'=>$user_progress
						);	
					}else{
						if(strpos($item,'--') === 0){
							$curriculum[]=array('key' => $kk,'type'=>'sub_section','label'=>$item);	
						}else{	
							$curriculum[]=array('key' => $kk,'type'=>'section','label'=>$item);	
						}
						
					}
					
				}
				return new WP_REST_Response( array('status'=>1,'curriculum'=>$curriculum), 200 );
			}
		}


		function ask_question($request){
			$body = json_decode($request->get_body(),true);
			$comment = $body['comment'];
			if($comment['user_id'] != $this->user->id){
				return new WP_REST_Response( array('status'=>0,'message'=>__('Can only convert your comment to question.','wplms')), 200 );
			}

			$instructor_id = get_post_field( 'post_author', $body['course_id'] );
			update_comment_meta($comment['comment_ID'],'question',1);
			update_comment_meta($comment['comment_ID'],'instructor',$instructor_id);
			update_comment_meta($comment['comment_ID'],'course_id',$body['course_id']);
			return new WP_REST_Response( array('status'=>1,'message'=>__('Instructor notified about this question.','wplms')), 200 );
		}


		function get_announcement($request){
			$body = json_decode($request->get_body(),true);
			if(!empty($body['course'])){
				$announcement = get_post_meta($body['course'],'announcement',true);
		        $announcement_type = get_post_meta($body['course'],'announcement_student_type',true);
		       
	            if(!empty($announcement)){
	            	return new WP_REST_Response( array('status'=>1,'announcement'=>$announcement,'student_type'=>$announcement_type), 200 );
	            }
			}
			return new WP_REST_Response( array('status'=>0,'message'=>__('No announcements for course.','wplms')), 200 );
		}

		function get_news($request){
			
			$args = json_decode($request->get_body(),true);

	        $news_args = array(
	            'post_type'=>'news',
	            'posts_per_page'=>20,
	            'paged'=>empty($args['paged'])?'':$args['paged'],
	            's'=>empty($args['s'])?'':$args['s'],
	            'orderby'=>$args['orderby'],
	            'order'=>$args['order'],	            
	        );

	        if(!empty($args['course'])){
	        	$news_args['meta_query']=array(
	            	'relation'=>'AND',
	            	array(
	            		'key'=>'vibe_news_course',
	            		'value'=>$args['course'],
	            		'compare'=>'='
	            	)
	            );
	        }

	        $news_query = new WP_Query($news_args);

	        $return = array(
	            'status'=>1,
	            'articles'=>[]
	        );

	        if($news_query->have_posts()){
	            $return['total']=$news_query->found_posts;
	            while($news_query->have_posts()){
	                $news_query->the_post();
	                
	                global $post;
	                $news=array(
	                    'id'=>$post->ID,
	                    'post_title'=>$post->post_title,
	                    'post_date'=>strtotime($post->post_date),
	                    'post_content'=>$post->post_content,
	                    'raw'=>get_post_meta($post->ID,'raw',true),
	                    'post_author'=>$post->post_author,
	                    'img'=>get_the_post_thumbnail_url($post->ID,'large')
	                );

	                $return['news'][]=$news;
	            }
	        }else{
	            $return = array(
	                'status'=>0,
	                'message'=>_x('No News found !','api','wplms')
	            );
	        }

	        return new WP_REST_Response($return, 200 );
		}

		function apply_course($request){
			$body = json_decode($request->get_body(),true);
			$course_id = $body['id'];

			if(!empty($course_id) && !empty($this->user->id)){
				update_user_meta($this->user->id,'apply_course'.$course_id,$course_id);
			    do_action('wplms_user_course_application',$course_id,$this->user->id);
			    $return  =array('status'=>true,'message'=>_x('Applied for course','','wplms'));
			}else{
				$return  =array('status'=>false,'message'=>_x('Data missing','','wplms'));
			}
			
		    return new WP_REST_Response( $return, 200 );
		}

		function course_button($request){
			$body = json_decode($request->get_body(),true);
			$course_id = $body['id'];

			

			$return = array('status'=>1,'text'=>'','link'=>apply_filters('bp_course_api_course_link',bp_core_get_user_domain($this->user->id).'#component=course&action=course&id='.$course_id),'extras'=>[]);
			if(bp_course_is_member($course_id, $this->user->id)){
				$time = bp_course_get_user_expiry_time($this->user->id,$course_id);
				
				if($time > time()){
					$stop_course_status = apply_filters('wplms_before_course_status_api',false,$course_id,$this->user->id);

					if($stop_course_status && is_array($stop_course_status) && !empty($stop_course_status['error_code'])){
						$return['error'] = $stop_course_status;

					}


					$statuses = bp_course_get_user_statuses();
					$status = bp_course_get_user_course_status($this->user->id,$course_id);
					$return['text'] = $statuses[$status];
					if(function_exists('vibe_get_option')){
						$take_course = vibe_get_option('take_course_page');
						if(!empty($take_course)){
							if(function_exists('vibe_get_customizer')){
				                $layout = vibe_get_customizer('course_layout');
				                if($layout!=='blank'){
				                	$return['form'] =  get_permalink($take_course);
				                	
				                }
				            }
						}
					}
				}else{

					$free=get_post_meta($course_id,'vibe_course_free',true);
					if( !empty($free) && $free=='S'){
						$t = bp_course_add_user_to_course($this->user->id,$course_id);
				        if($t){

				            $new_duration = apply_filters('wplms_free_course_check',$t);
				            $coursetaken = $new_duration;
				            $statuses = bp_course_get_user_statuses();
							$status = bp_course_get_user_course_status($this->user->id,$course_id);
							$return['text'] = $statuses[$status];
				        }
					}else{
						$pid=get_post_meta($course_id,'vibe_product',true);
						if(!empty($pid)){
							$pid=apply_filters('wplms_course_product_id',$pid,$course_id,-1); // $id checks for Single Course page or Course page in the my courses section
				            if(is_numeric($pid)){
				              $pid=get_permalink($pid);
				              $check=vibe_get_option('direct_checkout');
				              $check =intval($check);
				              if(isset($check) &&  $check){
				                $pid .= '?redirect';
				              }
				            }

				            $return['link'] = $pid;
				            $return['text'] = __('Course Expired','wplms');
			            	$return['meta'][]= __('Click to renew','wplms');
						}else{
							if ( in_array( 'paid-memberships-pro/paid-memberships-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

								$membership_ids = vibe_sanitize(get_post_meta($course_id,'vibe_pmpro_membership',false));
								if(isset($membership_ids) && is_Array($membership_ids) && count($membership_ids) && function_exists('pmpro_getAllLevels')){
								//$membership_id = min($membership_ids);
								$levels=pmpro_getAllLevels();
									foreach($levels as $level){
										if(in_array($level->id,$membership_ids)){
											$link = get_option('pmpro_levels_page_id');
											$link = get_permalink($link).'#'.$level->id;
											$return['link'] = $link;
				            				$return['text'] = __('Course Expired','wplms');
			            					$return['meta'][]= __('Click to renew','wplms');
				            				break;
										}
									}
							    }
							}
						}
			            
		            }

				}
			}else{
				//check course is free. Click to enroll
				
				$free=get_post_meta($course_id,'vibe_course_free',true);
		        if( !empty($free) && $free=='S'){
		        	$auto_subscribe = 1;
	            	$auto_subscribe = apply_filters('wplms_auto_subscribe',$auto_subscribe,$course_id);
				    if($auto_subscribe){  
				        $t = bp_course_add_user_to_course($this->user->id,$course_id);
				        if($t){

				            $new_duration = apply_filters('wplms_free_course_check',$t);
				            $coursetaken = $new_duration;
				            $statuses = bp_course_get_user_statuses();
							$status = bp_course_get_user_course_status($this->user->id,$course_id);
							$return['text'] = $statuses[$status];
				        }      
				    }
					
	            }else{
	            	$apply=get_post_meta($course_id,'vibe_course_apply',true);
					if(!empty($apply) && $apply=='S'){

						$applied=get_user_meta($this->user->id,'apply_course'.$course_id,true);
						if(empty($applied)){
							$return['link'] = '#apply';
					        $return['text'] = __('Apply for Course','wplms');
						}else{
							$return['link'] = '#applied';
					        $return['text'] = __('Applied for Course','wplms');
						}
						
					}else{
						$pid=get_post_meta($course_id,'vibe_product',true);
						if(!empty($pid)){
							$pid=apply_filters('wplms_course_product_id',$pid,$course_id,-1); // $id checks for Single Course page or Course page in the my courses section
				            if(is_numeric($pid)){
				              $pid=get_permalink($pid);
				              $check=vibe_get_option('direct_checkout');
				              $check =intval($check);
				              if(isset($check) &&  $check){
				                $pid .= '?redirect';
				              }
				            }

				            $return['link'] = $pid;
				            $return['text'] = __('Take this course','wplms');
						}else{
							if ( in_array( 'paid-memberships-pro/paid-memberships-pro.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

								$membership_ids = vibe_sanitize(get_post_meta($course_id,'vibe_pmpro_membership',false));
								if(isset($membership_ids) && is_Array($membership_ids) && count($membership_ids) && function_exists('pmpro_getAllLevels')){
								//$membership_id = min($membership_ids);
								$levels=pmpro_getAllLevels();
									foreach($levels as $level){
										if(in_array($level->id,$membership_ids)){
											$link = get_option('pmpro_levels_page_id');
											$link = get_permalink($link).'#'.$level->id;
											$return['link'] = $link;
				            				$return['text'] = __('Take this course','wplms');
				            				break;
										}
									}
							    }
							}
						}
			            
					}
	            }
				
				
				
				//get seats or start date
			}
			
			$starts = bp_course_get_start_date($course_id,$this->user->id);
			$seats = bp_course_get_max_students($course_id,$this->user->id);
			if(!empty($starts) && strtotime($starts) > time()){
				$return ['extras'][]= sprintf(_x('Starts %s','button','wplms'),date_i18n( get_option('date_format'), strtotime($starts) ));
			}
			if(!empty($seats) && $seats < 9999 ){
				$return ['extras'][]= sprintf(_x('Seats %d','button','wplms'),$seats);
			}
			
			
			
			return new WP_REST_Response( $return, 200 );
		}
	}//end of class
}
