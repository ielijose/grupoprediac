<?php

/**
 * FILE: archive-agent.php 
 * Created on Aug 16, 2013 at 1:50:51 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate 
 * License: GPLv2
 */

global $vibe_options;
$vibe_options = get_option(THEME_SHORT_NAME);
get_header($vibe_options['header_style']);

$rand='subheader'.rand(1,999);

$show=array();
$show = get_show_values();
$post_type=  get_post_type();
$custom_subheader =get_subheader_values();
$custom_css = get_custom_css();

$inpage_menu=vibe_inpagemenu();
?>
<style>
<?php
    if(isset($vibe_options['custom_css_changes']) && in_array($post_type,$vibe_options['custom_css_changes'])){
       $custom_css = get_custom_css();  
    echo 'header{
        display: '.(($custom_css['header'])?'block':'none').';
    }';
    if(isset($custom_css['body_bg_image']) && strlen($custom_css['body_bg_image']) > 6 ){
    echo 'body{
        background-image: '.$custom_css['body_bg_image'].';
        '.$custom_css['body_css'].'
    }';
    }
    
    if(isset($custom_css['general_css']) && $custom_css['general_css'])
    echo $custom_css['general_css'];
    
    if(isset($custom_css['footer']) && $custom_css['footer']){
    echo 'footer{
         display: '.(($custom_css['footer'])?'block':'none').';
        }';
        }
    }
    

    if(isset($vibe_options['subheader_css_changes']) && in_array($post_type,$vibe_options['subheader_css_changes'])){
       echo '#'.$rand.', .boxed #'.$rand.' .container{
          '.(isset($custom_subheader['subheader_bg_color'])?'background-color:'.$custom_subheader['subheader_bg_color'].';':'').'
         '.((isset($custom_subheader['subheader_bg_image']) && strlen($custom_subheader['subheader_bg_image']) > 6)?'background-image: '.$custom_subheader['subheader_bg_image'].'':'').
            ''.$custom_subheader['subheader_css'].' }';
    
    
    echo  '#'.$rand.' ul.breadcrumbs,
         #'.$rand.' h1,
         #'.$rand.' h5,
         #'.$rand.' a{color:'.$custom_subheader['subheader_color'].';}';
    }
   
    ?>
</style>
<?php
    if($show['subheader']){
?>
<section id="<?php echo $rand; ?>" class="subheader">
    <div class="container">
        <div class="row">
            <div class="<?php echo $show['headingspan']; ?>">
                <?php if($show['title']){ ?>
               <h1 id="page_title"><?php the_title(); ?></h1> 
               <?php 
                        }
                     if(strlen($custom_subheader['subtitle'])>2){
                         $subtitle=html_entity_decode($custom_subheader['subtitle']);
                        if(!(strcmp( $subtitle, strip_tags($subtitle) ) == 0)){
                            echo $subtitle;
                        }else {
                          echo '<h5>'.$custom_subheader['subtitle'].'</h5>';  
                        }
                    }
                 if($show['prev_next']){ 
                            ?>
                            <div class="prev_next_links">
                                <div class="prev_next">
                                <?php 
                                previous_post_link('%link', '<i class="icon-left-open-mini"></i>');
                                next_post_link('%link', '<i class="icon-right-open-mini"></i>');
                                ?>
                                </div>    
                            </div>
                            <?php
                            }
                            ?>
            </div>
            <?php
             if($show['breadcrumbs']){
            ?>
            <div class="span4">
                    <?php 
                       if (function_exists('vibe_breadcrumbs')) 
                        vibe_breadcrumbs(); 
                       ?>   
            </div>
        </div>      
    </div>
    <?php
                } //Hide Show BreadCrumbs
                if($inpage_menu){
                    $inclass='';
                    if(isset($vibe_options['nav_fix']) && !$vibe_options['nav_fix'])
                      $inclass='fixtop';
                    
            ?>
           <div class="inpage_menu <?php echo $inclass; ?>">
               <div class="container">
                   <div class="row">
                        <div class="span12">
                            <ul class="in_menu">
                            <?php
                                    foreach($inpage_menu as $key=>$item){
                                    echo '<li><a href="#'.$key.'">'.$item.'</a></li>';
                                    }
                                ?>
                            </ul>
                        </div> 
                    </div>    
                   </div>    
               </div>    
            <?php
                }
            ?>
</section> 
<?php
}
?>

<section class="main">
	<div class="container">
            <div class="row">
               <div class="span12">
                    <div class="pagecontent">
                        <div class="vibe_post_grid ">
                            <div class="vibe_grid  masonry">
                                
                                <div class="vibe_grid masonry" data-paged="<?php echo $paged; ?>">
                                     <ul class="grid masonry" data-width="290" data-gutter="20">
                        <?php
                            if (have_posts()) : 
                            while (have_posts()) : the_post(); 
                            global $post;
                                $phone=  getPostMeta($post->ID,'vibe_agent_phone'); 
                                $email=getPostMeta($post->ID,'vibe_agent_email'); 
                                $image=getPostMeta($post->ID,'vibe_agent_image');
                                if(wp_attachment_is_image($image)){
                                    $image= wp_get_attachment_image_src ($image);
                                    $image= $image[0];
                                }
                                $more = __('Read more','vibe');
                                
                                $read_more= '<a href="'.get_permalink().'" class="primary"><small>'.$more.'</small></a>';
    
    
                                echo '<li class="medium grid-item" style="width:290px;margin-bottom:20px;">';
                                echo '<div class="block">
                                        <div class="block_media">';
                                echo featured_component(get_the_ID(),3);
                                echo '</div><div class="block_content">';
                                echo '<h4 class="block_title"><a href="'.get_permalink($post->ID).'" title="'.get_the_title().'">'.get_the_title().'</a></h4>';
                                echo '<p class="block_desc italics">'.custom_excerpt(200,$post->ID).$read_more.'</p>';
                                echo '<div class="testimonial_post">
                                        <img src="'.$image.'" class="animate zoom" alt="testimonial author"/>
                                          <h4>'.get_the_title().'</h4>
                                          <small><i class="icon-mobile"></i> '.$phone.'</small>
                                              <small><i class="icon-email"></i> '.$email.'</small>
                                        </div>';
                                echo '</div></div>';
                                echo '</li>';
        
                            endwhile;
                            endif;
                            ?>
                                         
                            </ul>
                           <?php
                            pagination();
                            ?>    
                    </div>    
                </div> 
            </div>
	</div>
</section>  
<?php
get_footer();
?>