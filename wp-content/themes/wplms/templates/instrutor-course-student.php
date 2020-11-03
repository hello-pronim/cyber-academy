<?php 
/* Template Name: Instructor Students */
get_header('sleek'); ?>

<?php 


$user = wp_get_current_user();
if ( in_array( 'instructor', (array) $user->roles ) ) {
?>
<section id="content">
	<div id="buddypress">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<a class="mink-back" onclick="goBack()">Back</a>				
					<script>
					function goBack() {
					  window.history.back();
					}
					</script>
				</div>
			</div>
			
				
				<div class="row">
				<?php
				if ( is_user_logged_in() ):

					global $current_user;
					wp_get_current_user();
					$author_query = array('post_type'=> 'course','posts_per_page' => '-1','author' => $current_user->ID);
					$author_posts = new WP_Query($author_query);
					
					$count = $author_posts->post_count;
					
					$i=0; while($author_posts->have_posts()) : $author_posts->the_post(); $i++;
						/*
						if($count>1){
						$id[] = get_the_ID();
						$title[] = get_the_title();
						}else{
						$id = get_the_ID();	
						$title = get_the_title();
						}
						*/
						
					?>
					
					<?php $id = get_the_ID(); 
					$results = $wpdb->get_results( "SELECT user_id FROM esalSKkOusermeta WHERE meta_key = '$id'");	
					?>
					
					<div class="customize-inst-content col-md-6">
					<h2><?php the_title(); ?></h2>
					<div class="dash-widget">
						<div id="wplms_customize_instructor_users-2" class="wplms_customize_instructor_users">
							<div class="instructor_customize_three_part"><span class="instructor_user_active"><i class="fa fa-users" aria-hidden="true"></i></span><p>Students</p></div>
								<ul class="widget_users_list">
								<li class="customize_bp_user_title"><p>User Name</p></li>
								<div class="instructor_users_list">
								<?php foreach($results as $result){ 
								
								$data = get_userdata($result->user_id);
								//echo '<pre>';
								//print_r($data);
								//echo '</pre>';
								?>
								<li>
									<img src="<?php echo get_avatar_url($result->user_id); ?>" class="avatar user-42-avatar avatar-150 photo" width="150" height="150" alt="Profile Photo">
									<div class="customize_bp_user_info"><p><?php echo $data->data->display_name; ?></p><p><?php echo $data->data->user_email; ?></p></div>
								
									
								</li>								
									
								<?php } ?>	
								</div>
								</ul>
						</div>
					</div>	
					</div>
					
					<?php endwhile; else : ?>
						<p><?php echo 'You are not instructing any course so you dont have any students right now.'; ?></p>
					<?php endif; ?>
					<?php if($results == ''){ ?>
					<p><?php echo 'You are not instructing any course so you dont have any students right now.'; ?></p>
					<?php } ?>
				
				</div>
				
				
				
		</div>
	</div>
</section>	
<?php  
}else{
?>
<script>
window.location.replace("<?php echo home_url(); ?>");
</script>
<?php 
}
?>
<?php get_footer('customize'); ?>
<style>
.dash-widget {
    padding: 20px;
    background: #FFF;
    border-radius: 2px;
    margin-bottom: 30px;
    position: relative;
}

.customize-inst-content .dash-widget #wplms_customize_instructor_users-2 {
    height: auto !important;
    max-height: inherit !important;
}
.customize-inst-content.col-md-6 h2 {
    color: #000;
    font-size: 24px;
}
</style>