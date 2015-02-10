<?php

/**
 * FILE: search.php 
 * Created on Feb 13, 2013 at 7:12:22 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */

if (isset($_GET["post_type"]) && $_GET["post_type"] == LISTING){ 
    load_template(TEMPLATEPATH . '/listing_search.php'); 
    exit();
}
    
global $vibe_options;
get_header($vibe_options['header_style']);

global $wp_query;

if(isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['sort_by'][0])){
    
   
} 
$total_results = $wp_query->found_posts;
?>

<!-- ================================================== -->
<!-- =================  CONTENT   ===================== -->
<!-- ================================================== -->
<section class="subheader">
    <div class="container">
        <div class="row">
            <div class="span8">
               <h1 id="page_title"><?php _e('Search Results for ', 'vibe'); the_search_query(); echo ' ('.$total_results.' results found)'; ?></h1> 
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
                                    $len = isset($vibe_options['large_posts_excerpt'])?$vibe_options['large_posts_excerpt']:200;
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
                <div class="span4">
                    <div class="sidebar">
                        <?php if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('searchsidebar') ) : ?>
                                <?php endif; ?>
                    </div>
                </div>    
            </div>
	</div>
</section>  
<?php
get_footer();
?>