<?php

/**
 * FILE: small-loop.php 
 * Created on Jul 17, 2013 at 7:18:48 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */
global $vibe_options;
?>
<div class="span8">
                    <div class="content">
                        <?php
                           if (have_posts()) : 
                           while (have_posts()) : the_post(); 
                           $show = get_show_values(get_the_ID());
                            ?>
                        <article>
                            <div class="post_thumb">
                                <?php
                                if($vibe_options['link_media']){
                                ?>
                                <a href="<?php the_permalink(); ?>">
                                <?php
                                    if(has_post_thumbnail() || $show['featured'])
                                    echo featured_component(get_the_ID());
                                  ?>
                                </a> 
                                <?php
                                }else
                                     echo featured_component(get_the_ID(),2);
                                ?> 
                            </div>
                            <div class="post_desc">
                                 <div class="meta">	
                                             <?php echo get_the_time('F j, Y');  _e(' in  ','vibe');
                                                    the_category(' ',', ');  ?>
                                  </div> 
                                <div class="post_title">
                                    <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
                                </div>
                                <div class="excerpt">
                                <?php
                                    $len = isset($vibe_options['small_posts_excerpt'])?$vibe_options['small_posts_excerpt']:200;
                                    echo custom_excerpt($len);
                                    ?>
                                    <a href="<?php the_permalink(); ?>"><?php _e('Read more','vibe'); ?></a>
                                </div>
                            </div>    
                        </article>
                        <?php
                        
                        endwhile;
                        endif;
                        
                        if(function_exists('pagination'))
                            pagination();
                        else
                            paginate_links();
                        ?>    
                    </div>    
                </div> 
