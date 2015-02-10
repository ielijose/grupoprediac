<?php

// load wordpress
require_once('get_wp.php');

class vibe_shortcodes
{
	var	$conf;
	var	$popup;
	var	$params;
	var	$shortcode;
	var $cparams;
	var $cshortcode;
	var $popup_title;
	var $no_preview;
	var $has_child;
	var	$output;
	var	$errors;

	// --------------------------------------------------------------------------

	function __construct( $popup )
	{
		if( file_exists( dirname(__FILE__) . '/config.php' ) )
		{
			$this->conf = dirname(__FILE__) . '/config.php';
			$this->popup = $popup;
			
			$this->formate_shortcode();
		}
		else
		{
			$this->append_error('Config file does not exist');
		}
	}
	
	// --------------------------------------------------------------------------
	
	function formate_shortcode()
	{
		// get config file
		require_once( $this->conf );
		
		if( isset( $vibe_shortcodes[$this->popup]['child_shortcode'] ) )
			$this->has_child = true;
		
		if( isset( $vibe_shortcodes ) && is_array( $vibe_shortcodes ) )
		{
			// get shortcode config stuff
			$this->params = $vibe_shortcodes[$this->popup]['params'];
			$this->shortcode = $vibe_shortcodes[$this->popup]['shortcode'];
			$this->popup_title = $vibe_shortcodes[$this->popup]['popup_title'];
			
			// adds stuff for js use			
			$this->append_output( "\n" . '<div id="_vibe_shortcode" class="hidden">' . $this->shortcode . '</div>' );
			$this->append_output( "\n" . '<div id="_vibe_popup" class="hidden">' . $this->popup . '</div>' );
			
			if( isset( $vibe_shortcodes[$this->popup]['no_preview'] ) && $vibe_shortcodes[$this->popup]['no_preview'] )
			{
				//$this->append_output( "\n" . '<div id="_vibe_preview" class="hidden">false</div>' );
				$this->no_preview = true;		
			}
			
			// filters and excutes params
			foreach( $this->params as $pkey => $param )
			{
				// prefix the fields names and ids with vibe_
				$pkey = 'vibe_' . $pkey;
				if(!isset($param['desc'])){$param['desc'] =''; }
				// popup form row start
				$row_start  = '<tbody>' . "\n";
				$row_start .= '<tr class="form-row">' . "\n";
				$row_start .= '<td class="label">' . $param['label'] . '</td>' . "\n";
				$row_start .= '<td class="field">' . "\n";
				
				// popup form row end
				$row_end	= '<span class="vibe-form-desc">' . $param['desc'] . '</span>' . "\n";
				$row_end   .= '</td>' . "\n";
				$row_end   .= '</tr>' . "\n";					
				$row_end   .= '</tbody>' . "\n";
				
				switch( $param['type'] )
				{
					case 'text' :
						
						// prepare
						$output  = $row_start;
						$output .= '<input type="text" class="vibe-form-text vibe-input" name="' . $pkey . '" id="' . $pkey . '" value="' . (isset($param['std'])?$param['std']:'') . '" />' . "\n";
						$output .= $row_end;
						
						// append
						$this->append_output( $output );
						
						break;
                                            
                                        case 'color' :
						
						// prepare
						$output  = $row_start;
						$output .= '<input type="text" class="vibe-form-text vibe-input popup-colorpicker" name="' . $pkey . '" id="' . $pkey . '" value="' . (isset($param['std'])?$param['std']:'') . '" />' . "\n";
						$output .= $row_end;
						
						// append
						$this->append_output( $output );
						
						break;   
					 case 'slide' :
						
						// prepare
						$output  = $row_start;
						$output .= '<input type="text" class="vibe-form-text vibe-input popup-slider" name="' . $pkey . '" id="' . $pkey . '" value="' . (isset($param['std'])?$param['std']:'') . '" />' . "\n";
						$output .= '<div class="slider-range" data-min="' . $param['min'] . '" data-max="' . $param['max'] . '" data-std="' . (isset($param['std'])?$param['std']:'') . '"></div>';
                                                $output .= $row_end;
						
						// append
						$this->append_output( $output );
						
						break;   
						 	 
					case 'textarea' :
						
						// prepare
						$output  = $row_start;
						$output .= '<textarea rows="10" cols="30" name="' . $pkey . '" id="' . $pkey . '" class="vibe-form-textarea vibe-input">' . (isset($param['std'])?$param['std']:'') . '</textarea>' . "\n";
						$output .= $row_end;
						
						// append
						$this->append_output( $output );
						
						break;
						
					case 'select' :
						
						// prepare
						$output  = $row_start;
						$output .= '<select name="' . $pkey . '" id="' . $pkey . '" class="vibe-form-select vibe-input">' . "\n";
						
						foreach( $param['options'] as $value => $option )
						{
							$output .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
						}
						
						$output .= '</select>' . "\n";
						$output .= $row_end;
						
						// append
						$this->append_output( $output );
						
						break;
					case 'select_hide' :
						
						// prepare
						$output  = $row_start;
						$output .= '<select name="' . $pkey . '" id="' . $pkey . '" class="vibe-form-select-hide vibe-input" rel-hide="'.$param['level'].'">' . "\n";
						
						foreach( $param['options'] as $value => $option )
						{
							$output .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
						}
						
						$output .= '</select>' . "\n";
						$output .= $row_end;
						
						// append
						$this->append_output( $output );
						
						break;	
					case 'checkbox' :
						
						// prepare
						$output  = $row_start;
						$output .= '<label for="' . $pkey . '" class="vibe-form-checkbox">' . "\n";
						$output .= '<input type="checkbox" class="vibe-input" name="' . $pkey . '" id="' . $pkey . '" ' . ( $param['std'] ? 'checked' : '' ) . ' />' . "\n";
						$output .= ' ' . $param['checkbox_text'] . '</label>' . "\n";
						$output .= $row_end;
						
						// append
						$this->append_output( $output );
						
						break; 
                                        case 'icon' :
                                                     $output  = $row_start;
                                                   $output .='<ul class="the-icons unstyled">
            <li title="Code: 0x21"><i class="icon-duckduckgo"></i> <span class="i-name">icon-duckduckgo</span><span class="i-code">0x21</span></li>
            <li title="Code: 0x22"><i class="icon-aim"></i> <span class="i-name">icon-aim</span><span class="i-code">0x22</span></li>
            <li title="Code: 0x23"><i class="icon-delicious"></i> <span class="i-name">icon-delicious</span><span class="i-code">0x23</span></li>
            <li title="Code: 0x24"><i class="icon-paypal"></i> <span class="i-name">icon-paypal</span><span class="i-code">0x24</span></li>
            <li title="Code: 0x25"><i class="icon-flattr"></i> <span class="i-name">icon-flattr</span><span class="i-code">0x25</span></li>
            <li title="Code: 0x26"><i class="icon-android"></i> <span class="i-name">icon-android</span><span class="i-code">0x26</span></li>
            <li title="Code: 0x27"><i class="icon-eventful"></i> <span class="i-name">icon-eventful</span><span class="i-code">0x27</span></li>
            <li title="Code: 0x2a"><i class="icon-smashmag"></i> <span class="i-name">icon-smashmag</span><span class="i-code">0x2a</span></li>
            <li title="Code: 0xe800"><i class="icon-gplus"></i> <span class="i-name">icon-gplus</span><span class="i-code">0xe800</span></li>
            <li title="Code: 0x2c"><i class="icon-wikipedia"></i> <span class="i-name">icon-wikipedia</span><span class="i-code">0x2c</span></li>
            <li title="Code: 0xe801"><i class="icon-lanyrd"></i> <span class="i-name">icon-lanyrd</span><span class="i-code">0xe801</span></li>
            <li title="Code: 0x2e"><i class="icon-calendar-1"></i> <span class="i-name">icon-calendar-1</span><span class="i-code">0x2e</span></li>
            <li title="Code: 0x2f"><i class="icon-stumbleupon"></i> <span class="i-name">icon-stumbleupon</span><span class="i-code">0x2f</span></li>
            <li title="Code: 0x30"><i class="icon-fivehundredpx"></i> <span class="i-name">icon-fivehundredpx</span><span class="i-code">0x30</span></li>
            <li title="Code: 0x31"><i class="icon-pinterest"></i> <span class="i-name">icon-pinterest</span><span class="i-code">0x31</span></li>
            <li title="Code: 0x32"><i class="icon-bitcoin"></i> <span class="i-name">icon-bitcoin</span><span class="i-code">0x32</span></li>
            <li title="Code: 0x33"><i class="icon-w3c"></i> <span class="i-name">icon-w3c</span><span class="i-code">0x33</span></li>
            <li title="Code: 0x34"><i class="icon-foursquare"></i> <span class="i-name">icon-foursquare</span><span class="i-code">0x34</span></li>
            <li title="Code: 0x35"><i class="icon-html5"></i> <span class="i-name">icon-html5</span><span class="i-code">0x35</span></li>
            <li title="Code: 0x36"><i class="icon-ie-1"></i> <span class="i-name">icon-ie-1</span><span class="i-code">0x36</span></li>
            <li title="Code: 0x37"><i class="icon-call"></i> <span class="i-name">icon-call</span><span class="i-code">0x37</span></li>
            <li title="Code: 0x38"><i class="icon-grooveshark"></i> <span class="i-name">icon-grooveshark</span><span class="i-code">0x38</span></li>
            <li title="Code: 0x39"><i class="icon-ninetyninedesigns"></i> <span class="i-name">icon-ninetyninedesigns</span><span class="i-code">0x39</span></li>
            <li title="Code: 0x3a"><i class="icon-forrst"></i> <span class="i-name">icon-forrst</span><span class="i-code">0x3a</span></li>
            <li title="Code: 0x3b"><i class="icon-digg"></i> <span class="i-name">icon-digg</span><span class="i-code">0x3b</span></li>
            <li title="Code: 0x3d"><i class="icon-spotify"></i> <span class="i-name">icon-spotify</span><span class="i-code">0x3d</span></li>
            <li title="Code: 0x3e"><i class="icon-reddit"></i> <span class="i-name">icon-reddit</span><span class="i-code">0x3e</span></li>
            <li title="Code: 0x3f"><i class="icon-guest"></i> <span class="i-name">icon-guest</span><span class="i-code">0x3f</span></li>
            <li title="Code: 0x40"><i class="icon-gowalla"></i> <span class="i-name">icon-gowalla</span><span class="i-code">0x40</span></li>
            <li title="Code: 0x41"><i class="icon-appstore"></i> <span class="i-name">icon-appstore</span><span class="i-code">0x41</span></li>
            <li title="Code: 0x42"><i class="icon-blogger"></i> <span class="i-name">icon-blogger</span><span class="i-code">0x42</span></li>
            <li title="Code: 0x43"><i class="icon-cc-1"></i> <span class="i-name">icon-cc-1</span><span class="i-code">0x43</span></li>
            <li title="Code: 0x44"><i class="icon-dribbble"></i> <span class="i-name">icon-dribbble</span><span class="i-code">0x44</span></li>
            <li title="Code: 0x45"><i class="icon-evernote"></i> <span class="i-name">icon-evernote</span><span class="i-code">0x45</span></li>
            <li title="Code: 0x46"><i class="icon-flickr"></i> <span class="i-name">icon-flickr</span><span class="i-code">0x46</span></li>
            <li title="Code: 0x47"><i class="icon-google"></i> <span class="i-name">icon-google</span><span class="i-code">0x47</span></li>
            <li title="Code: 0x48"><i class="icon-viadeo"></i> <span class="i-name">icon-viadeo</span><span class="i-code">0x48</span></li>
            <li title="Code: 0x49"><i class="icon-instapaper"></i> <span class="i-name">icon-instapaper</span><span class="i-code">0x49</span></li>
            <li title="Code: 0x4a"><i class="icon-weibo"></i> <span class="i-name">icon-weibo</span><span class="i-code">0x4a</span></li>
            <li title="Code: 0x4b"><i class="icon-klout"></i> <span class="i-name">icon-klout</span><span class="i-code">0x4b</span></li>
            <li title="Code: 0x4c"><i class="icon-linkedin"></i> <span class="i-name">icon-linkedin</span><span class="i-code">0x4c</span></li>
            <li title="Code: 0x4d"><i class="icon-meetup"></i> <span class="i-name">icon-meetup</span><span class="i-code">0x4d</span></li>
            <li title="Code: 0x4e"><i class="icon-vk"></i> <span class="i-name">icon-vk</span><span class="i-code">0x4e</span></li>
            <li title="Code: 0x50"><i class="icon-plancast"></i> <span class="i-name">icon-plancast</span><span class="i-code">0x50</span></li>
            <li title="Code: 0x51"><i class="icon-disqus"></i> <span class="i-name">icon-disqus</span><span class="i-code">0x51</span></li>
            <li title="Code: 0x52"><i class="icon-rss-1"></i> <span class="i-name">icon-rss-1</span><span class="i-code">0x52</span></li>
            <li title="Code: 0x53"><i class="icon-skype"></i> <span class="i-name">icon-skype</span><span class="i-code">0x53</span></li>
            <li title="Code: 0x54"><i class="icon-twitter"></i> <span class="i-name">icon-twitter</span><span class="i-code">0x54</span></li>
            <li title="Code: 0x55"><i class="icon-youtube"></i> <span class="i-name">icon-youtube</span><span class="i-code">0x55</span></li>
            <li title="Code: 0x56"><i class="icon-vimeo"></i> <span class="i-name">icon-vimeo</span><span class="i-code">0x56</span></li>
            <li title="Code: 0x57"><i class="icon-windows"></i> <span class="i-name">icon-windows</span><span class="i-code">0x57</span></li>
            <li title="Code: 0x58"><i class="icon-xing"></i> <span class="i-name">icon-xing</span><span class="i-code">0x58</span></li>
            <li title="Code: 0x59"><i class="icon-yahoo"></i> <span class="i-name">icon-yahoo</span><span class="i-code">0x59</span></li>
            <li title="Code: 0x5b"><i class="icon-chrome-1"></i> <span class="i-name">icon-chrome-1</span><span class="i-code">0x5b</span></li>
            <li title="Code: 0x5d"><i class="icon-email"></i> <span class="i-name">icon-email</span><span class="i-code">0x5d</span></li>
            <li title="Code: 0x5e"><i class="icon-macstore"></i> <span class="i-name">icon-macstore</span><span class="i-code">0x5e</span></li>
            <li title="Code: 0x5f"><i class="icon-myspace"></i> <span class="i-name">icon-myspace</span><span class="i-code">0x5f</span></li>
            <li title="Code: 0x60"><i class="icon-podcast"></i> <span class="i-name">icon-podcast</span><span class="i-code">0x60</span></li>
            <li title="Code: 0x61"><i class="icon-amazon"></i> <span class="i-name">icon-amazon</span><span class="i-code">0x61</span></li>
            <li title="Code: 0x62"><i class="icon-steam"></i> <span class="i-name">icon-steam</span><span class="i-code">0x62</span></li>
            <li title="Code: 0x63"><i class="icon-cloudapp"></i> <span class="i-name">icon-cloudapp</span><span class="i-code">0x63</span></li>
            <li title="Code: 0x64"><i class="icon-dropbox"></i> <span class="i-name">icon-dropbox</span><span class="i-code">0x64</span></li>
            <li title="Code: 0x65"><i class="icon-ebay"></i> <span class="i-name">icon-ebay</span><span class="i-code">0x65</span></li>
            <li title="Code: 0x66"><i class="icon-facebook"></i> <span class="i-name">icon-facebook</span><span class="i-code">0x66</span></li>
            <li title="Code: 0x67"><i class="icon-github"></i> <span class="i-name">icon-github</span><span class="i-code">0x67</span></li>
            <li title="Code: 0x68"><i class="icon-googleplay"></i> <span class="i-name">icon-googleplay</span><span class="i-code">0x68</span></li>
            <li title="Code: 0x69"><i class="icon-itunes"></i> <span class="i-name">icon-itunes</span><span class="i-code">0x69</span></li>
            <li title="Code: 0x6a"><i class="icon-plurk"></i> <span class="i-name">icon-plurk</span><span class="i-code">0x6a</span></li>
            <li title="Code: 0x6b"><i class="icon-songkick"></i> <span class="i-name">icon-songkick</span><span class="i-code">0x6b</span></li>
            <li title="Code: 0x6c"><i class="icon-lastfm"></i> <span class="i-name">icon-lastfm</span><span class="i-code">0x6c</span></li>
            <li title="Code: 0x6d"><i class="icon-gmail"></i> <span class="i-name">icon-gmail</span><span class="i-code">0x6d</span></li>
            <li title="Code: 0x6e"><i class="icon-pinboard"></i> <span class="i-name">icon-pinboard</span><span class="i-code">0x6e</span></li>
            <li title="Code: 0x6f"><i class="icon-openid"></i> <span class="i-name">icon-openid</span><span class="i-code">0x6f</span></li>
            <li title="Code: 0x71"><i class="icon-quora"></i> <span class="i-name">icon-quora</span><span class="i-code">0x71</span></li>
            <li title="Code: 0x73"><i class="icon-soundcloud"></i> <span class="i-name">icon-soundcloud</span><span class="i-code">0x73</span></li>
            <li title="Code: 0x74"><i class="icon-tumblr"></i> <span class="i-name">icon-tumblr</span><span class="i-code">0x74</span></li>
            <li title="Code: 0x76"><i class="icon-eventasaurus"></i> <span class="i-name">icon-eventasaurus</span><span class="i-code">0x76</span></li>
            <li title="Code: 0x77"><i class="icon-wordpress"></i> <span class="i-name">icon-wordpress</span><span class="i-code">0x77</span></li>
            <li title="Code: 0x79"><i class="icon-yelp"></i> <span class="i-name">icon-yelp</span><span class="i-code">0x79</span></li>
            <li title="Code: 0x7b"><i class="icon-intensedebate"></i> <span class="i-name">icon-intensedebate</span><span class="i-code">0x7b</span></li>
            <li title="Code: 0x7c"><i class="icon-eventbrite"></i> <span class="i-name">icon-eventbrite</span><span class="i-code">0x7c</span></li>
            <li title="Code: 0x7d"><i class="icon-scribd"></i> <span class="i-name">icon-scribd</span><span class="i-code">0x7d</span></li>
            <li title="Code: 0x7e"><i class="icon-posterous"></i> <span class="i-name">icon-posterous</span><span class="i-code">0x7e</span></li>
            <li title="Code: 0xa3"><i class="icon-stripe"></i> <span class="i-name">icon-stripe</span><span class="i-code">0xa3</span></li>
            <li title="Code: 0xc7"><i class="icon-opentable"></i> <span class="i-name">icon-opentable</span><span class="i-code">0xc7</span></li>
            <li title="Code: 0xc9"><i class="icon-cart"></i> <span class="i-name">icon-cart</span><span class="i-code">0xc9</span></li>
            <li title="Code: 0xd1"><i class="icon-print-1"></i> <span class="i-name">icon-print-1</span><span class="i-code">0xd1</span></li>
            <li title="Code: 0xd6"><i class="icon-angellist"></i> <span class="i-name">icon-angellist</span><span class="i-code">0xd6</span></li>
            <li title="Code: 0xdc"><i class="icon-instagram"></i> <span class="i-name">icon-instagram</span><span class="i-code">0xdc</span></li>
            <li title="Code: 0xe0"><i class="icon-dwolla"></i> <span class="i-name">icon-dwolla</span><span class="i-code">0xe0</span></li>
            <li title="Code: 0xe1"><i class="icon-appnet"></i> <span class="i-name">icon-appnet</span><span class="i-code">0xe1</span></li>
            <li title="Code: 0xe2"><i class="icon-statusnet"></i> <span class="i-name">icon-statusnet</span><span class="i-code">0xe2</span></li>
            <li title="Code: 0xe3"><i class="icon-acrobat"></i> <span class="i-name">icon-acrobat</span><span class="i-code">0xe3</span></li>
            <li title="Code: 0xe4"><i class="icon-drupal"></i> <span class="i-name">icon-drupal</span><span class="i-code">0xe4</span></li>
            <li title="Code: 0xe5"><i class="icon-buffer"></i> <span class="i-name">icon-buffer</span><span class="i-code">0xe5</span></li>
            <li title="Code: 0xe7"><i class="icon-pocket"></i> <span class="i-name">icon-pocket</span><span class="i-code">0xe7</span></li>
            <li title="Code: 0xe9"><i class="icon-bitbucket"></i> <span class="i-name">icon-bitbucket</span><span class="i-code">0xe9</span></li>
            <li title="Code: 0x2190"><i class="icon-left-thin"></i> <span class="i-name">icon-left-thin</span><span class="i-code">0x2190</span></li>
            <li title="Code: 0x2191"><i class="icon-up-thin"></i> <span class="i-name">icon-up-thin</span><span class="i-code">0x2191</span></li>
            <li title="Code: 0x2192"><i class="icon-right-thin"></i> <span class="i-name">icon-right-thin</span><span class="i-code">0x2192</span></li>
            <li title="Code: 0x2193"><i class="icon-down-thin"></i> <span class="i-name">icon-down-thin</span><span class="i-code">0x2193</span></li>
            <li title="Code: 0x21b0"><i class="icon-level-up"></i> <span class="i-name">icon-level-up</span><span class="i-code">0x21b0</span></li>
            <li title="Code: 0x21b3"><i class="icon-level-down"></i> <span class="i-name">icon-level-down</span><span class="i-code">0x21b3</span></li>
            <li title="Code: 0x21c6"><i class="icon-switch"></i> <span class="i-name">icon-switch</span><span class="i-code">0x21c6</span></li>
            <li title="Code: 0x221e"><i class="icon-infinity"></i> <span class="i-name">icon-infinity</span><span class="i-code">0x221e</span></li>
            <li title="Code: 0x2302"><i class="icon-home"></i> <span class="i-name">icon-home</span><span class="i-code">0x2302</span></li>
            <li title="Code: 0x2328"><i class="icon-keyboard"></i> <span class="i-name">icon-keyboard</span><span class="i-code">0x2328</span></li>
            <li title="Code: 0x232b"><i class="icon-erase"></i> <span class="i-name">icon-erase</span><span class="i-code">0x232b</span></li>
            <li title="Code: 0x23f3"><i class="icon-hourglass"></i> <span class="i-name">icon-hourglass</span><span class="i-code">0x23f3</span></li>
            <li title="Code: 0x25b8"><i class="icon-right-dir"></i> <span class="i-name">icon-right-dir</span><span class="i-code">0x25b8</span></li>
            <li title="Code: 0x25d1"><i class="icon-adjust"></i> <span class="i-name">icon-adjust</span><span class="i-code">0x25d1</span></li>
            <li title="Code: 0x2601"><i class="icon-cloud"></i> <span class="i-name">icon-cloud</span><span class="i-code">0x2601</span></li>
            <li title="Code: 0xe832"><i class="icon-cloud-1"></i> <span class="i-name">icon-cloud-1</span><span class="i-code">0xe832</span></li>
            <li title="Code: 0x2602"><i class="icon-umbrella"></i> <span class="i-name">icon-umbrella</span><span class="i-code">0x2602</span></li>
            <li title="Code: 0x2605"><i class="icon-star"></i> <span class="i-name">icon-star</span><span class="i-code">0x2605</span></li>
            <li title="Code: 0x2606"><i class="icon-star-empty"></i> <span class="i-name">icon-star-empty</span><span class="i-code">0x2606</span></li>
            <li title="Code: 0x2611"><i class="icon-check-1"></i> <span class="i-name">icon-check-1</span><span class="i-code">0x2611</span></li>
            <li title="Code: 0x2615"><i class="icon-cup"></i> <span class="i-name">icon-cup</span><span class="i-code">0x2615</span></li>
            <li title="Code: 0x2630"><i class="icon-menu"></i> <span class="i-name">icon-menu</span><span class="i-code">0x2630</span></li>
            <li title="Code: 0x263d"><i class="icon-moon"></i> <span class="i-name">icon-moon</span><span class="i-code">0x263d</span></li>
            <li title="Code: 0x2661"><i class="icon-heart-empty"></i> <span class="i-name">icon-heart-empty</span><span class="i-code">0x2661</span></li>
            <li title="Code: 0x2665"><i class="icon-heart"></i> <span class="i-name">icon-heart</span><span class="i-code">0x2665</span></li>
            <li title="Code: 0x266a"><i class="icon-note"></i> <span class="i-name">icon-note</span><span class="i-code">0x266a</span></li>
            <li title="Code: 0x266b"><i class="icon-note-beamed"></i> <span class="i-name">icon-note-beamed</span><span class="i-code">0x266b</span></li>
            <li title="Code: 0x268f"><i class="icon-layout"></i> <span class="i-name">icon-layout</span><span class="i-code">0x268f</span></li>
            <li title="Code: 0x2691"><i class="icon-flag"></i> <span class="i-name">icon-flag</span><span class="i-code">0x2691</span></li>
            <li title="Code: 0x2692"><i class="icon-tools"></i> <span class="i-name">icon-tools</span><span class="i-code">0x2692</span></li>
            <li title="Code: 0x2699"><i class="icon-cog"></i> <span class="i-name">icon-cog</span><span class="i-code">0x2699</span></li>
            <li title="Code: 0xe86a"><i class="icon-cog-1"></i> <span class="i-name">icon-cog-1</span><span class="i-code">0xe86a</span></li>
            <li title="Code: 0x26a0"><i class="icon-attention"></i> <span class="i-name">icon-attention</span><span class="i-code">0x26a0</span></li>
            <li title="Code: 0xe864"><i class="icon-attention-1"></i> <span class="i-name">icon-attention-1</span><span class="i-code">0xe864</span></li>
            <li title="Code: 0x26a1"><i class="icon-flash"></i> <span class="i-name">icon-flash</span><span class="i-code">0x26a1</span></li>
            <li title="Code: 0xe81b"><i class="icon-flash-1"></i> <span class="i-name">icon-flash-1</span><span class="i-code">0xe81b</span></li>
            <li title="Code: 0x26c8"><i class="icon-cloud-thunder"></i> <span class="i-name">icon-cloud-thunder</span><span class="i-code">0x26c8</span></li>
            <li title="Code: 0x26ef"><i class="icon-cog-alt"></i> <span class="i-name">icon-cog-alt</span><span class="i-code">0x26ef</span></li>
            <li title="Code: 0x2702"><i class="icon-scissors"></i> <span class="i-name">icon-scissors</span><span class="i-code">0x2702</span></li>
            <li title="Code: 0x2707"><i class="icon-tape"></i> <span class="i-name">icon-tape</span><span class="i-code">0x2707</span></li>
            <li title="Code: 0x2708"><i class="icon-flight"></i> <span class="i-name">icon-flight</span><span class="i-code">0x2708</span></li>
            <li title="Code: 0xe81c"><i class="icon-flight-1"></i> <span class="i-name">icon-flight-1</span><span class="i-code">0xe81c</span></li>
            <li title="Code: 0x2709"><i class="icon-mail"></i> <span class="i-name">icon-mail</span><span class="i-code">0x2709</span></li>
            <li title="Code: 0xe877"><i class="icon-mail-2"></i> <span class="i-name">icon-mail-2</span><span class="i-code">0xe877</span></li>
            <li title="Code: 0x270e"><i class="icon-pencil"></i> <span class="i-name">icon-pencil</span><span class="i-code">0x270e</span></li>
            <li title="Code: 0x2712"><i class="icon-feather"></i> <span class="i-name">icon-feather</span><span class="i-code">0x2712</span></li>
            <li title="Code: 0x2713"><i class="icon-check"></i> <span class="i-name">icon-check</span><span class="i-code">0x2713</span></li>
            <li title="Code: 0xe879"><i class="icon-ok-1"></i> <span class="i-name">icon-ok-1</span><span class="i-code">0xe879</span></li>
            <li title="Code: 0x2715"><i class="icon-cancel"></i> <span class="i-name">icon-cancel</span><span class="i-code">0x2715</span></li>
            <li title="Code: 0xe87a"><i class="icon-cancel-2"></i> <span class="i-name">icon-cancel-2</span><span class="i-code">0xe87a</span></li>
            <li title="Code: 0x2731"><i class="icon-asterisk"></i> <span class="i-name">icon-asterisk</span><span class="i-code">0x2731</span></li>
            <li title="Code: 0x2757"><i class="icon-attention-circle"></i> <span class="i-name">icon-attention-circle</span><span class="i-code">0x2757</span></li>
            <li title="Code: 0x27a1"><i class="icon-right"></i> <span class="i-name">icon-right</span><span class="i-code">0x27a1</span></li>
            <li title="Code: 0x27a2"><i class="icon-direction"></i> <span class="i-name">icon-direction</span><span class="i-code">0x27a2</span></li>
            <li title="Code: 0x27f2"><i class="icon-ccw"></i> <span class="i-name">icon-ccw</span><span class="i-code">0x27f2</span></li>
            <li title="Code: 0x27f3"><i class="icon-cw"></i> <span class="i-name">icon-cw</span><span class="i-code">0x27f3</span></li>
            <li title="Code: 0x2b05"><i class="icon-left"></i> <span class="i-name">icon-left</span><span class="i-code">0x2b05</span></li>
            <li title="Code: 0x2b06"><i class="icon-up"></i> <span class="i-name">icon-up</span><span class="i-code">0x2b06</span></li>
            <li title="Code: 0x2b07"><i class="icon-down"></i> <span class="i-name">icon-down</span><span class="i-code">0x2b07</span></li>
            <li title="Code: 0xe003"><i class="icon-list-add"></i> <span class="i-name">icon-list-add</span><span class="i-code">0xe003</span></li>
            <li title="Code: 0xe005"><i class="icon-list"></i> <span class="i-name">icon-list</span><span class="i-code">0xe005</span></li>
            <li title="Code: 0xe071"><i class="icon-off-1"></i> <span class="i-name">icon-off-1</span><span class="i-code">0xe071</span></li>
            <li title="Code: 0xe700"><i class="icon-user-add"></i> <span class="i-name">icon-user-add</span><span class="i-code">0xe700</span></li>
            <li title="Code: 0xe704"><i class="icon-help-circled"></i> <span class="i-name">icon-help-circled</span><span class="i-code">0xe704</span></li>
            <li title="Code: 0xe705"><i class="icon-info-circled"></i> <span class="i-name">icon-info-circled</span><span class="i-code">0xe705</span></li>
            <li title="Code: 0xe876"><i class="icon-eye-2"></i> <span class="i-name">icon-eye-2</span><span class="i-code">0xe876</span></li>
            <li title="Code: 0xe70c"><i class="icon-tag"></i> <span class="i-name">icon-tag</span><span class="i-code">0xe70c</span></li>
            <li title="Code: 0xe803"><i class="icon-tag-1"></i> <span class="i-name">icon-tag-1</span><span class="i-code">0xe803</span></li>
            <li title="Code: 0xe711"><i class="icon-upload-cloud"></i> <span class="i-name">icon-upload-cloud</span><span class="i-code">0xe711</span></li>
            <li title="Code: 0xe715"><i class="icon-export"></i> <span class="i-name">icon-export</span><span class="i-code">0xe715</span></li>
            <li title="Code: 0xe716"><i class="icon-print"></i> <span class="i-name">icon-print</span><span class="i-code">0xe716</span></li>
            <li title="Code: 0xe717"><i class="icon-retweet"></i> <span class="i-name">icon-retweet</span><span class="i-code">0xe717</span></li>
            <li title="Code: 0xe718"><i class="icon-comment"></i> <span class="i-name">icon-comment</span><span class="i-code">0xe718</span></li>
            <li title="Code: 0xe861"><i class="icon-comment-1"></i> <span class="i-name">icon-comment-1</span><span class="i-code">0xe861</span></li>
            <li title="Code: 0xe802"><i class="icon-comment-2"></i> <span class="i-name">icon-comment-2</span><span class="i-code">0xe802</span></li>
            <li title="Code: 0xe720"><i class="icon-chat"></i> <span class="i-name">icon-chat</span><span class="i-code">0xe720</span></li>
            <li title="Code: 0xe862"><i class="icon-chat-1"></i> <span class="i-name">icon-chat-1</span><span class="i-code">0xe862</span></li>
            <li title="Code: 0xe722"><i class="icon-vcard"></i> <span class="i-name">icon-vcard</span><span class="i-code">0xe722</span></li>
            <li title="Code: 0xe723"><i class="icon-address"></i> <span class="i-name">icon-address</span><span class="i-code">0xe723</span></li>
            <li title="Code: 0xe724"><i class="icon-location"></i> <span class="i-name">icon-location</span><span class="i-code">0xe724</span></li>
            <li title="Code: 0xe865"><i class="icon-location-1"></i> <span class="i-name">icon-location-1</span><span class="i-code">0xe865</span></li>
            <li title="Code: 0xe878"><i class="icon-location-2"></i> <span class="i-name">icon-location-2</span><span class="i-code">0xe878</span></li>
            <li title="Code: 0xe727"><i class="icon-map"></i> <span class="i-name">icon-map</span><span class="i-code">0xe727</span></li>
            <li title="Code: 0xe728"><i class="icon-compass"></i> <span class="i-name">icon-compass</span><span class="i-code">0xe728</span></li>
            <li title="Code: 0xe729"><i class="icon-trash"></i> <span class="i-name">icon-trash</span><span class="i-code">0xe729</span></li>
            <li title="Code: 0xe730"><i class="icon-doc"></i> <span class="i-name">icon-doc</span><span class="i-code">0xe730</span></li>
            <li title="Code: 0xe731"><i class="icon-doc-text-inv"></i> <span class="i-name">icon-doc-text-inv</span><span class="i-code">0xe731</span></li>
            <li title="Code: 0xe736"><i class="icon-docs"></i> <span class="i-name">icon-docs</span><span class="i-code">0xe736</span></li>
            <li title="Code: 0xe737"><i class="icon-doc-landscape"></i> <span class="i-name">icon-doc-landscape</span><span class="i-code">0xe737</span></li>
            <li title="Code: 0xe738"><i class="icon-archive"></i> <span class="i-name">icon-archive</span><span class="i-code">0xe738</span></li>
            <li title="Code: 0xe73c"><i class="icon-share"></i> <span class="i-name">icon-share</span><span class="i-code">0xe73c</span></li>
            <li title="Code: 0xe73d"><i class="icon-basket"></i> <span class="i-name">icon-basket</span><span class="i-code">0xe73d</span></li>
            <li title="Code: 0xe86b"><i class="icon-basket-1"></i> <span class="i-name">icon-basket-1</span><span class="i-code">0xe86b</span></li>
            <li title="Code: 0xe875"><i class="icon-basket-2"></i> <span class="i-name">icon-basket-2</span><span class="i-code">0xe875</span></li>
            <li title="Code: 0xe73e"><i class="icon-shareable"></i> <span class="i-name">icon-shareable</span><span class="i-code">0xe73e</span></li>
            <li title="Code: 0xe740"><i class="icon-login"></i> <span class="i-name">icon-login</span><span class="i-code">0xe740</span></li>
            <li title="Code: 0xe86d"><i class="icon-login-1"></i> <span class="i-name">icon-login-1</span><span class="i-code">0xe86d</span></li>
            <li title="Code: 0xe741"><i class="icon-logout"></i> <span class="i-name">icon-logout</span><span class="i-code">0xe741</span></li>
            <li title="Code: 0xe86e"><i class="icon-logout-1"></i> <span class="i-name">icon-logout-1</span><span class="i-code">0xe86e</span></li>
            <li title="Code: 0xe742"><i class="icon-volume"></i> <span class="i-name">icon-volume</span><span class="i-code">0xe742</span></li>
            <li title="Code: 0xe744"><i class="icon-resize-full"></i> <span class="i-name">icon-resize-full</span><span class="i-code">0xe744</span></li>
            <li title="Code: 0xe746"><i class="icon-resize-small"></i> <span class="i-name">icon-resize-small</span><span class="i-code">0xe746</span></li>
            <li title="Code: 0xe74c"><i class="icon-popup"></i> <span class="i-name">icon-popup</span><span class="i-code">0xe74c</span></li>
            <li title="Code: 0xe74d"><i class="icon-publish"></i> <span class="i-name">icon-publish</span><span class="i-code">0xe74d</span></li>
            <li title="Code: 0xe74e"><i class="icon-window"></i> <span class="i-name">icon-window</span><span class="i-code">0xe74e</span></li>
            <li title="Code: 0xe74f"><i class="icon-arrow-combo"></i> <span class="i-name">icon-arrow-combo</span><span class="i-code">0xe74f</span></li>
            <li title="Code: 0xe751"><i class="icon-chart-pie"></i> <span class="i-name">icon-chart-pie</span><span class="i-code">0xe751</span></li>
            <li title="Code: 0xe752"><i class="icon-language"></i> <span class="i-name">icon-language</span><span class="i-code">0xe752</span></li>
            <li title="Code: 0xe753"><i class="icon-air"></i> <span class="i-name">icon-air</span><span class="i-code">0xe753</span></li>
            <li title="Code: 0xe754"><i class="icon-database"></i> <span class="i-name">icon-database</span><span class="i-code">0xe754</span></li>
            <li title="Code: 0xe755"><i class="icon-drive"></i> <span class="i-name">icon-drive</span><span class="i-code">0xe755</span></li>
            <li title="Code: 0xe756"><i class="icon-bucket"></i> <span class="i-name">icon-bucket</span><span class="i-code">0xe756</span></li>
            <li title="Code: 0xe757"><i class="icon-thermometer"></i> <span class="i-name">icon-thermometer</span><span class="i-code">0xe757</span></li>
            <li title="Code: 0xe758"><i class="icon-down-circled"></i> <span class="i-name">icon-down-circled</span><span class="i-code">0xe758</span></li>
            <li title="Code: 0xe759"><i class="icon-left-circled"></i> <span class="i-name">icon-left-circled</span><span class="i-code">0xe759</span></li>
            <li title="Code: 0xe75a"><i class="icon-right-circled"></i> <span class="i-name">icon-right-circled</span><span class="i-code">0xe75a</span></li>
            <li title="Code: 0xe75b"><i class="icon-up-circled"></i> <span class="i-name">icon-up-circled</span><span class="i-code">0xe75b</span></li>
            <li title="Code: 0xe760"><i class="icon-down-open-mini"></i> <span class="i-name">icon-down-open-mini</span><span class="i-code">0xe760</span></li>
            <li title="Code: 0xe761"><i class="icon-left-open-mini"></i> <span class="i-name">icon-left-open-mini</span><span class="i-code">0xe761</span></li>
            <li title="Code: 0xe762"><i class="icon-right-open-mini"></i> <span class="i-name">icon-right-open-mini</span><span class="i-code">0xe762</span></li>
            <li title="Code: 0xe763"><i class="icon-up-open-mini"></i> <span class="i-name">icon-up-open-mini</span><span class="i-code">0xe763</span></li>
            <li title="Code: 0xe764"><i class="icon-down-open-big"></i> <span class="i-name">icon-down-open-big</span><span class="i-code">0xe764</span></li>
            <li title="Code: 0xe765"><i class="icon-left-open-big"></i> <span class="i-name">icon-left-open-big</span><span class="i-code">0xe765</span></li>
            <li title="Code: 0xe766"><i class="icon-right-open-big"></i> <span class="i-name">icon-right-open-big</span><span class="i-code">0xe766</span></li>
            <li title="Code: 0xe767"><i class="icon-up-open-big"></i> <span class="i-name">icon-up-open-big</span><span class="i-code">0xe767</span></li>
            <li title="Code: 0xe769"><i class="icon-progress-1"></i> <span class="i-name">icon-progress-1</span><span class="i-code">0xe769</span></li>
            <li title="Code: 0xe76a"><i class="icon-progress-2"></i> <span class="i-name">icon-progress-2</span><span class="i-code">0xe76a</span></li>
            <li title="Code: 0xe76b"><i class="icon-progress-3"></i> <span class="i-name">icon-progress-3</span><span class="i-code">0xe76b</span></li>
            <li title="Code: 0xe770"><i class="icon-signal-2"></i> <span class="i-name">icon-signal-2</span><span class="i-code">0xe770</span></li>
            <li title="Code: 0xe771"><i class="icon-back-in-time"></i> <span class="i-name">icon-back-in-time</span><span class="i-code">0xe771</span></li>
            <li title="Code: 0xe776"><i class="icon-network"></i> <span class="i-name">icon-network</span><span class="i-code">0xe776</span></li>
            <li title="Code: 0xe777"><i class="icon-inbox"></i> <span class="i-name">icon-inbox</span><span class="i-code">0xe777</span></li>
            <li title="Code: 0xe830"><i class="icon-inbox-1"></i> <span class="i-name">icon-inbox-1</span><span class="i-code">0xe830</span></li>
            <li title="Code: 0xe778"><i class="icon-install"></i> <span class="i-name">icon-install</span><span class="i-code">0xe778</span></li>
            <li title="Code: 0xe788"><i class="icon-lifebuoy"></i> <span class="i-name">icon-lifebuoy</span><span class="i-code">0xe788</span></li>
            <li title="Code: 0xe789"><i class="icon-mouse"></i> <span class="i-name">icon-mouse</span><span class="i-code">0xe789</span></li>
            <li title="Code: 0xe78b"><i class="icon-dot"></i> <span class="i-name">icon-dot</span><span class="i-code">0xe78b</span></li>
            <li title="Code: 0xe78c"><i class="icon-dot-2"></i> <span class="i-name">icon-dot-2</span><span class="i-code">0xe78c</span></li>
            <li title="Code: 0xe78d"><i class="icon-dot-3"></i> <span class="i-name">icon-dot-3</span><span class="i-code">0xe78d</span></li>
            <li title="Code: 0xe78e"><i class="icon-suitcase"></i> <span class="i-name">icon-suitcase</span><span class="i-code">0xe78e</span></li>
            <li title="Code: 0xe81f"><i class="icon-off"></i> <span class="i-name">icon-off</span><span class="i-code">0xe81f</span></li>
            <li title="Code: 0xe78f"><i class="icon-road"></i> <span class="i-name">icon-road</span><span class="i-code">0xe78f</span></li>
            <li title="Code: 0xe790"><i class="icon-flow-cascade"></i> <span class="i-name">icon-flow-cascade</span><span class="i-code">0xe790</span></li>
            <li title="Code: 0xe820"><i class="icon-list-alt"></i> <span class="i-name">icon-list-alt</span><span class="i-code">0xe820</span></li>
            <li title="Code: 0xe791"><i class="icon-flow-branch"></i> <span class="i-name">icon-flow-branch</span><span class="i-code">0xe791</span></li>
            <li title="Code: 0xe821"><i class="icon-qrcode"></i> <span class="i-name">icon-qrcode</span><span class="i-code">0xe821</span></li>
            <li title="Code: 0xe792"><i class="icon-flow-tree"></i> <span class="i-name">icon-flow-tree</span><span class="i-code">0xe792</span></li>
            <li title="Code: 0xe822"><i class="icon-barcode"></i> <span class="i-name">icon-barcode</span><span class="i-code">0xe822</span></li>
            <li title="Code: 0xe793"><i class="icon-flow-line"></i> <span class="i-name">icon-flow-line</span><span class="i-code">0xe793</span></li>
            <li title="Code: 0xe824"><i class="icon-ajust"></i> <span class="i-name">icon-ajust</span><span class="i-code">0xe824</span></li>
            <li title="Code: 0xe794"><i class="icon-flow-parallel"></i> <span class="i-name">icon-flow-parallel</span><span class="i-code">0xe794</span></li>
            <li title="Code: 0xe833"><i class="icon-tint"></i> <span class="i-name">icon-tint</span><span class="i-code">0xe833</span></li>
            <li title="Code: 0xe79a"><i class="icon-brush"></i> <span class="i-name">icon-brush</span><span class="i-code">0xe79a</span></li>
            <li title="Code: 0xe79b"><i class="icon-paper-plane"></i> <span class="i-name">icon-paper-plane</span><span class="i-code">0xe79b</span></li>
            <li title="Code: 0xe7a1"><i class="icon-magnet"></i> <span class="i-name">icon-magnet</span><span class="i-code">0xe7a1</span></li>
            <li title="Code: 0xe825"><i class="icon-magnet-1"></i> <span class="i-name">icon-magnet-1</span><span class="i-code">0xe825</span></li>
            <li title="Code: 0xe7a2"><i class="icon-gauge"></i> <span class="i-name">icon-gauge</span><span class="i-code">0xe7a2</span></li>
            <li title="Code: 0xe7a3"><i class="icon-traffic-cone"></i> <span class="i-name">icon-traffic-cone</span><span class="i-code">0xe7a3</span></li>
            <li title="Code: 0xe7a5"><i class="icon-cc"></i> <span class="i-name">icon-cc</span><span class="i-code">0xe7a5</span></li>
            <li title="Code: 0xe7a6"><i class="icon-cc-by"></i> <span class="i-name">icon-cc-by</span><span class="i-code">0xe7a6</span></li>
            <li title="Code: 0xe7a7"><i class="icon-cc-nc"></i> <span class="i-name">icon-cc-nc</span><span class="i-code">0xe7a7</span></li>
            <li title="Code: 0xe7a8"><i class="icon-cc-nc-eu"></i> <span class="i-name">icon-cc-nc-eu</span><span class="i-code">0xe7a8</span></li>
            <li title="Code: 0xe7a9"><i class="icon-cc-nc-jp"></i> <span class="i-name">icon-cc-nc-jp</span><span class="i-code">0xe7a9</span></li>
            <li title="Code: 0xe7aa"><i class="icon-cc-sa"></i> <span class="i-name">icon-cc-sa</span><span class="i-code">0xe7aa</span></li>
            <li title="Code: 0xe7ab"><i class="icon-cc-nd"></i> <span class="i-name">icon-cc-nd</span><span class="i-code">0xe7ab</span></li>
            <li title="Code: 0xe7ac"><i class="icon-cc-pd"></i> <span class="i-name">icon-cc-pd</span><span class="i-code">0xe7ac</span></li>
            <li title="Code: 0xe7ad"><i class="icon-cc-zero"></i> <span class="i-name">icon-cc-zero</span><span class="i-code">0xe7ad</span></li>
            <li title="Code: 0xe7ae"><i class="icon-cc-share"></i> <span class="i-name">icon-cc-share</span><span class="i-code">0xe7ae</span></li>
            <li title="Code: 0xe7af"><i class="icon-cc-remix"></i> <span class="i-name">icon-cc-remix</span><span class="i-code">0xe7af</span></li>
            <li title="Code: 0xe7b5"><i class="icon-easel"></i> <span class="i-name">icon-easel</span><span class="i-code">0xe7b5</span></li>
            <li title="Code: 0xe840"><i class="icon-firefox"></i> <span class="i-name">icon-firefox</span><span class="i-code">0xe840</span></li>
            <li title="Code: 0xe841"><i class="icon-chrome"></i> <span class="i-name">icon-chrome</span><span class="i-code">0xe841</span></li>
            <li title="Code: 0xe842"><i class="icon-opera"></i> <span class="i-name">icon-opera</span><span class="i-code">0xe842</span></li>
            <li title="Code: 0xe843"><i class="icon-ie"></i> <span class="i-name">icon-ie</span><span class="i-code">0xe843</span></li>
            <li title="Code: 0xf01d"><i class="icon-paper-plane-1"></i> <span class="i-name">icon-paper-plane-1</span><span class="i-code">0xf01d</span></li>
            <li title="Code: 0xf03d"><i class="icon-chat-2"></i> <span class="i-name">icon-chat-2</span><span class="i-code">0xf03d</span></li>
            <li title="Code: 0xf096"><i class="icon-check-empty"></i> <span class="i-name">icon-check-empty</span><span class="i-code">0xf096</span></li>
            <li title="Code: 0xf0a0"><i class="icon-hdd"></i> <span class="i-name">icon-hdd</span><span class="i-code">0xf0a0</span></li>
            <li title="Code: 0xf0a3"><i class="icon-certificate"></i> <span class="i-name">icon-certificate</span><span class="i-code">0xf0a3</span></li>
            <li title="Code: 0xf0a9"><i class="icon-right-circled-1"></i> <span class="i-name">icon-right-circled-1</span><span class="i-code">0xf0a9</span></li>
            <li title="Code: 0xf0ae"><i class="icon-tasks"></i> <span class="i-name">icon-tasks</span><span class="i-code">0xf0ae</span></li>
            <li title="Code: 0xf0b0"><i class="icon-filter"></i> <span class="i-name">icon-filter</span><span class="i-code">0xf0b0</span></li>
            <li title="Code: 0xf0c3"><i class="icon-beaker"></i> <span class="i-name">icon-beaker</span><span class="i-code">0xf0c3</span></li>
            <li title="Code: 0xf0ce"><i class="icon-table"></i> <span class="i-name">icon-table</span><span class="i-code">0xf0ce</span></li>
            <li title="Code: 0xf0d0"><i class="icon-magic"></i> <span class="i-name">icon-magic</span><span class="i-code">0xf0d0</span></li>
            <li title="Code: 0xf0d6"><i class="icon-money"></i> <span class="i-name">icon-money</span><span class="i-code">0xf0d6</span></li>
            <li title="Code: 0xf0db"><i class="icon-columns"></i> <span class="i-name">icon-columns</span><span class="i-code">0xf0db</span></li>
            <li title="Code: 0xf0e4"><i class="icon-gauge-1"></i> <span class="i-name">icon-gauge-1</span><span class="i-code">0xf0e4</span></li>
            <li title="Code: 0xf0e5"><i class="icon-comment-empty"></i> <span class="i-name">icon-comment-empty</span><span class="i-code">0xf0e5</span></li>
            <li title="Code: 0xf0e6"><i class="icon-chat-empty"></i> <span class="i-name">icon-chat-empty</span><span class="i-code">0xf0e6</span></li>
            <li title="Code: 0xf0e8"><i class="icon-sitemap"></i> <span class="i-name">icon-sitemap</span><span class="i-code">0xf0e8</span></li>
            <li title="Code: 0xf0ea"><i class="icon-paste"></i> <span class="i-name">icon-paste</span><span class="i-code">0xf0ea</span></li>
            <li title="Code: 0xf0eb"><i class="icon-lightbulb"></i> <span class="i-name">icon-lightbulb</span><span class="i-code">0xf0eb</span></li>
            <li title="Code: 0xf0f0"><i class="icon-user-md"></i> <span class="i-name">icon-user-md</span><span class="i-code">0xf0f0</span></li>
            <li title="Code: 0xf0f1"><i class="icon-stethoscope"></i> <span class="i-name">icon-stethoscope</span><span class="i-code">0xf0f1</span></li>
            <li title="Code: 0xf0f2"><i class="icon-suitcase-1"></i> <span class="i-name">icon-suitcase-1</span><span class="i-code">0xf0f2</span></li>
            <li title="Code: 0xf0f3"><i class="icon-bell-alt"></i> <span class="i-name">icon-bell-alt</span><span class="i-code">0xf0f3</span></li>
            <li title="Code: 0xf0f4"><i class="icon-coffee"></i> <span class="i-name">icon-coffee</span><span class="i-code">0xf0f4</span></li>
            <li title="Code: 0xf0f5"><i class="icon-food"></i> <span class="i-name">icon-food</span><span class="i-code">0xf0f5</span></li>
            <li title="Code: 0xf0f9"><i class="icon-ambulance"></i> <span class="i-name">icon-ambulance</span><span class="i-code">0xf0f9</span></li>
            <li title="Code: 0xf0fa"><i class="icon-medkit"></i> <span class="i-name">icon-medkit</span><span class="i-code">0xf0fa</span></li>
            <li title="Code: 0xf0fb"><i class="icon-fighter-jet"></i> <span class="i-name">icon-fighter-jet</span><span class="i-code">0xf0fb</span></li>
            <li title="Code: 0xf0fc"><i class="icon-beer"></i> <span class="i-name">icon-beer</span><span class="i-code">0xf0fc</span></li>
            <li title="Code: 0xf0fe"><i class="icon-plus-squared-1"></i> <span class="i-name">icon-plus-squared-1</span><span class="i-code">0xf0fe</span></li>
            <li title="Code: 0xf108"><i class="icon-desktop"></i> <span class="i-name">icon-desktop</span><span class="i-code">0xf108</span></li>
            <li title="Code: 0xf109"><i class="icon-laptop"></i> <span class="i-name">icon-laptop</span><span class="i-code">0xf109</span></li>
            <li title="Code: 0xf10a"><i class="icon-tablet"></i> <span class="i-name">icon-tablet</span><span class="i-code">0xf10a</span></li>
            <li title="Code: 0xf10b"><i class="icon-mobile-1"></i> <span class="i-name">icon-mobile-1</span><span class="i-code">0xf10b</span></li>
            <li title="Code: 0xf10c"><i class="icon-circle-empty"></i> <span class="i-name">icon-circle-empty</span><span class="i-code">0xf10c</span></li>
            <li title="Code: 0xf110"><i class="icon-spinner"></i> <span class="i-name">icon-spinner</span><span class="i-code">0xf110</span></li>
            <li title="Code: 0xf111"><i class="icon-circle"></i> <span class="i-name">icon-circle</span><span class="i-code">0xf111</span></li>
            <li title="Code: 0xf4ac"><i class="icon-comment-3"></i> <span class="i-name">icon-comment-3</span><span class="i-code">0xf4ac</span></li>
            <li title="Code: 0x1f304"><i class="icon-picture"></i> <span class="i-name">icon-picture</span><span class="i-code">0x1f304</span></li>
            <li title="Code: 0x1f30e"><i class="icon-globe"></i> <span class="i-name">icon-globe</span><span class="i-code">0x1f30e</span></li>
            <li title="Code: 0xe831"><i class="icon-globe-1"></i> <span class="i-name">icon-globe-1</span><span class="i-code">0xe831</span></li>
            <li title="Code: 0x1f310"><i class="icon-globe-2"></i> <span class="i-name">icon-globe-2</span><span class="i-code">0x1f310</span></li>
            <li title="Code: 0x1f342"><i class="icon-leaf"></i> <span class="i-name">icon-leaf</span><span class="i-code">0x1f342</span></li>
            <li title="Code: 0xe81d"><i class="icon-leaf-1"></i> <span class="i-name">icon-leaf-1</span><span class="i-code">0xe81d</span></li>
            <li title="Code: 0x1f381"><i class="icon-gift"></i> <span class="i-name">icon-gift</span><span class="i-code">0x1f381</span></li>
            <li title="Code: 0x1f393"><i class="icon-graduation-cap"></i> <span class="i-name">icon-graduation-cap</span><span class="i-code">0x1f393</span></li>
            <li title="Code: 0x1f3a4"><i class="icon-mic"></i> <span class="i-name">icon-mic</span><span class="i-code">0x1f3a4</span></li>
            <li title="Code: 0x1f3a7"><i class="icon-headphones"></i> <span class="i-name">icon-headphones</span><span class="i-code">0x1f3a7</span></li>
            <li title="Code: 0x1f3a8"><i class="icon-palette"></i> <span class="i-name">icon-palette</span><span class="i-code">0x1f3a8</span></li>
            <li title="Code: 0x1f3ab"><i class="icon-ticket"></i> <span class="i-name">icon-ticket</span><span class="i-code">0x1f3ab</span></li>
            <li title="Code: 0x1f3ac"><i class="icon-video"></i> <span class="i-name">icon-video</span><span class="i-code">0x1f3ac</span></li>
            <li title="Code: 0x1f3af"><i class="icon-target"></i> <span class="i-name">icon-target</span><span class="i-code">0x1f3af</span></li>
            <li title="Code: 0x1f3c6"><i class="icon-trophy"></i> <span class="i-name">icon-trophy</span><span class="i-code">0x1f3c6</span></li>
            <li title="Code: 0x1f3c9"><i class="icon-award"></i> <span class="i-name">icon-award</span><span class="i-code">0x1f3c9</span></li>
            <li title="Code: 0x1f44d"><i class="icon-thumbs-up"></i> <span class="i-name">icon-thumbs-up</span><span class="i-code">0x1f44d</span></li>
            <li title="Code: 0x1f44e"><i class="icon-thumbs-down"></i> <span class="i-name">icon-thumbs-down</span><span class="i-code">0x1f44e</span></li>
            <li title="Code: 0x1f45c"><i class="icon-bag"></i> <span class="i-name">icon-bag</span><span class="i-code">0x1f45c</span></li>
            <li title="Code: 0x1f464"><i class="icon-user"></i> <span class="i-name">icon-user</span><span class="i-code">0x1f464</span></li>
            <li title="Code: 0x1f465"><i class="icon-users"></i> <span class="i-name">icon-users</span><span class="i-code">0x1f465</span></li>
            <li title="Code: 0x1f4a1"><i class="icon-lamp"></i> <span class="i-name">icon-lamp</span><span class="i-code">0x1f4a1</span></li>
            <li title="Code: 0x1f4a5"><i class="icon-alert"></i> <span class="i-name">icon-alert</span><span class="i-code">0x1f4a5</span></li>
            <li title="Code: 0x1f4a6"><i class="icon-water"></i> <span class="i-name">icon-water</span><span class="i-code">0x1f4a6</span></li>
            <li title="Code: 0x1f4a7"><i class="icon-droplet"></i> <span class="i-name">icon-droplet</span><span class="i-code">0x1f4a7</span></li>
            <li title="Code: 0x1f4b3"><i class="icon-credit-card"></i> <span class="i-name">icon-credit-card</span><span class="i-code">0x1f4b3</span></li>
            <li title="Code: 0xe827"><i class="icon-credit-card-1"></i> <span class="i-name">icon-credit-card-1</span><span class="i-code">0xe827</span></li>
            <li title="Code: 0x1f4bb"><i class="icon-monitor"></i> <span class="i-name">icon-monitor</span><span class="i-code">0x1f4bb</span></li>
            <li title="Code: 0x1f4bc"><i class="icon-briefcase"></i> <span class="i-name">icon-briefcase</span><span class="i-code">0x1f4bc</span></li>
            <li title="Code: 0xe81e"><i class="icon-briefcase-1"></i> <span class="i-name">icon-briefcase-1</span><span class="i-code">0xe81e</span></li>
            <li title="Code: 0x1f4be"><i class="icon-floppy"></i> <span class="i-name">icon-floppy</span><span class="i-code">0x1f4be</span></li>
            <li title="Code: 0xe828"><i class="icon-floppy-1"></i> <span class="i-name">icon-floppy-1</span><span class="i-code">0xe828</span></li>
            <li title="Code: 0x1f4bf"><i class="icon-cd"></i> <span class="i-name">icon-cd</span><span class="i-code">0x1f4bf</span></li>
            <li title="Code: 0x1f4c1"><i class="icon-folder"></i> <span class="i-name">icon-folder</span><span class="i-code">0x1f4c1</span></li>
            <li title="Code: 0x1f4c4"><i class="icon-doc-text"></i> <span class="i-name">icon-doc-text</span><span class="i-code">0x1f4c4</span></li>
            <li title="Code: 0x1f4c5"><i class="icon-calendar"></i> <span class="i-name">icon-calendar</span><span class="i-code">0x1f4c5</span></li>
            <li title="Code: 0xe86c"><i class="icon-calendar-2"></i> <span class="i-name">icon-calendar-2</span><span class="i-code">0xe86c</span></li>
            <li title="Code: 0x1f4c8"><i class="icon-chart-line"></i> <span class="i-name">icon-chart-line</span><span class="i-code">0x1f4c8</span></li>
            <li title="Code: 0x1f4ca"><i class="icon-chart-bar"></i> <span class="i-name">icon-chart-bar</span><span class="i-code">0x1f4ca</span></li>
            <li title="Code: 0xe826"><i class="icon-chart-bar-1"></i> <span class="i-name">icon-chart-bar-1</span><span class="i-code">0xe826</span></li>
            <li title="Code: 0x1f4cb"><i class="icon-clipboard"></i> <span class="i-name">icon-clipboard</span><span class="i-code">0x1f4cb</span></li>
            <li title="Code: 0x1f4ce"><i class="icon-attach"></i> <span class="i-name">icon-attach</span><span class="i-code">0x1f4ce</span></li>
            <li title="Code: 0x1f4d1"><i class="icon-bookmarks"></i> <span class="i-name">icon-bookmarks</span><span class="i-code">0x1f4d1</span></li>
            <li title="Code: 0x1f4d5"><i class="icon-book"></i> <span class="i-name">icon-book</span><span class="i-code">0x1f4d5</span></li>
            <li title="Code: 0xe823"><i class="icon-book-1"></i> <span class="i-name">icon-book-1</span><span class="i-code">0xe823</span></li>
            <li title="Code: 0x1f4d6"><i class="icon-book-open"></i> <span class="i-name">icon-book-open</span><span class="i-code">0x1f4d6</span></li>
            <li title="Code: 0x1f4de"><i class="icon-phone"></i> <span class="i-name">icon-phone</span><span class="i-code">0x1f4de</span></li>
            <li title="Code: 0xe869"><i class="icon-phone-1"></i> <span class="i-name">icon-phone-1</span><span class="i-code">0xe869</span></li>
            <li title="Code: 0x1f4e3"><i class="icon-megaphone"></i> <span class="i-name">icon-megaphone</span><span class="i-code">0x1f4e3</span></li>
            <li title="Code: 0xe829"><i class="icon-megaphone-1"></i> <span class="i-name">icon-megaphone-1</span><span class="i-code">0xe829</span></li>
            <li title="Code: 0xe87b"><i class="icon-bullhorn"></i> <span class="i-name">icon-bullhorn</span><span class="i-code">0xe87b</span></li>
            <li title="Code: 0x1f4e4"><i class="icon-upload"></i> <span class="i-name">icon-upload</span><span class="i-code">0x1f4e4</span></li>
            <li title="Code: 0x1f4e5"><i class="icon-download"></i> <span class="i-name">icon-download</span><span class="i-code">0x1f4e5</span></li>
            <li title="Code: 0x1f4e6"><i class="icon-box"></i> <span class="i-name">icon-box</span><span class="i-code">0x1f4e6</span></li>
            <li title="Code: 0x1f4f0"><i class="icon-newspaper"></i> <span class="i-name">icon-newspaper</span><span class="i-code">0x1f4f0</span></li>
            <li title="Code: 0x1f4f1"><i class="icon-mobile"></i> <span class="i-name">icon-mobile</span><span class="i-code">0x1f4f1</span></li>
            <li title="Code: 0x1f4f6"><i class="icon-signal"></i> <span class="i-name">icon-signal</span><span class="i-code">0x1f4f6</span></li>
            <li title="Code: 0xe81a"><i class="icon-signal-1"></i> <span class="i-name">icon-signal-1</span><span class="i-code">0xe81a</span></li>
            <li title="Code: 0x1f4f7"><i class="icon-camera"></i> <span class="i-name">icon-camera</span><span class="i-code">0x1f4f7</span></li>
            <li title="Code: 0x1f500"><i class="icon-shuffle"></i> <span class="i-name">icon-shuffle</span><span class="i-code">0x1f500</span></li>
            <li title="Code: 0x1f501"><i class="icon-loop"></i> <span class="i-name">icon-loop</span><span class="i-code">0x1f501</span></li>
            <li title="Code: 0x1f504"><i class="icon-arrows-ccw"></i> <span class="i-name">icon-arrows-ccw</span><span class="i-code">0x1f504</span></li>
            <li title="Code: 0x1f505"><i class="icon-light-down"></i> <span class="i-name">icon-light-down</span><span class="i-code">0x1f505</span></li>
            <li title="Code: 0x1f506"><i class="icon-light-up"></i> <span class="i-name">icon-light-up</span><span class="i-code">0x1f506</span></li>
            <li title="Code: 0x1f507"><i class="icon-mute"></i> <span class="i-name">icon-mute</span><span class="i-code">0x1f507</span></li>
            <li title="Code: 0xe86f"><i class="icon-volume-off"></i> <span class="i-name">icon-volume-off</span><span class="i-code">0xe86f</span></li>
            <li title="Code: 0x1f509"><i class="icon-volume-down"></i> <span class="i-name">icon-volume-down</span><span class="i-code">0x1f509</span></li>
            <li title="Code: 0x1f50a"><i class="icon-sound"></i> <span class="i-name">icon-sound</span><span class="i-code">0x1f50a</span></li>
            <li title="Code: 0xe870"><i class="icon-volume-up"></i> <span class="i-name">icon-volume-up</span><span class="i-code">0xe870</span></li>
            <li title="Code: 0x1f50b"><i class="icon-battery"></i> <span class="i-name">icon-battery</span><span class="i-code">0x1f50b</span></li>
            <li title="Code: 0x1f50d"><i class="icon-search"></i> <span class="i-name">icon-search</span><span class="i-code">0x1f50d</span></li>
            <li title="Code: 0x1f511"><i class="icon-key"></i> <span class="i-name">icon-key</span><span class="i-code">0x1f511</span></li>
            <li title="Code: 0xe82a"><i class="icon-key-1"></i> <span class="i-name">icon-key-1</span><span class="i-code">0xe82a</span></li>
            <li title="Code: 0x1f512"><i class="icon-lock"></i> <span class="i-name">icon-lock</span><span class="i-code">0x1f512</span></li>
            <li title="Code: 0x1f513"><i class="icon-lock-open"></i> <span class="i-name">icon-lock-open</span><span class="i-code">0x1f513</span></li>
            <li title="Code: 0x1f514"><i class="icon-bell"></i> <span class="i-name">icon-bell</span><span class="i-code">0x1f514</span></li>
            <li title="Code: 0xe863"><i class="icon-bell-1"></i> <span class="i-name">icon-bell-1</span><span class="i-code">0xe863</span></li>
            <li title="Code: 0x1f516"><i class="icon-bookmark"></i> <span class="i-name">icon-bookmark</span><span class="i-code">0x1f516</span></li>
            <li title="Code: 0x1f517"><i class="icon-link"></i> <span class="i-name">icon-link</span><span class="i-code">0x1f517</span></li>
            <li title="Code: 0x1f519"><i class="icon-back"></i> <span class="i-name">icon-back</span><span class="i-code">0x1f519</span></li>
            <li title="Code: 0x1f525"><i class="icon-fire"></i> <span class="i-name">icon-fire</span><span class="i-code">0x1f525</span></li>
            <li title="Code: 0x1f526"><i class="icon-flashlight"></i> <span class="i-name">icon-flashlight</span><span class="i-code">0x1f526</span></li>
            <li title="Code: 0x1f527"><i class="icon-wrench"></i> <span class="i-name">icon-wrench</span><span class="i-code">0x1f527</span></li>
            <li title="Code: 0x1f528"><i class="icon-hammer"></i> <span class="i-name">icon-hammer</span><span class="i-code">0x1f528</span></li>
            <li title="Code: 0x1f53e"><i class="icon-chart-area"></i> <span class="i-name">icon-chart-area</span><span class="i-code">0x1f53e</span></li>
            <li title="Code: 0x1f554"><i class="icon-clock"></i> <span class="i-name">icon-clock</span><span class="i-code">0x1f554</span></li>
            <li title="Code: 0xe871"><i class="icon-clock-1"></i> <span class="i-name">icon-clock-1</span><span class="i-code">0xe871</span></li>
            <li title="Code: 0x1f680"><i class="icon-rocket"></i> <span class="i-name">icon-rocket</span><span class="i-code">0x1f680</span></li>
            <li title="Code: 0x1f69a"><i class="icon-truck"></i> <span class="i-name">icon-truck</span><span class="i-code">0x1f69a</span></li>
            <li title="Code: 0x1f6ab"><i class="icon-block"></i> <span class="i-name">icon-block</span><span class="i-code">0x1f6ab</span></li>
            <li title="Code: 0xe872"><i class="icon-block-1"></i> <span class="i-name">icon-block-1</span><span class="i-code">0xe872</span></li>
          </ul>';
                                                   $output .= '<input type="hidden" class="capture-input vibe-form-text vibe-input" name="' . $pkey . '" id="' . $pkey . '" value="' . (isset($param['std'])?$param['std']:'') . '" />' . "\n";
						   $output .= $row_end;	
							// append
							$this->append_output( $output );
                                                        break;
                             
                                       case 'socialicon' :
                                                   $output  = $row_start;
                                                   $output .=' <ul class="the-icons unstyled">
            <li title="Code: 0x21"><i class="icon-duckduckgo"></i> <span class="i-name">icon-duckduckgo</span><span class="i-code">0x21</span></li>
            <li title="Code: 0x22"><i class="icon-aim"></i> <span class="i-name">icon-aim</span><span class="i-code">0x22</span></li>
            <li title="Code: 0x23"><i class="icon-delicious"></i> <span class="i-name">icon-delicious</span><span class="i-code">0x23</span></li>
            <li title="Code: 0x24"><i class="icon-paypal"></i> <span class="i-name">icon-paypal</span><span class="i-code">0x24</span></li>
            <li title="Code: 0x25"><i class="icon-flattr"></i> <span class="i-name">icon-flattr</span><span class="i-code">0x25</span></li>
            <li title="Code: 0x26"><i class="icon-android"></i> <span class="i-name">icon-android</span><span class="i-code">0x26</span></li>
            <li title="Code: 0x27"><i class="icon-eventful"></i> <span class="i-name">icon-eventful</span><span class="i-code">0x27</span></li>
            <li title="Code: 0x2a"><i class="icon-smashmag"></i> <span class="i-name">icon-smashmag</span><span class="i-code">0x2a</span></li>
            <li title="Code: 0xe800"><i class="icon-gplus"></i> <span class="i-name">icon-gplus</span><span class="i-code">0xe800</span></li>
            <li title="Code: 0x2c"><i class="icon-wikipedia"></i> <span class="i-name">icon-wikipedia</span><span class="i-code">0x2c</span></li>
            <li title="Code: 0xe801"><i class="icon-lanyrd"></i> <span class="i-name">icon-lanyrd</span><span class="i-code">0xe801</span></li>
            <li title="Code: 0x2f"><i class="icon-stumbleupon"></i> <span class="i-name">icon-stumbleupon</span><span class="i-code">0x2f</span></li>
            <li title="Code: 0x30"><i class="icon-fivehundredpx"></i> <span class="i-name">icon-fivehundredpx</span><span class="i-code">0x30</span></li>
            <li title="Code: 0x31"><i class="icon-pinterest"></i> <span class="i-name">icon-pinterest</span><span class="i-code">0x31</span></li>
            <li title="Code: 0x32"><i class="icon-bitcoin"></i> <span class="i-name">icon-bitcoin</span><span class="i-code">0x32</span></li>
            <li title="Code: 0x33"><i class="icon-w3c"></i> <span class="i-name">icon-w3c</span><span class="i-code">0x33</span></li>
            <li title="Code: 0x34"><i class="icon-foursquare"></i> <span class="i-name">icon-foursquare</span><span class="i-code">0x34</span></li>
            <li title="Code: 0x35"><i class="icon-html5"></i> <span class="i-name">icon-html5</span><span class="i-code">0x35</span></li>
            <li title="Code: 0x39"><i class="icon-ninetyninedesigns"></i> <span class="i-name">icon-ninetyninedesigns</span><span class="i-code">0x39</span></li>
            <li title="Code: 0x3a"><i class="icon-forrst"></i> <span class="i-name">icon-forrst</span><span class="i-code">0x3a</span></li>
            <li title="Code: 0x3b"><i class="icon-digg"></i> <span class="i-name">icon-digg</span><span class="i-code">0x3b</span></li>
            <li title="Code: 0x3d"><i class="icon-spotify"></i> <span class="i-name">icon-spotify</span><span class="i-code">0x3d</span></li>
            <li title="Code: 0x3e"><i class="icon-reddit"></i> <span class="i-name">icon-reddit</span><span class="i-code">0x3e</span></li>
            <li title="Code: 0x3f"><i class="icon-guest"></i> <span class="i-name">icon-guest</span><span class="i-code">0x3f</span></li>
            <li title="Code: 0x40"><i class="icon-gowalla"></i> <span class="i-name">icon-gowalla</span><span class="i-code">0x40</span></li>
            <li title="Code: 0x41"><i class="icon-appstore"></i> <span class="i-name">icon-appstore</span><span class="i-code">0x41</span></li>
            <li title="Code: 0x42"><i class="icon-blogger"></i> <span class="i-name">icon-blogger</span><span class="i-code">0x42</span></li>
            <li title="Code: 0x43"><i class="icon-cc-1"></i> <span class="i-name">icon-cc-1</span><span class="i-code">0x43</span></li>
            <li title="Code: 0x44"><i class="icon-dribbble"></i> <span class="i-name">icon-dribbble</span><span class="i-code">0x44</span></li>
            <li title="Code: 0x45"><i class="icon-evernote"></i> <span class="i-name">icon-evernote</span><span class="i-code">0x45</span></li>
            <li title="Code: 0x46"><i class="icon-flickr"></i> <span class="i-name">icon-flickr</span><span class="i-code">0x46</span></li>
            <li title="Code: 0x47"><i class="icon-google"></i> <span class="i-name">icon-google</span><span class="i-code">0x47</span></li>
            <li title="Code: 0x48"><i class="icon-viadeo"></i> <span class="i-name">icon-viadeo</span><span class="i-code">0x48</span></li>
            <li title="Code: 0x49"><i class="icon-instapaper"></i> <span class="i-name">icon-instapaper</span><span class="i-code">0x49</span></li>
            <li title="Code: 0x4a"><i class="icon-weibo"></i> <span class="i-name">icon-weibo</span><span class="i-code">0x4a</span></li>
            <li title="Code: 0x4b"><i class="icon-klout"></i> <span class="i-name">icon-klout</span><span class="i-code">0x4b</span></li>
            <li title="Code: 0x4c"><i class="icon-linkedin"></i> <span class="i-name">icon-linkedin</span><span class="i-code">0x4c</span></li>
            <li title="Code: 0x4d"><i class="icon-meetup"></i> <span class="i-name">icon-meetup</span><span class="i-code">0x4d</span></li>
            <li title="Code: 0x4e"><i class="icon-vk"></i> <span class="i-name">icon-vk</span><span class="i-code">0x4e</span></li>
            <li title="Code: 0x50"><i class="icon-plancast"></i> <span class="i-name">icon-plancast</span><span class="i-code">0x50</span></li>
            <li title="Code: 0x51"><i class="icon-disqus"></i> <span class="i-name">icon-disqus</span><span class="i-code">0x51</span></li>
            <li title="Code: 0x52"><i class="icon-rss-1"></i> <span class="i-name">icon-rss-1</span><span class="i-code">0x52</span></li>
            <li title="Code: 0x53"><i class="icon-skype"></i> <span class="i-name">icon-skype</span><span class="i-code">0x53</span></li>
            <li title="Code: 0x54"><i class="icon-twitter"></i> <span class="i-name">icon-twitter</span><span class="i-code">0x54</span></li>
            <li title="Code: 0x55"><i class="icon-youtube"></i> <span class="i-name">icon-youtube</span><span class="i-code">0x55</span></li>
            <li title="Code: 0x56"><i class="icon-vimeo"></i> <span class="i-name">icon-vimeo</span><span class="i-code">0x56</span></li>
            <li title="Code: 0x57"><i class="icon-windows"></i> <span class="i-name">icon-windows</span><span class="i-code">0x57</span></li>
            <li title="Code: 0x58"><i class="icon-xing"></i> <span class="i-name">icon-xing</span><span class="i-code">0x58</span></li>
            <li title="Code: 0x59"><i class="icon-yahoo"></i> <span class="i-name">icon-yahoo</span><span class="i-code">0x59</span></li>
            <li title="Code: 0x5b"><i class="icon-chrome-1"></i> <span class="i-name">icon-chrome-1</span><span class="i-code">0x5b</span></li>
            <li title="Code: 0x5d"><i class="icon-email"></i> <span class="i-name">icon-email</span><span class="i-code">0x5d</span></li>
            <li title="Code: 0x5e"><i class="icon-macstore"></i> <span class="i-name">icon-macstore</span><span class="i-code">0x5e</span></li>
            <li title="Code: 0x5f"><i class="icon-myspace"></i> <span class="i-name">icon-myspace</span><span class="i-code">0x5f</span></li>
            <li title="Code: 0x60"><i class="icon-podcast"></i> <span class="i-name">icon-podcast</span><span class="i-code">0x60</span></li>
            <li title="Code: 0x61"><i class="icon-amazon"></i> <span class="i-name">icon-amazon</span><span class="i-code">0x61</span></li>
            <li title="Code: 0x62"><i class="icon-steam"></i> <span class="i-name">icon-steam</span><span class="i-code">0x62</span></li>
            <li title="Code: 0x63"><i class="icon-cloudapp"></i> <span class="i-name">icon-cloudapp</span><span class="i-code">0x63</span></li>
            <li title="Code: 0x64"><i class="icon-dropbox"></i> <span class="i-name">icon-dropbox</span><span class="i-code">0x64</span></li>
            <li title="Code: 0x65"><i class="icon-ebay"></i> <span class="i-name">icon-ebay</span><span class="i-code">0x65</span></li>
            <li title="Code: 0x66"><i class="icon-facebook"></i> <span class="i-name">icon-facebook</span><span class="i-code">0x66</span></li>
            <li title="Code: 0x67"><i class="icon-github"></i> <span class="i-name">icon-github</span><span class="i-code">0x67</span></li>
            <li title="Code: 0x68"><i class="icon-googleplay"></i> <span class="i-name">icon-googleplay</span><span class="i-code">0x68</span></li>
            <li title="Code: 0x69"><i class="icon-itunes"></i> <span class="i-name">icon-itunes</span><span class="i-code">0x69</span></li>
            <li title="Code: 0x6a"><i class="icon-plurk"></i> <span class="i-name">icon-plurk</span><span class="i-code">0x6a</span></li>
            <li title="Code: 0x6b"><i class="icon-songkick"></i> <span class="i-name">icon-songkick</span><span class="i-code">0x6b</span></li>
            <li title="Code: 0x6c"><i class="icon-lastfm"></i> <span class="i-name">icon-lastfm</span><span class="i-code">0x6c</span></li>
            <li title="Code: 0x6d"><i class="icon-gmail"></i> <span class="i-name">icon-gmail</span><span class="i-code">0x6d</span></li>
            <li title="Code: 0x6e"><i class="icon-pinboard"></i> <span class="i-name">icon-pinboard</span><span class="i-code">0x6e</span></li>
            <li title="Code: 0x6f"><i class="icon-openid"></i> <span class="i-name">icon-openid</span><span class="i-code">0x6f</span></li>
            <li title="Code: 0x71"><i class="icon-quora"></i> <span class="i-name">icon-quora</span><span class="i-code">0x71</span></li>
            <li title="Code: 0x73"><i class="icon-soundcloud"></i> <span class="i-name">icon-soundcloud</span><span class="i-code">0x73</span></li>
            <li title="Code: 0x74"><i class="icon-tumblr"></i> <span class="i-name">icon-tumblr</span><span class="i-code">0x74</span></li>
            <li title="Code: 0x76"><i class="icon-eventasaurus"></i> <span class="i-name">icon-eventasaurus</span><span class="i-code">0x76</span></li>
            <li title="Code: 0x77"><i class="icon-wordpress"></i> <span class="i-name">icon-wordpress</span><span class="i-code">0x77</span></li>
            <li title="Code: 0x79"><i class="icon-yelp"></i> <span class="i-name">icon-yelp</span><span class="i-code">0x79</span></li>
            <li title="Code: 0x7b"><i class="icon-intensedebate"></i> <span class="i-name">icon-intensedebate</span><span class="i-code">0x7b</span></li>
            <li title="Code: 0x7c"><i class="icon-eventbrite"></i> <span class="i-name">icon-eventbrite</span><span class="i-code">0x7c</span></li>
            <li title="Code: 0x7d"><i class="icon-scribd"></i> <span class="i-name">icon-scribd</span><span class="i-code">0x7d</span></li>
            <li title="Code: 0x7e"><i class="icon-posterous"></i> <span class="i-name">icon-posterous</span><span class="i-code">0x7e</span></li>
            <li title="Code: 0xa3"><i class="icon-stripe"></i> <span class="i-name">icon-stripe</span><span class="i-code">0xa3</span></li>
            <li title="Code: 0xc7"><i class="icon-opentable"></i> <span class="i-name">icon-opentable</span><span class="i-code">0xc7</span></li>
            <li title="Code: 0xc9"><i class="icon-cart"></i> <span class="i-name">icon-cart</span><span class="i-code">0xc9</span></li>
            <li title="Code: 0xd1"><i class="icon-print-1"></i> <span class="i-name">icon-print-1</span><span class="i-code">0xd1</span></li>
            <li title="Code: 0xd6"><i class="icon-angellist"></i> <span class="i-name">icon-angellist</span><span class="i-code">0xd6</span></li>
            <li title="Code: 0xdc"><i class="icon-instagram"></i> <span class="i-name">icon-instagram</span><span class="i-code">0xdc</span></li>
            <li title="Code: 0xe0"><i class="icon-dwolla"></i> <span class="i-name">icon-dwolla</span><span class="i-code">0xe0</span></li>
            <li title="Code: 0xe1"><i class="icon-appnet"></i> <span class="i-name">icon-appnet</span><span class="i-code">0xe1</span></li>
            <li title="Code: 0xe2"><i class="icon-statusnet"></i> <span class="i-name">icon-statusnet</span><span class="i-code">0xe2</span></li>
            <li title="Code: 0xe3"><i class="icon-acrobat"></i> <span class="i-name">icon-acrobat</span><span class="i-code">0xe3</span></li>
            <li title="Code: 0xe4"><i class="icon-drupal"></i> <span class="i-name">icon-drupal</span><span class="i-code">0xe4</span></li>
            <li title="Code: 0xe5"><i class="icon-buffer"></i> <span class="i-name">icon-buffer</span><span class="i-code">0xe5</span></li>
            <li title="Code: 0xe7"><i class="icon-pocket"></i> <span class="i-name">icon-pocket</span><span class="i-code">0xe7</span></li>
            <li title="Code: 0xe9"><i class="icon-bitbucket"></i> <span class="i-name">icon-bitbucket</span><span class="i-code">0xe9</span></li>
          </ul>';
                                                  
						   
						   $output .= '<input type="hidden" class="capture-input vibe-form-text vibe-input" name="' . $pkey . '" id="' . $pkey . '" value="' . (isset($param['std'])?$param['std']:'') . '" />' . "\n";
						   $output .= $row_end;	
							// append
							$this->append_output( $output );
                                                        break;
				}
			}
			
			// checks if has a child shortcode
			if( isset( $vibe_shortcodes[$this->popup]['child_shortcode'] ) )
			{
				// set child shortcode
				$this->cparams = $vibe_shortcodes[$this->popup]['child_shortcode']['params'];
				$this->cshortcode = $vibe_shortcodes[$this->popup]['child_shortcode']['shortcode'];
			
				// popup parent form row start
				$prow_start  = '<tbody>' . "\n";
				$prow_start .= '<tr class="form-row has-child">' . "\n";
				$prow_start .= '<td><a href="#" id="form-child-add" class="vibe-btn green">' . $vibe_shortcodes[$this->popup]['child_shortcode']['clone_button'] . '</a>' . "\n";
				$prow_start .= '<div class="child-clone-rows">' . "\n";
				
				// for js use
				$prow_start .= '<div id="_vibe_cshortcode" class="hidden">' . $this->cshortcode . '</div>' . "\n";
				
				// start the default row
				$prow_start .= '<div class="child-clone-row">' . "\n";
				$prow_start .= '<ul class="child-clone-row-form">' . "\n";
				
				// add $prow_start to output
				$this->append_output( $prow_start );
				
				foreach( $this->cparams as $cpkey => $cparam )
				{
				
					// prefix the fields names and ids with vibe_
					$cpkey = 'vibe_' . $cpkey;
					if(!isset($cparam['desc'])){$cparam['desc'] =''; }
					// popup form row start
					$crow_start  = '<li class="child-clone-row-form-row">' . "\n";
					$crow_start .= '<div class="child-clone-row-label">' . "\n";
					$crow_start .= '<label>' . $cparam['label'] . '</label>' . "\n";
					$crow_start .= '</div>' . "\n";
					$crow_start .= '<div class="child-clone-row-field">' . "\n";
					
					// popup form row end
					$crow_end	  = '<span class="child-clone-row-desc">' . $cparam['desc'] . '</span>' . "\n";
					$crow_end   .= '</div>' . "\n";
					$crow_end   .= '</li>' . "\n";
					
					switch( $cparam['type'] )
					{
						case 'text' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<input type="text" class="vibe-form-text vibe-cinput" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
							
						case 'textarea' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<textarea rows="10" cols="30" name="' . $cpkey . '" id="' . $cpkey . '" class="vibe-form-textarea vibe-cinput">' . $cparam['std'] . '</textarea>' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
							
						case 'select' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<select name="' . $cpkey . '" id="' . $cpkey . '" class="vibe-form-select vibe-cinput">' . "\n";
							
							foreach( $cparam['options'] as $value => $option )
							{
								$coutput .= '<option value="' . $value . '">' . $option . '</option>' . "\n";
							}
							
							$coutput .= '</select>' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
					case 'color' :
						
                                                        // prepare
							$coutput  = $crow_start;
							$coutput .= '<input type="text" class="vibe-form-text vibe-cinput popup-colorpicker" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;  
					 case 'slide' :
						
						// prepare
						$coutput  = $crow_start;
						$coutput .= '<input type="text" class="vibe-form-text vibe-input popup-slider" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
						$coutput .= '<div class="slider-range" data-min="' . $cparam['min'] . '" data-max="' . $cparam['max'] . '" data-std="' . $cparam['std'] . '"></div>';
                                                $coutput .= $crow_end;
						
						// append
						$this->append_output( $output );
						
						break; 
                                            
						case 'checkbox' :
							
							// prepare
							$coutput  = $crow_start;
							$coutput .= '<label for="' . $cpkey . '" class="vibe-form-checkbox">' . "\n";
							$coutput .= '<input type="checkbox" class="vibe-cinput" name="' . $cpkey . '" id="' . $cpkey . '" ' . ( $cparam['std'] ? 'checked' : '' ) . ' />' . "\n";
							$coutput .= ' ' . $cparam['checkbox_text'] . '</label>' . "\n";
							$coutput .= $crow_end;
							
							// append
							$this->append_output( $coutput );
							
							break;
                                                    
                                       case 'socialicon' :
                                                   $output  = $row_start;
                                                   $output .=' <ul class="the-icons unstyled">
            <li title="Code: 0x21"><i class="icon-duckduckgo"></i> <span class="i-name">icon-duckduckgo</span><span class="i-code">0x21</span></li>
            <li title="Code: 0x22"><i class="icon-aim"></i> <span class="i-name">icon-aim</span><span class="i-code">0x22</span></li>
            <li title="Code: 0x23"><i class="icon-delicious"></i> <span class="i-name">icon-delicious</span><span class="i-code">0x23</span></li>
            <li title="Code: 0x24"><i class="icon-paypal"></i> <span class="i-name">icon-paypal</span><span class="i-code">0x24</span></li>
            <li title="Code: 0x25"><i class="icon-flattr"></i> <span class="i-name">icon-flattr</span><span class="i-code">0x25</span></li>
            <li title="Code: 0x26"><i class="icon-android"></i> <span class="i-name">icon-android</span><span class="i-code">0x26</span></li>
            <li title="Code: 0x27"><i class="icon-eventful"></i> <span class="i-name">icon-eventful</span><span class="i-code">0x27</span></li>
            <li title="Code: 0x2a"><i class="icon-smashmag"></i> <span class="i-name">icon-smashmag</span><span class="i-code">0x2a</span></li>
            <li title="Code: 0xe800"><i class="icon-gplus"></i> <span class="i-name">icon-gplus</span><span class="i-code">0xe800</span></li>
            <li title="Code: 0x2c"><i class="icon-wikipedia"></i> <span class="i-name">icon-wikipedia</span><span class="i-code">0x2c</span></li>
            <li title="Code: 0xe801"><i class="icon-lanyrd"></i> <span class="i-name">icon-lanyrd</span><span class="i-code">0xe801</span></li>
            <li title="Code: 0x2f"><i class="icon-stumbleupon"></i> <span class="i-name">icon-stumbleupon</span><span class="i-code">0x2f</span></li>
            <li title="Code: 0x30"><i class="icon-fivehundredpx"></i> <span class="i-name">icon-fivehundredpx</span><span class="i-code">0x30</span></li>
            <li title="Code: 0x31"><i class="icon-pinterest"></i> <span class="i-name">icon-pinterest</span><span class="i-code">0x31</span></li>
            <li title="Code: 0x32"><i class="icon-bitcoin"></i> <span class="i-name">icon-bitcoin</span><span class="i-code">0x32</span></li>
            <li title="Code: 0x33"><i class="icon-w3c"></i> <span class="i-name">icon-w3c</span><span class="i-code">0x33</span></li>
            <li title="Code: 0x34"><i class="icon-foursquare"></i> <span class="i-name">icon-foursquare</span><span class="i-code">0x34</span></li>
            <li title="Code: 0x35"><i class="icon-html5"></i> <span class="i-name">icon-html5</span><span class="i-code">0x35</span></li>
            <li title="Code: 0x39"><i class="icon-ninetyninedesigns"></i> <span class="i-name">icon-ninetyninedesigns</span><span class="i-code">0x39</span></li>
            <li title="Code: 0x3a"><i class="icon-forrst"></i> <span class="i-name">icon-forrst</span><span class="i-code">0x3a</span></li>
            <li title="Code: 0x3b"><i class="icon-digg"></i> <span class="i-name">icon-digg</span><span class="i-code">0x3b</span></li>
            <li title="Code: 0x3d"><i class="icon-spotify"></i> <span class="i-name">icon-spotify</span><span class="i-code">0x3d</span></li>
            <li title="Code: 0x3e"><i class="icon-reddit"></i> <span class="i-name">icon-reddit</span><span class="i-code">0x3e</span></li>
            <li title="Code: 0x3f"><i class="icon-guest"></i> <span class="i-name">icon-guest</span><span class="i-code">0x3f</span></li>
            <li title="Code: 0x40"><i class="icon-gowalla"></i> <span class="i-name">icon-gowalla</span><span class="i-code">0x40</span></li>
            <li title="Code: 0x41"><i class="icon-appstore"></i> <span class="i-name">icon-appstore</span><span class="i-code">0x41</span></li>
            <li title="Code: 0x42"><i class="icon-blogger"></i> <span class="i-name">icon-blogger</span><span class="i-code">0x42</span></li>
            <li title="Code: 0x43"><i class="icon-cc-1"></i> <span class="i-name">icon-cc-1</span><span class="i-code">0x43</span></li>
            <li title="Code: 0x44"><i class="icon-dribbble"></i> <span class="i-name">icon-dribbble</span><span class="i-code">0x44</span></li>
            <li title="Code: 0x45"><i class="icon-evernote"></i> <span class="i-name">icon-evernote</span><span class="i-code">0x45</span></li>
            <li title="Code: 0x46"><i class="icon-flickr"></i> <span class="i-name">icon-flickr</span><span class="i-code">0x46</span></li>
            <li title="Code: 0x47"><i class="icon-google"></i> <span class="i-name">icon-google</span><span class="i-code">0x47</span></li>
            <li title="Code: 0x48"><i class="icon-viadeo"></i> <span class="i-name">icon-viadeo</span><span class="i-code">0x48</span></li>
            <li title="Code: 0x49"><i class="icon-instapaper"></i> <span class="i-name">icon-instapaper</span><span class="i-code">0x49</span></li>
            <li title="Code: 0x4a"><i class="icon-weibo"></i> <span class="i-name">icon-weibo</span><span class="i-code">0x4a</span></li>
            <li title="Code: 0x4b"><i class="icon-klout"></i> <span class="i-name">icon-klout</span><span class="i-code">0x4b</span></li>
            <li title="Code: 0x4c"><i class="icon-linkedin"></i> <span class="i-name">icon-linkedin</span><span class="i-code">0x4c</span></li>
            <li title="Code: 0x4d"><i class="icon-meetup"></i> <span class="i-name">icon-meetup</span><span class="i-code">0x4d</span></li>
            <li title="Code: 0x4e"><i class="icon-vk"></i> <span class="i-name">icon-vk</span><span class="i-code">0x4e</span></li>
            <li title="Code: 0x50"><i class="icon-plancast"></i> <span class="i-name">icon-plancast</span><span class="i-code">0x50</span></li>
            <li title="Code: 0x51"><i class="icon-disqus"></i> <span class="i-name">icon-disqus</span><span class="i-code">0x51</span></li>
            <li title="Code: 0x52"><i class="icon-rss-1"></i> <span class="i-name">icon-rss-1</span><span class="i-code">0x52</span></li>
            <li title="Code: 0x53"><i class="icon-skype"></i> <span class="i-name">icon-skype</span><span class="i-code">0x53</span></li>
            <li title="Code: 0x54"><i class="icon-twitter"></i> <span class="i-name">icon-twitter</span><span class="i-code">0x54</span></li>
            <li title="Code: 0x55"><i class="icon-youtube"></i> <span class="i-name">icon-youtube</span><span class="i-code">0x55</span></li>
            <li title="Code: 0x56"><i class="icon-vimeo"></i> <span class="i-name">icon-vimeo</span><span class="i-code">0x56</span></li>
            <li title="Code: 0x57"><i class="icon-windows"></i> <span class="i-name">icon-windows</span><span class="i-code">0x57</span></li>
            <li title="Code: 0x58"><i class="icon-xing"></i> <span class="i-name">icon-xing</span><span class="i-code">0x58</span></li>
            <li title="Code: 0x59"><i class="icon-yahoo"></i> <span class="i-name">icon-yahoo</span><span class="i-code">0x59</span></li>
            <li title="Code: 0x5b"><i class="icon-chrome-1"></i> <span class="i-name">icon-chrome-1</span><span class="i-code">0x5b</span></li>
            <li title="Code: 0x5d"><i class="icon-email"></i> <span class="i-name">icon-email</span><span class="i-code">0x5d</span></li>
            <li title="Code: 0x5e"><i class="icon-macstore"></i> <span class="i-name">icon-macstore</span><span class="i-code">0x5e</span></li>
            <li title="Code: 0x5f"><i class="icon-myspace"></i> <span class="i-name">icon-myspace</span><span class="i-code">0x5f</span></li>
            <li title="Code: 0x60"><i class="icon-podcast"></i> <span class="i-name">icon-podcast</span><span class="i-code">0x60</span></li>
            <li title="Code: 0x61"><i class="icon-amazon"></i> <span class="i-name">icon-amazon</span><span class="i-code">0x61</span></li>
            <li title="Code: 0x62"><i class="icon-steam"></i> <span class="i-name">icon-steam</span><span class="i-code">0x62</span></li>
            <li title="Code: 0x63"><i class="icon-cloudapp"></i> <span class="i-name">icon-cloudapp</span><span class="i-code">0x63</span></li>
            <li title="Code: 0x64"><i class="icon-dropbox"></i> <span class="i-name">icon-dropbox</span><span class="i-code">0x64</span></li>
            <li title="Code: 0x65"><i class="icon-ebay"></i> <span class="i-name">icon-ebay</span><span class="i-code">0x65</span></li>
            <li title="Code: 0x66"><i class="icon-facebook"></i> <span class="i-name">icon-facebook</span><span class="i-code">0x66</span></li>
            <li title="Code: 0x67"><i class="icon-github"></i> <span class="i-name">icon-github</span><span class="i-code">0x67</span></li>
            <li title="Code: 0x68"><i class="icon-googleplay"></i> <span class="i-name">icon-googleplay</span><span class="i-code">0x68</span></li>
            <li title="Code: 0x69"><i class="icon-itunes"></i> <span class="i-name">icon-itunes</span><span class="i-code">0x69</span></li>
            <li title="Code: 0x6a"><i class="icon-plurk"></i> <span class="i-name">icon-plurk</span><span class="i-code">0x6a</span></li>
            <li title="Code: 0x6b"><i class="icon-songkick"></i> <span class="i-name">icon-songkick</span><span class="i-code">0x6b</span></li>
            <li title="Code: 0x6c"><i class="icon-lastfm"></i> <span class="i-name">icon-lastfm</span><span class="i-code">0x6c</span></li>
            <li title="Code: 0x6d"><i class="icon-gmail"></i> <span class="i-name">icon-gmail</span><span class="i-code">0x6d</span></li>
            <li title="Code: 0x6e"><i class="icon-pinboard"></i> <span class="i-name">icon-pinboard</span><span class="i-code">0x6e</span></li>
            <li title="Code: 0x6f"><i class="icon-openid"></i> <span class="i-name">icon-openid</span><span class="i-code">0x6f</span></li>
            <li title="Code: 0x71"><i class="icon-quora"></i> <span class="i-name">icon-quora</span><span class="i-code">0x71</span></li>
            <li title="Code: 0x73"><i class="icon-soundcloud"></i> <span class="i-name">icon-soundcloud</span><span class="i-code">0x73</span></li>
            <li title="Code: 0x74"><i class="icon-tumblr"></i> <span class="i-name">icon-tumblr</span><span class="i-code">0x74</span></li>
            <li title="Code: 0x76"><i class="icon-eventasaurus"></i> <span class="i-name">icon-eventasaurus</span><span class="i-code">0x76</span></li>
            <li title="Code: 0x77"><i class="icon-wordpress"></i> <span class="i-name">icon-wordpress</span><span class="i-code">0x77</span></li>
            <li title="Code: 0x79"><i class="icon-yelp"></i> <span class="i-name">icon-yelp</span><span class="i-code">0x79</span></li>
            <li title="Code: 0x7b"><i class="icon-intensedebate"></i> <span class="i-name">icon-intensedebate</span><span class="i-code">0x7b</span></li>
            <li title="Code: 0x7c"><i class="icon-eventbrite"></i> <span class="i-name">icon-eventbrite</span><span class="i-code">0x7c</span></li>
            <li title="Code: 0x7d"><i class="icon-scribd"></i> <span class="i-name">icon-scribd</span><span class="i-code">0x7d</span></li>
            <li title="Code: 0x7e"><i class="icon-posterous"></i> <span class="i-name">icon-posterous</span><span class="i-code">0x7e</span></li>
            <li title="Code: 0xa3"><i class="icon-stripe"></i> <span class="i-name">icon-stripe</span><span class="i-code">0xa3</span></li>
            <li title="Code: 0xc7"><i class="icon-opentable"></i> <span class="i-name">icon-opentable</span><span class="i-code">0xc7</span></li>
            <li title="Code: 0xc9"><i class="icon-cart"></i> <span class="i-name">icon-cart</span><span class="i-code">0xc9</span></li>
            <li title="Code: 0xd1"><i class="icon-print-1"></i> <span class="i-name">icon-print-1</span><span class="i-code">0xd1</span></li>
            <li title="Code: 0xd6"><i class="icon-angellist"></i> <span class="i-name">icon-angellist</span><span class="i-code">0xd6</span></li>
            <li title="Code: 0xdc"><i class="icon-instagram"></i> <span class="i-name">icon-instagram</span><span class="i-code">0xdc</span></li>
            <li title="Code: 0xe0"><i class="icon-dwolla"></i> <span class="i-name">icon-dwolla</span><span class="i-code">0xe0</span></li>
            <li title="Code: 0xe1"><i class="icon-appnet"></i> <span class="i-name">icon-appnet</span><span class="i-code">0xe1</span></li>
            <li title="Code: 0xe2"><i class="icon-statusnet"></i> <span class="i-name">icon-statusnet</span><span class="i-code">0xe2</span></li>
            <li title="Code: 0xe3"><i class="icon-acrobat"></i> <span class="i-name">icon-acrobat</span><span class="i-code">0xe3</span></li>
            <li title="Code: 0xe4"><i class="icon-drupal"></i> <span class="i-name">icon-drupal</span><span class="i-code">0xe4</span></li>
            <li title="Code: 0xe5"><i class="icon-buffer"></i> <span class="i-name">icon-buffer</span><span class="i-code">0xe5</span></li>
            <li title="Code: 0xe7"><i class="icon-pocket"></i> <span class="i-name">icon-pocket</span><span class="i-code">0xe7</span></li>
            <li title="Code: 0xe9"><i class="icon-bitbucket"></i> <span class="i-name">icon-bitbucket</span><span class="i-code">0xe9</span></li>
          </ul>';
                                                case 'icon' :
                                                     $coutput  = $crow_start;
                                                   $coutput .='<ul class="the-icons unstyled">
            <li title="Code: 0x21"><i class="icon-duckduckgo"></i> <span class="i-name">icon-duckduckgo</span><span class="i-code">0x21</span></li>
            <li title="Code: 0x22"><i class="icon-aim"></i> <span class="i-name">icon-aim</span><span class="i-code">0x22</span></li>
            <li title="Code: 0x23"><i class="icon-delicious"></i> <span class="i-name">icon-delicious</span><span class="i-code">0x23</span></li>
            <li title="Code: 0x24"><i class="icon-paypal"></i> <span class="i-name">icon-paypal</span><span class="i-code">0x24</span></li>
            <li title="Code: 0x25"><i class="icon-flattr"></i> <span class="i-name">icon-flattr</span><span class="i-code">0x25</span></li>
            <li title="Code: 0x26"><i class="icon-android"></i> <span class="i-name">icon-android</span><span class="i-code">0x26</span></li>
            <li title="Code: 0x27"><i class="icon-eventful"></i> <span class="i-name">icon-eventful</span><span class="i-code">0x27</span></li>
            <li title="Code: 0x2a"><i class="icon-smashmag"></i> <span class="i-name">icon-smashmag</span><span class="i-code">0x2a</span></li>
            <li title="Code: 0xe800"><i class="icon-gplus"></i> <span class="i-name">icon-gplus</span><span class="i-code">0xe800</span></li>
            <li title="Code: 0x2c"><i class="icon-wikipedia"></i> <span class="i-name">icon-wikipedia</span><span class="i-code">0x2c</span></li>
            <li title="Code: 0xe801"><i class="icon-lanyrd"></i> <span class="i-name">icon-lanyrd</span><span class="i-code">0xe801</span></li>
            <li title="Code: 0x2e"><i class="icon-calendar-1"></i> <span class="i-name">icon-calendar-1</span><span class="i-code">0x2e</span></li>
            <li title="Code: 0x2f"><i class="icon-stumbleupon"></i> <span class="i-name">icon-stumbleupon</span><span class="i-code">0x2f</span></li>
            <li title="Code: 0x30"><i class="icon-fivehundredpx"></i> <span class="i-name">icon-fivehundredpx</span><span class="i-code">0x30</span></li>
            <li title="Code: 0x31"><i class="icon-pinterest"></i> <span class="i-name">icon-pinterest</span><span class="i-code">0x31</span></li>
            <li title="Code: 0x32"><i class="icon-bitcoin"></i> <span class="i-name">icon-bitcoin</span><span class="i-code">0x32</span></li>
            <li title="Code: 0x33"><i class="icon-w3c"></i> <span class="i-name">icon-w3c</span><span class="i-code">0x33</span></li>
            <li title="Code: 0x34"><i class="icon-foursquare"></i> <span class="i-name">icon-foursquare</span><span class="i-code">0x34</span></li>
            <li title="Code: 0x35"><i class="icon-html5"></i> <span class="i-name">icon-html5</span><span class="i-code">0x35</span></li>
            <li title="Code: 0x36"><i class="icon-ie-1"></i> <span class="i-name">icon-ie-1</span><span class="i-code">0x36</span></li>
            <li title="Code: 0x37"><i class="icon-call"></i> <span class="i-name">icon-call</span><span class="i-code">0x37</span></li>
            <li title="Code: 0x38"><i class="icon-grooveshark"></i> <span class="i-name">icon-grooveshark</span><span class="i-code">0x38</span></li>
            <li title="Code: 0x39"><i class="icon-ninetyninedesigns"></i> <span class="i-name">icon-ninetyninedesigns</span><span class="i-code">0x39</span></li>
            <li title="Code: 0x3a"><i class="icon-forrst"></i> <span class="i-name">icon-forrst</span><span class="i-code">0x3a</span></li>
            <li title="Code: 0x3b"><i class="icon-digg"></i> <span class="i-name">icon-digg</span><span class="i-code">0x3b</span></li>
            <li title="Code: 0x3d"><i class="icon-spotify"></i> <span class="i-name">icon-spotify</span><span class="i-code">0x3d</span></li>
            <li title="Code: 0x3e"><i class="icon-reddit"></i> <span class="i-name">icon-reddit</span><span class="i-code">0x3e</span></li>
            <li title="Code: 0x3f"><i class="icon-guest"></i> <span class="i-name">icon-guest</span><span class="i-code">0x3f</span></li>
            <li title="Code: 0x40"><i class="icon-gowalla"></i> <span class="i-name">icon-gowalla</span><span class="i-code">0x40</span></li>
            <li title="Code: 0x41"><i class="icon-appstore"></i> <span class="i-name">icon-appstore</span><span class="i-code">0x41</span></li>
            <li title="Code: 0x42"><i class="icon-blogger"></i> <span class="i-name">icon-blogger</span><span class="i-code">0x42</span></li>
            <li title="Code: 0x43"><i class="icon-cc-1"></i> <span class="i-name">icon-cc-1</span><span class="i-code">0x43</span></li>
            <li title="Code: 0x44"><i class="icon-dribbble"></i> <span class="i-name">icon-dribbble</span><span class="i-code">0x44</span></li>
            <li title="Code: 0x45"><i class="icon-evernote"></i> <span class="i-name">icon-evernote</span><span class="i-code">0x45</span></li>
            <li title="Code: 0x46"><i class="icon-flickr"></i> <span class="i-name">icon-flickr</span><span class="i-code">0x46</span></li>
            <li title="Code: 0x47"><i class="icon-google"></i> <span class="i-name">icon-google</span><span class="i-code">0x47</span></li>
            <li title="Code: 0x48"><i class="icon-viadeo"></i> <span class="i-name">icon-viadeo</span><span class="i-code">0x48</span></li>
            <li title="Code: 0x49"><i class="icon-instapaper"></i> <span class="i-name">icon-instapaper</span><span class="i-code">0x49</span></li>
            <li title="Code: 0x4a"><i class="icon-weibo"></i> <span class="i-name">icon-weibo</span><span class="i-code">0x4a</span></li>
            <li title="Code: 0x4b"><i class="icon-klout"></i> <span class="i-name">icon-klout</span><span class="i-code">0x4b</span></li>
            <li title="Code: 0x4c"><i class="icon-linkedin"></i> <span class="i-name">icon-linkedin</span><span class="i-code">0x4c</span></li>
            <li title="Code: 0x4d"><i class="icon-meetup"></i> <span class="i-name">icon-meetup</span><span class="i-code">0x4d</span></li>
            <li title="Code: 0x4e"><i class="icon-vk"></i> <span class="i-name">icon-vk</span><span class="i-code">0x4e</span></li>
            <li title="Code: 0x50"><i class="icon-plancast"></i> <span class="i-name">icon-plancast</span><span class="i-code">0x50</span></li>
            <li title="Code: 0x51"><i class="icon-disqus"></i> <span class="i-name">icon-disqus</span><span class="i-code">0x51</span></li>
            <li title="Code: 0x52"><i class="icon-rss-1"></i> <span class="i-name">icon-rss-1</span><span class="i-code">0x52</span></li>
            <li title="Code: 0x53"><i class="icon-skype"></i> <span class="i-name">icon-skype</span><span class="i-code">0x53</span></li>
            <li title="Code: 0x54"><i class="icon-twitter"></i> <span class="i-name">icon-twitter</span><span class="i-code">0x54</span></li>
            <li title="Code: 0x55"><i class="icon-youtube"></i> <span class="i-name">icon-youtube</span><span class="i-code">0x55</span></li>
            <li title="Code: 0x56"><i class="icon-vimeo"></i> <span class="i-name">icon-vimeo</span><span class="i-code">0x56</span></li>
            <li title="Code: 0x57"><i class="icon-windows"></i> <span class="i-name">icon-windows</span><span class="i-code">0x57</span></li>
            <li title="Code: 0x58"><i class="icon-xing"></i> <span class="i-name">icon-xing</span><span class="i-code">0x58</span></li>
            <li title="Code: 0x59"><i class="icon-yahoo"></i> <span class="i-name">icon-yahoo</span><span class="i-code">0x59</span></li>
            <li title="Code: 0x5b"><i class="icon-chrome-1"></i> <span class="i-name">icon-chrome-1</span><span class="i-code">0x5b</span></li>
            <li title="Code: 0x5d"><i class="icon-email"></i> <span class="i-name">icon-email</span><span class="i-code">0x5d</span></li>
            <li title="Code: 0x5e"><i class="icon-macstore"></i> <span class="i-name">icon-macstore</span><span class="i-code">0x5e</span></li>
            <li title="Code: 0x5f"><i class="icon-myspace"></i> <span class="i-name">icon-myspace</span><span class="i-code">0x5f</span></li>
            <li title="Code: 0x60"><i class="icon-podcast"></i> <span class="i-name">icon-podcast</span><span class="i-code">0x60</span></li>
            <li title="Code: 0x61"><i class="icon-amazon"></i> <span class="i-name">icon-amazon</span><span class="i-code">0x61</span></li>
            <li title="Code: 0x62"><i class="icon-steam"></i> <span class="i-name">icon-steam</span><span class="i-code">0x62</span></li>
            <li title="Code: 0x63"><i class="icon-cloudapp"></i> <span class="i-name">icon-cloudapp</span><span class="i-code">0x63</span></li>
            <li title="Code: 0x64"><i class="icon-dropbox"></i> <span class="i-name">icon-dropbox</span><span class="i-code">0x64</span></li>
            <li title="Code: 0x65"><i class="icon-ebay"></i> <span class="i-name">icon-ebay</span><span class="i-code">0x65</span></li>
            <li title="Code: 0x66"><i class="icon-facebook"></i> <span class="i-name">icon-facebook</span><span class="i-code">0x66</span></li>
            <li title="Code: 0x67"><i class="icon-github"></i> <span class="i-name">icon-github</span><span class="i-code">0x67</span></li>
            <li title="Code: 0x68"><i class="icon-googleplay"></i> <span class="i-name">icon-googleplay</span><span class="i-code">0x68</span></li>
            <li title="Code: 0x69"><i class="icon-itunes"></i> <span class="i-name">icon-itunes</span><span class="i-code">0x69</span></li>
            <li title="Code: 0x6a"><i class="icon-plurk"></i> <span class="i-name">icon-plurk</span><span class="i-code">0x6a</span></li>
            <li title="Code: 0x6b"><i class="icon-songkick"></i> <span class="i-name">icon-songkick</span><span class="i-code">0x6b</span></li>
            <li title="Code: 0x6c"><i class="icon-lastfm"></i> <span class="i-name">icon-lastfm</span><span class="i-code">0x6c</span></li>
            <li title="Code: 0x6d"><i class="icon-gmail"></i> <span class="i-name">icon-gmail</span><span class="i-code">0x6d</span></li>
            <li title="Code: 0x6e"><i class="icon-pinboard"></i> <span class="i-name">icon-pinboard</span><span class="i-code">0x6e</span></li>
            <li title="Code: 0x6f"><i class="icon-openid"></i> <span class="i-name">icon-openid</span><span class="i-code">0x6f</span></li>
            <li title="Code: 0x71"><i class="icon-quora"></i> <span class="i-name">icon-quora</span><span class="i-code">0x71</span></li>
            <li title="Code: 0x73"><i class="icon-soundcloud"></i> <span class="i-name">icon-soundcloud</span><span class="i-code">0x73</span></li>
            <li title="Code: 0x74"><i class="icon-tumblr"></i> <span class="i-name">icon-tumblr</span><span class="i-code">0x74</span></li>
            <li title="Code: 0x76"><i class="icon-eventasaurus"></i> <span class="i-name">icon-eventasaurus</span><span class="i-code">0x76</span></li>
            <li title="Code: 0x77"><i class="icon-wordpress"></i> <span class="i-name">icon-wordpress</span><span class="i-code">0x77</span></li>
            <li title="Code: 0x79"><i class="icon-yelp"></i> <span class="i-name">icon-yelp</span><span class="i-code">0x79</span></li>
            <li title="Code: 0x7b"><i class="icon-intensedebate"></i> <span class="i-name">icon-intensedebate</span><span class="i-code">0x7b</span></li>
            <li title="Code: 0x7c"><i class="icon-eventbrite"></i> <span class="i-name">icon-eventbrite</span><span class="i-code">0x7c</span></li>
            <li title="Code: 0x7d"><i class="icon-scribd"></i> <span class="i-name">icon-scribd</span><span class="i-code">0x7d</span></li>
            <li title="Code: 0x7e"><i class="icon-posterous"></i> <span class="i-name">icon-posterous</span><span class="i-code">0x7e</span></li>
            <li title="Code: 0xa3"><i class="icon-stripe"></i> <span class="i-name">icon-stripe</span><span class="i-code">0xa3</span></li>
            <li title="Code: 0xc7"><i class="icon-opentable"></i> <span class="i-name">icon-opentable</span><span class="i-code">0xc7</span></li>
            <li title="Code: 0xc9"><i class="icon-cart"></i> <span class="i-name">icon-cart</span><span class="i-code">0xc9</span></li>
            <li title="Code: 0xd1"><i class="icon-print-1"></i> <span class="i-name">icon-print-1</span><span class="i-code">0xd1</span></li>
            <li title="Code: 0xd6"><i class="icon-angellist"></i> <span class="i-name">icon-angellist</span><span class="i-code">0xd6</span></li>
            <li title="Code: 0xdc"><i class="icon-instagram"></i> <span class="i-name">icon-instagram</span><span class="i-code">0xdc</span></li>
            <li title="Code: 0xe0"><i class="icon-dwolla"></i> <span class="i-name">icon-dwolla</span><span class="i-code">0xe0</span></li>
            <li title="Code: 0xe1"><i class="icon-appnet"></i> <span class="i-name">icon-appnet</span><span class="i-code">0xe1</span></li>
            <li title="Code: 0xe2"><i class="icon-statusnet"></i> <span class="i-name">icon-statusnet</span><span class="i-code">0xe2</span></li>
            <li title="Code: 0xe3"><i class="icon-acrobat"></i> <span class="i-name">icon-acrobat</span><span class="i-code">0xe3</span></li>
            <li title="Code: 0xe4"><i class="icon-drupal"></i> <span class="i-name">icon-drupal</span><span class="i-code">0xe4</span></li>
            <li title="Code: 0xe5"><i class="icon-buffer"></i> <span class="i-name">icon-buffer</span><span class="i-code">0xe5</span></li>
            <li title="Code: 0xe7"><i class="icon-pocket"></i> <span class="i-name">icon-pocket</span><span class="i-code">0xe7</span></li>
            <li title="Code: 0xe9"><i class="icon-bitbucket"></i> <span class="i-name">icon-bitbucket</span><span class="i-code">0xe9</span></li>
            <li title="Code: 0x2190"><i class="icon-left-thin"></i> <span class="i-name">icon-left-thin</span><span class="i-code">0x2190</span></li>
            <li title="Code: 0x2191"><i class="icon-up-thin"></i> <span class="i-name">icon-up-thin</span><span class="i-code">0x2191</span></li>
            <li title="Code: 0x2192"><i class="icon-right-thin"></i> <span class="i-name">icon-right-thin</span><span class="i-code">0x2192</span></li>
            <li title="Code: 0x2193"><i class="icon-down-thin"></i> <span class="i-name">icon-down-thin</span><span class="i-code">0x2193</span></li>
            <li title="Code: 0x21b0"><i class="icon-level-up"></i> <span class="i-name">icon-level-up</span><span class="i-code">0x21b0</span></li>
            <li title="Code: 0x21b3"><i class="icon-level-down"></i> <span class="i-name">icon-level-down</span><span class="i-code">0x21b3</span></li>
            <li title="Code: 0x21c6"><i class="icon-switch"></i> <span class="i-name">icon-switch</span><span class="i-code">0x21c6</span></li>
            <li title="Code: 0x221e"><i class="icon-infinity"></i> <span class="i-name">icon-infinity</span><span class="i-code">0x221e</span></li>
            <li title="Code: 0x2302"><i class="icon-home"></i> <span class="i-name">icon-home</span><span class="i-code">0x2302</span></li>
            <li title="Code: 0x2328"><i class="icon-keyboard"></i> <span class="i-name">icon-keyboard</span><span class="i-code">0x2328</span></li>
            <li title="Code: 0x232b"><i class="icon-erase"></i> <span class="i-name">icon-erase</span><span class="i-code">0x232b</span></li>
            <li title="Code: 0x23f3"><i class="icon-hourglass"></i> <span class="i-name">icon-hourglass</span><span class="i-code">0x23f3</span></li>
            <li title="Code: 0x25b8"><i class="icon-right-dir"></i> <span class="i-name">icon-right-dir</span><span class="i-code">0x25b8</span></li>
            <li title="Code: 0x25d1"><i class="icon-adjust"></i> <span class="i-name">icon-adjust</span><span class="i-code">0x25d1</span></li>
            <li title="Code: 0x2601"><i class="icon-cloud"></i> <span class="i-name">icon-cloud</span><span class="i-code">0x2601</span></li>
            <li title="Code: 0xe832"><i class="icon-cloud-1"></i> <span class="i-name">icon-cloud-1</span><span class="i-code">0xe832</span></li>
            <li title="Code: 0x2602"><i class="icon-umbrella"></i> <span class="i-name">icon-umbrella</span><span class="i-code">0x2602</span></li>
            <li title="Code: 0x2605"><i class="icon-star"></i> <span class="i-name">icon-star</span><span class="i-code">0x2605</span></li>
            <li title="Code: 0x2606"><i class="icon-star-empty"></i> <span class="i-name">icon-star-empty</span><span class="i-code">0x2606</span></li>
            <li title="Code: 0x2611"><i class="icon-check-1"></i> <span class="i-name">icon-check-1</span><span class="i-code">0x2611</span></li>
            <li title="Code: 0x2615"><i class="icon-cup"></i> <span class="i-name">icon-cup</span><span class="i-code">0x2615</span></li>
            <li title="Code: 0x2630"><i class="icon-menu"></i> <span class="i-name">icon-menu</span><span class="i-code">0x2630</span></li>
            <li title="Code: 0x263d"><i class="icon-moon"></i> <span class="i-name">icon-moon</span><span class="i-code">0x263d</span></li>
            <li title="Code: 0x2661"><i class="icon-heart-empty"></i> <span class="i-name">icon-heart-empty</span><span class="i-code">0x2661</span></li>
            <li title="Code: 0x2665"><i class="icon-heart"></i> <span class="i-name">icon-heart</span><span class="i-code">0x2665</span></li>
            <li title="Code: 0x266a"><i class="icon-note"></i> <span class="i-name">icon-note</span><span class="i-code">0x266a</span></li>
            <li title="Code: 0x266b"><i class="icon-note-beamed"></i> <span class="i-name">icon-note-beamed</span><span class="i-code">0x266b</span></li>
            <li title="Code: 0x268f"><i class="icon-layout"></i> <span class="i-name">icon-layout</span><span class="i-code">0x268f</span></li>
            <li title="Code: 0x2691"><i class="icon-flag"></i> <span class="i-name">icon-flag</span><span class="i-code">0x2691</span></li>
            <li title="Code: 0x2692"><i class="icon-tools"></i> <span class="i-name">icon-tools</span><span class="i-code">0x2692</span></li>
            <li title="Code: 0x2699"><i class="icon-cog"></i> <span class="i-name">icon-cog</span><span class="i-code">0x2699</span></li>
            <li title="Code: 0xe86a"><i class="icon-cog-1"></i> <span class="i-name">icon-cog-1</span><span class="i-code">0xe86a</span></li>
            <li title="Code: 0x26a0"><i class="icon-attention"></i> <span class="i-name">icon-attention</span><span class="i-code">0x26a0</span></li>
            <li title="Code: 0xe864"><i class="icon-attention-1"></i> <span class="i-name">icon-attention-1</span><span class="i-code">0xe864</span></li>
            <li title="Code: 0x26a1"><i class="icon-flash"></i> <span class="i-name">icon-flash</span><span class="i-code">0x26a1</span></li>
            <li title="Code: 0xe81b"><i class="icon-flash-1"></i> <span class="i-name">icon-flash-1</span><span class="i-code">0xe81b</span></li>
            <li title="Code: 0x26c8"><i class="icon-cloud-thunder"></i> <span class="i-name">icon-cloud-thunder</span><span class="i-code">0x26c8</span></li>
            <li title="Code: 0x26ef"><i class="icon-cog-alt"></i> <span class="i-name">icon-cog-alt</span><span class="i-code">0x26ef</span></li>
            <li title="Code: 0x2702"><i class="icon-scissors"></i> <span class="i-name">icon-scissors</span><span class="i-code">0x2702</span></li>
            <li title="Code: 0x2707"><i class="icon-tape"></i> <span class="i-name">icon-tape</span><span class="i-code">0x2707</span></li>
            <li title="Code: 0x2708"><i class="icon-flight"></i> <span class="i-name">icon-flight</span><span class="i-code">0x2708</span></li>
            <li title="Code: 0xe81c"><i class="icon-flight-1"></i> <span class="i-name">icon-flight-1</span><span class="i-code">0xe81c</span></li>
            <li title="Code: 0x2709"><i class="icon-mail"></i> <span class="i-name">icon-mail</span><span class="i-code">0x2709</span></li>
            <li title="Code: 0xe877"><i class="icon-mail-2"></i> <span class="i-name">icon-mail-2</span><span class="i-code">0xe877</span></li>
            <li title="Code: 0x270e"><i class="icon-pencil"></i> <span class="i-name">icon-pencil</span><span class="i-code">0x270e</span></li>
            <li title="Code: 0x2712"><i class="icon-feather"></i> <span class="i-name">icon-feather</span><span class="i-code">0x2712</span></li>
            <li title="Code: 0x2713"><i class="icon-check"></i> <span class="i-name">icon-check</span><span class="i-code">0x2713</span></li>
            <li title="Code: 0xe879"><i class="icon-ok-1"></i> <span class="i-name">icon-ok-1</span><span class="i-code">0xe879</span></li>
            <li title="Code: 0x2715"><i class="icon-cancel"></i> <span class="i-name">icon-cancel</span><span class="i-code">0x2715</span></li>
            <li title="Code: 0xe87a"><i class="icon-cancel-2"></i> <span class="i-name">icon-cancel-2</span><span class="i-code">0xe87a</span></li>
            <li title="Code: 0x2731"><i class="icon-asterisk"></i> <span class="i-name">icon-asterisk</span><span class="i-code">0x2731</span></li>
            <li title="Code: 0x2757"><i class="icon-attention-circle"></i> <span class="i-name">icon-attention-circle</span><span class="i-code">0x2757</span></li>
            <li title="Code: 0x27a1"><i class="icon-right"></i> <span class="i-name">icon-right</span><span class="i-code">0x27a1</span></li>
            <li title="Code: 0x27a2"><i class="icon-direction"></i> <span class="i-name">icon-direction</span><span class="i-code">0x27a2</span></li>
            <li title="Code: 0x27f2"><i class="icon-ccw"></i> <span class="i-name">icon-ccw</span><span class="i-code">0x27f2</span></li>
            <li title="Code: 0x27f3"><i class="icon-cw"></i> <span class="i-name">icon-cw</span><span class="i-code">0x27f3</span></li>
            <li title="Code: 0x2b05"><i class="icon-left"></i> <span class="i-name">icon-left</span><span class="i-code">0x2b05</span></li>
            <li title="Code: 0x2b06"><i class="icon-up"></i> <span class="i-name">icon-up</span><span class="i-code">0x2b06</span></li>
            <li title="Code: 0x2b07"><i class="icon-down"></i> <span class="i-name">icon-down</span><span class="i-code">0x2b07</span></li>
            <li title="Code: 0xe003"><i class="icon-list-add"></i> <span class="i-name">icon-list-add</span><span class="i-code">0xe003</span></li>
            <li title="Code: 0xe005"><i class="icon-list"></i> <span class="i-name">icon-list</span><span class="i-code">0xe005</span></li>
            <li title="Code: 0xe071"><i class="icon-off-1"></i> <span class="i-name">icon-off-1</span><span class="i-code">0xe071</span></li>
            <li title="Code: 0xe700"><i class="icon-user-add"></i> <span class="i-name">icon-user-add</span><span class="i-code">0xe700</span></li>
            <li title="Code: 0xe704"><i class="icon-help-circled"></i> <span class="i-name">icon-help-circled</span><span class="i-code">0xe704</span></li>
            <li title="Code: 0xe705"><i class="icon-info-circled"></i> <span class="i-name">icon-info-circled</span><span class="i-code">0xe705</span></li>
            <li title="Code: 0xe876"><i class="icon-eye-2"></i> <span class="i-name">icon-eye-2</span><span class="i-code">0xe876</span></li>
            <li title="Code: 0xe70c"><i class="icon-tag"></i> <span class="i-name">icon-tag</span><span class="i-code">0xe70c</span></li>
            <li title="Code: 0xe803"><i class="icon-tag-1"></i> <span class="i-name">icon-tag-1</span><span class="i-code">0xe803</span></li>
            <li title="Code: 0xe711"><i class="icon-upload-cloud"></i> <span class="i-name">icon-upload-cloud</span><span class="i-code">0xe711</span></li>
            <li title="Code: 0xe715"><i class="icon-export"></i> <span class="i-name">icon-export</span><span class="i-code">0xe715</span></li>
            <li title="Code: 0xe716"><i class="icon-print"></i> <span class="i-name">icon-print</span><span class="i-code">0xe716</span></li>
            <li title="Code: 0xe717"><i class="icon-retweet"></i> <span class="i-name">icon-retweet</span><span class="i-code">0xe717</span></li>
            <li title="Code: 0xe718"><i class="icon-comment"></i> <span class="i-name">icon-comment</span><span class="i-code">0xe718</span></li>
            <li title="Code: 0xe861"><i class="icon-comment-1"></i> <span class="i-name">icon-comment-1</span><span class="i-code">0xe861</span></li>
            <li title="Code: 0xe802"><i class="icon-comment-2"></i> <span class="i-name">icon-comment-2</span><span class="i-code">0xe802</span></li>
            <li title="Code: 0xe720"><i class="icon-chat"></i> <span class="i-name">icon-chat</span><span class="i-code">0xe720</span></li>
            <li title="Code: 0xe862"><i class="icon-chat-1"></i> <span class="i-name">icon-chat-1</span><span class="i-code">0xe862</span></li>
            <li title="Code: 0xe722"><i class="icon-vcard"></i> <span class="i-name">icon-vcard</span><span class="i-code">0xe722</span></li>
            <li title="Code: 0xe723"><i class="icon-address"></i> <span class="i-name">icon-address</span><span class="i-code">0xe723</span></li>
            <li title="Code: 0xe724"><i class="icon-location"></i> <span class="i-name">icon-location</span><span class="i-code">0xe724</span></li>
            <li title="Code: 0xe865"><i class="icon-location-1"></i> <span class="i-name">icon-location-1</span><span class="i-code">0xe865</span></li>
            <li title="Code: 0xe878"><i class="icon-location-2"></i> <span class="i-name">icon-location-2</span><span class="i-code">0xe878</span></li>
            <li title="Code: 0xe727"><i class="icon-map"></i> <span class="i-name">icon-map</span><span class="i-code">0xe727</span></li>
            <li title="Code: 0xe728"><i class="icon-compass"></i> <span class="i-name">icon-compass</span><span class="i-code">0xe728</span></li>
            <li title="Code: 0xe729"><i class="icon-trash"></i> <span class="i-name">icon-trash</span><span class="i-code">0xe729</span></li>
            <li title="Code: 0xe730"><i class="icon-doc"></i> <span class="i-name">icon-doc</span><span class="i-code">0xe730</span></li>
            <li title="Code: 0xe731"><i class="icon-doc-text-inv"></i> <span class="i-name">icon-doc-text-inv</span><span class="i-code">0xe731</span></li>
            <li title="Code: 0xe736"><i class="icon-docs"></i> <span class="i-name">icon-docs</span><span class="i-code">0xe736</span></li>
            <li title="Code: 0xe737"><i class="icon-doc-landscape"></i> <span class="i-name">icon-doc-landscape</span><span class="i-code">0xe737</span></li>
            <li title="Code: 0xe738"><i class="icon-archive"></i> <span class="i-name">icon-archive</span><span class="i-code">0xe738</span></li>
            <li title="Code: 0xe73c"><i class="icon-share"></i> <span class="i-name">icon-share</span><span class="i-code">0xe73c</span></li>
            <li title="Code: 0xe73d"><i class="icon-basket"></i> <span class="i-name">icon-basket</span><span class="i-code">0xe73d</span></li>
            <li title="Code: 0xe86b"><i class="icon-basket-1"></i> <span class="i-name">icon-basket-1</span><span class="i-code">0xe86b</span></li>
            <li title="Code: 0xe875"><i class="icon-basket-2"></i> <span class="i-name">icon-basket-2</span><span class="i-code">0xe875</span></li>
            <li title="Code: 0xe73e"><i class="icon-shareable"></i> <span class="i-name">icon-shareable</span><span class="i-code">0xe73e</span></li>
            <li title="Code: 0xe740"><i class="icon-login"></i> <span class="i-name">icon-login</span><span class="i-code">0xe740</span></li>
            <li title="Code: 0xe86d"><i class="icon-login-1"></i> <span class="i-name">icon-login-1</span><span class="i-code">0xe86d</span></li>
            <li title="Code: 0xe741"><i class="icon-logout"></i> <span class="i-name">icon-logout</span><span class="i-code">0xe741</span></li>
            <li title="Code: 0xe86e"><i class="icon-logout-1"></i> <span class="i-name">icon-logout-1</span><span class="i-code">0xe86e</span></li>
            <li title="Code: 0xe742"><i class="icon-volume"></i> <span class="i-name">icon-volume</span><span class="i-code">0xe742</span></li>
            <li title="Code: 0xe744"><i class="icon-resize-full"></i> <span class="i-name">icon-resize-full</span><span class="i-code">0xe744</span></li>
            <li title="Code: 0xe746"><i class="icon-resize-small"></i> <span class="i-name">icon-resize-small</span><span class="i-code">0xe746</span></li>
            <li title="Code: 0xe74c"><i class="icon-popup"></i> <span class="i-name">icon-popup</span><span class="i-code">0xe74c</span></li>
            <li title="Code: 0xe74d"><i class="icon-publish"></i> <span class="i-name">icon-publish</span><span class="i-code">0xe74d</span></li>
            <li title="Code: 0xe74e"><i class="icon-window"></i> <span class="i-name">icon-window</span><span class="i-code">0xe74e</span></li>
            <li title="Code: 0xe74f"><i class="icon-arrow-combo"></i> <span class="i-name">icon-arrow-combo</span><span class="i-code">0xe74f</span></li>
            <li title="Code: 0xe751"><i class="icon-chart-pie"></i> <span class="i-name">icon-chart-pie</span><span class="i-code">0xe751</span></li>
            <li title="Code: 0xe752"><i class="icon-language"></i> <span class="i-name">icon-language</span><span class="i-code">0xe752</span></li>
            <li title="Code: 0xe753"><i class="icon-air"></i> <span class="i-name">icon-air</span><span class="i-code">0xe753</span></li>
            <li title="Code: 0xe754"><i class="icon-database"></i> <span class="i-name">icon-database</span><span class="i-code">0xe754</span></li>
            <li title="Code: 0xe755"><i class="icon-drive"></i> <span class="i-name">icon-drive</span><span class="i-code">0xe755</span></li>
            <li title="Code: 0xe756"><i class="icon-bucket"></i> <span class="i-name">icon-bucket</span><span class="i-code">0xe756</span></li>
            <li title="Code: 0xe757"><i class="icon-thermometer"></i> <span class="i-name">icon-thermometer</span><span class="i-code">0xe757</span></li>
            <li title="Code: 0xe758"><i class="icon-down-circled"></i> <span class="i-name">icon-down-circled</span><span class="i-code">0xe758</span></li>
            <li title="Code: 0xe759"><i class="icon-left-circled"></i> <span class="i-name">icon-left-circled</span><span class="i-code">0xe759</span></li>
            <li title="Code: 0xe75a"><i class="icon-right-circled"></i> <span class="i-name">icon-right-circled</span><span class="i-code">0xe75a</span></li>
            <li title="Code: 0xe75b"><i class="icon-up-circled"></i> <span class="i-name">icon-up-circled</span><span class="i-code">0xe75b</span></li>
            <li title="Code: 0xe760"><i class="icon-down-open-mini"></i> <span class="i-name">icon-down-open-mini</span><span class="i-code">0xe760</span></li>
            <li title="Code: 0xe761"><i class="icon-left-open-mini"></i> <span class="i-name">icon-left-open-mini</span><span class="i-code">0xe761</span></li>
            <li title="Code: 0xe762"><i class="icon-right-open-mini"></i> <span class="i-name">icon-right-open-mini</span><span class="i-code">0xe762</span></li>
            <li title="Code: 0xe763"><i class="icon-up-open-mini"></i> <span class="i-name">icon-up-open-mini</span><span class="i-code">0xe763</span></li>
            <li title="Code: 0xe764"><i class="icon-down-open-big"></i> <span class="i-name">icon-down-open-big</span><span class="i-code">0xe764</span></li>
            <li title="Code: 0xe765"><i class="icon-left-open-big"></i> <span class="i-name">icon-left-open-big</span><span class="i-code">0xe765</span></li>
            <li title="Code: 0xe766"><i class="icon-right-open-big"></i> <span class="i-name">icon-right-open-big</span><span class="i-code">0xe766</span></li>
            <li title="Code: 0xe767"><i class="icon-up-open-big"></i> <span class="i-name">icon-up-open-big</span><span class="i-code">0xe767</span></li>
            <li title="Code: 0xe769"><i class="icon-progress-1"></i> <span class="i-name">icon-progress-1</span><span class="i-code">0xe769</span></li>
            <li title="Code: 0xe76a"><i class="icon-progress-2"></i> <span class="i-name">icon-progress-2</span><span class="i-code">0xe76a</span></li>
            <li title="Code: 0xe76b"><i class="icon-progress-3"></i> <span class="i-name">icon-progress-3</span><span class="i-code">0xe76b</span></li>
            <li title="Code: 0xe770"><i class="icon-signal-2"></i> <span class="i-name">icon-signal-2</span><span class="i-code">0xe770</span></li>
            <li title="Code: 0xe771"><i class="icon-back-in-time"></i> <span class="i-name">icon-back-in-time</span><span class="i-code">0xe771</span></li>
            <li title="Code: 0xe776"><i class="icon-network"></i> <span class="i-name">icon-network</span><span class="i-code">0xe776</span></li>
            <li title="Code: 0xe777"><i class="icon-inbox"></i> <span class="i-name">icon-inbox</span><span class="i-code">0xe777</span></li>
            <li title="Code: 0xe830"><i class="icon-inbox-1"></i> <span class="i-name">icon-inbox-1</span><span class="i-code">0xe830</span></li>
            <li title="Code: 0xe778"><i class="icon-install"></i> <span class="i-name">icon-install</span><span class="i-code">0xe778</span></li>
            <li title="Code: 0xe788"><i class="icon-lifebuoy"></i> <span class="i-name">icon-lifebuoy</span><span class="i-code">0xe788</span></li>
            <li title="Code: 0xe789"><i class="icon-mouse"></i> <span class="i-name">icon-mouse</span><span class="i-code">0xe789</span></li>
            <li title="Code: 0xe78b"><i class="icon-dot"></i> <span class="i-name">icon-dot</span><span class="i-code">0xe78b</span></li>
            <li title="Code: 0xe78c"><i class="icon-dot-2"></i> <span class="i-name">icon-dot-2</span><span class="i-code">0xe78c</span></li>
            <li title="Code: 0xe78d"><i class="icon-dot-3"></i> <span class="i-name">icon-dot-3</span><span class="i-code">0xe78d</span></li>
            <li title="Code: 0xe78e"><i class="icon-suitcase"></i> <span class="i-name">icon-suitcase</span><span class="i-code">0xe78e</span></li>
            <li title="Code: 0xe81f"><i class="icon-off"></i> <span class="i-name">icon-off</span><span class="i-code">0xe81f</span></li>
            <li title="Code: 0xe78f"><i class="icon-road"></i> <span class="i-name">icon-road</span><span class="i-code">0xe78f</span></li>
            <li title="Code: 0xe790"><i class="icon-flow-cascade"></i> <span class="i-name">icon-flow-cascade</span><span class="i-code">0xe790</span></li>
            <li title="Code: 0xe820"><i class="icon-list-alt"></i> <span class="i-name">icon-list-alt</span><span class="i-code">0xe820</span></li>
            <li title="Code: 0xe791"><i class="icon-flow-branch"></i> <span class="i-name">icon-flow-branch</span><span class="i-code">0xe791</span></li>
            <li title="Code: 0xe821"><i class="icon-qrcode"></i> <span class="i-name">icon-qrcode</span><span class="i-code">0xe821</span></li>
            <li title="Code: 0xe792"><i class="icon-flow-tree"></i> <span class="i-name">icon-flow-tree</span><span class="i-code">0xe792</span></li>
            <li title="Code: 0xe822"><i class="icon-barcode"></i> <span class="i-name">icon-barcode</span><span class="i-code">0xe822</span></li>
            <li title="Code: 0xe793"><i class="icon-flow-line"></i> <span class="i-name">icon-flow-line</span><span class="i-code">0xe793</span></li>
            <li title="Code: 0xe824"><i class="icon-ajust"></i> <span class="i-name">icon-ajust</span><span class="i-code">0xe824</span></li>
            <li title="Code: 0xe794"><i class="icon-flow-parallel"></i> <span class="i-name">icon-flow-parallel</span><span class="i-code">0xe794</span></li>
            <li title="Code: 0xe833"><i class="icon-tint"></i> <span class="i-name">icon-tint</span><span class="i-code">0xe833</span></li>
            <li title="Code: 0xe79a"><i class="icon-brush"></i> <span class="i-name">icon-brush</span><span class="i-code">0xe79a</span></li>
            <li title="Code: 0xe79b"><i class="icon-paper-plane"></i> <span class="i-name">icon-paper-plane</span><span class="i-code">0xe79b</span></li>
            <li title="Code: 0xe7a1"><i class="icon-magnet"></i> <span class="i-name">icon-magnet</span><span class="i-code">0xe7a1</span></li>
            <li title="Code: 0xe825"><i class="icon-magnet-1"></i> <span class="i-name">icon-magnet-1</span><span class="i-code">0xe825</span></li>
            <li title="Code: 0xe7a2"><i class="icon-gauge"></i> <span class="i-name">icon-gauge</span><span class="i-code">0xe7a2</span></li>
            <li title="Code: 0xe7a3"><i class="icon-traffic-cone"></i> <span class="i-name">icon-traffic-cone</span><span class="i-code">0xe7a3</span></li>
            <li title="Code: 0xe7a5"><i class="icon-cc"></i> <span class="i-name">icon-cc</span><span class="i-code">0xe7a5</span></li>
            <li title="Code: 0xe7a6"><i class="icon-cc-by"></i> <span class="i-name">icon-cc-by</span><span class="i-code">0xe7a6</span></li>
            <li title="Code: 0xe7a7"><i class="icon-cc-nc"></i> <span class="i-name">icon-cc-nc</span><span class="i-code">0xe7a7</span></li>
            <li title="Code: 0xe7a8"><i class="icon-cc-nc-eu"></i> <span class="i-name">icon-cc-nc-eu</span><span class="i-code">0xe7a8</span></li>
            <li title="Code: 0xe7a9"><i class="icon-cc-nc-jp"></i> <span class="i-name">icon-cc-nc-jp</span><span class="i-code">0xe7a9</span></li>
            <li title="Code: 0xe7aa"><i class="icon-cc-sa"></i> <span class="i-name">icon-cc-sa</span><span class="i-code">0xe7aa</span></li>
            <li title="Code: 0xe7ab"><i class="icon-cc-nd"></i> <span class="i-name">icon-cc-nd</span><span class="i-code">0xe7ab</span></li>
            <li title="Code: 0xe7ac"><i class="icon-cc-pd"></i> <span class="i-name">icon-cc-pd</span><span class="i-code">0xe7ac</span></li>
            <li title="Code: 0xe7ad"><i class="icon-cc-zero"></i> <span class="i-name">icon-cc-zero</span><span class="i-code">0xe7ad</span></li>
            <li title="Code: 0xe7ae"><i class="icon-cc-share"></i> <span class="i-name">icon-cc-share</span><span class="i-code">0xe7ae</span></li>
            <li title="Code: 0xe7af"><i class="icon-cc-remix"></i> <span class="i-name">icon-cc-remix</span><span class="i-code">0xe7af</span></li>
            <li title="Code: 0xe7b5"><i class="icon-easel"></i> <span class="i-name">icon-easel</span><span class="i-code">0xe7b5</span></li>
            <li title="Code: 0xe840"><i class="icon-firefox"></i> <span class="i-name">icon-firefox</span><span class="i-code">0xe840</span></li>
            <li title="Code: 0xe841"><i class="icon-chrome"></i> <span class="i-name">icon-chrome</span><span class="i-code">0xe841</span></li>
            <li title="Code: 0xe842"><i class="icon-opera"></i> <span class="i-name">icon-opera</span><span class="i-code">0xe842</span></li>
            <li title="Code: 0xe843"><i class="icon-ie"></i> <span class="i-name">icon-ie</span><span class="i-code">0xe843</span></li>
            <li title="Code: 0xf01d"><i class="icon-paper-plane-1"></i> <span class="i-name">icon-paper-plane-1</span><span class="i-code">0xf01d</span></li>
            <li title="Code: 0xf03d"><i class="icon-chat-2"></i> <span class="i-name">icon-chat-2</span><span class="i-code">0xf03d</span></li>
            <li title="Code: 0xf096"><i class="icon-check-empty"></i> <span class="i-name">icon-check-empty</span><span class="i-code">0xf096</span></li>
            <li title="Code: 0xf0a0"><i class="icon-hdd"></i> <span class="i-name">icon-hdd</span><span class="i-code">0xf0a0</span></li>
            <li title="Code: 0xf0a3"><i class="icon-certificate"></i> <span class="i-name">icon-certificate</span><span class="i-code">0xf0a3</span></li>
            <li title="Code: 0xf0a9"><i class="icon-right-circled-1"></i> <span class="i-name">icon-right-circled-1</span><span class="i-code">0xf0a9</span></li>
            <li title="Code: 0xf0ae"><i class="icon-tasks"></i> <span class="i-name">icon-tasks</span><span class="i-code">0xf0ae</span></li>
            <li title="Code: 0xf0b0"><i class="icon-filter"></i> <span class="i-name">icon-filter</span><span class="i-code">0xf0b0</span></li>
            <li title="Code: 0xf0c3"><i class="icon-beaker"></i> <span class="i-name">icon-beaker</span><span class="i-code">0xf0c3</span></li>
            <li title="Code: 0xf0ce"><i class="icon-table"></i> <span class="i-name">icon-table</span><span class="i-code">0xf0ce</span></li>
            <li title="Code: 0xf0d0"><i class="icon-magic"></i> <span class="i-name">icon-magic</span><span class="i-code">0xf0d0</span></li>
            <li title="Code: 0xf0d6"><i class="icon-money"></i> <span class="i-name">icon-money</span><span class="i-code">0xf0d6</span></li>
            <li title="Code: 0xf0db"><i class="icon-columns"></i> <span class="i-name">icon-columns</span><span class="i-code">0xf0db</span></li>
            <li title="Code: 0xf0e4"><i class="icon-gauge-1"></i> <span class="i-name">icon-gauge-1</span><span class="i-code">0xf0e4</span></li>
            <li title="Code: 0xf0e5"><i class="icon-comment-empty"></i> <span class="i-name">icon-comment-empty</span><span class="i-code">0xf0e5</span></li>
            <li title="Code: 0xf0e6"><i class="icon-chat-empty"></i> <span class="i-name">icon-chat-empty</span><span class="i-code">0xf0e6</span></li>
            <li title="Code: 0xf0e8"><i class="icon-sitemap"></i> <span class="i-name">icon-sitemap</span><span class="i-code">0xf0e8</span></li>
            <li title="Code: 0xf0ea"><i class="icon-paste"></i> <span class="i-name">icon-paste</span><span class="i-code">0xf0ea</span></li>
            <li title="Code: 0xf0eb"><i class="icon-lightbulb"></i> <span class="i-name">icon-lightbulb</span><span class="i-code">0xf0eb</span></li>
            <li title="Code: 0xf0f0"><i class="icon-user-md"></i> <span class="i-name">icon-user-md</span><span class="i-code">0xf0f0</span></li>
            <li title="Code: 0xf0f1"><i class="icon-stethoscope"></i> <span class="i-name">icon-stethoscope</span><span class="i-code">0xf0f1</span></li>
            <li title="Code: 0xf0f2"><i class="icon-suitcase-1"></i> <span class="i-name">icon-suitcase-1</span><span class="i-code">0xf0f2</span></li>
            <li title="Code: 0xf0f3"><i class="icon-bell-alt"></i> <span class="i-name">icon-bell-alt</span><span class="i-code">0xf0f3</span></li>
            <li title="Code: 0xf0f4"><i class="icon-coffee"></i> <span class="i-name">icon-coffee</span><span class="i-code">0xf0f4</span></li>
            <li title="Code: 0xf0f5"><i class="icon-food"></i> <span class="i-name">icon-food</span><span class="i-code">0xf0f5</span></li>
            <li title="Code: 0xf0f9"><i class="icon-ambulance"></i> <span class="i-name">icon-ambulance</span><span class="i-code">0xf0f9</span></li>
            <li title="Code: 0xf0fa"><i class="icon-medkit"></i> <span class="i-name">icon-medkit</span><span class="i-code">0xf0fa</span></li>
            <li title="Code: 0xf0fb"><i class="icon-fighter-jet"></i> <span class="i-name">icon-fighter-jet</span><span class="i-code">0xf0fb</span></li>
            <li title="Code: 0xf0fc"><i class="icon-beer"></i> <span class="i-name">icon-beer</span><span class="i-code">0xf0fc</span></li>
            <li title="Code: 0xf0fe"><i class="icon-plus-squared-1"></i> <span class="i-name">icon-plus-squared-1</span><span class="i-code">0xf0fe</span></li>
            <li title="Code: 0xf108"><i class="icon-desktop"></i> <span class="i-name">icon-desktop</span><span class="i-code">0xf108</span></li>
            <li title="Code: 0xf109"><i class="icon-laptop"></i> <span class="i-name">icon-laptop</span><span class="i-code">0xf109</span></li>
            <li title="Code: 0xf10a"><i class="icon-tablet"></i> <span class="i-name">icon-tablet</span><span class="i-code">0xf10a</span></li>
            <li title="Code: 0xf10b"><i class="icon-mobile-1"></i> <span class="i-name">icon-mobile-1</span><span class="i-code">0xf10b</span></li>
            <li title="Code: 0xf10c"><i class="icon-circle-empty"></i> <span class="i-name">icon-circle-empty</span><span class="i-code">0xf10c</span></li>
            <li title="Code: 0xf110"><i class="icon-spinner"></i> <span class="i-name">icon-spinner</span><span class="i-code">0xf110</span></li>
            <li title="Code: 0xf111"><i class="icon-circle"></i> <span class="i-name">icon-circle</span><span class="i-code">0xf111</span></li>
            <li title="Code: 0xf4ac"><i class="icon-comment-3"></i> <span class="i-name">icon-comment-3</span><span class="i-code">0xf4ac</span></li>
            <li title="Code: 0x1f304"><i class="icon-picture"></i> <span class="i-name">icon-picture</span><span class="i-code">0x1f304</span></li>
            <li title="Code: 0x1f30e"><i class="icon-globe"></i> <span class="i-name">icon-globe</span><span class="i-code">0x1f30e</span></li>
            <li title="Code: 0xe831"><i class="icon-globe-1"></i> <span class="i-name">icon-globe-1</span><span class="i-code">0xe831</span></li>
            <li title="Code: 0x1f310"><i class="icon-globe-2"></i> <span class="i-name">icon-globe-2</span><span class="i-code">0x1f310</span></li>
            <li title="Code: 0x1f342"><i class="icon-leaf"></i> <span class="i-name">icon-leaf</span><span class="i-code">0x1f342</span></li>
            <li title="Code: 0xe81d"><i class="icon-leaf-1"></i> <span class="i-name">icon-leaf-1</span><span class="i-code">0xe81d</span></li>
            <li title="Code: 0x1f381"><i class="icon-gift"></i> <span class="i-name">icon-gift</span><span class="i-code">0x1f381</span></li>
            <li title="Code: 0x1f393"><i class="icon-graduation-cap"></i> <span class="i-name">icon-graduation-cap</span><span class="i-code">0x1f393</span></li>
            <li title="Code: 0x1f3a4"><i class="icon-mic"></i> <span class="i-name">icon-mic</span><span class="i-code">0x1f3a4</span></li>
            <li title="Code: 0x1f3a7"><i class="icon-headphones"></i> <span class="i-name">icon-headphones</span><span class="i-code">0x1f3a7</span></li>
            <li title="Code: 0x1f3a8"><i class="icon-palette"></i> <span class="i-name">icon-palette</span><span class="i-code">0x1f3a8</span></li>
            <li title="Code: 0x1f3ab"><i class="icon-ticket"></i> <span class="i-name">icon-ticket</span><span class="i-code">0x1f3ab</span></li>
            <li title="Code: 0x1f3ac"><i class="icon-video"></i> <span class="i-name">icon-video</span><span class="i-code">0x1f3ac</span></li>
            <li title="Code: 0x1f3af"><i class="icon-target"></i> <span class="i-name">icon-target</span><span class="i-code">0x1f3af</span></li>
            <li title="Code: 0x1f3c6"><i class="icon-trophy"></i> <span class="i-name">icon-trophy</span><span class="i-code">0x1f3c6</span></li>
            <li title="Code: 0x1f3c9"><i class="icon-award"></i> <span class="i-name">icon-award</span><span class="i-code">0x1f3c9</span></li>
            <li title="Code: 0x1f44d"><i class="icon-thumbs-up"></i> <span class="i-name">icon-thumbs-up</span><span class="i-code">0x1f44d</span></li>
            <li title="Code: 0x1f44e"><i class="icon-thumbs-down"></i> <span class="i-name">icon-thumbs-down</span><span class="i-code">0x1f44e</span></li>
            <li title="Code: 0x1f45c"><i class="icon-bag"></i> <span class="i-name">icon-bag</span><span class="i-code">0x1f45c</span></li>
            <li title="Code: 0x1f464"><i class="icon-user"></i> <span class="i-name">icon-user</span><span class="i-code">0x1f464</span></li>
            <li title="Code: 0x1f465"><i class="icon-users"></i> <span class="i-name">icon-users</span><span class="i-code">0x1f465</span></li>
            <li title="Code: 0x1f4a1"><i class="icon-lamp"></i> <span class="i-name">icon-lamp</span><span class="i-code">0x1f4a1</span></li>
            <li title="Code: 0x1f4a5"><i class="icon-alert"></i> <span class="i-name">icon-alert</span><span class="i-code">0x1f4a5</span></li>
            <li title="Code: 0x1f4a6"><i class="icon-water"></i> <span class="i-name">icon-water</span><span class="i-code">0x1f4a6</span></li>
            <li title="Code: 0x1f4a7"><i class="icon-droplet"></i> <span class="i-name">icon-droplet</span><span class="i-code">0x1f4a7</span></li>
            <li title="Code: 0x1f4b3"><i class="icon-credit-card"></i> <span class="i-name">icon-credit-card</span><span class="i-code">0x1f4b3</span></li>
            <li title="Code: 0xe827"><i class="icon-credit-card-1"></i> <span class="i-name">icon-credit-card-1</span><span class="i-code">0xe827</span></li>
            <li title="Code: 0x1f4bb"><i class="icon-monitor"></i> <span class="i-name">icon-monitor</span><span class="i-code">0x1f4bb</span></li>
            <li title="Code: 0x1f4bc"><i class="icon-briefcase"></i> <span class="i-name">icon-briefcase</span><span class="i-code">0x1f4bc</span></li>
            <li title="Code: 0xe81e"><i class="icon-briefcase-1"></i> <span class="i-name">icon-briefcase-1</span><span class="i-code">0xe81e</span></li>
            <li title="Code: 0x1f4be"><i class="icon-floppy"></i> <span class="i-name">icon-floppy</span><span class="i-code">0x1f4be</span></li>
            <li title="Code: 0xe828"><i class="icon-floppy-1"></i> <span class="i-name">icon-floppy-1</span><span class="i-code">0xe828</span></li>
            <li title="Code: 0x1f4bf"><i class="icon-cd"></i> <span class="i-name">icon-cd</span><span class="i-code">0x1f4bf</span></li>
            <li title="Code: 0x1f4c1"><i class="icon-folder"></i> <span class="i-name">icon-folder</span><span class="i-code">0x1f4c1</span></li>
            <li title="Code: 0x1f4c4"><i class="icon-doc-text"></i> <span class="i-name">icon-doc-text</span><span class="i-code">0x1f4c4</span></li>
            <li title="Code: 0x1f4c5"><i class="icon-calendar"></i> <span class="i-name">icon-calendar</span><span class="i-code">0x1f4c5</span></li>
            <li title="Code: 0xe86c"><i class="icon-calendar-2"></i> <span class="i-name">icon-calendar-2</span><span class="i-code">0xe86c</span></li>
            <li title="Code: 0x1f4c8"><i class="icon-chart-line"></i> <span class="i-name">icon-chart-line</span><span class="i-code">0x1f4c8</span></li>
            <li title="Code: 0x1f4ca"><i class="icon-chart-bar"></i> <span class="i-name">icon-chart-bar</span><span class="i-code">0x1f4ca</span></li>
            <li title="Code: 0xe826"><i class="icon-chart-bar-1"></i> <span class="i-name">icon-chart-bar-1</span><span class="i-code">0xe826</span></li>
            <li title="Code: 0x1f4cb"><i class="icon-clipboard"></i> <span class="i-name">icon-clipboard</span><span class="i-code">0x1f4cb</span></li>
            <li title="Code: 0x1f4ce"><i class="icon-attach"></i> <span class="i-name">icon-attach</span><span class="i-code">0x1f4ce</span></li>
            <li title="Code: 0x1f4d1"><i class="icon-bookmarks"></i> <span class="i-name">icon-bookmarks</span><span class="i-code">0x1f4d1</span></li>
            <li title="Code: 0x1f4d5"><i class="icon-book"></i> <span class="i-name">icon-book</span><span class="i-code">0x1f4d5</span></li>
            <li title="Code: 0xe823"><i class="icon-book-1"></i> <span class="i-name">icon-book-1</span><span class="i-code">0xe823</span></li>
            <li title="Code: 0x1f4d6"><i class="icon-book-open"></i> <span class="i-name">icon-book-open</span><span class="i-code">0x1f4d6</span></li>
            <li title="Code: 0x1f4de"><i class="icon-phone"></i> <span class="i-name">icon-phone</span><span class="i-code">0x1f4de</span></li>
            <li title="Code: 0xe869"><i class="icon-phone-1"></i> <span class="i-name">icon-phone-1</span><span class="i-code">0xe869</span></li>
            <li title="Code: 0x1f4e3"><i class="icon-megaphone"></i> <span class="i-name">icon-megaphone</span><span class="i-code">0x1f4e3</span></li>
            <li title="Code: 0xe829"><i class="icon-megaphone-1"></i> <span class="i-name">icon-megaphone-1</span><span class="i-code">0xe829</span></li>
            <li title="Code: 0xe87b"><i class="icon-bullhorn"></i> <span class="i-name">icon-bullhorn</span><span class="i-code">0xe87b</span></li>
            <li title="Code: 0x1f4e4"><i class="icon-upload"></i> <span class="i-name">icon-upload</span><span class="i-code">0x1f4e4</span></li>
            <li title="Code: 0x1f4e5"><i class="icon-download"></i> <span class="i-name">icon-download</span><span class="i-code">0x1f4e5</span></li>
            <li title="Code: 0x1f4e6"><i class="icon-box"></i> <span class="i-name">icon-box</span><span class="i-code">0x1f4e6</span></li>
            <li title="Code: 0x1f4f0"><i class="icon-newspaper"></i> <span class="i-name">icon-newspaper</span><span class="i-code">0x1f4f0</span></li>
            <li title="Code: 0x1f4f1"><i class="icon-mobile"></i> <span class="i-name">icon-mobile</span><span class="i-code">0x1f4f1</span></li>
            <li title="Code: 0x1f4f6"><i class="icon-signal"></i> <span class="i-name">icon-signal</span><span class="i-code">0x1f4f6</span></li>
            <li title="Code: 0xe81a"><i class="icon-signal-1"></i> <span class="i-name">icon-signal-1</span><span class="i-code">0xe81a</span></li>
            <li title="Code: 0x1f4f7"><i class="icon-camera"></i> <span class="i-name">icon-camera</span><span class="i-code">0x1f4f7</span></li>
            <li title="Code: 0x1f500"><i class="icon-shuffle"></i> <span class="i-name">icon-shuffle</span><span class="i-code">0x1f500</span></li>
            <li title="Code: 0x1f501"><i class="icon-loop"></i> <span class="i-name">icon-loop</span><span class="i-code">0x1f501</span></li>
            <li title="Code: 0x1f504"><i class="icon-arrows-ccw"></i> <span class="i-name">icon-arrows-ccw</span><span class="i-code">0x1f504</span></li>
            <li title="Code: 0x1f505"><i class="icon-light-down"></i> <span class="i-name">icon-light-down</span><span class="i-code">0x1f505</span></li>
            <li title="Code: 0x1f506"><i class="icon-light-up"></i> <span class="i-name">icon-light-up</span><span class="i-code">0x1f506</span></li>
            <li title="Code: 0x1f507"><i class="icon-mute"></i> <span class="i-name">icon-mute</span><span class="i-code">0x1f507</span></li>
            <li title="Code: 0xe86f"><i class="icon-volume-off"></i> <span class="i-name">icon-volume-off</span><span class="i-code">0xe86f</span></li>
            <li title="Code: 0x1f509"><i class="icon-volume-down"></i> <span class="i-name">icon-volume-down</span><span class="i-code">0x1f509</span></li>
            <li title="Code: 0x1f50a"><i class="icon-sound"></i> <span class="i-name">icon-sound</span><span class="i-code">0x1f50a</span></li>
            <li title="Code: 0xe870"><i class="icon-volume-up"></i> <span class="i-name">icon-volume-up</span><span class="i-code">0xe870</span></li>
            <li title="Code: 0x1f50b"><i class="icon-battery"></i> <span class="i-name">icon-battery</span><span class="i-code">0x1f50b</span></li>
            <li title="Code: 0x1f50d"><i class="icon-search"></i> <span class="i-name">icon-search</span><span class="i-code">0x1f50d</span></li>
            <li title="Code: 0x1f511"><i class="icon-key"></i> <span class="i-name">icon-key</span><span class="i-code">0x1f511</span></li>
            <li title="Code: 0xe82a"><i class="icon-key-1"></i> <span class="i-name">icon-key-1</span><span class="i-code">0xe82a</span></li>
            <li title="Code: 0x1f512"><i class="icon-lock"></i> <span class="i-name">icon-lock</span><span class="i-code">0x1f512</span></li>
            <li title="Code: 0x1f513"><i class="icon-lock-open"></i> <span class="i-name">icon-lock-open</span><span class="i-code">0x1f513</span></li>
            <li title="Code: 0x1f514"><i class="icon-bell"></i> <span class="i-name">icon-bell</span><span class="i-code">0x1f514</span></li>
            <li title="Code: 0xe863"><i class="icon-bell-1"></i> <span class="i-name">icon-bell-1</span><span class="i-code">0xe863</span></li>
            <li title="Code: 0x1f516"><i class="icon-bookmark"></i> <span class="i-name">icon-bookmark</span><span class="i-code">0x1f516</span></li>
            <li title="Code: 0x1f517"><i class="icon-link"></i> <span class="i-name">icon-link</span><span class="i-code">0x1f517</span></li>
            <li title="Code: 0x1f519"><i class="icon-back"></i> <span class="i-name">icon-back</span><span class="i-code">0x1f519</span></li>
            <li title="Code: 0x1f525"><i class="icon-fire"></i> <span class="i-name">icon-fire</span><span class="i-code">0x1f525</span></li>
            <li title="Code: 0x1f526"><i class="icon-flashlight"></i> <span class="i-name">icon-flashlight</span><span class="i-code">0x1f526</span></li>
            <li title="Code: 0x1f527"><i class="icon-wrench"></i> <span class="i-name">icon-wrench</span><span class="i-code">0x1f527</span></li>
            <li title="Code: 0x1f528"><i class="icon-hammer"></i> <span class="i-name">icon-hammer</span><span class="i-code">0x1f528</span></li>
            <li title="Code: 0x1f53e"><i class="icon-chart-area"></i> <span class="i-name">icon-chart-area</span><span class="i-code">0x1f53e</span></li>
            <li title="Code: 0x1f554"><i class="icon-clock"></i> <span class="i-name">icon-clock</span><span class="i-code">0x1f554</span></li>
            <li title="Code: 0xe871"><i class="icon-clock-1"></i> <span class="i-name">icon-clock-1</span><span class="i-code">0xe871</span></li>
            <li title="Code: 0x1f680"><i class="icon-rocket"></i> <span class="i-name">icon-rocket</span><span class="i-code">0x1f680</span></li>
            <li title="Code: 0x1f69a"><i class="icon-truck"></i> <span class="i-name">icon-truck</span><span class="i-code">0x1f69a</span></li>
            <li title="Code: 0x1f6ab"><i class="icon-block"></i> <span class="i-name">icon-block</span><span class="i-code">0x1f6ab</span></li>
            <li title="Code: 0xe872"><i class="icon-block-1"></i> <span class="i-name">icon-block-1</span><span class="i-code">0xe872</span></li>
          </ul>';
                                                  
						  $coutput .= '<input type="hidden" class="capture-input vibe-form-text vibe-cinput" name="' . $cpkey . '" id="' . $cpkey . '" value="' . $cparam['std'] . '" />' . "\n";
						   $coutput .= $crow_end;	
							// append
							$this->append_output( $coutput );
                                                        break;     
                                              
					}
				}
				
				// popup parent form row end
				$prow_end    = '</ul>' . "\n";		// end .child-clone-row-form
				$prow_end   .= '<a href="#" class="child-clone-row-remove">Remove</a>' . "\n";
				$prow_end   .= '</div>' . "\n";		// end .child-clone-row
				
				
				$prow_end   .= '</div>' . "\n";		// end .child-clone-rows
				$prow_end   .= '</td>' . "\n";
				$prow_end   .= '</tr>' . "\n";					
				$prow_end   .= '</tbody>' . "\n";
				
				// add $prow_end to output
				$this->append_output( $prow_end );
			}			
		}
	}
	
	// --------------------------------------------------------------------------
	
	function append_output( $output )
	{
		$this->output = $this->output . "\n" . $output;		
	}
	
	// --------------------------------------------------------------------------
	
	function reset_output( $output )
	{
		$this->output = '';
	}
	
	// --------------------------------------------------------------------------
	
	function append_error( $error )
	{
		$this->errors = $this->errors . "\n" . $error;
	}
}

?>