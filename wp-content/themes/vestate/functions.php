<?php

/**
 * FILE: functions.php 
 * Created on Feb 12, 2013 at 6:44:28 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */

// BASIC Includes


include_once 'includes/config.php';
include_once 'includes/errorhandle.php';
include_once 'includes/init.php';


include_once 'includes/customizer/customizer.php';
include_once 'includes/customizer/css.php';

include_once 'includes/register.php';
include_once 'includes/func.php';



include_once('includes/custom-post-types.php');
include_once('includes/metaboxes/meta_box.php');
include_once 'includes/featured_media.php';


include_once('includes/metaboxes/library/vibe-editor.php');
include_once('includes/custom_meta_boxes.php');
include_once 'includes/vibe-menu.php';

include_once('includes/shortcodes/vibe-shortcodes.php');
include_once('includes/shortcodes/shortcodes.php');
include_once ('includes/listings.php');


if ( in_array( 'vibe-front-end/vibe-front-end.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    include_once 'includes/front_forms.php';
}

include_once('includes/widgets/custom_widgets.php');
include_once('includes/widgets/advanced_woocommerce_widgets.php');
include_once('includes/widgets/twitter.php');
include_once('includes/widgets/flickr.php');
include_once('includes/widgets/instagram.php');
include_once('includes/widgets/advanced_listings_search.php');
include_once 'includes/sharing.php';
include_once 'includes/tour.php';


//THEME OPTIONS PANEL
get_template_part( 'vibe', 'options' );  

?>