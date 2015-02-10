<?php
/*
Plugin Name: Vibe Ajax Login
Plugin URI: http://www.vibethemes.com
Description: The Ajax login widget for vEstate.
Version: 1.0
Author: VibeThemes
Author URI: http://www.vibethemes.com
*/

require_once( 'login-config.php' );
require_once( 'inc/activation.php' );

register_activation_hook( __FILE__, 'al_configure_database' );

add_action( 'widgets_init', 'ajaxwp_login_init' );	
	
function ajaxwp_login_init() {

	load_plugin_textdomain( 'al-domain', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	
	al_import_class( 'Ajax_Login_Attempts', 'inc/class-ajax-login-attempts.php' );
	al_import_class( 'Ajax_Login_Widget', 'inc/class-ajax-login-widget.php' );
			
	register_widget( 'Ajax_Login_Widget' );	
		
	if ( is_active_widget( false, false, 'ajaxwp_login_widget', true ) ) {
		
		if ( is_admin() ) {
		
			require_once( 'inc/ajax.php' );
			
			add_action( 'wp_ajax_ajaxwp_login_hook', 'ajaxwp_login_ajax' );
			add_action( 'wp_ajax_nopriv_ajaxwp_login_hook', 'ajaxwp_login_ajax' );
			
			add_action( 'wp_ajax_ajax_registration_hook', 'ajax_registration_ajax' );
			add_action( 'wp_ajax_nopriv_ajax_registration_hook', 'ajax_registration_ajax' );
			
			add_action( 'wp_ajax_ajax_lostpwd_hook', 'ajax_lostpwd_ajax' );
			add_action( 'wp_ajax_nopriv_ajax_lostpwd_hook', 'ajax_lostpwd_ajax' );
			
		}
		
		if ( ! is_admin() ) {
			
			$al_options	= get_option( 'al_options' );
			
			if ( $al_options['redirect_logout'] == 'custom' && $al_options['redirect_logout_url'] != '' ) {
				
				function al_allow_ms_parent_redirect( $allowed ) {
					
					$al_options	= get_option( 'al_options' );
					$uri		= parse_url( $al_options['redirect_logout_url'] );
					$allowed[] 	= $uri['host'];
					return $allowed;
		
				}
				
				add_filter( 'allowed_redirect_hosts', 'al_allow_ms_parent_redirect' );
				
			}
		
			if ( ! function_exists( 'recaptcha_get_html' ) )
				require_once( 'inc/lib/recaptchalib.php' );
		
			$sal_plugins_url	= ( is_ssl() ) ? str_replace( 'http://', 'https://', plugin_dir_url( __FILE__ ) ) : plugin_dir_url( __FILE__ );
			$recaptcha_js		= ( is_ssl() ) ? 'https://www.google.com/recaptcha/api/js/recaptcha_ajax.js' : 'http://www.google.com/recaptcha/api/js/recaptcha_ajax.js';
			
			wp_register_script( 'blockui',  $sal_plugins_url . 'js/jquery.blockUI.js', array( 'jquery' ), '2.53' );
			wp_register_script( 'al-javascript', $sal_plugins_url . 'js/ajax-login.js', array( 'jquery' ), '2.0' );
			wp_register_script( 'recaptcha', $recaptcha_js, array(), '1.0' );

			wp_enqueue_script( 'recaptcha' );
			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'blockui' );
			wp_enqueue_script( 'al-javascript' );
			
			wp_register_style( 'al-style', $sal_plugins_url . 'style.css', array(), '1.0', 'all' );
			
			wp_enqueue_style( 'al-style' );
			
			wp_localize_script( 
				'al-javascript', 
				'ajaxwp_loginl_data', 
				array( 
					'ajaxurl'		=> admin_url( 'admin-ajax.php' ), 
					'loadingurl'	=> $sal_plugins_url . 'img/ajax-loader.gif',
					'public_key'	=> $al_options['recaptcha_public_key'],
					'captcha_enter'	=> __( 'Enter the two words above', 'al-domain' ),
					'captcha_get'	=> __( 'Get another Captcha', 'al-domain' )
				) 
			);
			
		} // END ! is_admin()
		
    } // END is_active_widget()
	
	if ( is_admin() ) {
		
		al_import_class( 'Ajax_Login_Admin', 'inc/admin/class-ajax-login-admin.php' );
		
		if ( ! function_exists( 'recaptcha_get_html' ) )
			require_once( 'inc/lib/recaptchalib.php' );
			
		$admin_init	= new Ajax_Login_Admin();
		
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'ajaxwp_login_settings_link' );
		
	} // END is_admin()
	
}

function ajaxwp_login_settings_link( $links ) {

	$settings_link	= '<a href="options-general.php?page=al_options">' . esc_html__( 'Settings' ) . '</a>'; 
	array_unshift( $links, $settings_link ); 
	return $links;
  
}

function al_import_class( $class, $file ) {
	
	if ( ! class_exists( $class ) )
		require_once( $file );
	
}
?>