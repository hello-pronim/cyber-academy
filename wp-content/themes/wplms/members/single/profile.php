<?php
/**
 * BuddyPress - Users Profile
 *
 * @package BuddyPress
 * @subpackage bp-default
 */
if ( !defined( 'ABSPATH' ) ) exit;
global $wpdb;
if (isset($_POST["skill"]) && isset($_POST["level"])) {	
	$userID = get_current_user_id();
	$mySkills = array('skill' => $_POST["skill"], 'level' => $_POST["level"]);
	$meta = json_encode($mySkills);
		
	$wpdb->query(
		$wpdb->prepare("INSERT INTO {$wpdb->usermeta} (user_id,meta_key,meta_value) VALUES (%s, %s, %s)",
				$userID,
				'profile_skill',
			 	$meta
		)
	);	
	die();
}
$_token = get_option('envato_token');
$accessToken = $_token["access_token"];
if (isset($_POST["_token"]) && !empty($_POST["_token"])) {
	if($accessToken == $_POST["_token"]) {
		$firstName = isset($_POST["profile_first_name"]) ? $_POST["profile_first_name"] : "";
		$lastName = isset($_POST["profile_last_name"]) ? $_POST["profile_last_name"] : "";
		$displayName = $firstName." ".$lastName;
		$email = isset($_POST["profile_email"]) ? $_POST["profile_email"] : "";
		$pass = isset($_POST["profile_confirm_pass"]) ? $_POST["profile_confirm_pass"] : "";	
		$userID = get_current_user_id();
		if ($pass != "Type Password") {		
			if ( empty( $wp_hasher ) ) {
				require_once ABSPATH . WPINC . '/class-phpass.php';
				$wp_hasher = new PasswordHash( 8, true );
			}	
			$password = $wp_hasher->HashPassword( $pass );
			$updateQuery = $wpdb->prepare("UPDATE {$wpdb->users} SET user_email=%s, display_name=%s, user_pass=%s WHERE id=%d", $email, $displayName, $password, $userID);		
			$wpdb->query($updateQuery);	
			header("Refresh:0 url=/");
		} else {
			$updateQuery = $wpdb->prepare("UPDATE {$wpdb->users} SET user_email=%s, display_name=%s WHERE id=%d", $email, $displayName, $userID);		
			$wpdb->query($updateQuery);	
			//header("Refresh:0");
			?>
			<script>window.location.replace("https://cyber-academy.t-scop.com/my-account/student/");</script>
			<?php 
		}
	}
}
$skillResult = $wpdb->get_results(
		$wpdb->prepare("SELECT * FROM {$wpdb->usermeta} WHERE meta_key = 'profile_skill' ORDER BY umeta_id")
	);

?>
<div class="profile_panel">	
	<script>
		(function($) {
			$(".profile_panel").parent().css("cssText", "background: #efefef;padding: 0;");
		})(jQuery);
	</script>
	<!-- Stack the columns on mobile by making one full-width and the other half-width -->
	<div class="row">
		<div class="col-12 col-md-3 nopadding">
			<div class="user-profile">
				<div>
					<?php bp_displayed_user_avatar( 'type=full' ); ?>
				</div>
				<ul>
					<li>
						<i class="fa fa-user" aria-hidden="true"></i>
						<p><?php bp_loggedin_user_fullname(); ?></p>
					</li>
					<li>
						<i class="fa fa-globe" aria-hidden="true"></i>
						<p><?php bp_profile_field_data('field=Location'); ?></p>
					</li>
					<li></li>
				</ul>
			</div>
		</div>
		<div class="col-12 col-md-9 nopadding">
			<div class="profile_detail">
				<div class="row">					
					<div class="col-12 col-md-6">
						<h4>Personal Details</h4>
					</div>
					<div class="col-12 col-md-6 profile_save">
						<button class="profileEdit">Edit</button>
						<button class="profileSave profile_hidden">Save</button>
					</div>					
				</div>
				<?php

				$full_name = bp_get_loggedin_user_fullname();
				$first_last = explode(" ", $full_name);
				$first_name = count($first_last) > 1 ? $first_last[0] : $full_name;
				$last_name = count($first_last) > 1 ? $first_last[1] : "";
				
				global $wpdb;
				$user_id = get_current_user_id();
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

				?>
				<form action="" method="POST" id="profile_info">
					<input type="hidden" value="<?php echo $accessToken; ?>" name="_token" />
					<table>
						<tr class="row">
							<td class="col-12 col-md-6">
								<p>First Name</p>
								<input type="text" name="profile_first_name" value="<?php echo $first_name;?>"/>
							</td>
							<td class="col-12 col-md-6">
								<p>Last Name</p>
								<input type="text" name="profile_last_name" value="<?php echo $last_name;?>"/>
							</td>
						</tr>
						<tr class="row">
							<td class="col-12 col-md-6">
								<p>Subscription Date</p>
								<?php if (!empty($result_infos)) { ?>
									<input type="text" value="<?php echo date("m / d / Y", strtotime($result_infos->user_registered));?>" readonly/>
								<?php } else {
										echo '<input type="text" value="" readonly/>';
									  }
								?>
							</td>
							<td class="col-12 col-md-6">
								<p>Email Address</p>
								<?php if (!empty($result_infos)) { ?>
								<input type="text" name="profile_email" value="<?php echo $result_infos->user_email; ?>"/>
								<?php } else { ?>
								<input type="text" name="profile_email" value=""/>
								<?php } ?>
							</td>
						</tr>
						<tr class="row">
							<td class="col-12 col-md-6">
								<p>New Password</p>
								<input type="password" id="profile_new_pass" name="profile_new_pass" value="Type Password" minlength="8" required/>
							</td>
							<td class="col-12 col-md-6">
								<p>Confirm Password</p>
								<input type="password" id="profile_confirm_pass" name="profile_confirm_pass" value="Type Password" minlength="8" required/>
							</td>
						</tr>
					</table>					
				</form>
			</div>
		</div>
	</div>

	<!-- Columns are always 50% wide, on mobile and desktop -->
	<div class="row">	
		<div class="col-12 col-md-6 nopadding">
			<div class="first_panel">
				<div class="add_myskills">
					<h4>My Skills</h4>
					<?php echo do_shortcode('[popup id="4846" auto="0" classes="btn skill_adding_btn"] <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add New [/popup]'); ?>
<!-- 					<button id="4846"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Add New</button> -->
				</div>
				<div class="skills_list">
					<ul>
						<?php 
							foreach($skillResult as $key => $value) { 
								$skillSet = json_decode($value->meta_value);
								$noviceActive = (trim($skillSet->level) == "Novice") ? "active" : "";
								$interActive = (trim($skillSet->level) == "Intermediate") ? "active" : "";
								$masterActive = (trim($skillSet->level) == "Master") ? "active" : "";
								
								$progressPercent = 0;
								switch(trim($skillSet->level)) {
									case "Intermediate":
										$progressPercent = 50;
										break;
									case "Master":
										$progressPercent = 100;
										break;
									default:
										break;
								}
						?>
						<li>
							<h5><?php echo $skillSet->skill; ?></h5>
							<div class="progress course_progress" style="background-color: #efefef;padding: 0;">
                                <div class="bar animate stretchRight" style="width: <?php echo $progressPercent;?>%; background-color:#6cb1ef;"></div>
							</div>
							<div class="level_grade">
								<p class="<?php echo $noviceActive; ?>">Novice</p>
								<p class="<?php echo $interActive; ?>">Intermediate</p>
								<p class="<?php echo $masterActive; ?>">Master</p>
							</div>
						</li>
						<?php } ?>
					</ul>
				</div>
			</div>
		</div>	
		<div class="col-12 col-md-6 nopadding">
			<div class="second_panel">
				<h4>My Events</h4>
				<div class="row">
					<div class="col-12 col-md-5 event_piece">
						<p>List of Countries which are most vulnerable to Cyber Attacks</p>
						<div class="row">
							<div class="col-md-6 col-sm-5 event_item">
								<i class="fa fa-users" aria-hidden="true"></i>
								<p>15</p>
							</div>
							<div class="col-md-6 col-sm-5 event_item">
								<i class="fa fa-calendar" aria-hidden="true"></i>
								<p>7 june 2020</p>
								<p>10:00 - 11:00</p>
							</div>
						</div>
						<button class="col-md-8 col-sm-8 viewEvent">Zoom webinare</button>
					</div>
					<div class="col-12 col-md-5 event_piece">
						<p>List of Countries which are most vulnerable to Cyber Attacks</p>
						<div class="row">
							<div class="col-md-6 col-sm-5 event_item">
								<i class="fa fa-users" aria-hidden="true"></i>
								<p>15</p>
							</div>
							<div class="col-md-6 col-sm-5 event_item">
								<i class="fa fa-calendar" aria-hidden="true"></i>
								<p>7 june 2020</p>
								<p>10:00 - 11:00</p>
							</div>
						</div>
						<button class="col-md-8 col-sm-8 viewEvent">Zoom webinare</button>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-md-5 event_piece">
						<p>List of Countries which are most vulnerable to Cyber Attacks</p>
						<div class="row">
							<div class="col-md-6 col-sm-5 event_item">
								<i class="fa fa-users" aria-hidden="true"></i>
								<p>15</p>
							</div>
							<div class="col-md-6 col-sm-5 event_item">
								<i class="fa fa-calendar" aria-hidden="true"></i>
								<p>7 june 2020</p>
								<p>10:00 - 11:00</p>
							</div>
						</div>
						<button class="col-md-8 col-sm-8 viewEvent">Zoom webinare</button>
					</div>
					<div class="col-12 col-md-5 event_piece">
						<p>List of Countries which are most vulnerable to Cyber Attacks</p>
						<div class="row">
							<div class="col-md-6 col-sm-5 event_item">
								<i class="fa fa-users" aria-hidden="true"></i>
								<p>15</p>
							</div>
							<div class="col-md-6 col-sm-5 event_item">
								<i class="fa fa-calendar" aria-hidden="true"></i>
								<p>7 june 2020</p>
								<p>10:00 - 11:00</p>
							</div>
						</div>
						<button class="col-md-8 col-sm-8 viewEvent">Zoom webinare</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">	
		<div class="col-12 profile_bottom_save">
			<button class="profileSave">Save</button>
		</div>
	</div>
	<script>
		(function($) {
			// Password validate
			$("#profile_confirm_pass").keyup(function(e) {
				e.preventDefault();
				var newPass = $("#profile_new_pass").val();
				var newPassLen = newPass.length;
				if ((newPass != $(this).val()) || newPassLen < 8) {
					$(this).css("border", "solid 1px #ff7058");
					$("#profile_new_pass").css("border", "solid 1px #ff7058");
					$("#profile_confirm_pass").focus();
				} else {					
					$(this).css("border", "none");
					$("#profile_new_pass").css("border", "none");
				}
			});
			
			// Submit action
			$(".profileSave").on('click', function() {
				var newPass = $("#profile_new_pass").val();
				var confirmPass = $("#profile_confirm_pass").val();
				if (newPass != confirmPass || confirmPass.length < 8) {
					$("#profile_new_pass").css("border", "solid 1px #ff7058");
					$("#profile_confirm_pass").css("border", "solid 1px #ff7058");
					$("#profile_confirm_pass").focus();
				} else {					
					$("#profile_confirm_pass").css("border", "none");
					$("#profile_new_pass").css("border", "none");
					$("#profile_info").submit();
				}
			});
		})(jQuery);
	</script>
</div>