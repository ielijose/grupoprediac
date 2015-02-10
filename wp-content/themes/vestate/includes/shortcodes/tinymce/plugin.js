(function($) {
"use strict";   
 


 			//Shortcodes
           tinymce.PluginManager.add( 'vibeShortcodes', function( editor, url ) {

				editor.addCommand("vibePopup", function ( a, params )
				{
					var popup = params.identifier;
					tb_show("Insert Shortcode", url + "/popup.php?popup=" + popup + "&width=" + 800);
				});
     
                editor.addButton( 'vibe_button', {
                    type: 'splitbutton',
                    icon: 'icon vibe-icon',
					title:  'Vibe Shortcodes',
					onclick : function(e) {},
					menu: [

					{text: 'Accordion',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Accordion',identifier: 'accordion'})
					}},
					{text: 'Agent',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Agent',identifier: 'agent'})
					}},
					{text: 'Alerts',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Alerts',identifier: 'alert'})
					}},
					{text: 'Audio',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Alerts',identifier: 'audio'})
					}},
					{text: 'Buttons',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Buttons',identifier: 'button'})
					}},
					{text: 'Columns',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Columns',identifier: 'columns'})
					}},
					{text: 'Dropcaps',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Dropcaps',identifier: 'dropcaps'})
					}},
					{text: 'Forms',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Forms',identifier: 'forms'})
					}},
					{text: 'Gallery',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Gallery',identifier: 'gallery'})
					}},
					{text: 'Heading',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Heading',identifier: 'heading'})
					}},
					{text: 'Google Maps',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Google Maps',identifier: 'maps'})
					}},
					{text: 'Icons',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Icons',identifier: 'icons'})
					}},
					{text: 'List',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'List',identifier: 'list'})
					}},
					{text: 'Listing',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Listing',identifier: 'listing'})
					}},
					{text: 'Popups',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Popups',identifier: 'popups'})
					}},
					{text: 'Note',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Note',identifier: 'note'})
					}},
					{text: 'Progress Bar',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Progress Bar',identifier: 'progressbar'})
					}},
					{text: 'Round Progress Bar',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Round Progress Bar',identifier: 'roundprogress'})
					}},
					{text: 'Tabs',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Tabs',identifier: 'tabs'})
					}},
					{text: 'Team',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Team',identifier: 'team_member'})
					}},
					{text: 'Testimonial',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Testimonial',identifier: 'testimonial'})
					}},
					{text: 'Toggle',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Toggle',identifier: 'toggle'})
					}},
					{text: 'Tooltips',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Tooltips',identifier: 'tooltip'})
					}},
					{text: 'Video',onclick:function(){
						editor.execCommand("vibePopup", false, {title: 'Video',identifier: 'iframevideo'})
					}},
					]                
        	  });
         
          });
         
 
})(jQuery);