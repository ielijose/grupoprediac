<?php

/**
 * FILE: footer.php 
 * Created on Feb 12, 2013 at 6:44:46 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */

// $vibe_options : Vibe Options Parameters used in Footer.
// $script : javascript variables required in custom.js.
// $vibe_post_script : javascript function calls based on .

global $vibe_options,$script,$vibe_post_script;
$show =get_footer_values();
$style='';
$vibe_post_script .= 'VideoJS.options.flash.swf = "'.VIBE_URL.'/img/video-js.swf";
   
    // Catch each of the player\'s ready events and resize them individually
    // jQuery deferred might be a neater way to wait for ready on all components to load and avoid a bit of repetition
    for (var i = 0; i < players.length; i++) {
        _V_("#" + players[i]).ready(function() {
           var ar = aspectRatio[i];
            resizeVideoJS(this,ar);
        });
    }

    // Loop through all the players and resize them 
    function resizeVideos() { 
        for (var i = 0; i < players.length; i ++) {
            var player = _V_("#" + players[i]);
            var ar = aspectRatio[i];
            resizeVideoJS(player,ar);
        }           
    }

    // Resize a single player
    function resizeVideoJS(player,aspectRatio){
        // Get the parent element\'s actual width
        var width = document.getElementById(player.id).parentElement.offsetWidth;

        if(width>1920) // Issue with Flexslider
           width=263; // Default Width if issue arrises
           
        // Set width to fill parent element, Set height
        player.width(width).height( width * aspectRatio );
    }

    window.onresize = resizeVideos;';
?>

<!-- ================================================== -->
<!-- ==================  FOOTER  ====================== -->
<!-- ================================================== -->
<?php
$footer_class='footer';

if( isset($vibe_options['footer_fix']) && $vibe_options['footer_fix']){
    //$footer_class .=' fix';
}
?>
<footer class="<?php echo $footer_class; ?>">
      <div class="container">
      	<div class="row">
            <?php 
            foreach($show['footer'] as $footer){
                echo '<div class="'.$show['span'].'">';
                if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar($footer) ) : ?>
                <?php endif; 
                echo '</div>';
            }
            ?>
          </div>	
      </div>
      <div id="footer_bottom">
      	<div class="container">
      	<div class="row">
      	<div class="span6">
            <?php echo stripslashes($vibe_options['copyright']); ?>
        </div>
        <div class="span6">
        	<?php echo vibe_socialicons('footer_social_icons'); ?>
        </div>	
        </div>
        </div>					
      </div>
</footer>


<div class="toparrow"><a href="#top" id="top_arrow"></a></div>

<!-- ================================================== -->
<!-- ========  JavaScripts & Variables  =============== -->
<!-- ================================================== -->
<?php


/*-- ================================================== -->
<!-- ==============  Analytics Code  ================== -->
<!-- ================================================== --*/
if(isset($vibe_options['google_analytics']) ){ 
echo stripslashes($vibe_options['google_analytics']); 
} 
  
$script .='var ajaxurl="'.admin_url('admin-ajax.php').'";';
  ?>
 <script type="text/javascript">
      <?php echo $script; ?>
</script>
<div class="toparrow"><i class="icon-up-open-big"></i></div>
<?php
wp_footer();
?>
  </body>
</html>