<?php

/**
 * FILE: portfolio-full.php 
 * Created on Jun 17, 2013 at 3:30:05 PM 
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
                        <?php
                            if(has_post_thumbnail() && $show['featured'])
                                echo '<div class="project_featured">'.featured_component(get_the_ID()).'</div>';
                          ?> 
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
               
