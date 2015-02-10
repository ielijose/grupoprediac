<?php

/*-----------------------------------------------------------------------------------*/
/*	Icon
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_icon')) {
	function vibe_icon( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'icon'   => 'icon-facebook',
                'size' => '',
                'bg' =>'',
                'hoverbg'=>'',
                'padding' =>'',
                'radius' =>'',
                'color' => '',
                'hovercolor' => ''
	), $atts));
        $return='';
        $rand = 'icon'.rand(1,9999);
        if((isset($size) && $size) || (isset($bg) && $bg) || (isset($padding) && $padding) || (isset($radius) && $radius) || (isset($color) && $color)){
        $return ='<style> #'.$rand.'{'.((isset($size) && $size)?'font-size:'.$size.';':'').''.(((isset($bg) && $bg))?'background:'.$bg.';':';').''.((isset($padding) && $padding)?'padding:'.$padding.';':'').''.((isset($radius) && $radius)?'border-radius:'.$radius.';':'').''.(((isset($color) && $color))?'color:'.$color.';':'').'}
            #'.$rand.':hover{'.(((isset($hovercolor) && $hovercolor))?'color:'.$hovercolor.';':'').''.(((isset($hoverbg) && $hoverbg))?'background:'.$hoverbg.';':'').'}</style>';
        }
        $return .='<i class="'.$icon.'" id="'.$rand.'"></i>';
	   return $return;
	}
	add_shortcode('icon', 'vibe_icon');
}

/*-----------------------------------------------------------------------------------*/
/*	Round Progress
/*-----------------------------------------------------------------------------------*/


if (!function_exists('vibe_roundprogress')) {
	function vibe_roundprogress( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'percentage'   => '60',
                'radius' => '',
                'thickness' =>'',
                'color' =>'#333',
                'bg_color' =>'#65ABA6',
	), $atts));
        $rand = 'icon'.rand(1,9999);
        $return ='<figure class="knob animate zoom" style="width:'.($radius+30).'px;min-height:'.($radius+30).'px;">
                    <input class="dial" data-value="'.$percentage.'" data-fgcolor="'.$bg_color.'" data-height="'.$radius.'" data-inputColor="'.$color.'" data-width="'.$radius.'" data-thickness="'.($thickness/100).'" value="'.$percentage.'" data-readOnly=true />
                        <div class="knob_content"><h3 style="color:'.$color.';">'.do_shortcode($content).'</h3></div>
                  </figure>';
        return $return;
	}
	add_shortcode('roundprogress', 'vibe_roundprogress');
}



/*-----------------------------------------------------------------------------------*/
/*	WPML Language Selector shortcode
/*-----------------------------------------------------------------------------------*/

//[wpml_lang_selector]
function wpml_shortcode_func(){
do_action('icl_language_selector');
}
add_shortcode( 'wpml_lang_selector', 'wpml_shortcode_func' );


/*-----------------------------------------------------------------------------------*/
/*	Note
/*-----------------------------------------------------------------------------------*/


if (!function_exists('note')) {
	function note( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'style'   => '',
                'bg' =>'',
                'border' =>'',
                'bordercolor' =>'',
                'color' => ''
	), $atts));
	   return '<div class="note '.$style.'" style="background-color:'.$bg.';border-color:'.$border.';">
			<div class="notepad" style="color:'.$color.';border-color:'.$bordercolor.';">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('note', 'note');
}

/*-----------------------------------------------------------------------------------*/
/*	Column Shortcode
/*-----------------------------------------------------------------------------------*/

if (!function_exists('one_half')) {
	function one_half( $atts, $content = null ) {
	    $clear='';
	    if(isset($atts['first']))
	    if (strpos($atts['first'],'first') !== false)
	      $clear='clearfix';
	      
            return '<div class="one_half '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('one_half', 'one_half');
}


if (!function_exists('one_third')) {
	function one_third( $atts, $content = null ) {
	$clear='';
	if (isset($atts['first']) && strpos($atts['first'],'first') !== false)
	  $clear='clearfix';
	  
	   return '<div class="one_third '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('one_third', 'one_third');
}


if (!function_exists('one_fourth')) {
	function one_fourth( $atts, $content = null ) {
	$clear='';
	if (isset($atts['first']) && strpos($atts['first'],'first') !== false)
	  $clear='clearfix';
             return '<div class="one_fourth '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';	}
	add_shortcode('one_fourth', 'one_fourth');
}


if (!function_exists('three_fourth')) {
	function three_fourth( $atts, $content = null ) {
	$clear='';
	if (isset($atts['first']) && strpos($atts['first'],'first') !== false)
	  $clear='clearfix';
             return '<div class="three_fourth '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('three_fourth', 'three_fourth');
}


if (!function_exists('two_third')) {
	function two_third( $atts, $content = null ) {
	$clear='';
	if (isset($atts['first']) && strpos($atts['first'],'first') !== false)
	  $clear='clearfix';
            return '<div class="two_third"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('two_third', 'two_third');
}

if (!function_exists('one_fifth')) {
	function one_fifth( $atts, $content = null ) {
	$clear='';
	if (isset($atts['first']) && strpos($atts['first'],'first') !== false)
	  $clear='clearfix';
            return '<div class="one_fifth '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('one_fifth', 'one_fifth');
}
if (!function_exists('two_fifth')) {
	function two_fifth( $atts, $content = null ) {
            return '<div class="two_fifth '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('two_fifth', 'two_fifth');
}
if (!function_exists('three_fifth')) {
	function three_fifth( $atts, $content = null ) {
	$clear='';
	if (isset($atts['first']) && strpos($atts['first'],'first') !== false)
	  $clear='clearfix';
            return '<div class="three_fifth '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('three_fifth', 'three_fifth');
}
if (!function_exists('four_fifth')) {
	function four_fifth( $atts, $content = null ) {
	$clear='';
	if (isset($atts['first']) && strpos($atts['first'],'first') !== false)
	  $clear='clearfix';
            return '<div class="four_fifth '.$clear.'"><div class="column_content '.(isset($atts['first'])?$atts['first']:'').'">' . do_shortcode($content) . '</div></div>';
	}
	add_shortcode('four_fifth', 'four_fifth');
}
/*-----------------------------------------------------------------------------------*/
/*	Team
/*-----------------------------------------------------------------------------------*/


if (!function_exists('team_member')) {
	function team_member( $atts, $content = null ) {
            extract(shortcode_atts(array(
                        'style' => '',
                        'pic' => '',
			'name'   => '',
                        'designation' => '',
                        'description' => ''
	    ), $atts));
	    
	    $output  = '<div class="team_member '.$style.'">';
            
            if(isset($pic) && $pic !=''){
                if(preg_match('!(?<=src\=\").+(?=\"(\s|\/\>))!',$pic, $matches )){
                    $output .= '<img src="'.$matches[0].'" class="animate zoom" alt="'.$name.'" />';
                }else{
                    $output .= '<img src="'.$pic.'" class="animate zoom" alt="'.$name.'" />';
                }
            }
            
            (isset($name) && $name !='')?$output .= '<h3>'.html_entity_decode($name).'</h3>':'';
            ((isset($designation) && $designation !='')?$output .= '<h4>'.html_entity_decode($designation).'</h4>':'');
            (isset($description) && $description !='')?$output .= '<p>'.html_entity_decode($description).'</p>':'';
            global $vibe_options;
            $output .= '<ul class="socialicons '.$vibe_options['social_icons_type'].'">';
            $output .=do_shortcode($content);
            $output .= '</ul></div>';
            return $output;
	}
	add_shortcode('team_member', 'team_member');
}

if (!function_exists('team_social')) {
	function team_social( $atts, $content = null ) {
            extract(shortcode_atts(array(
			'icon' => 'icon-facebook',
                        'url' => ''
	    ), $atts));
           $class=str_replace('icon-','',$icon);
	   return '<li><a href="'.$url.'" title="'.$icon.'" class="'.$class.'" target="_blank"><i class="'.$icon.'"></i></a></li>';;
	}
	add_shortcode('team_social', 'team_social');
}

/*-----------------------------------------------------------------------------------*/
/*	Buttons
/*-----------------------------------------------------------------------------------*/

if (!function_exists('button')) {
	function button( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'url' => '#',
			'target' => '_self',
                        'class' => 'base',
			'bg' => '',
			'hover_bg' => '',
			'color' => '',
                        'size' => 0,
                        'width' => 0,
                        'height' => 0,
                        'radius' => 0,
	    ), $atts));
		
             $rand = 'button'.rand(1,9999);
             
             if((isset($bg) && $bg) || (isset($size) && $size && $size!= '0px') || (isset($width) && $width && $width!= '0px') || (isset($height) && $height && $height!= '0px') || (isset($radius) && $radius && $radius!= '0px') || (isset($hover_bg) && $hover_bg)){
           $return ='<style> #'.$rand.'{'.((isset($bg) && $bg)?'background-color:'.$bg.';':'').'
               '.((isset($color) && $color)?'color:'.$color.';':'').'
                   '.((isset($size) && $size && $size!= '0px')?'font-size:'.$size.';':'').'
                       '.((isset($width) && $width && $width!= '0px')?'width:'.$width.';':'').'
                           '.((isset($height) && $height && $height!= '0px')?'padding-top:'.$height.';padding-bottom:'.$height.';':'').'
               '.((isset($radius) && $radius && $radius!= '0px')?'border-radius:'.$radius.';':'').'} 
               #'.$rand.':hover{'.((isset($hover_bg) && $hover_bg)?'background-color:'.$hover_bg.';':'').'}</style>';
             }     
           $return='';
           $return .='<a target="'.$target.'" id="'.$rand.'" class="btn '.$class.'" href="'.$url.'">'.do_shortcode($content) . '</a>';
                 return $return;
	}
	add_shortcode('button', 'button');
}


/*-----------------------------------------------------------------------------------*/
/*	Alerts
/*-----------------------------------------------------------------------------------*/

if (!function_exists('alert')) {
	function alert( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'style'   => 'block',
                        'bg' => '',
                        'border' =>'',
                        'color' => '',
	    ), $atts));
		
           return '<div class="alert alert-'.$style.'" style="'.(($color)?'color:'.$color.';':'').''.(($bg)?'background-color:'.$bg.';':'').''.(($border)?'border-color:'.$border.';':'').'">'
                     . do_shortcode($content) . '</div>';
	}
	add_shortcode('alert', 'alert');
}

/*-----------------------------------------------------------------------------------*/
/*	Accordion Shortcodes
/*-----------------------------------------------------------------------------------*/


if (!function_exists('agroup')) {
	function agroup( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'style'   => '',
                'id'=>''
	), $atts));
        global $rand;
	   return '<div class="accordion '.$style.'" id="accordion'.$id.'">' . 
                   do_shortcode($content) . '</div>';
	}
	add_shortcode('agroup', 'agroup');
}



if (!function_exists('accordion')) {
	function accordion( $atts, $content = null ) {
            extract(shortcode_atts(array(
			'title' => 'Title goes here',
                        'id' => ''
	    ), $atts));
            
            $rid=rand(1,999);
	   return '<div class="accordion-group">
                     <div class="accordion-heading">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion'.$id.'"  href="#collapse'.$rid.'">
                            <i></i> '. $title .'</a>
                    </div>
                    <div id="collapse'.$rid.'" class="accordion-body collapse">
                        <div class="accordion-inner">
                            <p>'. do_shortcode($content) .'</p>
                        </div>
                   </div>
                   </div>';
	}
	add_shortcode('accordion', 'accordion');
}



/*-----------------------------------------------------------------------------------*/
/*	Toggle Shortcodes
/*-----------------------------------------------------------------------------------*/

if (!function_exists('toggle')) {
	function toggle( $atts, $content = null ) {
	    extract(shortcode_atts(array(
			'title'    	 => 'Title goes here',
			'state'		 => ''
	    ), $atts));

	$id=rand(1,999);
            return '<div class="accordion-group"><div class="accordion-heading"><a class="accordion-toggle '.$state.'" data-toggle="collapse" href="#collapse'.$id.'">'. $title .'<i class="icon-chevron-down right"></i></a></div><div id="collapse'.$id.'" class="accordion-body collapse '.((!isset($state) || $state =='')? 'in':'').'"><div class="accordion-inner"><p>'. do_shortcode($content) .'</p></div></div></div>';
	}
	add_shortcode('toggle', 'toggle');
}


/*-----------------------------------------------------------------------------------*/
/*	Testimonial Shortcodes
/*-----------------------------------------------------------------------------------*/

if (!function_exists('testimonial')) {
	function testimonial( $atts, $content = null ) {
	global $vibe_options;
	    extract(shortcode_atts(array(
			'id'    	 => '',
                        'length'    	 => 100,
                        'style'          => '',
	    ), $atts));
    global $post;
    $postdata=get_post($id);
    
    if($postdata == NULL){
    $error = new VibeErrors();
    return $error->get_error('incorrect_testimonial');;
    }


    $author=get_post_custom_values('vibe_testimonial_author_name',$id); 
    $designation=get_post_custom_values('vibe_testimonial_author_designation',$id); 
    if(is_array($author))$author=$author[0];
    if(is_array($designation))$designation=$designation[0];
    
    $error = new VibeErrors();
     if(!isset($author) && !$vibe_options['disable_errors']){
       return $error->get_error('author_not_found');
     }
    
        $return = thumbnail_generator($postdata,'testimonial',3,$length);
    
   return $return;
	}
	add_shortcode('testimonial', 'testimonial');
}


/*-----------------------------------------------------------------------------------*/
/*	Agent
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_agent')) {
	function vibe_agent( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'id'   => '',
	), $atts));
        
        $return='';
        $image=getPostMeta($id,'vibe_agent_image');
        if(wp_attachment_is_image($image)){
                        $image= wp_get_attachment_image_src ($image,'mini');
                        $image= $image[0];
                        }
        $return .='<div class="vibe_agent">
                        <img src="'. $image .'" alt="agent image" />
                        <div class="agent_desc">
                        <h4><a href="'.get_permalink($id).'">'.get_the_title($id).'</a></h4>
                        <p><i class="icon-mobile"></i> '.getPostMeta($id,'vibe_agent_phone').' | <i class="icon-mail-2"></i> '.getPostMeta($id,'vibe_agent_email').'</p>    
                        </div>
                   </div>';
	   return $return;
	}
	add_shortcode('agent', 'vibe_agent');
}

/*-----------------------------------------------------------------------------------*/
/*	Listing
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibe_listing')) {
	function vibe_listing( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'id'   => '',
	), $atts));
        global $vibe_options;
        $return='';
        
        $return .='<div class="vibe_single_listing">
                        '.  get_the_post_thumbnail($id,'medium').'
                        <div class="vibe_listing_description">
                        <h4><a href="'.get_permalink($id).'">'.get_the_title($id).'</a></h4>';
        
         if(isset($vibe_options['listing_fields']['field_type']) && is_array($vibe_options['listing_fields']['field_type'])){
        $i = array_search('price', $vibe_options['listing_fields']['field_type']);
        $key = 'vibe_'.strtolower(str_replace(' ', '-',$vibe_options['listing_fields']['label'][$i]));   
        $return .='<p class="price"><i class="'.$vibe_options['currency'].'"></i> '.getPostMeta($id,$key).'</p>';
        
            }
               $return .='<p> '.get_the_term_list( $id, 'location', ' ', ' ', '' ).'</p>';
               $return .='</div>
                   </div>';
	   return $return;
	}
	add_shortcode('listing', 'vibe_listing');
}

/*-----------------------------------------------------------------------------------*/
/*	Tabs Shortcodes
/*-----------------------------------------------------------------------------------*/

if (!function_exists('tabs')) {
	function tabs( $atts, $content = null ) {
            extract(shortcode_atts(array(
			'style'   => '',
                        'theme'   => ''
	    ), $atts));
            
		$defaults=$tab_icons = array();
                extract( shortcode_atts( $defaults, $atts ) );
		
		// Extract the tab titles for use in the tab widget.
		preg_match_all( '/tab title="([^\"]+)" icon="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		
		$tab_titles = array();
                
		if(!count($matches[1])){ 
		preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		if( isset($matches[1]) ){ $tab_titles = $matches[1];}
		}else{
		if( isset($matches[1]) ){ $tab_titles = $matches[1]; $tab_icons= $matches[2];}
		}
		
		
		$output = '';
                global $vibe_options;
                $vibe_options['rand'] = rand(1,1000);
		if( count($tab_titles) ){
		    $output .= '<div id="vibe-tabs-'. rand(1, 100) .'" class="tabs tabbable '.$style.' '.$theme.'">';
			$output .= '<ul class="nav nav-tabs clearfix">';
			$i=0;
                         foreach( $tab_titles as $tab ){ 
                                $tabstr= str_replace(' ', '-', $tab[0]);
				$output .= '<li><a href="#tab-'. $tabstr .'-'.$vibe_options['rand'].'">'.(isset($tab_icons[$i][0])?'<span><i class="' . $tab_icons[$i][0] . '"></i></span>': '').'' . $tab[0] . '</a></li>';
				$i++;
			}
		    $output .= '</ul><div class="tab-content">';
		    $output .= do_shortcode( $content );
		    $output .= '</div></div>';
		} else {
			$output .= do_shortcode( $content );
		}
		
		return $output;
	}
	add_shortcode( 'tabs', 'tabs' );
}

if (!function_exists('tab')) {
	function tab( $atts, $content = null ) { global $vibe_options;
		$defaults = array( 'title' => 'Tab' );
		extract( shortcode_atts( $defaults, $atts ) );
		$tabstr= str_replace(' ', '-', $title);
		return '<div id="tab-'. $tabstr .'-'.$vibe_options['rand'].'" class="tab-pane"><p>'. do_shortcode( $content ) .'</p></div>';
	}
	add_shortcode( 'tab', 'tab' );
}


/*-----------------------------------------------------------------------------------*/
/*	Tooltips
/*-----------------------------------------------------------------------------------*/

if (!function_exists('tooltip')) {
	function tooltip( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'style'   => '',
                        'direction'   => 'top',
                        'tip' => 'Tooltip',
                        'url' =>'http://google.com',
                        'target' => '_self'
	    ), $atts));
		$istyle='';

           return '<a href="'.$url.'" target="'.$target.'" data-rel="tooltip" class="tip-'.$style.'" data-placement="'.$direction.'" data-original-title="'.$tip.'">'.do_shortcode($content).'</a>';

	}
	add_shortcode('tooltip', 'tooltip');
}


/*-----------------------------------------------------------------------------------*/
/*	Taglines
/*-----------------------------------------------------------------------------------*/

if (!function_exists('tagline')) {
	function tagline( $atts, $content = null ) {
            extract(shortcode_atts(array(
			'style'   => '',
                        'bg'   => '',
                        'border'   => '',
                        'bordercolor'   => '',
                        'color'   => '',
	    ), $atts));
           return '<div class="tagline '.$style.'" style="background:'.$bg.';border-color:'.$border.';border-left-color:'.$bordercolor.';color:'.$color.';" >'.do_shortcode($content).'</div>';
	}
	add_shortcode('tagline', 'tagline');
}

/*-----------------------------------------------------------------------------------*/
/*	Tags
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vtags')) {
	function vtags( $atts, $content = null ) {
	global $post;
	$tags=get_the_tags();
	$tag_list='';
	if(isset($tags) && is_array($tags)){
	foreach($tags as $tag){
	$tag_list .='<a href="?tag='.$tag->slug.'">'.$tag->name.'</a>';
	}
	}else{
            return false;
        }
        return '<div class="meta"> <span class="left">TAGS:</span>'.$tag_list.'</div>';

	}
	add_shortcode('tags', 'vtags');
}


/*-----------------------------------------------------------------------------------*/
/*	Pricing
/*-----------------------------------------------------------------------------------*/

if (!function_exists('pricing_table')) {
	function pricing_table( $atts, $content = null ) { 
			extract(shortcode_atts(array(
			'style'   => '',
                        	    ), $atts));
		 
			
           return '<div class="pricing_table '.$style.'">
			'.do_shortcode($content).'
			</div>	';

	}
	add_shortcode('pricing_table', 'pricing_table');
}

if (!function_exists('pricing_column')) {
	function pricing_column( $atts, $content = null ) { 
            extract(shortcode_atts(array(
                        'style' => '',
			'title'   => 'Standard',
                        'price'   => 'Free ',
                        'button' => 'Buy Now',
                        'link' => '',
                        	    ), $atts));
            
           return '<div class="pricing_column">
                    <div class="column_price">
                        <label>'.$title.'</label>
                        <h3 style="color:'.$pricecolor.';">'.$title.'</h3>
                    </div>        
                    <div class="pricing_content">   
                    '.do_shortcode($content).'
                    </div>
                        <div class="call_to_action">
                        <a href="'.$link.'" class="btn">'.$button.'</a>
                        </div>
                    </div>';
	}
	add_shortcode('pricing_column', 'pricing_column');
}


/*-----------------------------------------------------------------------------------*/
/*	Animated Content
/*-----------------------------------------------------------------------------------*/

if (!function_exists('animated_menu')) {
	function animated_menu( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'style'   => 'default',
                        'size'   => ''
	    ), $atts));
		
	 
           return '<ul class="animated_menu_'.$style.' sti-menu '.$size.'">'.do_shortcode($content).'
                                </ul>';

	}
	add_shortcode('animated_menu', 'animated_menu');
}

if (!function_exists('menu_item')) {
	function menu_item( $atts, $content = null ) {
            extract(shortcode_atts(array(
			'icon'   => 'a',
                        'sub'   => '',
                        'url'   => ''
	    ), $atts));
            $icon =stripslashes($icon);
            global $vibe_options;
           return '<li data-hovercolor="'.$vibe_options['primarytextcolor'].'">
			<a href="'.$url.'">'.((strlen($icon) <25)?'<i data-type="icon" class="sti-icon sti-item '.$icon.'"></i>':'<img src="'.$icon.'" />').' 
						<h2 data-type="mText" class="sti-item">'.do_shortcode($content).'</h2>
						<h3 data-type="sText" class="sti-item">'.do_shortcode($sub).'</h3>
						
					</a>
				</li>';

	}
	add_shortcode('menu_item', 'menu_item');
}

/*-----------------------------------------------------------------------------------*/
/*	Modals
/*-----------------------------------------------------------------------------------*/

if (!function_exists('modal')) {
	function modal( $atts, $content = null ) {
            extract(shortcode_atts(array(
            	'id'   => '',
                'auto' => 0,
                'width' => '',
                'height' =>'',
                'hide_extras'=>0,
                'classes' =>''
            ), $atts));
/*if(isset($id)){	 
 $modal=get_page($id);
}
 * 
 */

   global $vibe_post_script;
    if($auto)
     $vibe_post_script .='jQuery("#anchor_popup_'.$id.'").trigger("click");'; 
    
        $return='';
        if($hide_extras)
            $return .='<style>.pp_details{display:none;}</style>';
        $return .='<a href="'.admin_url('admin-ajax.php').'?ajax=true&action=popup&width='.$width.'&height='.$height.'&id='.$id.'" class="'.$classes.'" data-rel="prettyPhoto[ajax]" id="anchor_popup_'.$id.'">'.do_shortcode($content).'</a>';
        return $return;

	}
	add_shortcode('popups', 'modal');
}

/*=== Featured Shortcode ===*/

if (!function_exists('featured_element')) {
	function featured_element( $atts, $content = null ) {
            global $post; 
            $result=featured_component($post->ID);
            return $result;
	}
	add_shortcode('featured', 'featured_element');
}

/*=== Audio Shortcode ===*/

if (!function_exists('audio')) {
	function audio( $atts, $content = null ) { 
            extract(shortcode_atts(array(
			'mp3'   => '',
                        'ogg'   => '',
                        'wav'   => '',
                            ), $atts));
           $af='';
           if((isset($mp3) && $mp3 !='') || (isset($ogg) && $ogg !='') || (isset($wav) && $wav !='')){
               
               if(isset($mp3) && $mp3 !='')
                    $af .='<source src="'.$mp3.'">';
               
               if(isset($ogg) && $ogg !='')
                   $af .='<source src="'.$ogg.'">';
                   
               if(isset($wav) && $wav !='')  
                   $af .='<source src="'.$wav.'">';
               
           }else{
               $audio_files=explode(',',$content);
           foreach($audio_files as $audio_file){
                            
                        			$af .='<source src="'.wp_get_attachment_url($audio_file).'">';
                        		} 
           }
	               
           global $post;
           $audio ='<div class="fitaudio '.$style.'">'.get_the_post_thumbnail($post->ID,'full').'
                        <div class="audio_player"><audio preload="auto" controls>';
                        $audio .=$af;
                        					$audio .='</audio></div></div>';
                        return $audio;
	}
	add_shortcode('audio', 'audio');
}

/*-----------------------------------------------------------------------------------*/
/*	Timer shortcode
/*-----------------------------------------------------------------------------------*/

if (!function_exists('timer')) {
	function timer( $atts, $content = null ) { 
                        extract(shortcode_atts(array(
			'end'   => '2013,01,31'
                            ), $atts));
                        $num=rand(1,999);
                        $timer ='<div class="timer"><div id="timer'.$num.'"></div></div>';
                        global $vibe_post_script;
                        $vibe_post_script .='var newYear = new Date(); 
                            var date = new Date("'.$end.'");
                            $("#timer'.$num.'").countdown({until: date, format: "dHMS"});';
                        return $timer;
	}
	add_shortcode('timer', 'timer');
}


/*-----------------------------------------------------------------------------------*/
/*	Google Maps shortcode
/*-----------------------------------------------------------------------------------*/

if (!function_exists('gmaps')) {
	function gmaps( $atts, $content = null ) { 
                        $map ='<div class="gmap">'.$content.'</div>';
                        return $map;
	}
	add_shortcode('map', 'gmaps');
}

/*-----------------------------------------------------------------------------------*/
/*	Gallery shortcode
/*-----------------------------------------------------------------------------------*/

if (!function_exists('gallery')) {
	function gallery( $atts, $content = null ) { 
           extract(shortcode_atts(array(
                        'size' => 'normal',
                        'ids' => ''
                            ), $atts));
            $gallery='<div class="gallery '.$size.'">';
            
            
                if(isset($ids) && $ids!=''){
                    $rand='gallery'.rand(1,999);
                    $posts=explode(',',$ids);
                    foreach($posts as $post_id){
                         // IF Ids are not Post Ids
                           if ( wp_attachment_is_image( $post_id ) ) {
                               $attachment_info = wp_get_attachment_info($post_id);
                               
                               $full=wp_get_attachment_image_src( $post_id, 'full' );
                               $thumb=wp_get_attachment_image_src( $post_id, $size );
                               
                               if(is_array($thumb))$thumb=$thumb[0];
                                if(is_array($full))$full=$full[0];
                                
                               $gallery.='<a href="'.$full.'" data-rel="prettyPhoto['.$rand.']" '.((isset($attachment_info['caption']) && $attachment_info['caption'])?'title="'.$attachment_info['caption'].'"':'').'><img src="'.$thumb.'" alt="'.$attachment_info['title'].'" /></a>';
                            }
                    }
                }
            $gallery.='</div>';
                        return $gallery;
	}
	add_shortcode('gallery', 'gallery');
}


/*==== Drop caps ====*/
if (!function_exists('dropcaps')) {
	function dropcaps( $atts, $content = null ) { 	
             extract(shortcode_atts(array(
                        'color' => '',
                        'padding' => '5px',
                        'size' => '16px'
                            ), $atts));
             
           return '<span class="dropcaps" style="'.(($color)?'color:'.$color.';':'').(($padding != '0px')?'padding-top:'.$padding.';padding-bottom:'.$padding.';line-height:0;':'').(($size)?'font-size:'.$size.';':'').'">'.do_shortcode($content).'</span>';
	}
	add_shortcode('d', 'dropcaps');
}


/*-----------------------------------------------------------------------------------*/
/*	Heading Shortcodes
/*-----------------------------------------------------------------------------------*/

if (!function_exists('heading')) {
	function heading( $atts, $content = null ) { 
             extract(shortcode_atts(array(
                        'style' => '',
                            ), $atts));
                return '<h3 class="heading '.$style.'"><span>'.do_shortcode($content).'</span></h3>';
	}
	add_shortcode('heading', 'heading');
}






/*-----------------------------------------------------------------------------------*/
/*	Progress Barl Shortcodes
/*-----------------------------------------------------------------------------------*/

if (!function_exists('progressbar')) {
	function progressbar( $atts, $content = null ) { 
			extract(shortcode_atts(array(
			             'color' => 'progress-info',
			             'style' => 'progress-striped',
                                     'bg' => '',
                                     'textcolor' => '',
			             'percentage' => '20'
			                 ), $atts));
				
           return '<div class="pbar">
                    <h5>'.do_shortcode($content).'</h5>
                    <div class="progress '.$color.' '.$style.'">
                        <div class="bar" style="width: '.$percentage.'%;'.(($bg)?'background-color:'.$bg.';':'').''.((isset($padding) && $padding != '0px' )?'padding:'.$padding.';':'').''.(($textcolor)?'color:'.$textcolor.';':'').'"></div>
                    </div>
                    </div>';

	}
	add_shortcode('progressbar', 'progressbar');
}



/*-----------------------------------------------------------------------------------*/
/*	Form Generator Shortcodes
/*-----------------------------------------------------------------------------------*/

if (!function_exists('vibeform')) {
	function vibeform( $atts, $content = null ) { 
            extract(shortcode_atts(array(
			             'style' => '',
                                     'email' => get_option('admin_email'),
                                     'subject' => 'Contact Submission'
			             ), $atts));
	
            $id=rand(1,999);
           return '<div class="form '.$style.'">
           	 <form method="post" data-email="'.$email.'" data-subject="'.$subject.'">'.
                    do_shortcode($content)  
           	 .'<div class="response"></div></form>
           	 </div>';

	}
	add_shortcode('form', 'vibeform');
}


if (!function_exists('form_element')) {
	function form_element( $atts, $content = null ) {
            extract(shortcode_atts(array(
			'type' => 'text',
                        'validate' => '',
                        'options' => '',
                        'placeholder' => 'Name'
	    ), $atts));
            $output='';
            switch($type){
                case 'text': $output .= '<input type="text" placeholder="'.$placeholder.'" class="form_field text" data-validate="'.$validate.'" />';
                    break;
                case 'textarea': $output .= '<textarea placeholder="'.$placeholder.'" class="form_field  textarea" data-validate="'.$validate.'"></textarea>';
                    break;
                case 'select': $output .= '<select class="form_field  select" placeholder="'.$placeholder.'">';
                                $output .= '<option value="">'.$placeholder.'</option>';
                                $options  = explode(',',$options);
                                foreach($options as $option){
                                    $output .= '<option value="'.$option.'">'.$option.'</option>';
                                }
                                $output .= '</select>';
                    break;
                case 'submit':
                    $output .= '<input type="submit" class="form_submit btn primary" value="'.$placeholder.'" />';
                    break;
            }

	   return $output;
	}
	add_shortcode('form_element', 'form_element');
}




/*-----------------------------------------------------------------------------------*/
/*	Project details Shortcodes
/*-----------------------------------------------------------------------------------*/
if (!function_exists('vibe_lists')) {
	function vibe_lists( $atts, $content = null ) {
            extract(shortcode_atts(array(
			'heading' => 'text'
	    ), $atts));
            
            $output ='<div class="vibe_list">
                       <h3 class="heading"><span>'.$heading.'</span></h3>
                            <ul>';
                     $output .= do_shortcode($content);    
                           
           $output .='</ul>    
                        </div>';
            return $output;
	}
	add_shortcode('list', 'vibe_lists');
}

if (!function_exists('vibe_listitem')) {
    function vibe_listitem( $atts, $content = null ) {
        return '<li>'.do_shortcode($content).'</li>';
    }
    add_shortcode('listitem', 'vibe_listitem');
}

?>