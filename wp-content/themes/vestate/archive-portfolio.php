<?php

/**
 * FILE: archive-portfolio.php 
 * Created on Jun 20, 2013 at 7:28:16 PM 
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
$current = '';
    $current_term = single_term_title($current, false);

    if(is_archive()){
       $current_term = single_month_title('', false);
    }
    
    if(!isset($current_term) || $current_term == '')
        $current_term = 'Portfolio';

?>
<section class="subheader">
    <div class="container">
        <div class="row">
            <div class="span8">
               <h1 id="page_title"><?php 
                   echo $current_term;
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
               <div class="span12">
                    <div class="pagecontent">
                        <div class="vibe_post_grid ">
                            <div class="vibe_grid  masonry">
                                
                                <div class="vibe_grid masonry" data-paged="<?php echo $paged; ?>">
                                     <ul class="grid masonry" data-width="370" data-gutter="30">
                        <?php
                           
                            if (have_posts()) : 
                            while (have_posts()) : the_post(); 
                            global $post;
                                echo '<li class="medium grid-item" style="width:370px;margin-bottom:30px;">';
                                echo  thumbnail_generator($post,'hover',3,0,0,0);
                                echo '</li>';
        
                            endwhile;
                            endif;
                            ?>
                                         
                            </ul>
                           <?php
                            pagination();
                            ?>    
                    </div>    
                </div> 
            </div>
	</div>
               </div>
            </div>  
</section>  
<?php
get_footer();
?>