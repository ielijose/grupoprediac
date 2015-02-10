<?php

/**
 * FILE: category.php 
 * Created on Feb 13, 2013 at 7:12:22 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */

global $vibe_options;
get_header($vibe_options['header_style']);
$show = get_show_values();
?>

<!-- ================================================== -->
<!-- =================  CONTENT   ===================== -->
<!-- ================================================== -->
<?php
$current = (isset($vibe_options['browsing_text']) && $vibe_options['browsing_text'])?$vibe_options['browsing_text']:__('Currently Browsing: ','vibe');
    $current_term = single_term_title($current, false);
               if($current_term){
?>
<section class="subheader">
    <div class="container">
        <div class="row">
            <div class="span8">
               <h1><?php 
                   echo $current_term
               ?></h1> 
            </div>
            <div class="span4">
              <?php if (function_exists('vibe_breadcrumbs')) vibe_breadcrumbs(); ?>   
            </div>
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
                        $post_type=get_post_type();
                        $flag=0;
                        if(isset($vibe_options['large_posts'])){
                            if(in_array($post_type, $vibe_options['large_posts'])){
                                get_template_part( 'large', 'loop' );  
                                $flag=1;
                            }
                        }

                        if(isset($vibe_options['small_posts']) && !$flag){
                            if(in_array($post_type, $vibe_options['small_posts'])){
                                get_template_part( 'small', 'loop' );  
                                $flag=1;
                            }
                        }

                        if(isset($vibe_options['full_posts']) && !$flag){
                            if(in_array($post_type, $vibe_options['full_posts'])){
                                get_template_part( 'fullwidth', 'loop' );  
                                $flag=1;
                            }
                        }

                        if(!$flag){
                            get_template_part( 'large', 'loop' ); 
                        }


                ?>
            </div>
	</div>
</section>  
<?php
get_footer();
?>
