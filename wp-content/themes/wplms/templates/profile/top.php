<?php
$header_style =  vibe_get_customizer('header_style');
if($header_style == 'transparent' || $header_style == 'generic'){ 
	echo '<section id="title">';
	do_action('wplms_before_title');
	echo '</section>';
}

global $wp;
$current_url = home_url(add_query_arg(array(), $wp->request));
$slug = end(explode("/", $current_url));
$pages = array("course", "activity", "notifications", "messages", "friends", "forums", "buddydrive", "commissions", "settings");

if (in_array($slug, $pages)) {	
	$left_class = "col-md-3 col-sm-4";
	$right_class = "col-md-9 col-sm-8";
} else {		
	$left_class = "left_panel_none";
	$right_class = "col-md-12 col-sm-12";
}

?>
<section id="content">
	<div id="buddypress">
	    <div class="<?php echo vibe_get_container(); ?>">
		
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
	            <div class="<?php echo $left_class;?>">
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
							</div>
						</div><!-- #item-nav -->
					</div>
				</div>	
				<div class="<?php echo $right_class;?>">
					<div class="padder">
						