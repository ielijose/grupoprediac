<?php

/**
 * FILE: listing-full.php 
 * Created on Aug 11, 2013 at 6:24:52 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate 
 * License: GPLv2
 */

 
if (have_posts()) : 
    
  while (have_posts()) : the_post(); 
global $post;

$show=array();
$show = get_show_values();

                ?>
                <div class="span12">
                       <div class="listing_featured">
                        <?php
                            if(has_post_thumbnail() && $show['featured']){
                              global $vibe_options;
                              $style='';
                              if(isset($vibe_options['thumbs_inlisting']) && $vibe_options['thumbs_inlisting']){
                                $style='thumb';
                              }
                                echo featured_component(get_the_ID(),'big',$style);
                              }  
                          ?>
                        </div>
                </div>
                <div class="span12">
                    <div class="project_content">
                         <?php    
                           the_content();
                           ?>
                    </div>
                     <div class="project_more"">
                        <?php
                        if($show['sharing']){
                            ?>
                        
                        <div class="post_sharing">
                                <?php
                                echo social_sharing();  
                                ?>  
                            </div>
                        <?php } ?>
                    </div>  
                </div>    
                 <?php
                    endwhile;
                    endif;
                    wp_reset_query();
?>
