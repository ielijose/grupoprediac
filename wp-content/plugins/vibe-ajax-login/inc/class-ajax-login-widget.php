<?php
class Ajax_Login_Widget extends WP_Widget {
	
	private static $instance;
	
	function Ajax_Login_Widget() {

		$this->WP_Widget( 'ajaxwp_login_widget', 'ajax Login', array( 'classname' => 'ajaxwp_login_widget', 'description' => 'A simple widget for login in Wordpress.' ) );
		
	}
	
	function widget( $args, $instance ) {
	
		if ( empty( $this->instance ) )
			$this->instance = true;
		else
			return;
			
		extract( $args, EXTR_SKIP );
		
		$title			= empty( $instance['title'] ) ? ' ' : apply_filters( 'widget_title', $instance['title'] );
		$al_options		= get_option( 'al_options' );
		$error_width	= $al_options['wrap_width'] - 20;
		
		echo $before_widget;
				
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		
		?>
		
		<div id="ajax-login-show-error" style="max-width: <?php echo esc_attr( $error_width ); ?>px;"></div>
   
		<div id="ajax-login-wrap" style="max-width: <?php echo esc_attr( $al_options['wrap_width'] ); ?>px;">
			
		<?php
		
		if ( is_user_logged_in() ) {
			
			global $current_user;
			get_currentuserinfo();
			$buttons	= array();
			
			if ( $al_options['show_dashboard'] )
				$buttons['Dashboard']	= admin_url();

			if ( $al_options['show_profile'] )
				$buttons['Edit My Profile']	=  admin_url( 'profile.php' ); 

			$buttons['Log Out']	= ( $al_options['redirect_logout'] == 'custom' && $al_options['redirect_logout_url'] != '' ) ? wp_logout_url( $al_options['redirect_logout_url'] ) : wp_logout_url( $this->current_url() );			
			
			?> 
			<div id="ajax-login-user" > 
				<?php
					
				if ( $al_options['show_avatar'] ) 	
					echo get_avatar( $current_user->ID, $al_options['avatar_size'] );
				
				echo '<div class="account_info"><ul>';

				if ( $al_options['show_nickname'] ) 
					echo '<li><h4>' . $current_user->nickname . '</h4></li>';
					
				if(function_exists('vibe_get_option'))	{
					$account = vibe_get_option('agent_account_page');
					$listing = vibe_get_option('agent_add_listings_page');


					if(isset($account)  && current_user_can( 'edit_posts' )){
						echo '<li><a href="' . get_page_uri($account) . '">'.__('Account','vibe').'</a></li>';
					}
					if(isset($listing) && current_user_can( 'edit_posts' ) ){
						echo '<li><a href="' . get_page_uri($listing) . '">'.__('Add Listing','vibe').'</a></li>';	
					}
				}
				foreach ( $buttons as $text => $href ) {
					echo '<li><a href="' . esc_attr( $href ) . '">' . esc_html__( $text ) . '</a></li>';
				}
				
				echo '</ul></div>';

			?></div><?php
			
		} else {
		
		
			$attempts			= new Ajax_Login_Attempts();
			
			$login_captcha		= ( $al_options['enable_captcha'] && $attempts->get_attempts() >= AL_LOGIN_ATTEMPTS ) ? 'block' : 'none';
			
			$redirect_to		= ( $al_options['redirect_login'] == 'custom' ) ? $al_options['redirect_login_url'] : $this->current_url();
			
			 $can_register		= get_option('users_can_register');
			 $show_registration	= $al_options['registration_enabled'];
			 
			$show_lostpwd		= $al_options['lostpwd_enabled'];
			$login_tab_width	= ( ! $can_register || ! $show_registration ) ? '100' : '50';
			
			?>
			<div id="ajax-login-tabs">
			
				<a class="ajax-login-tab selected" name="al-tab-login" href="#" style="width: <?php echo esc_attr( $login_tab_width ); ?>%;" ><?php esc_html_e( 'Log in' ) ?></a>

				<?php if ( $can_register && $show_registration ): ?> 
					<a class="ajax-login-tab" name="al-tab-registration" href="<?php echo esc_url( site_url( 'wp-login.php?action=register' ) ); ?>" ><?php esc_html_e( 'Register' ) ?></a>
				<?php endif;?>
				
			</div>
			
			<div id="ajax-login-content-tab">
			
				<?php if ( $can_register && $show_registration ): ?> 
				
				<div id="ajax-login-registration-form" class="ajax-login-form-wrap">
					
					<form id="al-registration-form" action="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>" method="post">
						<p>
							<!--[if lte IE 9]><label for="al-first-input-registration"><?php esc_html_e( 'Username' ); ?>: </label><![endif]-->
							<input type="text" name="user_login" size="20" class="al-input" id="al-first-input-registration" placeholder="<?php esc_attr_e( 'Username' ); ?>"  tabindex="421" required/>
						</p>
						<p>
							<!--[if lte IE 9]><label for="user_email"><?php esc_html_e( 'E-mail' ); ?>: </label><![endif]-->
							<input type="email" name="user_email" class="al-input" id="al-user-email" size="25" placeholder="<?php esc_attr_e( 'E-mail' ); ?>"  tabindex="422" required/>
						</p>
						<p>
							<div id="ajax-registration-recaptcha" class="ajax-div-captcha" style="display: <?php echo ( $al_options['enable_captcha'] ) ? esc_attr( 'block' ) : esc_attr( 'none' );?>;"></div>
							<input type="submit" name="user-submit" value="<?php esc_attr_e( 'Register' ); ?>"  tabindex="424"/>
							<?php wp_nonce_field( AL_NONCE_SECURITY, 'nonce'  ); ?>
							<input type="hidden" name="url" value="<?php echo esc_url( site_url( 'wp-login.php?action=register', 'login_post' ) ); ?>" />
							<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
						</p>
					</form>
					
				</div>
				
				<?php endif;?>
				
				<?php if ( $show_lostpwd ): ?>
				
				<div id="ajax-login-lostpwd-form" class="ajax-login-form-wrap">
				
					<h3><?php esc_html_e( 'Lost your password?' );?></h3>
					
					<p><?php esc_html_e( 'Please enter your username or email address. You will receive a link to create a new password via email.' );?></p>
					
					<form id="al-lostpwd-form" method="post" action="<?php echo site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ?>">
						<p>
							<input type="text" name="user_login" size="20" class="al-input" id="al-first-input-lostpwd" placeholder="<?php esc_attr_e( 'Username or E-mail' ); ?>" required  tabindex="421"/>
						</p>
						<p>
							<input type="submit" name="user-submit" value="<?php esc_attr_e( 'Get New Password' ); ?>" tabindex="422"/>
							<?php wp_nonce_field( AL_NONCE_SECURITY, 'nonce' ); ?>
							<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
						<p>
					</form>
					
				</div>
				
				<?php endif;?>
				
				<div id="ajax-login-login-form" class="ajax-login-form-wrap" style="display: block;">
				
					<form id="al-login-form" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
						<p>
							<!--[if lte IE 9]><label for="al-first-input-login"><?php esc_html_e( 'Username' ); ?>:</label><![endif]-->
							<input type="text" name="log" id="al-first-input-login" size="20" placeholder="<?php esc_attr_e( 'Username' ); ?>"  tabindex="421" required />
						</p>
						<p>
							<!--[if lte IE 9]><label for="al-user-pass-login"><?php esc_html_e( 'Password' ); ?>:</label><![endif]-->
							<input type="password" name="pwd" id="al-user-pass-login" size="20" placeholder="<?php esc_attr_e( 'Password' ); ?>" tabindex="422" required />
						</p>
						
						<div id="ajax-login-recaptcha" class="ajax-div-captcha" style="display: <?php echo esc_attr( $login_captcha ); ?>;"></div>
						
						<input type="submit" name="wp-submit" class="submit-button" value="<?php esc_attr_e( 'Log In' ); ?>" tabindex="424">
						
						<input type="hidden" name="rememberme" value="forever" />
						<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
						<?php wp_nonce_field( AL_NONCE_SECURITY, 'nonce' ); ?>
						
					</form>
				
					<?php if ( $show_lostpwd ): ?>
						<a name="al-tab-lostpwd" href="<?php echo esc_url( site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ); ?>" title="<?php esc_attr_e( 'Lost your password?' ); ?>" tabindex="425" ><?php esc_html_e( 'Lost your password?' ) ?></a>
					<?php endif;?>
					
				</div> 
			
			</div> <!-- END ajax-login-content-tab -->

			<?php
		}
		
		echo '</div>';
		echo $after_widget;
		
	}
	
	function update( $new_instance, $old_instance ) {
	
		$instance			= $old_instance;
		$instance['title']	= strip_tags( $new_instance['title'] );
		return $instance;
		
	}
	
	function form( $instance ) {
		
		$instance		= wp_parse_args( ( array ) $instance, array( 'title' => 'ajax Login' ) );
		$title 			= strip_tags( $instance['title'] );
		
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title' ); ?>: 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</label>
		</p>
		<?php
		
	}
	
	private function current_url() {

		$current_url	= ( force_ssl_admin() || is_ssl() ) ? 'https://' : 'http://';
		$current_url	.= esc_attr( $_SERVER['HTTP_HOST'] );
		$current_url	.= esc_attr( $_SERVER['REQUEST_URI'] );
		return strip_tags( $current_url );
	
	}
	
}
?>