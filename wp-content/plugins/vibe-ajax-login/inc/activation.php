<?php
function al_configure_database() {
	
	// ajax Login Config
	$exist_ajaxwp_login	= get_option( 'widget_ajaxwp_login_widget' );
	$old_config			= get_option( 'al_config' );
	$defaults			= array( 'version' => AL_VERSION );
	$new_config			= wp_parse_args( $old_config, $defaults );
	
	if ( $exist_ajaxwp_login && !$old_config )
		delete_option( 'widget_ajaxwp_login_widget' );
	
	update_option( 'al_config', $new_config );
	
	// ajax Login Options
	$defaults	= array(
		'enable_captcha'		=> FALSE,
		'recaptcha_public_key'	=> '',
		'recaptcha_private_key'	=> '',
		'show_dashboard'		=> TRUE,
		'show_profile'			=> TRUE,
		'show_avatar'			=> TRUE,
		'show_nickname'			=> TRUE,
		'avatar_size'			=> 220,
		'wrap_width'			=> 240,
		'redirect_login'		=> 'current',
		'redirect_login_url'	=> '',
		'redirect_logout'		=> 'current',
		'redirect_logout_url'	=> '',
		'registration_enabled'	=> TRUE,
		'lostpwd_enabled'		=> TRUE
	);
	$old_options	= get_option( 'al_options' );
	$new_options	= wp_parse_args( $old_options, $defaults );
	
	update_option( 'al_options', $new_options );
	
	global $wpdb;
	
	$wpdb->query( '	
		CREATE TABLE IF NOT EXISTS ' . AL_LOGIN_TABLE . ' (
		ip varchar(255) NOT NULL,
		last_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		login_attempts tinyint DEFAULT 1,
		PRIMARY KEY  (ip)
		);'
	);
		
}
?>