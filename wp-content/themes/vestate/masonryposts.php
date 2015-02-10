<?php

/**
 * Template Name: Masonry Grid Posts
 * FILE: masonryposts.php 
 * Created on Jul 18, 2013 at 11:26:35 AM 
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
    if(isset($vibe_options['custom_css_changes']) && in_array($post_type,$vibe_options['custom_css_changes'])){
       $custom_css = get_custom_css(); 
    
       
 ?>

<style>
<?php   
    echo 'header{
        display: '.(($custom_css['header'])?'block':'none').';
    }';
    if(isset($custom_css['body_bg_image']) && strlen($custom_css['body_bg_image']) > 6 ){
    echo 'body{
        background-image: '.$custom_css['body_bg_image'].';
        '.$custom_css['body_css'].'
    }';
    }
    
    echo '#'.$rand.', .boxed #'.$rand.' .container{
          '.(isset($custom_subheader['subheader_bg_color'])?'background-color:'.$custom_subheader['subheader_bg_color'].';':'').'
         '.((isset($custom_subheader['subheader_bg_image']) && strlen($custom_subheader['subheader_bg_image']) > 6)?'background-image: '.$custom_subheader['subheader_bg_image'].'':'').
            ''.$custom_subheader['subheader_css'].' }';
    
    
    echo  '#'.$rand.' ul.breadcrumbs,
         #'.$rand.' h1,
         #'.$rand.' h3,
         #'.$rand.' a{color:'.$custom_subheader['subheader_color'].';}';
    
    if(isset($custom_css['general_css']) && $custom_css['general_css'])
    echo $custom_css['general_css'];
    
    if(isset($custom_css['footer']) && $custom_css['footer']){
    echo 'footer{
         display: '.(($custom_css['footer'])?'block':'none').';
        }';
        }
?>
</style>
<?php
    }

    if($show['subheader']){
?>
<section id="<?php echo $rand; ?>" class="subheader <?php echo $vibe_options['header_style'].' '.($vibe_options['header_fix']>1)?'always':''; ?>">
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
                          echo '<h3>'.$custom_subheader['subtitle'].'</h3>';  
                        }
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
                    
                    if( $vibe_options['header_fix'] < 1 )
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
               <div class="span12">
                   <div class="content">
                    <?php
                           if (have_posts()) : 
                           while (have_posts()) : the_post(); 
                                    the_content();
                                endwhile;
                                endif;
                            ?>
                        </div>
                            <?php
                             $number = get_option('posts_per_page');
                            query_posts('posts_per_page='.$number.'&paged='.$paged);
                            ?>
                    <div class="pagecontent">
                        <div class="vibe_post_grid ">
                            <div class="vibe_grid  masonry">
                                
                                <div class="vibe_grid masonry" data-paged="<?php echo $paged; ?>">
                                     <ul class="grid masonry" data-width="370" data-gutter="30">
                        <?php
                            if (have_posts()) : 
                            while (have_posts()) : the_post(); 
                            global $post;
                                echo '<li class="medium grid-item" style="width:370px;margin-bottom:30px;">';
                                echo  thumbnail_generator($post,'',3,0,0,0);
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
</section>  
<?php
get_footer();
?>
