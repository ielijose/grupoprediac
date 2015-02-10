<?php

/**
 * FILE: thumbnail_generator.php 
 * Created on Mar 7, 2013 at 5:17:24 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */

if(!function_exists('thumbnail_generator')){
function thumbnail_generator($post,$featured_style,$cols,$n=100,$link=0,$zoom=0){
    $return=$read_more=$class='';
    global $vibe_options;
    
    $more = __('Read more','vibe');
    
    if(strlen($post->post_content) > $n)
                        $read_more= '<a href="'.get_permalink($post->ID).'" class="small_more">'.$more.'</a>';
    
    switch($featured_style){
            case 'hover':
                   $return .='<div class="block hover">';
                    $return .='<div class="block_media">';

                    $link_media=vibe_get_option('link_media');
                    switch($link_media){
                        case 1:
                            $return .='<a href="'.apply_filters('vestate_link_filter',get_permalink($post->ID)).'">'.featured_component($post->ID,$cols).'</a>';
                        break;
                        case 2:
                            $return .='<a href="'.apply_filters('vestate_link_filter',get_the_post_thumbnail($post->ID,full)).'" data-rel="prettyPhoto">'.featured_component($post->ID,$cols).'</a>';
                        break;
                        default:
                            $return .=featured_component($post->ID,$cols);
                        break;
                    }
                    $return .='</div>';
                    
                    $return .='<div class="block_content">';
                    
                    
                    $heart='';
                    $likes=getPostMeta($post->ID,'like_count');
                    if(isset($vibe_options['enable_likes']) && $vibe_options['enable_likes'])
                    $heart .='<a class="like" id="'.$post->ID.'" rel="tooltip" data-placement="top" data-original-title="Likes"><i class="icon-heart"></i> '.(isset($likes)?$likes:'0').'</a>';
                    
                    
                    
                    $return .='<h4 class="block_title"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h4>';
                    
                    $category='';
                    if(get_post_type($post->ID) == 'post'){
                        $cats = get_the_category(); 
                        if(is_array($cats)){
                            $category .= '<div class="categories">';

                            foreach($cats as $cat){
                            $category .= '<a href="'.get_category_link($cat->term_id ).'">'.$cat->cat_name.'</a> ';
                                
                             }
                             $category .= '</div>';
                        }
                    }
                    
                    if(get_post_type($post->ID) == 'portfolio'){
                        $cats = get_the_category(); 
                        if(is_array($cats)){
                             $category .= '<div class="categories">';
                             $category .= get_the_term_list( $post->ID, 'portfolio-type', ' ', ' ', '' );
                             $category .= '</div>';
                        }
                    }
                    
                    $return .= $category;
                    
                    if($n > 0)
                    $return .='<p class="block_desc">'.custom_excerpt($n,$post->ID).'</p>';
                   
                    if(isset($link) && $link)
                    $return .= '<a href="'.get_permalink($post->ID).'" class="hover-link link"><i class="icon-link"></i></a>';
                    if(isset($zoom) && has_post_thumbnail($post->ID) && $zoom )
                    $return .= '<a href="'.wp_get_attachment_url( get_post_thumbnail_id($post->ID),$cols ).'" class="hover-link pop" rel="prettyPhoto[pp_gal]"><i class="icon-resize-full"></i></a>';
                    
                    $return .='</div>';
                    $return .='</div>';
                break;
           case 'side':
                   $return .='<div class="block side">';
                    $return .='<div class="block_media">';
                    if(isset($link) && $link)
                        $return .='<span class="overlay"></span>';
                    if(isset($link) && $link)
                    $return .= '<a href="'.get_permalink($post->ID).'" class="hover-link link"><i class="icon-link"></i></a>';
                    $featured= getPostMeta($post->ID, 'vibe_select_featured');
                    if(isset($zoom) && $zoom && has_post_thumbnail($post->ID) )
                    $return .= '<a href="'.wp_get_attachment_url( get_post_thumbnail_id($post->ID),$cols ).'" class="hover-link pop" rel="prettyPhoto[pp_gal]"><i class="icon-resize-full"></i></a>';
                    
                    
                    $link_media=vibe_get_option('link_media');
                    switch($link_media){
                        case 1:
                            $return .='<a href="'.get_permalink($post->ID).'">'.featured_component($post->ID,$cols).'</a>';
                        break;
                        case 2:
                            $return .='<a href="'.get_the_post_thumbnail($post->ID,full).'" data-rel="prettyPhoto">'.featured_component($post->ID,$cols).'</a>';
                        break;
                        default:
                            $return .=featured_component($post->ID,$cols);
                        break;
                    }
                    
                    $category='';
                    if(get_post_type($post->ID) == 'post'){
                        $cats = get_the_category(); 
                        if(is_array($cats)){
                            foreach($cats as $cat){
                            $category .= '<a href="'.get_category_link($cat->term_id ).'">'.$cat->cat_name.'</a> ';
                            }
                        }
                    }
                    
                    $return .='</div>';
                    
                    $category='';
                    if(get_post_type($post->ID) == 'post'){
                        $cats = get_the_category(); 
                        if(is_array($cats)){
                            foreach($cats as $cat){
                            $category .= '<a href="'.get_category_link($cat->term_id ).'">'.$cat->cat_name.'</a> ';
                            }
                        }
                    }
                    
                    if(get_post_type($post->ID) == 'portfolio'){
                        $cats = get_the_category(); 
                        if(is_array($cats)){
                             $category .= '<div class="categories">';
                             $category .= get_the_term_list( $post->ID, 'portfolio-type', ' ', ' ', '' );
                             $category .= '</div>';
                        }
                    }
                    
                    
                    $return .='<div class="block_content">';
                    $return .='<h4 class="block_title"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h4>';
                    $return .='<div class="date"><small>'. get_the_time('F d,Y').''.((strlen($category)>2)? ' / '.$category:'').' / '.get_comments_number( '0', '1', '%' ).' Comments</small></div>';
                    $return .='<p class="block_desc">'.custom_excerpt($n,$post->ID).'</p>';
                    $return .='</div>';
                    $return .='</div>';
                break;    
            case 'images_only':
                    $return .='<div class="block">';
                    $return .='<div class="block_media images_only">';
                    if(isset($link) && $link)
                        $return .='<span class="overlay"></span>';
                    
                    if(isset($link) && $link)
                    $return .= '<a href="'.get_permalink($post->ID).'" class="hover-link link"><i class="icon-link"></i></a>';
                    
                    if(isset($zoom) && has_post_thumbnail($post->ID) && $zoom )
                    $return .= '<a href="'.wp_get_attachment_url( get_post_thumbnail_id($post->ID),$cols ).'" class="hover-link pop" rel="prettyPhoto[pp_gal]"><i class="icon-resize-full"></i></a>';
                    $return .= featured_component($post->ID,$cols);
                    $return .='</div>';
                    $return .='</div>';
                break;
            case 'testimonial':
                    $return .='<div class="block testimonials">';
                
                    $author=  getPostMeta($post->ID,'vibe_testimonial_author_name'); 
                    $designation=getPostMeta($post->ID,'vibe_testimonial_author_designation'); 
                    $image=getPostMeta($post->ID,'vibe_testimonial_author_image'); 
                    
                    if(get_post_type($post->ID) == 'agent'){
                        $author=  get_the_title($post->ID); 
                    $designation=''.getPostMeta($post->ID,'vibe_agent_phone').' / '.getPostMeta($post->ID,'vibe_agent_email'); 
                    $image=getPostMeta($post->ID,'vibe_agent_image'); 
                    }
                    if(wp_attachment_is_image($image)){
                        $image= wp_get_attachment_image_src ($image);
                        $image= $image[0];
                        }
                    $return .= '<div class="testimonial_item style2 clearfix">
                                    <img src="'.$image.'" class="author-image animate zoom" alt="testimonial author"/>
                                    <div class="testimonial-content">    
                                        <p>'.custom_excerpt($n,$post->ID).$read_more.'</p>
                                       <div class="author">
                                          <h4>'.html_entity_decode($author).'</h4>
                                          <small>'.html_entity_decode($designation).'</small>
                                        </div>     
                                    </div>        
                                    
                                </div>';
                    $return .='</div>';
                break;
             case 'blogpost':
                    $return .='<div class="block blogpost">';
                    $return .= '<div class="blog-item">
                                <div class="blog-item-date">
                                    <span class="day">'.get_the_time('d').'</span>
                                    <span class="month">'.get_the_time('M').'</span>
                                </div>
                                <h4><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h4>
                                <p>'.custom_excerpt($n,$post->ID).'</p>
                                </div>';
                    $return .='</div>';
                break;   
             case 'listing':
                   global $vibe_options;
                    
                    $cols='medium';

                    $onsale ='';
                     $terms = wp_get_post_terms( $post->ID, 'status');
                     if(isset($terms) && is_array($terms)){
                     foreach($terms as $term){
                         $onsale = '<span class="'.$term->slug.'">'.$term->name.'</span>';
                     }}
                     
                   $return .='<div class="block listing">';
                    $return .='<div class="block_media">'.$onsale;
                    
                    if(isset($link) && $link)
                    $return .= '<a href="'.get_permalink($post->ID).'" class="hover-link link"><i class="icon-link"></i></a>';
                   // $featured= getPostMeta($post->ID, 'vibe_select_featured');
                    if(isset($zoom) && $zoom && has_post_thumbnail($post->ID) )
                    $return .= '<a href="'.wp_get_attachment_url( get_post_thumbnail_id($post->ID),$cols ).'" class="hover-link pop" rel="prettyPhoto[pp_gal]"><i class="icon-resize-full"></i></a>';
                    
                    
                    $link_media=vibe_get_option('link_media');
                    switch($link_media){
                        case 1:
                            $return .='<a href="'.get_permalink($post->ID).'">'.featured_component($post->ID,$cols).'</a>';
                        break;
                        case 2:
                        
                        $img_url=wp_get_attachment_url( get_post_thumbnail_id($post->ID),'full');
                        
                            $return .='<a href="'.$img_url.'" data-rel="prettyPhoto[gal]">'.featured_component($post->ID,$cols).'</a>';
                        break;
                        default:
                            $return .=featured_component($post->ID,$cols);
                        break;
                    }
                    
                    
                    $featured='';
                                              if(isset($vibe_options['listing_fields']['field_type'])){
                                                  $i = array_search('featured',$vibe_options['listing_fields']['field_type']);
                                                  if(isset($i)){
                                                      $key = 'vibe_'.strtolower(str_replace(' ', '-',$vibe_options['listing_fields']['label'][$i]));
                                                      $featured = getPostMeta($post->ID,$key);
                                                  }
                                              }
                                              
                     if(isset($featured) && $featured == 1){
                         $return .= '<span class="vfeatured"><i class="icon-star" data-rel="tooltip" data-original-title="'.$vibe_options['listing_fields']['label'][$i].'" data-placement="left"></i></span>';
                     }
                     
                    
                     
                    $return .='</div>';
                    
                    $category='';
                    if(get_post_type($post->ID) == 'post'){
                        $cats = get_the_category(); 
                        if(is_array($cats)){
                            foreach($cats as $cat){
                            $category .= '<a href="'.get_category_link($cat->term_id ).'">'.$cat->cat_name.'</a> ';
                            }
                        }
                    }
                    
                    
                    $return .='<div class="block_content">';
                    $return .='<h4 class="block_title"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h4>';
                    if(isset($vibe_options['listing_fields']['feature']) && is_array($vibe_options['listing_fields']['feature'])){
                        $return .= '<ul class="listing_fields">';
                        
                        $return .= '<li class="primary_info">'.get_the_term_list( $post->ID, $vibe_options['primary_listing_parameter'], ' ', ', ', '' ).'</li>'; 
                        foreach($vibe_options['listing_fields']['feature'] as $k=>$value){

                                if(isset($value) && $value){
                                    $label = $vibe_options['listing_fields']['label'][$k];
                                    $class = $vibe_options['listing_fields']['class'][$k];
                                    $field = $vibe_options['listing_fields']['field_type'][$k];
                                    $key = 'vibe_'.strtolower(str_replace(' ', '-',$vibe_options['listing_fields']['label'][$k]));
                                    
                                    if($field == 'select'){
                                        $selectlabel = explode('|',$label);
                                        $vars=explode('|',$key);
                                        if(isset($vars[1])){
                                            $val=getPostMeta($post->ID,$vars[0]);
                                            if(isset($val) && $val)
                                            $return .= '<li class="on"><label><i class="'.$class.'"></i> '.$selectlabel[0].'</label><span>'.$val.'</span></li>';
                                        }
                                    }elseif($class == 'price'){
                                       $return .= '<li class="price"><span class="currency">'.(isset($vibe_options['currency'])?'<i class="'.$vibe_options['currency'].'"></i>':'$').' '.getPostMeta($post->ID,$key).'</span></li>';  
                                       }elseif($class == 'address' || $field == 'available' || $field == 'location' || $field == 'checkbox' || $field == 'featured'){
                                    }else{
                                        $v=getPostMeta($post->ID,$key);
                                        if(!is_array($v) && isset($v) && $v)
                                        $return .= '<li class="on"><i class="'.$class.'"></i><label> '.$label.'</label><span>'.$v.' '.(($class == 'area')?$vibe_options['area']:'').'</span></li>'; 
                                    }
                                  }   
                                }
                                $return .= '</ul>';
                             }
                    $return .='</div>';
                    $return .='</div>';
                break; 
               
            default:
                   $return .='<div class="block">';
                    $return .='<div class="block_media">';
                    
                    if(isset($link) && $link)
                    $return .= '<a href="'.get_permalink($post->ID).'" class="hover-link link"><i class="icon-link"></i></a>';
                    $featured= getPostMeta($post->ID, 'vibe_select_featured');
                    if(isset($zoom) && $zoom && has_post_thumbnail($post->ID) )
                    $return .= '<a href="'.wp_get_attachment_url( get_post_thumbnail_id($post->ID),$cols ).'" class="hover-link pop" rel="prettyPhoto[pp_gal]"><i class="icon-resize-full"></i></a>';
                    
                    
                    $return .= featured_component($post->ID,$cols);
                    
                    $category='';
                    if(get_post_type($post->ID) == 'post'){
                        $cats = get_the_category(); 
                        if(is_array($cats)){
                            foreach($cats as $cat){
                            $category .= '<a href="'.get_category_link($cat->term_id ).'">'.$cat->cat_name.'</a> ';
                            }
                        }
                    }
                    
                    $return .='</div>';
                    
                    $category='';
                    if(get_post_type($post->ID) == 'post'){
                        $cats = get_the_category(); 
                        if(is_array($cats)){
                            foreach($cats as $cat){
                            $category .= '<a href="'.get_category_link($cat->term_id ).'">'.$cat->cat_name.'</a> ';
                            }
                        }
                    }
                    
                    if(get_post_type($post->ID) == 'portfolio'){
                        $cats = get_the_category(); 
                        if(is_array($cats)){
                             $category .= '<div class="categories">';
                             if (!is_wp_error( get_the_term_list( $post->ID, 'portfolio-type', ' ', ' ', '' ) ) ) {
                             $category .= get_the_term_list( $post->ID, 'portfolio-type', ' ', ' ', '' );
                             }
                             $category .= '</div>';
                        }
                    }
                    
                    
                    $return .='<div class="block_content">';
                    $return .='<h4 class="block_title"><a href="'.get_permalink($post->ID).'" title="'.$post->post_title.'">'.$post->post_title.'</a></h4>';
                    $return .='<div class="date"><small>'. get_the_time('F d,Y').''.((strlen($category)>2)? ' / '.$category:'').' / '.get_comments_number( '0', '1', '%' ).' Comments</small></div>';
                    $return .='<p class="block_desc">'.custom_excerpt($n,$post->ID).'</p>';
                    $return .='</div>';
                    $return .='</div>';
                break;
            
        }
        return $return;
    }
}    


//*=== Featured Component ===*//

function featured_component($post_id,$cols='',$style=''){
global $vibe_options;

if(!in_array($cols,array('big','small','medium','mini','full'))){
    switch($cols){
      case '2':{ $cols = 'big';
      break;}
      case '3':{ $cols = 'medium';
      break;}
      case '4':{ $cols = 'medium';
      break;}
      case '5':{ $cols = 'small';
      break;}
       case '6':{ $cols = 'small';
      break;}  
      default:{ $cols = 'full';
      break;}
    }
}
        $post_thumbnail='';
        $featured= getPostMeta($post_id, 'vibe_select_featured');
        $flag=1; 
            if(isset($featured) && $featured && $featured != 'disable'){
                switch($featured){
                    case 'video':{
                        
                        $video=  getPostMeta($post_id, 'vibe_featuredvideo');
                        
                        $video = video('',$video);
                        
                        return $video;
                             break;} 
                    case 'iframevideo':{
                        $video=  getPostMeta($post_id, 'vibe_featurediframevideo');
                             $video=  '<div class="fit_video">'.html_entity_decode($video).'</div>';
                        return $video;
                             break;}          
                    case 'other':{
                        $other=  getPostMeta($post_id, 'vibe_featuredother');
                        $other=str_replace('&#039;','\'',$other);
                        $other=str_replace('&quot;','"',$other);
                        $other= do_shortcode($other);
                       
                        $other=  '<div class="fitother '.$style.'">'. $other . '</div>';
                        return $other;
                             break;}          
                    case 'audio':{
                        $audio_content=  getPostMeta($post_id, 'vibe_featured_audio');
                        
                        $audio_files=explode(',',$audio_content);
                        $audio ='<div class="fitaudio '.$style.'">'.get_the_post_thumbnail($post_id,$cols).'
                        <div class="audio_player"><audio preload="auto" controls>';
                        foreach($audio_files as $audio_file){
                        			$audio .='<source src="'.wp_get_attachment_url($audio_file).'">';
                        		}
                        					$audio .='</audio></div></div>';
                        return $audio;
                            break;}
                    case 'gallery':{ 
                            $slider=  getPostMeta($post_id, 'vibe_slider');
                            return featured_carousel($slider,$cols,$style);
                    }
                }
            }else{
                if(has_post_thumbnail($post_id)){
                    $post_thumbnail=  get_the_post_thumbnail($post_id,$cols);
                    }else{
                        if(isset($vibe_options['default_image']) && $vibe_options['default_image'])
                            $post_thumbnail='<img src="'.$vibe_options['default_image'].'" alt="'.the_title().'" />';
                    }
                   //$post_thumbnail=preg_replace('/class=".*?"/', '', $post_thumbnail);
                    
                return $post_thumbnail;
            }
}        

if(!function_exists('featured_carousel')){
    function featured_carousel($slider,$columns='medium',$style=''){
        global $vibe_options;
        $slider = explode(',',$slider);
        $slides_count=(count($slider) -1);
    $slider_html=''; 
     $thumb_html='';

    $id='post_slider'.rand(1,999);
    $slider_html.= '<div id="'.$id.'" class="thumb_slider carousel slide '.$style.'">';
      
    if($vibe_options['thumb_slider_buttons']){
        $first='active';	
        $slider_html.= '<ol class="carousel-indicators middle">';
        $i=0;
     foreach($slider as $slide){ 
        if(isset($slide)){   
                $slider_html.= '<li data-target="#'.$id.'" data-slide-to="'.$i.'" class="'.$first.'"></li>'; 
                $first = '';
                $i++;
            }
        }
      $slider_html.= '</ol>';
    }
    $slider_html.= '<div class="carousel-inner">';
    $first='active';
    $i=0;	 
    foreach($slider as $slide){ 
     if(isset($slide)){   
     
    $image_attributes = wp_get_attachment_image_src( $slide,$columns);
    $info =wp_get_attachment_info($slide);

   
    $link_media=vibe_get_option('link_media');
                    
    switch($link_media){
        case 1:
            $href=get_permalink(get_the_ID());
        break;
        case 2:
            $href=$image_attributes[0];
        break;
        default:
            $href='#';
        break;
    }

    $href= apply_filters('vestate_link_filter',$href);
    
    $show_title = vibe_get_option('show_title');
    if(isset($image_attributes[0])){
       $slider_html.= '<div class="'.$first.' item">
  			 '.(isset($image_attributes[0])? '<a href="'.$href.'" '.((isset($link_media) && $link_media ==  2)?'data-rel="prettyPhoto[gal]"':'').'><img src="'.$image_attributes[0].'" alt="'.$info['alt'].'" '.((isset($show_title) && $show_title)?'title="'.$info['title'].'"':'').' /></a>': '').'
  			</div>';

        $thumb_html .=  '<li><a id="carousel-selector-'.$i.'"><img src="'.$image_attributes[0].'" alt="'.$info['alt'].'" width="80" title="'.$info['title'].'" /></a></li>'; 

        $first='';
        }
     }
     $i++;
    }
    $slider_html.= ' </div>
            '.(($vibe_options['thumb_slider_arrows'] != 0)?'
                    <!-- Carousel nav -->
  		<a class="carousel-control left" href="#'.$id.'" data-slide="prev"><span><i class="icon-left-open-big"></i></span></a>
  		<a class="carousel-control right" href="#'.$id.'" data-slide="next"><span><i class="icon-right-open-big"></i></span></a>':'').'
  	';

    if($style=='thumb'){
        $slider_html .='<ul class="list-inline loading">';

        $slider_html .=$thumb_html;
        
        $slider_html .='</ul>';    
    }
    $slider_html.= ' </div>';
    
    return($slider_html);
    }
}



// Video Short Code
if (!function_exists('video')) {
	function video( $atts, $content = null ) { 
             extract(shortcode_atts(array(
			'webm'   => '',
                        'ogv' =>'',
                        'mp4'=>''
                            ), $atts));
             
                $i = strpos($content,'iframe');
                    if($i != false){
                    $video=  '<div class="fit_video">'.html_entity_decode($content).'</div>';
                    return $video;
                    }
                    
               $video_vars=explode(',',$content);
              
               if((isset($webm) && $webm !='') || (isset($ogv) && $ogv !='') || (isset($mp4) && $mp4 !='')){
                   $mp4_source = $mp4;
                   $webm_source = $webm;
                   $ogg_source = $ogv;
               }else{
               
               foreach($video_vars as $video_urls){
                   
                   $video_urls = wp_get_attachment_url($video_urls);
                   $video_urls=trim($video_urls);
                   
                        if(preg_match_all('/^.*\.mp4$/i' , $video_urls , $mp4matches)){
                           $mp4_source=  $video_urls; // .mp4
                       }else{
                           
                            
                               if(preg_match_all('/^.*\.webm$/i' , $video_urls , $webmmatches)){
                                   $webm_source=  $video_urls ;   // .Webm
                               }else{
                               
                                   if(preg_match_all('/^.*\.ogv$/i' , $video_urls , $ogvmatches)){
                                       $ogg_source =  $video_urls;   // .OGV
                                   }
                                   else{
                                        if(preg_match_all('/^.*\.vtt$/i' , $video_urls , $trackmatches)){
                                            $track=$video_urls;
                                        }
                               }
                         
                            }
                        }
                 
               }//end-For
               }
               
               $image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
               $id= 'vibevideo'.rand(1,999);
                $video = '<!-- Begin Video -->
                   <div class="videoWrapper">
                   <video id="'.$id.'" class="video-js vjs-default-skin" controls preload="auto" poster="'.$image[0].'" data-setup="{}">
                         '.(empty($mp4_source)?'':'<source src="'.$mp4_source.'" type="video/mp4"/>').'
                         '.(empty($webm_source)?'':'<source src="'.$webm_source.'" type="video/webm"/>').'
                         '.(empty($ogg_source)?'':'<source src="'.$ogg_source.'" type="video/ogg" />').'    
                         '.(empty($track)?'':'<track kind=captions src="'.$track.'" />').'    
                         </video>
                         </div>';
                global $vibe_post_script;
           if(!$image[1])
              $ar=0.66;
           else 
             $ar = round(($image[2]/$image[1]),2);
           
           echo'<script>
               if(typeof players != "undefined")
               players.push("'.$id.'");
                   if(typeof aspectRatio != "undefined")
               aspectRatio.push('.$ar.'); 
                   </script>';                
         
                return $video;
	}
	add_shortcode('video', 'video');
}


function generate_likeviews($likes,$post_id){
    global $vibe_options;
    $return = '';
    
    if(isset($vibe_options['enable_likes']) && $vibe_options['enable_likes'])
    $return .='<p class="meta_info"><a class="like" id="'.$post_id.'" rel="tooltip" data-placement="top" data-original-title="Likes"><i class="icon-heart"></i> '.(isset($likes)?$likes:'0').'</a></p>';
    
    return $return;
}
?>