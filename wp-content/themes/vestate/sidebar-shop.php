<?php

/**
 * FILE: sidebar-shop.php 
 * Created on Jul 20, 2013 at 11:11:05 AM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate 
 * License: GPLv2
 */

global $vibe_options;
if(isset($vibe_options['woocommerce_sidebar']))
    $shopsidebar=$vibe_options['woocommerce_sidebar'];
else
    $shopsidebar='shop';
?>
<div class="sidebar no-border">
     <?php 
         if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar($shopsidebar) ) : ?>
     <?php endif; ?>
</div>