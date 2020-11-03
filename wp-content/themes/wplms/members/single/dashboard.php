<?php

/**
 * WPLMS- DASHBOARD TEMPLATE
 */

if ( !defined( 'ABSPATH' ) ) exit;

if(!is_user_logged_in()){
	wp_redirect(home_url(),'302');
}

if(current_user_can('edit_posts')) {
	get_header( 'customizeinstructor' ); 
} else {
	get_header( vibe_get_header() );
}

$profile_layout = vibe_get_customizer('profile_layout');
do_action( 'bp_before_dashboard_body' );

if(current_user_can('edit_posts')){
// 	vibe_include_template("profile/top$profile_layout.php");  
	vibe_include_template("profile/instructor_dashboard.php");  
?>
<div>
	<div class="padder">
		<div class="wplms-dashboard row">
	<?php
			$sidebar = apply_filters('wplms_instructor_sidebar','instructor_sidebar');
            if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar($sidebar) ) : endif; 
		}else{			
			vibe_include_template("profile/student_dashboard.php");  
			$sidebar = apply_filters('wplms_student_sidebar','student_sidebar');
            if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar($sidebar) ) : endif; 
		}
	?>
	<?php do_action( 'bp_after_dashboard_body' ); ?>
	<?php
		if(current_user_can('edit_posts')){
	?>
		</div>	<!-- .wplms-dashbaord -->
<?php
		}
vibe_include_template("profile/bottom.php");  

get_footer( vibe_get_footer() );  						