<?php

/**
 * FILE: slider.php 
 * Created on Nov 16, 2012 at 4:08:14 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: VIBECOM
 */

add_shortcode( 'slider', 'shortcode_slider' );
function shortcode_slider( $atts ){
 extract( shortcode_atts( array(
		'id' => '',
                'style' => ''
	), $atts ) );
 
 $slider_array=get_post_meta($id,'vibe_slider');


 
 foreach($slider_array as $slider){
     
     $id=rand(1,999);
     $javastring= 'var slideroptions'.$id.' = { "controlNav" : '.((isset($slider['slider_control_nav']) && $slider['slider_control_nav'] == 1)? 'true':'false').', "directionNav" : '.((isset($slider['slider_direction_nav']) && $slider['slider_direction_nav'] == 1)? 'true':'false').', "slideshowSpeed" :'.((isset($slider['slider_slide_delay']) && $slider['slider_slide_delay'] != '')? $slider['slider_slide_delay'] : 6000).' }; ';
     
     global $script;
     $script .=$javastring;
     
     if(!isset($style))$style='defaultsliderstyle';
     
     $error = new VibeErrors();
      if(count($slider) < 6){
        return $error->get_error('slider_not_found');
      }
      
     switch($slider['slider_type']){
           case 'simple':{
               return simpleslider($slider,$id, $style);
               break;
           }
           case 'vibecom':{
               return vibecomslider($slider,$id, $style);
               break;
           }
           case 'thumbnailsimple':{
               return thumbnailsimpleslider($slider,$id, $style);
               break;
           }
           case 'vibecomthumbnail':{
               return thumbnailvibecomslider($slider,$id, $style);
               break;
           }
           case 'stepsimple':{
                   return stepsimpleslider($slider,$id, $style);
               break;
           }
           case 'stepvibecom':{
               return stepvibecomslider($slider,$id, $style);
               break;
           }
   }
 }
}

function simpleslider($slider,$id='', $style){
 
    $slides_count=(count($slider) -1);
    $slider_html='';
   
    $slider_html.= '<div class="simple-slider flexslider '.$style.'" data-id="'.$id.'">
  		<ul class="slides">';
  			
  	$i=0;			
    foreach($slider as $slide){ 
if(isset($slide['heading']) && $slide['heading']=='') unset($slide['heading']);
if(isset($slide['description']) && $slide['description']=='') unset($slide['description']);
if(isset($slide['action']) && $slide['action']=='') unset($slide['action']);

   if(isset($slide['image']))
    $image_attributes = wp_get_attachment_image_src( $slide['image'],'full' );
    if(isset($image_attributes[0])){
       $slider_html.= '<li>'.(isset($image_attributes[0])? '<img src="'.$image_attributes[0].'" />': '').'
                        '.(((isset($slide['heading']) && $slide['heading'] !='') || (isset($slide['description'])&& $slide['description'] !='') || (isset($slide['action']) && $slide['action'] !=''))?'
                            <div class="flex-caption">
                            '.(isset($slide['heading'])?'<h3>'.$slide['heading'].'</h3>':'').'
                            '.(isset($slide['description'])?'<p> '.$slide['description'].'</p>':'').'
                            '.(isset($slide['action'])?'<a href="'.$slide['url'].'" class="button right">'.$slide['action'].'</a>':'').'
                            </div>
                            ':'').'	
            </li>';
        }
        $i++;
    }
    
    $slider_html.= '</ul></div>';
    
    return($slider_html);
}

function vibecomslider($slider,$id='', $style){
 
    $slides_count=(count($slider) -4);
    
   $slider_html='';
    $slider_html.= '<div class="vibecom-slider flexslider '.$style.'" data-id="'.$id.'">
  		<ul class="slides">';
  			
  	$i=0;			
    for($i=0;$i<$slides_count;$i++){
      
        if(isset($slider[$i])){ 
            
        $slide=$slider[$i];
if(isset($slide['heading']) && $slide['heading']=='') unset($slide['heading']);
if(isset($slide['description']) && $slide['description']=='') unset($slide['description']);
if(isset($slide['action']) && $slide['action']=='') unset($slide['action']);
if(isset($slide['image']))
    $image_attributes = wp_get_attachment_image_src( $slide['image'],'full' );
    if(isset($image_attributes[0])){
       $slider_html.= '<li>
                    <img src="'.$image_attributes[0].'" alt="slide" />';
       
                        $slider_html.= ''.(((isset($slide['heading']) && $slide['heading'] !='') || (isset($slide['description'])&& $slide['description'] !='') || (isset($slide['action']) && $slide['action'] !=''))?'
  			<div id="slide'.($i+1).'" class="slide_caption">
                            '.(isset($slide['heading'])?'<h4 class="slide_title" data-effect="'.$slide['heading_effect'].'" data-displacement="'.$slide['heading_displacement'].'" data-duration="'.$slide['heading_duration'].'" data-easing="'.$slide['heading_easing'].'">'.$slide['heading'].'</h4>':'').'
                            '.(isset($slide['description'])?'<p class="slide_content" data-effect="'.$slide['description_effect'].'" data-displacement="'.$slide['description_displacement'].'" data-duration="'.$slide['description_duration'].'" data-easing="'.$slide['description_easing'].'">'.$slide['description'].'</p>':'').'
                            '.(isset($slide['action'])?'<a href="'.$slide['url'].'" class="slide_action button" data-effect="'.$slide['action_effect'].'" data-displacement="'.$slide['action_displacement'].'" data-duration="'.$slide['action_duration'].'" data-easing="'.$slide['action_easing'].'">'.$slide['action'].'</a>':'').'
  			</div>':'').'
            ';
      
       $slider_html .='</li>';
        }
        }
    }
    
    $slider_html.= '</ul></div>';
    return($slider_html);
}

function thumbnailsimpleslider($slider,$id='', $style){
     $slides_count=(count($slider) -4);
    
   $slider_html='';
    $slider_html.= '<div class="thumbnail-simple-slider flexslider '.$style.'" data-id="'.$id.'">
  		<ul class="slides">';
  			
  				
    for($i=0;$i<$slides_count;$i++){ if(isset($slider[$i])){$slide=$slider[$i];
if(isset($slide['heading']) && $slide['heading']=='') unset($slide['heading']);
if(isset($slide['description']) && $slide['description']=='') unset($slide['description']);
if(isset($slide['action']) && $slide['action']=='') unset($slide['action']);
if(isset($slide['image']))
    $image_attributes = wp_get_attachment_image_src( $slide['image'],'full' );
    $thumb_attributes = wp_get_attachment_image_src( $slide['image'],'thumbnails_slider' );
    if(isset($image_attributes[0])){
       $slider_html.= '<li data-thumb="'.$thumb_attributes[0].'">
                    <img src="'.$image_attributes[0].'" alt="slide" />
                       '.(((isset($slide['heading']) && $slide['heading'] !='') || (isset($slide['description'])&& $slide['description'] !='') || (isset($slide['action']) && $slide['action'] !=''))?' 
  			<div class="flex-caption">
                            <h3>'.$slide['heading'].'</h3>
                            '.((isset($slide['description']) && $slide['description'] !='')? '
                            <p> '.$slide['description'].'</p>' : '').
                            ((isset($slide['action']) && $slide['action'] !='')? '<a href="'.$slide['url'].'" class="button right">'.$slide['action'].'</a>':'').'
                            
  			</div>':'').'	
            </li>';
    }
    }
    }
    $slider_html.= '</ul></div>';
    return($slider_html);
}

function thumbnailvibecomslider($slider,$id='', $style){
 global $script;
 
    $slides_count=(count($slider) -4);
    
   $slider_html='';
    $slider_html.= '<div class="thumbnail-vibecom-slider flexslider '.$style.'" data-id="'.$id.'">
  		<ul class="slides">';
  			
  				
    for($i=0;$i<$slides_count;$i++){ 
        if(isset($slider[$i])){
        $slide=$slider[$i];
if(isset($slide['heading']) && $slide['heading']=='') unset($slide['heading']);
if(isset($slide['description']) && $slide['description']=='') unset($slide['description']);
if(isset($slide['action']) && $slide['action']=='') unset($slide['action']);
if(isset($slide['image']))
    $image_attributes = wp_get_attachment_image_src( $slide['image'],'full' );
    $thumb_attributes = wp_get_attachment_image_src( $slide['image'],'thumbnails_slider' );
    if(isset($image_attributes[0])){
      $slider_html.= '<li data-thumb="'.$thumb_attributes[0].'">
                    <img src="'.$image_attributes[0].'" alt="slide" />
                        '.(((isset($slide['heading']) && $slide['heading'] !='') || (isset($slide['description'])&& $slide['description'] !='') || (isset($slide['action']) && $slide['action'] !=''))?'
  			<div id="slide'.($i+1).'" class="slide_caption">
                            <h4 class="slide_title" data-effect="'.$slide['heading_effect'].'" data-displacement="'.$slide['heading_displacement'].'" data-duration="'.$slide['heading_duration'].'" data-easing="'.$slide['heading_easing'].'">'.$slide['heading'].'</h4>
                            '.((isset($slide['description']) && $slide['description'] !='')? '<p class="slide_content" data-effect="'.$slide['description_effect'].'" data-displacement="'.$slide['description_displacement'].'" data-duration="'.$slide['description_duration'].'" data-easing="'.$slide['description_easing'].'">'.$slide['description'].'</p>':'').'
                            '.((isset($slide['action']) && $slide['action'] !='')?'<a href="'.$slide['url'].'" class="slide_action button" data-effect="'.$slide['action_effect'].'" data-displacement="'.$slide['action_displacement'].'" data-duration="'.$slide['action_duration'].'" data-easing="'.$slide['action_easing'].'">'.$slide['action'].'</a>':'').'
                            
  			</div>':'').'
            </li>';
    }
    }
    }
    $slider_html.= '</ul></div>';
    return($slider_html);
}
function stepsimpleslider($slider,$id='', $style){
    
    $slides_count=(count($slider) -4);
    $slider_html='';
   
    $slider_html.= '<div class="step-simple-slider flexslider '.$style.'" data-id="'.$id.'">
  		<ul class="slides">';
  			
  				
    for($i=0;$i<$slides_count;$i++){
        if(isset($slider[$i])){
        $slide=$slider[$i];
if(isset($slide['heading']) && $slide['heading']=='') unset($slide['heading']);
if(isset($slide['description']) && $slide['description']=='') unset($slide['description']);
if(isset($slide['action']) && $slide['action']=='') unset($slide['action']);
if(isset($slide['image']))
    $image_attributes = wp_get_attachment_image_src( $slide['image'],'full' );
    $thumb_attributes = wp_get_attachment_image_src( $slide['image'],'thumbnails_slider' );
    if(isset($image_attributes[0])){
       $slider_html.= '<li>
                    <img src="'.$image_attributes[0].'" alt="slide" />
                        '.(((isset($slide['heading']) && $slide['heading'] !='') || (isset($slide['description'])&& $slide['description'] !='') || (isset($slide['action']) && $slide['action'] !=''))?'
  			<div class="flex-caption">
                            <h3>'.$slide['heading'].'</h3>
                             '.((isset($slide['description']) && $slide['description'] !='')? '<p> '.$slide['description'].'</p>' : '').'
                            '.((isset($slide['action']) && $slide['action'] !='')? ' <a href="'.$slide['url'].'" class="button right">'.$slide['action'].'</a>':'').'
  			</div>':'').'	
            </li>';
    }
    }
    }
    $slider_html.= '</ul></div>';
    
    $slider_html.= '<div class="stepcarousel flexslider '.$style.'">
  		<ul class="slides">';
    for($i=0;$i<$slides_count;$i++){ $slide=$slider[$i];
if(isset($slide['heading']) && $slide['heading']=='') unset($slide['heading']);
if(isset($slide['description']) && $slide['description']=='') unset($slide['description']);
if(isset($slide['action']) && $slide['action']=='') unset($slide['action']);

  				   $slider_html.= '<li>
  				      <div class="stepcarousel_step">
  				      <h3><span>'.do_shortcode($slide['step_label']).'</span> '.do_shortcode($slide['step_title']).'<small><br />'.do_shortcode($slide['step_subtitle']).'</small></h3>
  				      </div>
  				    </li>';
    }
    $slider_html.= '
  				  </ul>
  				</div>';
    return($slider_html);
}


function stepvibecomslider($slider,$id='', $style){
 
     $slides_count=(count($slider) -4);
    $slider_html='';
   
    $slider_html.= '<div class="step-vibecom-slider flexslider '.$style.'" data-id="'.$id.'">
  		<ul class="slides">';
  			
  				
    for($i=0;$i<$slides_count;$i++){ 
        if(isset($slider[$i])){
        $slide=$slider[$i];
if(isset($slide['heading']) && $slide['heading']=='') unset($slide['heading']);
if(isset($slide['description']) && $slide['description']=='') unset($slide['description']);
if(isset($slide['action']) && $slide['action']=='') unset($slide['action']);
if(isset($slide['image']))
    $image_attributes = wp_get_attachment_image_src( $slide['image'],'full' );
    $thumb_attributes = wp_get_attachment_image_src( $slide['image'],'thumbnails_slider' );
    if(isset($image_attributes[0])){
       $slider_html.= '<li>
                    <img src="'.$image_attributes[0].'" alt="slide" />
                        '.(((isset($slide['heading']) && $slide['heading'] !='') || (isset($slide['description'])&& $slide['description'] !='') || (isset($slide['action']) && $slide['action'] !=''))?'
  			<div id="slide'.($i+1).'" class="slide_caption">
                            <h4 class="slide_title" data-effect="'.$slide['heading_effect'].'" data-displacement="'.$slide['heading_displacement'].'" data-duration="'.$slide['heading_duration'].'" data-easing="'.$slide['heading_easing'].'">'.$slide['heading'].'</h4>
                            
                             '.((isset($slide['description']) && $slide['description'] !='')? '<p class="slide_content" data-effect="'.$slide['description_effect'].'" data-displacement="'.$slide['description_displacement'].'" data-duration="'.$slide['description_duration'].'" data-easing="'.$slide['description_easing'].'">'.$slide['description'].'</p>':'').'
                             '.((isset($slide['action']) && $slide['action'] !='')? '<a href="'.$slide['url'].'" class="slide_action button" data-effect="'.$slide['action_effect'].'" data-displacement="'.$slide['action_displacement'].'" data-duration="'.$slide['action_duration'].'" data-easing="'.$slide['action_easing'].'">'.$slide['action'].'</a>':'').'
  			</div>':'').'	
            </li>';
    }
        }
    }
    $slider_html.= '</ul></div>';
    
    $slider_html.= '<div class="vstepcarousel flexslider '.$style.'">
  		<ul class="slides">';
    for($i=0;$i<$slides_count;$i++){ $slide=$slider[$i];
if(isset($slide['heading']) && $slide['heading']=='') unset($slide['heading']);
if(isset($slide['description']) && $slide['description']=='') unset($slide['description']);
if(isset($slide['action']) && $slide['action']=='') unset($slide['action']);

  				   $slider_html.= '<li>
  				      <div class="stepcarousel_step">
  				       <h3><span>'.do_shortcode($slide['step_label']).'</span> '.do_shortcode($slide['step_title']).'<small><br />'.do_shortcode($slide['step_subtitle']).'</small></h3>
  				      </div>
  				    </li>';
    }
    $slider_html.= '
  				  </ul>
  				</div>';
    return($slider_html);
}
?>
