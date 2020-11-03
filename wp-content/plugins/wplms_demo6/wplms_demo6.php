<?php
/*
Plugin Name: WPLMS Demo6 Sample Data
Plugin URI: http://www.vibethemes.com
Description: Install WPLMS Demo 6 in your site ( http://themes.vibethemes.com/wplms/skins/demo6 )
Author: VibeThemes
Version: 1.0
Author URI: http://www.vibethemes.com
Text Domain: wplms-demo6
*/

if ( ! defined( 'ABSPATH' ) ) exit;

class WPLMS_Demo6{

    public static $instance;
    
    public static function init(){

        if ( is_null( self::$instance ) )
            self::$instance = new WPLMS_Demo6();

        return self::$instance;
    }

    private function __construct(){
    	add_filter('wplms_required_plugins',array($this,'required_plugins'));
    	add_filter('wplms_setup_import_file_path',array($this,'import_file_path'),10,2);
    	add_filter('wplms_data_import_url',array($this,'import_url'));

    	add_filter('wplms_setup_options_panel',array($this,'options'));

    	add_action('init',array($this,'sidebars'),5);
    	add_action('wplms_after_sample_data_import',array($this,'wplms_customizer_options'),30);
    	add_filter('wplms_setup_layerslider_file',array($this,'stop_layerslider'));
    	add_action('wplms_after_sample_data_import',array($this,'import_revslider'),99);

    	add_filter('wplms_setup_sidebars_file',array($this,'set_sidebars'));
    	add_filter('wplms_setup_widgets_file',array($this,'set_widgets'));
    	add_filter('wplms_setup_plugins',array($this,'setup_plugins'));
		
		add_filter('wplms_setup_bp_pages',array($this,'pages'));
		
		add_action('wplms_after_sample_data_import',array($this,'add_custom_users'),99,1);
    }

    function pages($pages){
    	$pages['buddydrive'] = 'buddydrive';
    	return $pages;
    }
    function sidebars(){
    	register_sidebar( array(
          	'name' => 'Megamenu',
          	'id' => 'Megamenu',
          	'before_widget' => '<div class="widget"><div class="inside">',
              'after_widget' => '</div></div>',
              'before_title' => '<h4 class="widgettitle"><span>',
              'after_title' => '</span></h4>',
            'description'   => __('This is the MegaMenu sidebar','vibe')
        ));
    }

    function setup_plugins($flag){

    	if(is_plugin_active('revslider/revslider.php') && is_plugin_active('wplms-front-end/wplms-front-end.php') && is_plugin_active('woocommerce/woocommerce.php')){ 
			return false;
		}else{
			return true;
		}
    	return $flag;
    }

    function required_plugins($plugins){
    	unset($plugins[5]);
    	return $plugins;
    }

    function stop_layerslider($file){
    	return '';
    }

    function set_sidebars($file){ 
    	$wplms = wp_get_theme();
		$value=$wplms->get('Version');
		if (version_compare($value, "3.9.3") < 0) {
			return plugin_dir_path(__FILE__)."data/sidebars.txt";
		}
    	return plugin_dir_path(__FILE__)."data/sidebars_json.json";
    }

    function set_widgets($file){
    	$wplms = wp_get_theme();
		$value=$wplms->get('Version');
		if (version_compare($value, "3.9.3") < 0) {
			return plugin_dir_path(__FILE__)."data/widgets.txt";
		}
		return plugin_dir_path(__FILE__)."data/widgets_json.json";
    	
    }

    function import_revslider(){

		$slider_array = array(plugin_dir_path(__FILE__)."data/homeslider.zip");
		$slider = new RevSlider();
		 
		foreach($slider_array as $filepath){
			$slider->importSliderFromPost(true,true,$filepath);  
		}
    }

	function import_file_path($file_path,$file){
	    $file_path = plugin_dir_path(__FILE__).'data/demo6.xml';
	    return $file_path;
	}

	function import_url(){
	    return plugin_dir_url(__FILE__).'data/uploads/';
	}

	// Options panel
	function options($panel){
		//Extra options for options panel
		$panel['logo'] = plugin_dir_url( __FILE__ ).'data/uploads/logo.png';
		$panel['alt_logo'] = plugin_dir_url( __FILE__ ).'data/uploads/logo_black.png';
		$panel['default_avatar'] = plugin_dir_url( __FILE__ ).'data/uploads/jobs.jpg';
		$panel['default_course_avatar'] = plugin_dir_url( __FILE__ ).'data/uploads/f3.jpg';
		$panel['social_icons'] = array('social'=>array('facebook','twitter','dribbble'),'url'=>array('#','#','#'));
		$panel['google_fonts'] = array('Lato-300-latin','Lato-regular-latin','Lato-700-latin','Varela-regular-latin','Varela Round-regular-latin');
		return $panel;
	}

	// Setup  Customizer 
	function wplms_customizer_options(){ 
	    $customizer_file = plugin_dir_path(__FILE__).'data/customiser.txt';
	    if(file_exists($customizer_file)){
	        $myfile = fopen($customizer_file , "r") or die("Unable to open file!".$customizer_file );
	        while(!feof($myfile)) {
	            $string = fgets($myfile);
	        }
	        fclose($myfile);
	        $code = base64_decode(trim($string)); 
	        if(is_string($code)){
	            $code = unserialize($code);
	            if(is_array($code)){
	                update_option('vibe_customizer',$code);
	            }
	        }
	    }
	    
	    // Setup Menus
		$wplms_menus = array(
			'top-menu'=>1,
			'main-menu'=>'main-menu',
			'mobile-menu'=>'footer-links',
			'footer-menu'=>'footer-links',
		);
		// End HomePage setup
		
		//Set Menus to Locations
		$vibe_menus  = wp_get_nav_menus();
		if(!empty($vibe_menus) && !empty($wplms_menus)){ // Check if menus are imported
			//Grab Menu values
			global $wpdb;
			foreach($wplms_menus as $key=>$menu_item){
				$term_id = $wpdb->get_var( $wpdb->prepare( "SELECT term_id FROM {$wpdb->terms} WHERE slug = %s LIMIT 1;", "{$menu_item}" ) );	
				if(isset($term_id) && is_numeric($term_id)){
					$wplms_menus[$key]=$term_id;
				}else{
					unset($wplms_menus[$key]);
				}
			}
			//update the theme
			set_theme_mod( 'nav_menu_locations', $wplms_menus);
			update_post_meta(2428,'_menu_item_sidebar','Megamenu');
			update_post_meta(2428,'_menu_item_menu_width','100%');
			update_post_meta(2428,'_menu_item_columns','4');
		}
		//End Menu setup
	}

	function sidebars_widgets(){

		$sidebars_file = plugin_dir_path(__FILE__)."data/sidebars.txt";

		if(file_exists($sidebars_file)){
			$myfile = fopen($sidebars_file , "r") or die("Unable to open file!".$sidebars_file );
			while(!feof($myfile)) {
				$string = fgets($myfile);
			}
			fclose($myfile);
		    $code = base64_decode(trim($string)); 
		    if(is_string($code)){
		        $code = unserialize($code);
		        if(is_array($code)){
		        	update_option('sidebars_widgets',$code);
		        }
		    }
		}
		$widgets_file = plugin_dir_path(__FILE__)."data/widgets.txt";
		if(file_exists($widgets_file)){
			$myfile = fopen($widgets_file , "r") or die("Unable to open file!".$widgets_file );
			while(!feof($myfile)) {
				$string = fgets($myfile);
			}
			fclose($myfile);
	        $code = base64_decode(trim($string)); 
	        if(is_string($code)){
	            $code = unserialize($code);
	            if(is_array($code)){
	            	foreach($code as $key=>$option){
	            		update_option($key,$option);
	            	}
	            }
	        }
		}
	}

	function add_custom_users(){

		//demo6 specific data

		update_term_meta(26,'course_cat_thumbnail_id',2204);
		update_term_meta(64,'course_cat_thumbnail_id',2205);
		update_term_meta(67,'course_cat_thumbnail_id',2206);
		update_term_meta(74,'course_cat_thumbnail_id',2207);
		update_term_meta(79,'course_cat_thumbnail_id',2208);
		update_term_meta(113,'course_cat_thumbnail_id',2209);



		$social_field_group=array(
					'name' => 'Social Profiles',
					'description' => 'Links to social profiles'
				);
		$social_field_group_id=xprofile_insert_field_group($social_field_group);
		$fields = array(
					array(
						'field_group_id'=>$social_field_group_id,
						'type'=>'url',
						'name'=>'Facebook',
						'description'=>'Facebook profile link'
					),
					array(
						'field_group_id'=>$social_field_group_id,
						'type'=>'url',
						'name'=>'Twitter',
						'description'=>'Twitter profile link'
					),
				);

		foreach($fields as $field){
			xprofile_insert_field($field);	
		}
		
		$users = array(
			array(
					'username'=>'wplms_lynda',
					'password'=>'lynda',
					'email'=>'vibethemes@gmail.com',
					'role'=>'instructor',
					'fields'=>array(
						'Location'=>'New York',
						'Speciality'=>'Design',
						'Bio'=>'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters English.',
						'Facebook'=>'#',
						'Twitter'=>'#',
					),
				),
			array(
					'username'=>'wplms_parker',
					'password'=>'parker',
					'email'=>'support@vibethemes.com',
					'role'=>'instructor',
					'fields'=>array(
						'Location'=>'New York',
						'Speciality'=>'Design',
						'Bio'=>'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters English.',
						'Facebook'=>'#',
						'Twitter'=>'#',
					),
				),
			array(
					'username'=>'wplms_simon',
					'password'=>'simon',
					'email'=>'sample@sample.com',
					'role'=>'instructor',
					'fields'=>array(
						'Location'=>'New York',
						'Speciality'=>'Literature',
						'Bio'=>'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters English.',
						'Facebook'=>'#',
						'Twitter'=>'#',
					),
				),
			array(
					'username'=>'wplms_leon',
					'password'=>'leon',
					'email'=>'sample@example.com',
					'role'=>'instructor',
					'fields'=>array(
						'Location'=>'New York',
						'Speciality'=>'MAths',
						'Bio'=>'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters English.',
						'Facebook'=>'#',
						'Twitter'=>'#',
					),
				),
			);

		foreach($users as $user){
			$user_id = wp_insert_user(array('user_login'=>$user['username'],'user_pass'=>$user['password'],'user_email'=>$user['email'],'role'=>$user['role']));
			if(!is_wp_error($user_id) && function_exists('xprofile_set_field_data')){
				foreach($user['fields'] as $field=>$value){
					xprofile_set_field_data($field,$user_id,$value);
				}
			}
		}
	}
}

WPLMS_Demo6::init();


