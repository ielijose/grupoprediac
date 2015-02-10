<?php

/**
 * FILE: single-left.php 
 * Created on Feb 14, 2013 at 1:17:53 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */

if (have_posts()) : 
while (have_posts()) : the_post(); 
global $vibe_options;
$show=array();
$show = get_show_values();
                        ?>
                <div class="span8 pull-right">
                        <div class="post_featured">
                        <?php
                            if(has_post_thumbnail() && $show['featured'])
                                echo featured_component(get_the_ID());
                               
                            $postclasses = 'postcontent ';
                            if(!$show['meta']) $postclasses .='no-sharing ';
                             ?>
                        </div>    
                        <div <?php post_class($postclasses);  ?>>
                           <?php
                           if($show['meta']){
                            ?>
                                <div class="meta">
                                    <ul>
                                         <?php echo '<li><span>'.get_the_time('F d, Y').'</span></li>'; 
                                       if($show['comments']){
                                           echo '<li>';
                                           _e('Comments : ','vibe');
                                            echo '<span>';comments_number( '0', '1', '%' ) ;echo '</span>';
                                            echo '</li>';
                                       }
                                      
                                       if($show['author']==1){
                                           echo '<li>';
                                           _e('Posted By : ','vibe');
                                         echo '<span>'; the_author();echo '</span>';
                                          echo '</li>';
                                        
                                       }
                                       if($show['comments']){
                                           echo '<li>';
                                            _e('In Category : ','vibe');
                                               echo the_category(' ',','); 
                                           echo '</li>';    
                                       }
                                      ?>
                                    </ul>   
                                </div>  
                            <?php
                             }    
                           the_content();
                          if($show['author']){
                          ?>
                            
                            <div class="post_author">
                                <div class="author_image">
                                    <?php echo get_avatar( get_the_author_meta('email'), '70'); ?>
                                </div>
                                <div class="author_description">
                                    <h4><?php echo do_shortcode(get_the_author_meta('display_name')); ?></h4>
                                    <div><?php echo do_shortcode(get_the_author_meta('description')); ?></div>
                                </div>
                            </div>
                            <?php
                            }
                           ?>
                        </div>
                    <div class="post_more <?php if(!$show['sharing']) echo 'no-sharing'; ?>">
                        <div class="tags">
                              <?php 
                              if(get_the_tags()){
                              _e('Tags : ','vibe'); 
                              the_tags('',',');
                              }
                              ?>
                         </div>
                        <?php
                        if($show['comments']){
                            ?>
                        
                        <div class="post_sharing">
                                <?php
                                echo social_sharing();  
                                ?>  
                            </div>
                        <?php } ?>
                    </div>  
                    <?php
                            if($show['comments']){
                    ?>            
                    <div class="comments">
                        <?php
                            comments_template();
                        ?>
                    </div>    
                        <?php
                            } // End Comments Show
                           endwhile;
                           endif;
                     ?>
                    </div>
<div class="span4">
   <div class="sidebar sidebar-left">
   <?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar($show['sidebar']) ) : ?>
                        <?php endif; ?>
   </div>
</div>                      