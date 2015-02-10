<?php

global $vibe_options;
if(is_404()){
    if(isset($vibe_options['error404'])){
        $page_id=  intval($vibe_options['error404']);
        wp_redirect( get_page_uri( $page_id ),301); 
        exit;
    }
    
}
?>