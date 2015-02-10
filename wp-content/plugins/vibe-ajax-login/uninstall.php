<?php

if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();
	
require_once( 'al-config.php' );

global $wpdb;

delete_option( 'al_options' );

delete_option( 'al_config' );

delete_option( 'widget_ajaxwp_login_widget' );

$delete_metas	= '
	DELETE
	FROM ' . $wpdb->usermeta . ' 
	WHERE ' . $wpdb->usermeta . '.meta_key = "al_lostpwd_time"
';

$wpdb->query( $delete_metas );

$wpdb->query( 'DROP TABLE IF EXISTS ' . AL_LOGIN_TABLE . ';' );

?>