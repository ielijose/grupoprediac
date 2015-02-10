<?php

/**
 * FILE: single-testimonial.php 
 * Created on Jun 27, 2013 at 5:49:03 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate 
 * License: GPLv2
 */
global $vibe_options;
$vibe_options = get_option(THEME_SHORT_NAME);
get_header($vibe_options['header_style']);

$show=$custom_css=array();
$show = get_show_values();
$custom_subheader =get_subheader_values();

$rand='subheader'.rand(1,999);

$post_type=  get_post_type();
    if(isset($vibe_options['custom_css_changes']) && in_array($post_type,$vibe_options['custom_css_changes'])){
       $custom_css = get_custom_css(); 
    ?>

<style>
<?php
    echo 'header{
        display: '.(($custom_css['header'])?'block':'none').';
    }';
    if(isset($custom_css['body_bg_image']) && $custom_css['body_bg_image'] != 'url()'){
    echo 'body{
        background-image: '.$custom_css['body_bg_image'].';
        '.$custom_css['body_css'].'
    }';
    }
    
    if(isset($custom_css['subheader_bg_image']) && $custom_css['subheader_bg_image']!= 'url()'){
    echo '#'.$rand.', .boxed #'.$rand.' .container{
         background-color: '.$custom_subheader['subheader_bg_color'].';
         background-image: '.$custom_subheader['subheader_bg_image'].';
        '.$custom_subheader['subheader_css'].'
            }
         #'.$rand.' h1,
         #'.$rand.' h5,
         #'.$rand.' a{color:'.$custom_subheader['subheader_color'].';}   
         #'.$rand.' .container{background:transparent;}   
         ';
    };
    if(isset($custom_css['general_css']) && $custom_css['general_css'])
    echo $custom_css['general_css'];
    
    if(isset($custom_css['footer']) && $custom_css['footer']){
    echo 'footer{
         display: '.(($custom_css['footer'])?'block':'none').';
        }';
        }
?>
</style>
<?php
    }
if($show['subheader']){
?>
<section id="<?php echo $rand; ?>" class="subheader <?php echo $vibe_options['header_style']; ?>">
    <div class="container">
        <div class="row">
            <div class="<?php echo $show['headingspan']; ?>">
               <h1><?php the_title(); ?></h1> 
               <h3><?php if(strlen($custom_subheader['subtitle'])>2) echo $custom_subheader['subtitle']; ?></h3>
            </div>
            <?php
            if($show['breadcrumbs']){
            ?>
            <div class="span4">
                    <?php if (function_exists('vibe_breadcrumbs')) 
                        vibe_breadcrumbs(); ?>   
            </div>
            <?php
                } //Hide Show BreadCrumbs
            ?>
        </div>      
    </div>
</section> 
<?php
    }
?>
<section class="main">
	<div class="container">
            <div class="row">
                <?php 
               if (have_posts()) : 
                        while (have_posts()) : the_post(); 
                     
                     global $vibe_options;
                    $show=array();
                    $show = get_show_values();
                    
                     ?>
                <div class="span12">
                         <?php 
                            if($show['prev_next']){ 
                            ?>
                            <div class="prev_next_links">
                                <?php
                                        $likes=getPostMeta($post->ID,'like_count');
                                        //if(isset($vibe_options['enable_likes']) && $vibe_options['enable_likes'])
                                        echo '<a class="like" id="'.$post->ID.'" rel="tooltip" data-placement="top" data-original-title="Likes"><i class="icon-heart"></i> '.(isset($likes)?$likes:'0').'</a>';
                    
                                ?>
                                <div class="prev_next">
                                <?php 
                                previous_post_link('%link', '<i class="icon-left-open-mini"></i> Previous');
                                next_post_link('%link', 'Next <i class="icon-right-open-mini"></i>');
                                ?>
                                </div>    
                            </div>
                            <?php
                            }
                            ?>
                </div>
                <div class="pagecontent">
                <div class="span4">
                    <?php
                    $author=  getPostMeta($post->ID,'vibe_testimonial_author_name'); 
                    $designation=getPostMeta($post->ID,'vibe_testimonial_author_designation'); 
                    $image=getPostMeta($post->ID,'vibe_testimonial_author_image'); 
                    if(wp_attachment_is_image($image)){
                        $image= wp_get_attachment_image_src ($image);
                        $image= $image[0];
                        }
                    ?>
                    <div class="testimonial_author">
                        <img src="<?php echo $image; ?>" class="testimonial-author-image animate zoom" alt="testimonial author"/>
                        <h3><?php echo html_entity_decode($author); ?></h3>
                        <p><?php echo html_entity_decode($designation); ?></p>
                    </div>
                </div>
                <div class="span8">
                        <div class="postcontent no-sharing">
                         <?php
                           the_content();
                           ?>
                        </div>
                     
                        <?php
                           endwhile;
                           endif;
                            ?>
                    </div>
            </div>
                </div>
	</div>
</section>   

<?php
get_footer();
?>

