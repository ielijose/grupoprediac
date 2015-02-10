<?php

global $vibe_options;

$vibe_options = get_option(THEME_SHORT_NAME);
$sidebars=$GLOBALS['wp_registered_sidebars'];
$sidebararray=array();
foreach($sidebars as $sidebar){
    $sidebararray[]= array('label'=>$sidebar['name'],'value'=>$sidebar['id']);
}

function default_sidebar(){
    global $vibe_options,$post;
    $return='';
 $post_type=get_current_post_type();
    if(isset($vibe_options['sidebar_defaults']) && is_array($vibe_options['sidebar_defaults']))
foreach($vibe_options['sidebar_defaults'] as $sidebar => $post_type_array){ 
        $key=array_search($post_type, $post_type_array);
        if(strlen($key)>0){
            $return = $sidebar;
        }
    }
    
    if(!$return){
        $return = 'mainsidebar';
    }
    
    return $return;
}


$prefix = 'vibe_';

$post_metabox = array(
	0 => array( 
                'label'	=> __('Template Layout','vibe'), // <label>
		'desc'	=> __('Template Layout.','vibe'), // description
		'id'	=> $prefix.'sidebar_layout', // field id and name
		'type'	=> 'radio_img', // type of field
		'options' => array ( // array of options
			'one' => array ( // array key needs to be the same as the option value
				'label' => __('Right Sidebar','vibe'), // text displayed as the option
				'value'	=> 'right', // value stored for the option
                                'image'	=> VIBE_URL.'/includes/metaboxes/images/right-sidebar.png' // value stored for the option
			),
			'two' => array (
				'label' => __('Left Sidebar','vibe'),
				'value'	=> 'left',
                                'image'	=> VIBE_URL.'/includes/metaboxes/images/left-sidebar.png' // value stored for the option
			),
                        'three' => array ( // array key needs to be the same as the option value
				'label' =>  __('No Sidebars','vibe'), // text displayed as the option
				'value'	=> 'full', // value stored for the option
                                'image'	=> VIBE_URL.'/includes/metaboxes/images/no-sidebar.png' // value stored for the option
                                
			)
			
		),
            'std'=>'right'
	),
        1 => array( // Select box
		'label'	=> __('Select Sidebar for Layout','vibe'), // <label>
		'desc'	=> __('Select Sidebar shown in the Post layout.','vibe'), // description
		'id'	=> $prefix.'sidebar', // field id and name
		'type'	=> 'select', // type of field
		'options' => $sidebararray,
                'std' => default_sidebar()
	),
        2 => (!in_array(get_current_post_type(), array('page','product','portfolio')))?array( // Single checkbox
		'label'	=> __('Show Author Information','vibe'), // <label>
		'desc'	=> __('Author information below post content.','vibe'), // description
		'id'	=> $prefix.'author', // field id and name
		'type'	=> 'showhide', // type of field
                'options' => array(
                            0 =>'Hide',
                            1 => 'Show'  
                ),
                'std'   => 'H'
	):array( // Single checkbox
		'label'	=> '', // <label>
		'desc'	=> '', // description
		'type'	=> 'divider', // type of field
	),
         3 => array( // Single checkbox
		'label'	=> __('Show Subheader (Title & Breadcrumbs)','vibe'), // <label>
		'desc'	=> __('Show Subheader (Title & Breadcrumbs) below main menu.','vibe'), // description
		'id'	=> $prefix.'subheader', // field id and name
		'type'	=> 'showhide', // type of field
                'options' => array(
                  0 =>'Hide',
                  1 => 'Show'  
                ),
                'std'   => 'S'
	),
        4 => array( // Single checkbox
		'label'	=> __('Show Page Title','vibe'), // <label>
		'desc'	=> __('Show Page/Post Title.','vibe'), // description
		'id'	=> $prefix.'title', // field id and name
		'type'	=> 'showhide', // type of field
                'options' => array(
                  0 =>'Hide',
                  1 => 'Show'  
                ),
                'std'   => 'S'
	),
        5 => array( // Single checkbox
		'label'	=> __('Show Breadcrumbs','vibe'), // <label>
		'desc'	=> __('Show Breadcrumbs in Subheader (Only is Subheader is visible).','vibe'), // description
		'id'	=> $prefix.'subheader_breadcrumbs', // field id and name
		'type'	=> 'showhide', // type of field
                'options' => array(
                  0 =>'Hide',
                  1 => 'Show'  
                ),
                'std'   => 'S'
	),
        6 => (!in_array(get_current_post_type(), array('page','product')))?array( // Single checkbox
		'label'	=> __('Show Featured','vibe'), // <label>
		'desc'	=> __('Show Featured Media above post content.','vibe'), // description
		'id'	=> $prefix.'featured', // field id and name
		'type'	=> 'showhide', // type of field
                'options' => array(
                            0 =>'Hide',
                            1 => 'Show'  
                ),
                'std'   => 'S'
	):array( // Single checkbox
		'label'	=> '', // <label>
		'desc'	=> '', // description
		'type'	=> 'divider', // type of field
	),
         7 => (!in_array(get_current_post_type(), array('page','product')))?array( // Single checkbox
		'label'	=> __('Show Sharing info','vibe'), // <label>
		'desc'	=> __('Show sharing icons below the post.','vibe'), // description
		'id'	=> $prefix.'sharing', // field id and name
		'type'	=> 'showhide', // type of field
                'options' => array(
                  0 =>'Hide',
                  1 => 'Show'  
                ),
                'std'   => 'S'
	):array( // Single checkbox
		'label'	=> '', // <label>
		'desc'	=> '', // description
		'type'	=> 'divider', // type of field
	),
         8 => (!in_array(get_current_post_type(), array('page','product')))?array( // Single checkbox
		'label'	=> __('Show Meta info','vibe'), // <label>
		'desc'	=> __('Show Meta information on left side post.','vibe'), // description
		'id'	=> $prefix.'meta_info', // field id and name
		'type'	=> 'showhide', // type of field
                'options' => array(
                  0 =>'Hide',
                  1 => 'Show'  
                ),
                'std'   => 'S'
	):array( // Single checkbox
		'label'	=> '', // <label>
		'desc'	=> '', // description
		'type'	=> 'divider', // type of field
	),
         9 => (!in_array(get_current_post_type(), array('page','product')))?array( // Single checkbox
		'label'	=> __('Show Comments','vibe'), // <label>
		'desc'	=> __('Show comments below post & comment info below date.','vibe'), // description
		'id'	=> $prefix.'comments', // field id and name
		'type'	=> 'showhide', // type of field
                'options' => array(
                  0 =>'Hide',
                  1 => 'Show'  
                ),
                'std'   => 'S'
	):array( // Single checkbox
		'label'	=> '', // <label>
		'desc'	=> '', // description
		'type'	=> 'divider', // type of field
	),
        10 => (get_current_post_type() != 'page')?array( // Single checkbox
		'label'	=> __('Show Prev/Next Links','vibe'), // <label>
		'desc'	=> __('Show previous/next links on top below the Subheader.','vibe'), // description
		'id'	=> $prefix.'prev_next', // field id and name
		'type'	=> 'showhide', // type of field
                'options' => array(
                  0 =>'Hide',
                  1 => 'Show'  
                ),
                'std'   => 'H'
	):array( // Single checkbox
		'label'	=> '', // <label>
		'desc'	=> '', // description
		'type'	=> 'divider', // type of field
	),
    );


$featured_metabox = array(
     array( // Select box
		'label'	=> __('Media','vibe'), // <label>
		'id'	=> $prefix.'select_featured', // field id and name
		'type'	=> 'select', // type of field
		'options' => array ( // array of options
                        'zero' => array ( // array key needs to be the same as the option value
				'label' => __('Disable','vibe'), // text displayed as the option
				'value'	=> 'disable' // value stored for the option
			),
			'one' => array ( // array key needs to be the same as the option value
				'label' => __('Gallery','vibe'), // text displayed as the option
				'value'	=> 'gallery' // value stored for the option
			),
			'two' => array (
				'label' => __('Self Hosted Video','vibe'),
				'value'	=> 'video'
			),
                        'three' => array (
				'label' => __('IFrame Video','vibe'),
				'value'	=> 'iframevideo'
			),
			'four' => array (
				'label' => __('Self Hosted Audio','vibe'),
				'value'	=> 'audio'
			),
            'five' => array (
				'label' => __('Other','vibe'),
				'value'	=> 'other'
			)
		)
	),
    
        
        array( // Repeatable & Sortable Text inputs
		'label'	=> __('Gallery','vibe'), // <label>
		'desc'	=> __('Create a Gallery in post.','vibe'), // description
		'id'	=> $prefix.'slider', // field id and name
		'type'	=> 'gallery' // type of field
	),
        
	array( // Textarea
		'label'	=> __('Self Hosted Video','vibe'), // <label>
		'desc'	=> __('Select video files (of same Video): xxxx.mp4,xxxx.ogv,xxxx.ogg for max. browser compatibility','vibe'), // description
		'id'	=> $prefix.'featuredvideo', // field id and name
		'type'	=> 'video' // type of field
	),
        array( // Textarea
		'label'	=> __('IFRAME Video','vibe'), // <label>
		'desc'	=> __('Insert Iframe (Youtube,Vimeo..) embed code of video ','vibe'), // description
		'id'	=> $prefix.'featurediframevideo', // field id and name
		'type'	=> 'textarea' // type of field
	),
        array( // Text Input
		'label'	=> __('Audio','vibe'), // <label>
		'desc'	=> __('Select audio files (of same Audio): xxxx.mp3,xxxx.wav,xxxx.ogg for max. browser compatibility','vibe'), // description
		'id'	=> $prefix.'featured_audio', // field id and name
		'type'	=> 'audio' // type of field
	),
        array( // Textarea
		'label'	=> __('Other','vibe'), // <label>
		'desc'	=> __('Insert Shortcode or relevant content.','vibe'), // description
		'id'	=> $prefix.'featuredother', // field id and name
		'type'	=> 'textarea' // type of field
	)
	
    );

$custom_css_metabox = array(
	array( // Single checkbox
		'label'	=> __('Show Header','vibe'), // <label>
		'desc'	=> __('Show/Hide Header with this setting.','vibe'), // description
		'id'	=> $prefix.'show_header', // field id and name
		'type'	=> 'showhide', // type of field
                'options' => array(
                  0 =>'Hide',
                  1 => 'Show'  
                ),
                'std'   => 'S'
	),
        array( // Text Input
		'label'	=> __('Body Custom CSS','vibe'), // <label>
		'desc'	=> __('Custom CSS included in body.','vibe'), // description
		'id'	=> $prefix.'body_css', // field id and name
		'type'	=> 'textarea' // type of field
	),
        array( // Text Input
		'label'	=> __('Body Background Image','vibe'), // <label>
		'desc'	=> __('Select/Upload a background image.','vibe'), // description
		'id'	=> $prefix.'body_bg_image', // field id and name
		'type'	=> 'image' // type of field
	),
        array( // Single checkbox
		'label'	=> __('Show Footer','vibe'), // <label>
		'desc'	=> __('Show/Hide Footer with this setting.','vibe'), // description
		'id'	=> $prefix.'show_footer', // field id and name
		'type'	=> 'showhide', // type of field
                'options' => array(
                  0 =>'Hide',
                  1 => 'Show'  
                ),
                'std'   => 'S'
	),
        array( 
		'label'	=> __('General CSS','vibe'), // <label>
		'desc'	=> __('Enter general CSS.','vibe'), // description
		'id'	=> $prefix.'general_css', // field id and name
		'type'	=> 'textarea', // type of field
                'std'   => ''
	),
	
    );

$subheader_css_metabox = array(
	
        array( 
		'label'	=> __('Sub-Title In Subheader','vibe'), // <label>
		'desc'	=> __('Enter a Sub-Title. Appears below the Page Title (Supports HTML)','vibe'), // description
		'id'	=> $prefix.'subtitle', // field id and name
		'type'	=> 'textarea', // type of field
                'std'   => ''
	),
        array( // Text Input
		'label'	=> __('Subheader Background color','vibe'), // <label>
		'desc'	=> __('Select/Enter a background color (Hexadecimal code).','vibe'), // description
		'id'	=> $prefix.'subheader_bg_color', // field id and name
		'type'	=> 'color' // type of field
	),
        array( // Text Input
		'label'	=> __('Subheader Font color','vibe'), // <label>
		'desc'	=> __('Select/Enter a color (Hexadecimal code).','vibe'), // description
		'id'	=> $prefix.'subheader_color', // field id and name
		'type'	=> 'color' // type of field
	),
        array( // Text Input
		'label'	=> __('Subheader Background Image','vibe'), // <label>
		'desc'	=> __('Select/Upload a background image.','vibe'), // description
		'id'	=> $prefix.'subheader_bg_image', // field id and name
		'type'	=> 'image' // type of field
	),
        
        array( 
		'label'	=> __('Custom CSS for Subheader','vibe'), // <label>
		'desc'	=> __('Customize Subheader style using pure CSS.','vibe'), // description
		'id'	=> $prefix.'subheader_css', // field id and name
		'type'	=> 'textarea', // type of field
                'std'   => ''
	)
	
    );

    
$wp_user_search = new WP_User_Query(array('fields'=>array('ID','display_name')));
$users=$wp_user_search->get_results();

foreach($users as $user){
    
    $agents[]=array('label'=>$user->display_name,'value'=>$user->ID);
}

$agent_metabox = array(
        array( // Single checkbox
		'label'	=> __('Agent UserID','vibe'), // <label>
		'desc'	=> __('Select Agent UserId.','vibe'), // description
		'id'	=> $prefix.'agent_id', // field id and name
		'type'	=> 'select', // type of field
                'options' => $agents
	), 
       array( // Text Input
		'label'	=> __('Agent Image','vibe'), // <label>
		'desc'	=> __('Upload/Select Agent image.','vibe'), // description
		'id'	=> $prefix.'agent_image', // field id and name
		'type'	=> 'image' // type of field
	),
       array( // Text Input
		'label'	=> __('Agent Phone Number','vibe'), // <label>
		'desc'	=> __('Enter agent number to be displayed.','vibe'), // description
		'id'	=> $prefix.'agent_phone', // field id and name
		'type'	=> 'text' // type of field
	),
       array( // Text Input
		'label'	=> __('Agent Email Id','vibe'), // <label>
		'desc'	=> __('Enter agent email id to be displayed.','vibe'), // description
		'id'	=> $prefix.'agent_email', // field id and name
		'type'	=> 'text' // type of field
	),
       array( // Single checkbox
		'label'	=> __('Show Agent Listings','vibe'), // <label>
		'desc'	=> __('Show Listings made by agent.','vibe'), // description
		'id'	=> $prefix.'show_listing', // field id and name
		'type'	=> 'showhide', // type of field
                'options' => array(
                  0 =>'Hide',
                  1 => 'Show'  
                ),
                'std'   => 'S'
	), 
	
    );


$inpage_metabox = array(
        array( // Single checkbox
		'label'	=> __('Show In-Page Menu','vibe'), // <label>
		'desc'	=> __('Show/Hide in Page Menu.','vibe'), // description
		'id'	=> $prefix.'show_inpagemenu', // field id and name
		'type'	=> 'showhide', // type of field
                'options' => array(
                  0 =>'Hide',
                  1 => 'Show'  
                ),
                'std'   => 'H'
	),   
	array( // Text Input
		'label'	=> __('Enter Element Name/IDs ','vibe'), // <label>
		'desc'	=> __('Enter the reference title of the Page block elements.','vibe'), // description
		'id'	=> $prefix.'inpage_menu', // field id and name
		'type'	=> 'repeatable' // type of field
	)
	
    );


if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		$agent_membership = array(
        array( // Single checkbox
		'label'	=> __('Add Agent membership','vibe'), // <label>
		'desc'	=> __('Add Agent membership.','vibe'), // description
		'id'	=> $prefix.'agent_membership', // field id and name
		'type'	=> 'showhide', // type of field
                'options' => array(
                  0 =>'Hide',
                  1 => 'Show'  
                ),
                'std'   => 'H'
	),   
	array( // Text Input
		'label'	=> __('Agent Membership in Days ','vibe'), // <label>
		'desc'	=> __('The Purchaser will get Agent access for X days after which it is automatically removed.','vibe'), // description
		'id'	=> $prefix.'agent_days', // field id and name
		'type'	=> 'number' // type of field
	)
	
    );
}

$testimonial_metabox = array(
        array( // Text Input
		'label'	=> __('Author Image','vibe'), // <label>
		'desc'	=> __('Upload/Select author image.','vibe'), // description
		'id'	=> $prefix.'testimonial_author_image', // field id and name
		'type'	=> 'image' // type of field
	),    
	array( // Text Input
		'label'	=> __('Author Name','vibe'), // <label>
		'desc'	=> __('Enter the name of the testimonial author.','vibe'), // description
		'id'	=> $prefix.'testimonial_author_name', // field id and name
		'type'	=> 'text' // type of field
	),
        array( // Text Input
		'label'	=> __('Designation','vibe'), // <label>
		'desc'	=> __('Enter the testimonial author\'s designation.','vibe'), // description
		'id'	=> $prefix.'testimonial_author_designation', // field id and name
		'type'	=> 'text' // type of field
	)
	
    );

if(isset($vibe_options['meta_featured'])){
foreach($vibe_options['meta_featured'] as $post_type){
$post_box = new custom_add_meta_box( 'featured-media', __('Featured Media','vibe'), $featured_metabox, $post_type, 'side' );
}
}
if(isset($vibe_options['meta_layouts'])){
foreach($vibe_options['meta_layouts'] as $post_type){
$post_box = new custom_add_meta_box( 'post-info', strtoupper(get_current_post_type()).' Settings', $post_metabox, $post_type, true );
}
}

$slider_box = new custom_add_meta_box( 'featured-media', 'Featured Media', $featured_metabox, 'featured', true );
$testimonial_box = new custom_add_meta_box( 'testimonial-info', 'Testimonial Author Information', $testimonial_metabox, 'testimonials', true );
$agent_box = new custom_add_meta_box( 'agent-meta', 'Agent Id', $agent_metabox, 'agent', true );

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	if(isset($vibe_options['add_membership']) && $vibe_options['add_membership']){
		$membership_box = new custom_add_meta_box( 'post-info', 'Agent Membership', $agent_membership , 'product', true );
	}
}

if(isset($vibe_options['inpage_menu'])){
foreach($vibe_options['inpage_menu'] as $post_type){
    $inpage_metabox = new custom_add_meta_box( 'inpage-info', 'In-Page Menu', $inpage_metabox, $post_type, true );
 }
}


if(isset($vibe_options['subheader_css_changes'])){
foreach($vibe_options['subheader_css_changes'] as $post_type){
    $subheader_box = new custom_add_meta_box( 'subheader-info', 'Sub-Header Changes', $subheader_css_metabox, $post_type, true );
 }
}


if(isset($vibe_options['custom_css_changes'])){
foreach($vibe_options['custom_css_changes'] as $post_type){
    $landing_box = new custom_add_meta_box( 'customcss-info', 'Custom CSS Changes', $custom_css_metabox, $post_type, true );
}
}

add_action( 'add_meta_boxes', 'add_vibe_editor' );
//Adding Layout Builder for Posts
function add_vibe_editor(){
    global $vibe_options;
    foreach($vibe_options['meta_builder'] as $post_type){
    add_meta_box( 'vibe-editor', __( 'Page Builder', 'vibe' ), 'vibe_layout_editor', $post_type, 'normal', 'high' );
    }
    
   // add_meta_box( 'vibe_advanced_featured', __( 'Add Slider', 'vibe' ), 'vibe_advanced_featured', 'post', 'side' );
}
   
/*=== Dynamic Listings MetaBox ===*/
$listings_metabox=array();
if(isset($vibe_options['listing_fields']) && is_array($vibe_options['listing_fields'])){
    //print_r($vibe_options['listing_fields']);
        for($i=0;$i<=max(array_keys($vibe_options['listing_fields']['label']));$i++){
            if(isset($vibe_options['listing_fields']['label'][$i])){
            if($vibe_options['listing_fields']['field_type'][$i] == 'select' || $vibe_options['listing_fields']['field_type'][$i] == 'multiselect' ){
                $vars=explode('|',$vibe_options['listing_fields']['label'][$i]);
                $vibe_options['listing_fields']['label'][$i]=$vars[0];
                if(isset($vars[1]))
                    $options = explode(',',$vars[1]);
                else
                    $options = array('Options does not exist');
            }
            $label=$vibe_options['listing_fields']['label'][$i];
            if($vibe_options['listing_fields']['field_type'][$i] == 'multiselect' ){
                $l=explode('|',$vibe_options['listing_fields']['label'][$i]);
                $label=$l[0];
            }

           $listings_metabox[$i]= array( // Text Input
		'label'	=> $vibe_options['listing_fields']['label'][$i], // <label>
		'desc'	=> ''.(($vibe_options['listing_fields']['field_type'][$i] == 'number' || $vibe_options['listing_fields']['field_type'][$i] == 'price')?'Enter only number':''), // description
		'id'	=> $prefix.strtolower(str_replace(' ', '-',$label)), // field id and name
		'type'	=> $vibe_options['listing_fields']['field_type'][$i], // type of field
		'std' => '3344'
            );
           if($vibe_options['listing_fields']['field_type'][$i] == 'select' || $vibe_options['listing_fields']['field_type'][$i] == 'multiselect' ){
                 $listings_metabox[$i]['options'] = array();;
                 for($j=0;$j<count($options);$j++){
                     $listings_metabox[$i]['options'][]=array('label'=>$options[$j],'value'=>$options[$j]);
                 }
               
                 $listings_metabox[$i]['std']=0;
           }
          }
        }
   $listings_meta = new custom_add_meta_box( 'listing-info', 'Listing Details', $listings_metabox, LISTING, true );
}