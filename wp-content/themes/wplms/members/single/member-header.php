<?php

/**
 * BuddyPress - Users Header
 *
 * @package BuddyPress
 * @subpackage bp-default
 */
if ( !defined( 'ABSPATH' ) ) exit;
?>

<?php 
  	do_action( 'bp_before_member_header' ); 

	$user_id = get_current_user_id();
	global $wpdb;
	$query = apply_filters(
		'wplms_usersinfo_direct_query',
		$wpdb->prepare(
			" SELECT users.user_email, users.user_registered
						  FROM {$wpdb->users} AS users
						  WHERE   users.id = %d ORDER BY users.id DESC
						  ",
			$user_id
		)
	);

	$user_infos = $wpdb->get_results($query);		
	$result_infos = [];
	if (count($user_infos)) {
		$result_infos = $user_infos[0];
	}

	$header_avatar = current_user_can('edit_posts') ? 'text-center' : 'col-md-8 col-sm-12';
	$header_content = current_user_can('edit_posts') ? 'col-md-12 col-sm-12' : 'col-md-6 col-sm-6';
	$typestring = $wp->request;
 	$slug = end(explode("/", $typestring));
?>
<div class="row">
	<div id="item-header-avatar" class="<?php echo $header_avatar; ?>">
		<a href="<?php bp_displayed_user_link(); ?>">
			<?php bp_displayed_user_avatar( 'type=full' ); ?>
		</a>
	</div><!-- #item-header-avatar -->
<?php if(!current_user_can('edit_posts') && $slug == "dashboard") { ?>
	
	<div id="item-header-info" class="col-md-5 col-sm-6 col-xs-12">
		<ul>
			<li>
				<p>MAIL </p>
				<?php 
					if (!empty($result_infos)) {
				?>
					<p><?php echo $result_infos->user_email;?></p>
				<?php
					} else {
						echo "<p></p>";
					}
				?>
			</li>
			<li>
				<p>SUBSCRIPTION DATE</p>				
				<?php 
					if (!empty($result_infos)) {
				?>
					<p><?php echo date("m / d / Y", strtotime($result_infos->user_registered));?></p>
				<?php
					} else {
						echo "<p></p>";
					}
				?>
			</li>
		</ul>
	</div><!-- #item-header-information  -->
<?php } ?>
</div>

<div id="item-header-content" calss="row">

	<h3 class="<?php echo $header_content; ?> header-content-title">
		<a href="<?php bp_displayed_user_link(); ?>"><?php bp_displayed_user_mentionname(); ?></a>
	</h3>
	<div class="location">
	<?php
		$user_id=bp_displayed_user_id();
		$field = vibe_get_option('student_field');

		if(!isset($field) || $field =='')
			$field = 'Location';

		
		if(bp_is_active('xprofile'))
		echo bp_get_profile_field_data( array('user_id'=>$user_id,'field'=>$field ));

	?>
	</div>
	<?php 
	$members_activity=vibe_get_option('members_activity');
	if(isset($members_activity) && $members_activity){
   //Hiding Activity
	if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
		<span class="user-nicename">@<?php bp_displayed_user_mentionname(); ?></span>
	<?php endif; 

	?>

	<span class="activity"><?php bp_last_activity( bp_displayed_user_id() ); ?></span>
   

	<?php  
	

	do_action( 'bp_profile_before_member_header_meta' ); 

	 // Hiding MEta Info

	?>

	<div id="item-meta">

		<?php if ( bp_is_active( 'activity' ) ) : ?>

			<div id="latest-update">

				<h6><?php bp_activity_latest_update( bp_displayed_user_id() ); ?></h6>

			</div>

		<?php endif;  
		?>

		<div id="item-buttons">
			<?php do_action( 'bp_member_header_actions' ); ?>
		</div><!-- #item-buttons -->

		<?php
		/***
		 * If you'd like to show specific profile fields here use:
		 * bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
		 */
		 do_action( 'bp_profile_header_meta' );

		 ?>

	</div><!-- #item-meta -->
	<?php
    }
	?>
	<?php
	
	 do_action( 'bp_profile_after_member_header_meta' );

	 ?>
</div><!-- #item-header-content -->

<?php do_action( 'bp_after_member_header' ); ?>

