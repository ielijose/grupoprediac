<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

get_header('vibewoo');
?>
<div class="container">
  	<div class="row">
  		<section class="main-section">
                    <div class="product_title">
                    
                        <h1><?php the_title(); ?></h1>
                        <div class="prev_next_links">
                                <div class="prev_next">
                                <?php 
                                previous_post_link(); echo ' | ';
                                next_post_link();
                                ?>
                                </div>    
                            </div>
                    <?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
                            do_action('woocommerce_before_main_content');
                        ?>
                
                </div>      
                <div class="span8">
                
                            
                           
		<?php while ( have_posts() ) : the_post(); ?>
                
                
			<?php woocommerce_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>
            </div>
                 <?php
                    echo '<div class="span4"><div class="sidebar">';
                    
                 ?>
                <?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action('woocommerce_sidebar');
                
                echo '</div></div>';
                ?>
                <?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
                ?>                    
               
                </div>
            </div>
</section>
<?php get_footer('shop'); ?>