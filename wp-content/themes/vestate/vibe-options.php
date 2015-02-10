<?php

if(!class_exists('VIBE_Options')){
	require_once( dirname( __FILE__ ) . '/options/options.php' );
}

/*
 * 
 * Custom function for filtering the sections array given by theme, good for child themes to override or add to the sections.
 * Simply include this function in the child themes functions.php file.
 *
 * NOTE: the defined constansts for urls, and dir will NOT be available at this point in a child theme, so you must use
 * get_template_directory_uri() if you want to use any of the built in icons
 *
 */
function add_another_section($sections){
	
	//$sections = array();
	$sections[] = array(
				'title' => __('A Section added by hook', 'vibe'),
				'desc' => '<p class="description">'.__('This is a section created by adding a filter to the sections array, great to allow child themes, to add/remove sections from the options.', 'vibe').'</p>',
				//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
				//You dont have to though, leave it blank for default.
				'icon' => trailingslashit(get_template_directory_uri()).'options/img/glyphicons/glyphicons_062_attach.png',
				//Lets leave this as a blank section, no options just some intro text set above.
				'fields' => array()
				);
	
	return $sections;
	
}//function


/*
 * 
 * Custom function for filtering the args array given by theme, good for child themes to override or add to the args array.
 *
 */
function change_framework_args($args){
	
	//$args['dev_mode'] = false;
	
	return $args;
	
}

/*
 * This is the meat of creating the optons page
 *
 * Override some of the default values, uncomment the args and change the values
 * - no $args are required, but there there to be over ridden if needed.
 *
 *
 */

function setup_framework_options(){
$args = array();
global $vibe_options;

      $vibe_options = get_option(THEME_SHORT_NAME);  //Initialize Vibeoptions
//Set it to dev mode to view the class settings/info in the form - default is false
$args['dev_mode'] = false;

//google api key MUST BE DEFINED IF YOU WANT TO USE GOOGLE WEBFONTS
//$args['google_api_key'] = '***';

//Remove the default stylesheet? make sure you enqueue another one all the page will look whack!
//$args['stylesheet_override'] = true;

//Add HTML before the form
$args['intro_text'] = '';

//Setup custom links in the footer for share icons
$args['share_icons']['twitter'] = array(
										'link' => 'http://twitter.com/vibethemes',
										'title' => __('Folow me on Twitter','vibe'), 
										'img' => VIBE_OPTIONS_URL.'img/ico-twitter.png'
										);
$args['share_icons']['facebook'] = array(
										'link' => 'http://facebook.com/vibethemes',
										'title' => __('Be our Fan on Facebook','vibe'), 
										'img' => VIBE_OPTIONS_URL.'img/ico-facebook.png'
										);
$args['share_icons']['gplus'] = array(
										'link' => 'https://plus.google.com/107421230631579548079',
										'title' => __('Follow us on Google Plus','vibe'), 
										'img' => VIBE_OPTIONS_URL.'img/ico-g+.png'
										);
$args['share_icons']['rss'] = array(
										'link' => 'feed://themeforest.net/feeds/users/VibeThemes',
										'title' => __('Latest News from VibeThemes','vibe'), 
										'img' => VIBE_OPTIONS_URL.'img/ico-rss.png'
										);

//Choose to disable the import/export feature
//$args['show_import_export'] = false;

//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
$args['opt_name'] = THEME_SHORT_NAME;

//Custom menu icon
//$args['menu_icon'] = '';

//Custom menu title for options page - default is "Options"
$args['menu_title'] = __(THEME_FULL_NAME, 'vibe');

//Custom Page Title for options page - default is "Options"
$args['page_title'] = __('Vibe Options Panel v 2.0', 'vibe');

//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "vibe_theme_options"
$args['page_slug'] = THEME_SHORT_NAME.'_options';

//Custom page capability - default is set to "manage_options"
$args['page_cap'] = 'manage_options';

//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
//$args['page_type'] = 'submenu';
//$args['page_parent'] = 'themes.php';
if(function_exists('social_sharing_links')){
$social_links= social_sharing_links();
foreach($social_links as $link => $value){
    $social_links[$link]=$link;
}
}

$sidebars=$GLOBALS['wp_registered_sidebars'];
$sidebararray=array();
foreach($sidebars as $sidebar){
    $sidebararray[$sidebar['id']]= $sidebar['name'];
}

//custom page location - default 100 - must be unique or will override other items
$args['page_position'] = 62;

$args['help_tabs'][] = array(
							'id' => 'vibe-opts-1',
							'title' => __('Support', 'vibe'),
							'content' => '<p>'.__('We provide support via three mediums (in priority)','vibe').':
                                                            <ul><li><a href="http://vibethemes.com/forums/forumdisplay.php?65-vEstate" target="_blank">'.THEME_FULL_NAME.' VibeThemes Forums</a></li><li>'.__('Support Email: VibeThemes@gmail.com', 'vibe').'</li><li>'.__('ThemeForest Item Comments','vibe').'</li></ul>
                                                            </p>',
							);
$args['help_tabs'][] = array(
							'id' => 'vibe-opts-2',
							'title' => __('Documentation & Links', 'vibe'),
							'content' => '<ul><li><a href="http://vibethemes.com/forums/forumdisplay.php?65-vEstate" target="_blank">'.THEME_FULL_NAME.' Support Forums</a></li>
                                                                          <li><a href="http://vibethemes.com/forums/showthread.php?1171-Getting-Stated" target="_blank">'.THEME_FULL_NAME.' Getting Started*</a></li>
                                                                          <li><a href="http://vibethemes.com/forums/forumdisplay.php?66-Documentation-amp-Tutorials" target="_blank">'.THEME_FULL_NAME.' Documentation</a></li>  
                                                                          <li><a href="http://vibethemes.com/forums/showthread.php?1175-Issue-Log" target="_blank">'.THEME_FULL_NAME.' Issue Log</a></li>
                                                                          <li><a href="http://vibethemes.com/forums/showthread.php?1176-Feature-Requests" target="_blank">'.THEME_FULL_NAME.' Feature Requests</a></li>    
                                                                              <li><a href="http://vibethemes.com/forums/showthread.php?1174-Common-FAQ-s" target="_blank">'.THEME_FULL_NAME.' Common FAQs</a></li>    
                                                                      </ul>
                                                            ',
							);
$args['help_tabs'][] = array(
							'id' => 'vibe-opts-3',
							'title' => __('Upgrades', 'vibe'),
							'content' => ' Latest Theme Version  is  1.4.1 <br /><ol>
                                                            <li> Updated Revolution Slider</li>
                                                            <li>Added Controls for Hiding , Showing Feature Area fields in single listing</li>
                                                            <li>Added controls for Keywords handling in advanced search widget</li>
                                                            <li>Added controls for disabling Taxonomy tree</li>
                                                            <li>Added controls for Directing Navigation Search to listing search</li>
                                                            <li>Pagination Bug fix in single agent</li>
                                                            <li>Thumbnails lazy load in single listing</li>
                                                            <li>Added Controls Listing Snapshot connect to single Listing</li>
                                                            </ol>'
                                                        );
							
$args['help_tabs'][] = array(
							'id' => 'vibe-opts-4',
							'title' => __('Notices', 'vibe'),
							'content' => '<p> Latest Theme Version  is  1.2.1<br /><ol>
                                                    <li>Contact Form controls added in Options Panel -> Miscellaneous</li>
                                                    <li>Feature ARea controls in Options Panel -> Miscellaneous</li>
                                                    <li>Keyword Handling in Search & Widget controls in Options Panel -> Miscellaneous</li>
                                                    <li>Listing Snapshot connect with Single Listings Connect in Options Panel -> Miscellaneous</li>
                                                    </ol></p>'
							);


//Set the Help Sidebar for the options page - no sidebar by default										
$args['help_sidebar'] = '<p>For Support/Help and Docuementation open <strong><a href="http://vibethemes.com/forums/forumdisplay.php?63-vEstate">'.THEME_FULL_NAME.' forums</a></strong>'.__('Or email us at','vibe').' <a href="mailto:vibethemes@gmail.com">vibethemes@gmail.com</a>. </p>';



$sections = array();

$sections[] = array(
				'title' => __('Getting Started', 'vibe'),
				'desc' => '<p class="description">'.__('Welcome to '.THEME_FULL_NAME.' Theme Options panel. ','vibe').'</p>
                                    <ol>
                                        <li>'.__('Click on  <a href="'.admin_url( 'admin.php?page=vest_options&tour=start' ).'" class="button">Start Tour</a> to get familiar with the Options Panel.','vibe').'</li> 
                                        <li>'.__('Demo Data Install ','vibe').' <a href="javascript:void(0);" id="sampleinstall" rel-file="sample_data" class="button button-primary"> '.__('Install Sample Data','vibe').'</a><small>'.__('(* Requires Vibe Importer Plugin and it may take 3-5 minutes, please do not migrate from page while importing data.)','vibe').'</small></li> 
                                        <li>'.__('Other important setups. ','vibe').' <a href="http://vibethemes.com/forums/showthread.php?1090-Getting-Started-with-vEstate" class="button" target="_blank">'.__('Other setups','vibe').'</a></li> 
                                        <li>'.__('How to Update? Facing Issues while updating?','vibe').' <a href="http://vibethemes.com/forums/showthread.php?868-Update-Notification-amp-Issues">support forum thread.</a></li>     
                                        
                                    </ol>
                                    
                                    </p>',
				//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
				//You dont have to though, leave it blank for default.
				'icon' => 'home',
                                'fields' => array(
                                    array(
						'id' => 'notice',
						'type' => 'divide',
                                                'desc' => 'Details required for Auto-Update'
						),
                                    array(
						'id' => 'username',
						'type' => 'text',
						'title' => __('Enter Your Themeforest Username', 'vibe'), 
						'sub_desc' => __('Required for Automatic Upgrades.', 'vibe'),
                                                'std' => ''
						),
                                    array(
						'id' => 'apikey',
						'type' => 'text',
						'title' => __('Enter Your Themeforest API KEY', 'vibe'), 
						'sub_desc' => __('Please Enter your API Key.Required for Automatic Upgrades.', 'vibe'),
                                                'desc' => __('Whats an API KEY? Where can I find one?','vibe').' : <a href="http://themeforest.net/help/api" target="_blank">Get all your Anwers here</a> or use our Support Forums',
                                                'std' => ''
						),
                                    )
                                );

$sections[] = array(
				'title' => __('General Settings', 'vibe'),
				'desc' => '<p class="description">'.__('General Settings, essential for theme working ', 'vibe').'</p>',
				//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
				//You dont have to though, leave it blank for default.
				'icon' => 'cog',
				//Lets leave this as a blank section, no options just some intro text set above.
				'fields' => array(
                                                array(
						'id' => 'responsive',
						'type' => 'button_set',
						'title' => __('Enable Responsiveness', 'vibe'), 
						'sub_desc' => __('Responsive Templates look good on mobile platforms as well.', 'vibe'),
						'desc' => __('.', 'vibe'),
						'options' => array(1 => 'Yes',0 => 'No'),
                                                'std' => 1
						), 
                                                array(
						'id' => 'theme_layout',
						'type' => 'button_set',
						'title' => __('Theme Layout', 'vibe'), 
						'sub_desc' => __('Layout of the Overall Theme', 'vibe'),
						'desc' => __('All the pages/templates in the theme are governed by the layout.', 'vibe'),
						'options' => array('boxed' => 'Boxed','wide' => 'Wide'),//Must provide key => value pairs for radio options
						'std' => 'wide'
						),
                                                array(
						'id' => 'content_area',
						'type' => 'button_set',
						'title' => __('Default Content Area', 'vibe'), 
						'sub_desc' => __('Select Default Content area', 'vibe'),
						'desc' => __('Content area is the container in which all content is located.', 'vibe'),
						'options' => array(0 => '960 Grid',1 => '1170 Grid'),//Must provide key => value pairs for radio options
						'std' => 0
						),
						 
                                )
				
                    );				


$sections[] = array(
				'icon' => 'publish clicked',
				'title' => __('Header', 'vibe'),
				'desc' => '<p class="description">'.__('Header settings','vibe').'..</p>',
				'fields' => array(
                                       array(
						'id' => 'header_style',
						'type' => 'button_set',
						'title' => __('Header Layout', 'vibe'), 
						'sub_desc' => __('Layout of the Theme Header', 'vibe'),
						'desc' => __('Header is consistent across all pages.', 'vibe'),
						'options' => array('' => 'Default','vibe-center' => 'Center'),//Must provide key => value pairs for radio options
						'std' => ''
						),
                                       array(
						'id' => 'logo',
						'type' => 'upload',
						'title' => __('Upload Logo', 'vibe'), 
						'sub_desc' => __('Upload your logo', 'vibe'),
						'desc' => __('This Logo is shown in header.', 'vibe'),
                                                'std' => VIBE_URL.'/img/logo.png'
						),
                                        array(
						'id' => 'favicon',
						'type' => 'upload',
						'title' => __('Upload Favicon', 'vibe'), 
						'sub_desc' => __('Upload 16x16px Favicon', 'vibe'),
						'desc' => __('Upload 16x16px Favicon.', 'vibe'),
                                                'std' => VIBE_URL.'/img/favicon.png'
						),
                                         array(
						'id' => 'nav_fix',
						'type' => 'button_set',
						'title' => __('Fix Navigation on Scroll', 'vibe'), 
						'sub_desc' => __('Fix Navition on top of screen' , 'vibe'),
						'desc' => __('Navigation is fixed to top as user scrolls down.', 'vibe'),
						'options' => array('0' => 'Static','1' => 'Fixed on Scroll'),//Must provide key => value pairs for radio options
						'std' => '0'
						), 
                                       array(
						'id' => 'header_note',
						'type' => 'editor',
						'title' => __('Header Note', 'vibe'), 
						'sub_desc' => __('Supports HTML & Shortcode' , 'vibe'),
						'desc' => __('Header Note .', 'vibe'),
						'std'=>''
						), 
                                        array(
						'id' => 'header_top_content',
						'type' => 'editor',
						'title' => __('Header Top Content', 'vibe'), 
						'sub_desc' => __('Content just above logo' , 'vibe'),
						'desc' => __('Add notification or information.', 'vibe'),
						'std' => ''
						),
                                         array(
						'id' => 'header_sidebar',
						'type' => 'button_set',
						'title' => __('Show Header sidebar on top', 'vibe'), 
						'sub_desc' => __('Header Sidebar on top' , 'vibe'),
						'desc' => __('Show Header sidebar.', 'vibe'),
						'options' => array('0' => 'No','1' => 'Yes'),//Must provide key => value pairs for radio options
						'std' => '0'
						),
                                       array(
						'id' => 'header_sidebar_columns',
						'type' => 'radio_img',
						'title' => __('Header Sidebar Columns', 'vibe'), 
						'sub_desc' => __('Header sidebar Columns', 'vibe'),
						'options' => array(             
                                                                                '4' => array('title' => 'Four Columns', 'img' => VIBE_OPTIONS_URL.'img/footer-1.png'),
										'3' => array('title' => 'Three Columns', 'img' => VIBE_OPTIONS_URL.'img/footer-2.png'),    
										'2' => array('title' => 'Two Columns', 'img' => VIBE_OPTIONS_URL.'img/footer-3.png'),
                                                                                '1' => array('title' => 'One Columns', 'img' => VIBE_OPTIONS_URL.'img/footer-4.png'),
                                                                  ),//Must provide key => value(array:title|img) pairs for radio options
						'std' => '4'
						),        
					)
				);

$listing_taxonomies = array();
if(isset($vibe_options['listing_taxonomies']) && is_array(($vibe_options['listing_taxonomies']))){
  if(is_array($vibe_options['listing_taxonomies']['slug'])){
  foreach($vibe_options['listing_taxonomies']['slug'] as $key => $value){
      $listing_taxonomies[$value] = $vibe_options['listing_taxonomies']['label'][$key];
  }
  }
}
$sections[] = array(
				'icon' => 'location-1',
				'title' => __('Listings Manager', 'vibe'),
				'desc' => '<p class="description">'.__('Add/Remove Listing Fields','vibe').'</p>',
				'fields' => array(
                    array(
						'id' => 'listing_taxonomies',
						'type' => 'custom_taxonomy',
                                                'post-type' => 'listing',
                                                'title' => __('Add/Remove Taxonomies ', 'vibe'),
                                                'sub_desc' => __('Taxonomies are Required for Custom Search functions', 'vibe'),
                                                'desc' => __('Add cusotm taxonomy classes for appearance', 'vibe')
						),
					array(
						'id' => 'listing_fields',
						'type' => 'custom_fields',
                                                'post-type' => 'listing',
                                                'title' => __('Add/Remove Listings Fields ', 'vibe'),
                                                'sub_desc' => __('Listings fields are used to create listings', 'vibe'),
                                                'desc' => __('In built display classes related to icons are : oneroomapartment,agent,apartment,bedroom,parking,house,industrial,area,office,swimmingpool,villa', 'vibe')
						),
                    array(
						'id' => 'currency',
						'type' => 'select',
						'title' => __('Select Price field Currencies', 'vibe'), 
						'sub_desc' => __('Currency is shown in as prefix to the price value', 'vibe'),
						'desc' => __('This Currency label is prepended to the price value.', 'vibe'),
                        'options' => vibe_currency_symbols(),
                        'std'=>'cur-dollar'
						),
                    array(
						'id' => 'area',
						'type' => 'text',
						'title' => __('Area Unit', 'vibe'), 
						'sub_desc' => __('Enter unit of area', 'vibe'),
						'desc' => __('Connected with class area.', 'vibe'),
                                               'std'=>'sqft.'
						),
					array(
						'id' => 'zoomlevel',
						'type' => 'slider',
						'title' => __('Enter Google Map Zoom Level', 'vibe'), 
						'sub_desc' => __('Enter a Zoom level in 1-16', 'vibe'),
						'desc' => __('Enter the Google map zoom level', 'vibe'),
                                                'min'=> '1',
                                                'std'=> '15',
                                                'max'=> '16'
						), 
                                        array(
						'id' => 'agent_email_subject',
						'type' => 'text',
						'title' => __('Agent Contact form Email Subject', 'vibe'), 
						'sub_desc' => __('Agents are sent mails with this subject', 'vibe'),
						'desc' => __('Subject to notify Agents of email', 'vibe'),
                                               'std'=>'Contact submission'
						),
                                       array(
						'id' => 'listing_search_page',
						'type' => 'pages_select',
                                                'title' => __('Listings search results page', 'vibe'),
                                                'sub_desc' => __('Search results are shown in this page', 'vibe'),
                                                'desc' => __('Create a new page with Search Results Page template and select this page.', 'vibe'),
                                                'std' =>''
                                           
						),
                        array(
						'id' => 'primary_listing_parameter',
						'type' => 'select',
                                                'title' => __('Select Primary Listing Parameter', 'vibe'),
                                                'sub_desc' => __('First Field in Listing blocks, always visible.', 'vibe'),
                                                'desc' => __('Select most important Listings Taxonomy.', 'vibe'),
                                                'options' => $listing_taxonomies,
                                                'std' =>'location'
                                           
						),
					)
				);

$sections[] = array(
				'icon' => 'users',
				'title' => __('Agents', 'vibe'),
				'desc' => '<p class="description">'.__('Agents profiles and front end posting,', 'vibe').'</p>',
				'fields' => array(
					 array(
						'id' => 'agent_role',
						'type' => 'button_set',
						'title' => __('Enable Agent User', 'vibe'), 
						'sub_desc' => __('Agent type user role in WordPress Users', 'vibe'),
						'desc' => __('Required for front end submissions.', 'vibe'),
						'options' => array('1' => 'Enable','0' => 'Disable'),
                        'std' => '1'// 1 = on | 0 = off
						),
                      array(
						'id' => 'front_end_submission',
						'type' => 'button_set',
						'title' => __('Enable Front End submission', 'vibe'), 
						'sub_desc' => __('Front end submissions for Agents', 'vibe'),
						'desc' => __('Create front end submissions for Agents.', 'vibe'),
						'options' => array('1' => 'Enable','0' => 'Disable'),
                        'std' => '1'// 1 = on | 0 = off
						),
						array(
						'id' => 'agent_account_page',
						'type' => 'pages_select',
                        'title' => __('Agent Account page', 'vibe'),
                        'sub_desc' => __('Page with Agent Account template', 'vibe'),
                        'desc' => __('Page with Agent Account Page Template.', 'vibe'),
                        'std' =>''
						),
						array(
						'id' => 'agent_profile_page',
						'type' => 'pages_select',
                        'title' => __('Agent Profile page', 'vibe'),
                        'sub_desc' => __('Page with Agent profile template', 'vibe'),
                        'desc' => __('Page with Agent Profile Page Template.', 'vibe'),
                        'std' =>''
						),
						array(
						'id' => 'agent_add_listings_page',
						'type' => 'pages_select',
                        'title' => __('Agent Add Listings page', 'vibe'),
                        'sub_desc' => __('Page with Add listings page template', 'vibe'),
                        'desc' => __('Page with add listings page template.', 'vibe'),
                        'std' =>''
						),
						array(
						'id' => 'agent_publish_listing',
						'type' => 'button_set',
						'title' => __('Directly Publish Agent Listings', 'vibe'), 
						'sub_desc' => __('Front end Listings submitted by agents', 'vibe'),
						'desc' => __('Publish or Save as Draft Agent Listings', 'vibe'),
						'options' => array('publish' => 'Publish','draft' => 'Save Listings as Draft'),
                        'std' => '1'// 1 = on | 0 = off
						),
						array(
						'id' => 'add_membership',
						'type' => 'button_set',
						'title' => __('Add Agent Membership with WooCommerce', 'vibe'), 
						'sub_desc' => __('Add Agent Membership with WooCommerce', 'vibe'),
						'desc' => __('Add a Agents Membership metabox in WooCommerce Products.', 'vibe'),
						'options' => array('1' => 'Show','0' => 'Don\'t Show'),
                                                'std' => '1'// 1 = on | 0 = off
						),
					 				
					)
				);


$sections[] = array(
				'icon' => 'list-add',
				'title' => __('Sidebar Manager', 'vibe'),
				'desc' => '<p class="description">'.__('Generate more sidebars dynamically and use them in various layouts','vibe').'..</p>',
				'fields' => array(
					 array(
						'id' => 'sidebars',
						'type' => 'multi_text',
                                                'title' => __('Create New sidebars ', 'vibe'),
                                                'sub_desc' => __('Dynamically generate sidebars', 'vibe'),
                                                'desc' => __('Use these sidebars in various layouts.', 'vibe')
						),
                                    
                                          array(
						'id' => 'sidebar_defaults',
						'type' => 'sidebars',
						'title' => __('Set Default Sidebars', 'vibe'), 
						'sub_desc' => __('Select Default sidebar for Post Types', 'vibe'),
						'desc' => __('Set Sidebar as default sidebar for post types (Post/Portfolio/Products/Testimonial/Carousels etc..). These will be default sidebars shown in category/search/tags/posts etc pages. You can also manage sidebars for individual posts via in-post template layouts. If no sidebar is selected for any post type then it revert to default <b>MainSidebar</b> .', 'vibe'),
						) 				
					)
				);


$sections[] = array(
				'icon' => 'list-alt',
				'title' => __('Custom Posts Types', 'vibe'),
				'desc' => '<p class="description">'.__('Generate Unlimited Custom Post Types,', 'vibe').' <a href="http://codex.wordpress.org/Post_Types" target="_blank">learn more</a></p>',
				'fields' => array(
					 array(
						'id' => 'custom_posts',
						'type' => 'custom_posts',
                                                'title' => __('Create New Custom Posts Type ', 'vibe'),
                                                'sub_desc' => __('Dynamically generate custom posts type', 'vibe'),
                                                'desc' => __('Use these custom posts type in various layouts.', 'vibe')
						)
					 				
					)
				);

$sections[] = array(
				'icon' => 'upload',
				'title' => __('Fonts Manager', 'vibe'),
				'desc' => '<p class="description">'.__('Manage Fonts to be used in the Site. Fonts selected here will be available in Theme customizer font family select options.','vibe').'..</p>',
				'fields' => array(
					 array(
						'id' => 'google_fonts',
						'type' => 'google_webfonts_multi_select',
                                                'title' => __('Select Fonts for Live Theme Editor ', 'vibe'),
                                                'sub_desc' => __('Select Fonts and setup fonts in Live Editor', 'vibe'),
                                                'desc' => __('Use these sample layouts in PageBuilder.', 'vibe')
						),
                                        array(
						'id' => 'custom_fonts',
						'type' => 'multi_text',
                                                'title' => __('Custom Fonts (Enter CSS Font Family name)', 'vibe'),
                                                'sub_desc' => __(' Custom Fonts are added to Theme Customizer Font List.. ', 'vibe').'<a href="http://forums.vibethemes.com">Learn how to add custom fonts</a>'
						)
					 				
					)
				);


$sections[] = array(
				'icon' => 'download',
				'title' => __('Customizer', 'vibe'),
				'desc' => '<p class="description">'.__('Import/Export customizer settings. Customize your theme using ','vibe').' <a href="'.get_admin_url().'customize.php" class="button">WP Theme Customizer</a></p>',
				'fields' => array(
					 
                                        /*
                                        array(
						'id' => 'theme_customizer',
						'type' => 'button_set',
						'title' => __('Enable Theme Customizer', 'vibe'), 
						'sub_desc' => __('Enable advanced theme customization options' , 'vibe').'via <a href="'.get_admin_url().'customize.php">WP Theme Customizer</a>..<a href="http://www.vibethemes.com/forums/">more info..</a>',
						'desc' => __('Make and Save all changes Live.', 'vibe'),
						'options' => array('1' => 'Yes','0' => 'No'),//Must provide key => value pairs for radio options
						'std' => '0'
						),
                                        array(
						'id' => 'finalize_customizer',
						'type' => 'button_set',
						'title' => __('Finalize Theme Customizer', 'vibe'), 
						'sub_desc' => __('Enable this after you have done all the design changes' , 'vibe').'via <a href="'.get_admin_url().'customize.php">WP Theme Customizer</a>..<a href="http://www.vibethemes.com/forums/">more info..</a>',
						'desc' => __('Improves Page Speed. Converts all dynamic changes into a stylesheet. After enable disable Theme Customizer.', 'vibe'),
						'options' => array('1' => 'Yes','0' => 'No'),//Must provide key => value pairs for radio options
						'std' => '0'
						),*/
                                    
                                        array(
						'id' => 'viz_customizer',
						'type' => 'import_export',
                                                'title' => __('Import/Export Customizer settings ', 'vibe'),
                                                'sub_desc' => __('Import/Export customizer settings', 'vibe'),
                                                'desc' => __('Use import/export functionality to import/export your customizer settings.', 'vibe')
						)
					 				
					)
				);

$sections[] = array(
				'icon' => 'popup',
				'title' => __('PageBuilder Manager', 'vibe'),
				'desc' => '<p class="description">'.__('Manage PageBuilder saved layouts and Import/Export pagebuilder Saved layouts','vibe').'</p>',
				'fields' => array(
					 array(
						'id' => 'sample_layouts',
						'type' => 'pagebuilder_layouts',
                                                'title' => __('Manage Sample Layouts ', 'vibe'),
                                                'sub_desc' => __('Delete Sample Layouts', 'vibe'),
                                                'desc' => __('Use these sample layouts in PageBuilder.', 'vibe')
						),
                                        array(
						'id' => 'vibe_builder_sample_layouts',
						'type' => 'import_export',
                                                'title' => __('Import/Export Sample Layouts ', 'vibe'),
                                                'sub_desc' => __('Import/Export existing Layouts', 'vibe'),
                                                'desc' => __('Use import/export functionality to save your layouts.', 'vibe')
						)
					 				
					)
				);

$sections[] = array(
				'icon' => 'thumbs-up',
				'title' => __('Social Information', 'vibe'),
				'desc' => '<p class="description">'.__('All Social media settings','vibe').'..</p>',
				'fields' => array(
					   
                                           array(
						'id' => 'social_icons',
						'type' => 'multi_social',
                                                'title' => __('Add Social Media Icons ', 'vibe'),
                                                'sub_desc' => __('Dynamically add social media icons', 'vibe'),
                                                'desc' => __('Add your Full URL in social media.', 'vibe')
						),
                                           array(
						'id' => 'social_icons_type',
						'type' => 'button_set',
						'title' => __('Social Icons Type', 'vibe'), 
						'sub_desc' => __('Social Icons Theme', 'vibe'),
						'options' => array('' => 'Minimal','round' => 'Round','square' => 'Square','round color' => 'Round Colored','square color' => 'Square Colored'),
						'std' => ''
						),
                                         array(
						'id' => 'show_social_tooltip',
						'type' => 'button_set',
						'title' => __('Show Tooltip on Social Icons', 'vibe'), 
						'options' => array(1 => 'Yes',0 => 'No'),
						'std' => 1
						),     
                                           array(
						'id' => 'social_share',
						'type' => 'multi_select',
                                                'title' => __('Social Sharing in Blog Posts', 'vibe'),
                                                'sub_desc' => __('Adds Social media sharing code for share in blog posts', 'vibe'),
                                                'options' => $social_links
						),
                                        array(
						'id' => 'enable_likes',
						'type' => 'button_set',
						'title' => __('Enable Post/Page Likes', 'vibe'), 
						'options' => array(1 => 'Yes',0 => 'No'),
						'std' => 1
						), 
					 				
					)
				);


$sections[] = array(
				'icon' => 'retweet',
				'title' => __('Custom Connect', 'vibe'),
				'desc' => '<p class="description">'.__('Connect Various meta boxes with Post Type admin interface. Select various category layouts for various Post Types (Posts/Portfolio etc..).', 'vibe').'</p>',
				'fields' => array(
						
                                        array(
						'id' => 'meta_featured',
						'type' => 'custom_posts_multi_select',
						'title' => __('METABOX: Featured Media', 'vibe'), 
						'sub_desc' => __('Show Featured Media Meta Box in following post-types', 'vibe'),
						'desc' => __('Select multiple post types to show featured media in admin interface.', 'vibe'),
                                                'std' => array('0' => 'post','1'=>'page','2'=>'portfolio')//uses get_pages
						),
                                       array(
						'id' => 'meta_layouts',
						'type' => 'custom_posts_multi_select',
						'title' => __('METABOX: Page Settings', 'vibe'), 
						'sub_desc' => __('Show Settings Meta Box in following post-types', 'vibe'),
						'desc' => __('Select multiple post types to show Settings metabox in admin interface.', 'vibe'),
                                                'std' => array('0' => 'post','1'=>'page','2'=>'portfolio')//uses get_pages
						),
                                       array(
						'id' => 'meta_builder',
						'type' => 'custom_posts_multi_select',
						'title' => __('METABOX: Page Builder', 'vibe'), 
						'sub_desc' => __('Show Page Builder Meta Box in following post-types', 'vibe'),
						'desc' => __('Select multiple post types to enable Page Builder metabox in admin interface.', 'vibe'),
                                                'std' => array('0' => 'post','1'=>'page','2'=>'portfolio')//uses get_pages
						),
                                    array(
						'id' => 'subheader_css_changes',
						'type' => 'custom_posts_multi_select',
						'title' => __('METABOX: Subheader Changes', 'vibe'), 
						'sub_desc' => __('Show Sub-Header Meta Box in following post-types', 'vibe'),
						'desc' => __('Select multiple post types to enable Custom Subheader changes metabox in admin interface. Set SubTitle, Subheader Image, Subheader Background Color', 'vibe'),
                                                'std' => array('0' => 'pages')//uses get_pages
						),
                                    array(
						'id' => 'custom_css_changes',
						'type' => 'custom_posts_multi_select',
						'title' => __('METABOX: Custom CSS Changes', 'vibe'), 
						'sub_desc' => __('Show Custom CSS Changes Meta Box in following post-types', 'vibe'),
						'desc' => __('Select multiple post types to enable Custom CSS changes metabox in admin interface.', 'vibe'),
                                                'std' => array('0' => 'pages')//uses get_pages
						),
                                    array(
						'id' => 'inpage_menu',
						'type' => 'custom_posts_multi_select',
						'title' => __('METABOX: InPage Menu', 'vibe'), 
						'sub_desc' => __('Show InPage Menu Meta Box in following post-types', 'vibe'),
						'desc' => __('Select multiple post types to enable InPage Menu metabox in admin interface.', 'vibe'),
                                                'std' => array('0' => 'pages')//uses get_pages
						),
                                      
                                    array(
						'id' => 'large_posts_excerpt',
						'type' => 'text',
						'title' => __('Excerpt Length in Large Width Posts', 'vibe'), 
						'sub_desc' => __('Excerpt length for archive/category/tag pages with this style', 'vibe'),
						'std' => '300'
						),
                                      array(
						'id' => 'small_posts_excerpt',
						'type' => 'text',
						'title' => __('Excerpt Length in Small Width Posts', 'vibe'), 
						'sub_desc' => __('Excerpt length for archive/category/tag pages with this style', 'vibe'),
						'std' => '400'
						),
					)
				);
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
     
$sections[] = array(
				'icon' => 'cart',
				'title' => __('WooCommerce ', 'vibe'),
				'desc' => '<p class="description">'.__('Settings for WooCommerce Plugin.','vibe').'..</p>',
				'fields' => array(
                                        array(
						'id' => 'woocommerce_shop_layout',
						'type' => 'radio_img',
						'title' => __('Select Woocommerce Shop Layout', 'vibe'), 
						'sub_desc' => __('Select Shop Layout (Default sidebar : Shop)', 'vibe'),
						'options' => array(             
                                                                                'left' => array('title' => 'Left Sidebar', 'img' => VIBE_OPTIONS_URL.'img/left-sidebar.png'),
										'right' => array('title' => 'Right Sidebar', 'img' => VIBE_OPTIONS_URL.'img/right-sidebar.png'),    
										'full' => array('title' => 'Full Width', 'img' => VIBE_OPTIONS_URL.'img/no-sidebar.png'),
                                                    ),
                                                'std' => 'left'                                   
						),
                                         array(
						'id' => 'woocommerce_sidebar',
						'type' => 'select',
						'title' => __('Shop Page Sidebar', 'vibe'), 
						'sub_desc' => __('* Required only if Sidebar layout is selected above', 'vibe'),
						'desc' => __('This Sidebar is shown in above layout.', 'vibe'),
						'options' => $sidebararray,
                                                'std' => 'shop'
						),
					 array(
						'id' => 'woocommerce_columns',
						'type' => 'select',
                                                'title' => __('Woocommerce Columns ', 'vibe'),
                                                'sub_desc' => __('Woocommerce columns in single product row.', 'vibe'),
                                                'desc' => __('Use these sidebars in various layouts.', 'vibe'),
                                                'options' => array('1' => __('1 Column','vibe'),
                                                                   '2' => __('2 Columns','vibe'),
                                                                   '3' => __('3 Columns','vibe'),
                                                                   '4' => __('4 Columns','vibe'),
                                                                   '6' => __('6 Columns (only in FullWidth Shop Layout)','vibe'),
                                                                   ),
                                                'std' => 3                   
						),
                                         array(
						'id' => 'woocommerce_no_products',
						'type' => 'text',
						'title' => __('Number of Products to display in one screen on Shop Page', 'vibe'), 
						'sub_desc' => __('Number of products shown on Shop Page per screen, with pagination.', 'vibe'),
                                                'desc' => __('Enter a number, multiple of above WooCommerce Columns.', 'vibe'),
						'std' => 16
						), 
                                         array(
						'id' => 'woocommerce_welcome_message',
						'type' => 'editor',
						'title' => __('WooCommerce MyAccount Text/Notification:', 'vibe'), 
						'sub_desc' => __('User sees this text when logged in you can use this space for notifications etc.', 'vibe'),
                                                'desc' => __('supports shortcodes.', 'vibe'),
						'std' => ''
						),
                                       array(
						'id' => 'woocommerce_checkout_message',
						'type' => 'editor',
						'title' => __('WooCommerce Checkout Message/Notification:', 'vibe'), 
						'sub_desc' => __('User sees this text when they\'re on checkout page.', 'vibe'),
                                                'desc' => __('Supports shortcodes.', 'vibe'),
						'std' => ''
						),
					 				
					)
				);
}

$sections[] = array(
				'icon' => 'briefcase',
				'title' => __('SEO Settings', 'vibe'),
				'desc' => '<p class="description">'.__('Some SEO Recommendations/Settings supported by'.THEME_FULL_NAME, 'vibe').'</p>',
				'fields' => array(
                                        array(
						'id' => 'seo_panel',
						'type' => 'seo_panel',
						'title' => __('SEO Panel', 'vibe'), 
						'sub_desc' => __('SEO Recommendations', 'vibe'),
						'desc' => __('We Recommended settings up following plugins for better SEO results.', 'vibe'),
						'options' => array('wordpress-seo/wp-seo.php' => 'WordPress SEO')
						),    
                                       array(
						'id' => 'seo_alt',
						'type' => 'text',
						'title' => __('Image Alt tag Format', 'vibe'), 
						'sub_desc' => __('Alt tag format, enable SEO Image alt for its usage', 'vibe'),
						'desc' => __('Use combinations of %title | %name | %category | %tag, saperated by /.', 'vibe'),
                                                'std' => '%title/%category'
						),
                                      array(
						'id' => 'image_alt',
						'type' => 'button_set',
						'title' => __('Force Image Alt Attributes', 'vibe'), 
						'sub_desc' => __('Force set image alt tags ', 'vibe'),
						'desc' => __('If No then it applies only on images with no alt attributes.', 'vibe'),
						'options' => array('1' => 'Yes','0' => 'No'),//Must provide key => value pairs for radio options
						'std' => '1'
						),
                                       
                                       array(
						'id' => 'seo_title',
						'type' => 'text',
						'title' => __('Image Title Format', 'vibe'), 
						'sub_desc' => __('Force title tag format, enable SEO Image alt for its usage', 'vibe'),
						'desc' => __('Use combinations of %title | %name | %category | %tag, saperated by /.', 'vibe'),
                                                'std' => '%title'
						),
                                       array(
						'id' => 'image_title',
						'type' => 'button_set',
						'title' => __('Force Image Title Attribute', 'vibe'), 
						'sub_desc' => __('Force set image title, ', 'vibe'),
						'desc' => __('If No then it applies only on images with no Title attribute.', 'vibe'),
						'options' => array('1' => 'Yes','0' => 'No'),//Must provide key => value pairs for radio options
						'std' => '1'
						),
						array(
						'id' => 'remove_wlw',
						'type' => 'button_set',
						'title' => __('Remove automatic link to WLW', 'vibe'), 
						'sub_desc' => __('Removes backlink to WLW ', 'vibe'),
						'desc' => __('If you use Windows live writer to write blog posts.', 'vibe'),
						'options' => array('1' => 'Yes','0' => 'No'),//Must provide key => value pairs for radio options
						'std' => '1'
						),
                                                array(
						'id' => 'optimize_db',
						'type' => 'button_set',
						'title' => __('Keep DB Optimized', 'vibe'), 
						'sub_desc' => __('Optimized your database in every 24 hours automatically', 'vibe'),
						'desc' => __('An optimized database runs mysql queries faster without any overheads making your site faster to load.', 'vibe'),
						'options' => array('no' => 'No','daily' => 'Daily','twicedaily' => 'Twice Daily','hourly' => 'Hourly'),//Must provide key => value pairs for radio options
						'std' => 'no'
						)
					)
				);	
$sections[] = array(
				'icon' => 'window',
				'title' => __('Footer ', 'vibe'),
				'desc' => '<p class="description">'.__('Setup footer settings','vibe').'..</p>',
				'fields' => array( 
					 array(
						'id' => 'footer_columns',
						'type' => 'radio_img',
						'title' => __('Footer Columns', 'vibe'), 
						'sub_desc' => __('Footer Columns', 'vibe'),
						'options' => array(             
                                                                                '4' => array('title' => 'Four Columns', 'img' => VIBE_OPTIONS_URL.'img/footer-1.png'),
										'3' => array('title' => 'Three Columns', 'img' => VIBE_OPTIONS_URL.'img/footer-2.png'),    
										'2' => array('title' => 'Two Columns', 'img' => VIBE_OPTIONS_URL.'img/footer-3.png'),
                                                                                '1' => array('title' => 'One Columns', 'img' => VIBE_OPTIONS_URL.'img/footer-4.png'),
                                                                  ),//Must provide key => value(array:title|img) pairs for radio options
						'std' => '4'
						),
                                        
                                        array(
						'id' => 'footersidebar_1',
						'type' => 'select',
						'title' => __('First Footer Sidebar', 'vibe'), 
						'sub_desc' => __('Required Sidebar in all footer layouts selected above', 'vibe'),
						'desc' => __('Sidebar is the first column form the left in footer.', 'vibe'),
						'options' => $sidebararray,
                                                'std' => 'footersideber_1'
						),
                                        
                                        array(
						'id' => 'footersidebar_2',
						'type' => 'select',
						'title' => __('Second Footer Sidebar', 'vibe'), 
						'sub_desc' => __('Required Sidebar in 2 columns, 3 column and 4 column footer layout, selected above', 'vibe'),
						'desc' => __('Sidebar is the second column form the left in footer.', 'vibe'),
						'options' => $sidebararray,
                                                'std' => 'footersideber_2'
						),
                                        
                                        array(
						'id' => 'footersidebar_3',
						'type' => 'select',
						'title' => __('Third Footer Sidebar', 'vibe'), 
						'sub_desc' => __('Required Sidebar in  3 column and 4 column footer layout, selected above', 'vibe'),
						'desc' => __('Sidebar is the third column form the left in footer.', 'vibe'),
						'options' => $sidebararray,
                                                'std' => 'footersideber_3'
						),
                                        
                                        array(
						'id' => 'footersidebar_4',
						'type' => 'select',
						'title' => __('Fourth Footer Sidebar', 'vibe'), 
						'sub_desc' => __('Required Sidebar in 4 column footer layout, selected above', 'vibe'),
						'desc' => __('Sidebar is the fourth column form the left in footer.', 'vibe'),
						'options' => $sidebararray,
                                                'std' => 'footersideber_4'
						),
                                    //=============
                                        array(
						'id' => 'footer_social_icons',
						'type' => 'multi_select',
                                                'title' => __('Add Social Media Icons ', 'vibe'),
                                                'sub_desc' => __('Select social media icons, added in the Social Information tab.', 'vibe'),
                                                'desc' => __('Select social icons which you want to show in footer. These icons are selected from the information provided in the social information tab.', 'vibe'),
                                                'options' => ((isset($vibe_options['social_icons'])) && (is_array($vibe_options['social_icons']) && is_array($vibe_options['social_icons']['social']))?$vibe_options['social_icons']['social']:'')
						),
                                        array(
						'id' => 'copyright',
						'type' => 'editor',
						'title' => __('Copyright Text', 'vibe'), 
						'sub_desc' => __('Enter copyrighted text', 'vibe'),
						'desc' => __('Also supports shotcodes.', 'vibe'),
                                                'std' => 'Template Design © <a href="http://www.vibethemes.com" title="VibeCom">VibeThemes</a>. All rights reserved.'
						),
                                     
                                       array(
						'id' => 'google_analytics',
						'type' => 'textarea',
						'title' => __('Google Analytics Code', 'vibe'), 
						'sub_desc' => __('Google Analytics account', 'vibe'),
						'desc' => __('Please enter full code with javascript tags.', 'vibe'),
						)
					 				
					)
				);
$sections[] = array(
				'icon' => 'bookmark',
				'title' => __('Miscellaneous', 'vibe'),
				'desc' =>'<p class="description">'. __('Miscellaneous settings used in the theme.', 'vibe').'</p>',
				'fields' => array(

                                        array(
						'id' => 'breadcrumbs',
						'type' => 'button_set',
						'title' => __('Show Breadcrumbs', 'vibe'), 
						'sub_desc' => __('Show Breadcrumbs on all posts and pages', 'vibe'),
						'desc' => __('Show breadcrumbs below main navigation menu in subheader.', 'vibe'),
						'options' => array('1' => 'Show','0' => 'Don\'t Show'),
                                                'std' => '1'// 1 = on | 0 = off
						),
                                         array(
						'id' => 'minified',
						'type' => 'button_set',
						'title' => __('Use Minified Styles & Scripts', 'vibe'), 
						'sub_desc' => __('Minified scripts', 'vibe'),
						'desc' => __('Enhances page loading speed. No conflict with other systems.', 'vibe'),
						'options' => array('1' => 'Yes','0' => 'No'),
                                                'std' => '0'// 1 = on | 0 = off
						),
                                         
                                        array(
						'id' => 'thumbs_inlisting',
						'type' => 'button_set',
						'title' => __('Show Thumbnails in Listing Slider', 'vibe'), 
						'sub_desc' => __('Show Thumbnails below Slider in Single Listings', 'vibe'),
						'desc' => __('Show Thumbnails of images in the gallery in single listings page.', 'vibe'),
						'options' => array('1' => 'Show','0' => 'Don\'t Show'),
                                                'std' => '1'// 1 = on | 0 = off
						),
                                       array(
						'id' => 'contact_ll',
						'type' => 'text',
						'title' => __('Contact Page Latitude and Longitude values', 'vibe'), 
						'sub_desc' => __('Grab the latitude and Longitude values .', 'vibe'),
						'std' => '43.730325,7.422155'
						),
                                       array(
						'id' => 'contact_style',
						'type' => 'button_set',
						'title' => __('Contact Page Map Style', 'vibe'), 
						'sub_desc' => __('Select the map style on contact page.', 'vibe'),
						'desc' => __('Content area is the container in which all content is located.', 'vibe'),
						'options' => array('SATELLITE' => 'Saterllite View','ROADMAP' => 'Road map'),
						'std' => 'SATELLITE'
						),
                                       array(
						'id' => 'default_ll',
						'type' => 'text',
						'title' => __('Default Latitude, Longitude Values for Google Map Custom field', 'vibe'), 
						'sub_desc' => __('Default Latitude,Longitude values for Google maps field in listing settings.', 'vibe'),
						'std' => '37.0625,-95.677068'
						),
                                       
                   array(
						'id' => 'link_media',
						'type' => 'button_set',
						'title' => __('Link Featured Media to Post', 'vibe'), 
						'sub_desc' => __('Link Featured Media in Category/Search/Archive Pages to Post', 'vibe'),
						'options' => array('1' => 'Yes, Link to post','2' => 'Link to thumbnail','0' => 'No, Do not link to anything'),
                        'std' => '0'// 1 = on | 0 = off
						),
					array(
						'id' => 'disable_errors',
						'type' => 'button_set',
						'title' => __('Disable Error Handling', 'vibe'), 
						'sub_desc' => __('Disable error handle in theme.', 'vibe'),
						'options' => array('1' => 'Yes','0' => 'No'),
						                        'std' => '0'// 1 = on | 0 = off
						),
					
                    array(	
						'id' => 'default_image',
						'type' => 'upload',
						'title' => __('Upload a Default Image', 'vibe'), 
						'sub_desc' => __('Default image is shown whereever a featured image is not attached in the Post/Portfolio.', 'vibe'),
						 'std' => ''
						), 
                     array(	
						'id' => 'show_title',
						'type' => 'button_set',
						'title' => __('Show title on image Carousel in Listings', 'vibe'), 
						'sub_desc' => __('Show/Hide title on image carousel in listings.', 'vibe'),
						'options' => array('1' => 'Show','0' => 'Hide'),
                        'std' => '0'// 1 = on | 0 = off
						), 
                    
                    array(	
						'id' => 'hide_feature',
						'type' => 'button_set',
						'title' => __('Hide Feature Area info in Features Tab', 'vibe'), 
						'sub_desc' => __('Hide Feature Area info in Features Tab', 'vibe'),
						'options' => array('1' => 'Yes','0' => 'No'),
                        'std' => '0'// 1 = on | 0 = off
						),

                    array(	
						'id' => 'taxonomy_tree',
						'type' => 'button_set',
						'title' => __('Use Generated Taxonomy tree for Advanced Search', 'vibe'), 
						'sub_desc' => __('Uses Generated taxonomy tree for Advanced search.', 'vibe'),
						'options' => array('1' => 'Yes','0' => 'No'),
                        'std' => '0'// 1 = on | 0 = off
						),

					array(	
						'id' => 'search_template',
						'type' => 'button_set',
						'title' => __('Use Listing Search in Nav', 'vibe'), 
						'sub_desc' => __('Uses Advanced search instead of WordPress Default search in Navigation Bar', 'vibe'),
						'options' => array('1' => 'Yes','0' => 'No'),
                        'std' => '0'// 1 = on | 0 = off
						),	 
					array(	
						'id' => 'search_terms',
						'type' => 'button_set',
						'title' => __('Show Keywords field in Advanced Listing Search Widget', 'vibe'), 
						'sub_desc' => __('Show Keywords search terms field in Advanced Listing Search Widget', 'vibe'),
						'options' => array('1' => 'Yes','0' => 'No'),
                        'std' => '0'// 1 = on | 0 = off
						),
                    array(
						'id' => 'error404',
						'type' => 'pages_select',
						'title' => __('Select 404 Page', 'vibe'), 
						'sub_desc' => __('This page is shown when page not found on your site.', 'vibe'),
						'desc' => __('User redirected to this page when page not found.', 'vibe'),
						),
                                       array(
						'id' => 'thumb_slider_delay',
						'type' => 'text',
						'title' => __('Gallery Slider slide delay in Thumbnails (in ms)', 'vibe'), 
						'sub_desc' => __('0 to Stop Auto-slide, slide/Rotate delay in Carousels/Filterable/Postlists etc.', 'vibe'),
						'std' => '0'// 1 = on | 0 = off
						),
                                       array(
						'id' => 'thumb_slider_buttons',
						'type' => 'button_set',
						'title' => __('Show Gallery Slider control buttons in Thumbnails', 'vibe'), 
						'sub_desc' => '',
						'options' => array('1' => 'Yes','0' => 'No'),
						                        'std' => '0'// 1 = on | 0 = off
						),
                                      array(
						'id' => 'thumb_slider_arrows',
						'type' => 'button_set',
						'title' => __('Show Gallery Slider direction arrows in Thumbnails', 'vibe'), 
						'sub_desc' => '',
						'options' => array('1' => 'Yes','0' => 'No'),
						                        'std' => '0'// 1 = on | 0 = off
						),
                                      )
                                );      
	$tabs = array();
			
	if (function_exists('wp_get_theme')){
		$theme_data = wp_get_theme();
		$theme_uri = $theme_data->get('ThemeURI');
		$description = $theme_data->get('Description');
		$author = $theme_data->get('Author');
		$version = $theme_data->get('Version');
		$tags = $theme_data->get('Tags');
	}else{
		$theme_data = get_theme_data(trailingslashit(get_stylesheet_directory()).'style.css');
		$theme_uri = $theme_data['URI'];
		$description = $theme_data['Description'];
		$author = $theme_data['Author'];
		$version = $theme_data['Version'];
		$tags = $theme_data['Tags'];
	}	

	$theme_info = '<div class="vibe-opts-section-desc">';
	$theme_info .= '<p class="vibe-opts-theme-data description theme-uri"><strong>Theme URL:</strong> <a href="'.$theme_uri.'" target="_blank">'.$theme_uri.'</a></p>';
	$theme_info .= '<p class="vibe-opts-theme-data description theme-author"><strong>Author:</strong>'.$author.'</p>';
	$theme_info .= '<p class="vibe-opts-theme-data description theme-version"><strong>Version:</strong> '.$version.'</p>';
	$theme_info .= '<p class="vibe-opts-theme-data description theme-description">'.$description.'</p>';
	$theme_info .= '<p class="vibe-opts-theme-data description theme-tags"><strong>Tags:</strong> '.implode(', ', $tags).'</p>';
	$theme_info .= '</div>';



	$tabs['theme_info'] = array(
					'icon' => 'info-sign',
					'title' => __('Theme Information', 'vibe'),
					'content' => $theme_info
					);
	/*
	if(file_exists(trailingslashit(get_stylesheet_directory()).'README.html')){
		$tabs['theme_docs'] = array(
						'icon' => 'book',
						'title' => __('Documentation', 'vibe'),
						'content' => nl2br(file_get_contents(trailingslashit(get_stylesheet_directory()).'README.html'))
						);
	}*///if

	global $VIBE_Options;
	$VIBE_Options = new VIBE_Options($sections, $args, $tabs);
       


}//function
add_action('init', 'setup_framework_options', 0);

/*
 * 
 * Custom function for the callback referenced above
 *
 */
function my_custom_field($field, $value){
	print_r($field);
	print_r($value);

}//function

/*
 * 
 * Custom function for the callback validation referenced above
 *
 */
function validate_callback_function($field, $value, $existing_value){
	
	$error = false;
	$value =  'just testing';
	/*
	do your validation
	
	if(something){
		$value = $value;
	}elseif(somthing else){
		$error = true;
		$value = $existing_value;
		$field['msg'] = 'your custom error message';
	}
	*/
	
	$return['value'] = $value;
	if($error == true){
		$return['error'] = $field;
	}
	return $return;
	
}//function
?>