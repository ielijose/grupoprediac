<?php

/**
 * FILE: archive.php 
 * Created on May 15, 2013 at 8:10:26 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate 
 * License: GPLv2
 */

global $vibe_options;
$vibe_options = get_option(THEME_SHORT_NAME);
get_header($vibe_options['header_style']);
$show = get_show_values();
?>

<!-- ================================================== -->
<!-- =================  CONTENT   ===================== -->
<!-- ================================================== -->
<?php
$current ='';
    $current_term = single_term_title($current, false);

    if(is_archive()){
       $current_term = single_month_title('', false);
    }
    
    if(is_category()){
       $current_term = single_cat_title( '', false );
    }
    
    if(is_tag()){
       $current_term = single_tag_title( '', false );
    }
    
               if(isset($current_term) && $current_term !=''){
?>
<section class="subheader">
    <div class="container">
        <div class="row">
            <div class="<?php echo $show['headingspan']; ?>">
                <?php if($show['title']){ ?>
               <h1 id="page_title"><?php echo $current_term; ?></h1> 
               <?php 
                    }
                ?>
            </div>
            <?php
             if($show['breadcrumbs']){
            ?>
            <div class="span4">
                    <?php 
                       if (function_exists('vibe_breadcrumbs')) 
                        vibe_breadcrumbs(); 
                       ?>   
            </div>
        </div>      
    </div>
    <?php
                } //Hide Show BreadCrumbs
                 ?>
</section> 
<?php
               }
?>
<section class="main">
	<div class="container">
            <div class="row">
               <?php
               get_template_part('small', 'loop');
               ?>
                <div class="span4">
                    <div class="sidebar">
                        <?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('mainsidebar') ) : ?>
                                <?php endif; ?>
                    </div>
                </div> 
            </div>
	</div>
</section>  
<?php
get_footer();
?>
