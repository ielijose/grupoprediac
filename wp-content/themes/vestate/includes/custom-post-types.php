<?php

/**
 * FILE: custom-post-types.php 
 * Created on Feb 18, 2013 at 7:47:20 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */

$vibe_options=get_option(THEME_FULL_NAME);
/*== Listing == */


function register_listings() {
	register_post_type( LISTING,
		array(
			'labels' => array(
				'name' => 'Listing',
				'menu_name' => 'Listing',
				'singular_name' => 'Listing',
				'all_items' => 'All Listings'
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
            'has_archive' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'post-formats', 'revisions' ),
			'hierarchical' => false,
			'taxonomies' => array( 'listing-type'),
            'menu_position' => 5,
            'show_in_nav_menus' => false,
			'rewrite' => array( 'slug' => 'listing', 'hierarchical' => true, 'with_front' => false )
		)
	);
         flush_rewrite_rules( false );
         
        
        global $vibe_options;
        if(isset($vibe_options['listing_taxonomies']) && is_array($vibe_options['listing_taxonomies']) && is_array($vibe_options['listing_taxonomies']['label'])){
            foreach($vibe_options['listing_taxonomies']['label'] as $key => $value){
               $slug=$vibe_options['listing_taxonomies']['slug'][$key];
                register_taxonomy( $slug, array( LISTING ),
		array(
			'labels' => array(
				'name' => $value,
				'menu_name' => $value,
				'singular_name' => $value,
				'all_items' => 'All '.$value
			),
			'public' => true,
			'hierarchical' => true,
			'show_ui' => true,
			'rewrite' => array( 'slug' => $slug, 'hierarchical' => true, 'with_front' => false ),
		)
                );
            }
        }
       
          
}
add_action( 'init', 'register_listings' );
/*
function portfolio_rewrite_rules( $wp_rewrite ) {
	$new_rules = array( 'portfolio/(.*)/(.*)' => 'index.php?post_type=portfolio&section=' . $wp_rewrite->preg_index( 1 ) . '&portfolio=' . $wp_rewrite->preg_index( 2 ) );
	$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}
add_action( 'generate_rewrite_rules', 'portfolio_rewrite_rules' );
*/

/*== Popups == */

function register_popups() {
	register_post_type( 'popups',
		array(
			'labels' => array(
				'name' => 'Popups',
				'menu_name' => 'Popups',
				'singular_name' => 'Popup',
				'all_items' => 'All Popups'
			),
                    
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'supports' => array( 'title', 'editor', 'author', 'thumbnail'),
			'hierarchical' => false,
			'has_archive' => true,
            'menu_position' => 4,
            'show_in_nav_menus' => false,
			'rewrite' => array( 'slug' => 'popup', 'hierarchical' => true, 'with_front' => false )
		)
	);
        
          flush_rewrite_rules();
}
add_action( 'init', 'register_popups' );



/*== Landing Pages == */

function register_clients() {
	register_post_type( 'clients',
		array(
			'labels' => array(
				'name' => 'Clients',
				'menu_name' => 'Clients',
				'singular_name' => 'Clients',
				'all_items' => 'All Clients'
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'supports' => array( 'title', 'editor', 'thumbnail'),
			'hierarchical' => false,
			'has_archive' => false,
            'menu_position' => 5,
            'show_in_nav_menus' => false,
			'rewrite' => array( 'slug' => 'client', 'hierarchical' => true, 'with_front' => false )
		)
	);
        
          flush_rewrite_rules();
}
add_action( 'init', 'register_clients' );


function register_agents() {
	register_post_type( 'agent',
		array(
			'labels' => array(
				'name' => 'Agents',
				'menu_name' => 'Agents',
				'singular_name' => 'Agent',
				'all_items' => 'All Agents'
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'supports' => array( 'title', 'editor', 'thumbnail'),
			'hierarchical' => false,
			'has_archive' => true,
            'menu_position' => 5,
            'show_in_nav_menus' => false,
			'rewrite' => array( 'slug' => 'agent', 'hierarchical' => true, 'with_front' => false )
		)
	);
        
          flush_rewrite_rules();
}
add_action( 'init', 'register_agents' );
/*== Testimonials == */

function register_testimonials() {
	register_post_type( 'testimonials',
		array(
			'labels' => array(
				'name' => 'Testimonials',
				'menu_name' => 'Testimonials',
				'singular_name' => 'Testimonial',
				'all_items' => 'All Testimonials'
			),
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'supports' => array( 'title', 'editor','excerpt','thumbnail'),
			'hierarchical' => false,
			'has_archive' => true,
            'menu_position' => 6,
            'show_in_nav_menus' => false,
			'rewrite' => array( 'slug' => 'testimonial', 'hierarchical' => true, 'with_front' => false )
		)
	);
        
          flush_rewrite_rules();
}
add_action( 'init', 'register_testimonials' );



/* === Dynamically Generated Custom Posts === */

function dynamic_custom_posts(){
    global $vibe_options;
    
    if(isset($vibe_options['custom_posts'])){
$custom_post_types=$vibe_options['custom_posts'];
$n=0;
if(isset($custom_post_types['post-type-name']))
$n= count($custom_post_types['post-type-name']);

for($i=0;$i<$n;$i++){
    
    if(isset($custom_post_types['post-type-name'][$i]) && ($custom_post_types['post-type-name'][$i] !='')){
        
    
    $supportsarray=array();
    $taxonomyarray=array();
    if(isset($custom_post_types['supports-title'][$i])){
        $supportsarray[]='title';
    }
    if(isset($custom_post_types['supports-editor'][$i])){
        $supportsarray[]='editor';
    }
    if(isset($custom_post_types['supports-excerpt'][$i])){
        $supportsarray[]='excerpt';
    }
    if(isset($custom_post_types['supports-trackbacks'][$i])){
        $supportsarray[]='trackbacks';
    }
    if(isset($custom_post_types['supports-customfields'][$i])){
        $supportsarray[]='custom-fields';
    }
    if(isset($custom_post_types['supports-comments'][$i])){
        $supportsarray[]='comments';
    }
    if(isset($custom_post_types['supports-revisions'][$i])){
        $supportsarray[]='revisions';
    }
    if(isset($custom_post_types['supports-thumbnail'][$i])){
        $supportsarray[]='thumbnail';
    }
    if(isset($custom_post_types['supports-author'][$i])){
        $supportsarray[]='author';
    }
    if(isset($custom_post_types['supports-pageattributes'][$i])){
        $supportsarray[]='page-attributes';
    }
    if(isset($custom_post_types['supports-postformats'][$i])){
        $supportsarray[]='post-formats';
    }
    
    $taxonomies=get_taxonomies('','names'); 
          foreach ($taxonomies as $taxonomy ) {
           if(isset($custom_post_types['taxonomy'][$taxonomy][$i])){
        $taxonomyarray[]=$taxonomy;
            } 
      }
      
         
        register_post_type( $custom_post_types['post-type-name'][$i],
		array(
			'labels' => array(
				'name' => $custom_post_types['post-type-name'][$i],
				'singular_name' => $custom_post_types['singular-label'][$i],
                                'add_new' => $custom_post_types['label-add-new'][$i],
				'all_items' => 'All '.$custom_post_types['post-type-name'][$i].'s',
                                'add_new_item' => $custom_post_types['label-add-new-item'][$i],
                                'edit_item' => $custom_post_types['label-edit-item'][$i],
                                'new_item' => $custom_post_types['label-new-item'][$i],
                                'view_item' => $custom_post_types['label-view-item'][$i],
                                'search_items' => $custom_post_types['label-search-item'][$i],
                                'not_found' => $custom_post_types['label-not-found'][$i],
                                'not_found_in_trash' => $custom_post_types['label-not-found-trash'][$i],
                                'parent_item_coln' => $custom_post_types['label-parent'][$i],
                                'menu_name' => $custom_post_types['label-menu-name'][$i],
                            
			),
                        'description' => $custom_post_types['description'][$i],
			'public' => ((isset($custom_post_types['public'][$i]))? true : false),
			'publicly_queryable' => ((isset($custom_post_types['queryvar'][$i]))? true : false),
			'show_ui' => ((isset($custom_post_types['showui'][$i]))? true : false),
			'show_in_menu' => ((isset($custom_post_types['showmenu'][$i]))? true : false),
			'show_in_nav_menus' => ((isset($custom_post_types['shownavmenu'][$i]))? true : false),
                        'show_in_admin_bar' => ((isset($custom_post_types['showadminmenu'][$i]))? true : false),
			'menu_position ' => intval($custom_post_types['menuposition'][$i]),
			'capability_type' =>$custom_post_types['capability'][$i],
                        'supports' => $supportsarray,
                        'taxonomies' => $taxonomyarray,
                        'menu_icon' => VIBE_URL.'/img/tagline_icon.png',
			'hierarchical' => ((isset($custom_post_types['hierarchial'][$i]))? true : false),
			'has_archive' => ((isset($custom_post_types['hasarchive'][$i]))? true : false),
                        'exclude_from_search'=> ((isset($custom_post_types['excludesearch'][$i]))? true : false),
                        'menu_position' => $custom_post_types['menuposition'][$i],
			'rewrite' => ((isset($custom_post_types['rewrite'][$i]))? array( 'slug' =>  $custom_post_types['rewriteslug'][$i]) : false)
		)
            
	);
            
            
            }//End if
        }//End -For loop
    }//End if isset 
    
          flush_rewrite_rules();
}

add_action( 'init', 'dynamic_custom_posts' );
?>