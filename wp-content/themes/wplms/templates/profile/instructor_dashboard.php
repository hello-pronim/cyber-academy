<?php
$header_style =  vibe_get_customizer('header_style');
if($header_style == 'transparent' || $header_style == 'generic'){ 
	echo '<section id="title">';
	do_action('wplms_before_title');
	echo '</section>';
}


?>
<section id="content" class="customize-inst-content">
	<div id="buddypress">
	    <div class="<?php echo vibe_get_container(); ?>">
	        <div class="row">
	            <div class="left-sidebar col-md-2 col-sm-4">
	             <?php do_action( 'bp_before_member_home_content' ); ?>
	                <div class="pagetitle">
						<div id="item-header" class="<?php 
						$image = bp_attachments_get_user_has_cover_image();echo (empty($image)?'':'cover_image')?>" role="complementary">
							<?php locate_template( array( 'members/single/member-header.php' ), true ); ?>

						</div><!-- #item-header -->
						
						<div id="item-nav" class="">
							<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
								<ul>

									<?php bp_get_displayed_user_nav(); ?>

									<?php do_action( 'bp_member_options_nav' ); ?>

								</ul>
								<script>
									(function($) {
										$("#user-buddydrive").text("MyDrive");
									})(jQuery);
								</script>
							</div>
						</div><!-- #item-nav -->
					</div>
				</div>	
				<div class="col-md-10 col-sm-8">
					<div class="padder">
						