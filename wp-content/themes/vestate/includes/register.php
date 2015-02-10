<?php

/**
 * FILE: register.php 
 * Created on Feb 12, 2013 at 7:31:02 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */

global $vibe_options;

if(function_exists('add_image_size')){
    add_image_size('mini', 128, 999);
    add_image_size('small', 310, 9999);
    add_image_size('medium', 460, 9999);
    add_image_size('big', 768, 9999);
}



//ENQUEUE SCRIPTS TO HEAD
function enqueue_head() {
    $theme_customizer=get_option('viz_customizer');
    global $vibe_options;
    //if(!isset($vibe_options))
        $vibe_options=get_option(THEME_SHORT_NAME);
    
 if( ! is_admin() )
  {
     
     /*=== Enqueing Google Web Fonts =====*/
     $font_string='';
     if(isset($vibe_options['google_fonts']) && is_array($vibe_options['google_fonts'])){
     foreach($vibe_options['google_fonts'] as $font){
         $font= preg_replace('/(?<! )(?<!^)[A-Z]/',' $0', $font);
         $font=str_replace(' ','+',$font);
         $font_string.=$font.':100,200,300,400,600,700,800|';
     }
     $protocol = is_ssl() ? 'https' : 'http';
        $query_args = array(
        'family' => $font_string,
        'subset' => 'latin,latin-ext',
        );

        wp_enqueue_style('google-webfonts',
        add_query_arg($query_args, "$protocol://fonts.googleapis.com/css" ),
        array(), null);
     }
/*=== End Web Fonts ===== */
     
     wp_enqueue_style('twitter', VIBE_URL.'/css/bootstrap.css');
     
     wp_enqueue_style( 'bootstrap-fix', VIBE_URL .'/css/bootstrap-fix.css' );
     
     if(isset($vibe_options['content_area']) && $vibe_options['content_area'])
        wp_enqueue_style( 'bootstrap-1170', VIBE_URL .'/css/1170.css' );
     
     $minified = vibe_get_option('minified');
     if(isset($minified) && $minified){
        wp_enqueue_style( 'minified-css', VIBE_URL .'/css/minified.css' );
     }else{
     wp_enqueue_style( 'fonticons-css', VIBE_URL .'/css/fonticons.css' );
     wp_enqueue_style( 'animation-css', VIBE_URL .'/css/animation.css' );
     wp_enqueue_style( 'shortcodes-css', VIBE_URL .'/css/shortcodes.css' );
     wp_enqueue_style( 'slider-css', VIBE_URL .'/css/slider.css' );
     wp_enqueue_style( 'search-css', VIBE_URL .'/css/chosen.css' );
     wp_enqueue_style( 'date-picker', VIBE_URL .'/css/jdpicker.css' );
     wp_enqueue_style( 'prettyphoto-css', VIBE_URL .'/css/prettyPhoto.css' );
     wp_enqueue_style( 'audio-css', VIBE_URL .'/css/audioplayer.css' );
     wp_enqueue_style( 'video-css', VIBE_URL .'/css/video-js.min.css' );
     }

     wp_register_script( 'gmaps-js', 'http://maps.google.com/maps/api/js?sensor=false');

     wp_enqueue_style('theme-css', get_stylesheet_uri(), 'twitter');

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {     
     wp_enqueue_style( 'woocommerce-css', VIBE_URL .'/css/woocommerce.css' );
     wp_deregister_style( 'woocommerce_chosen_styles' );
    
}
     
     
     if($vibe_options['responsive'] !=0)
     wp_enqueue_style( 'responsive-css', VIBE_URL .'/css/responsive.css' );
     
     //$theme_customizer=get_option('viz_customizer');
     
      
      /*
     $url = VIBE_URL .'/includes/customizer/css.php?';
     
     //$encoded = urlencode(strtr(base64_encode(addslashes(gzcompress(serialize($theme_customizer),9))), '+/=', '-_,'));
     $first = true;
     if(isset($theme_customizer) && is_array($theme_customizer)){
    foreach($theme_customizer as $key => $value) {
        if(isset($value) && $value !=''){
        if(!$first) 
            $url .= '&amp;';
        else 
            $first = false;

            $url .= 'customizer['.urlencode($key).']='.urlencode($value);
            }
        }
     }
     
     wp_enqueue_style( 'customizer-css', $url); 
     */
     
     wp_enqueue_script( 'jquery' );
      if(isset($vibe_options['listing_fields']['field_type']) && array_search('gmap',$vibe_options['listing_fields']['field_type']))
            wp_enqueue_script( 'gmaps-js' );
    }
}    

add_action('wp_enqueue_scripts', 'enqueue_head');
add_action("wp_head", "print_customizer_style");
function enqueue_after_head(){
  echo '<script>var players=[];var aspectRatio=[];</script>';
     /*=====*/
    //wp_enqueue_style( 'options-css', VIBE_URL .'/css/options.css' );
    //wp_enqueue_script( 'options-js', VIBE_URL .'/js/options.js' );
     do_action('vibe_after_header'); // Custom Hook for Header  
}

add_action('wp_enqueue_scripts', 'enqueue_after_head');
//ENQUEUE SCRIPTS TO FOOTER
function enqueue_footer() {
    if(!is_admin()){ global $vibe_options, $vibe_post_script;

    wp_register_script( 'easing', VIBE_URL.'/js/jquery.easing.1.3.js'); 
    wp_register_script( 'bootstrap', VIBE_URL.'/js/bootstrap.min.js'); 
    wp_register_script( 'flexslider', VIBE_URL.'/js/jquery.flexslider-min.js'); 
    wp_register_script( 'prettyphoto', VIBE_URL.'/js/jquery.prettyPhoto.js');
    wp_register_script( 'imagesloaded-js', VIBE_URL.'/js/jquery.imagesloaded.js');
    wp_register_script( 'isotope', VIBE_URL.'/js/jquery.isotope.min.js');
    wp_register_script( 'fitvids', VIBE_URL.'/js/jquery.fitvids.js');
    wp_register_script( 'audiojs', VIBE_URL.'/js/audioplayer.min.js');
    wp_register_script( 'videojs', VIBE_URL.'/js/video.min.js');
    wp_register_script( 'advanced_search', VIBE_URL.'/js/chosen.jquery.min.js');
    wp_register_script( 'date_picker', VIBE_URL.'/js/jquery.jdpicker.js');
    wp_register_script( 'masonry-js', VIBE_URL.'/js/masonry.min.js');
    wp_register_script( 'instagram-js', VIBE_URL.'/js/spectragram.min.js');
    wp_register_script( 'knob-js', VIBE_URL.'/js/jquery.knob.js');
    
    wp_register_script( 'custom', VIBE_URL.'/js/custom.js');
    

    $minified = vibe_get_option('minified');
     if(isset($minified) && $minified){
        wp_enqueue_script( 'minified-js', VIBE_URL .'/js/minified.js' );
     }else{
    wp_enqueue_script( 'easing' );
    wp_enqueue_script( 'bootstrap' );
    wp_enqueue_script( 'jquery-ui-slider' );
    wp_enqueue_script( 'flexslider' );
    wp_enqueue_script( 'imagesloaded-js' );
    wp_enqueue_script( 'fitvids' );
    wp_enqueue_script( 'mordernizer-js', VIBE_URL .'/js/modernizr.custom.js' );
    wp_enqueue_script( 'knob-js' );
    }// END ELSE

    wp_enqueue_script( 'prettyphoto' );
    wp_enqueue_script( 'instagram-js' );
    wp_enqueue_script( 'masonry-js' );
    wp_enqueue_script( 'isotope' );
    wp_enqueue_script( 'audiojs' );
    
    wp_enqueue_script( 'advanced_search' ); //Chosen
    wp_enqueue_script( 'videojs' );

    wp_enqueue_script( 'custom' ); 
 
    }
}    
 
add_action('wp_footer', 'enqueue_footer');

function enqueue_after_footer(){
    global $vibe_options,$vibe_post_script;
if($vibe_options['thumb_slider_delay'] && $vibe_options['thumb_slider_delay'] !=0)
    $delay= $vibe_options['thumb_slider_delay'];
else
    $delay = 'false';



 echo '<script type="text/javascript">
      jQuery(window).load(function(){
          '.$vibe_post_script.'
		jQuery(".thumb_slider").carousel({ interval: '.$delay.' });
        });
        </script>';
 
 do_action('vibe_after_footer');
}
add_action('wp_footer', 'enqueue_after_footer');

//ENABLE MENUS
function register_vibe_menus() {
register_nav_menus(
array(
'main-menu' => __( 'Main Menu','vibe' ),
'top-menu' => __( 'Top Menu','vibe' )
  )
  );
}
add_action( 'init', 'register_vibe_menus' );


add_action('init','vibe_taxonomy_tree');
function vibe_taxonomy_tree(){
    $taxonomy_tree=vibe_get_option('taxonomy_tree');
    if(isset($taxonomy_tree) && $taxonomy_tree == 0){
        $vibe_advanced_listings_search=get_option('vibe_advanced_listings_search');
        if(isset($vibe_advanced_listings_search)){
            delete_option('vibe_advanced_listings_search');
        }
    }
}

/*=== Ajax for Admin ===*/
add_action( 'wp_ajax_generate_taxtree', 'generate_taxtree' );
if(!function_exists('generate_taxtree')){
    function generate_taxtree() {

        $taxonomy_tree=vibe_get_option('taxonomy_tree');
        if(isset($taxonomy_tree) && $taxonomy_tree == 0){
            echo 'Enable Taxonomy Tree Generation from Options Panel';
            die();
        }

        $slug=$_POST['tax'];
        $terms=get_terms($slug,array());
        $tax_array = array();
        foreach($terms as $term){

            
            $args = array(
                        'tax_query' => array(
                            array(
                                'taxonomy' => $slug,
                                'field' => 'slug',
                                'terms' =>  $term->slug
                            )
                        )
                    );

        $tax_query = new WP_Query($args);
        $listing_taxonomies = vibe_get_option('listing_taxonomies');

        
        while ($tax_query->have_posts()) : $tax_query->the_post();

            $post_id=get_the_ID();

            if(is_array($listing_taxonomies['search'])){


                foreach($listing_taxonomies['search'] as $key=>$value){
                    $tax_slug=$listing_taxonomies['slug'][$key];

                    if($tax_slug != $slug){

                        $tts = get_the_terms( $post_id, $tax_slug );

                        if(isset($tts) && $tts && is_array($tts)){

                            foreach($tts as $tt){
                                if(isset($tax_array[$term->slug][$tax_slug][$tt->slug])){
                                    $tax_array[$term->slug][$tax_slug][$tt->slug]++;
                                }else{
                                    $tax_array[$term->slug][$tax_slug][$tt->slug] = 1;
                                }
                            }

                        }
                    }  
                }

            }
        endwhile;
       
        }
        update_option('vibe_advanced_listings_search',$tax_array);

        echo 'Updated Listings Taxonomy Tree';

        die();
    }
}

/*=== Add Scripts in Admin Footer ===*/

/*============================================*/
/*===========  REGISTER SIDEBARS  ============*/
/*============================================*/
if(function_exists('register_sidebar'))
{   
    register_sidebar( array(
		'name' => 'MainSidebar',
		'id' => 'mainsidebar',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget_title">',
		'after_title' => '</h4>'
	) );
     register_sidebar( array(
		'name' => 'SearchSidebar',
		'id' => 'searchsidebar',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget_title">',
		'after_title' => '</h4>'
	) );
     if(isset($vibe_options['header_sidebar']) && $vibe_options['header_sidebar']){
         switch($vibe_options['header_sidebar_columns']){
             case '1' : $span = 'span12';break;
             case '2' : $span = 'span6';break;
             case '3' : $span = 'span4';break;
             case '4' : $span = 'span3';break;
             default : $span = 'span3';break;
         }
     register_sidebar( array(
		'name' => 'Header Sidebar',
		'id' => 'headersidebar',
		'before_widget' => '<div class="'.$span.'"><div class="widget">',
		'after_widget' => '</div></div>',
		'before_title' => '<h4 class="widget_title">',
		'after_title' => '</h4>'
	) );
     }
     register_sidebar( array(
		'name' => 'Footer Sidebar 1',
		'id' => 'footersidebar_1',
		'before_widget' => '
                                        <div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget_title">',
		'after_title' => '</h4>'
	) );
     register_sidebar( array(
		'name' => 'Footer Sidebar 2',
		'id' => 'footersidebar_2',
		'before_widget' => '
                                        <div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget_title">',
		'after_title' => '</h4>'
	) );
     register_sidebar( array(
		'name' => 'Footer Sidebar 3',
		'id' => 'footersidebar_3',
		'before_widget' => '
                                        <div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget_title">',
		'after_title' => '</h4>'
	) );
     register_sidebar( array(
		'name' => 'Footer Sidebar 4',
		'id' => 'footersidebar_4',
		'before_widget' => '
                                        <div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget_title">',
		'after_title' => '</h4>'
	) );
     if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
      register_sidebar( array(
		'name' => 'Shop',
		'id' => 'shop',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget_title">',
		'after_title' => '</h4>'
	) );
      register_sidebar( array(
		'name' => 'WooCommerce Cart',
		'id' => 'woocommerce-cart',
		'before_widget' => '<div class="cart_widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="cart_title">',
		'after_title' => '</h4>'
	) );
      register_sidebar( array(
		'name' => 'WooCommerce Login',
		'id' => 'woocommerce-login',
		'before_widget' => '<div class="login_widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="login_title">',
		'after_title' => '</h4>'
	) );
     }
     
     register_sidebar( array(
		'name' => 'Listings',
		'id' => 'listing',
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widget_title">',
		'after_title' => '</h4>'
	) );
     
     $vibe_options=get_option(THEME_SHORT_NAME);
    if(isset($vibe_options['sidebars']) && is_array($vibe_options['sidebars'])){ 
    foreach($vibe_options['sidebars'] as $sidebar){ 
        register_sidebar( array(
		'name' => $sidebar,
		'id' => $sidebar,
		'before_widget' => '<div class="widget"><div class="inside">',
		'after_widget' => '</div></div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>'
	) );
    }
    }
}


if ( ! function_exists( 'storegoogle_webfonts' ) ){
    function storegoogle_webfonts(){
        $google_webfonts=get_option('google_webfonts');
            if(!isset($google_webfonts) || $google_webfonts ==''){
                $url='http://api.vibethemes.com/fonts.php';       
                $fonts = wp_remote_retrieve_body( wp_remote_get($url));
                $fonts=(string)$fonts;
                add_option( 'google_webfonts', "$fonts",'', 'no');
            }
    }
}


add_action( 'admin_init', 'storegoogle_webfonts' );

function slider_defaults() {
    global $vibe_options,$script;
    $script.='var options={"slide_easing" : "'.$vibe_options['slide_easing'].'"
                    , "slide_direction" : "'.$vibe_options['slide_direction']. '", "reverse" : '.$vibe_options['reverse']. ', "animationLoop" : '.(($vibe_options['animationLoop'] == 1)? 'true' : 'false'). ', "smoothHeight" : '.(($vibe_options['smoothHeight'] == 1)? 'true' : 'false').
         ', "slideshow" : '.(($vibe_options['slideshow'] == 1)? 'true' : 'false'). ', "startAt" : '.(($vibe_options['startAt'] == 1)? 'true' : 'false'). ', "randomize" : '.(($vibe_options['randomize'] == 1)? 'true' : 'false'). ', "slideshowSpeed" : '.(($vibe_options['slideshowSpeed'] == 1)? 'true' : 'false'). ', "animationSpeed" : '.(($vibe_options['animationSpeed'] == 1)? 'true' : 'false'). ', "initDelay" : '.(($vibe_options['initDelay'] == 1)? 'true' : 'false').
         ', "pauseOnAction" : '.(($vibe_options['pauseOnAction'] == 1)? 'true' : 'false'). ', "pauseOnHover" : '.(($vibe_options['pauseOnHover'] == 1)? 'true' : 'false'). ', "useCSS" : '.(($vibe_options['useCSS'] == 1)? 'true' : 'false'). ', "touch" : '.(($vibe_options['touch'] == 1)? 'true' : 'false'). ', "controlNav" : '.(($vibe_options['controlNav'] == 1)? 'true' : 'false'). ', "directionNav" : '.(($vibe_options['directionNav'] == 1)? 'true' : 'false').
         ', "keyboard" : '.(($vibe_options['keyboard'] == 1)? 'true' : 'false'). ', "mousewheel" : '.(($vibe_options['mousewheel'] == 1)? 'true' : 'false').'};';
        
}


?>
