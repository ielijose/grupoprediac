<?php

/**
 * FILE: config.php 
 * Created on Mar 2, 2013 at 4:11:49 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */

global $vibe_options;
$vibe_options = get_option(THEME_SHORT_NAME);
$fonts=array();
if(isset($vibe_options['google_fonts'])&& is_array($vibe_options['google_fonts']))
foreach($vibe_options['google_fonts'] as $font){
    $fonts[$font]=$font;
}


if(isset($vibe_options['custom_fonts']) && is_array($vibe_options['custom_fonts']) && count($vibe_options['custom_fonts']) > 0){
    $custom_fonts=array();
    foreach($vibe_options['custom_fonts'] as $font){
        $custom_fonts[$font]=$font;
    }
    $fonts= array_merge($fonts, $custom_fonts); 
}

                    
$viz_customizer = array(
  'sections' => array(
                    'theme'=>'Theme',
                    'header'=>'Header',
                    'body'  => 'Body',
                    'typography' => 'Typography',
                    'elements' => 'Elements',
                    'footer' => 'Footer'
                    ),
    'controls' => array(
        'theme' => array( 
                            'primary_color' => array(
                                                            'label' => 'Theme Primary Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),
                            'primary_text_color' => array(
                                                            'label' => 'Theme Primary Text Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),  
                            ),
        'header' => array(   
                            'logo_top' => array(
                                                            'label' => 'Header: Space between Logo and Header-Top (Logo Top Margin)',
                                                            'type'  => 'slider',
                                                            'default' => '26'
                                                            ),
                            'logo_size' => array(
                                                            'label' => 'Logo Size',
                                                            'type'  => 'slider',
                                                            'default' => '36'
                                                            ),
                            'header_top_bg_color' => array(
                                                            'label' => 'Header Top : Background Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),                               
                            'header_top_border_color' => array(
                                                            'label' => 'Header Top : Border Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),                                
                            'header_top_color' => array(
                                                            'label' => 'Header Top : Text Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ), 
                            'header_top_font_size' => array(
                                                            'label' => 'Header Top : Font size',
                                                            'type'  => 'slider',
                                                            'default' => '12'
                                                            ),
                            
                            'header_bg_color' => array(
                                                            'label' => 'Header : Background Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),
                                                           
                            'header_bg_image' => array(
                                                            'label' => 'Header : Background Image',
                                                            'type'  => 'image',
                                                            'default' => ''
                                                            ),
                             'header_font' => array(
                                                            'label' => 'Header : Font',
                                                            'type'  => 'select',
                                                            'choices' => $fonts,
                                                            'default' => ''
                                                            ),   
                             'header_font_size' => array(
                                                            'label' => 'Header : Font size',
                                                            'type'  => 'slider',
                                                            'default' => '12'
                                                            ),
                             'header_color' => array(
                                                            'label' => 'Header : Font color',
                                                            'type'  => 'color',
                                                            'default' => '#444'
                                                            ),  
                             'nav_bg_color' => array(
                                                            'label' => 'Navigation : Background color',
                                                            'type'  => 'color',
                                                            'default' => '#FFF'
                                                            ), 
                             'nav_border_color' => array(
                                                            'label' => 'Navigation : Border color',
                                                            'type'  => 'color',
                                                            'default' => '#EFEFEF'
                                                            ),                                
                             'nav_font' => array(
                                                            'label' => 'Navigation : Font Family',
                                                            'type'  => 'select',
                                                            'choices' => $fonts,
                                                            'default' => ''
                                                            ),   
                             'nav_font_weight' => array(
                                                            'label' => 'Navigation : Font Weight',
                                                            'type'  => 'select',
                                                            'choices' => array(
                                                                '100'=>'100 : Lighter',
                                                                '200'=>'200 : Light',
                                                                '300'=>'300 : Light',
                                                                '400'=>'400 : Normal',
                                                                '600'=>'600 : Bold',
                                                                '700'=>'700 : Bolder',
                                                                '800'=>'800 : Bolder'
                                                            ),
                                                            'default' => '400'
                                                            ),                                
                             'nav_color' => array(
                                                            'label' => 'Navigation : Font Color',
                                                            'type'  => 'color',
                                                            'default' => '#474747'
                                                            ),                               
                             'nav_size' => array(
                                                            'label' => 'Navigation : Font Size (in px)',
                                                            'type'  => 'slider',
                                                            'default' => '14'
                                                            ),  
                              'nav_sub_text_size' => array(
                                                            'label' => 'Navigation : Sub-menu-Item Font Size (in px)',
                                                            'type'  => 'slider',
                                                            'default' => '12'
                                                            ),                             
                              'nav_sub_font' => array(
                                                            'label' => 'Navigation Sub-Menu : Font Family',
                                                            'type'  => 'select',
                                                            'choices' => $fonts,
                                                            'default' => ''
                                                            ),                                
            
            ),
        'body' => array(
                            'body_bg_color' => array(
                                                            'label' => 'Background Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),
                            'main_bg_color' => array(
                                                            'label' => 'Main Content Background Color',
                                                            'type'  => 'color',
                                                            'default' => '#FFF'
                                                            ),             
                            'body_bg_image' => array(
                                                            'label' => 'Background Image (Boxed only)',
                                                            'type'  => 'image',
                                                            'default' => ''
                                                            ),                                    
                            'body_bg_image_repeat' => array(
                                                            'label' => 'Background Image Repeat',
                                                            'type'  => 'select',
                                                            'choices'    => array(
                                                                        '' => 'Auto Repeat',
                                                                        'repeat-x' => 'Repeat-X',
                                                                        'repeat-y' => 'Repeat-Y',
                                                                        'center' => 'Center ViewPort',
                                                                            ),
                                                            'default' => ''
                                                            ),
                             'body_text_font' => array(
                                                            'label' => 'Font Family',
                                                            'type'  => 'select',
                                                            'choices' => $fonts,
                                                            'default' => ''
                                                            ),  
                              'body_font_weight' => array(
                                                            'label' => 'Font Weight',
                                                            'type'  => 'select',
                                                            'choices' => array(
                                                                '100'=>'100 : Lighter',
                                                                '200'=>'200 : Light',
                                                                '300'=>'300 : Light',
                                                                '400'=>'400 : Normal',
                                                                '600'=>'600 : Bold',
                                                                '700'=>'700 : Bolder',
                                                                '800'=>'800 : Bolder'
                                                            ),
                                                            'default' => '400'
                                                            ),                               
                             'body_text_color' => array(
                                                            'label' => 'Font Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),
                             'body_text_size' => array(
                                                            'label' => 'Font Size (in px)',
                                                            'type'  => 'slider',
                                                            'default' => '12'
                                                            ), 
                             'body_link_color' => array(
                                                            'label' => 'Link Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),                                 
                             'body_border_color' => array(
                                                            'label' => 'Border Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),
                              'body_elements_bg_color' => array(
                                                            'label' => 'Body Elements Background color',
                                                            'type'  => 'color',
                                                            'default' => '#FFF'
                                                            ),
                               'body_hover_color' => array(
                                                            'label' => 'Background Hover Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),
                             
            
            ),
        'typography' => array(
            
                            'h1_font' => array(
                                                            'label' => 'H1 Font Family',
                                                            'type'  => 'select',
                                                            'choices' => $fonts,
                                                            'default' => ''
                                                            ),
                              'h1_font_weight' => array(
                                                            'label' => 'H1: Font Weight',
                                                            'type'  => 'select',
                                                            'choices' => array(
                                                                '100'=>'100 : Lighter',
                                                                '200'=>'200 : Light',
                                                                '300'=>'300 : Light',
                                                                '400'=>'400 : Normal',
                                                                '600'=>'600 : Bold',
                                                                '700'=>'700 : Bolder',
                                                                '800'=>'800 : Bolder'
                                                            ),
                                                            'default' => '400'
                                                            ),                               
                             'h1_color' => array(
                                                            'label' => 'H1 Font Color',
                                                            'type'  => 'color',
                                                            'default' => '#474747'
                                                            ),
                             'h1_size' => array(
                                                            'label' => 'H1 Font Size (in px)',
                                                            'type'  => 'slider',
                                                            'default' => '28'
                                                            ),       
                             
                             'h2_font' => array(
                                                            'label' => 'H2 Font Family',
                                                            'type'  => 'select',
                                                            'choices' => $fonts,
                                                            'default' => ''
                                                            ),   
                               'h2_font_weight' => array(
                                                            'label' => 'H2: Font Weight',
                                                            'type'  => 'select',
                                                            'choices' => array(
                                                                '100'=>'100 : Lighter',
                                                                '200'=>'200 : Light',
                                                                '300'=>'300 : Light',
                                                                '400'=>'400 : Normal',
                                                                '600'=>'600 : Bold',
                                                                '700'=>'700 : Bolder',
                                                                '800'=>'800 : Bolder'
                                                            ),
                                                            'default' => '400'
                                                            ),                              
                             'h2_color' => array(
                                                            'label' => 'H2 Font Color',
                                                            'type'  => 'color',
                                                            'default' => '#474747'
                                                            ),
                             'h2_size' => array(
                                                            'label' => 'H2 Font Size (in px)',
                                                            'type'  => 'slider',
                                                            'default' => '22'
                                                            ),  
                             'h3_font' => array(
                                                            'label' => 'H3 Font Family',
                                                            'type'  => 'select',
                                                            'choices' => $fonts,
                                                            'default' => ''
                                                            ),  
                             'h3_font_weight' => array(
                                                            'label' => 'H3: Font Weight',
                                                            'type'  => 'select',
                                                            'choices' => array(
                                                                '100'=>'100 : Lighter',
                                                                '200'=>'200 : Light',
                                                                '300'=>'300 : Light',
                                                                '400'=>'400 : Normal',
                                                                '600'=>'600 : Bold',
                                                                '700'=>'700 : Bolder',
                                                                '800'=>'800 : Bolder'
                                                            ),
                                                            'default' => '400'
                                                            ),                               
                             'h3_color' => array(
                                                            'label' => 'H3 Font Color',
                                                            'type'  => 'color',
                                                            'default' => '#474747'
                                                            ),
                             'h3_size' => array(
                                                            'label' => 'H3 Font Size (in px)',
                                                            'type'  => 'slider',
                                                            'default' => '18'
                                                            ),     
                            'h4_font' => array(
                                                            'label' => 'H4 Font Family',
                                                            'type'  => 'select',
                                                            'choices' => $fonts,
                                                            'default' => ''
                                                            ),  
                             'h4_font_weight' => array(
                                                            'label' => 'H4: Font Weight',
                                                            'type'  => 'select',
                                                            'choices' => array(
                                                                '100'=>'100 : Lighter',
                                                                '200'=>'200 : Light',
                                                                '300'=>'300 : Light',
                                                                '400'=>'400 : Normal',
                                                                '600'=>'600 : Bold',
                                                                '700'=>'700 : Bolder',
                                                                '800'=>'800 : Bolder'
                                                            ),
                                                            'default' => '400'
                                                            ),                               
                             'h4_color' => array(
                                                            'label' => 'H4 Font Color',
                                                            'type'  => 'color',
                                                            'default' => '#474747'
                                                            ),
                             'h4_size' => array(
                                                            'label' => 'H4 Font Size (in px)',
                                                            'type'  => 'slider',
                                                            'default' => '16'
                                                            ),    
                             'h5_font' => array(
                                                            'label' => 'H5 Font Family',
                                                            'type'  => 'select',
                                                            'choices' => $fonts,
                                                            'default' => ''
                                                            ),   
                             'h5_font_weight' => array(
                                                            'label' => 'H5: Font Weight',
                                                            'type'  => 'select',
                                                            'choices' => array(
                                                                '100'=>'100 : Lighter',
                                                                '200'=>'200 : Light',
                                                                '300'=>'300 : Light',
                                                                '400'=>'400 : Normal',
                                                                '600'=>'600 : Bold',
                                                                '700'=>'700 : Bolder',
                                                                '800'=>'800 : Bolder'
                                                            ),
                                                            'default' => '400'
                                                            ),                               
                             'h5_color' => array(
                                                            'label' => 'H5 Font Color',
                                                            'type'  => 'color',
                                                            'default' => '#474747'
                                                            ),
                             'h5_size' => array(
                                                            'label' => 'H5 Font Size (in px)',
                                                            'type'  => 'slider',
                                                            'default' => '14'
                                                            ),     
                             'h6_font' => array(
                                                            'label' => 'H6 Font Family',
                                                            'type'  => 'select',
                                                            'choices' => $fonts,
                                                            'default' => ''
                                                            ),   
                             'h6_font_weight' => array(
                                                            'label' => 'H6: Font Weight',
                                                            'type'  => 'select',
                                                            'choices' => array(
                                                                '100'=>'100 : Lighter',
                                                                '200'=>'200 : Light',
                                                                '300'=>'300 : Light',
                                                                '400'=>'400 : Normal',
                                                                '600'=>'600 : Bold',
                                                                '700'=>'700 : Bolder',
                                                                '800'=>'800 : Bolder'
                                                            ),
                                                            'default' => '400'
                                                            ),                               
                             'h6_color' => array(
                                                            'label' => 'H6 Font Color',
                                                            'type'  => 'color',
                                                            'default' => '#474747'
                                                            ),
                             'h6_size' => array(
                                                            'label' => 'H6 Font Size (in px)',
                                                            'type'  => 'slider',
                                                            'default' => '12'
                                                            ),    
                                                          
            ),
        
        'elements' => array(                              
                            'title_bg_color' => array(
                                                            'label' => 'Subheader (Page Title) Background Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),
                            'title_bg_image' => array(
                                                            'label' => 'Subheader (Page Title) Background Image',
                                                            'type'  => 'image',
                                                            'default' => ''
                                                            ),
                            'title_text_color' => array(
                                                            'label' => 'Subheader (Page Title) Font Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ), 
                            'blockquote_bg_color' => array(
                                                            'label' => 'Blockquote Background Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),
                            'blockquote_text_color' => array(
                                                            'label' => 'Blockquote Font Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),                                 
                            'heading_text_color' => array(
                                                            'label' => 'Theme Heading Font Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),  
                            'heading_font_size' => array(
                                                            'label' => 'Theme Heading Font size',
                                                            'type'  => 'slider',
                                                            'default' => '24'
                                                            ),                                                                 
                           'heading_font_weight' => array(
                                                            'label' => 'Theme Heading Font Weight',
                                                            'type'  => 'select',
                                                            'choices' => array(
                                                                '100'=>'100 : Lighter',
                                                                '200'=>'200 : Light',
                                                                '300'=>'300 : Light',
                                                                '400'=>'400 : Normal',
                                                                '600'=>'600 : Bold',
                                                                '700'=>'700 : Bolder',
                                                                '800'=>'800 : Bolder'
                                                            ),
                                                            'default' => '400'
                                                            ),                                
                           'formfield_bg_color' => array(
                                                            'label' => 'Form Fields Background color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),  
                            'formfield_border_color' => array(
                                                            'label' => 'Form Fields Border Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),                                  
                            'formfield_font_color' => array(
                                                            'label' => 'Form Fields Font Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ), 
                            'formfield_font' => array(
                                                            'label' => 'Form Fields Font',
                                                            'type'  => 'select',
                                                            'choices' => $fonts,
                                                            'default' => ''
                                                            ),  
                           'formfield_font_weight' => array(
                                                            'label' => 'Form Fields Font Weight',
                                                            'type'  => 'select',
                                                            'choices' => array(
                                                                '100'=>'100 : Lighter',
                                                                '200'=>'200 : Light',
                                                                '300'=>'300 : Light',
                                                                '400'=>'400 : Normal',
                                                                '600'=>'600 : Bold',
                                                                '700'=>'700 : Bolder',
                                                                '800'=>'800 : Bolder'
                                                            ),
                                                            'default' => '400'
                                                            ),                                 
                           'formfield_font_size' => array(
                                                            'label' => 'Form Fields Font Size (in px)',
                                                            'type'  => 'slider',
                                                            'default' => ''
                                                            ),                                
                        ),
        'footer' => array(
                                'footer_bg_color' => array(
                                                            'label' => 'Footer Background Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),
                                'footer_bg_image' => array(
                                                            'label' => 'Footer Background Image',
                                                            'type'  => 'image',
                                                            'default' => ''
                                                            ),
                                'footer_border_color' => array(
                                                            'label' => 'Footer Border Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),             
                                'footer_text_color' => array(
                                                            'label' => 'Footer Font Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),
                                'footer_text_size' => array(
                                                            'label' => 'Footer Font Size (in px)',
                                                            'type'  => 'slider',
                                                            'default' => '12'
                                                            ),                                   
                                'footer_link_color' => array(
                                                            'label' => 'Footer Links Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),                            
                                'footer_text_font' => array(
                                                            'label' => 'Footer Font Family',
                                                            'type'  => 'select',
                                                            'choices' => $fonts,
                                                            'default' => ''
                                                            ),
                                 'footer_font_weight' => array(
                                                            'label' => 'Footer Font Weight',
                                                            'type'  => 'select',
                                                            'choices' => array(
                                                                '100'=>'100 : Lighter',
                                                                '200'=>'200 : Light',
                                                                '300'=>'300 : Light',
                                                                '400'=>'400 : Normal',
                                                                '600'=>'600 : Bold',
                                                                '700'=>'700 : Bolder',
                                                                '800'=>'800 : Bolder'
                                                            ),
                                                            'default' => '400'
                                                            ),                           
                                'footer_title_text_color' => array(
                                                            'label' => 'Footer Title Font Color',
                                                            'type'  => 'color',
                                                            'default' => ''
                                                            ),
                                'footer_title_text_size' => array(
                                                            'label' => 'Footer Title Font Size (in px)',
                                                            'type'  => 'slider',
                                                            'default' => ''
                                                            ),                                   

                                'footer_title_font' => array(
                                                            'label' => 'Footer Title Font Family',
                                                            'type'  => 'select',
                                                            'choices' => $fonts,
                                                            'default' => ''
                                                            ), 
                                'footer_title_font_weight' => array(
                                                            'label' => 'Footer Title Font Weight',
                                                            'type'  => 'select',
                                                            'choices' => array(
                                                                '100'=>'100 : Lighter',
                                                                '200'=>'200 : Light',
                                                                '300'=>'300 : Light',
                                                                '400'=>'400 : Normal',
                                                                '600'=>'600 : Bold',
                                                                '700'=>'700 : Bolder',
                                                                '800'=>'800 : Bolder'
                                                            ),
                                                            'default' => '400'
                                                            ),                            
            ),
    ),
);
?>
