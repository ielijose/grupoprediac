<?php

/**
 * FILE: listings_filter_widget.php 
 * Created on Aug 12, 2013 at 5:09:48 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate 
 * License: GPLv2
 */


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Vibe_Advanced_Listing_Search extends WP_Widget {
    
        function Vibe_Advanced_Listing_Search() {
	$widget_ops = array( 'classname' => 'advanced_listings_search', 'description' => 'Advanced listings search widget.' );
	$control_ops = array( 'width' => 250, 'height' => 350,'id_base' => 'vibe_advanced_listing_search');
	$this->WP_Widget( 'Vibe_Advanced_Listing_Search',  __('Vibe Advanced Listing Search','vibe'), $widget_ops, $control_ops);
	}
        
        
        function widget( $args, $instance ) {
		global $vibe_options;
		extract( $args );
                
                echo $before_widget;
                $title = apply_filters('widget_title', $instance['title'] );
		// Display the widget title 
                ?>
                <div class="advanced-listing-search">
                <?php
		if ( $title )
                    echo $args['before_title'] . $title . $args['after_title'];
                

                $taxonomy_tree=vibe_get_option('taxonomy_tree');

                if(isset($taxonomy_tree) && $taxonomy_tree)
                    $vibe_advanced_listings_search=get_option('vibe_advanced_listings_search');
                 

                ?>
                <form method="get" action="<?php echo get_permalink( $vibe_options['listing_search_page'] ); ?>">
                    <?php
                    if(isset($instance['tab']) && $instance['tab']){
                    ?>
                    <div class="tabs tabbable">
                        <ul <?php echo ((isset($taxonomy_tree) && $taxonomy_tree)?'id="ajax_taxonomy"':''); ?> class="nav nav-tabs light">
                    <?php
                    
                    $tabs = get_terms($instance['tab']);
                    $first_flag=1;
                    foreach($tabs as $tab){
                        
                       $class='';
                       if(isset($_GET[$instance['tab']]) && in_array($tab->slug,$_GET[$instance['tab']])){
                            $class='class="active"';
                        }
                        
                        $hide_terms = explode(',',$instance['hide_terms']);
                        $hide_terms[]='';
                        if(!in_array($tab->name,$hide_terms)){


                            if($first_flag){
                                $first_tab=$tab->slug;
                                $first_flag=0;
                            }
                            echo '<li '.$class.'><a href="#'.$tab->slug.'" class="activate-tab">'.$tab->name.'</a></li>';
                        }
                    }
                    ?>
                        </ul>
                        <div class="tab-content light">
                            <?php
                            foreach($tabs as $tab){
                            echo '<div class="tab-pane hidden-tab" id="'.$tab->slug.'"><input type="radio" name="'.$instance['tab'].'[0]" value="'.$tab->slug.'" /></div>';
                            }
                            ?>
                        </div>    
                    </div>
                    <?php
                        }
                    ?>
                    <div class="advanced_listing_search" data-tax="<?php echo $instance['tab']; ?>" data-sort="<?php echo $instance['sort']; ?>" data-sortby="<?php echo $instance['sortby']; ?>" data-count="<?php echo $instance['count']; ?>">
                    <ul>
                    <?php    
                        if(isset($instance['id_search']) && $instance['id_search']){
                            echo '<input type="hidden" name="id_" value="1" />';
                            foreach($vibe_options['listing_fields']['field_type'] as $k => $value){
                                if($value == 'id'){ 
                                    echo '<li>';
                                    $label = $vibe_options['listing_fields']['label'][$k];
                                    $key=strtolower(str_replace(' ', '-',$label));
                                    echo '<input type="text" name="'.$key.'" placeholder="'.$label.'" value="'.(isset($_GET[$key])?$_GET[$key]:'').'"/>';
                                    echo '</li>';
                                }
                            }
                        }

                        $search_terms=vibe_get_option('search_terms');   
                        if(isset($search_terms) && $search_terms){
                            if(isset($_GET['s'])){
                                $_GET['keywords'] = $_GET['s'];
                            }
                            echo '<li><input type="text" name="keywords" value="'.(isset($_GET['keywords'])?$_GET['keywords']:'').'"  placeholder="Keywords" /></li>';
                        }
                    ?>
                    <?php 
                    

                    // DEFAULT if vibe_advanced_listings_search; Option is not SET
                     if(isset($vibe_options['listing_taxonomies']) && is_array($vibe_options['listing_taxonomies']) && is_array($vibe_options['listing_taxonomies']['search'])){
                        foreach($vibe_options['listing_taxonomies']['search'] as $key => $value){
                            $slug=$vibe_options['listing_taxonomies']['slug'][$key];
                            $label=$vibe_options['listing_taxonomies']['label'][$key];
                    if($instance['tab'] != $slug){
                    echo '<li class="search_select">';
                    echo '<select name="'.$slug.'[]" data-placeholder="'.$label.'"  class="chosen-select chzn-select" multiple>';

                    if(!isset($instace['sort'])){
                        $instace['sort'] = 'name';
                    }
                    if(!isset($instace['sortby'])){
                        $instace['sortby'] = 'ASC';
                    }
                    $args = array(
                                            'orderby' => $instance['sort'],
                                            'order' => $instance['sortby']
                                            );    

                    $locations = get_terms($slug,$args);
                    $c='';
                    foreach($locations as $location){
                        if(isset($instance['count']) && $instance['count']){
                            if(isset($vibe_advanced_listings_search)){
                                if(isset($_GET[$instance['tab']]) && count($_GET[$instance['tab']]) > 0){
                                    $first_tab = $_GET[$instance['tab']][0];
                                }
                               $c='('.(isset($vibe_advanced_listings_search[$first_tab][$slug][$location->slug])?$vibe_advanced_listings_search[$first_tab][$slug][$location->slug]:'0').')';
                            }else
                            $c= '('.$location->count.')';
                        }
                        
                     if(isset($vibe_advanced_listings_search) && $vibe_advanced_listings_search){    // BUG FIX
                        if(isset($vibe_advanced_listings_search[$first_tab][$slug][$location->slug]) && $vibe_advanced_listings_search[$first_tab][$slug][$location->slug]){
                            echo '<option value="'.$location->slug.'" '.((isset($_GET[$slug]) && in_array($location->slug,$_GET[$slug]))?'selected="SELECTED"':'').'>'.$location->name.''.$c.'</option>';
                        }
                    }else    
                        echo '<option value="'.$location->slug.'" '.((isset($_GET[$slug]) && in_array($location->slug,$_GET[$slug]))?'selected="SELECTED"':'').'>'.$location->name.''.$c.'</option>';
                    }
                    echo '</select></li>'; 
                    }
                       }
                        }    

                        
                    ?>
                    
                        <li id="submit_advanced_search"><input type="submit" value="<?php _e('Search','vibe'); ?>" class="btn" /></li>
                    </ul>
                   </div>     
                </form>
            </div>
                <?php
                echo $after_widget;
        }
        
        function update( $new_instance, $old_instance ) {
		global $vibe_options;
                $instance = array();
                
                $instance = $old_instance;
		         $instance['title']=$new_instance['title'];
                 $instance['count']=$new_instance['count'];
                 $instance['sort']=$new_instance['sort'];
                 $instance['sortby']=$new_instance['sortby'];
                 $instance['hide_terms']=$new_instance['hide_terms'];
                $instance['tab']=$new_instance['tab'];
                 $instance['id_search']=$new_instance['id_search'];
               return $instance;
	}
        
        function form( $instance ) {
		global $vibe_options;
                ?>
                <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'vibe' ) ?></label>
		<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php if ( isset( $instance['title'] ) ) echo esc_attr( $instance['title'] ); ?>" />
                </p><p><label for="<?php echo $this->get_field_id( 'tab' ); ?>"><?php _e( 'Select Tab Term:', 'vibe' ) ?></label>
                    <select name="<?php echo esc_attr( $this->get_field_name( 'tab' ) ); ?>" >
                        <option value=""><?php _e('Select tab values from','vibe');?></option>
                        <?php
                        if(isset($vibe_options['listing_taxonomies']) && is_array($vibe_options['listing_taxonomies']) && is_array($vibe_options['listing_taxonomies']['search'])){
                        foreach($vibe_options['listing_taxonomies']['search'] as $key => $value){
                            $slug=$vibe_options['listing_taxonomies']['slug'][$key];
                            $label=$vibe_options['listing_taxonomies']['label'][$key];
                            echo '<option value="'. $slug.'" '.( isset( $instance['tab'] )? selected($instance['tab'], $slug):'').'>'.$label.'</option>';
                            }
                        }
                        ?>
                   </select>
                    <br /><a href="#" id="generate_tree" ><?php _e('Generate Taxonomy Tree for Tabs','vibe'); ?></a>
                   </p>
                   <p>
                      <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Show Count','vibe'); ?></label> 
                       <select class="select" name="<?php echo $this->get_field_name('count'); ?>">
                            <option value="1" <?php selected($instance['count'],1); ?>> Yes </option>
                            <option value="0" <?php selected($instance['count'],0); ?>> No </option>
                            </select>
                    </p>
                     <p>
                      <label for="<?php echo $this->get_field_id('sort'); ?>"><?php _e('Sort By','vibe'); ?></label> 
                       <select class="select" name="<?php echo $this->get_field_name('sort'); ?>">
                            <option value="name" <?php selected($instance['sort'],'name'); ?>> Name </option>
                            <option value="count" <?php selected($instance['sort'],'count'); ?>> Count </option>
                       </select>
                       <select class="select" name="<?php echo $this->get_field_name('sortby'); ?>">
                            <option value="ASC" <?php selected($instance['sortby'],'ASC'); ?>> Ascending </option>
                            <option value="DESC" <?php selected($instance['sortby'],'DESC'); ?>> Desending </option>
                       </select>
                    </p>
                     <p>
                      <label for="<?php echo $this->get_field_id('hide_terms'); ?>"><?php _e('Hide Taxonomy Terms (comma saperated)','vibe'); ?></label> 
                      <input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'hide_terms' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_terms' ) ); ?>" value="<?php if ( isset( $instance['hide_terms'] ) ) echo esc_attr( $instance['hide_terms'] ); ?>" /> 
                    </p>
                    <p>
                    <label for="<?php echo $this->get_field_id('id_search'); ?>"><?php _e('Include ID Fields in Search','vibe'); ?></label> 
                    <select class="select" name="<?php echo $this->get_field_name('id_search'); ?>">
                        <option value="0" <?php selected($instance['id_search'],0); ?>> No </option>
                        <option value="1" <?php selected($instance['id_search'],1); ?>> Yes </option>
                    </select>
                    </p>
                 <?php
        }
}


?>
