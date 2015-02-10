<?php

/**
 * FILE: func.php 
 * Created on Feb 20, 2013 at 1:57:30 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */

/// BEGIN AJAX HANDELERS
add_action( 'wp_ajax_reset_googlewebfonts', 'reset_googlewebfonts' );
	function reset_googlewebfonts(){ 
            echo "reselecting..";
            $r = get_option('google_webfonts');
            if(isset($r)){
                delete_option('google_webfonts');
            }
                die();
}



if(!function_exists('vibe_currency_symbols')){
    function vibe_currency_symbols(){
        $vibe_currency_symbols=array(  'cur-dollar' => 'USD',
                                        'cur-euro'=>'Euro',
                                        'cur-pound'=>'Pound',
                                        'cur-bitcoin'=>'Bitcoin',
                                        'cur-renmibi'=>'Renminbi',
                                        'cur-yen'=>'Yen',
                                        'cur-won'=>'Won',
                                        'cur-rupee'=>'Rupee');
        return $vibe_currency_symbols;
    }
}        

if(!function_exists('vibe_user_roles')){
    function vibe_user_roles(){
    $agent_capability=array(
        'delete_posts'=> true,
        'delete_published_posts'=> true,
        'edit_posts'=> true,
        'edit_published_posts'=> true,
        'publish_posts'=> true,
        'read' => true,
        'upload_files'=> true,
        'level_1' => true
        );
       $agent=vibe_get_option('agent_role');
       if(isset($agent) && $agent){
        //remove_role('vest_agent');
        //remove_role('agents');
        
        add_role( 'vest_agent', __('Agent','vibe'),$agent_capability);  
        /*global $wp_roles;

        $wp_roles->add_cap( 'vest_agent', 'read' );
        $wp_roles->add_cap( 'vest_agent', 'edit_posts' );
        $wp_roles->add_cap( 'vest_agent', 'delete_posts' );
        $wp_roles->add_cap( 'vest_agent', 'edit_published_posts' );
        $wp_roles->add_cap( 'vest_agent', 'delete_published_posts' );
        $wp_roles->add_cap( 'vest_agent', 'upload_files' );
        $wp_roles->add_cap( 'vest_agent', 'publish_posts' );
        $wp_roles->add_cap( 'vest_agent', 'level_1' );*/

       }
    }
    add_action('init','vibe_user_roles');
}


add_action( 'wp_ajax_vibe-feature-listing', 'vibe_feature_listing' );
	function vibe_feature_listing(){ 
         
            if ( ! is_admin() ) die;
         if ( ! check_admin_referer('vibe-feature-listing')) wp_die( __( 'You have taken too long. Please go back and retry.', 'vibe' ) );

	$post_id = isset( $_GET['listing_id'] ) && (int) $_GET['listing_id'] ? (int) $_GET['listing_id'] : '';

	if (!$post_id) die;

	$post = get_post($post_id);

	if ( ! $post || $post->post_type !== LISTING ) die;

	$vibe_options = get_option(THEME_SHORT_NAME);
            if(in_array('featured', $vibe_options['listing_fields']['field_type'])){
                        $i = array_search('featured', $vibe_options['listing_fields']['field_type']);
                        $label = 'vibe_'.strtolower(str_replace(' ', '-',$vibe_options['listing_fields']['label'][$i]));
                    }
                    
            $r = getPostMeta($post_id,$label);
            if(isset($r) && $r){
                update_post_meta($post->ID, $label,0, 1);
            }else{
                update_post_meta($post->ID, $label,1,0);
            }
	wp_safe_redirect( remove_query_arg( array('trashed', 'untrashed', 'deleted', 'ids'), wp_get_referer() ) );

}

add_action( 'wp_ajax_vibe-available-listing', 'vibe_available_listing' );
	function vibe_available_listing(){ 
            
            if ( ! is_admin() ) die;
         if ( ! check_admin_referer('vibe-available-listing')) wp_die( __( 'You have taken too long. Please go back and retry.', 'vibe' ) );

	$post_id = isset( $_GET['listing_id'] ) && (int) $_GET['listing_id'] ? (int) $_GET['listing_id'] : '';

	if (!$post_id) die;

	$post = get_post($post_id);

	if ( ! $post || $post->post_type !== LISTING ) die;

	$vibe_options = get_option(THEME_SHORT_NAME);
            if(in_array('available', $vibe_options['listing_fields']['field_type'])){
                        $i = array_search('available', $vibe_options['listing_fields']['field_type']);
                        $label = 'vibe_'.strtolower(str_replace(' ', '-',$vibe_options['listing_fields']['label'][$i]));
                    }
                    
            $r = getPostMeta($post_id,$label);
            if(isset($r) && $r){
                update_post_meta($post->ID, $label,0, 1);
            }else{
                update_post_meta($post->ID, $label,1,0);
            }
	wp_safe_redirect( remove_query_arg( array('trashed', 'untrashed', 'deleted', 'ids'), wp_get_referer() ) );
}


add_action( 'wp_ajax_tour_number', 'inc_tour_number' );
	function inc_tour_number(){ 
            $r = get_option('tour_number');
            if(isset($r)){ $r++;
                update_option('tour_number', $r);
            }else
                add_option('tour_number', 0);
                die();
}
            
add_action( 'wp_ajax_import_data', 'import_data' );
	function import_data(){
		$name = stripslashes($_POST['name']);
                $code = base64_decode(trim($_POST['code'])); 
                if(is_string($code))
                    $code = unserialize ($code);
                
                $value = get_option($name);
                if(isset($value)){
                                update_option($name,$code);
                }else{
                    echo "Error, Option does not exist !";
                }
                die();
            }
add_action( 'wp_ajax_import_sample_data', 'import_sample_data' );
	function import_sample_data(){
		$file = stripslashes($_POST['file']);
                include 'importer/vibeimport.php';
                vibe_import($file);
                die();
            }
            
add_action( 'wp_ajax_popup', 'ajax_popup' );
add_action( 'wp_ajax_nopriv_popup', 'ajax_popup' );
	function ajax_popup(){ 
                $id = stripslashes($_GET['id']);
                $popup = get_page($id);
                $post_content=apply_filters('the_content', $popup->post_content);;
                echo '<div class="popup_content">';
                echo do_shortcode($post_content).'</div>';
                die();
}


add_action( 'wp_ajax_add_slider_item', 'v_add_slider_item' );
    function v_add_slider_item(){
        if ( ! wp_verify_nonce( $_POST['load_nonce'], 'load_nonce' ) ) die(-1);
        
        $attachment_class = $_POST['attachment_class'];
        $change_image = (bool) $_POST['change_image'];

        preg_match( '/wp-image-([\d])+/', $attachment_class, $matches );
        $attachment_id = str_replace( 'wp-image-', '', $matches[0] );
        $attachment_image = wp_get_attachment_image( $attachment_id );
        
        if ( $change_image ) {
            echo json_encode( array( 'attachment_image' => $attachment_image, 'attachment_id' => $attachment_id ) );
        } else {
            echo '<div class="attachment clearfix" data-attachment="' . esc_attr( $attachment_id ) .'">' 
                    . $attachment_image
                    . '<div class="attachment_options">'
                        . '<p class="clearfix">' . '<label>' . esc_html__('Description (HTML & Shortcodes allowed)', 'vibe') . ': </label>' . '<textarea name="attachment_description[]" class="attachment_description"></textarea> </p>'
                        . '<p class="clearfix">' . '<label>' . esc_html__('Link', 'vibe') . ': </label>'. '<input name="attachment_link[]" class="attachment_link" /> </p>'
                    . '</div>'
                    . '<a href="#" class="delete_attachment">' . esc_html__('Delete this slide', 'vibe') . '</a>'
                    . '<a href="#" class="change_attachment_image">' . esc_html__('Change image', 'vibe') . '</a>'
                . '</div>';
        }
        
        die();
    }
        
add_action( 'wp_ajax_delete_layout', 'delete_layout' );
    function delete_layout(){
                $name = stripslashes($_POST['name']);
                  
                $value = get_option('vibe_builder_sample_layouts');
                if(isset($value)){
                    
                    if(is_string($value))
                    $value=  unserialize($value);
                    
                    for($i=0;$i<count($value);$i++){
                        if($name == $value[$i]['name']){
                            unset($value[$i]);
                            $value = array_values($value);
                                $value=serialize($value);
                                update_option('vibe_builder_sample_layouts',$value);
                            }
                        }
                    }
                die();
            }
            
add_action( 'wp_ajax_show_module_options', 'new_show_module_options' );
    function new_show_module_options(){
        if ( ! wp_verify_nonce( $_POST['load_nonce'], 'load_nonce' ) ) die(-1);
        
        $module_class = $_POST['module_class'];
        $v_module_exact_name = $_POST['module_exact_name'];
        $module_window = (int) $_POST['modal_window'];
        
        preg_match( '/m_([^\s])+/', $module_class, $matches );
        $module_name = str_replace( 'm_', '', $matches[0] );
        
        $paste_to_editor_id = isset( $_POST['paste_to_editor_id'] ) ? $_POST['paste_to_editor_id'] : '';
        
        generate_module_options( $module_name, $module_window, $paste_to_editor_id, $v_module_exact_name );
        
        die();
    }

add_action( 'wp_ajax_show_column_options', 'new_show_column_options' );
    function new_show_column_options(){
        if ( ! wp_verify_nonce( $_POST['load_nonce'], 'load_nonce' ) ) die(-1);
        
        $module_class = $_POST['et_module_class'];
        
        preg_match( '/m_column_([^\s])+/', $module_class, $matches );
        $module_name = str_replace( 'm_column_', '', $matches[0] );
        
        $paste_to_editor_id = isset( $_POST['paste_to_editor_id'] ) ? $_POST['paste_to_editor_id'] : '';
        
        generate_column_options( $module_name, $paste_to_editor_id );
        
        die();
    }


        //Ajax Handle Contact Form

add_action('wp_ajax_contact_submission', 'contact_form_submission');
add_action( 'wp_ajax_nopriv_contact_submission', 'contact_form_submission' );

function contact_form_submission() {
    global $vibe_options;
    
    $data = json_decode(stripslashes($_POST['data']));
    $labels = json_decode(stripslashes($_POST['label']));
    
    $subject=stripslashes($_POST['subject']);
    if(!isset($subject))
        $subject = "Contact Form Submission";
    
    $to=stripslashes($_POST['to']);
    $admin_email=get_option('admin_email');
    if(!isset($to))
        $to = $admin_email; 
    
    
    for($i=1;$i<count($data);$i++){
        $message .= $labels[$i].' : '.$data[$i].' <br />';
    }

    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'From: "'.get_bloginfo('name').'" <'.$admin_email.'>'. '\r\n';
    $headers .= "Reply-To: vEstate <$to>\r\n";
    $headers .= "Return-Path: email\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


    
   
   
    $flag=wp_mail( $to, $subject, $message, $headers );
    if ( $flag ) {
        echo "<span style='color:#0E7A00;'>Message sent! </span>";
    }else{
    	echo "Unable to send message! Please try again later..";
    	}
die();
}


/// END AJAX HANDELERS

if(!function_exists('getall_taxonomy_terms')){
    function getall_taxonomy_terms(){
        $taxonomies=get_taxonomies('','objects'); 
        $termchildren = array();
        foreach ($taxonomies as $taxonomy ) {
            $toplevelterms = get_terms($taxonomy->name, 'hide_empty=0&hierarchical=0&parent=0');
        	foreach ($toplevelterms as $toplevelterm) {
                    $termchildren[ $toplevelterm->slug] = $taxonomy->name.' : '.$toplevelterm->name;
        		}
            }
            
    return $termchildren;  
    }
}




add_filter('get_avatar','change_avatar_css');


function change_avatar_css($class) {
$class = str_replace("class='avatar", "class='retina_avatar zoom animate", $class) ;
return $class;
}


if(!function_exists('vibe_socialicons')){
    function vibe_socialicons($location=''){
        global $vibe_options; $html='';
        $vibe_options=get_option(THEME_SHORT_NAME);
         
        if(isset($vibe_options[$location])){
            $social_icons = $vibe_options[$location];
        
        $html = '<ul class="socialicons '.$vibe_options['social_icons_type'].'">';
        if(is_array($social_icons)){
         foreach($social_icons as $icon){ 
            $social_icon = $vibe_options['social_icons']['social'][$icon];
            $url=$vibe_options['social_icons']['url'][$icon];
            $rel='';
            if($vibe_options['show_social_tooltip']){
                $rel='data-rel="tooltip" data-original-title="'. $social_icon .'"';

                if($location == 'header_social_icons'){
                    $rel .=' data-placement="bottom"';
                }
            }
            $html .= '<li><a href="'.$url.'" title="'.$social_icon.'" class="'.$social_icon.'" '.$rel.'><i class="icon-'.$social_icon.'"></i></a></li>';
            }
        }
        $html .= '</ul>';
        }
    return $html;  
    }
}

if(!function_exists('vibe_inpagemenu')){
    function vibe_inpagemenu(){
        global $post;
        $show_menu=getPostMeta($post->ID,'vibe_show_inpagemenu');
        if($show_menu && $show_menu == 'S'){
            $inpage_menu=getPostMeta($post->ID,'vibe_inpage_menu');
            $inpage=array();
            foreach($inpage_menu as $item){
                $nitem = preg_replace('/[^a-zA-Z0-9\']/', '_', $item);
                $nitem = str_replace("'", '', $nitem);
                $inpage[$nitem]=$item;
            }
            return $inpage;
        }else
            return 0;
    }
    
}
/*
//Search functions
if(!function_exists('search_filter_where')){
function search_filter_where($where = '') { 
            if(isset($_GET['start_date']) && $_GET['start_date'] != 'Start Date' && $_GET['start_date'] !=''){
                 $start_date = str_replace('%2F','-',$_GET['start_date']);
                $where .= " AND post_date >= '" . $start_date . "'";
             }
            if(isset($_GET['end_date']) && $_GET['end_date'] != 'End Date'  && $_GET['end_date'] != ''){
                 $end_date = str_replace('%2F','-',$_GET['end_date']);
                 $where .= " AND post_date <= '" . $end_date . "'";
             }
            return $where;
}

add_filter('posts_where', 'search_filter_where');
}


if(!function_exists('search_filter_orderby')){
function search_filter_orderby($sortby='') {
    if(isset($_GET['sort_by'])  && $_GET['sort_by'] != '' && !in_array($_GET['sort_by'],array('sale','price'))){
                $sortby =  ''.$_GET['sort_by'].' '.$_GET['sort_order'].'';
             }
              
            return $sortby;
} 
add_filter( 'posts_orderby','search_filter_orderby',10,2);
}
*/

function wp_get_attachment_info( $attachment_id ) {
       
	$attachment = get_post( $attachment_id );
        if(isset($attachment)){
	return array(
		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href' => get_permalink( $attachment->ID ),
		'src' => $attachment->guid,
		'title' => $attachment->post_title
	);
       }
}

/*  For Debugging
function wpse70214_posts_request( $query_string )
{
    var_dump( $query_string );
    return $query_string;
}
add_action( 'posts_request', 'wpse70214_posts_request' );

*/

/*====

function sale_price_sort($query) {
        if(isset($_GET['sort_by'])  && $_GET['sort_by'] != '' && $_GET['sort_by'] == 'sale'){
                 $query->set('meta_key', '_sale_price');
              } 
              
              if(isset($_GET['sort_by'])  && $_GET['sort_by'] != '' && $_GET['sort_by'] == 'price'){
                 $query->set('meta_key', '_price');
              } 
}
add_action('pre_get_posts','sale_price_sort');


*/


function set_wpmenu(){
    echo '<p style="padding:20px 0 10px;text-align:center;">Setup Menus</p>';
}

function trim_excerpt($text) {
  return rtrim($text,'[...]');
}
add_filter('get_the_excerpt', 'trim_excerpt');


//SEO FRIENDLY IMAGES


	function remove_extension($name) {
		return preg_replace('/(.+)\..*$/', '$1', $name);
	} 
	function seo_friendly_images_process($matches) {
		global $post, $vibe_options;
		$title = $post->post_title;
		$alttext_rep = $vibe_options['seo_alt'];
		$titletext_rep = $vibe_options['seo_title'];;
		$override= $vibe_options['image_alt'];;
		$override_title= $vibe_options['image_title'];;
	
		# take care of unsusal endings
		$matches[0]=preg_replace('|([\'"])[/ ]*$|', '\1 /', $matches[0]);
	
		### Normalize spacing around attributes.
		$matches[0] = preg_replace('/\s*=\s*/', '=', substr($matches[0],0,strlen($matches[0])-2));
		### Get source.
	
		preg_match('/src\s*=\s*([\'"])?((?(1).+?|[^\s>]+))(?(1)\1)/', $matches[0], $source);
	
		$saved=$source[2];
	
		### Swap with file's base name.
		preg_match('%[^/]+(?=\.[a-z]{3}\z)%', $source[2], $source);
		### Separate URL by attributes.
		$pieces = preg_split('/(\w+=)/', $matches[0], -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
		### Add missing pieces.
	
		$postcats=get_the_category();
		$cats="";
		if ($postcats) {
			foreach($postcats as $cat) {
				$cats = $cat->slug. ' '. $cats;
			}
		}
	
		$posttags = get_the_tags();
	
		$tags="";
		if ($posttags) {
			foreach($posttags as $tag) {
				$tags = $tag->name . ' ' . $tags;
			}
		}
	
		if (!in_array('title=', $pieces) || $override_title) {
			$titletext_rep=str_replace("%title", $post->post_title, $titletext_rep);
                        if(isset($source[0]))
			$titletext_rep=str_replace("%name", $source[0], $titletext_rep);
			$titletext_rep=str_replace("%category", $cats, $titletext_rep);
			$titletext_rep=str_replace("%tags", $tags, $titletext_rep);
		
			$titletext_rep=str_replace('"', '', $titletext_rep);
			$titletext_rep=str_replace("'", "", $titletext_rep);
		
			$titletext_rep=str_replace("_", " ", $titletext_rep);
			$titletext_rep=str_replace("-", " ", $titletext_rep);
			//$titletext_rep=ucwords(strtolower($titletext_rep));
			if (!in_array('title=', $pieces)) {
				array_push($pieces, ' title="' . $titletext_rep . '"');
			} else {
				$key=array_search('title=',$pieces);
				$pieces[$key+1]='"'.$titletext_rep.'" ';
			}
		}
	
		if (!in_array('alt=', $pieces) || $override) {
			$alttext_rep=str_replace("%title", $post->post_title, $alttext_rep);
                        if(isset($source[0]))
			$alttext_rep=str_replace("%name", $source[0], $alttext_rep);
			$alttext_rep=str_replace("%category", $cats, $alttext_rep);
			$alttext_rep=str_replace("%tags", $tags, $alttext_rep);
			$alttext_rep=str_replace("\"", "", $alttext_rep);
			$alttext_rep=str_replace("'", "", $alttext_rep);
			$alttext_rep=(str_replace("-", " ", $alttext_rep));
			$alttext_rep=(str_replace("_", " ", $alttext_rep));
		
			if (!in_array('alt=', $pieces)) {
				array_push($pieces, ' alt="' . $alttext_rep . '"');
			} else {
				$key=array_search('alt=',$pieces);
				$pieces[$key+1]='"'.$alttext_rep.'" ';
			}
		}
		return implode('', $pieces).' /';
	}
	function seo_friendly_images($content) {
		return preg_replace_callback('/<img[^>]+/', 'seo_friendly_images_process', $content);
	}

//add_filter('the_content', 'seo_friendly_images', 100);
	//add_action( 'after_plugin_row', 'seo_friendly_images_check_plugin_version' );


function db_optimization_cron_on(){
    global $vibe_options;
    if(isset($vibe_options['optimize_db']) && $vibe_options['optimize_db'] !=0){
        $cron=$vibe_options['optimize_db'];}
        else{
            $cron='daily'; }
    wp_schedule_event(time(), $cron, 'optimize_database'); // add optimize_database to wp cron events

}

function db_optimization_cron_reschedule(){
    global $vibe_options;
    $cron=$vibe_options['optimize_db'];
   wp_reschedule_event( time(), $cron,'optimize_database'); 

}

function db_optimization_cron_off(){

    wp_clear_scheduled_hook('optimize_database'); // remove optimize_database from wp cron events

}



function optimize_database(){

    global $wpdb; // get access to $wpdb object

    $all_tables = $wpdb->get_results('SHOW TABLES',ARRAY_A); // get all table names

    foreach ($all_tables as $tables){ // loop through every table name

        $table = array_values($tables); // get table name out of array

        $wpdb->query("OPTIMIZE TABLE ".$table[0]); // run the optimize SQL command on the table

    }

}

function get_image_id($image_url) {
    global $wpdb;
    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_url'";
    $attachment = $wpdb->get_var($query);
  if($attachment)
        return $attachment;
    else
        return false;
}

/*=== Show values used in Post/Pages and CPT linked to Template layouts meta box ====*/
function get_show_values($id = ''){
    if(!$id){
        $id= get_the_ID();
    }
    
    //Configuring Default Sidebar
$show = array(
  'subheader' => 1,
  'title' => 1,  
  'breadcrumbs' => 1,
  'featured' => 1,  
  'template' => 'right',
  'headingspan' => 'span8',
  'comments' => 1,
  'meta' => 1,
  'sharing' => 0,
  'author' => 0,
  'featured' => 1,
  'prev_next' => 0,
  'sidebar' => 'mainsidebar' 
);

  
$dbvalues = array(
    'breadcrumbs' => getPostMeta($id,'vibe_subheader_breadcrumbs'),
    'title' => getPostMeta($id,'vibe_title'),
    'subheader' => getPostMeta($id,'vibe_subheader'),
    'featured' => getPostMeta($id,'vibe_featured'),
    'template' => getPostMeta($id,'vibe_sidebar_layout'),
    'comments' => getPostMeta($id,'vibe_comments'),
    'meta' => getPostMeta($id,'vibe_meta_info'),
    'sharing' => getPostMeta($id,'vibe_sharing'),
    'author' => getPostMeta($id,'vibe_author'),
    'featured' => getPostMeta($id,'vibe_featured'),
    'prev_next' => getPostMeta($id,'vibe_prev_next'),
    'sidebar' => getPostMeta($id,'vibe_sidebar')
);


foreach($dbvalues as $key => $value){
    if(isset($value) && $value){
        if($value == 'S'){
            $value = 1;
        }
        if($value == 'H'){
            $value = 0;
        }
        $show[$key]=$value;
     }
    }
    
if(!$show['breadcrumbs']){
    $show['headingspan'] = 'span12';
    }


    return $show;
}

function get_subheader_values($id = ''){
    if(!$id){
        $id= get_the_ID();
    }
    
    //Configuring Default Sidebar
$show = array(
  'subtitle'=>'',
  'color'=>'',
  'bgcolor'=>'',
  'bgimage'=>'',  
  'css'=>''  
    
);

  $sbg=wp_get_attachment_image_src( getPostMeta($id,'vibe_subheader_bg_image'),'full');
  
$dbvalues = array(
    'subtitle' => getPostMeta($id,'vibe_subtitle'),
    'subheader_color' => getPostMeta($id,'vibe_subheader_color'),
    'subheader_bg_color' => getPostMeta($id,'vibe_subheader_bg_color'),
    'subheader_bg_image' => 'url('.$sbg[0].');',
    'subheader_css' => getPostMeta($id,'vibe_subheader_css')
    
);


foreach($dbvalues as $key => $value){
    if(isset($value) && $value){
        if($value == 'S'){
            $value = 1;
        }
        if($value == 'H'){
            $value = 0;
        }
        $show[$key]=$value;
     }
    }



    return $show;
}

function get_footer_values(){
    global $vibe_options;
    $show = array();
    switch($vibe_options['footer_columns']){
        case '1': $show['span'] = 'span12';
                  $show['footer'][0] = $vibe_options['footersidebar_1'];  
            break;
        case '2': $show['span'] = 'span6';
                  $show['footer'][0] = $vibe_options['footersidebar_1'];  
                  $show['footer'][1] = $vibe_options['footersidebar_2'];  
            break;
        case '3': $show['span'] = 'span4';
                  $show['footer'][0] = $vibe_options['footersidebar_1'];  
                  $show['footer'][1] = $vibe_options['footersidebar_2'];  
                  $show['footer'][2] = $vibe_options['footersidebar_3'];  
            break;
        case '4': $show['span'] = 'span3';
                  $show['footer'][0] = $vibe_options['footersidebar_1'];  
                  $show['footer'][1] = $vibe_options['footersidebar_2'];
                  $show['footer'][2] = $vibe_options['footersidebar_3'];
                  $show['footer'][3] = $vibe_options['footersidebar_4'];
            break;
        default : $show['span'] = 'span3';
                  $show['footer'][0] = $vibe_options['footersidebar_1'];  
                  $show['footer'][1] = $vibe_options['footersidebar_2'];
                  $show['footer'][2] = $vibe_options['footersidebar_3'];
                  $show['footer'][3] = $vibe_options['footersidebar_4'];  
            break;
    }
    return $show;
}



function get_custom_css($id=''){
    $css = array(
                'header' => 1,
                'body_css' => '',
                'body_bg_image' => '',
                'general_css' => '',
                'footer' => 1 
                );
    
if(is_single() || is_page()){
    if(!isset($id) || !$id)
        $id=get_the_ID();
    
    $bg=wp_get_attachment_image_src( getPostMeta($id,'vibe_body_bg_image'), 'full');
    
$dbvalues = array(
    'header' => getPostMeta($id,'vibe_show_header'),
    'body_css' => getPostMeta($id,'vibe_body_css'),
    'body_bg_image' => 'url('.$bg[0].')',
    'general_css' => getPostMeta($id,'vibe_general_css'),
    'footer' => getPostMeta($id,'vibe_show_footer'),
);


foreach($dbvalues as $key => $value){
    if(isset($value) && $value){
        if($value == 'S'){
            $value = 1;
        }
        if($value == 'H'){
            $value = 0;
        }
        $css[$key]=$value;
     }
    }
}

return $css;
}

/*==== End Show Values ====*/


add_filter('widget_text', 'do_shortcode');
function custom_excerpt($chars=0, $id = NULL) {
	global $post;
        if(!isset($id)) $id=$post->ID;
	$text = get_post($id);
        
	if(strlen($text->post_excerpt) > 10)
            $text = $text->post_excerpt . " ";
        else
            $text = $text->post_content . " ";
        
	$text = strip_tags($text);
        $ellipsis = false;
        $text = strip_shortcodes($text);
	if( strlen($text) > $chars )
		$ellipsis = true;

	$text = substr($text,0,$chars);

	$text = substr($text,0,strrpos($text,' '));

	if( $ellipsis == true && $chars > 1)
		$text = $text . "...";
        
	return $text;
}


/// POST Views
function getPostMeta($postID,$count_key = 'post_views_count'){
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
   }
   return $count;
}

/// Like Count
add_action( 'wp_ajax_like_count', 'like_count' );
add_action( 'wp_ajax_nopriv_like_count', 'like_count' );
	function like_count(){
            if(isset($_COOKIE['like_count'.$_POST['id']])){
               _e("Already liked !","vibe"); 
            }else{
                $count = intval(getPostMeta($_POST['id'], 'like_count'));
                if(!isset($count))
                	$count =0;
                $count++;
                setcookie('like_count'.$_POST['id'], $count, time()+3600);
                update_post_meta($_POST['id'], 'like_count', $count);
                echo $count;
            }
		
            die();
   }
   
function show_terms($post_id,$tax,$num){
    $terms = wp_get_post_terms( $post_id, $tax, array("fields" => "names") );
    if(count($terms) > $num){
        $n=count($terms);
    }else{
        $n=$num;
    }   
    $str='';
    for($i=0;$i<$n;$i++){
        $str .=$terms[$i];
        if($i<($n-1))
        $str .='/';
    }
    return $str;
}   


function pagination($pages = '', $range = 4)
{  
     $showitems = ($range * 2)+1;  
 
     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
 
     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
         echo "</div>\n";
     }
}


function get_current_post_type() {
  global $post, $typenow, $current_screen;
  
  //lastly check the post_type querystring
  if( isset( $_REQUEST['post_type'] ) )
    return sanitize_key( $_REQUEST['post_type'] );
  
  elseif ( isset( $_REQUEST['post'] ) )
    return get_post_type($_REQUEST['post']);
  
  elseif ( $post && $post->post_type )
    return $post->post_type;
  
  elseif( $typenow )
    return $typenow;

  //check the global $current_screen object - set in sceen.php
  elseif( $current_screen && $current_screen->post_type )
    return $current_screen->post_type;

  //we do not know the post type!
  return 'post';
}



add_action( 'wp_ajax_postlist_pagination', 'ajax_pagination' );
function ajax_pagination(){
    
    
    $query_args = unserialize(stripslashes($_POST['query']));
    $curr_page = intval($_POST['curr']);
    $list_style = $_POST['list_style'];
    $excerpt_length = intval($_POST['excerpt_length']);
    $link = intval($_POST['link']);
    $lightbox = intval($_POST['lightbox']);
    
    
    
    if($_POST['scroll'] == 'next'){
        $curr_page++;
        $query_args['paged'] = $curr_page;
        
        $the_query = new WP_Query($query_args);
        
        while ( $the_query->have_posts() ) : $the_query->the_post();
        global $post;
        echo '<li>';
        echo thumbnail_generator($post,$list_style,1,$excerpt_length,$link,$lightbox);
        echo '</li>';
        endwhile;
        wp_reset_postdata();
    }
    
    if($_POST['scroll'] == 'previous'){
        $curr_page--;
        $query_args['paged'] = $curr_page;
        
        $the_query = new WP_Query($query_args);
        
        while ( $the_query->have_posts() ) : $the_query->the_post();
        global $post;
        echo '<li>';
        echo thumbnail_generator($post,$list_style,1,$excerpt_length,$link,$lightbox);
        echo '</li>';
        endwhile;
        wp_reset_postdata();
    }
    
    die();
}


function vibe_breadcrumbs() {  
    global $post;
   
    /* === OPTIONS === */  
    $text['home']     = 'Home'; // text for the 'Home' link  
    $text['category'] = '%s'; // text for a category page  
    $text['search']   = '%s'; // text for a search results page  
    $text['tag']      = '%s'; // text for a tag page  
    $text['author']   = '%s'; // text for an author page  
    $text['404']      = 'Error 404'; // text for the 404 page  
  
    $showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show  
    $showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show  
    $delimiter   = '<li>&rsaquo;</li>'; // delimiter between crumbs  
    $before      = '<li class="current">'; // tag before the current crumb  
    $after       = '</li>'; // tag after the current crumb  
    /* === END OF OPTIONS === */  
  
    global $post;  
    $homeLink = home_url() . '/';  
    $linkBefore = '<li>';  
    $linkAfter = '</li>';  
    $linkAttr = ' rel="v:url" property="v:title"';  
    $link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;  
  
    if (is_home() || is_front_page()) {  
  
        if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';  
  
    } else {  
  
        echo '<ul class="breadcrumbs"><li>'._('You are here : ').'</li>' . sprintf($link, $homeLink, $text['home']) . $delimiter;  
  
        if ( is_category() ) {  
            $thisCat = get_category(get_query_var('cat'), false);  
            if ($thisCat->parent != 0) {  
                $cats = get_category_parents($thisCat->parent, TRUE, $delimiter);  
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);  
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);  
                echo $cats;  
            }  
            echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;  
  
        } elseif ( is_search() ) {  
            echo $before . sprintf($text['search'], get_search_query()) . $after;  
  
        } elseif ( is_day() ) {  
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;  
            echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;  
            echo $before . get_the_time('d') . $after;  
  
        } elseif ( is_month() ) {  
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;  
            echo $before . get_the_time('F') . $after;  
  
        } elseif ( is_year() ) {  
            echo $before . get_the_time('Y') . $after;  
  
        } elseif ( is_single() && !is_attachment() ) {  
            if ( get_post_type() != 'post' ) {  
                $post_type = get_post_type_object(get_post_type());  
                $slug = $post_type->rewrite;  
                printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);  
                if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;  
            } else {  
                $cat = get_the_category(); $cat = $cat[0];  
                $cats = get_category_parents($cat, TRUE, $delimiter);  
                if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);  
                $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);  
                $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);  
                echo $cats;  
                if ($showCurrent == 1) echo $before . get_the_title() . $after;  
            }  
  
        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {  
            $post_type = get_post_type_object(get_post_type());  
            if($post_type == 'product')
                $post_type->labels->singular_name = get_option( 'woocommerce_shop_page_title' );
            echo $before . $post_type->labels->singular_name . $after;  
  
        } elseif ( is_attachment() ) {  
            $parent = get_post($post->post_parent);  
            $cat = get_the_category($parent->ID); 
            if(isset($cat[0])){
            $cat = $cat[0];  
            $cats = get_category_parents($cat, TRUE, $delimiter);  
            $cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);  
            $cats = str_replace('</a>', '</a>' . $linkAfter, $cats);  
            echo $cats;  
            }
            printf($link, get_permalink($parent), __('Attachment','vibe'));  
            
            if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;  
  
        } elseif ( is_page() && !$post->post_parent ) {  
            if ($showCurrent == 1) echo $before . get_the_title() . $after;  
  
        } elseif ( is_page() && $post->post_parent ) {  
            $parent_id  = $post->post_parent;  
            $breadcrumbs = array();  
            while ($parent_id) {  
                $page = get_page($parent_id);  
                $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));  
                $parent_id  = $page->post_parent;  
            }  
            $breadcrumbs = array_reverse($breadcrumbs);  
            for ($i = 0; $i < count($breadcrumbs); $i++) {  
                echo $breadcrumbs[$i];  
                if ($i != count($breadcrumbs)-1) echo $delimiter;  
            }  
            if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;  
  
        } elseif ( is_tag() ) {  
            echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;  
  
        } elseif ( is_author() ) {  
            global $author;  
            $userdata = get_userdata($author);  
            echo $before . sprintf($text['author'], $userdata->display_name) . $after;  
  
        } elseif ( is_404() ) {  
            echo $before . $text['404'] . $after;  
        }  
  
        if ( get_query_var('paged') ) {  
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';  
            echo __('Page','vibe') . ' ' . get_query_var('paged');  
            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';  
        }  
  
        //echo '</div>';  
  
    }  
} // end vibe_breadcrumbs()  









//Vibe Grid Infinite Scroll
add_action( 'wp_ajax_grid_scroll', 'vibe_grid_scroll' );
	function vibe_grid_scroll(){ 
            $atts = json_decode(stripslashes($_POST['args']),true);
            $output ='';
            $paged = stripslashes($_POST['page']);
            $paged++;
            
        if(!isset($atts['post_ids']) || count($atts['post_ids']) > 0){
            if(isset($atts['term']) && isset($atts['taxonomy']) && $atts['term'] !='nothing_selected'){
               
            if(isset($atts['taxonomy']) && $atts['taxonomy']!=''){
                         if($atts['taxonomy'] == 'category'){
                             $atts['taxonomy']='category_name'; 
                             }
                          if($atts['taxonomy'] == 'tag'){
                             $atts['taxonomy']='tag_name'; 
                             }   
                     }
           
                             
          $query_args=array( 'post_type' => $atts['post_type'],$atts['taxonomy'] => $atts['term'], 'posts_per_page' => $atts['grid_number'],'paged' => $paged);
          
        }else
           $query_args=array('post_type'=>$atts['post_type'], 'posts_per_page' => $atts['grid_number'],'paged' => $paged);
        
        
        if(isset($atts['masonry']) && $atts['masonry']){
            $style= 'style="width:'.$atts['column_width'].'px;"'; 
        }

        query_posts($query_args);
        while ( have_posts() ) : the_post();
        global $post;
        $output .= '<li '.(isset($atts['grid_columns'])?'class="'.$atts['grid_columns'].'"':'').' '.$style.'>';
        $output .= thumbnail_generator($post,$atts['featured_style'],$atts['grid_columns'],$atts['grid_excerpt_length'],$atts['grid_link'],$atts['grid_lightbox']);
        $output .= '</li>';
        
        endwhile;
        wp_reset_query();
        wp_reset_postdata();
        
        echo $output;
        }else{
            echo '0';
        }
                die();
}


if(isset($vibe_options['logo'])){ 
add_action("login_head", "vibe_login_head");
function vibe_login_head() {
         global $vibe_options;
	echo '
	<style>
	body.login #login h1 a {
		background: url("'.$vibe_options['logo'].'") no-repeat scroll center top transparent;
		height: 100px;
	}
	</style>
	';
    }
    
function vibe_login_url() {
return site_url();
}
add_filter( 'login_headerurl', 'vibe_login_url', 10, 4 );
}


function animation_effects(){
    $animate=array(
                                        ''=>'none',
                                        'cssanim flash'=> 'Flash',
                                        'zoom' => 'Zoom',
                                        'scale' => 'Scale',
                                        'slide' => 'Slide (Height)', 
                                        'expand' => 'Expand (Width)',
                                        'cssanim shake'=> 'Shake',
                                        'cssanim bounce'=> 'Bounce',
                                        'cssanim tada'=> 'Tada',
                                        'cssanim swing'=> 'Swing',
                                        'cssanim wobble'=> 'Flash',
                                        'cssanim wiggle'=> 'Flash',
                                        'cssanim pulse'=> 'Flash',
                                        'cssanim flip'=> 'Flash',
                                        'cssanim flipInX'=> 'Flip Left',
                                        'cssanim flipInY'=> 'Flip Top',
                                        'cssanim fadeIn'=> 'Fade',
                                        'cssanim fadeInUp'=> 'Fade Up',
                                        'cssanim fadeInDown'=> 'Fade Down',
                                        'cssanim fadeInLeft'=> 'Fade Left',
                                        'cssanim fadeInRight'=> 'Fade Right',
                                        'cssanim fadeInUptBig'=> 'Fade Big Up',
                                        'cssanim fadeInDownBig'=> 'Fade Big Down',
                                        'cssanim fadeInLeftBig'=> 'Fade Big Left',
                                        'cssanim fadeInRightBig'=> 'Fade Big Right',
                                        'cssanim bounceInUp'=> 'Bounce Up',
                                        'cssanim bounceInDown'=> 'Bounce Down',
                                        'cssanim bounceInLeft'=> 'Bounce Left',
                                        'cssanim bounceInRight'=> 'Bounce Right',
                                        'cssanim rotateIn'=> 'Rotate',
                                        'cssanim rotateInUpLeft'=> 'Rotate Up Left',
                                        'cssanim rotateInUpRight'=> 'Rotate Up Right',
                                        'cssanim rotateInDownLeft'=> 'Rotate Down Left',
                                        'cssanim rotateInDownRight'=> 'Rotate Down Right',
                                        'cssanim speedIn'=> 'Speed In',
                                        'cssanim rollIn'=> 'Roll In',
                                        'ltr'=> 'Left To Right',
                                        'rtl' => 'Right to Left', 
                                        'btt' => 'Bottom to Top',
                                        'ttb'=>'Top to Bottom',
                                        'smallspin'=> 'Small Spin',
                                        'spin'=> 'Infinite Spin'
                                        );
    return $animate;
}

if(!function_exists('vibe_main_features')){

    function vibe_main_features(){
        global $post, $vibe_options;
         echo '<div class="main_features"><ul>';  
           
         if(isset($vibe_options['listing_fields']['feature']) && is_array($vibe_options['listing_fields']['feature'])){
            foreach($vibe_options['listing_fields']['feature'] as $k=>$value){
                $label = $vibe_options['listing_fields']['label'][$k];
                $class = $vibe_options['listing_fields']['class'][$k];
                $key = 'vibe_'.strtolower(str_replace(' ', '-',$vibe_options['listing_fields']['label'][$k]));
                if($class == 'price'){
                   echo '<li class="price"><label><i class="icon-tag-1"></i> '.$label.'</label>
                   <span class="currency"><i class="'.$vibe_options['currency'].'"></i>'.getPostMeta($post->ID,$key).'</span>
                   </li>';  
                }elseif($class == 'available'){
                    if(getPostMeta($post->ID,$key))
                        echo '<li class="available"><a href="#" data-rel="tooltip" title="'.$label.'" data-original-title></a></li>';  
                }elseif($class == 'featured'){
                }elseif($class == 'address'){
                  echo '<li class="listing_address">'.getPostMeta($post->ID,$key).'</li>';   
                }elseif($vibe_options['listing_fields']['field_type'][$k] == 'checkbox'){
                    $val=getPostMeta($post->ID,$key);
                    if(isset($val) && $val)
                        echo '<li class="fieldon"><a href="#" data-rel="tooltip" title="'.$label.'" data-original-title="title="'.$label.'"><i class="'.$class.'"></i></a></li>'; 
                }elseif($vibe_options['listing_fields']['field_type'][$k] == 'select' ){
                    
                    $vars=explode('|',$vibe_options['listing_fields']['label'][$k]);
                    if(isset($vars[1])){
                        $options = explode(',',$vars[1]);
                        $k='vibe_'.strtolower(str_replace(' ', '-',$vars[0]));
                        $val=getPostMeta($post->ID,$k);
                        if(isset($val) && $val)
                            echo '<li><label><i class="'.$class.'"></i> '.$vars[0].'</label><span>'.$val.'</span></li>';
                    }
                }else
                        echo '<li><label><i class="'.$class.'"></i> '.$label.'</label><span>'.getPostMeta($post->ID,$key).'</span></li>'; 
            }
         }
         echo '</ul></div>';
         
    }
}    

if(!function_exists('vibe_listing_features')){
    function vibe_listing_features(){
        global $post, $vibe_options;


        echo '<div class="listing_features_tab"><ul>';
        if(isset($vibe_options['listing_fields']['field_type']) && is_array($vibe_options['listing_fields']['field_type'])){
            

            foreach($vibe_options['listing_fields']['field_type'] as $k=>$value){

                if(!isset($vibe_options['hide_feature']) || ($vibe_options['hide_feature'] == 0) || ($vibe_options['hide_feature'] == 1 && !isset($vibe_options['listing_fields']['feature'][$k]))){


                $label = $vibe_options['listing_fields']['label'][$k];
                $class = $vibe_options['listing_fields']['class'][$k];
                $key = 'vibe_'.strtolower(str_replace(' ', '-',$vibe_options['listing_fields']['label'][$k]));
                $val = getPostMeta($post->ID,$key);

                if(is_array($val) || $vibe_options['listing_fields']['field_type'][$k] == 'available'){
                    
                }elseif($vibe_options['listing_fields']['field_type'][$k] == 'checkbox'){
                    $val=getPostMeta($post->ID,$key);
                    if(isset($val) && $val)
                        echo '<li class="fieldon"><a href="#" data-rel="tooltip" title="'.$label.'" data-original-title="title="'.$label.'"><i class="'.$class.'"></i></a></li>'; 
                }elseif($vibe_options['listing_fields']['field_type'][$k] == 'select' ){
                    
                    $vars=explode('|',$vibe_options['listing_fields']['label'][$k]);
                    if(isset($vars[1])){
                        $options = explode(',',$vars[1]);
                        $k='vibe_'.strtolower(str_replace(' ', '-',$vars[0]));
                        $val=getPostMeta($post->ID,$k);
                        if(isset($val) && $val)
                            echo '<li><label><i class="'.$class.'"></i> '.$vars[0].'</label><span>'.$val.'</span></li>';
                    }
                }elseif($vibe_options['listing_fields']['field_type'][$k] == 'multiselect' || $vibe_options['listing_fields']['class'][$k] == 'amenities' ){
                    
                    $vars=explode('|',$vibe_options['listing_fields']['label'][$k]);

                   
                    if(isset($vars[1])){
                        $options = explode(',',$vars[1]);
                        $k='vibe_'.strtolower(str_replace(' ', '-',$vars[0]));
                        $val=getPostMeta($post->ID,$k);
                        echo '<li class="amenities_title"><h3>'.$vars[0].'</h3></li><li class="no-border">';
                        foreach($options as $option){
                            if(isset($val) && is_array($val) && in_array($option,$val)){
                            echo '<span class="amenities"><i class="icon-ok-1"></i> '.$option.'</span>';
                            }
                        }
                        echo '</li>';
                    }
                    
                   }elseif($vibe_options['listing_fields']['field_type'][$k] == 'featured'){
                   echo '<li class="fieldon"><a href="#" data-rel="tooltip" title="'.$label.'" data-original-title="title="'.$label.'"><i class="icon-star"></i></a></li>'; 
                }else
                    echo '<li><label><i class="'.$class.'"></i> '.$label.'</label><span>'.$val.'</span></li>'; 
                }
            } //Hide Featured
         }
        echo '</ul></div>';  
    }
}    


if(!function_exists('vibe_agent_contactform')){
    function vibe_agent_contactform(){
        global $post, $vibe_options;
         if(isset($vibe_options['listing_fields']['field_type']) && is_array($vibe_options['listing_fields']['field_type'])){
             foreach($vibe_options['listing_fields']['field_type'] as $k=>$value){
                if($vibe_options['listing_fields']['field_type'][$k] == 'agents'){
                    $key = 'vibe_'.strtolower(str_replace(' ', '-',$vibe_options['listing_fields']['label'][$k]));
                    $value = getPostMeta($post->ID,$key); 

                    $email=get_option('admin_email'); 
                    if(isset($value)){
                        if(is_array($value)){
                            foreach($value as $id){
                                $image=getPostMeta($id,'vibe_agent_image'); 
                                    if(wp_attachment_is_image($image)){
                                        $image= wp_get_attachment_image_src ($image);
                                    $image= $image[0];
                                    }
                                echo '<div class="agent_small_intro">';
                                echo '<div class="agent_image"><a href="'.get_permalink($id).'"><img src="'.$image.'" alt="agent pic" /></a></div>';
                                $userid = getPostMeta($id,'vibe_agent_id');
                                $user = get_userdata($userid);
                                $email .= ','.$user->user_email;
                                
                                echo '<h4 class="agent_name"><a href="'.get_permalink($id).'">'.get_the_title($id).' <span><i class="icon-mail-2"></i>'.getPostMeta($id,'vibe_agent_email').' , <i class="icon-mobile"></i>'.getPostMeta($id,'vibe_agent_phone').'</span></a></h4>';
                                echo '<p class="agent_desc">'.custom_excerpt(70,$id).'</p>';
                                echo '</div>';
                            }
                        }else{
                            global $post;
                            $author_id = $post->post_author;
                            $id = get_user_meta($author_id,'agent_profile',true);

                            $image=getPostMeta($id,'vibe_agent_image'); 
                            if(wp_attachment_is_image($image)){
                                $image= wp_get_attachment_image_src ($image);
                            $image= $image[0];
                            }

                            echo '<div class="agent_small_intro">';
                            echo '<div class="agent_image"><a href="'.get_permalink($id).'"><img src="'.$image.'" alt="agent pic" /></a></div>';
                            $userid = $author_id;
                            $user = get_userdata($userid);
                            $email .= ','.$user->user_email;
                            
                            echo '<h4 class="agent_name"><a href="'.get_permalink($id).'">'.get_the_title($id).' <span><i class="icon-mail-2"></i>'.getPostMeta($id,'vibe_agent_email').' , <i class="icon-mobile"></i>'.getPostMeta($id,'vibe_agent_phone').'</span></a></h4>';
                            echo '<p class="agent_desc">'.custom_excerpt(70).'</p>';
                            echo '</div>';
                        }
                    }else{

                    }
                    break;
                } 
             }
         }
         $subject = (isset($vibe_options['agent_email_subject'])?$vibe_options['agent_email_subject']:__('Contact Form Submission','vibe'));
        echo '<div class="agent_contact_form"><h3>'.__('Contact Agents','vibe').'</h3>'.do_shortcode('[form email="'.$email.'" subject="'.$subject.'" ] [form_element type="text" validate="" options="" placeholder="Name"] [form_element type="text" validate="email" options="" placeholder="Email"] [form_element type="textarea" validate="" options="" placeholder="Contact"] [form_element type="submit" validate="" options="" placeholder="Send Message"] [/form]').'</div>';
    }
}    

// Woocommerce Functions & fixes

/**
 * @credits WPSnacks.com
 */


if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    remove_action('woocommerce_pagination', 'woocommerce_pagination', 10);
    add_action( 'woocommerce_pagination', 'pagination', 10);
}

if(!function_exists('update_vibe_agent_membership')){
   function update_vibe_agent_membership($days,$id){
        global $current_user;
        get_currentuserinfo();

        $expiry=get_user_meta($current_user->ID,'vibe_membership_expire',true);
        $lastorder=get_user_meta($current_user->ID,'vibe_membership_order',true);
       
        if($id != $lastorder){
            $lastorder=$id;

            if(isset($expiry) && $expiry){
                $expiry = $expiry + 86400*$days;
                update_user_meta($current_user->ID,'vibe_membership_expire',$expiry);
            }else{
                $expiry=0;
                $expiry= time()+86400*$days;
                add_user_meta($current_user->ID,'vibe_membership_expire',$expiry);
            } 
            update_user_meta($current_user->ID,'vibe_membership_order',$lastorder);

            if(is_user_logged_in()){
                global $current_user;
                get_currentuserinfo();
                $user_roles = $current_user->roles;
                $user_role = array_shift($user_roles);

                if($user_role == 'subscriber'){
                    $current_user->remove_role( 'subscriber' );
                    $current_user->add_role( 'agent1' );
                }
            }
            

        }
    } 
}

/// BEGIN AJAX HANDELERS
add_action( 'wp_ajax_update_search_selects', 'update_search_selects' );
add_action( 'wp_ajax_nopriv_update_search_selects', 'update_search_selects' );

if(!function_exists('update_search_selects')){
   function update_search_selects(){
    $tab=str_replace('#','',$_POST['slug']);
    $tax=$_POST['tax'];
    global $vibe_options;
    $vibe_advanced_listings_search=get_option('vibe_advanced_listings_search');

    if(isset($vibe_options['listing_taxonomies']) && is_array($vibe_options['listing_taxonomies']) && is_array($vibe_options['listing_taxonomies']['search'])){
            foreach($vibe_options['listing_taxonomies']['search'] as $key => $value){
                $slug=$vibe_options['listing_taxonomies']['slug'][$key];
                $label=$vibe_options['listing_taxonomies']['label'][$key];
                $type=$vibe_options['listing_taxonomies']['field_type'][$key];


        if(($tax != $slug) && ($type != 'id')){
        echo '<li class="search_select">';
        echo '<select name="'.$slug.'[]" data-placeholder="'.$label.'"  class="chosen-select chzn-select" multiple>';

        if(!isset($_POST['sort'])){
            $_POST['sort'] = 'name';
        }
        if(!isset($_POST['sortby'])){
            $_POST['sortby'] = 'ASC';
        }
        $args = array(
                        'orderby' => $_POST['sort'],
                        'order' => $_POST['sortby']
                                );    

        $locations = get_terms($slug,$args);
        $c='';
        foreach($locations as $location){
            if(isset($_POST['count']) && $_POST['count']){
                if(isset($vibe_advanced_listings_search) && $vibe_advanced_listings_search[$tab][$slug][$location->slug]){
                    $c='('.(isset($vibe_advanced_listings_search[$tab][$slug][$location->slug])?$vibe_advanced_listings_search[$tab][$slug][$location->slug]:'').')';
                }else
                $c= '('.$location->count.')';
            }

            if(isset($vibe_advanced_listings_search)){    
                if(isset($vibe_advanced_listings_search[$tab][$slug][$location->slug]) && $vibe_advanced_listings_search[$tab][$slug][$location->slug]){
                    echo '<option value="'.$location->slug.'">'.$location->name.''.$c.'</option>';     
                }
            }else{    
               echo '<option value="'.$location->slug.'">'.$location->name.''.$c.'</option>';
            }

            
        }
        echo '</select></li>'; 
        }
           }
        } 
        die();
   }
}

?>
