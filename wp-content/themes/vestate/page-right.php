<?php

/**
 * FILE: page.php 
 * Created on Feb 14, 2013 at 1:18:15 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */

                if (have_posts()) : 
                    while (have_posts()) : the_post(); 

                $show=array();
                $show = get_show_values();
                 ?>
                <div class="span8">
                   <div class="pagecontent">
                         <?php
                           the_content();
                          ?>
                   </div>   
                        <?php
                           endwhile;
                           endif;
                            ?>
                    </div>
                    <div class="span4">
                        <div class="sidebar">
                        <?php 
                            if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar($show['sidebar']) ) : ?>
                        <?php endif; ?>
                        </div>
                    </div>   