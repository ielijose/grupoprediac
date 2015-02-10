<?php

/**
 * FILE: css.php 
 * Created on Mar 23, 2013 at 2:10:17 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */


function print_customizer_style(){
//header("Content-type: text/css; charset: UTF-8");
//theme_customizer =$_GET['customizer'];
//$theme_customizer = (array)json_decode( urldecode(stripslashes($str)));
$theme_customizer=get_option('viz_customizer');


echo '<style>';

$dom_array = array(
  'body_link_color'=> array(
                            'element' => 'body a,.nav-tabs > .active > a',
                            'css' => 'color'
                            ),  
  'logo_top'=> array(
                            'element' => 'h1#logo,.header_note',
                            'css' => 'margin-top'
                            ), 
  'logo_size'=> array(
                            'element' => '#logo img',
                            'css' => 'max-height'
                            ), 
  'header_top_bg_color'=> array(
                            'element' => '#header_top,.boxed #header_top .container',
                            'css' => 'background-color'
                            ), 
  'header_top_border_color'=> array(
                            'element' => '#header_top,.boxed #header_top .container,#header_top li a',
                            'css' => 'border-color'
                            ),   
  'header_top_color'=> array(
                            'element' => '#header_top,#header_top a,#search,
                                          .boxed #header_top .container',
                            'css' => 'color'
                            ),    
  'header_bg_color'=> array(
                            'element' => 'header,.boxed header .container,#search,
                                          header.fix.fixed,body.logged-in header.fix.fixed, 
                                          header.fix.fixed .container',
                            'css' => 'background-color'
                            ),  
  'header_top_font_size' =>  array(
                            'element' => '#header_top,#header_top a',
                            'css' => 'font-size'
                            ), 
  'header_bg_image'=> array(
                            'element' => 'header,header.fix.fixed',
                            'css' => 'background-image'
                            ), 
    
  'header_font'=> array(
                            'element' => 'header,header a',
                            'css' => 'font-family'
                            ),   
  'header_font_size'=> array(
                            'element' => 'header,header a,ul.headernet li .header_note',
                            'css' => 'font-size'
                            ), 
  'header_color'=> array(
                            'element' => 'header,header a,ul.headernet li .header_note',
                            'css' => 'color'
                            ),   
  'nav_bg_color' => array(
                            'element' => 'nav#nav_horizontal,#nav_horizontal.fixed,.boxed #nav_horizontal.fixed .container,nav li:hover > ul.sub-menu,#nav_horizontal li:hover .sub-menu a, 
                                        .boxed #nav_horizontal .container,#nav_horizontal .extras .login:hover > .woocom_loginform, 
                                        #nav_horizontal .extras .login:hover > .loggedin_menu, #searchicon:hover > #searchform',
                            'css' => 'background-color'
                            ), 
  'nav_border_color' => array(
                            'element' => '#nav_horizontal,#nav_horizontal li,#nav_horizontal .sub-menu li a:hover,.navsearch .icon-search,#nav_horizontal .sub-menu li .widget .inside,
                                         #nav_horizontal li:hover .sub-menu a,#nav_horizontal .extras li:hover .loggedin_menu li a,#search,#nav_horizontal .sub-menu li h4.widgettitle,
                                         .cart_title,#nav_horizontal .extras .cart_widget .cart_list li',
                            'css' => 'border-color'
                            ),   
  'nav_font' => array(
                            'element' => 'nav li.menu-item a,.extras .cart_title,.accordionnav,#nav_horizontal .sub-menu li h4.widgettitle',
                            'css' => 'font-family'
                            ),
  'nav_color'=> array(
                            'element' => '#nav_horizontal li.menu-item a,#nav_horizontal .sub-menu li a,.cart_title,#nav_horizontal .sub-menu li h4.widgettitle,#nav_horizontal .extras li a,
                                             #nav_horizontal li.current-menu-ancestor .sub-menu a,.navsearch .icon-search, 
                                             #nav_horizontal li.current-menu-item .sub-menu a, 
                                            #nav_horizontal li:hover .sub-menu a',
                            'css' => 'color'
                            ),
  'nav_size'=> array(
                            'element' => 'nav li.menu-item > a,#nav_horizontal .sub-menu li h4.widgettitle,.extras .cart_title',
                            'css' => 'font-size'
                            ),
   'nav_sub_text_size'  => array(
                            'element' => 'nav .sub-menu li.menu-item a,#nav_horizontal .extras li a,
                                #nav_horizontal .sub-menu li .widget a,#nav_horizontal .sub-menu li .widget',
                            'css' => 'font-size'
                            ),
   'nav_sub_font' => array(
                            'element' => 'nav .sub-menu li.menu-item a,#nav_horizontal .extras li a,
                                         #nav_horizontal .sub-menu li .widget a,#nav_horizontal .sub-menu li .widget',
                            'css' => 'font-family'
                            ), 
  'body_bg_color'=> array(
                            'element' => 'body,.boxed .container',
                            'css' => 'background-color'
                            ),  
  'body_bg_image'=> array(
                            'element' => 'body',
                            'css' => 'background-image'
                            ),  
  'body_bg_image_repeat'=> array(
                            'element' => 'body',
                            'css' => 'background-repeat'
                            ),  
  'body_text_font'=> array(
                            'element' => 'body',
                            'css' => 'font-family'
                            ), 
  'body_font_weight'=> array(
                            'element' => 'body',
                            'css' => 'font-weight'
                            ),   
  'body_text_color'=> array(
                            'element' => 'body',
                            'css' => 'color'
                            ),
  'body_text_size'=> array(
                            'element' => 'body',
                            'css' => 'font-size'
                            ),
  'body_elements_bg_color'=> array(
                            'element' => '.post_title .meta,.team_member,.sidebar .widget,.post_thumb > .carousel, .post_thumb > a > .fit_video, .post_thumb > .fit_video, .post_thumb > a > .fitaudio, .post_thumb > .fitaudio, .post_thumb > img, .post_thumb > a > img, .post_thumb > .videoWrapper, .post_featured > .carousel, .post_featured > .fit_video, .post_featured > .videoWrapper, .post_featured > .fitaudio, .post_featured > img,
                                            .block,.post_featured .meta,#contactpage .span4,.testimonial_author',
                            'css' => 'background-color'
                            ), 
  'body_border_color'=> array(
                            'element' => '.content article,.tab-content,.vibe_list li,.sidebar .widget li,.pagination,.plain .accordion-group,.tab-content,.woocommerce div.product .woocommerce-tabs ul.tabs li,.advanced_listing_search,.woocommerce #content div.product .woocommerce-tabs ul.tabs li,.woocommerce-page div.product .woocommerce-tabs ul.tabs li,.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li,.gallery a img,p.block_desc,.prev_next_links,.post_category,.tagcloud a,.post-categories a,blockquote,.post_author .author_image img,.comments,.boxed section.stripe .container,.boxed.block .block_content,
                                          .post_author,.comments_rss,#respond,.tab-content.light,.nav.nav-tabs ,.sidebar,.nav.nav-tabs li,.sidebar .widget ul li,.tags a,.meta .comments_meta,.nav.nav-tabs li.active,.comment-body,.comment-author img,.nav.nav-tabs li:hover:first-child, .nav.nav-tabs li:first-child,.social_links li a,.social_links li:last-child a,.boxed .stripe,
                                          .sidebar h4.widget_title,article .post_desc .more,.boxed header .container,.boxed section.subheader .container, .boxed header .container, .boxed header.fix.fixed .container, body.logged-in.boxed header.fix.fixed .container, .boxed section.main .container',
                            'css' => 'border-color'
                            ),
  'body_hover_color'=> array(
                            'element' => ' .vibe_filterable li,
                                          .pagination span, .pagination a,.tagcloud a,.tagged_as a, .posted_in a, .post-categories a, .tags a,
                                          a.btn.readmore,.categories a,#respond,
                                          .nav.nav-tabs li,.toparrow',
                            'css' => 'background-color'
                            ),  
  'main_bg_color'  => array(
                            'element' => 'section.main,section.stripe,.boxed section.main .container',
                            'css' => 'background-color'
                            ),
    
  'h1_font' => array(
                            'element' => 'h1',
                            'css' => 'font-family'
                            ),
  'h1_font_weight'=> array(
                            'element' => 'h1',
                            'css' => 'font-weight'
                            ),  
  'h1_color'=> array(
                            'element' => 'h1',
                            'css' => 'color'
                            ),
  'h1_size'=> array(
                            'element' => 'h1',
                            'css' => 'font-size'
                            ),
  'h2_font' => array(
                            'element' => 'h2',
                            'css' => 'font-family'
                            ),
  'h2_font_weight'=> array(
                            'element' => 'h2',
                            'css' => 'font-weight'
                            ),  
  'h2_color'=> array(
                            'element' => 'h2',
                            'css' => 'color'
                            ),
  'h2_size'=> array(
                            'element' => 'h2',
                            'css' => 'font-size'
                            ),
   'h3_font' => array(
                            'element' => 'h3',
                            'css' => 'font-family'
                            ),
  'h3_font_weight'=> array(
                            'element' => 'h3',
                            'css' => 'font-weight'
                            ),  
  'h3_color'=> array(
                            'element' => 'h3',
                            'css' => 'color'
                            ),
  'h3_size'=> array(
                            'element' => 'h3',
                            'css' => 'font-size'
                            ),
   'h4_font' => array(
                            'element' => 'h4',
                            'css' => 'font-family'
                            ),
   'h4_font_weight'=> array(
                            'element' => 'h4',
                            'css' => 'font-weight'
                            ), 
  'h4_color'=> array(
                            'element' => 'h4,h4.block_title a',
                            'css' => 'color'
                            ),
  'h4_size'=> array(
                            'element' => 'h4',
                            'css' => 'font-size'
                            ),
  'h5_font' => array(
                            'element' => 'h5',
                            'css' => 'font-family'
                            ),
  'h5_font_weight'=> array(
                            'element' => 'h5',
                            'css' => 'font-weight'
                            ),  
  'h5_color'=> array(
                            'element' => 'h5',
                            'css' => 'color'
                            ),
  'h5_size'=> array(
                            'element' => 'h5',
                            'css' => 'font-size'
                            ),
  'h6_font' => array(
                            'element' => 'h6',
                            'css' => 'font-family'
                            ),
  'h6_font_weight'=> array(
                            'element' => 'h6',
                            'css' => 'font-weight'
                            ),  
  'h6_color'=> array(
                            'element' => 'h6',
                            'css' => 'color'
                            ),
  'h6_size'=> array(
                            'element' => 'h6',
                            'css' => 'font-size'
                            ),
 
    'primary_color'  => array(
                            'element' => 'a:hover,',
                            'css' => 'primary'
                            ),
    'primary_text_color'  => array(
                            'element' => '#nav_horizontal li.current-menu-ancestor>a, 
                                          #nav_horizontal li.current-menu-item>a, 
                                          #nav_horizontal li a:hover, 
                                          #nav_horizontal li:hover a,
                                          nav li.menu-item a:hover,
                                          nav li.menu-item.current-menu-ancestor > a,
                                          .vibe_filterable li.active a,.tabbable .nav.nav-tabs li:hover a,
                                          .btn,a.btn.readmore:hover,
                                          footer .tagcloud a:hover,
                                          .pagination a:hover,
                                          .hover-link:hover,
                                          .pagination .current',
                            'css' => 'color'
                            ),
    'title_bg_color'=> array(
                            'element' => 'section.subheader,.boxed section.subheader .container',
                            'css' => 'background-color'
                            ),
    'title_bg_image'=> array(
                            'element' => 'section.subheader,.boxed section.subheader .container',
                            'css' => 'background-image'
                            ),
    'title_text_color'=> array(
                            'element' => '.subheader h1,.subheader h5,.subheader h5 a, .subheader ul.breadcrumbs, 
                                          .subheader .woocommerce-breadcrumb,
                                          ul.breadcrumbs li a',
                                          
                            'css' => 'color'
                            ),
    'blockquote_bg_color'=> array(
                            'element' => 'blockquote',
                            'css' => 'background-color'
                            ),
    'blockquote_text_color'=> array(
                            'element' => 'blockquote',
                            'css' => 'color'
                            ),
    
    'button_bg_color'=> array(
                            'element' => '.btn.primary,#submit,.button,.product .add_to_cart_button,.single_add_to_cart_button',
                            'css' => 'background-color'
                            ),
    'button_border_color'=> array(
                            'element' => '.btn.primary,#submit,.button,.product .add_to_cart_button,.single_add_to_cart_button',
                            'css' => 'border-color'
                            ),
    'button_text_color'=> array(
                            'element' => '.btn.primary,#submit,.button,.product .add_to_cart_button,.single_add_to_cart_button',
                            'css' => 'color'
                            ),
    'button_font'=> array(
                            'element' => '.btn.primary,#submit,.product .add_to_cart_button,.single_add_to_cart_button',
                            'css' => 'font-family'
                            ),
    'button_font_weight'=> array(
                            'element' => '.btn.primary,#submit,.product .add_to_cart_button,.single_add_to_cart_button',
                            'css' => 'font-weight'
                            ),    
    'button_text_size'=> array(
                            'element' => '.btn.primary,#submit,.product .add_to_cart_button,.single_add_to_cart_button',
                            'css' => 'font-size'
                            ),
    'heading_text_color'=> array(
                            'element' => 'h3.heading',
                            'css' => 'color'
                            ),
    'heading_font_weight'=> array(
                            'element' => 'h3.heading',
                            'css' => 'font-weight'
                            ),
    'testimonial_bg_color'=> array(
                            'element' => '.testimonial_item p',
                            'css' => 'background'
                            ),
    'testimonial_text_color'=> array(
                            'element' => '.testimonial_item p',
                            'css' => 'color'
                            ),
    'tooltip_text_color' => array(
                            'element' => '.tooltip-inner',
                            'css' => 'color'
                            ),
    'tooltip_bg_color' => array(
                            'element' => '.tooltip-inner',
                            'css' => 'background-color'
                            ),
    'formfield_bg_color'=> array(
                            'element' => '.form_field,.sidebar #s,input.form_field,.chzn-container-active .chzn-single,.chzn-container-active .chzn-single-with-drop,
                                          .chzn-container-active .chzn-choices,.chzn-container .chzn-drop,.chzn-container-single .chzn-single,
                                          .chzn-container-single .chzn-search input,.chzn-container-multi .chzn-choices',
                            'css' => 'background-color'
                            ),
    'formfield_border_color'=> array(
                            'element' => '.form_field,.sidebar #s,input.form_field,.chzn-container-active .chzn-single,.chzn-container-active .chzn-single-with-drop,
                                          .chzn-container-active .chzn-choices,.chzn-container .chzn-drop,.chzn-container-single .chzn-single,
                                          .chzn-container-single .chzn-search input,.chzn-container-multi .chzn-choices',
                            'css' => 'border-color'
                            ),
    'formfield_font_color'=> array(
                            'element' => '.form_field,.sidebar #s,input.form_field,.chzn-container-active .chzn-single,.chzn-container-active .chzn-single-with-drop,
                                          .chzn-container-active .chzn-choices,.chzn-container .chzn-drop,.chzn-container-single .chzn-single,
                                          .chzn-container-single .chzn-search input,.chzn-container-multi .chzn-choices',
                            'css' => 'color'
                            ),
    'formfield_font'=> array(
                            'element' => '.form_field,.sidebar #s,input.form_field,.chzn-container-active .chzn-single,.chzn-container-active .chzn-single-with-drop,
                                          .chzn-container-active .chzn-choices,.chzn-container .chzn-drop,.chzn-container-single .chzn-single,
                                          .chzn-container-single .chzn-search input,.chzn-container-multi .chzn-choices',
                            'css' => 'font-family'
                            ),
    'formfield_font_weight'=> array(
                            'element' => '.form_field,.sidebar #s,input.form_field,.chzn-container-active .chzn-single,.chzn-container-active .chzn-single-with-drop,
                                          .chzn-container-active .chzn-choices,.chzn-container .chzn-drop,.chzn-container-single .chzn-single,
                                          .chzn-container-single .chzn-search input,.chzn-container-multi .chzn-choices',
                            'css' => 'font-weight'
                            ),
    'formfield_font_size'=> array(
                            'element' => '.form_field,.sidebar #s,input.form_field,.chzn-container-active .chzn-single,.chzn-container-active .chzn-single-with-drop,
                                          .chzn-container-active .chzn-choices,.chzn-container .chzn-drop,.chzn-container-single .chzn-single,
                                          .chzn-container-single .chzn-search input,.chzn-container-multi .chzn-choices',
                            'css' => 'font-size'
                              ),  
    'footer_bg_color'=> array(
                            'element' => 'footer,footer .container,.boxed footer .container',
                            'css' => 'background-color'
                            ),
    'footer_bg_image'=> array(
                            'element' => 'footer, .boxed footer .container',
                            'css' => 'background-image'
                            ),
                            
     'footer_border_color'=> array(
                            'element' => 'footer #footer_bottom,footer #footer_bottom .container,footer .tagcloud a,
                                         .boxed #footer_bottom .container,footer .testimonial_item p, 
                                         footer .twitter_item p,footer .widget_carousel .flex-control-nav.flex-control-paging li a,
                                         footer textarea,.boxed #footer_bottom .container,
                                        footer input[type="text"], .nav.nav-tabs.dark li,
                                      footer input[type="password"], 
                                      footer input[type="datetime"], 
                                      footer input[type="datetime-local"], 
                                      footer input[type="date"], 
                                      footer input[type="month"], 
                                      footer input[type="time"], 
                                      footer input[type="week"], 
                                      footer input[type="number"], 
                                      footer input[type="email"], 
                                      footer input[type="url"], 
                                      footer input[type="search"], 
                                      footer input[type="tel"]',
                            'css' => 'background-color'
                            ),
    
    'footer_text_color'=> array(
                            'element' => 'footer,footer .twitter_item p,.tabbable .nav-tabs.dark > li > a, footer .twitter_item,',
                            'css' => 'color'
                            ),
    'footer_text_size'=> array(
                            'element' => 'footer',
                            'css' => 'font-size'
                            ),
    'footer_link_color'=> array(
                            'element' => 'footer a,#footer_bottom a,footer .widget a,footer .testimonial_item p, footer .twitter_item p',
                            'css' => 'color'
                            ),
    'footer_text_font'=> array(
                            'element' => 'footer',
                            'css' => 'font-family'
                            ),
    'footer_text_font_weight'=> array(
                            'element' => 'footer',
                            'css' => 'font-weight'
                            ),
    'footer_title_text_color'=> array(
                            'element' => 'footer .widget_title,footer h2,footer h3,footer h4,footer h5,footer h6,
                            footer .twitter_item p',
                            'css' => 'color'
                            ),
    'footer_title_text_size'=> array(
                            'element' => 'footer .widget_title',
                            'css' => 'font-size'
                            ),
    'footer_title_font'=> array(
                            'element' => 'footer .widget_title',
                            'css' => 'font-family'
                            ),
    'footer_title_font_weight'=> array(
                            'element' => 'footer .widget_title',
                            'css' => 'font-weight'
                            )
    
);


foreach($dom_array as $style => $value){
    if(isset($theme_customizer[$style]) && $theme_customizer[$style] !=''){
        switch($value['css']){
            case 'max-height':
            case 'font-size':
                echo $value['element'].'{'.$value['css'].':'.$theme_customizer[$style].'px;}';
                break;
            case 'background-image':
                echo $value['element'].'{'.$value['css'].':url('.$theme_customizer[$style].');}';
                break;
             case 'margin-top':
                echo $value['element'].'{'.$value['css'].':'.$theme_customizer[$style].'px;}';
                break;
            case 'padding-left-right':
                echo $value['element'].'{
                            padding-left:'.$theme_customizer[$style].'px;
                            padding-right:'.$theme_customizer[$style].'px;
                        }';
                break;
            case 'padding-top-bottom':
                echo $value['element'].'{
                            padding-top:'.$theme_customizer[$style].'px;
                            padding-bottom:'.$theme_customizer[$style].'px;
                    }';
                break;
            case 'box-shadow':
                echo $value['element'].'{
                            box-shadow:0 1px 3px '.$theme_customizer[$style].';
                            -moz-box-shadow: 0 1px 3px '.$theme_customizer[$style].';
                            -webkit-box-shadow: 0 1px 3px '.$theme_customizer[$style].';    
                    }';
                break;
             case 'primary':
                echo 'a:hover,.hover-link,.plain a.accordion-toggle:hover,a.primary,
                      .vibe_carousel .flex-direction-nav .flex-prev:hover,.vibeposts article span.price,
                        .vibe_carousel .flex-direction-nav .flex-next:hover,
                        .widget_carousel .flex-direction-nav .flex-prev:hover,
                        .widget_carousel .flex-direction-nav .flex-next:hover,
                        #ajax-login-content-tab a,
                        h4.agent_name span{
                            color:'.$theme_customizer[$style].'; 
                      }
                    
                    header,.boxed header .container,nav li:hover > ul.sub-menu,
                    #nav_horizontal .extras .login:hover > .woocom_loginform,
                    #nav_horizontal .extras .login:hover > .loggedin_menu,
                    #searchicon:hover > #searchform
                    .boxed header .container,.cart_widget,#searchicon:hover > #searchform,
                    .nav.nav-tabs li.active,header,
                    .nav.nav-tabs li:hover{
                    border-top-color:'.$theme_customizer[$style].';
                    }
                    
                    
                    .vertical .nav.nav-tabs li:hover,
                    .vertical .nav.nav-tabs li.active,
                    .tabbable.tabs-left .nav.nav-tabs li:hover,
                    .tabbable.tabs-left .nav.nav-tabs li.active{
                        border-left-color:'.$theme_customizer[$style].';
                        }
                    
                    .tabbable.tabs-right .nav.nav-tabs li:hover,
                    .tabbable.tabs-right .nav.nav-tabs li.active,
                    .sidebar.sidebar-left .widget li:hover{
                        border-right-color:'.$theme_customizer[$style].';
                        }
                        
                        ::selection,
                         ::-moz-selection{
                                background-color:'.$theme_customizer[$style].';
                          }
                          #searchsubmit,.hover .block_content, .btn,.btn:visited,.btn:focus,.social_links li a:hover,#today,
                          nav li.current-menu-item a,nav li.menu-item a:hover, 
                         .carousel-control:hover,footer .tagcloud a:hover,.vibe_filterable li.active a,.vibe_filterable li a:hover
                        .tagged_as a:hover,.post-categories a:hover,.btn.primary,.button.primary,#submit,
                         .plain .accordion-toggle i, nav li.menu-item.current-menu-ancestor > a,  
                         .plain .accordion-toggle.collapsed i,.block_media span.overlay,
                         .dark .accordion-toggle i,#nav_horizontal .extras .cart_widget .buttons .button,
                         .dark .accordion-toggle.collapsed i,.price_slider .ui-slider-range,.ui-slider .ui-slider-handle,
                         .plain .accordion-toggle.collapsed i,.header_top.show,.boxed .header_top.show .container,
                         .vibe_carousel .flex-control-nav.flex-control-paging li a:hover,
                         .vibe_carousel .flex-control-nav.flex-control-paging li a.flex-active,
                         .vibe_carousel .flex-direction-nav a.flex-prev:hover, .vibe_carousel .flex-direction-nav a.flex-next:hover,
                         input[type="button"]:hover,.accordionnav a.show_nav:hover,.accordionnav ul.collapsed_accordion,.toparrow:hover,
                         #ajax-login-content-tab input[type="submit"], #ajax-login-user a, #ajax-recaptcha-container a,
                         .listing_features_tab li.fieldon a:hover, .main_features li.fieldon a:hover, .listing_fields li.fieldon a:hover {
                             background-color:'.$theme_customizer[$style].';
                         }
                            #nav_horizontal li.current-menu-ancestor>a, #nav_horizontal li.current-menu-item>a, 
                            #nav_horizontal li a:hover, #nav_horizontal li:hover a,h3.heading span,
                             .vibe_filterable li.active a,.vibe_filterable li a:hover,h3.heading span,
                             header.always,body.boxed header.always .container,nav li.current-menu-item:hover a,
                            .instagram a img:hover, .gallery a img:hover,
                            .featurebox3:after,
                            .featurebox2:after,.tagcloud a:hover,
                            .listing_features_tab li.fieldon a:hover, .main_features li.fieldon a:hover, .listing_fields li.fieldon a:hover{
                                border-color:'.$theme_customizer[$style].';
                            }
                            
                          #nav_horizontal li.current-menu-ancestor>a, 
                          #nav_horizontal li.current-menu-item>a,
                          #nav_horizontal li a:hover, 
                          #nav_horizontal li:hover a,  
                          #nav_horizontal .sub-menu .widget .nav.nav-tabs li.active a, 
                          #nav_horizontal .sub-menu .widget .nav.nav-tabs li:hover a,
                          .chzn-container .chzn-results .highlighted,
                          .sidebar .widget .nav.nav-tabs li:hover,
                          #scrollmenu li a:hover, #scrollmenu li a.active,
                          .pagination a:hover,
                          .inpage_menu,
                          section.subheader,
                          .vibe_listing_description p.price, 
                          .widget .widget_carousel span.price, 
                          .listing_fields li.price,
                          .nav.nav-tabs li.active a,
                          .nav.nav-tabs li.active,
                          .nav.nav-tabs li.active:hover,
                          .pagination .current,
                          .tagcloud a:hover,
                          .currency_conversion li a.active,
                          .tabbable.tabs-left .nav.nav-tabs li:hover,
                          .widget_carousel .flex-control-nav.flex-control-paging li a:hover,
                          .widget_carousel .flex-control-nav.flex-control-paging li a.flex-active,
                          .featurebox1:hover:after,
                          .featurebox1:hover>i,
                          .nav.nav-tabs li:hover, 
                          .nav.nav-tabs li.active,
                            .featurebox2:hover>i,
                            .featurebox3:hover>i,
                            .featurebox4:hover>i,
                            .featurebox5:hover>i{
                            background: '.$theme_customizer[$style].';
                            }
                            .header_sidebar_hook{
                            border-color: transparent '.$theme_customizer[$style].' transparent transparent;
                            }';
                break;
            default:
                echo $value['element'].'{'.$value['css'].':'.$theme_customizer[$style].';}';
                break;
        }
                                         #
    }
    
}    



        //Exceptions:

        if(isset($theme_customizer['footer_border_color'])){
            echo 'footer, footer.container,footer .widget .quick-flickr-item img,footer .widget .instagram li img,
                  .boxed footer .container,.dark .accordion-group,
                  footer textarea, footer .gallery a img,.widget_carousel li,
                  footer input[type="text"], .boxed footer .container,.boxed #footer_bottom .container,
                   footer input[type="password"],.tab-content.dark ,
                   footer input[type="datetime"], 
                   footer input[type="datetime-local"], 
                   footer input[type="date"], 
                   footer input[type="month"], 
                   footer input[type="time"], 
                   footer input[type="week"], 
                   footer input[type="number"], 
                   footer input[type="email"], 
                   footer input[type="url"], 
                   footer input[type="search"], 
                   footer input[type="tel"]  {
                            border-color: '.$theme_customizer['footer_border_color'].';
                      }';
        }
        
        if(isset($theme_customizer['nav_border_color'])){
            echo 'nav li:hover > ul.sub-menu{
                border-bottom-color:'.$theme_customizer['nav_border_color'].';
                    border-left-color:'.$theme_customizer['nav_border_color'].';
                        border-right-color:'.$theme_customizer['nav_border_color'].';
                }
                #nav_horizontal li:hover .sub-menu a:hover,
                #nav_horizontal .extras li:hover .loggedin_menu li a:hover{
                        background:'.$theme_customizer['nav_border_color'].';
                    }';
        }
        if(isset($theme_customizer['primary_color'])){
        echo '.block_media span.vfeatured:after, .widget .widget_carousel .post_thumb span.vfeatured:after{
          border-color:'.$theme_customizer['primary_color'].' '.$theme_customizer['primary_color'].' transparent transparent;
        }';
      }
        if(isset($theme_customizer['footer_border_color'])){
        echo 'footer .testimonial_item p:after, footer .twitter_item p:after{
               border-color: '.$theme_customizer['footer_border_color'].' transparent transparent '.$theme_customizer['footer_border_color'].';
            }';
        }
        
echo '</style>';
}
?>