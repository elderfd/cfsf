<style>
label {
	margin-right:10px;
}
#fb-msg {
	border: 1px #888888 solid; background-color: #FFFAF0; padding: 10px; font-size: inherit; font-weight: bold; font-family: inherit; font-style: inherit; text-decoration: inherit;
}
</style>
<script type="text/javascript">
function SaveSettings(){
	var FbAppId = jQuery("#twitter-page-id-fetch").val();
    var User_name_3 = jQuery("#twitter-page-user-name").val();	
	var show_theme = jQuery("#show-theme-background").val();
	var Height = jQuery("#twitter-page-url-Height").val();
	var link_color = jQuery("#twitter-page-lnk-Color").val();
	var replieses = jQuery("#exclude_replies_23").val();
	var photos_acces = jQuery("#photo_1234").val();
	if(!FbAppId) {
		jQuery("#twitter-page-id-fetch").focus();
		return false;
	}
	jQuery("#fb-save-settings").hide();
	jQuery("#fb-img").show();
	jQuery.ajax({
		url: location.href,
		type: "POST",
		data: jQuery("form#fb-form").serialize(),
		dataType: "html",
		//Do not cache the page
		cache: false,
		//success
		success: function (html) {
			jQuery("#fb-img").hide();
			jQuery("#fb-msg").show();
			setTimeout(function() {location.reload(true);}, 2000);
		}
	});
}
</script>
 <?php
 wp_enqueue_style('op-bootstrap-css', WEBLIZAR_TWITTER_PLUGIN_URL. 'css/bootstrap.min.css');
 if(isset($_REQUEST['twitter-page-id-fetch'])) {
 $TwitterSettingsArray = serialize(
		array(
			'TwitterUserName' => $_REQUEST['twitter-page-user_name'],
			'Theme' => $_REQUEST['show-theme-background'],
			'Height' => $_REQUEST['twitter-page-url-Height'],
			'TwitterWidgetId' => $_REQUEST['twitter-page-id-fetch'],
		    'LinkColor' => $_REQUEST['twitter-page-lnk-Color'],
			'ExcludeReplies' => $_REQUEST['exclude_replies_23'],
			'AutoExpandPhotos' => $_REQUEST['photo_1234'],
		));
	update_option("ali_twitter_shortcode", $TwitterSettingsArray);
}?>
<div class="block ui-tabs-panel active" id="option-general">		
	<div class="row">
		<div class="col-md-6">
			<h2><?php _e( 'Twitter Shortcode Settings', WEBLIZAR_TWITTER_TEXT_DOMAIN); ?>: [TWTR]</h2>
			<hr>
			<form name='fb-form' id='fb-form'>
				<?php
					$twitterSettings =  unserialize(get_option("ali_twitter_shortcode"));
					$TwitterUserName = "weblizar";
					if( isset($twitterSettings[ 'TwitterUserName' ] ) )  {
						$TwitterUserName = $twitterSettings[ 'TwitterUserName' ];
					}
					$TwitterWidgetId = "462084801944485888";
					if ( isset($twitterSettings[ 'TwitterWidgetId' ] ) ) {
						$TwitterWidgetId = $twitterSettings[ 'TwitterWidgetId' ];
					}
					$Theme = "light";
					if (isset( $twitterSettings[ 'Theme' ] ) ) {
						$Theme = $twitterSettings[ 'Theme' ];
					}
					$Height = "450";
					if ( isset($twitterSettings[ 'Height' ] ) ) {
						$Height = $twitterSettings[ 'Height' ];
					}
					$Width = "";
					if ( isset($twitterSettings[ 'Width' ] ) ) {
					$Width = $twitterSettings[ 'Width' ];
					}
					$LinkColor = "#CC0000";
					if ( isset( $twitterSettings[ 'LinkColor' ] ) ) {
						$LinkColor = $twitterSettings[ 'LinkColor' ];
					}
					$ExcludeReplies = "yes";
					if ( isset( $twitterSettings[ 'ExcludeReplies' ] ) )  {
						$ExcludeReplies = $twitterSettings['ExcludeReplies' ];
					}
					$AutoExpandPhotos = "yes";
					if ( isset( $twitterSettings[ 'AutoExpandPhotos' ] ) ) {
						$AutoExpandPhotos = $twitterSettings[ 'AutoExpandPhotos' ];
					}
				?>
				<p>
					<label><?php _e( 'Twitter Account Username',WEBLIZAR_TWITTER_TEXT_DOMAIN); ?></label>
					<input class="widefat" id="twitter-page-user-name" name="twitter-page-user_name" type="text" value="<?php echo esc_attr($TwitterUserName); ?>">
				</p>
				<br>
				
				<p>
					<label><?php _e( 'Twitter Widget Id (Required)',WEBLIZAR_TWITTER_TEXT_DOMAIN); ?></label>
					<input class="widefat" id="twitter-page-id-fetch" name="twitter-page-id-fetch" type="text" value="<?php echo esc_attr( $TwitterWidgetId); ?>">
					Get Your Twitter Widget Id: <a href="https://weblizar.com/get-twitter-widget-id/" target="_blank">HERE</a>
				</p>
				<br>
				 
				<p>
					<label><?php _e( 'Theme',WEBLIZAR_TWITTER_TEXT_DOMAIN); ?></label>
					<select id="show-theme-background" name="show-theme-background">
						<option value="light" <?php if($Theme == "light") echo "selected=selected" ?>>Light</option>
						<option value="dark" <?php if($Theme == "dark") echo "selected=selected" ?>>Dark</option>
					</select>
				</p>
				<br>
				
				<p>
					<label><?php _e( 'Height',WEBLIZAR_TWITTER_TEXT_DOMAIN); ?></label>
					<input class="widefat" id="twitter-page-url-Height" name="twitter-page-url-Height" type="text" value="<?php echo esc_attr($Height ); ?>">
				</p>
				<br>
				
				<p>
					<label><?php _e( 'URL Link Color:',WEBLIZAR_TWITTER_TEXT_DOMAIN); ?></label>
					<input class="widefat" id="twitter-page-lnk-Color" name="twitter-page-lnk-Color" type="text" value="<?php echo esc_attr( $LinkColor ); ?>" >
					Find More Color Codes <a href="http://html-color-codes.info/" target="_blank">HERE</a>
				</p>
				<br>
				
				<p>
					<label><?php _e( 'Exclude Replies on Tweets',WEBLIZAR_TWITTER_TEXT_DOMAIN); ?></label>
					<select id="exclude_replies_23" name="exclude_replies_23">
						<option value="yes" <?php if($ExcludeReplies == "yes") echo "selected=selected" ?>>Yes</option>
						<option value="no" <?php if($ExcludeReplies == "no") echo "selected=selected" ?>>No</option>
					</select>
				</p>
				<br>
				<p>
					<label><?php _e( 'Auto Expand Photos in Tweets',WEBLIZAR_TWITTER_TEXT_DOMAIN); ?></label>
					<select id="photo_1234" name="photo_1234">
						<option value="yes" <?php if($AutoExpandPhotos == "yes") echo "selected=selected" ?>>Yes</option>
						<option value="no" <?php if($AutoExpandPhotos == "no") echo "selected=selected" ?>>No</option>
					</select>
				</p>
				<br>
				
				<input onclick="return SaveSettings();" type="button" class="btn btn-primary btn-lg" id="fb-save-settings" name="fb-save-settings" value="SAVE">
			
				<div id="fb-img" style="display: none;">
					<img src="<?php echo WEBLIZAR_TWITTER_PLUGIN_URL.'images/loading.gif'; ?>" />
				</div>
				<div id="fb-msg" style="display: none;" class"alert">
					<?php _e( 'Settings successfully saved. Reloading page for generating preview right side of setting.', WEBLIZAR_TWITTER_TEXT_DOMAIN ); ?> 
				</div>		
			</form>
			
		</div>
		<!-- Preview Part-->
		<div class="col-md-6">
			<?php if($TwitterWidgetId) { ?>
			<h2>Twitter Shortcode <?php _e( 'Preview', WEBLIZAR_TWITTER_TEXT_DOMAIN); ?></h2>
			<hr>
			<p>
				<a class="twitter-timeline" data-dnt="true" href="https://twitter.com/<?php echo $TwitterUserName; ?>" 
				min-width="<?php echo $Width; ?>" 
				height="<?php echo $Height; ?>" 
				data-theme="<?php echo $Theme; ?>" 
				data-link-color="<?php echo $LinkColor; ?>" 
				data-widget-id="<?php echo $TwitterWidgetId; ?>">Twitter Tweets</a>
				<script>
				!function(d,s,id) {
					var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}
				} (document,"script","twitter-wjs");
				</script>
			</p>
			<?php }?>
		</div>
    </div>
</div>

<!---------------- need help tab------------------------>
<div class="block ui-tabs-panel deactive" id="option-needhelp">		
	<div class="row">
		<div class="col-md-10">
			<div id="heading">
				<h2>Twitter Tweet Widget & Shortcode Help Section</h2>
			</div>
			<p>Twitter Tweet By Weblizar plugin comes with 2 major feature.</p>
			<br>
			<p><strong>1 - Twitter Tweets Widget</strong></p>
			<p><strong>2 - Twitter Tweets Shoertcode [TWTR]</strong></p>
			<br><br>
			<p><strong>Twitter Tweets Widget</strong></p>
			<hr>
			<p>You can use the widget to display your Twitter Tweets in any theme Widget Sections.</p>
			<p>Simple go to your <a href="<?php echo get_site_url(); ?>/wp-admin/widgets.php"><strong>Widgets</strong></a> section and activate available <strong>"Twitter By Weblizar"</strong> widget in any sidebar section, like in left sidebar, right sidebar or footer sidebar.</p>
			<br><br>
			<p><strong>Twitter Tweets Shoertcode [TWTR]</strong></p>
			<hr>
			<p><strong>[TWTR]</strong> shortcode give ability to display Twitter Tweets Box in any Page / Post with content.</p>
			<p>To use shortcode, just copy <strong>[TWTR]</strong> shortcode and paste into content editor of any Page / Post.</p>
		
			<br><br>
			<p><strong>Q. What is Twitter Widget ID?</strong></p>
			<p><strong>Ans. Twitter Widget ID</strong> used to authenticate your TWITTER
			Page data & settings. To get your own TWITTER ID please read our very simple and easy <a href="https://weblizar.com/get-twitter-widget-id/" target="_blank"><strong>Tutorial.</p>
		</div>
	</div>
</div>

<!---------------- our product tab------------------------>
<div class="block ui-tabs-panel deactive" id="option-ourproduct">
	<div class="row-fluid pricing-table pricing-three-column">
		<div class="plan-name centre"> 
			<a href="http://weblizar.com" target="_new" style="margin-bottom:10px;textt-align:center"><img src="http://weblizar.com/wp-content/themes/home-theme/images/weblizar2.png"></a>
		</div>	
		<div class="plan-name">
			<h2>Weblizar Responsive WordPress Theme</h2>
			<h6>Get The Premium Products & Create Your Website Beautifully.  </h6>
		</div>
		<div class="section container">
			<div class="col-lg-6">
				<h2>Premium Themes </h2>
				<br>
				<ol id="weblizar_product">
					<li><a href="http://weblizar.com/themes/enigma-premium/">Enigma </a> </li>
					<li><a href="http://weblizar.com/themes/weblizar-premium-theme/">Weblizar </a></li>					
					<li><a href="http://weblizar.com/themes/guardian-premium-theme/">Guardian </a></li>
					<li><a href="http://weblizar.com/plugins/green-lantern-premium-theme/">Green Lantern</a> </li>
					<li><a href="https://weblizar.com/themes/creative-premium-theme/">Creative </a> </li>
					<li><a href="https://weblizar.com/themes/incredible-premium-theme/">Incredible </a></li>
				</ol>
			</div>
			<div class="col-lg-6">
				<h2>Pro Plugins</h2>
				<br>
				<ol id="weblizar_product">
					<li><a href="http://weblizar.com/plugins/responsive-photo-gallery-pro/">Responsive Photo Gallery</a></li>
					<li><a href="http://weblizar.com/plugins/ultimate-responsive-image-slider-pro/">Ultimate Responsive Image Slider</a></li>
					<li><a href="http://weblizar.com/plugins/responsive-portfolio-pro/">Responsive Portfolio</a></li>
					<li><a href="http://weblizar.com/plugins/photo-video-link-gallery-pro//">Photo Video Link Gallery</a></li>
					<li><a href="http://weblizar.com/plugins/lightbox-slider-pro/">Lightbox Slider</a></li>
					<li><a href="http://weblizar.com/plugins/flickr-album-gallery-pro/">Flickr Album Gallery</a></li>
					<li><a href="https://weblizar.com/plugins/instagram-shortcode-and-widget-pro/">Instagram Shortcode &amp; Widget</a></li>
					<li><a href="https://weblizar.com/plugins/instagram-gallery-pro/">Instagram Gallery</a></li>
					<li><a href="https://weblizar.com/plugins/gallery-pro/">Gallery Pro</a></li>
				</ol>
			</div>
		</div>	
	</div>
</div>