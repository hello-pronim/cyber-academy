<?php 
/* Template Name: Instructor Questions */
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
					
					<?php 
					
					$quiz = $wpdb->get_results("select id from esalSKkOposts where post_type = 'quiz'");
					foreach($quiz as $q){
					$quizID[] = $q->id;
					}
					
					$qq = $wpdb->get_results("select id from esalSKkOposts where post_type = 'question'");
					foreach($qq as $qe){
					$queID[] = $qe->id;
					}
					
					$id = get_the_ID(); 
					$pp = get_post_meta($id, 'vibe_course_curriculum', true);
					
					?>
					
					<div class="customize-inst-content col-md-6">
					<h2><?php the_title(); ?></h2>
					<div class="dash-widget">
						<div id="wplms_customize_instructor_users-2" class="wplms_customize_instructor_users">
							<div class="instructor_customize_three_part"><span class="instructor_user_active"><i class="fa fa-users" aria-hidden="true"></i></span><p>Quiz Questions</p></div>
								<ul class="widget_users_list">
								<li class="customize_bp_user_title"><p>Questions</p></li>
								<div class="instructor_users_list">
								<?php 
								
								foreach($pp as $p){ 
								
								$data = get_userdata($result->user_id);
								if(in_array($p, $quizID)){
								
								$questions = get_post_meta($p,'vibe_quiz_questions', true);	
								//print_r($questions);
								foreach($questions['ques'] as $que){
								
								if(in_array($que, $queID)){		
									
								?>
								<li>
									<p><?php echo get_the_title($que); ?></p>
								</li>								
									
								<?php }}}} ?>	
								</div>
								</ul>
						</div>
					</div>	
					</div>
					
					<?php endwhile; else : ?>
						<p><?php esc_html_e( 'You have no course so there is no active Questionnaire.' ); ?></p>
					<?php endif; ?>
					
					<?php if($results == ''){ ?>
					<p><?php echo 'You have no course so there is no active Questionnaire.'; ?></p>
					<?php } 
					
					/*
					if(is_array($id)){
						foreach($id as $idd){	
							$results[] = $wpdb->get_results( "SELECT user_id FROM esalSKkOusermeta WHERE meta_key = '$idd'");	
						}
					}else{
						
					$results = $wpdb->get_results( "SELECT user_id FROM esalSKkOusermeta WHERE meta_key = '$id'");			
					
					}
					*/
					
					
				?>
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