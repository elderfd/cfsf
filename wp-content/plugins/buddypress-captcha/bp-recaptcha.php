<?php
/*
Plugin Name: BuddyPress Captcha
Plugin URI: http://www.trickspanda.com
Description: This plugin adds a reCAPTCHA form to BuddyPress registration form to keep your community spam free.
Version: 1.2
Author: Hardeep Asrani
Author URI: http://www.hardeepasrani.com
Requires at least: WordPress 2.8, BuddyPress 1.2.9
License: GPL2
*/

require_once( 'bpcapt-options.php' );

/* Display a notice that can be dismissed */

function bp_recaptcha_notice() {
	global $current_user ;
	$user_id = $current_user->ID;
	/* Check that the user hasn't already clicked to ignore the message */
	if ( ! get_user_meta($user_id, 'bp_ignore_notice') ) {
		echo '<div class="updated"><p>'; 
		printf(__('After updating to BuddyPress Captcha version 1.2, you\'re required to update your reCaptcha keys with reCaptcha API 2.0 keys yo use the updated version. I know it\'s annoying but you guys will love it. :) | <a href="%1$s">Hide Notice</a>'), '?bp_nag_ignore=0');
		echo "</p></div>";
	}
}

add_action('admin_notices', 'bp_recaptcha_notice');

function bp_recaptcha_ignore() {
	global $current_user;
	$user_id = $current_user->ID;
	/* If user clicks to ignore the notice, add that to their user meta */
	if ( isset($_GET['bp_nag_ignore']) && '0' == $_GET['bp_nag_ignore'] ) {
		 add_user_meta($user_id, 'bp_ignore_notice', 'true', true);
	}
}

add_action('admin_init', 'bp_recaptcha_ignore');

//Injects recaptcha to the the BuddyPress registration Form
function bp_recaptcha_add_code() {
	
	$bp = buddypress();
	//site key
	$public_key =  get_option( 'bpcapt_public' );
	$theme = get_option('bpcapt_theme');
	
	
		
	$html = '<div class="register-section" id="security-section">';
	$html .= '<div class="editfield">';
	$html .= '<label>CAPTCHA code</label>';
	
	if ( ! empty( $bp->signup->errors['recaptcha_response_field'] ) ) {
		$html .= '<div class="error">';
		$html .= $bp->signup->errors['recaptcha_response_field'];
		$html .= '</div>';
	}
	
	$html .= '<div class="g-recaptcha" data-sitekey="' . $public_key . '" data-theme="' . $theme . '"></div>';
	$html .= '</div>';
	$html .= '</div>';
	echo $html;
	?>
<script type="text/javascript">
	var _bp_recaptcha_config = {
				sitekey : "<?php echo $public_key ;?>",
				theme   : "<?php echo $theme;?>"
		};
	
	function bp_recaptcha_init() {
	
		if( window.grecaptcha == undefined ) {
			return ;
		}
			
		jQuery('.g-recaptcha').each( function() {
			var $this = jQuery( this );
			//do not apply if already initilized on some of the elemts
			//allows us to have multiple recaptch on same page
			//the onlything bad is we have a dependency on jQuery
			if( $this.children().length > 0 ) {
				return ;//return won't break the loop, don't worry
			}

			//though we can check for grecaptcha, let us not. The developers should get the error message and load libary if using outside register page
			grecaptcha.render(
				this,
				_bp_recaptcha_config

			);
			//element must be empty to apply the setting
		});
	}
	//allows to work in modal boxes etc
	//not needed for the Bp default registration
	bp_recaptcha_init();
		
</script>
<?php
}

add_action( 'bp_before_registration_submit_buttons', 'bp_recaptcha_add_code' );

/**
 * Validate BuddyPress signup
 * Check for the captcha and add error if not valid
 * 
 */
function bp_recaptcha_validate_signup( $errors ) {
	//we may want to check for php 5.3 here as the lib will not work for anything below php 5.3
	//version_compare($version1, $version2) should be used and admin should be notified
	//I will leave it upto you Hardeep
	//load recaptcha lib
	require_once( plugin_dir_path( __FILE__ ) .'recaptcha/autoload.php' );

	global $bp;
	
	$error_message = __( 'Please check the CAPTCHA code. It\'s not correct.', 'buddypress-recaptcha' );
	
	$private_key = get_option('bpcapt_private');
	
	$recaptcha = new \ReCaptcha\ReCaptcha( $private_key );
	
	$resp = $recaptcha->verify( $_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR'] );
	 	
	if ( ! $resp->isSuccess() ) {
		$bp->signup->errors['recaptcha_response_field'] = $error_message;
	}
	
	return;
}


add_action( 'bp_signup_validate', 'bp_recaptcha_validate_signup' );

/**
 * Load google's js 
 *
 */
function bp_recaptcha_load_js() {
	
	$load = function_exists( 'bp_is_register_page' )&& bp_is_register_page();
	
	//give other plugins opportunity to load too
	if( ! apply_filters( 'bp_recaptcha_load', $load ) ) {
		return ;
	}
	
	?>
	<script src="https://www.google.com/recaptcha/api.js?onload=bp_recaptcha_init&hl=<?php echo get_option( 'bpcapt_language' );?>" async defer></script>

	<?php
}
//you can move it to wp_footer but since we have sync defer set, it is not going to make much difference,
// any modern browser should load it asynchronously(the actual js )
add_action( 'wp_head', 'bp_recaptcha_load_js');

	
	