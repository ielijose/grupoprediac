<?php

/**
 * FILE: listing_search.php 
 * Template Name: Listing Search Results
 * Created on Aug 14, 2013 at 2:37:23 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate 
 * License: GPLv2
 */


global $vibe_options;

get_header($vibe_options['header_style']);

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 


     $args =array('post_type'=>LISTING,'paged'=>$paged);
    if(isset($vibe_options['listing_taxonomies']['search']) && is_array($vibe_options['listing_taxonomies']['search'])){
             foreach($vibe_options['listing_taxonomies']['search'] as $key => $value){              
                            $slug=$vibe_options['listing_taxonomies']['slug'][$key];
                            
                            if(isset($_GET[$slug])){
                                if(is_array($_GET[$slug]))
                                    $var = implode(',',$_GET[$slug]);
                                else
                                    $var = $_GET[$slug];
                                $args[$slug]=$var;
                            }
               }
         }

    

    if(isset($_GET['id_'])){ 
      $id_enable = $_GET['id_'];
        $i=0;
      foreach($vibe_options['listing_fields']['field_type'] as $k=>$value){ 
        if($value == 'id'){
            $label = $vibe_options['listing_fields']['label'][$k];
            $key=strtolower(str_replace(' ', '-',$label));
            $meta_args[$i]['key']='vibe_'.$key;
            $meta_args[$i]['value']=$_GET[$key];
            $meta_args[$i]['compare']='LIKE';
        }
        $i++;
      }

      $args['meta_query']= $meta_args;
   }

   if(isset($_GET['orderby']) && $_GET['orderby'] == 'price'){
    $args['meta_key']= 'vibe_price';
    $args['orderby'] = 'meta_value';
    $args['order'] = $_GET['order'];
   }

   if(isset($_GET['s']) && $_GET['s'] !=''){
      $args['s']=$_GET['s'];
   }
   if(isset($_GET['keywords']) && $_GET['keywords'] !=''){
      $args['s']=$_GET['keywords'];
   }
   global $wp_query;
   query_posts($args);
   $total_results = $wp_query->found_posts;
?>

<!-- ================================================== -->
<!-- =================  CONTENT   ===================== -->
<!-- ================================================== -->
<section class="subheader">
    <div class="container">
        <div class="row">
            <div class="span8">
               <h1 id="page_title"><?php 
               if(isset($total_results)){
                   _e('Search Results', 'vibe'); the_search_query(); echo ' ('.$total_results.' '.__('results found','vibe').')'; 
               }else{
                  _e('Results','vibe'); 
               }
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
                                </select>
                                <?php
                                
                               if(isset($vibe_options['listing_taxonomies']['search']) && is_array($vibe_options['listing_taxonomies']['search'])){
             foreach($vibe_options['listing_taxonomies']['search'] as $key => $value){   
                               $slug=$vibe_options['listing_taxonomies']['slug'][$key]; 
                                if(isset($_GET[$slug])){
                                    if(is_array($_GET[$slug])){
                                        foreach($_GET[$slug] as $location)
                                             echo '<input type="hidden" name="'.$slug.'[]" value="'.$location.'" />';
                                    }
                               }
                        }
                    }
                                ?>
                                
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
<?php
get_footer();
?>
