<?php

/**
 * Template Name: Agent Account
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate 
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
<section id="<?php echo $rand; ?>" class="subheader">
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
            <?php
                  } //Hide Show BreadCrumbs
              ?>
      </div>      
    </div>
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
        </div> 
    </div>
	</div>
</section>  
<?php

if ( is_user_logged_in() ):
?>
<section id="agent_details" class="main">
  <div class="container">
    <div class="row">
        <?php
          global $current_user;
        get_currentuserinfo();
        ?>
        <div class="span3">
          <div id="avatar">
            <?php
               echo get_avatar( $current_user->user_email, '480');
            ?>
          </div>
          <ul>
            <li><label><?php _e('Username','vibe'); ?></label><?php echo $current_user->user_login; ?></li>
            <li><label><?php _e('Email','vibe'); ?></label><?php echo $current_user->user_email; ?></li>
            <?php 

            $profile_page = get_user_meta($current_user->ID,'agent_profile',true); 

            $page_id=  intval($vibe_options['agent_profile_page']);
              $href= get_page_uri( $page_id );
            if(isset($profile_page) && $profile_page){
              $href .='?agent_id='.$profile_page;
            }
            ?>
            <li><a href="<?php echo $href; ?>" class="btn"><?php echo ((isset($profile_page) && $profile_page)?__('Edit Profile','vibe'):__('Create Profile','vibe')); ?></a>
            <?php
            if(isset($profile_page) && $profile_page){
            ?>
            <a href="<?php echo get_permalink($profile_page); ?>" class="btn"><?php _e('View Profile','vibe'); ?></a>
            <?php
          }
            ?>
            </li>
            <li>
            <?php

            ?>
            </li>
          </ul>  
        </div>
        <div class="span6">
          <?php
          
          if(isset($_POST['update_agent_details'])){
              $args=array('ID'=>$current_user->ID);
              if(isset($_POST['firstname'])){
                  $args['first_name'] = $_POST['firstname'];
              }
              if(isset($_POST['lastname'])){
                $args['last_name'] = $_POST['lastname'];
              }
              if(isset($_POST['desc'])){
                $args['description'] = $_POST['desc'];
              }
              if(count($args) > 1){
                  wp_update_user($args);
              }
          }
          ?>
            <form method="post" name="usersettings">
              <ul>
                <li><label><?php _e('First Name','vibe'); ?></label><input type="text" name="firstname" value="<?php echo $current_user->user_firstname; ?>"></li>
                <li><label><?php _e('Last Name','vibe'); ?></label><input type="text" name="lastname" value="<?php echo $current_user->user_lastname; ?>"></li>
                <li><label><?php _e('About','vibe'); ?></label><textarea name="desc"><?php echo $current_user->description; ?></textarea></li>
                <li><input type="submit" name="update_agent_details" value="Update Details" class="btn" /></li>
                <li><?php

                $add_membership = vibe_get_option('add_membership');
                
                if(isset($add_membership) && $add_membership){
                    $expiry=get_user_meta($current_user->ID,'vibe_membership_expire',true);
                    if(time() > $expiry){
                        echo '<div class="message">'.__('AGENT MEMBERSHIP EXPIRED','vibe').'</div>';
                        // Remove role
                        $current_user->remove_role( 'agent' );
                        // Add role
                        $current_user->add_role( 'subscriber' );
                    }else{
                       $days=round((($expiry-time())/86400),0);
                      echo '<div class="message">'.__('AGENT MEMBERSHIP EXPIRES IN ','vibe').$days.' '.__(' DAYS','vibe').'</div>';

                      $user_roles = $current_user->roles;
                      $user_role = array_shift($user_roles);

                      if($user_role == 'subscriber'){
                         $current_user->remove_role( 'subscriber' );
                        $current_user->add_role( 'agent' );
                      }

                    }
                  }else{
                    echo '<div class="message">'.__('AGENT MEMBERSHIP DISABLED ','vibe').'</div>';
                  }  

                ?></li>
              </ul>
            </form>
        </div>
        <div class="span3">
          <div class="sidebar">
                <?php 
                    if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar($show['sidebar']) ) : ?>
                <?php endif; ?>
          </div>
        </div>
    </div>
    <div class="row"> 

            <div class="listings">
               <h3><?php _e('Listings Submitted','vibe');?></h3>
              <?php

                  $edit_page = get_page_uri(vibe_get_option('agent_add_listings_page'));

                  global $current_user;
                  get_currentuserinfo();

                  $author_query = array('post_type' => LISTING,'posts_per_page' => '-1','author' => $current_user->ID,'post_status'=>'any');
                  $author_posts = new WP_Query($author_query);
                  if($author_posts->have_posts()):
                    echo '<ul>';
                  while($author_posts->have_posts()) : $author_posts->the_post();

                  $st=get_post_status(get_the_ID());

                  switch($st){
                    case 'publish' : $status='PUBLISHED';
                    break;
                    case 'draft' :
                        $status='SAVED AS DRAFT';
                    break;
                    default:
                      $status='PENDING APPROVAL';
                  }
                  ?>
                      <li class="span4">
                        <div class="single_listing">
                          <?php the_post_thumbnail(get_the_ID(),'full');?>
                          <h5><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> </a></h5>
                          <ul>
                            <li><a href="<?php the_permalink(); ?>"><?php _e('View','vibe'); ?></a></li>
                            <li><a href="<?php echo $edit_page.'?listing_id='.get_the_ID(); ?>"><?php _e('Edit','vibe'); ?></a></li>
                            <li><strong><?php echo $status; ?></strong></li>
                          </ul>
                        </div>
                      </li>       
                  <?php           
                  endwhile;
                    echo '</ul>';
                  endif;

              ?>
            </div>
        
        
     </div>  
  </div>
</section>
<?php
endif;

get_footer();
?>