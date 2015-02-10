<?php

/**
 * FILE: listing-left.php 
 * Created on Aug 11, 2013 at 6:25:07 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate 
 * License: GPLv2
 */

global $vibe_options;

if (have_posts()) : 
    
  while (have_posts()) : the_post(); 
global $post;

$show=array();
$show = get_show_values();

                ?>
                
                <div class="span5 pull-right">
                        <div class="listing_featured">
                        <?php
                            if(has_post_thumbnail() && $show['featured']){
                              global $vibe_options;
                              $style='';
                              if(isset($vibe_options['thumbs_inlisting']) && $vibe_options['thumbs_inlisting']){
                                $style='thumb';
                              }
                                echo featured_component(get_the_ID(),'big',$style);
                              }  
                          ?>
                        </div> 
                </div>
                <div class="span4 pull-right">
                    <div class="listing_content">
                         <?php    
                           vibe_main_features();
                           ?>
                    </div>
                    <div class="listing_more">
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
                <div class="span9 pull-right">
                    <div id="listing_description_tabs" class="tabs tabbable">
                        <ul class="nav nav-tabs clearfix">
                            <li class="active">
                                <a href="#tab-description"><?php _e('Description','vibe')?></a>
                            </li>
                            <li>
                                <a href="#tab-features"><?php _e('Features','vibe')?></a>
                            </li>
                            <li>
                                <a href="#tab-contact"><?php _e('Contact Agent','vibe')?></a>
                            </li>
                        </ul>
                        <div class="tab-content"> 
                            <div id="tab-description" class="tab-pane active">
                                <?php   the_content(); ?> 
                            </div> 
                            <div id="tab-features" class="tab-pane">
                                <?php   vibe_listing_features(); ?> 
                            </div> 
                            <div id="tab-contact" class="tab-pane">
                                <?php   vibe_agent_contactform(); ?> 
                            </div> 
                        </div>
                    </div>
                </div>    
                    <?php
                        if(in_array('gmap', $vibe_options['listing_fields']['field_type'])){
                            $i = array_search('gmap', $vibe_options['listing_fields']['field_type']);
                              $key = 'vibe_'.strtolower(str_replace(' ', '-',$vibe_options['listing_fields']['label'][$i]));
                              $gmap=getPostMeta($post->ID,$key);
                          ?>
                <div class="span9 pull-right">
                    <div class="vibe_gmap">
                        <h3 class="heading"><span><?php 
                        echo $vibe_options['listing_fields']['label'][$i];
                        ?></span></h3>
                        <?php
                      echo '<script>
function initialize() {
  var myLatlng = new google.maps.LatLng('.$gmap['latitude'].','.$gmap['longitude'].');
  var mapOptions = {
    zoom: 15,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

  var marker = new google.maps.Marker({
      position: myLatlng,
      map: map,
      title: "Hello World!"
  });
}

google.maps.event.addDomListener(window, "load", initialize);

    </script> ';                        
                      ?>
                        <div id="map-canvas"></div>
                    </div>  
                  </div>   
                    <?php
                        }
                    endwhile;
                    endif;
                    wp_reset_query();
                  ?>
                  
                <div class="span9 pull-right">
                    <div class="related_listings">
                         <div class="vibe_carousel">
                        <?php
                        echo '<div class="listing_carousel vibe_carousel flexslider">
                               <h3 class="heading"><span>'.__('Related Listings','vibe').'</span></h3>
                                <ul class="slides">';
                        
                        $related_listings = array( 'post_type' => LISTING,'posts_per_page' => '8');
                        $query_args=apply_filters('vestate_related_listings',$related_listings);
                        $the_query = new WP_Query($query_args);
                        if( $the_query->have_posts() ) {
                            while ( $the_query->have_posts() ) : $the_query->the_post();
                            global $post;
                            echo '<li>';
                            echo thumbnail_generator($post,'listing','4',0,1,1);
                            echo '</li>';
                            endwhile;
                        }
                            echo '</ul>
                                  </div>';
                        ?>
                         </div>       
                   </div>     
                </div>
                <div class="span3">   
                    <div class="sidebar sidebar-left">
                        <?php 
                            if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar($show['sidebar']) ) : ?>
                        <?php endif; ?>
                    </div>
                </div> 


