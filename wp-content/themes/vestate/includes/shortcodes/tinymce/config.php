<?php

$testimonials=$popups=$listings=$agents=array();
$args=array(
  'post_type' => 'testimonials',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'ignore_sticky_posts'=> 1
);

$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
  while ($my_query->have_posts()) : $my_query->the_post(); 
   $testimonials[get_the_ID()] = get_the_title();
  endwhile;
}
wp_reset_query();  // Restore global post data stomped by the_post().



$args=array(
  'post_type' => 'listing',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'ignore_sticky_posts'=> 1
);

$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
  while ($my_query->have_posts()) : $my_query->the_post(); 
   $listings[get_the_ID()] = get_the_title();
  endwhile;
}
wp_reset_query();  // Restore global post data stomped by the_post().


$args=array(
  'post_type' => 'agent',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'ignore_sticky_posts'=> 1
);

$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
  while ($my_query->have_posts()) : $my_query->the_post(); 
   $agents[get_the_ID()] = get_the_title();
  endwhile;
}
wp_reset_query();  // Restore global post data stomped by the_post().


$args=array(
  'post_type' => 'popups',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'ignore_sticky_posts'=> 1
);

$my_query = null;
$my_query = new WP_Query($args);
if( $my_query->have_posts() ) {
  while ($my_query->have_posts()) : $my_query->the_post(); 
   $popups[get_the_ID()] = get_the_title();
  endwhile;
}
wp_reset_query();  // Restore global post data stomped by the_post().

/*-----------------------------------------------------------------------------------*/
/*	Accordion Config
/*-----------------------------------------------------------------------------------*/
$rand=rand(1,999);
$vibe_shortcodes['accordion'] = array(
    'params' => array(),
    'no_preview' => true,
    'params' => array(
                        'style' => array(
				'std' => 'default',
				'type' => 'select',
				'label' => __('Accordion Style', 'vibe'),
				'desc' => __('Select a Accordion style/theme', 'vibe'),
                                'options' => array(
					'' => 'Default',
					'plain' => 'Plain',
                                        'dark' => 'Dark'
				),
			),),
    'shortcode' => '[agroup style="{{style}}" id='.$rand.'] {{child_shortcode}}  [/agroup]',
    'popup_title' => __('Insert Accordion Shortcode', 'vibe'),
    'child_shortcode' => array(
        'params' => array(
                    'title' => array(
			'type' => 'text',
			'label' => __('Accordion Title', 'vibe'),
			'desc' => __('Add the title of the accordion', 'vibe'),
			'std' => 'Title'
		),
		'content' => array(
			'std' => 'Content',
			'type' => 'textarea',
			'label' => __('Accordion Content', 'vibe'),
			'desc' => __('Add the content. Accepts HTML & other Shortcodes.', 'vibe'),
		),
              ),
        'shortcode' => '[accordion title="{{title}}"  id='.$rand.'] {{content}} [/accordion]',
        'clone_button' => __('Add Accordion Toggle', 'vibe')
    )
);


/*-----------------------------------------------------------------------------------*/
/*	Button Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['button'] = array(
	'no_preview' => false,
	'params' => array(
		'url' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Link URL', 'vibe'),
			'desc' => __('Add the button\'s url eg http://www.example.com', 'vibe')
		),
                'class' => array(
			'std' => '',
			'type' => 'select_hide',
			'label' => __('Button Style', 'vibe'),
			'desc' => __('Select button style', 'vibe'),
                        'options' => array(
				'' => 'Base',
                                'other' => 'Custom',
			),
                        'level' => 7
		),
		'bg' => array(
			'type' => 'color',
			'label' => __('Background color', 'vibe'),
			'desc' => __('Select the button\'s background color', 'vibe')
		),
                'hover_bg' => array(
			'type' => 'color',
			'label' => __('Hover Bg color', 'vibe'),
			'desc' => __('Select the button\'s on hover background color ', 'vibe')
		),
                'color' => array(
			'type' => 'color',
			'label' => __('Text color', 'vibe'),
			'desc' => __('Select the button\'s text color', 'vibe')
		),
                'size' => array(
			'type' => 'slide',
			'label' => __('Font Size', 'vibe'),
                        'min' => 0,
                        'max' => 100,
                        'std' => 0,
		),
		'width' => array(
			'type' => 'slide',
			'label' => __('Width', 'vibe'),
                        'min' => 0,
                        'max' => 500,
                        'std' => 0,
		),
                'height' => array(
			'type' => 'slide',
			'label' => __('Height', 'vibe'),
                        'min' => 0,
                        'max' => 100,
                        'std' => 0,
		),
		'radius' => array(
			'type' => 'slide',
			'label' => __('Border Radius', 'vibe'),
                        'min' => 0,
                        'max' => 150,
                        'std' => 0
		),
		'target' => array(
			'type' => 'select',
			'label' => __('Button Target', 'vibe'),
			'desc' => __('_self = open in same window. _blank = open in new window', 'vibe'),
			'options' => array(
				'_self' => '_self',
				'_blank' => '_blank'
			)
		),
            'content' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Button Anchor', 'vibe'),
			'desc' => __('Replace button label with the text you enter.', 'vibe'),
		)
	),
	'shortcode' => '[button url="{{url}}" class="{{class}}" bg="{{bg}}" hover_bg="{{hover_bg}}" size="{{size}}" color="{{color}}" radius="{{radius}}" width="{{width}}"  height="{{height}}"  target="{{target}}"] {{content}} [/button]',
	'popup_title' => __('Insert Button Shortcode', 'vibe')
);


/*-----------------------------------------------------------------------------------*/
/*	Columns Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['columns'] = array(
	'params' => array(),
	'shortcode' => ' {{child_shortcode}} ', // as there is no wrapper shortcode
	'popup_title' => __('Insert Columns Shortcode', 'vibe'),
	'no_preview' => true,
	
	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'column' => array(
				'type' => 'select',
				'label' => __('Column Type', 'vibe'),
				'desc' => __('Select the type, ie width of the column.', 'vibe'),
				'options' => array(
                                        'one_fifth' => 'One Fifth',
                                        'one_fourth' => 'One Fourth',
					'one_third' => 'One Third',
                                        'two_fifth' => 'Two Fifth',
					'one_half' => 'One Half',
                                        'three_fifth' => 'Three Fifth',
                                        'two_third' => 'Two Thirds',
					'three_fourth' => 'Three Fourth',
                                        'four_fifth' => 'Four Fifth',
				)
			),
                        'first' => array(
				'type' => 'select',
				'label' => __('Column Type', 'vibe'),
				'desc' => __('Select the type, ie width of the column.', 'vibe'),
				'options' => array(
                                        '' => 'Default',
                                        'first' => 'First in Row (from Left)',
				)
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Column Content', 'vibe'),
				'desc' => __('Add the column content.', 'vibe'),
			)
		),
		'shortcode' => '[{{column}} first={{first}}] {{content}} [/{{column}}] ',
		'clone_button' => __('Add Column', 'vibe')
	)
);

/*-----------------------------------------------------------------------------------*/
/*	Icon Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['icons'] = array(
	'no_preview' => true,
	'params' => array(
		'icon' => array(
					'type' => 'icon',
					'label' => __('Icon type', 'vibe'),
					'desc' => __('Select Icon type', 'vibe'),
					
                 ),
                 'size' => array(
					'type' => 'slide',
					'label' => __('Icon Size', 'vibe'),
					'desc' => __('Icon Size', 'vibe'),
					'min' => 0,
                                        'max' => 100,
                                        'std' => 0,
                 ),
                 
                 'class' => array(
			'std' => '',
			'type' => 'select_hide',
			'label' => __('Custom Style', 'vibe'),
			'desc' => __('icon style', 'vibe'),
                        'options' => array(
				'' => 'Text Style',
                                'other' => 'Custom',
			),
                        'level' => 6
		),
                 'color' => array(
					'type' => 'color',
					'label' => __('Icon Color', 'vibe'),
					'desc' => __('Icon Color', 'vibe')
                 )
                 ,
                 'bg' => array(
					'type' => 'color',
					'label' => __('Icon Bg Color', 'vibe'),
					'desc' => __('Icon Background color', 'vibe'),
                 ),
                 'hovercolor' => array(
					'type' => 'color',
					'label' => __('Icon Hover Color', 'vibe'),
					'desc' => __('Icon Color', 'vibe'),
                 )
                 ,
                 'hoverbg' => array(
					'type' => 'color',
					'label' => __('Icon Hover Bg Color', 'vibe'),
					'desc' => __('Icon Background color', 'vibe'),
                 ),
                 'padding' => array(
					'type' => 'slide',
					'label' => __('Icon padding', 'vibe'),
					'desc' => __('Icon Background padding', 'vibe'),
					'min' => 0,
                                        'max' => 100,
                                        'std' => 0,
                 ),
                 'radius' => array(
					'type' => 'slide',
					'label' => __('Icon Bg Radius', 'vibe'),
					'desc' => __('Icon Background radius', 'vibe'),
					'min' => 0,
                                        'max' => 100,
                                        'std' => 0,
                 ),
                 
		
	),
	'shortcode' => '[icon icon="{{icon}}" size="{{size}}" color="{{color}}" bg="{{bg}}" hovercolor="{{hovercolor}}" hoverbg="{{hoverbg}}" padding="{{padding}}" radius="{{radius}}"]',
	'popup_title' => __('Insert Icon Shortcode', 'vibe')
);


/*-----------------------------------------------------------------------------------*/
/*	Alert Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['alert'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
			'type' => 'select_hide',
			'label' => __('Alert Style', 'vibe'),
			'desc' => __('Select the alert\'s style, ie the alert colour', 'vibe'),
			'options' => array(
				'block' => 'Orange',
				'info' => 'Blue',
				'error' => 'Red',
				'success' => 'Green',
                                'other' => 'Custom'
			),
                        'level' => 3
		),
            'bg' => array(
					'type' => 'color',
					'label' => __('Alert Bg Color', 'vibe'),
					'desc' => __('Background color', 'vibe'),
                 ),
            'border' => array(
					'type' => 'color',
					'label' => __('Alert Border Color', 'vibe'),
					'desc' => __('Border color', 'vibe'),
                 ),
            'color' => array(
					'type' => 'color',
					'label' => __('Text Color', 'vibe'),
					'desc' => __('Alert Text color', 'vibe'),
                 ),
		'content' => array(
			'std' => 'Your Alert/Information Message!',
			'type' => 'textarea',
			'label' => __('Alert Text', 'vibe'),
			'desc' => __('Add the alert\'s text', 'vibe'),
		)
		
	),
	'shortcode' => '[alert style="{{style}}" bg="{{bg}}" border="{{border}}" color="{{color}}"] {{content}} [/alert]',
	'popup_title' => __('Insert Alert Shortcode', 'vibe')
);

/*-----------------------------------------------------------------------------------*/
/*	Tooltip Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['tooltip'] = array(
	'no_preview' => true,
	'params' => array(
                'direction' => array(
			'type' => 'select',
			'label' => __('Direction', 'vibe'),
			'desc' => __('Tooltip direction', 'vibe'),
			'options' => array(
				'top' => 'Above Content',
				'right' => 'Right of Content',
				'bottom' => 'Below Content',
				'left' => 'Left Of Content'
			)
		),
                'tip' => array(
			'std' => 'Tip content!',
			'type' => 'textarea',
			'label' => __('Tooltip Text', 'vibe'),
			'desc' => __('Add the Tooltip text', 'vibe'),
		),
		'content' => array(
			'std' => 'Tooltip',
			'type' => 'text',
			'label' => __('Tooltip Anchor', 'vibe'),
			'desc' => __('Add the Tooltip anchor', 'vibe'),
		),
                'url' => array(
			'std' => 'http://www.google.com',
			'type' => 'text',
			'label' => __('Tooltip URL', 'vibe'),
			'desc' => __('Add the Tooltip URL', 'vibe'),
		),
                'target' => array(
			'type' => 'select',
			'label' => __('Button Target', 'vibe'),
			'desc' => __('_self = open in same window. _blank = open in new window', 'vibe'),
			'options' => array(
				'_self' => '_self',
				'_blank' => '_blank'
			)
		)
		
	),
	'shortcode' => '[tooltip style="{{style}}" direction="{{direction}}" tip="{{tip}}" url="{{url}}" target="{{target}}"] {{content}} [/tooltip]',
	'popup_title' => __('Insert Tooltip Shortcode', 'vibe')
);




/*-----------------------------------------------------------------------------------*/
/*	Toggle Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['toggle'] = array(
	'no_preview' => true,
	'params' => array(
		'title' => array(
			'type' => 'text',
			'label' => __('Toggle Content Title', 'vibe'),
			'desc' => __('Add the title that will go above the toggle content', 'vibe'),
			'std' => 'Title'
		),
		'content' => array(
			'std' => 'Content',
			'type' => 'textarea',
			'label' => __('Toggle Content', 'vibe'),
			'desc' => __('Add the toggle content. Will accept HTML', 'vibe'),
		),
		'state' => array(
			'type' => 'select',
			'label' => __('Toggle State', 'vibe'),
			'desc' => __('Select the state of the toggle on page load', 'vibe'),
			'options' => array(
				'' => 'Open',
				'collapsed' => 'Closed'
			)
		),
		
	),
	'shortcode' => '[toggle title="{{title}}" state="{{state}}"] {{content}} [/toggle]',
	'popup_title' => __('Insert Toggle Content Shortcode', 'vibe')
);

/*-----------------------------------------------------------------------------------*/
/*	RoundProgressBar
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['roundprogress'] = array(
	'no_preview' => true,
	'params' => array(
		'percentage' => array(
			'type' => 'text',
			'label' => __('Percentage Cover', 'vibe'),
			'desc' => __('Only number eg:20', 'vibe'),
			'std' => '20'
		),
                'radius' => array(
			'std' => '200',
			'type' => 'text',
			'label' => __('Circle Diameter', 'vibe'),
			'desc' => __('In pixels eg: 100', 'vibe'),
		),
                'thickness' => array(
			'std' => '20',
			'type' => 'text',
			'label' => __('Circle Thickness', 'vibe'),
			'desc' => __('In percentage', 'vibe'),
		),
                 'color' => array(
					'type' => 'color',
					'label' => __('Progress  Text Color', 'vibe'),
					'desc' => __('Progress  Text color', 'vibe'),
                 ),
                 'bg_color' => array(
					'type' => 'color',
					'label' => __('Progress Circle Color', 'vibe'),
					'desc' => __('Progress Circle color', 'vibe'),
                 ),
		'content' => array(
			'std' => '20%',
			'type' => 'text',
			'label' => __('Some Content', 'vibe'),
			'desc' => __('like : 20% Skill, shortcodes/html allowed', 'vibe'),
		),
		
	),
	'shortcode' => '[roundprogress color="{{color}}" bg_color="{{bg_color}}" percentage="{{percentage}}" radius="{{radius}}" thickness="{{thickness}}"] {{content}} [/roundprogress]',
	'popup_title' => __('Insert Round Progress Shortcode', 'vibe')
);



/*-----------------------------------------------------------------------------------*/
/*	ProgressBar
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['progressbar'] = array(
	'no_preview' => true,
	'params' => array(
		'percentage' => array(
			'type' => 'text',
			'label' => __('Percentage Cover', 'vibe'),
			'desc' => __('Only number eg:20', 'vibe'),
			'std' => '20'
		),
		'content' => array(
			'std' => '20%',
			'type' => 'text',
			'label' => __('Some Content', 'vibe'),
			'desc' => __('like : 20% Skill, shortcodes/html allowed', 'vibe'),
		),
                'style' => array(
			'type' => 'select',
			'label' => __('Style', 'vibe'),
			'desc' => __('Select Bar Style', 'vibe'),
			'options' => array(
				'' => 'Simple',
				'progress-striped' => 'Striped',
				'progress-striped active' => 'Running Stripes',
			)
		),
		'color' => array(
			'type' => 'select_hide',
			'label' => __('Color', 'vibe'),
			'desc' => __('Select progressbar color', 'vibe'),
			'options' => array(
				'progress-info' => 'Blue',
				'progress-warning' => 'Orange',
				'progress-danger' => 'Red',
				'progress-success' => 'Green',
                                'other' => 'Custom',
			),
                        'level' => 2
		),
                'bg' => array(
					'type' => 'color',
					'label' => __('Stripe Bg Color', 'vibe'),
					'desc' => __('Stripe Background color', 'vibe'),
                 ),
                 'textcolor' => array(
					'type' => 'color',
					'label' => __('Text Color', 'vibe'),
					'desc' => __('Stripe Text color', 'vibe'),
                 )
		
	),
	'shortcode' => '[progressbar color="{{color}}" style="{{style}}" percentage="{{percentage}}" bg={{bg}} textcolor={{textcolor}}] {{content}} [/progressbar]',
	'popup_title' => __('Insert Progressbar Shortcode', 'vibe')
);


/*-----------------------------------------------------------------------------------*/
/*	Tabs Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['tabs'] = array(
    'params' => array(),
    'no_preview' => true,
    'params' => array(
            'style' => array(
                'std' => '',
                'type' => 'select',
                'label' => __('Tabs Style', 'vibe'),
                'desc' => __('select a style', 'vibe'),
                'options' => array(
                    '' => 'Top Horizontal',
                    'tabs-left' => 'Left Vertical',
                    'tabs-right' => 'Right Vertical'
                )
            ),
            'theme' => array(
                'std' => '',
                'type' => 'select',
                'label' => __('Tabs theme', 'vibe'),
                'desc' => __('select a theme', 'vibe'),
                'options' => array(
                    '' => 'Light',
                    'dark' => 'Dark'
                )
            ),
        ),
    'shortcode' => '[tabs style="{{style}}" theme={{theme}}] {{child_shortcode}}  [/tabs]',
    'popup_title' => __('Insert Tab Shortcode', 'vibe'),
    
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => 'Title',
                'type' => 'text',
                'label' => __('Tab Title', 'vibe'),
                'desc' => __('Title of the tab', 'vibe'),
            ),  
            'icon' => array(
            			'type' => 'icon',
            			'label' => __('Title Icon', 'vibe'),
            			'desc' => __('Select Icon type', 'vibe'),
            			),   
            'content' => array(
                'std' => 'Tab Content',
                'type' => 'textarea',
                'label' => __('Tab Content', 'vibe'),
                'desc' => __('Add the tabs content', 'vibe')
            )
        ),
        'shortcode' => '[tab title="{{title}}" icon="{{icon}}"] {{content}} [/tab]',
        'clone_button' => __('Add Tab', 'vibe')
    )
);


/*-----------------------------------------------------------------------------------*/
/*	Dropcap Config
/*-----------------------------------------------------------------------------------*/


$vibe_shortcodes['dropcaps'] = array(
	'no_preview' => true,
	'params' => array(
                'style' => array(
				'std' => 'default',
				'type' => 'select_hide',
				'label' => __('Dropcaps Style', 'vibe'),
				'desc' => __('Set dropcaps style', 'vibe'),
                                'options' => array(
					'' => 'Default Text Style',
					'other' => 'Custom'
				),
                                'level' => 2
			),
		'color' => array(
			'type' => 'color',
			'label' => __('Text color', 'vibe'),
			'desc' => __('Select the dropcaps text color', 'vibe'),
                        'std' => ''
		),
                'padding' => array(
			'type' => 'slide',
			'label' => __('Padding', 'vibe'),
                        'min' => 0,
                        'max' => 100,
                        'std' => 0,
		),
		 'size' => array(
			'type' => 'slide',
			'label' => __('Font Size', 'vibe'),
                        'min' => 0,
                        'max' => 100,
                        'std' => 16,
		),	
		'content' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Dropcaps', 'vibe'),
			'desc' => __('Dropcaps single letter', 'vibe'),
		)
		
	),
	'shortcode' => '[d padding="{{padding}}" color="{{color}}" size="{{size}}"] {{content}} [/d]',
	'popup_title' => __('Insert Dropcaps Shortcode', 'vibe')
);

/*-----------------------------------------------------------------------------------*/
/*	Note Config
/*-----------------------------------------------------------------------------------*/


$vibe_shortcodes['note'] = array(
	'no_preview' => true,
	'params' => array(
            
		'style' => array(
				'std' => 'default',
				'type' => 'select_hide',
				'label' => __('Background Color', 'vibe'),
				'desc' => __('Background color & theme of note', 'vibe'),
                                'options' => array(
					'' => 'Default',
					'blue' => 'Blue',
                                        'green' => 'Green',
                                    'white' => 'White',
                                    'orange' => 'Orange',
                                    'red' => 'Red',
                                    'other' => 'Custom'
				),
                                'level' => 4
			),
                'bg' => array(
                        'label' => 'Background Color',
                        'desc'  => 'Background color',
                        'type'  => 'color'
                ),
                'border' => array(
                        'label' => 'Border Color',
                        'desc'  => 'border color',
                        'type'  => 'color'
                ),
                'bordercolor' => array(
                        'label' => 'Note Border Color',
                        'desc'  => 'Double Border color inside note',
                        'type'  => 'color'
                ),
                'color' => array(
                        'label' => 'Text Color',
                        'desc'  => 'text color',
                        'type'  => 'color'
                ),
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Content', 'vibe'),
			'desc' => __('Note Content, supports HTML/Shortcodes', 'vibe'),
		)
		
	),
	'shortcode' => '[note style="{{style}}" bg="{{bg}}" border="{{border}}" bordercolor="{{bordercolor}}" color="{{color}}"] {{content}} [/note]',
	'popup_title' => __('Insert Note Shortcode', 'vibe')
);


/*-----------------------------------------------------------------------------------*/
/*	Tagline Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['tagline'] = array(
	'no_preview' => true,
	'params' => array(
		'style' => array(
			'type' => 'select_hide',
			'label' => __('Tagline Style', 'vibe'),
			'desc' => __('Select the Tagline style', 'vibe'),
			'options' => array(
				'boxed' => 'Boxed',
				'tagfullwidth' => 'Fullwidth',
                                'other' => 'Custom Boxed'
			),
                    'level' => 4
                    ),
                'bg' => array(
                        'label' => 'Background Color',
                        'desc'  => 'Background color',
                        'type'  => 'color'
                ),
                'border' => array(
                        'label' => 'Overall Border Color',
                        'desc'  => 'border color',
                        'type'  => 'color'
                ),
                'bordercolor' => array(
                        'label' => 'Left Border Color',
                        'desc'  => 'Default color : Theme Primary color',
                        'type'  => 'color'
                ),
                'color' => array(
                        'label' => 'Text Color',
                        'desc'  => 'Default color : Theme text color',
                        'type'  => 'color'
                ),
		'content' => array(
			'std' => 'Tagline Supports HTML',
			'type' => 'textarea',
			'label' => __('Tagline', 'vibe'),
			'desc' => __('Supports HTML content', 'vibe'),
		)
		
	),
	'shortcode' => '[tagline style="{{style}}" bg="{{bg}}" border="{{border}}" bordercolor="{{bordercolor}}" color="{{color}}"] {{content}} [/tagline]',
	'popup_title' => __('Insert Tagline Shortcode', 'vibe')
);



/*-----------------------------------------------------------------------------------*/
/*	Animated Menu
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['animated_menu'] = array(
    'params' => array(),
    'no_preview' => true,
    'params' => array(
                        'style' => array(
				'std' => 'default',
				'type' => 'select',
				'label' => __('Animated Menu Style', 'vibe'),
                   'options' => array(
					'default' => 'Default',
					'style1' => 'Style1',
                                        'style2' => 'Style2',
                                        'style3' => 'Style3',
                                        'style4' => 'Style4',
                                        'style5' => 'Style5',
                                        'style6' => 'Style6',
                                        'style7' => 'Style7',
				),
			),
			'size' => array(
				'std' => 'default',
				'type' => 'select',
				'label' => __('Animated Menu Size', 'vibe'),
			       'options' => array(
				'default' => 'Normal',
				'' => 'Normal (180px width)',
			        'smallmenu' => 'Small (120px width)',
			        'minimenu' => 'Mini (80px width)',
			        'bigmenu' => 'Big (230px width)'
				),
			),
			),
    'shortcode' => '[animated_menu style={{style}} size={{size}}] {{child_shortcode}}  [/animated_menu]',
    'popup_title' => __('Insert Animated Menu Item Shortcode', 'vibe'),
    'child_shortcode' => array(
        'params' => array(
            'url' => array(
			'std' => 'http://www.vibethemes.com',
			'type' => 'text',
			'label' => __('Link to URL', 'vibe'),
		),
                'icon' => array(
					'type' => 'icon',
					'label' => __('Icon', 'vibe'),
					
                 ),
           		
                'content' => array(
			'std' => 'Sample Heading',
			'type' => 'text',
			'label' => __('Content', 'vibe'),
		),
                'sub' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Sub Content', 'vibe'),
		)
        ),
        'shortcode' => '[menu_item url="{{url}}" icon="{{icon}}" sub="{{sub}}"] {{content}} [/menu_item]',
        'clone_button' => __('Add Item', 'vibe')
    )
);


               

/*-----------------------------------------------------------------------------------*/
/*	Popupss Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['popups'] = array(
	'no_preview' => true,
	'params' => array(
		
                    'id' => array(
                        'std' =>'',
			'type' => 'select',
			'label' => __('Select Popup', 'vibe'),
                        'options' => $popups
			),   
                    'classes' => array(
                                'type' => 'select',
                                'label' => __('Anchor Style', 'vibe'),
                                'options' => array(
				    'default' => 'Default',
		                    'btn' =>  'Button',
		                    'btn primary' =>  'Primary Button',
						)
                                    ),    
                    'content' => array(
                        'std' =>'',
			'type' => 'textarea',
			'label' => __('Popup/Modal Anchor', 'vibe'),
			'desc' => __('Supports HTML & Shortcodes', 'vibe')
			),
		    'auto' => array(
                        'std' =>'',
			'type' => 'select',
			'label' => __('Show Popup on Page-load', 'vibe'),
                        'options' => array(1 => 'Yes',0 => 'No')
			),
                    'width' => array(
                        'std' =>'500',
			'type' => 'text',
			'label' => __('Popup window width (in px)', 'vibe')
			),
                    'height' => array(
                        'std' =>'300',
			'type' => 'text',
			'label' => __('Popup window height (in px)', 'vibe')
			),   
                    'hide_extras' =>  array(
                        'type' => 'select',
                        'label' => __('Hide Share buttons', 'vibe'),
                        'options' => array(
				0 => __('No','vibe'),
		                1 =>  __('Yes','vibe'),
				)
                        ),     
	),
	'shortcode' => '[popups id="{{id}}" auto={{auto}} classes="{{classes}}" width={{width}} height={{height}} hide_extras={{hide_extras}}] {{content}} [/popups] ',
	'popup_title' => __('Insert Popup Shortcode', 'vibe')
);

/*-----------------------------------------------------------------------------------*/
/*	Testimonials Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['testimonial'] = array(
	'no_preview' => true,
	'params' => array(
                'id' => array(
                        'std' =>'',
			'type' => 'select',
			'label' => __('Select Testimonial', 'vibe'),
                        'options' => $testimonials
			),
                 'length' => array(
                        'std' =>'100',
			'type' => 'text',
			'label' => __('Number of Characters to show', 'vibe'),
                        'desc' => __('If number of characters entered above is less than Testimonial Post length, Read more link will appear', 'vibe'), 
			),
	),
	'shortcode' => '[testimonial id="{{id}}" length={{length}}]',
	'popup_title' => __('Insert Testimonial Shortcode', 'vibe')
);


/*-----------------------------------------------------------------------------------*/
/*	Agent Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['agent'] = array(
	'no_preview' => true,
	'params' => array(
                'id' => array(
                        'std' =>'',
			'type' => 'select',
			'label' => __('Select Agent', 'vibe'),
                        'options' => $agents
			),
	),
	'shortcode' => '[agent id="{{id}}"]',
	'popup_title' => __('Insert Agent Shortcode', 'vibe')
);


/*-----------------------------------------------------------------------------------*/
/*	Listing Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['listing'] = array(
	'no_preview' => true,
	'params' => array(
                'id' => array(
                        'std' =>'',
			'type' => 'select',
			'label' => __('Select Listing', 'vibe'),
                        'options' => $listings
			),
	),
	'shortcode' => '[listing id="{{id}}"]',
	'popup_title' => __('Insert Listing Shortcode', 'vibe')
);
/*-----------------------------------------------------------------------------------*/
/*	Authors Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['team_member'] = array(
	'no_preview' => true,
	'params' => array(
                'pic' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Member Image', 'vibe'),
			'desc' => __('Image url of team member', 'vibe'),
		),
		'name' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Member Name', 'vibe'),
			'desc' => __('Name of team member (HTML allowed)', 'vibe'),
		),
                'designation' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Designation', 'vibe'),
			'desc' => __('Designation of Team Member (HTML allowed)', 'vibe'),
		),
                'description' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('description', 'vibe'),
			'desc' => __('Description (HTML allowed)', 'vibe'),
		) ),
        'shortcode' => '[team_member pic=\'{{pic}}\' name="{{name}}" designation="{{designation}}" description="{{description}}"] {{child_shortcode}}  [/team_member]',
        'popup_title' => __('Insert Team Member Shortcode', 'vibe'),
        'child_shortcode' => array(
        'params' => array(
                'icon' => array(
					'type' => 'socialicon',
					'label' => __('Social Icon', 'vibe'),	
                    ),
            'url' => array(
			'std' => 'http://www.vibethemes.com',
			'type' => 'text',
			'label' => __('Icon Link', 'vibe'),
                    )
                ),
        'shortcode' => '[team_social url="{{url}}" icon="{{icon}}"]',
        'clone_button' => __('Add Social Information', 'vibe')
                )
            );

/*-----------------------------------------------------------------------------------*/
/*	Timer Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['timer'] = array(
	'no_preview' => true,
	'params' => array(
		'date' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('End Time', 'vibe'),
			'desc' => __('Your Timer End time Format= YYYY,MM,DD ', 'vibe'),
		)
		
	),
	'shortcode' => '[timer end="{{date}}"]',
	'popup_title' => __('Insert Timer Shortcode', 'vibe')
);

/*-----------------------------------------------------------------------------------*/
/*	Google Maps Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['maps'] = array(
	'no_preview' => true,
	'params' => array(
		'map' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('End Map Iframe code', 'vibe'),
			'desc' => __('Enter your map iframce code including iframe tags', 'vibe'),
		)
		
	),
	'shortcode' => '[map]{{map}}[/map]',
	'popup_title' => __('Insert Google Maps Shortcode', 'vibe')
);

/*-----------------------------------------------------------------------------------*/
/*	Gallery Config
/*-----------------------------------------------------------------------------------*/

                        
$vibe_shortcodes['gallery'] = array(
	'no_preview' => true,
	'params' => array(
                
		'size' => array(
		                'std' =>'',
			'type' => 'select',
			'label' => __('Select Thumb Size', 'vibe'),
			'desc' => __('Image size', 'vibe'),
			'options' => array(
			                        '' => 'Select Size',
			                        'normal' => 'Normal',
			                        'small' => 'Small',
			                        'micro' => 'Very Small',
			                        'large' => 'Large'
			            )
		),
		
                'ids' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Attachment Ids', 'vibe'),
			'desc' => __('Attachment Ids separated by comma', 'vibe'),
		)
		
	),
	'shortcode' => '[gallery size="{{size}}" ids="{{ids}}"]',
	'popup_title' => __('Insert Gallery Shortcode', 'vibe')
);

/*-----------------------------------------------------------------------------------*/
/*	Social Icons
/*-----------------------------------------------------------------------------------*/


$vibe_shortcodes['socialicons'] = array(
	'no_preview' => true,
	'params' => array(
		'icon' => array(
					'type' => 'socialicon',
					'label' => __('Social Icon', 'vibe'),
					'desc' => __('Select Elastic Social Icon, takes size/color of text it is inserted in:', 'vibe'),
				),	
				'size' => array(
					'std' => '32',
					'type' => 'text',
					'label' => __('Size in pixels', 'vibe'),
					'desc' => __('Enter Elastic font size in pixels ', 'vibe'),
				),
				),
				
				        'shortcode' => '[socialicon icon="{{icon}}" size="{{size}}"]',
				        'popup_title' => __('Insert Social Icon Shortcode', 'vibe')
			);
/*-----------------------------------------------------------------------------------*/
/*	Forms
/*-----------------------------------------------------------------------------------*/



$vibe_shortcodes['forms'] = array(
	'no_preview' => true,
	'params' => array(
                    'style' => array(
			'std' => 'Contact Style',
			'type' => 'select',
			'label' => __('Contact Form Style', 'vibe'),
			'desc' => __('Select Style', 'vibe'),
                        'options' => array(
                            '' => 'Light',
                            'dark' => 'Dark'
                        )
                    ),
		),
	'shortcode' => '[form style="{{style}}"] {{child_shortcode}}  [/form]',
    'popup_title' => __('Generate ContactForm Shortcode', 'vibe'),
    'child_shortcode' => array(
        'params' => array(
                    'placeholder' => array(
			'std' => 'Name',
			'type' => 'text',
			'label' => __('Label Text', 'vibe'),
			'desc' => __('Add the content. Accepts HTML & other Shortcodes.', 'vibe'),
                    ),
                    'type' => array(
			'type' => 'select',
			'label' => __('Form Element', 'vibe'),
			'desc' => __('select Form element type', 'vibe'),
			'options' => array(
                            'text' => 'Single Line Text Box (Text)',
                            'textarea' => 'Multi Line Text Box (TextArea)',
                            'select' => 'Select from Options (Select)',
                            'submit' => 'Submit Button'
                        )
                    ),
                    'options' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Enter Select Options', 'vibe'),
			'desc' => __('Comma seperated options.', 'vibe'),
                    ),
                    'validate' => array(
			'type' => 'select',
			'label' => __('Validation', 'vibe'),
			'desc' => __('select Form element type', 'vibe'),
			'options' => array(
                            '' => 'None',
                            'email' => 'Email',
                            'numeric' => 'Numeric',
                            'phone' => 'Phone Number'
                        )
                    ),
                    
              ),
        'shortcode' => '[form_element type="{{type}}" validate="{{validate}}" options="{{options}}" placeholder="{{placeholder}}"]',
        'clone_button' => __('Add Form Element', 'vibe')
    )
);	



$vibe_shortcodes['audio'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Enter Audio File Attachment IDs', 'vibe'),
			'desc' => __('Enter comma separated files[.mp3,.wav,.ogg]', 'vibe')
		)
		),
	'shortcode' => '[audio] {{content}} [/audio]',
	'popup_title' => __('Insert Audio Shortcode', 'vibe')
);


$vibe_shortcodes['video'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Enter Video Embed Code or Attachment Ids', 'vibe'),
			'desc' => __('Enter video iframe code or Video attachment Ids [.mp4,.ogv].', 'vibe')
                        )
		),
	'shortcode' => '[video] {{content}} [/video]',
	'popup_title' => __('Insert Video Shortcode', 'vibe')
);	



/*==== Heading =====*/
$vibe_shortcodes['heading'] = array(
	'no_preview' => true,
	'params' => array(
		'content' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Enter Heading', 'vibe'),
			'desc' => __('Enter heading.', 'vibe')
                    )
		),
	'shortcode' => '[heading] {{content}} [/heading]',
	'popup_title' => __('Insert Heading Shortcode', 'vibe')
);					


/*-----------------------------------------------------------------------------------*/
/*	List Config
/*-----------------------------------------------------------------------------------*/

$vibe_shortcodes['list'] = array(
    'params' => array(),
    'no_preview' => true,
    'params' => array(
                  'heading' => array(
			'std' => '',
			'type' => 'textarea',
			'label' => __('Enter List Heading', 'vibe'),
			'desc' => __('Enter List heading.', 'vibe')
                        ),
                    ),
    'shortcode' => '[list heading="{{heading}}"]{{child_shortcode}}[/list]',
    'popup_title' => __('Insert List Items', 'vibe'),
    'child_shortcode' => array(
        'params' => array(
                    
		'content' => array(
			'std' => 'List Item Content',
			'type' => 'textarea',
			'label' => __('List Item Content', 'vibe'),
			'desc' => __('Add the content. Accepts HTML & other Shortcodes.', 'vibe'),
		),
              ),
        'shortcode' => '[listitem] {{content}} [/listitem]',
        'clone_button' => __('Add List Item', 'vibe')
    )
);


?>