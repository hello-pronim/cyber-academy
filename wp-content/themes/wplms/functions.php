<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if(!defined('WPLMS_THEME_FILE_INCLUDE_PATH')){
	define('WPLMS_THEME_FILE_INCLUDE_PATH',get_template_directory());
	//use this if you want to overwrite core functions from includes directory with your child theme
	//copy includes and _inc folder into your child them and define path constant to child theme
	
	//define('WPLMS_THEME_FILE_INCLUDE_PATH',get_stylesheet_directory());
}

if(defined('WPLMS_THEME_FILE_INCLUDE_PATH')){
	// Essentials
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/config.php';
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/init.php';

	// Register & Functions
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/register.php';
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/actions.php';
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/filters.php';
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/func.php';
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/ratings.php'; 
	// Customizer
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/customizer/customizer.php';
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/customizer/css.php';
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/vibe-menu.php';
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/notes-discussions.php';
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/wplms-woocommerce-checkout.php';

	if ( function_exists('bp_get_signup_allowed')) {
	    include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/bp-custom.php';
	}

	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/_inc/ajax.php';
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/buddydrive.php';
	//Widgets
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/widgets/custom_widgets.php';
	if ( function_exists('bp_get_signup_allowed')) {
	 include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/widgets/custom_bp_widgets.php';
	}
	if (function_exists('pmpro_hasMembershipLevel')) {
	    include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/pmpro-connect.php';
	}
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/widgets/advanced_woocommerce_widgets.php';
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/widgets/twitter.php';
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/widgets/flickr.php';

	//Misc
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/includes/extras.php';

	//SETUP
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/setup/wplms-install.php';

	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/setup/installer/envato_setup.php';
	include_once WPLMS_THEME_FILE_INCLUDE_PATH.'/setup/installer/wplms_demo_fixes.php';
}


// Options Panel
get_template_part('vibe','options');
// wplms_course_curriculum_section check this out
		// add_filter('wplms_before_single_course',function($data){
		// 	echo $data;
		// echo "perwaaa";
		// 	print_r($data);
		// // $data[‘description’] = "nabeel the wpexpert";
		// // if($request[‘context’] == ‘full || $request[‘context’] == ‘loggedin’){
		// // $data[‘description’] = "nabeel the wpexpert";
		// // }
		// return $data;
		// },10,2);
		// 
		// 
//Here's my custom CSS that removes the back link in a function
function my_login_page_remove_back_to_link() { ?>
    <style type="text/css">
		body.login{
			background:none !important;
		}
        body.login, body.login form#loginform {
    background: white !Important;
	padding-top: 20px !important;
    padding-bottom: 20px !important;
}
	form#loginform	label {
    color: #333 !important;
    font-weight: bold !important;
    margin-bottom: 10px;
}
		body.login #nav a, body.login #backtoblog a {
    color: #008ec2;
    text-transform: uppercase;
    font-size: 12px !important;
    opacity: 0.8 ;
    font-weight: bold !important;
}
		body.login h1 a {
    background-size: cover !important;
    width: 170px !important;
    height: 95px !important;
}
		.login .privacy-policy-page-link {
    margin: 3em 0 2em !important;
}
		body.login form#loginform .input, body.login form#loginform input[type=text], body.login form#loginform input[type=checkbox] {
    background: #ffffff;
    border-radius: 2px;
    border: 1px solid #bdbdbd;
    color: gray;
}
		.loginpress-show-love {
    display: none !important;
}
    </style>
<?php }

//This loads the function above on the login page
add_action( 'login_enqueue_scripts', 'my_login_page_remove_back_to_link' );





function myscript() {
	//$url = home_url()."/wp-login.php?action=logout&_wpnonce=" . wp_create_nonce( 'log-out' )."&redirect_to=".home_url();
$user = wp_get_current_user();
if ( in_array( 'student', (array) $user->roles ) ) {
    //print_r($user);
	?>
	<script>
	jQuery(".minku-logout a").attr("href", "<?php echo home_url(); ?>/my-account/<?php echo $user->data->user_nicename; ?>/dashboard");
	</script>
	<?php
}elseif ( in_array( 'instructor', (array) $user->roles ) ) {
	?>
	<script>
	jQuery(".minku-logout a").attr("href", "<?php echo home_url(); ?>/my-account/<?php echo $user->data->user_nicename; ?>/dashboard");
	
	jQuery(".my-account.course div#subnav ul li").hide();
	jQuery(".my-account.course div#subnav ul li:last-child").show();
	jQuery(".my-account.course div#subnav ul li:first-child").removeClass('current');
	jQuery(".my-account.course div#subnav ul li:last-child").addClass('current');
	jQuery(".my-account ul li #user-course").attr("href", "<?php echo home_url(); ?>/my-account/<?php echo $user->data->user_nicename; ?>/course/instructor-courses/");
	
	</script>
	<?php	
}elseif ( in_array( 'administrator', (array) $user->roles ) ) {
	?>
	<script>
	jQuery(".minku-logout a").attr("href", "<?php echo home_url(); ?>/wp-admin");
	</script>
	<?php	
}

}
add_action( 'wp_footer', 'myscript' );






function my_login_redirect( $redirect_url,$request_url,$user ) {
    //is there a user to check?
    global $user;
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {

        if ( in_array( 'administrator', $user->roles ) ) {
            // redirect them to the default place
            return home_url('/wp-admin/');
        }else if ( in_array( 'instructor', $user->roles ) ) {
            // redirect them to the default place
            return home_url().'/my-account/'.$user->data->user_nicename.'/dashboard';
        }else if ( in_array( 'student', $user->roles ) ) {
            // redirect them to the default place
            return home_url().'/my-account/'.$user->data->user_nicename.'/dashboard';
        }
		
		
		
    }
}
add_filter( 'login_redirect', 'my_login_redirect', 999, 3 );



function data_deserialize($value){
$output = '';
$data = maybe_unserialize($value);
$data = $data[0];
foreach ($data as $key => $value){
$output .= $key.': '.$value.'
';
}
return $output;
}