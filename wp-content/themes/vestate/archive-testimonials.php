<?php

/**
 * FILE: archive-testimonials.php 
 * Created on Jun 27, 2013 at 6:08:35 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate 
 * License: GPLv2
 */


global $vibe_options;
$vibe_options = get_option(THEME_SHORT_NAME);
get_header($vibe_options['header_style']);

?>

<!-- ================================================== -->
<!-- =================  CONTENT   ===================== -->
<!-- ================================================== -->
<?php
?>
<section class="subheader">
    <div class="container">
        <div class="row">
            <div class="span8">
               <h1 id="page_title"><?php 
                   _e('ALL Testimonials','vibe');
               ?></h1> 
            </div>
            <div class="span4">
              <?php if (function_exists('vibe_breadcrumbs')) vibe_breadcrumbs(); ?>   
            </div>
        </div>      
    </div>
</section> 
<section class="main">
	<div class="container">
            <div class="row">
               
                    <div class="content">
                        <?php
                           if (have_posts()) : 
                           while (have_posts()) : the_post(); 
                           $show = get_show_values(get_the_ID());
                            ?>
                        <div class="testimonial_row">
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
                        <article>
                                <div class="post_title">
                                    <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
                                </div>
                                <div class="excerpt">
                                <?php
                                    $len = isset($vibe_options['large_posts_excerpt'])?$vibe_options['large_posts_excerpt']:200;
                                    echo custom_excerpt($len);
                                    ?>
                                </div>    
                        </article>
                        </div> 
                        </div>     
                        <?php
                        
                        endwhile;
                        endif;
                        ?>
                        <div class="span12">
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

