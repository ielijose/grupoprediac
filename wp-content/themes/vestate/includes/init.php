<?php

/**
 * FILE: init.php 
 * Created on Feb 12, 2013 at 7:30:53 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */


if ( ! isset( $content_width ) ) $content_width = 1170;

function vibe_admin_url($url) {
	if (is_multisite()) {
		if  (is_super_admin())
			return network_admin_url($url);
	} else {
		return admin_url($url);
	}
}

function vibe_site_url($url) {
	if (is_multisite()) {
		return network_site_url($url);
	} else {
		return site_url($url);
	}
}

add_theme_support( 'woocommerce' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'automatic-feed-links' );


//Translation Support
function wpse49326_translate_theme() {
    // Load Theme textdomain
    load_theme_textdomain( 'vibe', get_template_directory() . '/languages');

    // Include Theme text translation file
    $locale = get_locale();
    $locale_file = get_template_directory() . "/languages/$locale.php";
    if ( is_readable( $locale_file ) ) {
        require_once( $locale_file );
    }
}
add_action( 'after_setup_theme', 'wpse49326_translate_theme' );




// Auto plugin activation
require_once('plugin-activation.php');
add_action('tgmpa_register', 'register_required_plugins');
function register_required_plugins() {
	$plugins = array(
		array(
			'name'     				=> 'Revolution Slider', // The plugin name
			'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
			'source'   				=> VIBE_URL . '/plugins/revslider.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
                array(
			'name'     				=> 'Vibe WordPress Importer', // The plugin name
			'slug'     				=> 'vibe-wordpress-importer', // The plugin slug (typically the folder name)
			'source'   				=> VIBE_URL . '/plugins/vibe-wordpress-importer.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
        array(
			'name'     				=> 'Vibe Front End', // The plugin name
			'slug'     				=> 'vibe-front-end', // The plugin slug (typically the folder name)
			'source'   				=> VIBE_URL . '/plugins/vibe-front-end.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Vibe Ajax Login', // The plugin name
			'slug'     				=> 'vibe-ajax-login', // The plugin slug (typically the folder name)
			'source'   				=> VIBE_URL . '/plugins/vibe-ajax-login.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
	);



	// Change this to your theme text domain, used for internationalising strings
	$theme_text_domain = 'vibe';

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=>'vibe',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins','vibe' ),
			'menu_title'                       			=> __( 'Install Plugins','vibe' ),
			'installing'                       			=> __( 'Installing Plugin: %s','vibe' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.','vibe' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
			'return'                           			=> __( 'Return to Required Plugins Installer','vibe' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.','vibe' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s','vibe' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa($plugins, $config);
}

if(!function_exists('vibe_random')){
	function vibe_random(){
		$date = new DateTime();
        return($date->getTimestamp());
	}
}

/* ===========================================================================================*/
/*========================= Woo Commerce Fixes ===============================================*/
/* ===========================================================================================*/

     //remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
            global $vibe_options;
            if(isset($vibe_options['woocommerce_columns']))
		return $vibe_options['woocommerce_columns']; // 3 products per row
            else
                return 3;
	}
}
/**
 * Hook in on activation
 */
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) add_action( 'init', 'yourtheme_woocommerce_image_dimensions', 1 );
 
/**
 * Define image sizes
 */
function yourtheme_woocommerce_image_dimensions() {
  	$catalog = array(
		'width' 	=> '400',	// px
		'height'	=> '400',	// px
		'crop'		=> 1 		// true
	);
 
	$single = array(
		'width' 	=> '600',	// px
		'height'	=> '600',	// px
		'crop'		=> 0		// true
	);
 
	$thumbnail = array(
		'width' 	=> '90',	// px
		'height'	=> '90',	// px
		'crop'		=> 0 		// false
	);
 
	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}

//
    add_filter( 'loop_shop_per_page','shop_no_products', 20 );
    
function shop_no_products(){ global $vibe_options;
    if(isset($vibe_options['woocommerce_no_products']) && $vibe_options['woocommerce_no_products'])
        return $vibe_options['woocommerce_no_products'];
    else
        return 16;
        
}    


// Remove default WooCommerce breadcrumbs and add Yoast ones instead
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
add_action( 'woocommerce_before_main_content','vibe_breadcrumbs', 20, 0);

if (!function_exists('woocommerce_output_upsells')) {
	function woocommerce_output_upsells() {
            global $vibe_options;
            if(isset($vibe_options['woocommerce_columns']) && $vibe_options['woocommerce_columns']<6){
                $cols=$vibe_options['woocommerce_columns'];
            }else {
                $cols=3;
            }
	    woocommerce_upsell_display($cols,$cols); // Display 3 products in rows of 3
	}
}


function woocommerce_output_related_products() {
    global $vibe_options;
            if(isset($vibe_options['woocommerce_columns']) && $vibe_options['woocommerce_columns']<6){
                $cols=$vibe_options['woocommerce_columns'];
            }else {
                $cols=3;
            }
    woocommerce_related_products($cols,$cols); // Display 3 products in rows of 3
}


/*
function woo_share()
{         $show_sharing = getPostMeta(get_the_ID(),'vibe_sharing');
         if($show_sharing !=0){
            echo '<div class="product_sharing">'.social_sharing('top').'</div>';
         }
}*/


add_action( 'woocommerce_sidebar', 'vibe_woocommerce_sidebars' );

function vibe_woocommerce_sidebars( $post_ID )  
{
    global $post;
   if(is_product()){
       $vsidebar = getPostMeta($post->ID,'vibe_sidebar');
       if(!isset($vsidebar))
        $vsidebar='shop';
       
       if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar($vsidebar) ) :?>
        <?php
       endif;
       
   }
}

add_filter ('add_to_cart_redirect', 'redirect_to_checkout');

function redirect_to_checkout() {
    global $woocommerce;
    $checkout_url = $woocommerce->cart->get_checkout_url();
    return $checkout_url;
}

function vibe_get_option($field,$compare = NULL){
    
    $option=get_option(THEME_SHORT_NAME);
    
    $return = isset($option[$field])?$option[$field]:NULL;
    if(isset($return)){
        if(isset($compare)){
        if($compare === $return){
            return true;
        }else
            return false;
    }
    	return $return;
    }else
    	return NULL;
    
}



?>
