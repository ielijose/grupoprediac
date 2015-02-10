<?php

/**
 * FILE: config.php 
 * Created on Feb 12, 2013 at 7:30:46 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 * Project: vEstate
 * License: GPLv2
 */

//Define CONSTANTS
define('THEME_DOMAIN','vibe'); 
define('THEME_SHORT_NAME','vest');
define('THEME_FULL_NAME','vEstate');
define('VIBE_PATH',get_theme_root().'/vestate');
define('VIBE_URL',get_template_directory_uri());

if (!defined('LISTING')) { 
	define('LISTING','listing');
 }  


//Global Vars
global $vibe_options,$vibe_post_script;

$vibe_options = get_option(THEME_SHORT_NAME);


// Auto Update
if(isset($vibe_options['username']) && isset($vibe_options['apikey'])){ 
require_once(VIBE_PATH."/options/validation/theme-update/class-theme-update.php");
VibeThemeUpdate::init($vibe_options['username'],$vibe_options['apikey']);
}


?>