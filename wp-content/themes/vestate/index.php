<?php

/**
 * FILE: index.php 
 * Created on Feb 12, 2013 at 7:07:40 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */

global $vibe_options;
$vibe_options = get_option(THEME_SHORT_NAME);
get_header($vibe_options['header_style']);

 (isset($vibe_options['header_fix']) && $vibe_options['header_fix'] > 1)?$fixclass='always':$fixclass='';
 
?>
<section class="subheader <?php echo $fixclass; ?>">
    <div class="container">
        <div class="row">
            <div class="span8">
               <h1 id="page_title"><?php echo get_bloginfo('description'); ?></h1> 
            </div>
            <div class="span4">
                    <?php if (function_exists('vibe_breadcrumbs')) 
                        vibe_breadcrumbs(); ?>   
            </div>
        </div>      
    </div>
</section> 
<!-- ================================================== -->
<!-- =================  CONTENT   ===================== -->
<!-- ================================================== -->
<section class="main">
	<div class="container">
            <div class="row">
                <?php
                            get_template_part( 'small', 'loop' ); 
                        ?>
            </div>
	</div>
</section>  
<?php
get_footer();
?>