<?php

/**
 * FILE: single-agent.php 
 * Created on Aug 16, 2013 at 2:16:51 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate 
 * License: GPLv2
 */

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

global $vibe_options;
$vibe_options = get_option(THEME_SHORT_NAME);
get_header($vibe_options['header_style']);

$rand='subheader'.rand(1,999);



$pageid=get_the_ID();
?>
<section id="<?php echo $rand; ?>" class="subheader <?php echo $vibe_options['header_style']; ?>">
    <div class="container">
        <div class="row">
            <div class="span8">
                
               <h1 id="page_title"><?php the_title(); ?></h1> 
               <?php 
                    echo '<h5>'.$custom_subheader['subtitle'].'</h5>';  
                ?>    
                <div class="prev_next_links">
                    <div class="prev_next">
                    <?php 
                    previous_post_link('%link', '<i class="icon-left-open-mini"></i>');
                    next_post_link('%link', '<i class="icon-right-open-mini"></i>');
                    ?>
                    </div>    
                </div>
            </div>
            <div class="span4">
                    <?php 
                       if (function_exists('vibe_breadcrumbs')) 
                        vibe_breadcrumbs(); 
                       ?>   
            </div>
        </div>      
    </div>
</section> 
<section class="main">
	<div class="container">
            <div class="row">
             <?php
              if (have_posts()) : 
                    while (have_posts()) : the_post(); 
                 ?>
                <div class="span8">
                   <div class="post_featured">
                        <?php
                                echo featured_component(get_the_ID());
                       ?>
                   </div>   
                   <div class="pagecontent">
                         <?php
                           the_content();
                           $image=getPostMeta($id,'vibe_agent_image'); 
                                if(wp_attachment_is_image($image)){
                                    $image= wp_get_attachment_image_src ($image);
                                $image= $image[0];
                                }
                                $name= get_the_title();
                          ?>
                       <div class="post_author">
                                <div class="author_image">
                                    <img src="<?php echo $image; ?>" alt="Agent image" />
                                </div>
                                <div class="author_description">
                                    
                                    <h4><?php the_title(); ?></h4>
                                    <h5><span><i class="icon-mail-2"></i><?php echo getPostMeta(get_the_ID(),'vibe_agent_email').' , <i class="icon-mobile"></i>'.getPostMeta(get_the_ID(),'vibe_agent_phone'); ?></span></h5>
                                    <div class="auth_description"><?php echo do_shortcode(get_the_author_meta('description',getPostMeta(get_the_ID(),'vibe_agent_id'))); ?></div>
                                </div>
                            <?php
                           endwhile;
                           endif;
                            ?>
                       </div>
                       <div class="agent_listings">
                           <?php
                           //wp_reset_query(); 
                           //$temp_query = $wp_query;
                            
                            
                          $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                            $args = array(
                                          'post_type' => 'listing',
                                          'author' => getPostMeta($pageid,'vibe_agent_id',true),
                                          'order' => 'DESC',
                                          'posts_per_page' => '6',
                                          'paged' => $paged
                                      );
                                       
                                  $the_query=new WP_Query($args);  
                                
                           ?>
                           <div class="vibe_post_grid ">
                               <h3 class="heading"><span><?php _e('Listings submitted by : ','vibe'); echo $name; ?></span></h3>
                            <div class="vibe_grid  masonry">
                                
                                <div class="vibe_grid inifnite_scroll masonry" data-page="<?php echo $paged; ?>">
                                      <?php

                                       $atts["title"]="Heading";
                                       $atts["show_title"]="0";
                                       $atts["post_type"]=LISTING;
                                       $atts["taxonomy"]="";
                                       $atts["term"]="nothing_selected";
                                       $atts["post_ids"]="null";
                                       $atts["featured_style"]="listing";
                                       $atts["masonry"]="1";
                                       $atts["grid_columns"]=" grid-item";
                                       $atts["column_width"]="192";
                                       $atts["gutter"]="20";
                                       $atts["grid_number"]="6";
                                       $atts["infinite"]="1";
                                       $atts["pagination"]="0";
                                       $atts["grid_excerpt_length"]="0";
                                       $atts["grid_lightbox"]="0";
                                       $atts["grid_link"]="0";

                                      echo '<div class="wp_query_args" data-max-pages="'.$the_query->max_num_pages.'">'.  json_encode($atts).'</div>';
                                      ?>
                                     <ul class="grid masonry" data-width="192" data-gutter="20">

                        <?php
                          
                            if ($the_query->have_posts()) : 
                            while ($the_query->have_posts()) : $the_query->the_post(); 
                            global $post;
                                echo '<li class="medium grid-item" style="width:192px;margin:0 20px 40px 0;">';
                                echo  thumbnail_generator($post,'listing',3,0,0,0);
                                echo '</li>';
        
                            endwhile;
                            echo '</ul>';
                            echo '<div class="load_grid"><span>'.__('Loading..','vibe').'</i></span></div>
                                  <div class="end_grid"><span>'.__('No more to load','vibe').'</i></span></div>';
                            ?>

                            <?php
                            //$wp_query = $the_query;
                            echo '<span class="clear"></span>';
                            endif;

                            //$wp_query = $temp_query;
                            ?>  
                                </div>    
                              </div> 
                            </div>
                       </div>
                   </div>   
                       
                    </div>
                    <div class="span4">
                        <div class="sidebar">
                        <?php 
                            if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('mainsidebar') ) : ?>
                        <?php endif; ?>
                        </div>
                    </div>  
            </div>
	</div>
</section>   
<?php
get_footer();
?>
