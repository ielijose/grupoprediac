<?php

class VibeShortcodes {

    function __construct() 
    {	
    	//require_once( plugin_dir_path( __FILE__ ) .'shortcodes.php' );
    	define('VIBE_TINYMCE_URI', VIBE_URL.'/includes/shortcodes/tinymce');
	define('VIBE_TINYMCE_DIR', VIBE_PATH .'/includes/shortcodes/tinymce');
		
        add_action('init', array(&$this, 'init'));
        
        add_action('admin_init', array(&$this, 'admin_icons'));
        add_action('admin_init', array(&$this, 'admin_init'));
        //add_action( 'admin_print_scripts-post-new.php', array(&$this, 'admin_init') );
        //add_action( 'admin_print_scripts-post.php', array(&$this, 'admin_init') );
        
        //add_action( 'admin_print_styles-post-new.php', array(&$this, 'admin_css') );
       // add_action( 'admin_print_styles-post.php', array(&$this, 'admin_css') );
        
	}
	
	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function init()
	{
		
		
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;
	
		if ( get_user_option('rich_editing') == 'true' )
		{
			add_filter( 'mce_external_plugins', array(&$this, 'add_rich_plugins') );
			add_filter( 'mce_buttons', array(&$this, 'register_rich_buttons') );
		}
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Defins TinyMCE rich editor js plugin
	 *
	 * @return	void
	 */
	function add_rich_plugins( $plugin_array )
	{
		
		if ( floatval(get_bloginfo('version')) >= 3.9){
			$plugin_array['vibeShortcodes'] = VIBE_TINYMCE_URI . '/plugin.js';
		}else{
			$plugin_array['vibeShortcodes'] = VIBE_TINYMCE_URI . '/plugin.old.js'; // For old versions of WP
		}
		return $plugin_array;
	}
	
	// --------------------------------------------------------------------------
	
	/**
	 * Adds TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function register_rich_buttons( $buttons )
	{
		array_push( $buttons, "|", 'vibe_button' );
		return $buttons;
	}
	
	/**
	 * Enqueue Scripts and Styles
	 *
	 * @return	void
	 */
	function admin_init()
	{       
        if(is_admin()){
		
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-livequery', VIBE_TINYMCE_URI . '/js/jquery.livequery.js', false, '1.1.1', false );
			wp_enqueue_script( 'jquery-appendo', VIBE_TINYMCE_URI . '/js/jquery.appendo.js', false, '1.0', false );
			wp_enqueue_script( 'base64', VIBE_TINYMCE_URI . '/js/base64.js', false, '1.0', false );

			if ( floatval(get_bloginfo('version')) >= 3.9){
			  wp_enqueue_script( 'vibe-popup', VIBE_TINYMCE_URI . '/js/popup.js', array('jquery-ui-core','jquery-ui-widget','jquery-ui-mouse','jquery-ui-draggable','jquery-ui-slider','iris'), '1.0', false );
			}else{
				wp_enqueue_script( 'vibe-popup', VIBE_TINYMCE_URI . '/js/popup.old.js', array('jquery-ui-core','jquery-ui-widget','jquery-ui-mouse','jquery-ui-draggable','jquery-ui-slider','iris'), '1.0', false );
				//For older versions of WP
			}
			
			wp_localize_script( 'jquery', 'VibeShortcodes', array('shortcodes_folder' => VIBE_URL .'/includes/shortcodes') );
        }
                
        if(is_admin()){
			wp_enqueue_style( 'vibe-popup', VIBE_TINYMCE_URI . '/css/popup.css', false, '1.0', 'all' );
                wp_enqueue_style( 'shortcodes-css', VIBE_URL.'/css/shortcodes.css');
        }
            
        }
        /*
        function admin_css(){
            // css
                if(is_admin()){
		wp_enqueue_style( 'vibe-popup', VIBE_TINYMCE_URI . '/css/popup.css', false, '1.0', 'all' );
                wp_enqueue_style( 'shortcodes-css', VIBE_URL.'/css/shortcodes.css');
                }
                
        }*/
        function admin_icons(){
            wp_enqueue_style( 'icons-css', VIBE_URL.'/css/fonticons.css');
        }
    
}
$vibe_shortcodes = new VibeShortcodes();

?>