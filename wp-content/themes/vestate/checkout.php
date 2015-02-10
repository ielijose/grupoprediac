<?php

/**
 * Template Name: Checkout
 * FILE: checkout.php 
 * Created on Apr 2, 2013 at 3:07:11 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
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
         #'.$rand.' h5,
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
<section class="main">
	<div class="container">
            <div class="row">
            <?php    
                    if (have_posts()) : 
                    while (have_posts()) : the_post(); 
                 ?>
                   <div class="checkout">
                       <div class="span9"> 
                       <div class="checkoutsteps">
                           <ul class="checkout_steps">
                               <li class="checkout_begin">
                                   <i class="icon-cart"></i>
                               </li>
                               <?php
                               if ( get_option('woocommerce_enable_signup_and_login_from_checkout') != "no" ){
                                   ?>
                               <li class="active"><a>
                                   <h4>Step 1</h4>
                                   <p>Login/Register</p>
                                   </a>
                               </li>
                               <?php
                                 }
                               ?>
                               <li><a>
                                   <h4>Step 2</h4>
                                   <p>Billing & Shipping</p>
                                   </a>
                               </li>
                                <li><a>
                                   <h4>Step 3</h4>
                                   <p>Review Order</p>
                                   </a>
                               </li>
                                <li><a>
                                   <h4>Step 4</h4>
                                   <p>Payment Details</p>
                                   </a>
                               </li>
                               <li class="checkout_end">
                                   <h4>Step 5</h4>
                                   <p>Thank You !</p>
                               </li>
                           </ul>
                       </div>
                         <div class="checkout_content">
                         <?php
                           the_content();
                          ?>
                       </div>   
                      </div>     
                       <div class="coupon_checkout span3">
                           <div class="coupon">
                           <?php
                           if ( get_option( 'woocommerce_enable_coupons' ) == 'no' || get_option( 'woocommerce_enable_coupon_form_on_checkout' ) == 'no' ) return;
                            $info_message = apply_filters('woocommerce_checkout_coupon_message', __('Have a coupon?', 'woocommerce'));
                            ?>

                            <p class="woocommerce_info"><?php echo $info_message; ?> <a href="#" class="showcoupon"><?php _e('Click here to enter your code', 'woocommerce'); ?></a></p>
                            <form class="checkout_coupon" method="post">

                                <p class="form-row-first">
                                    <input type="text" name="coupon_code" class="input-text" placeholder="<?php _e('Coupon code', 'woocommerce'); ?>" id="coupon_code" value="" />
                                </p>
        
                                <p class="form-row-last">
                                    <input type="submit" class="button" name="apply_coupon" value="<?php _e('Apply Coupon', 'woocommerce'); ?>" />
                                </p>
        
                                <div class="clear"></div>
                            </form>
                            </div>
                           <div class="checkout_message">
                           <?php
                           $msg=do_shortcode($vibe_options['woocommerce_checkout_message']);
                           echo apply_filters('the_content',$msg );
                           ?>
                           </div> 
                       </div>
                        </div>   
                        <?php
                           endwhile;
                           endif;
                            ?>
            </div>
	</div>
</section>   
<?php
get_footer();
?>
