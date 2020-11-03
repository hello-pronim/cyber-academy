<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://ays-pro.com/
 * @since      1.0.0
 *
 * @package    Secure_Copy_Content_Protection
 * @subpackage Secure_Copy_Content_Protection/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Secure_Copy_Content_Protection
 * @subpackage Secure_Copy_Content_Protection/public
 * @author     Security Team <info@ays-pro.com>
 */
class Secure_Copy_Content_Protection_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		add_shortcode( 'ays_block', array( $this, 'sccp_blockcont_generate_shortcode' ) );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		//Elementor plugin conflict solution
		if (isset($_GET['action']) && $_GET['action'] == 'elementor') {
			return false;
		}

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Secure_Copy_Content_Protection_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Secure_Copy_Content_Protection_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ($this->check_enable_sccp()) {
			wp_enqueue_style($this->plugin_name.'-public', plugin_dir_url(__FILE__) . 'css/secure-copy-content-protection-public.css', array(), $this->version, 'all');
		}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		//Elementor plugin conflict solution
		if (isset($_GET['action']) && $_GET['action'] == 'elementor') {
			return false;
		}
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Secure_Copy_Content_Protection_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Secure_Copy_Content_Protection_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ($this->check_enable_sccp()) {
			wp_enqueue_script('jquery');
			wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/secure-copy-content-protection-public.js', array('jquery'), $this->version, false);
		}
	}

	public function sccp_blockcont_generate_shortcode( $atts, $content ) {
		wp_enqueue_style($this->plugin_name.'-block-content', plugin_dir_url(__FILE__) . 'css/block_content_public.css', array(), $this->version, 'all');
		global $wpdb;
		$id = esc_sql($atts['id']);
		$bc_table = esc_sql(SCCP_BLOCK_CONTENT);

		$sccp_result = $wpdb->get_row(
					    $wpdb->prepare( 'SELECT * FROM '. $bc_table .' WHERE id = %d',
					        $id
					    )
					);		
		$result = (array) $sccp_result;

		$sccp_wpdb_id = isset($result['id']) && $result['id'] != null ? absint( intval($result['id'])) : null;
		
		if ( !session_id() ) {
			session_start();
		}

		if ($result == null) {				
			return do_shortcode($content);
		}

		$options = json_decode($result['options'], true);
		$bc_schedule_from = isset($options['bc_schedule_from']) && !empty($options['bc_schedule_from']) ? strtotime($options['bc_schedule_from']) : false;
		$bc_schedule_to	  = isset($options['bc_schedule_to']) && !empty($options['bc_schedule_to']) ? strtotime($options['bc_schedule_to']) : false;
		$pass_count = isset($options['pass_count']) ? intval($options['pass_count']) : 0;
		$pass_limit = isset($options['pass_limit']) && ($options['pass_limit'] != 0 ) ? intval($options['pass_limit']) : 0;
		$pass_count = intval($pass_count);
		$pass_limit = intval($pass_limit);
		$not_expired = true;
		$current_time = strtotime(current_time( "Y:m:d H:i:s" ));

		if ($bc_schedule_from && $bc_schedule_to) {
			if ($bc_schedule_from < $current_time && $bc_schedule_to > $current_time) {
				$not_expired = true;
			}else{
				$not_expired = false;
			}
		}
		$check_session_id = isset($_SESSION['ays_bc_user'][$id]) ? $_SESSION['ays_bc_user'][$id] : false;

		if ($pass_count >= $pass_limit && $pass_limit != 0 && $check_session_id != true){				    
			return '';
		}else{
			if ($not_expired) {
				if (isset($options['user_role']) && !empty($options['user_role'])) {
					$role_check = true;
					$pass_check = false;
				}else{
					$pass_check = isset($result['password']) && !empty($result['password']) ? true : false;
					$role_check = false;
				}
				if ($role_check) {
					$user = wp_get_current_user();
					$user_role = isset($user->roles[0]) && !empty($user->roles[0]) ? $user->roles[0] : '';
					
					if (isset($options['user_role']) && !empty($options['user_role'])) {
						$check_role = $options['user_role'];

						if(in_array($user_role, $check_role)){
							$role_check = true;
						}else{
							$role_check = false;
						}	
					}

					if ($role_check == false) {				
						$con = '';
						return $con;
					}else{
						// ---------AV User role count-----------
						$bc_result_options = json_decode($result['options'], true);
						$user_role_count = isset($bc_result_options['user_role_count']) ? intval($bc_result_options['user_role_count']) : 0;
						$user_role_count = intval($user_role_count);
						$user_role_count++;

						$bc_options = array(
							'user_role'	 		 =>  $bc_result_options['user_role'],
							'pass_count'		 =>  $bc_result_options['pass_count'],
							'user_role_count'	 =>  $user_role_count,
							'pass_limit'		 =>  isset($bc_result_options['pass_limit']) ? $bc_result_options['pass_limit'] : 0,
							'bc_schedule_from'	 =>  $bc_result_options['bc_schedule_from'],
							'bc_schedule_to'	 =>  $bc_result_options['bc_schedule_to']
						);
						$bc_options = json_encode($bc_options);
						$table = esc_sql(SCCP_BLOCK_CONTENT);

						if ($sccp_wpdb_id != $id) {
							$wpdb->insert( $table,
						        array(
						            'options' 	=> $bc_options
						        ),
							    array( '%s' )
							);
						}else{
							$wpdb->update( $table,
						        array(
						            'options' 	=> $bc_options
						        ),
						        array( 'id' => $id ),
							    array( '%s' ),
							    array( '%d' )
							);
						}					

						return do_shortcode($content);
					}

				}elseif($pass_check){
					if ( !session_id() ) {
						session_start();
					}

					global $wpdb;
					$sccp_table = esc_sql(SCCP_TABLE);
					$sccp_result = $wpdb->get_row("SELECT * FROM " . $sccp_table . " WHERE id = 1", ARRAY_A);
					$sccp_data   = json_decode($sccp_result["options"], true);

					$bc_header_text = isset($sccp_data["bc_header_text"]) && !empty($sccp_data["bc_header_text"]) ? stripslashes($sccp_data["bc_header_text"]) : __('You need to Enter right password', $this->plugin_name);

			        if (!isset($_SESSION['ays_bc_user'])) {
			        	$_SESSION['ays_bc_user'] = array();
			        }

					$con = do_shortcode('<div class="conblock_div">
								<p>' . $bc_header_text . '</p>
								<div class="conblock_icon">
									<img src="'.SCCP_PUBLIC_URL.'/images/lock.png" class="ays_sccp_lock" alt="Lock">
								</div>
								<form action="" method="post">
									<input type="password" required name="pass_form" placeholder="'.__('Password').'">
									<input type="submit" name="sub_form_'.$id.'" value="'.__('Submit').'">
								</form>
							</div>');
					if(isset($_SESSION['ays_bc_user'][$id]) && $_SESSION['ays_bc_user'][$id] == true) {
					    $con = do_shortcode($content);
					    return $con;
				    }

					$pass = $result['password'];
					if (isset($_POST['sub_form_'.$id.''])) {
						$check_pass = isset($_POST['pass_form']) && $_POST['pass_form'] == $pass ? true : false ;
						if ($check_pass) {
						// ---------AV Password count-----------					
							$bc_result_options = json_decode($result['options'], true);
							$pass_count++;
							$bc_options = array(
								'user_role'	 		 =>  $bc_result_options['user_role'],
								'pass_count'		 =>  $pass_count,
								'pass_limit'		 =>  isset($bc_result_options['pass_limit']) ? $bc_result_options['pass_limit'] : 0,
								'user_role_count'	 =>  $bc_result_options['user_role_count'],
								'bc_schedule_from'	 =>  $bc_result_options['bc_schedule_from'],
								'bc_schedule_to'	 =>  $bc_result_options['bc_schedule_to']
							);
							$bc_options = json_encode($bc_options);
							$table = esc_sql(SCCP_BLOCK_CONTENT);
							
							if ($sccp_wpdb_id != $id) {
								$wpdb->insert( $table,
							        array(
							            'options' 	=> $bc_options
							        ),
								    array( '%s' )
								);
							}else{
								$wpdb->update( $table,
							        array(
							            'options' 	=> $bc_options
							        ),
							        array( 'id' => $id ),
								    array( '%s' ),
								    array( '%d' )
								);
							}

							$_SESSION['ays_bc_user'][$id] = true;
						}else{
							$_SESSION['ays_bc_user'][$id] = false;
						}

						if ($_SESSION['ays_bc_user'][$id]) {
					        $con = do_shortcode($content);
				        }
					}

					return $con;

				}else{			
					return do_shortcode($content);
				}
			}else{
				return '';
			}
		}	
	}

	public function check_enable_sccp() {
		global $wpdb;
		$sccp_table = esc_sql(SCCP_TABLE);
		$sql = "SELECT COUNT(*) FROM ".$sccp_table;
		$count = $wpdb->get_var($sql);
		if ($count == 0) {
			$enable_protection = 0;
			$except_types      = array();
		} else {
			$sccp_table = esc_sql(SCCP_TABLE);
			$sql = "SELECT * FROM " . $sccp_table . " WHERE id = 1";
			$data = $wpdb->get_row($sql, ARRAY_A);

			$enable_protection = (isset($data['protection_status']) && $data['protection_status'] == 1) ? 1 : 0;
			$except_types      = (isset($data['except_post_types']) && !empty($data['except_post_types'])) ? json_decode($data['except_post_types'], true) : array();
		}
		
		if (is_front_page()) {
			$this_post_type = "page";
		} else {
			$this_post_type = get_post_type();
		}

		if ($enable_protection == 1 && !in_array($this_post_type, $except_types)) {
			return true;
		}
		
		return false;
	}

	public function ays_get_notification_text( $text_only = false ) {
		global $wpdb;
		$sccp_table = esc_sql(SCCP_TABLE);
		$sql = "SELECT COUNT(*) FROM ".$sccp_table;
		$count = $wpdb->get_var($sql);
		if ($count == 0) {
			$enable_protection = 0;
			$except_types      = array();
			$styles            = array(
				"bg_color"         => "#ffffff",
				"bg_image"         => "",
				"tooltip_opacity"  => "1",
				"text_color"       => "#ff0000",
				"font_size"        => "12",
				"border_color"     => "#b7b7b7",
				"boxshadow_color"  => "rgba(0,0,0,0)",
				"border_width"     => "1",
				"border_radius"    => "3",
				"border_style"     => "solid",
				"tooltip_position" => "mouse",
				"tooltip_padding"  => "5"
			);
			$notf_text         = __('You cannot copy content of this page', $this->plugin_name);
			$audio             = '';
		} else {
			$sccp_table = esc_sql(SCCP_TABLE);
			$sql = "SELECT * FROM " . $sccp_table . " WHERE id = 1";
			$data = $wpdb->get_row($sql, ARRAY_A);
			$notf_text         = $data['protection_text'];
			$style             = json_decode($data["styles"], true);
			$options           = json_decode($data["options"], true);
			$styles            = array(
				"bg_color"         		=> isset($style['bg_color']) ? $style['bg_color'] : "#ffffff",
				"bg_image"         		=> isset($style['bg_image']) ? $style['bg_image'] : "",
				"tooltip_opacity"  		=> isset( $style['tooltip_opacity']) ? $style['tooltip_opacity'] : "",
				"text_color"       		=> isset($style['text_color']) ? $style['text_color'] : "#ff0000",
				"font_size"        		=> isset($style['font_size']) ? $style['font_size'] : "12",
				"border_color"     		=> isset($style['border_color']) ? $style['border_color'] : "#b7b7b7",
				"boxshadow_color"     	=> isset($style['boxshadow_color']) ? $style['boxshadow_color'] : "rgba(0,0,0,0)",
				"border_width"     		=> isset($style['border_width']) ? $style['border_width'] : "1",
				"border_radius"    		=> isset($style['border_radius']) ? $style['border_radius'] : "3",
				"border_style"     		=> isset($style['border_style']) ? $style['border_style'] : "solid",
				"tooltip_position" 		=> isset($style['tooltip_position']) ? $style['tooltip_position'] : "mouse",
				"tooltip_padding"  		=> isset($style['tooltip_padding']) ? $style['tooltip_padding'] : "5",
				"ays_sccp_custom_class" => isset($style['ays_sccp_custom_class']) ? $style['ays_sccp_custom_class'] : "",
				"custom_css"       		=> isset($style['custom_css']) ? $style['custom_css'] : "",
			);
			$audio          = $data['audio'];
			$custom_class 	= isset($style['ays_sccp_custom_class']) && !empty($style['ays_sccp_custom_class']) ? "class='".$style['ays_sccp_custom_class']."'" : "";
		}

		if ($text_only) {
			return $notf_text;
		}

		if ($this->check_enable_sccp()) {

			if (!empty($audio)) {
				echo "<audio id='sccp_public_audio'>
                  <source src=" . $audio . " type='audio/mpeg'>
                </audio>";
			}

			$av_bg_image = '';
			if (isset($styles["bg_image"]) && !empty($styles["bg_image"])) {
				$av_bg_image = 'background-image: url('.$styles["bg_image"].');';	
			}

			echo '<div id="ays_tooltip" '.$custom_class.'>' . $notf_text . '</div>
                    <style>
                        #ays_tooltip {
                    		display: none;
                    		position: absolute;
    						z-index: 999999999;
                            background-color: ' . $styles["bg_color"] . ';
                            '.$av_bg_image.'
                            background-repeat: no-repeat;
                            background-size: cover;
                            opacity:' . $styles["tooltip_opacity"] . ';
                            border: ' . $styles["border_width"] . 'px ' . $styles["border_style"] . ' ' . $styles["border_color"] . ';
                            border-radius: ' . $styles["border_radius"] . 'px;
                            box-shadow: ' . $styles["boxshadow_color"] . ' 0px 0px 15px 1px;
                            color: ' . $styles["text_color"] . ';
                            padding: ' . $styles["tooltip_padding"] . 'px;
                            font-size: ' . (isset($styles["font_size"]) ? $styles["font_size"] : "12") . 'px;
                        }
                        
                        #ays_tooltip > * {
                            color: ' . $styles["text_color"] . ';
                            font-size: ' . (isset($styles["font_size"]) ? $styles["font_size"] : "12") . 'px;
                        }
                       ' . (isset($styles["custom_css"]) ? $styles["custom_css"] : "") . '
                    </style>
            ';
			include_once('partials/secure-copy-content-protection-public-display.php');
		}

		if (isset($options['disable_js']) && $options['disable_js'] == 'checked') {
			echo '<div id="ays_noscript" style="display:none;">
					<p>Javascript not detected. Javascript required for this site to function. Please enable it in your browser settings and refresh this page.</p>
			  	  </div>
			  	  <noscript> 
			  	 	<style>
			  	 		#ays_noscript{
			  	 			display:flex !important;
		  	 			}
		  	 			html{
	 				        pointer-events: none;
	    					user-select: none;
		  	 			}
	  	 			</style>
	  	 		  </noscript>';			
		}

	}

	public function hex2rgba( $color, $opacity = false ) {

		$default = 'rgb(0,0,0)';

		//Return default if no color provided
		if (empty($color)) {
			return $default;
		}

		//Sanitize $color if "#" is provided
		if ($color[0] == '#') {
			$color = substr($color, 1);
		}

		//Check if color has 6 or 3 characters and get values
		if (strlen($color) == 6) {
			$hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
		} elseif (strlen($color) == 3) {
			$hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
		} else {
			return $default;
		}

		//Convert hexadec to rgb
		$rgb = array_map('hexdec', $hex);

		//Check if opacity is set(rgba or rgb)
		if ($opacity) {
			if (abs($opacity) > 1) {
				$opacity = 1.0;
			}
			$output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
		} else {
			$output = 'rgb(' . implode(",", $rgb) . ')';
		}

		//Return rgb(a) color string
		return $output;
	}	

	public static function isMobileDevice(  ) {
		$aMobileDevs = array(
			'/iphone/i' => 'iPhone',
			'/ipod/i' => 'iPod',
			'/ipad/i' => 'iPad',
			'/android/i' => 'Android',
			'/blackberry/i' => 'BlackBerry',
			'/webos/i' => 'Mobile'
		);

		//Return true if Mobile User Agent is detected
		foreach($aMobileDevs as $sMobileKey => $sMobileOS){
			if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
				return true;
			}
		}
		//Otherwise return false..
		return false;
	}
}
