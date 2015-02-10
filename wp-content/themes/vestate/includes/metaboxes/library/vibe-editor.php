<?php
/**
 * FILE: vibe-layout-editor.php 
 * Created on Oct 29, 2012 at 2:22:06 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 */


add_action( 'init', 'layout_editor' );
function layout_editor(){
	add_action( 'admin_enqueue_scripts', 'v_scripts_styles', 10, 1 );
	function v_scripts_styles( $hook ) {
		if ( in_array( $hook, array( 'post-new.php', 'post.php' ) ) ){
			v_new_settings_page_js();
			v_new_settings_page_css();
		}
	}

}


add_shortcode('v_carousel', 'custom_post_carousel');
function custom_post_carousel($atts, $content = null) {
       global $vibe_options; 
       
       
        $error = new VibeErrors();
        if(!isset($atts) || !isset($atts['post_type'])){
          return $error->get_error('unsaved_editor');
        }
       
       
	$attributes = v_get_attributes( $atts, "custom_post_carousel" );
	
        if(!isset($atts['auto_slide']))
            $atts['auto_slide']='';

        if($atts['custom_css'] && strlen($atts['custom_css'])>5)    
            $output = '<style>'.$atts['custom_css'].'</style>';
        else
            $output= '';
	$output .= "<div {$attributes['class']}{$attributes['inline_styles']}>";
	if(!isset($atts['post_ids']) || count($atts['post_ids']) > 0){
        
        if(isset($atts['term']) && isset($atts['taxonomy']) && $atts['term'] !='nothing_selected'){
            
            if(isset($atts['taxonomy']) && $atts['taxonomy']!=''){ 
                    
                        $check=term_exists($atts['term'], $atts['taxonomy']);
                    if($atts['term'] !='nothing_selected'){    
                   if ($check == 0 || $check == null || !$check) {
                           $error = new VibeErrors();
                          $output .= $error->get_error('term_taxonomy_mismatch');
                          $output .='</div>';
                          return $output;
                       } 
                    }
                       $check=is_object_in_taxonomy($atts['post_type'], $atts['taxonomy']);
                   if ($check == 0 || $check == null || !$check) {
                           $error = new VibeErrors();
                           $output .= $error->get_error('term_postype_mismatch');
                           $output .='</div>';
                           return $output;
                       }
                    }
                    
            if(isset($atts['taxonomy']) && $atts['taxonomy']!=''){
                         if($atts['taxonomy'] == 'category'){
                             $atts['taxonomy']='category_name'; 
                             }
                          if($atts['taxonomy'] == 'tag'){
                             $atts['taxonomy']='tag_name'; 
                             }   
                     }
                     
          $query_args=array( 'post_type' => $atts['post_type'],$atts['taxonomy'] => $atts['term'], 'posts_per_page' => $atts['carousel_number']);
          
        }else
           $query_args=array('post_type'=>$atts['post_type'], 'posts_per_page' => $atts['carousel_number']);
        
        $the_query = new WP_Query($query_args);
        }else{
                $cus_posts_ids=explode(",",$atts['post_ids']);
        	$query_args=array( 'post_type' => $atts['post_type'], 'post__in' => $cus_posts_ids , 'orderby' => 'post__in'); 
        	$the_query = new WP_Query($query_args);
        }
        
        
        if(isset($atts['title']) && $atts['title'] && $atts['title'] != 'Content'){
            $ntitle= $atts['title'];
            $ntitle = preg_replace('/[^a-zA-Z0-9\']/', '_', $ntitle);
            $ntitle = str_replace("'", '', $ntitle);
            $output .='<div id="'.$ntitle.'"></div>';
        }
        
        $more= '';
        if(isset($atts['show_more']) && $atts['show_more']) {
            $more = ' <a href="'.$atts['more_link'].'" class="heading_more">+</a>';
        }
        $noheading='';
        
        if($atts['show_title'])
            $output .='<h3 class="heading"><span>'.$atts['title'].'</span></h3>'.$more;
        else
            $noheading='noheading';
        
        global $script;
        $rand='carousel'.rand(1,999);
    
        $script .= '; var op'.$rand.' = {
           "controlNav" : false,
           "directionNav" : '.(($atts['show_controls'])? 'true':'false').',
           "animationLoop" : '.((isset($atts['auto_slide']) && $atts['auto_slide'])? 'true':'false').',
           "slideshow" : '.((isset($atts['auto_slide']) && $atts['auto_slide'])? 'true':'false').'
        };';

        $class='slides';
        
        $output .= '<div id="'.$rand.'" class="vibe_carousel carousel_columns'.$atts['carousel_columns'].' flexslider loading '.$noheading.' '.((isset($atts['show_more']) && $atts['show_more'])?'more_heading':'').'">
  	            <ul class="'.$class.'">';
  	 $links='';
         $excerpt='';
         $thumb='';
         
         
        if( $the_query->have_posts() ) {
          
        while ( $the_query->have_posts() ) : $the_query->the_post();
        global $post;
        $output .= '<li>';
    $output .= thumbnail_generator($post,$atts['featured_style'],$atts['carousel_columns'],$atts['carousel_excerpt_length'],$atts['carousel_link'],$atts['carousel_lightbox']);
        $output .= '</li>';
        endwhile;
        }else{
          $error = new VibeErrors();
          $output .= $error->get_error('no_posts');
        }
        wp_reset_postdata();
        $output .= "</ul></div></div>";

	return $output;
}


add_shortcode('v_filterable', 'custom_post_filterable');
function custom_post_filterable($atts, $content = null) {
        global $vibe_options;
        
        $error = new VibeErrors();
        if(!isset($atts) || !isset($atts['post_type'])){
          return $error->get_error('unsaved_editor');
        }
       
        
        if(!isset($vibe_options['default_hover']))$vibe_options['default_hover']='hover_fade_in';
	$attributes = v_get_attributes( $atts, "custom_post_filterable" );
        
        if($atts['custom_css'] && strlen($atts['custom_css'])>5)    
            $output = '<style>'.$atts['custom_css'].'</style>';
        else
            $output= '';
	$output .= "<div {$attributes['class']}{$attributes['inline_styles']}>";
	
        if(isset($atts['title']) && $atts['title'] && $atts['title'] != 'Content'){
            $ntitle= $atts['title'];
            $ntitle = preg_replace('/[^a-zA-Z0-9\']/', '_', $ntitle);
            $ntitle = str_replace("'", '', $ntitle);
            $output .='<div id="'.$ntitle.'"></div>';
        }
         
         if(isset($atts['taxonomy']) && $atts['taxonomy']!=''){ 
                       $check=is_object_in_taxonomy($atts['post_type'], $atts['taxonomy']);
                   if ($check == 0 || $check == null || !$check) {
                           $error = new VibeErrors();
                           $output .= $error->get_error('term_postype_mismatch');
                           $output .='</div>';
                           return $output;
                       }
                    }
         
         if($atts['column_width'] < 311)
             $cols = 'small';
         
         if(($atts['column_width'] >= 311) && ($atts['column_width'] < 460))    
             $cols='medium';
         
         if(($atts['column_width'] >= 460) && ($atts['column_width'] < 769))    
             $cols='big';
         
         if($atts['column_width'] >= 769)    
             $cols='full';
         
        global $paged,$wp_query;
          
        $temp_query = $wp_query;
        
        $wp_query = null;
        $query_args=array('post_type'=>$atts['post_type'], 'posts_per_page' => intval($atts['filterable_number']));
        
        if($atts['show_pagination']) 
        $query_args['paged']=$paged;  
        
        
        query_posts($query_args);
        
        if($atts['show_title'])
        $output .='<h3 class="heading"><span>'.$atts['title'].'</span></h3>';
        
        $output .= '<div class="filterable_columns">
  			 	  <ul class="vibe_filterable">';
        if($atts['show_all'])                
        $output .='<li class="active"><a href="javascript:void();" data-filter="*" class="all">'.__('All','vibe').'</a></li>';
        
        
        while ( have_posts() ) : the_post();
        global $post;
        $cats=get_the_terms($post->ID,$atts['taxonomy']);
        if(isset($cats) && count($cats) > 0)
        foreach($cats as $cat){
        $categories[$post->ID][]=$cat->slug;
        $all_categories[$cat->slug]=$cat->name;
        }
        endwhile;
  	    wp_reset_query();
  	
        $all_categories=  array_unique($all_categories);
        foreach($all_categories as $slug=>$name){
            $output .='<li><a href="javascript:void();" data-filter=".'.$slug.'">'.$name.'</a></li>';
        }
        $output .='</ul><div class="filterableitems_container">';
        
        
         $query_args=array('post_type'=>$atts['post_type'], 'posts_per_page' => intval($atts['filterable_number']));
         
         if($atts['show_pagination'])
         $query_args['paged']=$paged;  
            
            $wp_query = null;
            query_posts($query_args);
            while ( have_posts() ) : the_post();
            global $post;
                if(isset($categories[$post->ID]))
                foreach($categories[$post->ID] as $cat)
                $classes = $cat.' ';
              
                $output .='<div class="filteritem '.$classes.'" style="max-width:'.$atts['column_width'].'px;width:100%;">'; 
                $output .= thumbnail_generator($post,$atts['featured_style'],$cols,$atts['filterable_excerpt_length'],$atts['filterable_link'],$atts['filterable_lightbox']);
                 $output .='</div>';
            endwhile;
           
            $output .='</div>';
             if($atts['show_pagination']) {
                    ob_start(); 
                    pagination();
                    $output .= ob_get_contents();
                    ob_end_clean();
                }
            $output .='</div>';
            
            $output .='</div>';
           wp_reset_query();
            $wp_query = $temp_query;
       
	return $output;
}


/*==== FlexSlider ====*/

add_shortcode('v_slider', 'custom_slider');
function custom_slider($atts, $content) {
       extract(shortcode_atts(array(
				'title' => '',
                                'slide_style' =>'slide1',
                                'animation' => "fade",
                                'auto_slide' => 1,
                                'loop' => 1,
                                'randomize' => 1,
                                'show_directionnav'=>1,
                                'show_controlnav' => 1,
                                'animation_duration' => 700,
                                'auto_speed' => 7000,
                                'pause_on_hover' =>1 ,
                                'css_class' => '',
                                'custom_css' => '',
                                'container_css' => ''
			), $atts));
       if($atts['custom_css'] && strlen($atts['custom_css'])>5)    
            $output = '<style>'.$atts['custom_css'].'</style>';
        else
            $output= '';
       global $vibe_post_script;
       $title = preg_replace('/[^a-zA-Z0-9\']/', '_', $title);
       $title = str_replace("'", '', $title).rand(1,999);;
       $vibe_post_script .= 'jQuery("#'.$title.'").flexslider({
           animation:"'.$animation.'",
           animationLoop:'.(($loop)?'true':'false').',
           smoothHeight: true,
           slideshow:'.(($auto_slide)?'true':'false').',
           slideshowSpeed:'.$auto_speed.',
           animationSpeed:'.$animation_duration.',
           randomize : '.(($randomize)? 'true':'false').',
           directionNav: '.(($show_directionnav)? 'true':'false').',
           controlNav: '.(($show_controlnav)? 'true':'false').',
           pauseOnHove: '.(($pause_on_hover)? 'true':'false').',   
           prevText: \'<i class="icon-left-open-mini"></i>\',
           nextText: \'<i class="icon-right-open-mini"></i>\'    
           });';
        $attributes = v_get_attributes( $atts, "custom_slider" );
	$output .= "<div {$attributes['class']}{$attributes['inline_styles']}>";
        if(isset($atts['title']) && $atts['title'] && $atts['title'] != 'Content'){
            $ntitle= $atts['title'];
            $ntitle = preg_replace('/[^a-zA-Z0-9\']/', '_', $ntitle);
            $ntitle = str_replace("'", '', $ntitle);
            $output .='<div id="'.$ntitle.'"></div>';
        }
        
        $output .= '<div id="'.$title.'" class="image_slider flexslider '.$slide_style.'">';
        $output .= '<ul class="slides">';
        $output .= $content;
        $output .= "</ul>";
        $output .= "</div>";
        $output .= "</div>";
       return $output;
}
add_shortcode('v_slides', 'custom_attachment');
function custom_attachment($atts, $content) {
       extract(shortcode_atts(array(
				'attachment_id' => '',
				'link' => ''
			), $atts));
       if(isset($attachment_id) && $attachment_id){
       $image = wp_get_attachment_image_src( $attachment_id, 'full' );
       $output  = '<li>';
       $output .= '<a href="'.$link.'">';
       $output .= '<img src="'.$image[0].'" />';
       $output .= '</a>';
       $output .= ($content)?'<div class="flex-caption">'.html_entity_decode($content).'</div>':'';
       $output .= '</li>';
       return $output;
       }
}


/*==== CUSTOM LISTING Slider ====*/
add_shortcode('listing_slider','custom_listing_slider');

function custom_listing_slider($atts, $content) {
    
    $args = array(
      'post_type' => 'listing',
      'meta_key'  => 'featured',
      'meta_value' => 1,
      'posts_per_page' => $atts['n']  
    );
    $the_query = new WP_Query($args);
    if( $the_query->have_posts() ) {
          
        $output ='';
        $output .='<div class="custom_listing_slider">
                    <div class="flexslider">
                        <ul class="slides">';
        while ( $the_query->have_posts() ) : $the_query->the_post();
        global $post;
        $output .='<li><a href="'.get_permalink().'">'.get_the_post_thumbnail('full').'</a></li>';
        endwhile;
        
        $output .= '        </ul>
                        </div>
                    </div>';
        
        wp_reset_postdata();
    }
    
}

/*==== NivoSlider ====*/

add_shortcode('v_nivoslider', 'v_nivoslider');
function v_nivoslider($atts, $content) {
       extract(shortcode_atts(array(
				'title' => '',
                                'slide_style' =>'slide1',
                                'effect' => "random",
                                'manualAdvance' => 1,
                                'randomStart' => 0,
                                'directionNav'=>0,
                                'controlNav' => 0,
                                'animSpeed' => 700,
                                'pauseTime' => 7000,
                                'pauseOnHover' =>1 ,
                                'slices' =>15 ,
                                'boxCols' =>8 ,
                                'boxRows' =>4 ,
                                'css_class' => '',
                                'custom_css' => '',
                                'container_css' => ''
			), $atts));
       
       if($atts['custom_css'] && strlen($atts['custom_css'])>5)    
            $output = '<style>'.$atts['custom_css'].'</style>';
        else
            $output= '';
       global $vibe_post_script,$captions;
       $title = preg_replace('/[^a-zA-Z0-9\']/', '_', $title);
       $title = str_replace("'", '', $title).rand(1,999);;
       if(!$effect) $effect = 'random';
       
       $vibe_post_script .= "jQuery('#".$title."').nivoSlider({
        effect: 'random', // Specify sets like: 'fold,fade,sliceDown'
        slices: 15, // For slice animations
        boxCols: 8, // For box animations
        boxRows: 4, // For box animations
        animSpeed: 500, // Slide transition speed
        pauseTime: 3000, // How long each slide will show
        startSlide: 0, // Set starting Slide (0 index)
        directionNav: true, // Next & Prev navigation
        controlNav: true, // 1,2,3... navigation
        controlNavThumbs: false, // Use thumbnails for Control Nav
        pauseOnHover: true, // Stop animation while hovering
        manualAdvance: true, // Force manual transitions
        prevText: 'Prev', // Prev directionNav text
        nextText: 'Next', // Next directionNav text
        randomStart: false
         });";
       
       
       $vibe_post_script .= "jQuery('#".$title."').nivoSlider({
           effect: '".$effect."',
           manualAdvance: ".(($manualAdvance)?"true":"false").",
           animSpeed: ".$animSpeed.",
           pauseTime: ".$pauseTime.",
           slices: $slices,
           boxCols: $boxCols,
           boxRows: $boxRows,    
           randomStart: ".(($randomStart)? "true":"false").",
           directionNav: ".(($directionNav)? "true":"false").",
           controlNav: ".(($controlNav)? "true":"false").",
           pauseOnHover: ".(($pauseOnHover)? "true":"false")."   
           });";
       
        $attributes = v_get_attributes( $atts, "custom_slider" );
	$output .= "<div {$attributes['class']}{$attributes['inline_styles']}>";
        if(isset($atts['title']) && $atts['title'] && $atts['title'] != 'Content'){
            $ntitle= $atts['title'];
            $ntitle = preg_replace('/[^a-zA-Z0-9\']/', '_', $ntitle);
            $ntitle = str_replace("'", '', $ntitle);
            $output .='<div id="'.$ntitle.'"></div>';
        }
        $output .= '<div class="slider-wrapper theme-light '.$slide_style.'">';
        $output .= '<div id="'.$title.'" class="nivoSlider">';
        $output .= $content;
        $output .= "</div>";
        $output .= "</div>";
        $output .= "</div>";
       return $output;
}


add_shortcode('v_nivo', 'nivo_slide');
function nivo_slide($atts, $content) {
        global $captions;
       extract(shortcode_atts(array(
				'attachment_id' => '',
				'link' => ''
			), $atts));
       
       if(isset($attachment_id) && $attachment_id){
       $image = wp_get_attachment_image_src( $attachment_id, 'full' );
       $id = 'nivocaption'.rand(1,999);
       
       $output  = '<a href="'.$link.'"><img src="'.$image[0].'" alt="" title="'.$content.'" /></a>';
       return $output;
       }
}

/*==== CameraSlider ====*/

add_shortcode('v_cameraslider', 'v_cameraslider');
function v_cameraslider($atts, $content) {
       extract(shortcode_atts(array(
				'title' => '',
                                'slide_style' =>'slide1',
                                'skin' =>'camera_azure_skin',
                                'fx' => '"random"',
                                'height' => '600',
                                'allignment' => '"center"',
                                'autoAdvance' =>1,
                                'cols' => 6, 
                                'rows' => 6,
                                'thumbnails' => 1,
                                'captionentry' => 'moveFromLeft',
                                'loader' => '"pie"',
                                'navigation' =>1,
                                'pagination' =>1,
                                'transPeriod' => 600,
                                'time' => 7000,
                                'hover' => 1,
                                'css_class' => '',
                                'custom_css' => '',
                                'container_css' => ''
			), $atts));
       
       if($atts['custom_css'] && strlen($atts['custom_css'])>5)    
            $output = '<style>'.$atts['custom_css'].'</style>';
        else
            $output= '';
       global $vibe_post_script,$captions;
       
       $title = preg_replace('/[^a-zA-Z0-9\']/', '_', $title);
       $title = str_replace("'", '', $title).rand(1,999);;
       
       if(!$fx) $fx = 'random';
       
       $vibe_post_script .= "jQuery('#".$title."').camera({
                                fx: '$fx',
                                height: '".$height."px',
                                allignment: '$allignment',
                                autoAdvance:".(($autoAdvance)? 'true':'false').",   
                                cols: $cols, 
                                rows: $rows,
                                thumbnails: ".(($thumbnails)? "true":"false").",
                                loader: '$loader',
                                navigation: ".(($navigation)? "true":"false").",
                                pagination: ".(($pagination)? "true":"false").",
                                transPeriod: $transPeriod,
                                time: $time,
                                hover: ".(($hover)? "true":"false")."  
           });";
        
       global $vibe_options;
       $vibe_options['captionentry'] = $captionentry;
        $attributes = v_get_attributes( $atts, "custom_slider" );
	$output .= "<div {$attributes['class']}{$attributes['inline_styles']}>";
        if(isset($atts['title']) && $atts['title'] && $atts['title'] != 'Content'){
            $ntitle= $atts['title'];
            $ntitle = preg_replace('/[^a-zA-Z0-9\']/', '_', $ntitle);
            $ntitle = str_replace("'", '', $ntitle);
            $output .='<div id="'.$ntitle.'"></div>';
        }
        $output .= '<div id="'.$title.'" class="camera_wrap '.$skin.' '.$slide_style.'">';
        $output .= $content;
        $output .= "</div>";
        $output .= "</div>";
       return $output;
}


add_shortcode('v_camera', 'camera_slide');
function camera_slide($atts, $content) {
        global $captions;
       extract(shortcode_atts(array(
				'attachment_id' => '',
				'link' => ''
			), $atts));
       
       if(isset($attachment_id) && $attachment_id){
       $image = wp_get_attachment_image_src( $attachment_id, 'full' );
       $thumb = wp_get_attachment_image_src( $attachment_id, 'mini' );
       $output ='';
       global $vibe_options;
       $output  .='<div data-thumb="'.$thumb[0].'" data-src="'.$image[0].'">
                  '.(($content && strlen($content)>1)?'<div class="camera_caption '.$vibe_options['captionentry'].'">'.$content.'</div>':'').'
                  </div>';
       
       return $output;
       }
}

/*==== POSTLIST ====*/
add_shortcode('v_postlist', 'custom_postlist');
function custom_postlist($atts, $content = null) {
       global $vibe_options; 
       
        $error = new VibeErrors();
        if(!isset($atts) || !isset($atts['post_type'])){
          return $error->get_error('unsaved_editor');
        }
        //Capture Attributes
        $attributes = v_get_attributes( $atts, "custom_postlist" );
	
        if($atts['custom_css'] && strlen($atts['custom_css'])>5)    
            $output = '<style>'.$atts['custom_css'].'</style>';
        else
            $output= '';
        
        //Capture PostList
	$output .= "<div {$attributes['class']}{$attributes['inline_styles']}>";
	if(!isset($atts['post_ids']) || count($atts['post_ids']) > 0){
        
       
        if(isset($atts['term']) && isset($atts['taxonomy']) && $atts['term'] !='nothing_selected'){
            
            if(isset($atts['taxonomy']) && $atts['taxonomy']!=''){ 
                    
                     $check=term_exists($atts['term'], $atts['taxonomy']);
                    if($atts['term'] !='nothing_selected'){    
                   if ($check == 0 || $check == null || !$check) {
                           $error = new VibeErrors();
                          $output .= $error->get_error('term_taxonomy_mismatch');
                          $output .='</div>';
                          return $output;
                       } 
                    }
                       $check=is_object_in_taxonomy($atts['post_type'], $atts['taxonomy']);
                   if ($check == 0 || $check == null || !$check) {
                           $error = new VibeErrors();
                           $output .= $error->get_error('term_postype_mismatch');
                           $output .='</div>';
                           return $output;
                       }
                    }
                    
            if(isset($atts['taxonomy']) && $atts['taxonomy']!=''){
                         if($atts['taxonomy'] == 'category'){
                             $atts['taxonomy']='category_name'; 
                             }
                          if($atts['taxonomy'] == 'tag'){
                             $atts['taxonomy']='tag_name'; 
                             }   
                     }
           
                     
          $query_args=array( 'post_type' => $atts['post_type'],$atts['taxonomy'] => $atts['term'], 'posts_per_page' => $atts['postlist_number']);
          
        }else
           $query_args=array('post_type'=>$atts['post_type'], 'posts_per_page' => $atts['postlist_number']);
        
            $the_query = new WP_Query($query_args);
        }else{
                $cus_posts_ids=explode(",",$atts['post_ids']);
        	$query_args=array( 'post_type' => $atts['post_type'], 'post__in' => $cus_posts_ids ); 
        	$the_query = new WP_Query($query_args);
        }
        
        $max_pages=$the_query->max_num_pages;
        
         if(isset($atts['title']) && $atts['title'] && $atts['title'] != 'Content'){
            $ntitle= $atts['title'];
            $ntitle = preg_replace('/[^a-zA-Z0-9\']/', '_', $ntitle);
            $ntitle = str_replace("'", '', $ntitle);
            $output .='<div id="'.$ntitle.'"></div>';
        }
        
        if($atts['show_title'])
        $output .='<h3 class="heading"><span>'.$atts['title'].'</span></h3>';
        global $script;
        $rand='carousel'.rand(1,999);
    
        
        $output .= '<div id="'.$rand.'" class="postlist_'.$atts['postlist_number'].'">
  	            <ul class="postlist">';
  	
        
        
        if( $the_query->have_posts() ) {
          
        while ( $the_query->have_posts() ) : $the_query->the_post();
        global $post;
        $output .= '<li>';
        $output .= thumbnail_generator($post,$atts['postlist_style'],6,$atts['postlist_excerpt_length'],$atts['postlist_link'],$atts['postlist_lightbox']);
        $output .= '</li>';
        endwhile;
        }else{
          $error = new VibeErrors();
          $output .= $error->get_error('no_posts');
        }
        wp_reset_postdata();
        
        $output .= "</ul>";
        
        $output .= "</div>";
        $output .= '<div class="postlist_pagination">';
        $output .= '<a class="pagination_previous"><i class="icon-left-open-mini"></i></a>';
        $output .= "<input type='hidden' class='pagination query' value='".  serialize($query_args)."' />";
        $output .= '<input type="hidden" class="pagination max_pages" value="'.$max_pages.'" />';
        $output .= '<input type="hidden" class="pagination cur_page" value="1" />';
        $output .= '<input type="hidden" class="pagination postlist_style" value="'.$atts['postlist_style'].'" />';
        $output .= '<input type="hidden" class="pagination postlist_excerpt_length" value="'.$atts['postlist_excerpt_length'].'" />';
        $output .= '<input type="hidden" class="pagination postlist_link" value="'.$atts['postlist_link'].'" />';
        $output .= '<input type="hidden" class="pagination postlist_lightbox" value="'.$atts['postlist_lightbox'].'" />';
        $output .= '<a class="pagination_next"><i class="icon-right-open-mini"></i></a>';
        $output .= "</div>";
         if(isset($atts['postlist_url']) && $atts['postlist_url'] !='')
        $output .= '<a href="'.$atts['postlist_url'].'" class="view_all">'.__('All','vibe').'</a>';
             
         $output .= "</div>";

	return $output;
}

add_shortcode('v_grid', 'vibe_post_grid');
function vibe_post_grid($atts, $content = null) {
       global $vibe_options; 
       
       
        $error = new VibeErrors();
        if(!isset($atts) || !isset($atts['post_type'])){
          return $error->get_error('unsaved_editor');
        }
       
       
	$attributes = v_get_attributes( $atts, "vibe_post_grid" );
	
        if(isset($atts['masonry']) && $atts['masonry']){
            $atts['custom_css'] .= '.grid.masonry li .block { margin-bottom:'.(isset($atts['gutter'])?$atts['gutter']:'30').'px;}';
        }  
        
        if($atts['custom_css'] && strlen($atts['custom_css'])>5)    
            $output = '<style>'.$atts['custom_css'].'</style>';
        else
            $output= '';
        
	$output .= "<div {$attributes['class']}{$attributes['inline_styles']}>";
        
	if(!isset($atts['post_ids']) || count($atts['post_ids']) > 0){
        
        if(isset($atts['term']) && isset($atts['taxonomy']) && $atts['term'] !='nothing_selected'){
            
            if(isset($atts['taxonomy']) && $atts['taxonomy']!=''){ 
                    
                        $check=term_exists($atts['term'], $atts['taxonomy']);
                    if($atts['term'] !='nothing_selected'){    
                   if ($check == 0 || $check == null || !$check) {
                           $error = new VibeErrors();
                          $output .= $error->get_error('term_taxonomy_mismatch');
                          $output .='</div>';
                          return $output;
                       } 
                    }
                       $check=is_object_in_taxonomy($atts['post_type'], $atts['taxonomy']);
                   if ($check == 0 || $check == null || !$check) {
                           $error = new VibeErrors();
                           $output .= $error->get_error('term_postype_mismatch');
                           $output .='</div>';
                           return $output;
                       }
                    }
            if($atts['column_width'] < 311)
             $cols = 'small';
         
         if(($atts['column_width'] >= 311) && ($atts['column_width'] < 460))    
             $cols='medium';
         
         if(($atts['column_width'] >= 460) && ($atts['column_width'] < 769))    
             $cols='big';
         
         if($atts['column_width'] >= 769)    
             $cols='full';
         
            if(isset($atts['taxonomy']) && $atts['taxonomy']!=''){
                         if($atts['taxonomy'] == 'category'){
                             $atts['taxonomy']='category_name'; 
                             }
                          if($atts['taxonomy'] == 'tag'){
                             $atts['taxonomy']='tag_name'; 
                             }   
                     }
           
                             
          $query_args=array( 'post_type' => $atts['post_type'],$atts['taxonomy'] => $atts['term'], 'posts_per_page' => $atts['grid_number']);
          
        }else
           $query_args=array('post_type'=>$atts['post_type'], 'posts_per_page' => $atts['grid_number']);
        
        
        }else{
                $cus_posts_ids=explode(",",$atts['post_ids']);
        	$query_args=array( 'post_type' => $atts['post_type'], 'post__in' => $cus_posts_ids ); 
        }
        global $paged;
        if(isset($atts['pagination']) && $atts['pagination']){
                  
                  $query_args['paged']=$paged;       
               }
        $istyle='';       
        query_posts($query_args);
        $masonry=$style=$rel='';
        if(isset($atts['masonry']) && $atts['masonry']){
            $atts['grid_columns'] =' grid-item';
            $style= 'style="width:'.$atts['column_width'].'px;"'; 
            $masonry= 'masonry';
            $istyle .= ' data-width="'.$atts['column_width'].'" data-gutter="'.(isset($atts['gutter'])?$atts['gutter']:'30').'"';// Rel-width used in Masonry+infinite scroll
        }
        $infinite='';
        if(isset($atts['infinite']) && $atts['infinite']){
            $infinite=' inifnite_scroll';
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $rel = 'data-page='.$paged;
        }
        
        if(isset($atts['title']) && $atts['title'] && $atts['title'] != 'Content'){
            $ntitle= $atts['title'];
            $ntitle = preg_replace('/[^a-zA-Z0-9\']/', '_', $ntitle);
            $ntitle = str_replace("'", '', $ntitle);
            $output .='<div id="'.$ntitle.'"></div>';
        }
        
        global $wp_query;
        if($atts['show_title']){
        $output .='<h3 class="heading"><span>'.$atts['title'].'</span></h3>'; 
        }
        $output .= '<div class="vibe_grid '.$infinite.' '.$masonry.'" '.$rel.'><div class="wp_query_args" data-max-pages="'.$wp_query->max_num_pages.'">'.  json_encode($atts).'</div>';
  	
        if( have_posts() ) {
        
        $output .= '<ul class="grid '.$masonry.'" '.$istyle.'>';
        
        while ( have_posts() ) : the_post();
        global $post;
        
        
        $output .= '<li class="'.$atts['grid_columns'].'" '.$style.'>';
        $output .= thumbnail_generator($post,$atts['featured_style'],$atts['grid_columns'],$atts['grid_excerpt_length'],$atts['grid_link'],$atts['grid_lightbox']);
        $output .= '</li>';
        
        endwhile;
       
        $output .= '</ul>';
        }else{
          $error = new VibeErrors();
          $output .= $error->get_error('no_posts');
        }
        wp_reset_postdata();
        $output .= '</div>';
        
        if(isset($atts['infinite']) && $atts['infinite']){
            $output .= '<div class="load_grid"><span>'.__('Loading..','vibe').'</i></span></div>
                        <div class="end_grid"><span>'.__('No more to load','vibe').'</i></span></div>';
        }
        $output .="</div>";
        if(isset($atts['pagination']) && $atts['pagination']){
        ob_start();
        pagination();
        $output .=ob_get_contents();
        ob_end_clean();
        }
        wp_reset_query();
        wp_reset_postdata();
	return $output;
}


add_shortcode('v_layerslider', 'vibe_layerslider');
function vibe_layerslider($atts, $content = null) {
       if($atts['custom_css'] && strlen($atts['custom_css'])>5)    
            $output = '<style>'.$atts['custom_css'].'</style>';
        else
            $output= '';
       $attributes = v_get_attributes( $atts, "custom_post_carousel" );
       $output .= "<div {$attributes['class']}{$attributes['inline_styles']}>";

        if(isset($atts['title']) && $atts['title'] && $atts['title'] != 'Content'){
            $ntitle= $atts['title'];
            $ntitle = preg_replace('/[^a-zA-Z0-9\']/', '_', $ntitle);
            $ntitle = str_replace("'", '', $ntitle);
            $output .='<div id="'.$ntitle.'"></div>';
        }
        
       $output .=do_shortcode('[layerslider id="'.$atts['id'].'"]');
       
       $output .= '</div>';
	return $output;
}

add_shortcode('v_revslider', 'vibe_revslider');
function vibe_revslider($atts, $content = null) {
       if($atts['custom_css'] && strlen($atts['custom_css'])>5)    
            $output = '<style>'.$atts['custom_css'].'</style>';
        else
            $output= '';
       $attributes = v_get_attributes( $atts, "custom_post_carousel" );
       $output .= "<div {$attributes['class']}{$attributes['inline_styles']}>";
       
        if(isset($atts['title']) && $atts['title'] && $atts['title'] != 'Content'){
            $ntitle= $atts['title'];
            $ntitle = preg_replace('/[^a-zA-Z0-9\']/', '_', $ntitle);
            $ntitle = str_replace("'", '', $ntitle);
            $output .='<div id="'.$ntitle.'"></div>';
        }
        
       $output .=do_shortcode('[rev_slider '.$atts['alias'].']');

       $output .= '</div>';
	return $output;
}






function new_column( $atts, $content = null, $name = '' ){
    global $post;
    $content_span='';
    
    $post_layout = get_post_custom_values('vibe_sidebar_layout',$post->ID);
    $content_span = $post_layout[0];
    
    switch($name){
        case 'v_1_2':{
                            if($content_span == 'full')
                                    $name='span6';
                            else
                                    $name='span4';
        break;}
        case 'v_1_3':{
                            if($content_span == 'full')
                                    $name='span4';
                            else
                                    $name='span83';
        break;}
        case 'v_1_4':{
                            if($content_span == 'full')
                                    $name='span3';
                            else
                                    $name='span2';
        break;}
        case 'v_2_3':{
                            if($content_span == 'full')
                                    $name='span8';
                            else
                                    $name='span823';
        break;}
        case 'v_3_4':{ 
                            if($content_span == 'full')
                                    $name='span9';
                            else
                                    $name='span6';
        break;}
        case 'v_resizable':{ 
                            if($content_span == 'full')
                            $name='fullwidth';
                            else
                                    $name='span8';
        break;}
        case 'v_stripe':{ 
                            $name='stripe';
        break;}
        case 'v_stripe_container':{ 
                            $name='stripe_container';
        break;}
    }
        if($name != 'stripe' && $name != 'stripe_container'){
	$attributes = v_get_attributes( $atts, "v_column {$name}" );	
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. do_shortcode( v_fix_shortcodes($content) ) .
				"</div> <!-- end .v_column_{$name} -->";
        }elseif( $name == 'stripe'){
            $name .=' fullwidth';
            $attributes = v_get_attributes( $atts, "v_column {$name}" );	
            $output = 	"</div></div></div>
                          </div></div>
                          </section>
                          <section class='stripe'>
                              <!-- Begin Stripe {$name} -->
                                    <div {$attributes['class']}{$attributes['inline_styles']}>"
					. do_shortcode( v_fix_shortcodes($content) ) .
                                    "</div> 
                                <!-- End Stripe{$name} -->
                          </section>          
                            <section class='main'>
                                <div class='container'>
                                    <div class='row'>
                                        <div class='span12'>
                                            <div class='postcontent full-width'>
                                                <div class='vibe_editor clearfix'>";
        }else{
            $name .=' fullwidth';
            $attributes = v_get_attributes( $atts, "v_column {$name}" );	
            $output = 	"</div></div></div>
                          </div></div>
                          </section>
                          <section class='stripe'>
                            <div class='container'>
                                <div class='row'>
                                   <div class='span12'>
                                    <!-- Begin Stripe {$name} -->
                                    <div {$attributes['class']}{$attributes['inline_styles']}>"
					. do_shortcode( v_fix_shortcodes($content) ) .
                                    "</div> 
                                    <!-- End Stripe{$name} -->
                                </div>
                               </div>     
                             </div>
                          </section>          
                            <section class='main nextstripe'>
                                <div class='container'>
                                    <div class='row'>
                                        <div class='span12'>
                                            <div class='postcontent full-width'>
                                                <div class='vibe_editor clearfix'>";
        }
	return $output;
}

// dialog box columns
function new_alt_column( $atts, $content = null, $name = '' ){
	$name = str_replace( 'alt_', '', $name );
	$attributes = v_get_attributes( $atts, "v_column {$name}" );
		
	$output = 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. do_shortcode( v_fix_shortcodes($content) ) .
				"</div> <!-- end .v_column_{$name} -->";

	return $output;
}

add_shortcode('v_text_block', 'vibe_text_block');
function vibe_text_block($atts, $content = null) {
        
	$attributes = v_get_attributes( $atts, "v_text_block" );
	if(isset($atts['custom_css'] ) && $atts['custom_css'] && strlen($atts['custom_css'])>5)    
            $output = '<style>'.$atts['custom_css'].'</style>';
        else
            $output= '';  	
	$output .= 	"<div {$attributes['class']}{$attributes['inline_styles']}>";
        
        if(isset($atts['title']) && $atts['title'] && $atts['title'] != 'Content'){
        $ntitle= $atts['title'];
        $ntitle = preg_replace('/[^a-zA-Z0-9\']/', '_', $ntitle);
        $ntitle = str_replace("'", '', $ntitle);
        $output .='<div id="'.$ntitle.'"></div>';
        }
        
	$output .= do_shortcode( v_fix_shortcodes($content) ) .
				"</div>";

	return $output;
}


add_shortcode('v_parallax_block', 'vibe_parallax_block');
function vibe_parallax_block($atts, $content = null) {
	$attributes = v_get_attributes( $atts, "v_parallax_block" );
        $rand ='paralax'.rand(1,999);
	$output = '<style>#'.$rand.' {
            background: url('.$atts['bg_image'].') 50% -50px;
            position:relative;
            height: '.$atts['height'].'px;
            } '.$atts['custom_css'].'</style>'; 
        
        $scroll = ($atts['scroll'])?$atts['scroll']:2;
        $rev = ($atts['rev'])?$atts['rev']:'0';
	
	$output .= 	"<div id='$rand' data-rev={$rev} data-scroll={$scroll} {$attributes['class']}{$attributes['inline_styles']} >
                            <div class='parallax_content'>";
        
	if(isset($atts['title']) && $atts['title'] && $atts['title'] != 'Content'){
        $ntitle= $atts['title'];
        $ntitle = preg_replace('/[^a-zA-Z0-9\']/', '_', $ntitle);
        $ntitle = str_replace("'", '', $ntitle);
        $output .='<div id="'.$ntitle.'"></div>';
        }
        
	$output .= do_shortcode( v_fix_shortcodes($content) ) .
				"</div></div>";

	return $output;
}

add_shortcode('v_widget_area', 'new_widget_area');
function new_widget_area($atts, $content = null) {
	extract(shortcode_atts(array(
				'area' => 'mainsidebar'
			), $atts));
			
	$attributes = v_get_attributes( $atts, "vibe_sidebar" );
	
	ob_start();
	dynamic_sidebar($area);
	$widgets = ob_get_contents();
	ob_end_clean();
	if($atts['custom_css'] && strlen($atts['custom_css'])>5)    
            $output = '<style>'.$atts['custom_css'].'</style>';
        else
            $output= '';
	$output .= 	"<div {$attributes['class']}{$attributes['inline_styles']}>"
					. $widgets .
				"</div> <!-- end sidebar -->";

	return $output;
}


	function new_load_convertible_scripts( $scripts_to_load ){
		
	}

	function v_new_settings_page_css(){
		wp_enqueue_style( 'v_admin_css', VIBE_URL . '/includes/metaboxes/library/css/v_admin.css' );
                wp_enqueue_style( 'v_chosen_css', VIBE_URL . '/css/chosen.css' );
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
		wp_enqueue_style( 'thickbox' );
	}

	function v_new_settings_page_js(){	
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-droppable' );
		wp_enqueue_script( 'jquery-ui-resizable' );
		
    wp_enqueue_script( 'v_chosen_js', VIBE_URL . '/js/chosen.jquery.min.js');        
		if ( floatval(get_bloginfo('version')) >= 3.9){
      wp_enqueue_script( 'v_admin_js',VIBE_URL . '/includes/metaboxes/library/js/v_admin.js' , array('jquery','jquery-ui-core','jquery-ui-sortable','jquery-ui-draggable','jquery-ui-droppable','jquery-ui-resizable'), '1.0' );
    }else{
      wp_enqueue_script( 'v_admin_js',VIBE_URL . '/includes/metaboxes/library/js/v_admin.old.js' , array('jquery','jquery-ui-core','jquery-ui-sortable','jquery-ui-draggable','jquery-ui-droppable','jquery-ui-resizable'), '1.0' );
    }
		wp_localize_script( 'v_admin_js', 'v_options', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'load_nonce' => wp_create_nonce( 'load_nonce' ), 'confirm_message' => __('Confirm Delete?', 'vibe'), 'confirm_message_yes' => __('Yes', 'vibe'), 'confirm_message_no' => __('No', 'vibe'), 'saving_text' => __('Saving...', 'vibe'), 'saved_text' => __('Saved.', 'vibe') ) );
	}

	add_action('init','v_new_modules_init');
	function v_new_modules_init(){
		global $v_modules, $v_columns, $v_sample_layouts,$wp_registered_sidebars;
		
		$v_widget_areas =$v_post_types =$v_all_taxonomies=$v_taxonomy_terms=$v_all_products=array();
                
		foreach($wp_registered_sidebars as $sidebar){
		$v_widget_areas[$sidebar['id']]=$sidebar['id'];
		};
               $v_all_posts=array();
                $post_types=get_post_types('','objects'); 
		foreach ( $post_types as $post_type ){
		    if( !in_array($post_type->name, array('attachment','revision','nav_menu_item','sliders','modals','shop','shop_order','shop_coupon','page'))){
			$v_post_types[$post_type->name]=$post_type->label;
                      // memory_get_usage();memory_get_peak_usage();
                       query_posts('post_type='.$post_type->name.'&post_per_page=-1');
                        
                        while ( have_posts() ) : the_post(); // The Loop
                            $v_all_posts[get_the_ID()] = $post_type->label.' - '.get_the_title();
                        endwhile;
                        
                        wp_reset_query();// Reset Query
                       // memory_get_usage();
                    }
                        
		}
                
                
                
                $taxonomies=get_taxonomies('','objects'); 
                    foreach ($taxonomies as $taxonomy ) {
                    if( !in_array($taxonomy, array('nav_menu','link_category','post_format')))    
                    $v_all_taxonomies[$taxonomy->name]=$taxonomy->label;
                    }
                    
                 $v_taxonomy_terms=getall_taxonomy_terms();       
                 
                 
                 //Get List of All Products
                 
                
                $v_thumb_styles = array(
                                                    ''=> VIBE_URL.'/includes/metaboxes/library/images/thumb_1.png',
                                                    'hover'=> VIBE_URL.'/includes/metaboxes/library/images/thumb_2.png',
                                                    'listing'=> VIBE_URL.'/includes/metaboxes/library/images/thumb_7.png',
                                                    'side'=> VIBE_URL.'/includes/metaboxes/library/images/thumb_3.png',
                                                    'blogpost'=> VIBE_URL.'/includes/metaboxes/library/images/thumb_6.png',
                                                    'images_only'=> VIBE_URL.'/includes/metaboxes/library/images/thumb_4.png',
                                                    'testimonial'=> VIBE_URL.'/includes/metaboxes/library/images/thumb_5.png'
                                            );
                
/* ===== Declaring the Modules =======  */                
		
		$v_modules['carousel'] = array(
			'name' => __('Carousels/Rotating Blocks', 'vibe'),
			'options' => array(
                   
                'title' => array(
                	'title' => __('Title/Heading', 'vibe'),
                	'type' => 'text',
                	'std' => __('Heading', 'vibe')
                ), 
                'show_title' => array(
					'title' => __('Show Title', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),
                'show_more' => array(
					'title' => __('Show Read More link', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(0, 'vibe')
				),            
                 'more_link' => array(
					'title' => __('More Link (User redirected to this page on click)', 'vibe'),
					'type' => 'text',
					'std' => ''
				), 
                'show_controls' => array(
					'title' => __('Show Controls', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				), 
                'post_type' => array(
					'title' => __('Select Post Type<br /><span style="font-size:11px;">(Select Post Type from Posts/Portfolio/Clients/Products ...)</span>', 'vibe'),
					'type' => 'select',
					'options' => $v_post_types,
					'std' => __('post', 'vibe')
				),
                'taxonomy' => array(
					'title' => __('Select Taxonomy (optional)<br /><span style="font-size:11px;">(A "Taxonomy" is a grouping mechanism for posts. Like Category for Posts, Tags for Posts, Portfolio Type for Portfolio etc.. <a href="http://codex.wordpress.org/Taxonomies">more</a>)</span> ', 'vibe'),
					'type' => 'select',
					'options' => $v_all_taxonomies,
					'std' => __('post', 'vibe')
				), 
		'term' => array(
					'title' => __('Select Taxonomy value (optional, only if above is selected): ', 'vibe'),
					'type' => 'select',
					'options' => $v_taxonomy_terms,
				),   
                'post_ids' => array(
					'title' => __('Or Select Specific Posts', 'vibe'),
					'type' => 'multiselect',
                                        'options' => $v_all_posts,
						),          
                'featured_style' => array(
					'title' => __('Carousel/Rotating Block Style', 'vibe'),
					'type' => 'radio_images',
					'options' => $v_thumb_styles,
					'std' => __('excerpt', 'vibe')
				),
                'auto_slide' => array(
					'title' => __('Auto slide/rotate', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),            
		'carousel_columns' => array(
					'title' => __('Number of Blocks (in one screen)', 'vibe'),
					'type' => 'select',
					'options' => array('6'=>'Six columns','5'=>'Five columns','4'=>'Four columns','3'=>'Three Columns','2'=>'Two Columns','1' => 'One Column'),
					'std' => __('4', 'vibe')
				), 
                
                'carousel_number' => array(
					'title' => __('Total Number of Blocks', 'vibe'),
					'type' => 'text',
                                        'std' => __('6', 'vibe')
				), 
		
                'carousel_excerpt_length' => array(
					'title' => __('Excerpt Length in Block (in characters)', 'vibe'),
					'type' => 'text',
					'std' => __('100', 'vibe')
				),  
                'carousel_lightbox' => array(
					'title' => __('Show Lightbox button on image hover[Opens Full image]', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),
                'carousel_link' => array(
					'title' => __('Show Link button on image hover', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				), 
                'advanced_settings' => array(
			'title' => __('Show Advanced settings', 'vibe'),
			'type' => 'divider',
                        'std' => 3
		),             
                'css_class' => array(
                         'title' => __('* Custom Class name (Add Custom Class to this Block)', 'vibe'),
                         'type' => 'text'
                           ),
                'container_css' => array(
                          'title' => __('* Class for on containing Layout column', 'vibe'),
                          'type' => 'text'
                           ),
                'custom_css' => array(
		           'title' => __('* Add Custom CSS (Use <strong>.</strong> for class name, <strong>:hover</strong> for hover styles etc..)', 'vibe'),
			   'type' => 'textarea'
		          ),             
		),
		);

                
/* ====== Filterable ===== */
                
		$v_modules['filterable'] = array(
			'name' => __('Filterable Posts', 'vibe'),
			'options' => array(
                   
                'title' => array(
                	'title' => __('Filterable Block Title', 'vibe'),
                	'type' => 'text',
                	'std' => __('Heading', 'vibe')
                ), 
                            'show_title' => array(
					'title' => __('Show Title', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				), 
                'post_type' => array(
					'title' => __('Select a Post Type', 'vibe'),
					'type' => 'select',
					'options' => $v_post_types,
					'std' => __('post', 'vibe')
				),    
                'taxonomy' => array(
					'title' => __('Select relevant Taxonomy used for Filter buttons', 'vibe'),
					'type' => 'select',
					'options' => $v_all_taxonomies,
					'std' => __('post', 'vibe')
				),
                 'featured_style' => array(
					'title' => __('Featured Media Block Style', 'vibe'),
					'type' => 'radio_images',
					'options' => $v_thumb_styles,
					'std' => __('excerpt', 'vibe')
				), 
                'show_all' => array(
					'title' => __('Show All link', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),   
                'column_width' => array(
					'title' => __('Column Width (in px)', 'vibe'),
					'type' => 'text',
					'std' => '200'
				),           
                'filterable_excerpt_length' => array(
					'title' => __('Excerpt Length (in characters)', 'vibe'),
					'type' => 'text',
					'std' => __('100', 'vibe')
				),              
                'filterable_number' => array(
					'title' => __('Total Number of blocks', 'vibe'),
					'type' => 'text',
					'std' => __('6', 'vibe')
				), 
                'show_pagination' => array(
					'title' => __('Show Pagination', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),  
                            
                'filterable_lightbox' => array(
					'title' => __('Show Lightbox [Opens Full image]', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),
                'filterable_link' => array(
					'title' => __('Show Link [Links to Post]', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				), 
                'advanced_settings' => array(
			'title' => __('Show Advanced settings', 'vibe'),
			'type' => 'divider',
                        'std' => 3
		),             
                'css_class' => array(
                         'title' => __('* Custom Class name (Add Custom Class to this Block)', 'vibe'),
                         'type' => 'text'
                           ),
                'container_css' => array(
                          'title' => __('* Class for on containing Layout column', 'vibe'),
                          'type' => 'text'
                           ),
                'custom_css' => array(
		           'title' => __('* Add Custom CSS (Use <strong>.</strong> for class name, <strong>:hover</strong> for hover styles etc..)', 'vibe'),
			   'type' => 'textarea'
		          ),            
		   ),
		);
                
/* ====== PostList ===== */
                
                $v_modules['postlist'] = array(
			'name' => __('Posts Lists', 'vibe'),
			'options' => array(
                   
                'title' => array(
                	'title' => __('PostList Title', 'vibe'),
                	'type' => 'text',
                	'std' => __('Heading', 'vibe')
                ), 
                            'show_title' => array(
					'title' => __('Show Title', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				), 
                'post_type' => array(
					'title' => __('Select a Post Type', 'vibe'),
					'type' => 'select',
					'options' => $v_post_types,
					'std' => __('post', 'vibe')
				),    
                'taxonomy' => array(
					'title' => __('Select relevant Posts via Taxonomy + Term combination', 'vibe'),
					'type' => 'select',
					'options' => $v_all_taxonomies,
					'std' => __('post', 'vibe')
				),
                 'term' => array(
					'title' => __('Select relevant Posts via Term + Taxonomy combination', 'vibe'),
					'type' => 'select',
					'options' => $v_taxonomy_terms,
				),   
                'post_ids' => array(
					'title' => __('OR Select Specific posts (Overrides Taxonomy + Term)', 'vibe'),
					'type' => 'multiselect',
                                        'options' => $v_all_posts,
						),              
                 'postlist_style' => array(
					'title' => __('PostList Style', 'vibe'),
					'type' => 'radio_images',
					'options' => $v_thumb_styles,
					'std' => __('excerpt', 'vibe')
                                        ),
                'postlist_excerpt_length' => array(
					'title' => __('Excerpt Length (in characters)', 'vibe'),
					'type' => 'text',
					'std' => __('100', 'vibe')
				),  
                 'postlist_number' => array(
					'title' => __('Number of Posts at display', 'vibe'),
					'type' => 'text',
					'std' => __('6', 'vibe')
				), 
                 'postlist_pagination' => array(
					'title' => __('Show Pagination (Ajax based)', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				), 
                 'postlist_link' => array(
					'title' => __('Show Post Link', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),
                 'postlist_lightbox' => array(
					'title' => __('Show Lightbox [Opens Full image]', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),
                  'postlist_url' => array(
					'title' => __('PostList View All link (Leave blank to hide)', 'vibe'),
					'type' => 'text',
					'std' => ''
				), 
                'advanced_settings' => array(
			'title' => __('Show Advanced settings', 'vibe'),
			'type' => 'divider',
                        'std' => 3
		),             
                'css_class' => array(
                         'title' => __('* Custom Class name (Add Custom Class to this Block)', 'vibe'),
                         'type' => 'text'
                           ),
                'container_css' => array(
                          'title' => __('* Class for on containing Layout column', 'vibe'),
                          'type' => 'text'
                           ),
                'custom_css' => array(
		           'title' => __('* Add Custom CSS (Use <strong>.</strong> for class name, <strong>:hover</strong> for hover styles etc..)', 'vibe'),
			   'type' => 'textarea'
		          ),  
			),
		);
                
                
/* ===== Grid =======  */                
		
		$v_modules['grid'] = array(
			'name' => __('Post Grid', 'vibe'),
			'options' => array(
                   
                'title' => array(
                	'title' => __('Grid Title', 'vibe'),
                	'type' => 'text',
                	'std' => __('Heading', 'vibe')
                ), 
                      'show_title' => array(
					'title' => __('Show Title', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),    
                'post_type' => array(
					'title' => __('Custom Post Type', 'vibe'),
					'type' => 'select',
					'options' => $v_post_types,
					'std' => __('post', 'vibe')
				),
                'taxonomy' => array(
					'title' => __('Select Taxonomy (optional):<br /><span style="font-size:11px;">(A "Taxonomy" is a grouping mechanism for posts. Like Category for Posts, Tags for Posts, Portfolio Type for Portfolio etc.. <a href="http://codex.wordpress.org/Taxonomies">more</a>)</span>', 'vibe'),
					'type' => 'select',
					'options' => $v_all_taxonomies,
					'std' => __('post', 'vibe')
				), 
		'term' => array(
					'title' => __('Select Taxonomy value (only req. if above is selected): ', 'vibe'),
					'type' => 'select',
					'options' => $v_taxonomy_terms,
				),   
                'post_ids' => array(
					'title' => __('Or Select Specific posts', 'vibe'),
					'type' => 'multiselect',
                                        'options' => $v_all_posts,
						),          
                'featured_style' => array(
					'title' => __('Featured Media Block Style', 'vibe'),
					'type' => 'radio_images',
					'options' => $v_thumb_styles,
					'std' => __('excerpt', 'vibe')
				), 
                'masonry' => array(
					'title' => __('Grid Masonry Layout', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(0, 'vibe')
				),             
		'grid_columns' => array(
					'title' => __('Grid Columns', 'vibe'),
					'type' => 'select',
					'options' => array('clear1 span12'=>'1 Columns in FullWidth','clear2 span6'=>'2 Columns in FullWidth','clear3 span4'=>'3 Columns in FullWidth','clear4 span3'=>'4 Columns in FullWidth','clear6 span2'=>'6 Columns in FullWidth','clear1 span8'=>'1 Columns in Left/Right Sidebar','clear2 span4'=>'2 Columns in Left/Right Sidebar','clear3 span83'=>'3 Columns in Left/Right Sidebar','clear4 span2'=>'4 Columns in Left/Right Sidebar'),
					'std' => 'clear3 span4'
				), 
                'column_width' => array(
					'title' => __('Masonry Grid Column Width(in px)', 'vibe'),
					'type' => 'text',
					'std' => '200'
				), 
                'gutter' => array(
					'title' => __('Spacing between Columns (in px)', 'vibe'),
					'type' => 'text',
					'std' => '30'
				),             
                'grid_number' => array(
					'title' => __('Total Number of Blocks in Grid', 'vibe'),
					'type' => 'text',
                                        'std' => __('6', 'vibe')
				), 
                            
		'infinite' => array(
					'title' => __('Infinite Scroll', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				), 
                 'pagination' => array(
					'title' => __('Enable Pagination (If infinite scroll is off)', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),            
                'grid_excerpt_length' => array(
					'title' => __('Excerpt Length (in characters)', 'vibe'),
					'type' => 'text',
					'std' => __('100', 'vibe')
				),  
                'grid_lightbox' => array(
					'title' => __('Show Lightbox [Opens Full image]', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),
                'grid_link' => array(
					'title' => __('Show Link', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				), 
                'advanced_settings' => array(
			'title' => __('Show Advanced settings', 'vibe'),
			'type' => 'divider',
                        'std' => 3
		),             
                'css_class' => array(
                         'title' => __('* Custom Class name (Add Custom Class to this Block)', 'vibe'),
                         'type' => 'text'
                           ),
                'container_css' => array(
                          'title' => __('* Class for on containing Layout column', 'vibe'),
                          'type' => 'text'
                           ),
                'custom_css' => array(
		           'title' => __('* Add Custom CSS (Use <strong>.</strong> for class name, <strong>:hover</strong> for hover styles etc..)', 'vibe'),
			   'type' => 'textarea'
		          ),   
			),
		);
		
                
/* ====== Editor ===== */                
		$v_modules['text_block'] = array(
			'name' => __('WP Editor', 'vibe'),
			'options' => array(
                            'title' => array(
                	'title' => __('Reference Title', 'vibe'),
                	'type' => 'text',
                	'std' => __('Content', 'vibe')
                     ), 
				'text_block_content' => array(
					'title' => __('Content', 'vibe'),
					'type' => 'wp_editor',
					'is_content' => true
				),
                        'advanced_settings' => array(
			'title' => __('Show Advanced settings', 'vibe'),
			'type' => 'divider',
                        'std' => 4
		),             
                'animation_effect' => array(
                         'title' => __('* On-Load CSS3 Animation effect on the block (<a href="http://vibethemes.com/forums/showthread.php?914-CSS3-Animation-Effects&p=2488" target="_blank">more</a>)', 'vibe'),
                         'type' => 'select',
                         'options' => animation_effects(),
                         'std' => ''
                           ),             
                'css_class' => array(
                         'title' => __('* Custom Class name (Add Custom Class to this Block)', 'vibe'),
                         'type' => 'text'
                           ),
                'container_css' => array(
                          'title' => __('* Class for on containing Layout column', 'vibe'),
                          'type' => 'text'
                           ),
                'custom_css' => array(
		           'title' => __('* Add Custom CSS (Use <strong>.</strong> for class name, <strong>:hover</strong> for hover styles etc..)', 'vibe'),
			   'type' => 'textarea'
		          ),     
			)
		);

/* ====== Parallax ===== */                
		$v_modules['parallax_block'] = array(
			'name' => __('Parallax Content', 'vibe'),
			'options' => array(
                            'title' => array(
                	'title' => __('Reference Title', 'vibe'),
                	'type' => 'text',
                	'std' => __('Parallax Title', 'vibe')
                ), 
				'text_block_content' => array(
					'title' => __('Content', 'vibe'),
					'type' => 'wp_editor',
					'is_content' => true
				),
                  'bg_image' => array(
			'title' => __('Upload Parallax Background image', 'vibe'),
			'type' => 'upload',
                        'std' => ''
                    ), 
                 'rev' => array(
					'title' => __('Background Effect', 'vibe'),
					'type' => 'select',
					'options' => array(
                                                        ''=>'Image Scrolls with scroll',
                                                        1=>'Image Static with Scroll'),
					'std' => ''
				),  
                 'height' => array(
			'title' => __('Parallax Block Height (in px)', 'vibe'),
			'type' => 'text',
                        'std' => '200'
                    ), 
                 'scroll' => array(
			'title' => __('Parallax value (Scroll senstivity, lower value means higher scroll)', 'vibe'),
			'type' => 'text',
                        'std' => '2'
                    ),           
                 'advanced_settings' => array(
			'title' => __('Show Advanced settings', 'vibe'),
			'type' => 'divider',
                        'std' => 4
                    ),       
                'animation_effect' => array(
                         'title' => __('* On-Load CSS3 Animation effect on the block (<a href="http://vibethemes.com/forums/showthread.php?914-CSS3-Animation-Effects&p=2488" target="_blank">more</a>)', 'vibe'),
                         'type' => 'select',
                         'options' => animation_effects(),
                         'std' => ''
                           ),            
                'css_class' => array(
                         'title' => __('* Custom Class name (Add Custom Class to this Block)', 'vibe'),
                         'type' => 'text'
                           ),
                'container_css' => array(
                          'title' => __('* Class for on containing Layout column', 'vibe'),
                          'type' => 'text'
                           ),
                'custom_css' => array(
		           'title' => __('* Add Custom CSS (Use <strong>.</strong> for class name, <strong>:hover</strong> for hover styles etc..)', 'vibe'),
			   'type' => 'textarea'
		          ),     
			)
		);                

                
                          
/* ====== Listing Slider ===== */
                
if(post_type_exists('listing')){      
    
		$v_modules['listing_slider'] = array(
			'name' => __('Listings Slider', 'vibe'),
			'options' => array(
                   
                'title' => array(
                	'title' => __('Slider Reference Title', 'vibe'),
                	'type' => 'text',
                	'std' => __('Heading', 'vibe')
                                 ),
                'n' => array(
                	'title' => __('Number of Featured Properties', 'vibe'),
                	'type' => 'text',
                	'std' => '3'
                          ),            
                'advanced_settings' => array(
			'title' => __('Show Advanced settings', 'vibe'),
			'type' => 'divider',
                        'std' => 3
		),             
                'css_class' => array(
                         'title' => __('* Custom Class name (Add Custom Class to this Block)', 'vibe'),
                         'type' => 'text'
                           ),
                'container_css' => array(
                          'title' => __('* Class for on containing Layout column', 'vibe'),
                          'type' => 'text'
                           ),
                'custom_css' => array(
		           'title' => __('* Add Custom CSS (Use <strong>.</strong> for class name, <strong>:hover</strong> for hover styles etc..)', 'vibe'),
			   'type' => 'textarea'
		          ),            
		   ),
		);

}
                
/* ====== RevSlider ===== */
                
                if ( in_array( 'revslider/revslider.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                    $revsliders = array();
                    // Fetch all Revolution Slider list
                    global $wpdb;
                    $table_name = $wpdb->prefix . "revslider_sliders"; 
                     $querystr = "
                            SELECT title,alias
                            FROM $table_name";

                             $rev_sliders = $wpdb->get_results($querystr, OBJECT);
                             
                             foreach($rev_sliders as $sliders){ 
                                $revsliders[$sliders->alias] = $sliders->title;
                             }
                   $v_modules['revslider'] = array(
			'name' => __('Revolution Slider', 'vibe'),
			'options' => array(
				'alias' => array(
					'title' => __('Select Slider', 'vibe'),
					'type' => 'select',
                                        'options' => $revsliders
				),  
                'advanced_settings' => array(
			'title' => __('Show Advanced settings', 'vibe'),
			'type' => 'divider',
                        'std' => 3
		),             
                'css_class' => array(
                         'title' => __('* Custom Class name (Add Custom Class to this Block)', 'vibe'),
                         'type' => 'text'
                           ),
                'container_css' => array(
                          'title' => __('* Class for on containing Layout column', 'vibe'),
                          'type' => 'text'
                           ),
                'custom_css' => array(
		           'title' => __('* Add Custom CSS (Use <strong>.</strong> for class name, <strong>:hover</strong> for hover styles etc..)', 'vibe'),
			   'type' => 'textarea'
		          ),    
			)
                    ); 
                }
                
                if ( in_array( 'LayerSlider/layerslider.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                    
                    // Fetch all Layer Slider list
                    $layersliders = array();
                    global $wpdb;
                    $table_name = $wpdb->prefix . "layerslider"; 
                     $querystr = "
                            SELECT id,name
                            FROM $table_name";
                             $layer_sliders = $wpdb->get_results($querystr, OBJECT);
                             
                             foreach($layer_sliders as $sliders){ 
                                $layersliders[$sliders->id] = $sliders->name;
                             }
                   $v_modules['layerslider'] = array(
			'name' => __('Layer Slider', 'vibe'),
			'options' => array(
				'id' => array(
					'title' => __('Select Slider', 'vibe'),
					'type' => 'select',
                                        'options' => $layersliders
				),  
                'advanced_settings' => array(
			'title' => __('Show Advanced settings', 'vibe'),
			'type' => 'divider',
                        'std' => 3
		),             
                'css_class' => array(
                         'title' => __('* Custom Class name (Add Custom Class to this Block)', 'vibe'),
                         'type' => 'text'
                           ),
                'container_css' => array(
                          'title' => __('* Class for on containing Layout column', 'vibe'),
                          'type' => 'text'
                           ),
                'custom_css' => array(
		           'title' => __('* Add Custom CSS (Use <strong>.</strong> for class name, <strong>:hover</strong> for hover styles etc..)', 'vibe'),
			   'type' => 'textarea'
		          ),    
			)
                    ); 
                }
                
                /*
               // If WOO Commerce Define Product Blocks 
                $product =  get_current_post_type();
                
                
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                    
                    $v_modules['product_info'] = array(
			'name' => __('Product Information', 'vibe'),
			'options' => array(
                                'product' => array(
					'title' => __('Current Product', 'vibe'),
                                        'type' => 'text',
                                        'std' => get_the_title()
				),
                                'style' => array(
					'title' => __('Select Product Block Style', 'vibe'),
					'type' => 'select',
					'options' => array(
                                          'plain' => 'Plain',    
                                          'minimal' => 'Minimal', 
                                          'elegant' => 'Elegant',        
                                        ),
					'std' => __('plain', 'vibe')
				),
                                'feature' => array(
					'title' => __('Select Product Block', 'vibe'),
					'type' => 'select',
					'options' => array(
                                          'Product-Title'=>'Product Title',
                                          'Product-Price' => 'Product Price',
                                          'Product-Add-to-cart-button' => 'Add to Cart Button',  
                                          'Image-Block' => 'Product Image Block',    
                                          'Product-Summary' => 'Product Summary Block', 
                                          'Product-Tabs' => 'Product Tabs Block',     
                                          'Upsell-Products' => 'Upsell Products Block',     
                                          'Related-Products' => 'Related Products Block',       
                                        ),
					'std' => __('images', 'vibe')
				),
                                'custom_css' => array(
                                        'title' => __('* Add your Custom CSS here', 'vibe'),
                                        'type' => 'textarea'
                                ),
				'css_class' => array(
					'title' => __('Additional CSS Classes', 'vibe'),
					'type' => 'text'
				)
			)
                    );
               }
                
                
                
                  */

                
                
                
                //Sidebars
		$v_modules['widget_area'] = array(
			'name' => __('Sidebar', 'vibe'),
			'options' => array(
				'area' => array(
					'title' => __('Select a Sidebar', 'vibe'),
					'type' => 'select',
					'options' => $v_widget_areas,
					'std' => __('MainSidebar', 'vibe')
				),
                'advanced_settings' => array(
			'title' => __('Show Advanced settings', 'vibe'),
			'type' => 'divider',
                        'std' => 3
		),             
                'css_class' => array(
                         'title' => __('* Custom Class name (Add Custom Class to this Block)', 'vibe'),
                         'type' => 'text'
                           ),
                'container_css' => array(
                          'title' => __('* Class for on containing Layout column', 'vibe'),
                          'type' => 'text'
                           ),
                'custom_css' => array(
		           'title' => __('* Add Custom CSS (Use <strong>.</strong> for class name, <strong>:hover</strong> for hover styles etc..)', 'vibe'),
			   'type' => 'textarea'
		          ),   
			)
		);
		
		
		$v_modules['slider'] = array(
			'name' => __('FlexSlider', 'vibe'),
			'options' => array(
                                'title' => array(
					'title' => __('Slider ID (for reference & Css)', 'vibe'),
					'type' => 'text',
                                        'std' => 'FlexSlider'
				),
                                'slide_style' => array(
                                    
                                    'title' => __('Slide Style', 'vibe'),
				    'type' => 'radio_images',
                                    'options'=>array(
                                                    'slide1'=> VIBE_URL.'/includes/metaboxes/library/images/slider_1.png',
                                                    'slide2'=> VIBE_URL.'/includes/metaboxes/library/images/slider_2.png',
                                                    'slide3'=> VIBE_URL.'/includes/metaboxes/library/images/slider_3.png',
                                                    'slide4'=> VIBE_URL.'/includes/metaboxes/library/images/slider_4.png',
                                                    'slide5'=> VIBE_URL.'/includes/metaboxes/library/images/slider_5.png',
                                            ),
                                    'std' => 'slide1'
                                ),
                                'animation' => array(
					'title' => __('Animation Effect', 'vibe'),
					'type' => 'select',
					'options' => array( __('fade', 'vibe'), __('slide', 'vibe') ),
					'std' => __('fade', 'vibe')
				),
                                
                                'slider_settings' => array(
                                    'title' => __('Slider settings', 'vibe'),
                                    'type' => 'divider',
                                    'std' => 12
                                        ),
				'auto_slide' => array(
					'title' => __('Auto slide Images', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),
                                'loop' => array(
					'title' => __('Loop Slides', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),
                                'randomize' => array(
					'title' => __('Randomize Slides', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),
                                'show_directionnav' => array(
					'title' => __('Show Slider Direction arrows', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),
                                'show_controlnav' => array(
					'title' => __('Show Slider Control buttons', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),
				'animation_duration' => array(
					'title' => __('Animation Duration (in ms)', 'vibe'),
					'type' => 'text',
					'std' => '600'
				),
				
				'auto_speed' => array(
					'title' => __('Auto Animation Speed (in ms)', 'vibe'),
					'type' => 'text',
					'std' => '7000'
				),
				'pause_on_hover' => array(
					'title' => __('Pause Slider On Hover', 'vibe'),
					'type' => 'select_yesno',
					'options' => array(0=>'No',1=>'Yes'),
					'std' => __(1, 'vibe')
				),
                                
                            'css_class' => array(
                                'title' => __('* Custom Class name (Add Custom Class to this Block)', 'vibe'),
                                'type' => 'text'
                           ),
                            'container_css' => array(
                            'title' => __('* Class for on containing Layout column', 'vibe'),
                            'type' => 'text'
                           ),
                            'custom_css' => array(
                                'title' => __('* Add Custom CSS (Use <strong>.</strong> for class name, <strong>:hover</strong> for hover styles etc..)', 'vibe'),
                                'type' => 'textarea'
		          ), 
                                
				'images' => array(
					'type' => 'slider_images',
                                        'std' => 'slides'
				),
                                'advanced_settings' => array(
                                    'title' => '',
                                    'type' => '',
                                        ),             
                               
			)
		);
                
		$v_modules = apply_filters( 'v_modules', $v_modules );
		
		$v_columns['1_2'] = array( 'name' => __('1/2 Column', 'vibe') );
		$v_columns['1_3'] = array( 'name' => __('1/3 Column', 'vibe') );
		$v_columns['1_4'] = array( 'name' => __('1/4 Column', 'vibe') );
		$v_columns['2_3'] = array( 'name' => __('2/3 Column', 'vibe') );
		$v_columns['3_4'] = array( 'name' => __('3/4 Column', 'vibe') );
		$v_columns['resizable'] = array( 'name' => __('Full-Width Resizable Column', 'vibe') );
		$v_columns['stripe_container'] = array( 'name' => __('FullScreen Stripe with Container', 'vibe') );
                $v_columns['stripe'] = array( 'name' => __('FullScreen Stripe', 'vibe') );
                
		$v_columns = apply_filters( 'v_columns', $v_columns );
		$v_sample_layouts='';
		$v_sample_layouts = get_option('vibe_builder_sample_layouts');
                if(is_string($v_sample_layouts))
                    $v_sample_layouts = unserialize($v_sample_layouts);
                
		foreach( $v_columns as $v_column_key => $v_column ){
			add_shortcode("v_{$v_column_key}", 'new_column');
			add_shortcode("v_alt_{$v_column_key}", 'new_alt_column');
		}
		
	}

	function vibe_layout_editor(){
		global $v_modules, $v_columns, $v_sample_layouts, $post;
		$v_helper_class = '';
		$v_convertible_settings = get_post_meta( $post->ID, '_builder_settings', true );
	?>
		<?php do_action( 'before_page_builder' ); ?>
		
		<div id="page_builder">
			<div id="vibe_editor_controls" class="clearfix">
				<a href="#" class="add_element add_column"><span><?php _e('Add Layout Columns', 'vibe'); ?></span></a>
				<a href="#" class="add_element add_module"><span><?php _e('Add Content Block', 'vibe'); ?></span></a>
				<a href="#" class="add_element add_sample_layout"><span><?php _e('Saved Layouts', 'vibe'); ?></span></a>
			</div> <!-- #vibe_editor_controls -->
			
			<div id="modules">
				<?php
					foreach ( $v_modules as $module_key => $module_settings ){
						$class = "module m_{$module_key}";
						if ( isset( $module_settings['full_width'] ) && $module_settings['full_width'] ) $class .= ' full_width';
						
						echo "<div data-placeholder='" . esc_attr( $module_settings['name'] ) . "' data-name='" . esc_attr( $module_key ) . "' class='" . esc_attr( $class ) . "'>" . '<span class="module_name">' . esc_html( $module_settings['name'] ) . '</span>' .
						'<span class="move"></span><span class="delete"></span><span class="settings_arrow"></span><div class="module_settings"></div></div>';
					}
					
					foreach ( $v_columns as $column_key => $column_settings ){
						echo "<div data-placeholder='" . esc_attr( $column_settings['name'] ) . "' data-name='" . esc_attr( $column_key ) . "' class='" . esc_attr( "module m_column m_column_{$column_key}" ) . "'>" . 
						'<span class="module_name column_name">' . esc_html( $column_settings['name'] ) . '</span>' .
						'<span class="move"></span> <span class="delete_column delete"></span></div>';
					}
					if(is_array($v_sample_layouts))
					foreach ( $v_sample_layouts as $layout_key => $layout_settings ){
						echo "<div data-placeholder='" . esc_attr( $layout_settings['name'] ) . "' data-name='" . esc_attr( $layout_key ) . "' class='" . esc_attr( "module sample_layout" ) . "'>" . 
						'<span class="module_name">' . esc_html( $layout_settings['name'] ) . '</span>' .
						'<span class="move"></span></div>';
					}
				?>
				<div id="module_separator"></div>
				<div id="active_module_settings"></div>
			</div> <!-- #modules -->
			
			<div id="layout_container">
				<div id="layout" class="clearfix">
					<?php 
						if ( is_array( $v_convertible_settings ) && $v_convertible_settings['layout_html'] ) {
							echo stripslashes( $v_convertible_settings['layout_html'] );
							$v_helper_class = ' class="hidden"';
						}
					?>
				</div> <!-- #layout -->
				<div id="v_helper"<?php echo $v_helper_class; ?>><?php esc_html_e('Drag & Drop Layout Columns and then Drag & Drop Content Blocks to each column', 'vibe'); ?></div>
			</div> <!-- #layout_container -->
			
			<div style="display: none;">
				<?php
					wp_editor( ' ', 'v_hidden_editor' );
					do_action( 'v_hidden_editor' );
				?>
			</div>
		</div> <!-- #page_builder -->
                <div class="overlay">
                                <label><?php _e('Enter name of Sample Layout','vibe'); ?></label><input type="text" class="text" id="new_sample_layout_name" name="new_sample_layout_name" data-id="<?php global $post; echo $post->ID;?>"/>
                                <a id="save_new_sample_layout" class="vibe-button-save-new-layout"><?php _e('Save Layout', 'vibe') ?></a>
                                <span class="remove"></span>
                </div>
		<div id="v_ajax_save">
			<img src="<?php echo esc_url( VIBE_URL . '/img/loading.gif' ); ?>" alt="loading" id="loading" />
			<span><?php esc_html_e( 'Saving...', 'vibe' ); ?></span>
		</div>
		
		<?php
			echo '<div id="v_save">';
                        submit_button( __('Save Changes', 'vibe'), 'vibe-button-save', 'v_main_save' );
			echo '<a id="new_sample_layout" class="vibe-button-save-new-layout" style="display:none;">'. __('Save as New Layout', 'vibe').'</a>';
			echo '</div> <!-- end #v_save -->';
	}

	add_action( 'wp_ajax_save_layout', 'new_save_layout' );
        //add_action( 'save_post',  'new_save_layout');
        
	function new_save_layout(){
		if ( ! wp_verify_nonce( $_POST['load_nonce'], 'load_nonce' ) ) die(-1);
		
		$v_convertible_settings = array();
		
		$v_convertible_settings['layout_html'] = trim( $_POST['layout_html'] );
		$v_convertible_settings['layout_shortcode'] = $_POST['layout_shortcode'];
		$v_post_id = (int) $_POST['post_id'];
		
                //print_r($v_convertible_settings);
                
		if ( get_post_meta( $v_post_id, '_builder_settings', true ) ) 
                        update_post_meta( $v_post_id, '_builder_settings', $v_convertible_settings );
		else 
                    add_post_meta( $v_post_id, '_builder_settings', $v_convertible_settings, true );
		
		die();
	}

	add_action( 'wp_ajax_append_layout', 'new_append_layout' );
	function new_append_layout(){
		global $v_sample_layouts;
		
		if ( ! wp_verify_nonce( $_POST['load_nonce'], 'load_nonce' ) ) die(-1);
		
		$layout_name = $_POST['layout_name'];
		if ( isset( $v_sample_layouts[$layout_name] ) ) echo stripslashes( $v_sample_layouts[$layout_name]['content'] );
		
		die();
	}
        
        add_action( 'wp_ajax_save_new_layout', 'save_new_layout' );
	function save_new_layout(){
		if ( ! wp_verify_nonce( $_POST['load_nonce'], 'load_nonce' ) ) die(-1);
		global $vibe_options;
                $name = stripslashes($_POST['name']);
                $postid = stripslashes($_POST['id']);
                
                $layout = get_post_meta($postid,'_builder_settings');
                
                echo $layout[0]['layout_html'];
                
                if(isset($layout[0]['layout_html'])){
                $n = count($vibe_options['sample_layouts']);
                $vibe_options['sample_layouts'][$n]=$name;   
                $value = get_option('vibe_builder_sample_layouts');
                if(isset($value)){
                    
                    if(is_string($value))
                    $value=  unserialize($value);
                    $value[]=array('name'=>$name,
                                    'content'=>$layout[0]['layout_html']);
                    
                    $value=serialize($value);
                    update_option('vibe_builder_sample_layouts',$value);
                }else{
                    $value[]=array('name'=>$name,
                                    'content'=>$layout[0]['layout_html']);
                    $value=serialize($value);
                    add_option('vibe_builder_sample_layouts',$value);
                }
                update_option('vibe_builder_sample_layouts',$value);
                }else{
                    echo 'unable to save';
                }
                die();
            }
        


	if ( ! function_exists('generate_column_options') ){
		function generate_column_options( $column_name, $paste_to_editor_id ){
			global $v_columns;
			
			$module_name = $v_columns[$column_name]['name'];
			echo '<form id="dialog_settings">'
					. '<span id="settings_title">' . esc_html( ucfirst( $module_name ) . ' ' . __('Settings', 'vibe') ) . '</span>'
					. '<a href="#" id="close_dialog_settings"></a>'
					. '<p class="clearfix"><input type="checkbox" id="dialog_first_class" name="dialog_first_class" value="" class="v_option" /> ' . esc_html__('This is the first column in the row', 'vibe') . '</p>';
			
			if ( 'resizable' == $column_name ) echo '<p class="clearfix"><label>' . esc_html__('Column width (%)', 'vibe') . ':</label> <input name="dialog_width" type="text" id="dialog_width" value="100" class="regular-text v_option" /></p>';
			
			submit_button(__('Save Changes', 'vibe'), 'vibe-button-save');
			
			echo '<input type="hidden" id="saved_module_name" value="' . esc_attr( "alt_{$column_name}" ) . '" />';
			
			if ( '' != $paste_to_editor_id ) echo '<input type="hidden" id="paste_to_editor_id" value="' . esc_attr( $paste_to_editor_id ) . '" />';
			
			echo '</form>';
		}
	}

	if ( ! function_exists('generate_module_options') ){
		function generate_module_options( $module_name, $module_window, $paste_to_editor_id, $v_module_exact_name ){
			global $v_modules;
			
			$i = 1;
			$form_id = ( 0 == $module_window ) ? 'module_settings' : 'dialog_settings';
			
			echo '<form id="' . esc_attr( $form_id ) . '">';
			echo '<span id="settings_title">' . esc_html( $v_module_exact_name . ' ' . __('Settings', 'vibe') ) . '</span>';
			
			if ( 0 == $module_window ) echo '<a href="#" id="close_module_settings"></a>';
			else echo '<a href="#" id="close_dialog_settings"></a>';
			
			foreach ( $v_modules[$module_name]['options'] as $option_slug => $option_settings ){
				$content_class = isset( $option_settings['is_content'] ) && $option_settings['is_content'] ? ' v_module_content' : '';
				
				echo '<p class="clearfix">';
				if ( isset( $option_settings['title'] ) ) echo "<label>{$option_settings['title']}</label>";
				
				if ( 1 == $module_window ) $option_slug = 'dialog_' . $option_slug;
				
				switch ( $option_settings['type'] ) {
					case 'wp_editor':
						wp_editor( '', $option_slug, array( 'editor_class' => 'v_wp_editor v_option' . $content_class ) );
						break;
					
					case 'select':
						$std = isset( $option_settings['std'] ) ? $option_settings['std'] : '';
						echo
						'<select name="' . esc_attr( $option_slug ) . '" id="' . esc_attr( $option_slug ) . '" class="chzn-select v_option' . $content_class . '">'
							. ( ( '' == $std ) ? '<option value="nothing_selected">  ' . esc_html__('Select', 'vibe') . '  </option>' : '' );
							
                                                foreach ( $option_settings['options'] as $key=>$setting_value ){ 
								echo '<option value="' . esc_attr( $key ) . '"' . selected( $key, $std, false ) . '>' . esc_html( $setting_value ) . '</option>';
							}
						echo '</select>';
						break;
                                        case 'multiselect':
						$std = isset( $option_settings['std'] ) ? $option_settings['std'] : '';
						echo
						'<select name="' . esc_attr( $option_slug ) . '" id="' . esc_attr( $option_slug ) . '" class="chzn-select v_option' . $content_class . '" multiple=multiple style="min-width:300px;" data-placeholder="Choose options...">'
							. ( ( '' == $std ) ? '<option value="nothing_selected">  ' . esc_html__('Select', 'vibe') . '  </option>' : '' );
							
                                                foreach ( $option_settings['options'] as $key=>$setting_value ){ 
                                                    $value_array=explode(',',$std);
								echo '<option value="' . esc_attr( $key ) . '"' . (in_array( $key, $value_array )?'selected="SELECTED"':'') . '>' . esc_html( $setting_value ) . '</option>';
							}
						echo '</select>';
						break;        
                                        case 'radio_images':
						$std = isset( $option_settings['std'] ) ? $option_settings['std'] : '';
						foreach ( $option_settings['options'] as $key=>$setting_value ){ 
                                                    echo '<label class="radio_images" data-value="'.$key.'"><img src="' . esc_html( $setting_value ) . '" for="' . esc_attr( $option_slug ) . '" />
                                                                      </label>';
							}
                                                echo '<input name="' . esc_attr( $option_slug ) . '" type="hidden" id="' . esc_attr( $option_slug ) . '" value="'.( '' != $std ? esc_attr( $std ) : '' ).'" class="image_value v_option' . $content_class . '" />';
						break; 
                                        case 'select_yesno':
						$std = isset( $option_settings['std'] ) ? $option_settings['std'] : '';
						echo
						'<span class="select_yesno_button"></span>
                                                    <select name="' . esc_attr( $option_slug ) . '" id="' . esc_attr( $option_slug ) . '" class="select_yesno_val v_option' . $content_class . '">'
							. ( ( '' == $std ) ? '<option value="nothing_selected">  ' . esc_html__('Select', 'vibe') . '  </option>' : '' );
							
                                                foreach ( $option_settings['options'] as $key=>$setting_value ){ 
								echo '<option value="' . esc_attr( $key ) . '"' . selected( $key, $std, false ) . '>' . esc_html( $setting_value ) . '</option>';
							}
						echo '</select>';
						break;        
					case 'text':
						$std = isset( $option_settings['std'] ) ? $option_settings['std'] : '';
						echo '<input name="' . esc_attr( $option_slug ) . '" type="text" id="' . esc_attr( $option_slug ) . '" value="'.( '' != $std ? esc_attr( $std ) : '' ).'" class="text regular-text v_option' . $content_class . '" />';
						break;
                                       case 'textarea':
						$std = isset( $option_settings['std'] ) ? $option_settings['std'] : '';
						echo '<textarea name="' . esc_attr( $option_slug ) . '" id="' . esc_attr( $option_slug ) . '"  class="textarea regular-text v_option' . $content_class . '" row="5">'.( '' != $std ? esc_attr( $std ) : '' ).'</textarea>';
						break; 
                                      case 'divider':
                                                $std = isset( $option_settings['std'] ) ? $option_settings['std'] : '';
						echo '<span class="divider" rel-hide="'.$std.'"></span><i class="toggle closed"></i>';
						break; 
                                      case 'upload':
						echo '<input name="' . esc_attr( $option_slug ) . '" type="hidden" id="' . esc_attr( $option_slug ) . '" value="" class="regular-text v_option v_upload_field' . $content_class . '" />' . '<img src="'.VIBE_URL.'/includes/metaboxes/images/image.png" class="uploaded_image" /><a href="#" rel-default="'.VIBE_URL.'/includes/metaboxes/images/image.png" class="remove_uploaded">cancel</a><a href="#" class="v_upload_button button">' . esc_html__('Upload', 'vibe') . '</a>';
						break;
					case 'slider_images':
                                                $std = isset( $option_settings['std'] ) ? $option_settings['std'] : '';
						echo '<div id="v_slider_images">' . '<div id="'.$std.'" class="slides v_option "></div>' . '<a href="#" id="v_add_slider_images" class="button button-primary button-large">' . esc_html__('Add Slider Image', 'Convertible') . '</a>' . '</div>';
						break;      
				}
				
				echo '</p>';
				
				++$i;
			}
			
			submit_button(__('Save Changes', 'vibe'), 'vibe-button-save');
			
			echo '<input type="hidden" id="saved_module_name" value="' . esc_attr( $module_name ) . '" />';
			
			if ( '' != $paste_to_editor_id ) echo '<input type="hidden" id="paste_to_editor_id" value="' . esc_attr( $paste_to_editor_id ) . '" />';
			
			echo '</form>';
		}
	}

	if ( ! function_exists('v_get_attributes') ){
		function v_get_attributes( $atts, $additional_classes = '', $additional_styles = '' ){
			extract( shortcode_atts(array(
                        'container_css'=>'',
						'css_class' => '',
						'first_class' => '0',
						'width' => ''
					), $atts));
			$attributes = array( 'class' => '', 'inline_styles' => '' );
                        
			if ( '' != $css_class ) $css_class = ' ' . $css_class;
                        if ( '' != $container_css ) $container_css = 'data-class="' . $container_css.'"';
                        
			if ( '' != $additional_classes ) $additional_classes = ' ' . $additional_classes;
			$first_class = ( '1' == $first_class ) ? ' v_first' : ' ';
            
            $animation ='';
            if(isset($atts['animation_effect']) && $atts['animation_effect']){
            $animation = 'animate '.$atts['animation_effect'].'';
            }
                        
			$attributes['class'] = ' class="' . esc_attr( "v_module{$additional_classes}{$first_class}{$css_class}{$animation}" ) . '" '.$container_css.'';
			
			if ( '' != $width ) $attributes['inline_styles'] .= " width: {$width}%;";
			$attributes['inline_styles'] .= $additional_styles;
			if ( '' != $attributes['inline_styles'] ) $attributes['inline_styles'] = ' style="' . esc_attr( $attributes['inline_styles'] ) .'"';
			
			return $attributes;
		}
	}

	if ( ! function_exists('v_fix_shortcodes') ){
		function v_fix_shortcodes($content){   
			$replace_tags_from_to = array (
				'<p>[' => '[', 
				']</p>' => ']', 
				']<br />' => ']'
			);
			return strtr( $content, $replace_tags_from_to );
		}
	}
	
add_action( 'before_page_builder', 'disable_builder_option' );
function disable_builder_option(){
	global $post;
	
	$v_builder_enable = get_post_meta( $post->ID, '_enable_builder', true );
	
	wp_nonce_field( basename( __FILE__ ), 'vibe_editor_settings_nonce' );

	echo '<p class="vibe_editor_option">'
			. '<label for="builder_disable" class="builder_enable">'
				. '<input name="builder_enable" type="checkbox" id="builder_enable" ' . checked( $v_builder_enable, 1, false ) . ' /></label>'
		. '</p>';
}

add_action( 'before_page_builder', 'add_content_option' );
function add_content_option(){
	global $post;
	
	$v_add_content = get_post_meta( $post->ID, '_add_content', true );
	
	wp_nonce_field( basename( __FILE__ ), 'vibe_editor_settings_nonce' );

	echo '<p class="vibe_editor_option content_addon">'
			. '<label for="add_content">'
				. __('Show Page Content','vibe').'<select name="add_content" id="add_content" class="chzn-select"><option value="no" '. selected($v_add_content, 'no', false).'> No</option><option value="yes_top" '. selected($v_add_content, 'yes_top', false).'> Yes, above Page Builder</option><option value="yes_below" '. selected($v_add_content, 'yes_below', false).'> Yes, Below Page Builder</option></select></label>'
		. '</p>';
}

add_action( 'save_post', 'vibe_editor_save_details', 10, 2 );
function vibe_editor_save_details( $post_id, $post ){
	global $pagenow;

	if ( 'post.php' != $pagenow ) return $post_id;
		
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
		return $post_id;

	$post_type = get_post_type_object( $post->post_type );
	if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
		
	if ( ! isset( $_POST['vibe_editor_settings_nonce'] ) || ! wp_verify_nonce( $_POST['vibe_editor_settings_nonce'], basename( __FILE__ ) ) )
		return $post_id;

	if ( isset( $_POST['builder_enable'] ) )
		update_post_meta( $post_id, '_enable_builder', 1 );
	else
		update_post_meta( $post_id, '_enable_builder', 0 );
        
        if ( isset( $_POST['add_content'] ) )
		update_post_meta( $post_id, '_add_content', $_POST['add_content'] );
	else
		update_post_meta( $post_id, '_add_content', 'no' );
       
}
 

//if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    //add_action( 'woocommerce_before_single_product', 'show_builder_layout' );
//}
add_filter( 'the_content', 'show_builder_layout' );
function show_builder_layout( $content ){
	global $post;
	$builder_layout = get_post_meta( $post->ID, '_builder_settings', true );
	$builder_enable = get_post_meta( $post->ID, '_enable_builder', true );
        $add_content = get_post_meta( $post->ID, '_add_content', true );
	
        
            
	if ( ! is_singular() || ! $builder_layout || ! is_main_query() || 0 == $builder_enable ) return $content;
	
       
        
        
	if ( isset($builder_layout) && '' != $builder_layout['layout_shortcode'] && $add_content == 'no') { 
           
            $content = '<div class="vibe_editor clearfix">' . 
                do_shortcode( stripslashes( $builder_layout['layout_shortcode'] ) ) . 
                '</div>';
          
        }
        
        if ( $builder_layout && '' != $builder_layout['layout_shortcode'] && $add_content == 'yes_top') {
            $content = $content.'<div class="vibe_editor clearfix">' . 
                do_shortcode( stripslashes( $builder_layout['layout_shortcode'] ) ) . 
                '</div>';
        }
        
        if ( $builder_layout && '' != $builder_layout['layout_shortcode'] && $add_content == 'yes_below') {
            $content = '<div class="vibe_editor clearfix">' . 
                do_shortcode( stripslashes( $builder_layout['layout_shortcode'] ) ) . 
                '</div>'.$content;
        }
        
        
	return $content;
} ?>