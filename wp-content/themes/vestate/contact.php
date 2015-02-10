<?php

/**
 * Template Name: Contact Page
 * FILE: contact.php 
 * Created on Jun 28, 2013 at 10:02:23 AM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate 
 * License: GPLv2
 */

global $vibe_options;
$vibe_options = get_option(THEME_SHORT_NAME);
get_header($vibe_options['header_style']);

$rand='subheader'.rand(1,999);

$show=array();
$show = get_show_values();
$post_type=  get_post_type();
$custom_subheader =get_subheader_values();
$custom_css = get_custom_css();

$inpage_menu=vibe_inpagemenu();

?>
<style>
<?php
    if(isset($vibe_options['custom_css_changes']) && in_array($post_type,$vibe_options['custom_css_changes'])){
       $custom_css = get_custom_css();  
    echo 'header{
        display: '.(($custom_css['header'])?'block':'none').';
    }';
    if(isset($custom_css['body_bg_image']) && strlen($custom_css['body_bg_image']) > 6 ){
    echo 'body{
        background-image: '.$custom_css['body_bg_image'].';
        '.$custom_css['body_css'].'
    }';
    }
    
    if(isset($custom_css['general_css']) && $custom_css['general_css'])
    echo $custom_css['general_css'];
    
    if(isset($custom_css['footer']) && $custom_css['footer']){
    echo 'footer{
         display: '.(($custom_css['footer'])?'block':'none').';
        }';
        }
    }
    

    if(isset($vibe_options['subheader_css_changes']) && in_array($post_type,$vibe_options['subheader_css_changes'])){
       echo '#'.$rand.', .boxed #'.$rand.' .container{
          '.(isset($custom_subheader['subheader_bg_color'])?'background-color:'.$custom_subheader['subheader_bg_color'].';':'').'
         '.((isset($custom_subheader['subheader_bg_image']) && strlen($custom_subheader['subheader_bg_image']) > 6)?'background-image: '.$custom_subheader['subheader_bg_image'].'':'').
            ''.$custom_subheader['subheader_css'].' }';
    
    
    echo  '#'.$rand.' ul.breadcrumbs,
         #'.$rand.' h1,
         #'.$rand.' h3,
         #'.$rand.' a{color:'.$custom_subheader['subheader_color'].';}';
    }
   
    ?>
</style>
<?php
    if($show['subheader']){
?>
<section id="<?php echo $rand; ?>" class="subheader <?php echo $vibe_options['header_style']; ?>">
    <div class="container">
        <div class="row">
            <div class="<?php echo $show['headingspan']; ?>">
                <?php if($show['title']){ ?>
               <h1 id="page_title"><?php the_title(); ?></h1> 
               <?php 
                        }
                     if(strlen($custom_subheader['subtitle'])>2){
                         $subtitle=html_entity_decode($custom_subheader['subtitle']);
                        if(!(strcmp( $subtitle, strip_tags($subtitle) ) == 0)){
                            echo $subtitle;
                        }else {
                          echo '<h5>'.$custom_subheader['subtitle'].'</h5>';  
                        }
                    }
                 if($show['prev_next']){ 
                            ?>
                            <div class="prev_next_links">
                                <div class="prev_next">
                                <?php 
                                previous_post_link('%link', '<i class="icon-left-open-mini"></i>');
                                next_post_link('%link', '<i class="icon-right-open-mini"></i>');
                                ?>
                                </div>    
                            </div>
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
                if($inpage_menu){
                    
                    if(isset($vibe_options['nav_fix']) && !$vibe_options['nav_fix'])
                      $inclass='fixtop';
                    
            ?>
           <div class="inpage_menu <?php echo $inclass; ?>">
               <div class="container">
                   <div class="row">
                        <div class="span12">
                            <ul class="in_menu">
                            <?php
                                    foreach($inpage_menu as $key=>$item){
                                    echo '<li><a href="#'.$key.'">'.$item.'</a></li>';
                                    }
                                ?>
                            </ul>
                        </div> 
                    </div>    
                   </div>    
               </div>    
            <?php
                }
            ?>
</section> 
<?php
}
?>
<section class="stripe" id="contactcanvas">
    <div id="map-canvas"></div>
</section>    
<section id="contactpage" class="main">
	<div class="container">
            <div class="row">
                <?php
                 if (have_posts()) : 
                    while (have_posts()) : the_post(); 
                 ?>
                <div class="span12">
                    <?php
                       the_content();
                     ?>
                   </div>   
                 <?php
                    endwhile;
                    endif;         
                ?>
            </div>
	</div>
</section>   
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script type='text/javascript'>
  var map;
       
           function initialize() {
          
              var point = new google.maps.LatLng(<?php if(isset($vibe_options['contact_ll'])){echo $vibe_options['contact_ll']; }else {echo '43.730325,7.422155'; }; ?>);
              var centrePoint = new google.maps.LatLng(<?php if(isset($vibe_options['contact_ll'])){echo $vibe_options['contact_ll']; }else {echo '43.730325,7.422155'; }; ?>);
          
              var myOptions = {
                 center: centrePoint,
                 zoom: 17,
                 mapTypeId: google.maps.MapTypeId.<?php if(isset($vibe_options['contact_style'])) {echo $vibe_options['contact_style'];}else{echo 'SATELLITE';} ?>,
                 disableDefaultUI:true,
                 scrollwheel:false,
                 zoomControl: true,
                 zoomControlOptions: {
                     style: google.maps.ZoomControlStyle.LARGE,
                     position: google.maps.ControlPosition.RIGHT_CENTER
                 }
              };
          
              map = new google.maps.Map(document.getElementById('map-canvas'), myOptions);

              var image = new google.maps.MarkerImage(
                 '<?php echo VIBE_URL; ?>/img/marker.png',
                 new google.maps.Size(60,75),
                 new google.maps.Point(0,0),
                 new google.maps.Point(60,75)
              );

              var shadow = new google.maps.MarkerImage(
                '<?php echo VIBE_URL; ?>/img/marker_shadow.png',
                new google.maps.Size(77,36),
                new google.maps.Point(0,0),
                new google.maps.Point(42,36)
              );

              var shape = {
                coord: [25,0,28,1,30,2,31,3,33,4,33,5,34,6,35,7,36,8,36,9,36,10,37,11,37,12,37,13,37,14,37,15,37,16,37,17,37,18,37,19,37,20,37,21,37,22,37,23,36,24,36,25,36,26,35,27,35,28,34,29,34,30,33,31,33,32,32,33,32,34,31,35,31,36,30,37,30,38,29,39,29,40,28,41,27,42,27,43,26,44,26,45,25,46,24,47,24,48,23,49,23,50,22,51,21,52,16,52,15,51,14,50,14,49,13,48,13,47,12,46,11,45,11,44,10,43,10,42,9,41,8,40,8,39,7,38,7,37,6,36,6,35,5,34,5,33,4,32,4,31,3,30,3,29,2,28,2,27,1,26,1,25,1,24,0,23,0,22,0,21,0,20,0,19,0,18,0,17,0,16,0,15,0,14,0,13,0,12,0,11,1,10,1,9,1,8,2,7,3,6,4,5,4,4,6,3,7,2,9,1,12,0,25,0],
                type: 'poly'
              };

              var marker = new google.maps.Marker({
                draggable: false,
                raiseOnDrag: false,
                animation: google.maps.Animation.DROP,
                icon: image,
                shadow: shadow,
                shape: shape,
                map: map,
                position: point
              });
          
              google.maps.event.addListener(marker, 'click', toggleBounce);
          
              function toggleBounce() {
                if (marker.getAnimation() != null) {
                  marker.setAnimation(null);
                } else {
                  marker.setAnimation(google.maps.Animation.BOUNCE);
                }   
              }
           }
       
           //google.maps.event.addDomListener(window, 'load', initialize);
           setTimeout(initialize, 2000);
</script>
<?php
get_footer();
?>