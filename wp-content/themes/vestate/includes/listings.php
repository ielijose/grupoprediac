<?php

/**
 * FILE: listings.php 
 * Created on Aug 4, 2013 at 7:17:59 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate 
 * License: GPLv2
 */


function vibe_custom_listing_columns( $column, $post_id ) {
	global $post,$vibe_options;
	
	switch ($column) {
		case "thumb" :
			echo '<a href="' . get_edit_post_link( $post->ID ) . '">' . get_the_post_thumbnail($post->ID) . '</a>';
		break;
		/*case "mls" :
			if ($the_product->get_sku()) echo $the_product->get_sku(); else echo '<span class="na">&ndash;</span>';
		break;*/
		case "price":
                         $price= getPostMeta($post->ID,'vibe_price');
                         if ($price) 
                             echo $price; 
                         else 
                             echo '<span class="na">&ndash;</span>';
		break;
        case "listing-type" : 
            if ( ! $terms = get_the_terms( $post->ID, $column ) ) {
                echo '<span class="na">&ndash;</span>';
            } else {
                if(isset($terms) && is_array($terms)){
                    foreach ( $terms as $term ) {
                    $termlist[] = '<a href="' . admin_url( 'edit.php?' . $column . '=' . $term->slug . '&post_type=listing' ) . ' ">' . $term->name . '</a>';
                    }
                    echo implode( ', ', $termlist );
                }
            }
        break;
		case 'featured':
                    $label = 'vibe_featured';
                    if(in_array('featured', $vibe_options['listing_fields']['field_type'])){
                        $i = array_search('featured', $vibe_options['listing_fields']['field_type']);
                        $label = 'vibe_'.strtolower(str_replace(' ', '-',$vibe_options['listing_fields']['label'][$i]));
                    }
                    $featured= getPostMeta($post->ID,$label);
			$url = wp_nonce_url( admin_url( 'admin-ajax.php?action=vibe-feature-listing&listing_id=' . $post->ID ), 'vibe-feature-listing' );
			echo '<a href="' . $url . '" title="'. __( 'Toggle featured', 'woocommerce' ) . '">';
			if ( $featured ) {
				echo '<img src="' . VIBE_URL . '/includes/metaboxes/images/on.png" alt="'. __( 'yes', 'vibe' ) . '" height="26" width="65" />';
			} else {
				echo '<img src="' . VIBE_URL . '/includes/metaboxes/images/off.png" alt="'. __( 'no', 'vibe' ) . '" height="26" width="65" />';
			}
			echo '</a>';
		break;
                case 'available':
                    $label = 'vibe_available';
                    if(in_array('available', $vibe_options['listing_fields']['field_type'])){
                        $i = array_search('available', $vibe_options['listing_fields']['field_type']);
                        $label = 'vibe_'.strtolower(str_replace(' ', '-',$vibe_options['listing_fields']['label'][$i]));
                    }
                     $available= getPostMeta($post->ID,$label);
                     
			$url = wp_nonce_url( admin_url( 'admin-ajax.php?action=vibe-available-listing&listing_id=' . $post->ID ), 'vibe-available-listing' );
			echo '<a href="' . $url . '" title="'. __( 'Toggle featured', 'woocommerce' ) . '">';
			if ( $available) {
				echo '<img src="' . VIBE_URL . '/includes/metaboxes/images/on.png" alt="'. __( 'yes', 'vibe' ) . '" height="26" width="65" />';
			} else {
				echo '<img src="' . VIBE_URL . '/includes/metaboxes/images/off.png" alt="'. __( 'no', 'vibe' ) . '" height="26" width="65" />';
			}
			echo '</a>';
		break;
	}
}

add_action('manage_listing_posts_custom_column', 'vibe_custom_listing_columns',10, 2 );



add_filter( 'manage_edit-listing_columns', 'vibe_listing_columns' ) ;

function vibe_listing_columns( $columns ) {
global $vibe_options;
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Listing','vibe' ),
                'listing-type' => __( 'Listing Type','vibe' )
                );
        if(in_array('price', $vibe_options['listing_fields']['field_type'])){
            $i = array_search('price', $vibe_options['listing_fields']['field_type']);
            $label = $vibe_options['listing_fields']['label'][$i];
            $columns['price'] = $label; 
        }
                
            
        if(in_array('featured', $vibe_options['listing_fields']['field_type'])){
            $i = array_search('featured', $vibe_options['listing_fields']['field_type']);
            $label = $vibe_options['listing_fields']['label'][$i];
            $columns['featured'] = $label; 
        }
        if(in_array('available', $vibe_options['listing_fields']['field_type'])){
            $i = array_search('available', $vibe_options['listing_fields']['field_type']);
            $label = $vibe_options['listing_fields']['label'][$i];
            $columns['available'] = $label; 
        }
        
        
        $columns['author'] = __( 'Agent','vibe' );
        $columns['date'] = __( 'Date','vibe' );


	return $columns;
}


function vibe_custom_listing_sort($columns) {
	$custom = array(
		'price'			=> 'price',
		'featured'		=> 'featured',
		'available'		=> 'available',
		'title'			=> 'title'
	);
	return wp_parse_args( $custom, $columns );
}

add_filter( 'manage_edit-listing_sortable_columns', 'vibe_custom_listing_sort');


function vibe_custom_listing_orderby( $vars ) {
	if (isset( $vars['orderby'] )) :
		if ( 'price' == $vars['orderby'] ) :
			$vars = array_merge( $vars, array(
				'meta_key' 	=> 'vibe_price',
				'orderby' 	=> 'meta_value_num'
			) );
		endif;
		if ( 'featured' == $vars['orderby'] ) :
			$vars = array_merge( $vars, array(
				'meta_key' 	=> 'vibe_featured',
				'orderby' 	=> 'meta_value'
			) );
		endif;
                if ( 'available' == $vars['orderby'] ) :
			$vars = array_merge( $vars, array(
				'meta_key' 	=> 'vibe_available',
				'orderby' 	=> 'meta_value'
			) );
		endif;
	endif;

	return $vars;
}

add_filter( 'request', 'vibe_custom_listing_orderby' );


/*=== Filters and Sorters ===*/

$possible_orders = array('price');



add_filter( 'pre_get_posts', 'archive_meta_sorting' );
function archive_meta_sorting( $query_object ) {
    
    if( !is_archive() || is_admin() || is_page())
       return $query_object;

    if( !isset( $_GET['orderby'] ) )
        return $query_object;

    global $possible_orders;

    $orderby = trim( $_GET['orderby'] );    
    if($query_object->is_main_query()){
        switch( $orderby ) {
            case( in_array( $orderby, $possible_orders ) ):
                  //$query_object->set( 'orderby', 'meta_value_num' );
                  //$query_object->set( 'meta_key', 'vibe_price' );
                break;
            // You don't actually need these two cases below, it will work without them
            // The switch could actually just be a simple if in_array condition..
            case 'title':
                $query_object->set( 'orderby', 'title' );
                break;
            case 'date':
                $query_object->set( 'orderby', 'date' );
                break;
        }
    }    
    return $query_object;
}

/*
function custom_search_query( $query ) {
$custom_fields = array(
// put all the meta fields you want to search for here
"vibe_price",
"vibe_available"
);
$searchterm = $query->query_vars['s'];
// we have to remove the "s" parameter from the query, because it will prevent the posts from being found
$query->query_vars['s'] = "";
if ($searchterm != "") {

$meta_query = array('relation' => 'OR');

foreach($custom_fields as $cf) {
    array_push($meta_query, array(
        'key' => $cf,
        'value' => $searchterm,
        'compare' => 'LIKE'
    ));
    }
    $query->set("meta_query", $meta_query);
    };
}

add_filter( "pre_get_posts", "custom_search_query");
*/
add_action( "save_post", "add_title_custom_field");

function add_title_custom_field($postid){
    if(isset($_POST["post_title"]))
        update_post_meta($postid, "_post_title", $_POST["post_title"]);
}


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



?>