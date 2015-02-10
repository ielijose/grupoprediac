<?php

/**
 * FILE: archive-listing.php 
 * Created on Aug 8, 2013 at 4:28:10 PM 
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
        $current_term = 'Listings';

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
               <div class="span9 pull-right">
                    <div class="listingcontent">
                        <div class="sortorder">
                            <form id="sortform" method="get">
                                <select name="order">
                                    <option value="DESC" <?php (isset($_GET['order'])?selected('DESC',$_GET['order']):''); ?>><?php _e('Decreasing','vibe'); ?></option>
                                    <option value="ASC" <?php (isset($_GET['order'])?selected('ASC',$_GET['order']):''); ?>><?php _e('Increasing','vibe'); ?></option>
                                </select>
                                <select name="orderby">
                                    <option value="date" <?php (isset($_GET['orderby'])?selected('date',$_GET['orderby']):''); ?>><?php _e('Publish Date','vibe'); ?></option>
                                    <option value="title" <?php (isset($_GET['orderby'])?selected('title',$_GET['orderby']):''); ?>><?php _e('Title','vibe'); ?></option>
                                    <option value="price" <?php (isset($_GET['orderby'])?selected('price',$_GET['orderby']):''); ?>><?php _e('Price','vibe'); ?></option>
                               </select>
                            </form>
                            <p><?php
                                global $wp_query; 
                                    _e('Number of Listings found ','vibe');echo $wp_query->found_posts;
                                ?>
                            </p>
                        </div>    
                        <div class="vibe_post_grid ">
                            <div class="vibe_grid  masonry">
                                
                                <div class="vibe_grid masonry" data-paged="<?php echo $paged; ?>">
                                     <ul class="grid masonry" data-width="220" data-gutter="20">
                        <?php
                        
                            if (have_posts()) : 
                            while (have_posts()) : the_post(); 
                            global $post;
                                echo '<li class="medium grid-item" style="width:220px;margin:0 20px 40px 0;">';
                                echo  thumbnail_generator($post,'listing',3,0,0,0);
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
      <div class="span3">
         <div class="sidebar sidebar-left">
           <?php 
              if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('listing') ) : ?>
           <?php endif; ?>
         </div>
      </div>           
 </div>  
</section>  
<?php
get_footer();
?>