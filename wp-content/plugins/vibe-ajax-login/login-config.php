<?php 

global $wpdb;
define( 'AL_NONCE_SECURITY', 'ajax-login-nonce' );
define( 'AL_LOGIN_TABLE',  $wpdb->prefix . 'ajaxwp_login' );
define( 'AL_LOGIN_ATTEMPTS', 3 );
define( 'AL_LOGIN_ATTEMPTS_LAPSE', 10 );
define( 'AL_LOSTPWD_TIME_LAPSE', 10 );
define( 'AL_VERSION', '2.5' );
define( 'AL_PLUGIN_ROOT_URL', plugin_dir_url( __FILE__ ) );

?>
