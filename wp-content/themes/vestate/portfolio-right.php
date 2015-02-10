<?php

/**
 * FILE: portfolio-right.php 
 * Created on Jun 17, 2013 at 3:29:53 PM 
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
                <div class="span8">
                        <div class="project_featured">
                        <?php
                            if(has_post_thumbnail() && $show['featured'])
                                echo featured_component(get_the_ID());
                          ?>
                        </div> 
                </div>
                <div class="span4">
                    <div class="project_content">
                         <?php    
                           the_content();
                           ?>
                    </div>
                    <div class="project_more">
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
                <div class="span12">
                    <div class="recent_projects">
                        <div class="vibe_carousel">
                        <?php
                        echo '<div class="project_carousel vibe_carousel carousel_columns4 flexslider">
                               <h3 class="heading"><span>'.__('Recent Projects','vibe').'</span></h3>
                                <ul class="slides">';
                        
                        $query_args=array( 'post_type' => 'portfolio','posts_per_page' => '5');
                        $the_query = new WP_Query($query_args);
                        if( $the_query->have_posts() ) {
                            while ( $the_query->have_posts() ) : $the_query->the_post();
                            global $post;
                            echo '<li>';
                            echo thumbnail_generator($post,'hover','4',0,1,1);
                            echo '</li>';
                            endwhile;
                        }
                            echo '</ul>
                                  </div>';
                        ?>
                        
                    </div>
                   </div>     
                </div>
               
