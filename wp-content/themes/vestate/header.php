<?php

/**
 * FILE: header.php 
 * Created on Feb 12, 2013 at 6:44:37 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEState
 */
global $vibe_options,$woocommerce;
$class='';
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title>
        <?php wp_title(); ?>
    </title>
    <?php
     if(isset($vibe_options['responsive']) && !$vibe_options['responsive']){
        echo '<meta name="viewport" content="width=1200">'; 
     }else{
       echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';  
     }
    ?>

   
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo VIBE_URL;?>/css/fonticons-ie7.css">
    <![endif]-->
    
    
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    
    <?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
    <!-- Le fav and touch icons -->
   <link rel="shortcut icon" href="<?php  echo $vibe_options['favicon']; ?>">
   <?php 
   $nclass='';
   if($vibe_options['nav_fix'])
       { 
          $nclass='fix';
       }
       $hclass =$vibe_options['header_style'];
       $class ='';

        if($vibe_options['theme_layout'] == 'boxed')
            $class .=' boxed';
    ?>
   <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php
    wp_head();
    ?>
  </head>


  <body <?php body_class($class); ?>>
 
<!-- ================================================== -->
<!-- ==================  HEADER  ====================== -->
<!-- ================================================== -->
    
<header>
    <?php
                if(isset($vibe_options['header_sidebar']) && $vibe_options['header_sidebar']){
            ?>
                <div class="header_top">
                   <div class="container"> 
                    <div class="row">
                        <div class="header_sidebar">
                    <?php 
                            if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('headersidebar') ) : ?>
                        <?php endif; ?>
                        </div>    
                </div>
               </div>     
            </div> 
             <a href="javascript:void();" class="header_sidebar_hook"><i></i></a>
            <?php
                }
             ?>  
    <div id="header_top">
        <div class="container">
            <div class="row">  
                <div class="span6">
                    <div id="header_top_note">
                    <?php
                        echo do_shortcode($vibe_options['header_top_content']);
                    ?>
                    </div>    
                </div>
                <div class="span6">
                   <?php
                     wp_nav_menu( array(
                         'theme_location'  => 'top-menu',
                         'container'       => 'div',
                         'menu_class'      => 'topmenu',
                         'fallback_cb'     => 'set_wpmenu'
                     ) );
                    ?>   
                </div>
            </div>     
    </div>
   </div>
	<div class="container">  
            <div class="row">
    		<div class="span6">
    			<h1 id="logo">
    			<a href="<?php echo home_url(); ?>">
                            <?php
                            if(isset($vibe_options['logo']) && $vibe_options['logo']){
                               echo '<img src="'.$vibe_options['logo'].'" alt="'.get_option('blogname').'" />';
                            }else
                                echo '<img src="'.VIBE_URL.'/img/logo.png" alt="'.get_option('blogname').'" />';
                            ?>
                            
                        </a>
    			</h1>
                    
                <div class="accordionnav">
	  		   	<a class="show_nav"><i class="icon-list"></i></a>
                                <?php
                            $defaults = array(
                            'theme_location'  => 'main-menu',
                            'container'       => false, 
                            'menu_class'      => 'collapsed_accordion',
                            'menu_id'         => '',
                            'echo'            => true,
                            'fallback_cb'     => 'set_wpmenu'
                            ); 
                            wp_nav_menu( $defaults ); 
                           ?>	  		   		   		
  		   </div>
                    
    		</div>
                <div class="span6">
                   <div class="header_note">
                      <?php
                         echo do_shortcode($vibe_options['header_note']);
                      ?>
                   </div>          
    		</div>
            </div>   
  	</div>
</header>
<nav id="nav_horizontal" data-top="200" class="<?php if($nclass){echo $nclass;} ?>">
    <div class="container">
<?php
                     wp_nav_menu( array(
                         'theme_location'  => 'main-menu',
                         'container'       => 'div',
                         'menu_class'      => 'menu horizontal',
                         'walker'          => new vibe_walker,
                         'fallback_cb'     => 'set_wpmenu'
                     ) );
                    ?>   
        <div class="navsearch">
           <form role="search" method="get" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
                <input type="text" name="s" id="search" value="" placeholder="<?php _e('Type to Search..','vibe'); ?>" />
                <?php
                $search_template=vibe_get_option('search_template');
                if(isset($search_template) && $search_template){
                  echo '<input type="hidden" name="post_type" value="'.LISTING.'" />';
                }
                ?>
                <i class="icon-search"></i>
            </form>
        </div>
    </div>
</nav>    
<?php

?>