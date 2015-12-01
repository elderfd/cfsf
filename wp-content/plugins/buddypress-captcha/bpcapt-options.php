<?php
function tpbpcapt_register_settings() {
	
    add_option( 'bpcapt_public');
    add_option( 'bpcapt_private');
    add_option( 'bpcapt_theme', 'white');
    add_option( 'bpcapt_language', 'en');
    
	register_setting( 'tpbpcapt', 'bpcapt_public' );
    register_setting( 'tpbpcapt', 'bpcapt_private' );
    register_setting( 'tpbpcapt', 'bpcapt_theme' );
    register_setting( 'tpbpcapt', 'bpcapt_language' );
}
add_action( 'admin_init', 'tpbpcapt_register_settings' );
 
function tpbpcapt_register_options_page() {
	
	add_options_page( 'BuddyPress Captcha', 'BuddyPress Captcha', 'manage_options', 'bp-captcha', 'tpbpcapt_options_page' );
}

add_action('admin_menu', 'tpbpcapt_register_options_page');
 
function tpbpcapt_options_page() {
	?>
<div class="wrap">
	<?php screen_icon(); ?>
	<h2>BuddyPress Captcha</h2>
	<form method="post" action="options.php"> 
		<?php settings_fields( 'tpbpcapt' ); ?>
			<p>Click <a href="https://www.google.com/recaptcha/admin" target="_blank">here</a> to get reCAPTCHA credentials.</p>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><label for="bpcapt_public">reCAPTCHA Site Key:</label></th>
					<td><input type="text" id="bpcapt_public" name="bpcapt_public" value="<?php echo get_option('bpcapt_public'); ?>" /></td>
				</tr>
				<tr valign="top">
    				<th scope="row"><label for="bpcapt_private">reCAPTCHA Secret Key:</label></th>
					<td><input type="text" id="bpcapt_private" name="bpcapt_private" value="<?php echo get_option('bpcapt_private'); ?>" /></td>
				</tr>
                <tr valign="top">
    				<th scope="row"><label for="bpcapt_theme">Theme:</label></th>
					<td>
						<?php $theme = 	get_option('bpcapt_theme'); ?>
						<select id="bpcapt_theme" name="bpcapt_theme" value=" <?php	echo $theme ; ?>">
						
							<option value="white" <?php selected( $theme, 'white' ); ?> >White</option>
							<option value="red" <?php selected( $theme, 'red' ); ?>>Red</option>
							<option value="blackglass" <?php selected( $theme, 'blackglass' ); ?> >Black Grass</option>
							<option value="clean" <?php selected( $theme, 'clean' ); ?> >Clean</option>
						</select>
					</td>
				</tr>
                <tr valign="top">
    				<th scope="row"><label for="bpcapt_language">Language:</label></th>
					<?php $language = get_option('bpcapt_language');?>
					<td>
						<select id="bpcapt_language" name="bpcapt_language" value="<?php echo $language;?>">
							<option value="en" <?php selected( $language, 'en' ); ?> >English</option>
							<option value="nl" <?php selected( $language, 'nl' ); ?> >Dutch</option>
							<option value="fr" <?php selected( $language, 'fr' ); ?> >French</option>
							<option value="de" <?php selected( $language, 'de' ); ?> >German</option>
							<option value="pt" <?php selected( $language, 'pt' ); ?> >Portuguese</option>
							<option value="ru" <?php selected( $language, 'ru' ); ?> >Russian</option>
							<option value="es" <?php selected( $language, 'es' ); ?> >Spanish</option>
							<option value="tr" <?php selected( $language, 'tr' ); ?> >Turkish</option>
					  </select>
					</td>
				</tr>
			</table>
		<?php submit_button(); ?>
	</form>
    <span>Want to know more about protecting your WordPress from spam & improving WordPress security? Click <a target="_blank" href="http://www.trickspanda.com/2014/06/improve-wordpress-security/">here</a> to get our FREE PDF book to know more about making your WordPress hacking & spamming proof!</span>
</div>
<?php
}
