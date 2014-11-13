<?php 
	wp_enqueue_script('jquery-ui-dialog');
	// if blog is greater than or equal to WordPress 3.9
	// enqueue our new jQuery UI dialog styles
	if ( get_bloginfo( 'version' ) >= '3.9' ) {
		// wp_enqueue_style("wp-jquery-ui-dialog");
	}
?>	
<script type="text/javascript">
/* 
* Options Page Script 
* Handles save functions
*/
jQuery(document).ready(function () {
	
	/*
	* Clear our response message upon
	* saving the options
	*/
	function clear_update_option_message() {
		window.clearTimeout(timeoutHandle);
		var timeoutHandle = setTimeout(function(){
										jQuery('#yt4wp-status').fadeOut('fast');
									},6000);
	};

	// ajax save the WordPress Plugin Options Page
	// YouTube Settings Page
    jQuery('#yt4wp-youtube-form').submit(function (e) {	        
            jQuery('#yt4wp-status').slideUp('fast');
			var oauth2_id = jQuery( '#yt4wp-oauth2-key' ).val();
			var oauth2_secret = jQuery( '#yt4wp-oauth2-secret' ).val();
			var api_key = jQuery( '#yt4wp-api-key' ).val();
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'yt_plus_settings_form',
						form_action: 'update_options',
						form_data: jQuery('#yt4wp-youtube-form').serialize()
					},
					dataType: 'json',
					success: function (MAILCHIMP) {
						if (MAILCHIMP == '1') {	
							jQuery('#yt4wp-status').html('<div class=updated><p><?php _e('The options were saved successfully!', 'youtube-for-wordpress-translation'); ?></p></div>');
							jQuery('#yt4wp-status').slideDown('fast');
							clear_update_option_message();
						} else {
							jQuery('#yt4wp-status').html("<div class=error><p><?php _e("No changes have been made.", "yt-plus-translation-text-domain"); ?></p></div>");
							jQuery('#yt4wp-status').slideDown('fast');
							clear_update_option_message();
							console.log(MAILCHIMP);
						}
					},
					error : function(MAILCHIMP2) {
						console.log(MAILCHIMP2.responseText);
					}
				});
       e.preventDefault();
    });
	
	
	// ajax save the WordPress Plugin Debug Options Page
	// Debug Options Page
    jQuery('#yt4wp-youtube-form-debug-options').submit(function (e) {	   
        // Make sure the api key exists
            jQuery('#yt4wp-status').slideUp('fast');
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'yt_plus_settings_form',
						form_action: 'update_debug_options',
						form_data: jQuery('#yt4wp-youtube-form-debug-options').serialize()
					},
					dataType: 'json',
					success: function (MAILCHIMP) {
						if (MAILCHIMP == '1') {	
							jQuery('#yt4wp-status').html('<div class=updated><p><?php _e('The options were saved successfully!', 'youtube-for-wordpress-translation'); ?></p></div>');
							jQuery('#yt4wp-status').slideDown('fast');
							clear_update_option_message()
						} else {
							jQuery('#yt4wp-status').html("<div class=error><p><?php _e("No changes have been made.", "yt-plus-translation-text-domain"); ?></p></div>");
							jQuery('#yt4wp-status').slideDown('fast');
							clear_update_option_message()
							console.log(MAILCHIMP);
						}
					},
					error : function(MAILCHIMP2) {
						console.log(MAILCHIMP2.responseText);
					}
				});
       e.preventDefault();
    });
	
	// ajax save the YouTube for WordPress License Options
	// License Options Page
    jQuery('#yt4wp-youtube-form-license-options').submit(function (e) {	   
        // Make sure the api key exists
            jQuery('#yt4wp-status').slideUp('fast');
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'yt_plus_settings_form',
						form_action: 'update_license_options',
						form_data: jQuery('#yt4wp-youtube-form-license-options').serialize()
					},
					dataType: 'json',
					success: function (response) {
						if (response == '1') {	
							jQuery('#yt4wp-status').html('<div class=updated><p><?php _e('The options were saved successfully!', 'youtube-for-wordpress-translation'); ?></p></div>');
							jQuery('#yt4wp-status').slideDown('fast');
							clear_update_option_message()
						} else {
							jQuery('#yt4wp-status').html("<div class=error><p><?php _e("No changes have been made.", "yt-plus-translation-text-domain"); ?></p></div>");
							jQuery('#yt4wp-status').slideDown('fast');
							clear_update_option_message()
							console.log(response);
						}
					},
					error : function(error_response) {
						console.log(error_response.responseText);
					}
				});
       e.preventDefault();
    });
	
	/*******************	Reset Plugin Ajax Request ****************************/	
	
	jQuery('#yt4wp-mc-reset-plugin-settings').click(function(e) {
		jQuery("<div id='yt_plus_reset_plugin_settings' style='height:auto !important;'><div class='yt4wp-mc-icon-yt4wp-mc-warning yt4wp-mc-reset-warning-icon'></div><p style='float:left;width:80%;margin-top:5px;'><?php _e("Are you sure you want to reset YouTube for WordPress back to default? This cannot be undone.", "yt-plus-translation-text-domain" ); ?></p></div>").dialog({
		 dialogClass: 'ui-dialog-yt-plus',
		 title : "Reset YouTube for WordPress Settings?",
		 width: 400,
		 height: 200,
		 resizable: false,
		 buttons : {
			"Yes" : function() {
				 jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'yt_plus_settings_form',
						form_action: 'yt_plus_reset_plugin_settings'
					},
					dataType: 'json',
					success: function () {
						jQuery( "#yt_plus_reset_plugin_settings" ).html('<div class="dashicons dashicons-yes yt4wp-mc-success-icon"></div><p style="float:left;width:80%;"><?php _e("YouTube for WordPress settings have successfully been reset", "yt-plus-translation-text-domain" ); ?></p><span class="yt4wp-mc-reset-plugin-settings-preloader-container"><img class="yt4wp-mc-reset-plugin-settings-preloader" src="<?php echo plugin_dir_url(__FILE__).'../images/preloader.gif'; ?>" alt="preloader" /></span>');
						jQuery( "#yt_plus_reset_plugin_settings" ).next().hide();
						jQuery( "#yt_plus_reset_plugin_settings" ).prev().text("Success!");
						setTimeout(function() {	
							location.reload();
						}, 2000);
					},
					error: function() {
						alert('Error resetting plugin settings. If the error persists, uninstall and reinstall the plugin to reset your options.');
					}
				});
			},
			"Cancel" : function() {
			  jQuery(this).dialog("close");
			}
		  },
		  modal: true,
		  resizable: false
		});
		e.preventDefault();
	});
		
	/* Revoke Permissions From the User */
	jQuery('#yt4wp-mc-logout-revoke-permissions').click(function(e) {
		jQuery("<div id='yt_plus_revoke_permissions' style='height:auto !important;'><div class='yt4wp-mc-icon-yt4wp-mc-warning yt4wp-mc-reset-warning-icon'></div><p style='float:left;width:80%;margin-top:5px;'><?php _e("Are you sure you want to revoke permissions? This cannot be undone and you will need to re-authenticate to regain access.", "yt-plus-translation-text-domain" ); ?></p></div>").dialog({
		 dialogClass: 'ui-dialog-yt-plus',
		 title : "Revoke YouTube for WordPress Permissons?",
		 width: 400,
		 height: 200,
		 resizable: false,
		 buttons : {
			"Yes" : function() {
				 jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'yt_plus_settings_form',
						form_action: 'yt_plus_revoke_user_permissions',
						access_token: '<?php echo $this->optionVal['yt4wp-oauth2-key']; ?>'
					},
					dataType: 'json',
					success: function () {
						jQuery( "#yt_plus_revoke_permissions" ).html('<div class="dashicons dashicons-yes yt4wp-mc-success-icon"></div><p style="float:left;width:80%;"><?php _e("YouTube for WordPress permissions have successfully been revoked. You can now re-authenticate.", "yt-plus-translation-text-domain" ); ?></p><span class="yt4wp-mc-reset-plugin-settings-preloader-container"></span>');
						jQuery('#yt4wp-mc-logout-revoke-permissions').attr('disabled','disabled');
						jQuery( "#yt_plus_revoke_permissions" ).next().find('button:first').remove();
						jQuery( "#yt_plus_revoke_permissions" ).next().find('button:last').find('span').text('Close');
					},
					error: function() {
						jQuery('body.youtube_page_youtube-for-wordpress-settings').find('#yt4wp-youtube-form').before('<span id="response_message" class="yt4wp-error-alert" style="display:none;width:100%;"><p>Error revoking permissions. If the error persists, please contact the YouTube for WordPress support team.</p></span>');
						jQuery(this).dialog("close");
						jQuery('.yt4wp-error-alert').slideDown();
						window.scrollTo(0, 0);
					}
				});
			},
			"Cancel" : function() {
			  jQuery(this).dialog("close");
			}
		  },
		  modal: true,
		  resizable: false
		});
		e.preventDefault();
	});
		
		
});

</script>

<!-- get and store our api key option -->
<?php
	$api_key_option = get_option( 'api_validation' );
	$wordPress_version = get_bloginfo( 'version' );
	
	// get the SQL and PHP versions 
	$php_version = phpversion();
	$sql_version = mysql_get_server_info();
	
	// set up the options for our WYSIWYG editors
	// for the optin messages
	$single_optin_message_parameters = array(
		'teeny' => true,
		'textarea_rows' => 15,
		'tabindex' => 1,
		'textarea_name' => 'single-optin-message',
		'drag_drop_upload' => true
	);
	
	$double_optin_message_parameters = array(
		'teeny' => true,
		'textarea_rows' => 15,
		'tabindex' => 1,
		'textarea_name' => 'double-optin-message',
		'drag_drop_upload' => true
	);
	
	// used to dictate the active tab
	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'youtube_settings';
?>
<div class="wrap">

<?php 
	// Display the Help/Contact Banner
	$this->yt_plus_contact_support_banner(); 
?>

<h2 id="yt4wp-page-header">
	<div id="yt4wp-icon" class="icon32"></div><?php _e('YouTube for WordPress','youtube-for-wordpress-translation'); ?>
</h2>

<!-- tabs -->
<h2 class="nav-tab-wrapper">
    <a href="?page=youtube-for-wordpress-settings&tab=youtube_settings" class="nav-tab <?php echo $active_tab == 'youtube_settings' ? 'nav-tab-active' : ''; ?>"><?php _e('YouTube Settings','youtube-for-wordpress-translation'); ?></a>
	<a href="?page=youtube-for-wordpress-settings&tab=debug_settings" class="nav-tab <?php echo $active_tab == 'debug_settings' ? 'nav-tab-active' : ''; ?>" ><?php _e('Debug Settings','youtube-for-wordpress-translation'); ?></a>
	<a href="?page=youtube-for-wordpress-settings&tab=license_settings" class="nav-tab <?php echo $active_tab == 'license_settings' ? 'nav-tab-active' : ''; ?>" ><?php _e('Support License','youtube-for-wordpress-translation'); ?></a>
	<?php do_action( 'youtube_for_wordpress_addon_settings_tabs' , $active_tab ); ?>
</h2>
	
	<div class="yt4wp-status" id="yt4wp-status"></div>
	
<?php if ( $active_tab == 'youtube_settings' ) { ?>
	
	<br />
	
	<h2><?php _e('YouTube for WordPress Settings','youtube-for-wordpress-translation'); ?></h2>

	<!-- WordPress version number and SSL error checking -->
	<!-- check WordPress version num. and display an error if its outdated -->
	<?php if ( $wordPress_version < '3.9' ) { ?>
		<div class="error">
			<h3><div class="dashicons dashicons-no yt_plus_error_x"></div><?php _e( 'WordPress Version Number Error', 'youtube-for-wordpress-translation' ); ?></h3>
			<p><?php _e( 'We\'re sorry, but it looks like your using an outdated version of WordPress. You won\'t be able to access the tinyMCE button to insert forms into pages and posts unless you update to 3.9 or later.', 'youtube-for-wordpress-translation' ); ?></p>
		</div>
	<?php } 
	
		
	// check if the user is on localhost
	// if so, they need to enable SSL on localhost
	if ( $this->yt4wp_is_user_localhost() ) {
	?>
		<div class="update-nag" style="margin-bottom:2.5em;width:97.5% !important;">
			<span class="yt4wp-mc-icon-notice"><h3><?php _e( 'LocalHost Detected :', 'youtube-for-wordpress-translation' ); ?></h3></span>
			<p><?php _e( 'It looks like your using YouTube for WordPress on localhost.', 'youtube-for-wordpress-translation' ); ?></p>
			<p><?php _e( 'You will want to setup a <strong>global API key</strong> and set your <strong>redirect URI</strong> as ', 'youtube-for-wordpress-translation' ); ?><?php echo '<em>"' . admin_url() . 'admin.php?page=youtube-for-wordpress"</em>'; ?></p>
		</div>
	<?php }

	// Check the Users PHP Version Numbers 
	if ( $php_version < '5.3' ) {
	?>
		<div class="update-nag" style="margin-bottom:2.5em;width:97.5% !important;">
			<span class="yt4wp-mc-icon-notice"><h3><?php _e( 'Outdated Version of PHP :', 'youtube-for-wordpress-translation' ); ?></h3></span>
			<p><?php _e( 'It looks like your site is running an outdated version of PHP. YouTube for WordPress requires a minimum of PHP 5.3.', 'youtube-for-wordpress-translation' ); ?></p>
			<p><?php _e( 'Your site is currently running PHP v.', 'youtube-for-wordpress-translation' ); echo $php_version; ?></p>
		</div>
	<?php 
	}  
	
	// Check the Users MySQL Version Numbers 
	if ( $sql_version < '5.0.0' ) {
	?>
		<div class="update-nag" style="margin-bottom:2.5em;width:97.5% !important;">
			<span class="yt4wp-mc-icon-notice"><h3><?php _e( 'LocalHost Detected :', 'youtube-for-wordpress-translation' ); ?></h3></span>
			<p><?php _e( 'It looks like your site is running an outdated version of MySQL. YouTube for WordPress requires a minimum of MySQL 5.0.0.', 'youtube-for-wordpress-translation' ); ?></p>
			<p><?php _e( 'Your site is currently running MySQL v.', 'youtube-for-wordpress-translation' ); echo $sql_version; ?></p>
		</div>
	<?php 
	} ?>
	
	
	<form method="post" name="yt4wp-youtube-form" id="yt4wp-youtube-form">
		<table class="form-table yt4wp-admin-form">
			<tbody>				
				<!-- YouTube OAUTH2 Key Field -->
				<tr valign="top">
					<th scope="row"><label for="yt4wp-oauth2-key"><?php _e('Google OAUTH2 Client ID','youtube-for-wordpress-translation'); ?></label></th>
					<td><input name="yt4wp-oauth2-key" type="password" autofill="off" id="yt4wp-oauth2-key" value="<?php echo $this->optionVal['yt4wp-oauth2-key']; ?>" class="regular-text" /></span>
					</td>
				</tr>
				<!-- YouTube OAUTH2 Secret Key Field -->
				<tr valign="top">
					<th scope="row"><label for="yt4wp-oauth2-secret"><?php _e('Google OAUTH2 Client Secret','youtube-for-wordpress-translation'); ?></label></th>
					<td><input name="yt4wp-oauth2-secret" type="password" autofill="off" id="yt4wp-oauth2-secret" value="<?php echo $this->optionVal['yt4wp-oauth2-secret']; ?>" class="regular-text" /></span>
					</td>
				</tr>
				<!-- YouTube OAUTH2 Description -->
				<tr>
					<td></td>
					<td class="yt4wp-settings-description">
						<?php _e('Please enter your Google OAUTH2 Keys above. The OAUTH2 Keys allow your WordPress site to communicate securely with your YouTube account.','youtube-for-wordpress-translation'); ?>  <a href="https://console.developers.google.com" target="_blank"><?php _e('Google Developer Console','youtube-for-wordpress-translation'); ?></a>
					</td>
				</tr>
				<!-- Google Project Setup Tutorial Link -->
				<tr>
					<td></td>
					<td class="yt4wp-settings-description">
						<?php _e('If you need help setting up the Google API Project, please visit the support article :','youtube-for-wordpress-translation'); ?> <a href="http://YouTubeforWordPress.com/support/documentation/setup/setup-google-project/" target="_blank"><?php _e('Setup the Google Project','youtube-for-wordpress-translation'); ?></a>
					</td>
				</tr>
				<!-- YouTube API Key Field -->
				<tr valign="top">
					<th scope="row"><label for="yt4wp-api-key"><?php _e('Google Public API Key','youtube-for-wordpress-translation'); ?></label></th>
					<td><input name="yt4wp-api-key" type="password" id="yt4wp-api-key" autofill="off" value="<?php echo $this->optionVal['yt4wp-api-key']; ?>" class="regular-text" /></span>
					</td>
				</tr>
				<!-- YouTube API Key Description -->
				<tr>
					<td></td>
					<td class="yt4wp-settings-description">
						<?php _e('Please enter your Google API Key above.','youtube-for-wordpress-translation'); ?><br />
					</td>
				</tr>
				<?php if ( get_option( 'yt4wp_user_refresh_token' ) != '' ) { ?>
				
				<!-- YouTube Region Field -->
				<tr valign="top">
					<th scope="row"><label for="yt4wp-region"><?php _e('Select Your Region','youtube-for-wordpress-translation'); ?></label></th>
					<td><?php $this->generateRegionDropdown(); ?></span>
					</td>
				</tr>
				<!-- YouTube Region Field Description -->
				<tr>
					<td></td>
					<td class="yt4wp-settings-description">
						<?php _e('Your region will determine some data returned from the API. For example, when searching, YouTube will return videos from your country first.','youtube-for-wordpress-translation'); ?><br />
					</td>
				</tr>
				<tr>
					<td></td>
					<td class="yt4wp-settings-description">
						<?php _e('Note : Use Wordlwide if you are in the United States.','youtube-for-wordpress-translation'); ?><br />
					</td>
				</tr>
				<!-- YouTube Language Field -->
				<tr valign="top">
					<th scope="row"><label for="yt4wp-language"><?php _e('Select Your Language','youtube-for-wordpress-translation'); ?></label></th>
					<td><?php $this->generateLanguageDropdown(); ?></span>
					</td>
				</tr>
				<!-- YouTube Language Field Description -->
				<tr>
					<td></td>
					<td class="yt4wp-settings-description">
						<?php _e('This will determine the language of some data returned from the YouTube API (ie: category names).','youtube-for-wordpress-translation'); ?><br />
					</td>
				</tr>
				
				<?php } ?>
				<!-- YouTube Embed Player Options -->
				<tr valign="top">
					<th scope="row"><label for="yt4wp-embed-player-style"><?php _e('YouTube Embedded Player Style','youtube-for-wordpress-translation'); ?></label></th>
					<td>
						<select name="yt4wp-embed-player-style" id="yt4wp-embed-player-style" class="regular-text" style="width:300px;">
							<option value="yt-default"<?php echo ($this->optionVal['yt4wp-embed-player-style'] === 'yt-default' ? ' selected' : ''); ?>><?php _e('YouTube Default','youtube-for-wordpress-translation'); ?></option>
							<option value="wp-mediaelement"<?php echo ($this->optionVal['yt4wp-embed-player-style'] === 'wp-mediaelement' ? ' selected' : ''); ?>><?php _e('Media Element Player','youtube-for-wordpress-translation'); ?></option>
						</select>
					</td>
				</tr>
				<!-- YouTube API Key Description -->
				<tr>
					<td></td>
					<td class="yt4wp-settings-description">
						<?php _e('Select your video style above.','youtube-for-wordpress-translation'); ?><br />
					</td>
				</tr>		
				<!-- YouTube Statistics Inclusion Setting -->
				<tr valign="top">
					<th scope="row"><label for="yt4wp-embed-player-style"><?php _e('Display Video Statistics','youtube-for-wordpress-translation'); ?></label></th>
					<td>
						<select name="yt4wp-include-stat-count-in-query" id="yt4wp-include-stat-count-in-query" class="regular-text" style="width:300px;">
							<option value="stat-count-enabled"<?php echo ($this->optionVal['yt4wp-include-stat-count-in-query'] === 'stat-count-enabled' ? ' selected' : ''); ?>><?php _e('Enable Video Stats','youtube-for-wordpress-translation'); ?></option>
							<option value="stat-count-disabled"<?php echo ($this->optionVal['yt4wp-include-stat-count-in-query'] === 'stat-count-disabled' ? ' selected' : ''); ?>><?php _e('Disable Video Stats','youtube-for-wordpress-translation'); ?></option>
						</select>
					</td>
				</tr>
				<!-- YouTube Statistics Inclusion Setting Description -->
				<tr>
					<td></td>
					<td class="yt4wp-settings-description">
						<?php _e('Select if you would like the video statistics to be displayed below videos. Video stats include view count, dislikes, likes and favorites. Note : including stats will significantly increase page load times in the dashboard.','youtube-for-wordpress-translation'); ?><br />
					</td>
				</tr>		
				<!-- submit button -->
				<tr>
					<td></td>
					<td><input type="submit" name="submit" id="submit" class="button-primary" value="Save Settings" ><input type="submit" name="yt4wp-mc-reset-plugin-settings" id="yt4wp-mc-reset-plugin-settings" class="button yt4wp-mc-button-red" value="Reset Plugin Settings"><input style="width:auto; float:right;" type="submit" name="yt4wp-mc-logout-revoke-permissions" id="yt4wp-mc-logout-revoke-permissions" class="button yt4wp-mc-button-revoke yt4wp-revoke-permissions" <?php if( get_option( 'yt4wp_user_refresh_token' ) == '' ) { echo 'disabled=disabled'; } ?> value="Revoke Permissions"></td>
				</tr>	
			
			</tbody>
		</table>
	</form>
	
		<?php 
			/** Display the upsell banner **/
			$this->yt_plus_display_upsell_banner();	
		?>

	<?php } else if ( $active_tab == 'debug_settings' ) { ?>
		
		<br />
		
		<h2><?php _e('Debug Settings','youtube-for-wordpress-translation'); ?></h2>
		
		<form method="post" name="yt4wp-youtube-form" id="yt4wp-youtube-form-debug-options">
			<table class="form-table yt4wp-admin-form">
				<tbody>
				
				<!-- Advanced Debug -->
				<tr valign="top">
					<th scope="row"><label for="yt4wp-debug"><?php _e('Advanced Error Messaging','youtube-for-wordpress-translation'); ?></label></th>
					<td>
						<select name="yt4wp-debug" id="yt4wp-debug" class="regular-text" />
							<option value="0"<?php echo ($this->optionVal['yt4wp-debug'] === '0' ? ' selected' : ''); ?>><?php _e('Disabled','youtube-for-wordpress-translation'); ?></option>
							<option value="1"<?php echo ($this->optionVal['yt4wp-debug'] === '1' ? ' selected' : ''); ?>><?php _e('Enabled','youtube-for-wordpress-translation'); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<!-- Advanced Debug Description -->
					<td class="yt4wp-settings-description">
						<?php _e( "Enable if you're having problems with your forms sending data to YouTube. Enabling Advanced Error Messaging will show you the exact error codes YouTube is returning.","yt-plus-translation-text-domain" ); ?>
					</td>
				</tr>

				<table class="form-table yt4wp-admin-form">
					<tbody>
						<!-- Plugin Info -->
						<h3><?php _e('Plugin Information','youtube-for-wordpress-translation'); ?></h3>
						<!-- Issues? Contact Us. -->
						<p>
							<?php _e('If you experience any issues with YouTube for WordPress, please read the documentation or ','youtube-for-wordpress-translation'); ?> <a href="http://www.youtubeforwordpress.com/support/" target="_blank"><?php _e('submit a new ticket','youtube-for-wordpress-translation'); ?></a>. <?php _e('You will need to be a support license holder to receive any level of support. Please include the information below to help us troubleshoot your problem.','youtube-for-wordpress-translation'); ?>
						</p>
						<!-- User Debug Section -->
						<!-- Plugin Version, Browser Version etc. -->
						<tr valign="top">
							<th scope="row"><label><?php _e('Plugin Version','youtube-for-wordpress-translation'); ?></label></th>
							<td><?php echo YT4WP_VERSION_CURRENT; ?></td>
						</tr>
						<tr valign="top">
							<th scope="row"><label><?php _e('Wordpress Version','youtube-for-wordpress-translation'); ?></label></th>
							<td>
							<?php 
								$wordpress_version = get_bloginfo( 'version' );
								if ( $wordpress_version < '3.9' ) {
									echo '<div class="dashicons dashicons-no-alt" style="margin-right:2em;color:red;"></div>' . $wordpress_version;
								} else {
									echo '<div class="dashicons dashicons-yes" style="margin-right:2em;color:green;"></div>' . $wordpress_version;
								}							
							?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label><?php _e('PHP Version','youtube-for-wordpress-translation'); ?></label></th>
							<td>
								<?php	
								if ( $php_version < '5.3' ) {
									echo '<div class="dashicons dashicons-no-alt" style="margin-right:2em;color:red;"></div>' . $php_version ;
								} else {
									echo '<div class="dashicons dashicons-yes" style="margin-right:2em;color:green;"></div>' . $php_version;
								}
								?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label><?php _e('MySQL Version','youtube-for-wordpress-translation'); ?></label></th>
							<td>
								<?php	
								if ( $sql_version < '5.0.0' ) {
									echo '<div class="dashicons dashicons-no-alt" style="margin-right:2em;color:red;"></div>' . $sql_version ;
								} else {
									echo '<div class="dashicons dashicons-yes" style="margin-right:2em;color:green;"></div>' . $sql_version;
								}
								?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><label><?php _e('Browser Information','youtube-for-wordpress-translation'); ?></label></th>
							<td>
								<?php
								$theBrowser = $this->getBrowser();
								echo $theBrowser['name'].' '.$theBrowser['version'].' on '.$theBrowser['platform'];					
								?>
							</td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" name="submit" id="submit" class="button-primary" value="Save Settings"></td>
						</tr>
					</tbody>
				</table>
				
				</tbody>
			</table>
		</form>

			<?php 
				/** Display the upsell banner **/
				$this->yt_plus_display_upsell_banner();	
			?>

	<?php } else if ( $active_tab == 'license_settings' ) { ?>
		
			<br />
		
			<h2><?php _e('Support License','youtube-for-wordpress-translation'); ?></h2>
						
			<form method="post" name="yt4wp-youtube-form" id="yt4wp-youtube-form-license-options">
								
				<table class="form-table yt4wp-admin-form" style="margin-bottom:4em;">
					<tbody>				
						<!-- YouTube for WordPress License Key Field -->
						<tr valign="top">
							<th scope="row"><label for="yt4wp-license-key"><?php _e('Support License Key','youtube-for-wordpress-translation'); ?></label></th>
							<td><input name="yt4wp-license-key" disabled="disabled" placeholder="Temporarily Unavailable" type="text" id="yt4wp-license-key" value="<?php echo $this->optionVal['yt4wp-license-key']; ?>" class="regular-text" style="width:100%;min-width:500px;" /></span>
							</td>
						</tr>
						<!-- YouTube for WordPress License Description -->
						<tr>
							<td></td>
							<td class="yt4wp-settings-description">
								<?php _e('The license key is used for access to automatic upgrades and support. Please see the' , 'youtube-for-wordpress-translation'); ?> <a href="http://www.youtubeforwordpress.com/buy-yt4wp/" target="_blank"><?php _e( 'support' , 'youtube-for-wordpress-translation'); ?></a> <?php _e( 'page for further details about purchasing a support license.','youtube-for-wordpress-translation'); ?>
							</td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" name="submit" id="submit" class="button-primary" value="Save Settings"></td>
						</tr>
					</tbody>
				</table>
			
			</form>
			
			
			
			<?php 
				/** Display the upsell banner **/
				$this->yt_plus_display_upsell_banner();	
			?>
	
	<?php }

	do_action( 'youtube_plus_addon_settings_page' , $active_tab ); ?>
	
</div>