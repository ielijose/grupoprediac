<?php

/**
 * FILE: functions.php 
 * Created on Apr 20, 2013 at 5:49:28 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: Vizard
 * License: GPLv2
 */

// Attaching function to Theme Hook "vibe_after_header"
add_action( 'vibe_after_header', 'custom_css_function' );

function custom_css_function(){
    echo '<link rel="stylesheet" href="'.  get_stylesheet_directory_uri().'/custom.css">';
}


add_action( 'vibe_after_footer', 'custom_js_function' );
function custom_js_function(){
   echo '<script type="text/javascript" src="'.  get_stylesheet_directory_uri().'/custom.js"></script>'; 
}

remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wp_generator');

add_filter('pre_comment_content', 'wp_specialchars');
?>
