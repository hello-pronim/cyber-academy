<?php
$header_style =  vibe_get_customizer('header_style');
if($header_style == 'transparent' || $header_style == 'generic'){ 
	echo '<section id="title">';
	do_action('wplms_before_title');
	echo '</section>';
}


?>
<section id="content">
	<div id="buddypress">
	    <div class="<?php echo vibe_get_container(); ?>">
	        <div class="user-dashboard row">
	            <div class="col-md-6 col-sm-12">
	             <?php do_action( 'bp_before_member_home_content' ); ?>
	                <div class="pagetitle">
						<div id="item-header" class="<?php 
						$image = bp_attachments_get_user_has_cover_image();echo (empty($image)?'':'cover_image')?>" role="complementary">
							<p class="profile-title">My Profile</p>
							<?php locate_template( array( 'members/single/member-header.php' ), true ); ?>

						</div><!-- #item-header -->
					</div>
					<div id="item-nav" class="">
						<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
							<ul>

								<?php bp_get_displayed_user_nav(); ?>

								<?php do_action( 'bp_member_options_nav' ); ?>

							</ul>
						</div>
					</div><!-- #item-nav -->
				</div>	
						