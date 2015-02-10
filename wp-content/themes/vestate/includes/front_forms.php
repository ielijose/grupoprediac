<?php


function vibe_register_forms(){

    global $current_user;
    get_currentuserinfo();
    $profile_settings = array(
            'post_type' => 'agent',
            'post_status' => 'publish',
            'post_author' => true,
            'show_comment_option' => false,
            'custom_fields' => array(
                                 'vibe_agent_phone' => array(
                                          'type' => 'textbox',
                                          'label'=>'Agent Phone Number',
                                          'name' => 'vibe_agent_phone',
                                          'default'=>'',
                                          'desc' => 'Phone number for contact information.'
                                          ),
                                 'vibe_agent_email' => array(
                                          'type' => 'textbox',
                                          'label'=>'Agent Email Id',
                                          'name' => 'vibe_agent_email',
                                          'default'=>'',
                                          'desc' => 'Email Id for contact information'
                                          ),
                                 
                                 'vibe_show_listing' => array(
                                       'type' => 'switch',
                                       'label' => 'Show Listings in Profile Page',
                                       'name' => 'vibe_show_listing',
                                       'desc' => 'Show Agent submitted Listings in Profile page'
                                    ),
                                 'vibe_agent_id' => array(
                                       'type' => 'readonly',
                                       'label' => 'Agent ID',
                                       'name' => 'vibe_agent_id',
                                       'desc' => 'Agent ID , Do not Edit',
                                       'std' => $current_user->ID
                                    ),
               ),
            
            'upload_array' => array(
                                 'thumbnail' => 'Agent Profile Page Featured iamge',
                                 'vibe_agent_image' => 'Agent Passport size photo'
                              ),
            'current_user_can_post' => current_user_can('edit_posts')
        );
    


   
        $listing_status=vibe_get_option('agent_publish_listing');
        if(!isset($listing_status) || !$listing_status){
           $listing_status = 'draft';
        }
        $listing_settings = array(
            'post_type' => LISTING,
            'post_status' => $listing_status,
            'post_author' => true,
            'show_comment_option' => false,
           
            'upload_array' => array(
                                 'thumbnail' => 'Listing Featured iamge',
                              ),
            'current_user_can_post' => current_user_can('edit_posts')
        );

    $listing_tax = vibe_get_option('listing_taxonomies');

    if(isset($listing_tax) && is_array($listing_tax)){
       if(is_array($listing_tax['slug'])){

          foreach($listing_tax['slug'] as $key => $value){
              $listing_settings['tax'][$value] = array();
          }
      }
    }

    $listing_fields = vibe_get_option('listing_fields');
    
    $listing_settings['custom_fields']['vibe_select_featured']=array(
      'type' => 'select',
      'label' => __('Enable Gallery','vibe'),
      'name'=> 'vibe_select_featured',
      'options' => array(
        'disable' => array('label' => 'Disable','value'=>'disable'),
        'gallery' => array('label' => 'Enable','value'=>'gallery')
        ),
      );
    
    $listing_settings['custom_fields']['vibe_slider']=array(
      'type' => 'textbox',
      'label' => __('Add Gallery Images (IDs)','vibe'),
      'name'=> 'vibe_slider',
      );
  
    if(isset($listing_fields) && is_array($listing_fields)){


            foreach($listing_fields['label'] as $k=>$label){

                $type = $listing_fields['field_type'][$k];

                if($type == 'select' || $type == 'multiselect'){
                  $l = explode('|',$label);
                  $label = $l[0];
                  $alloptions=explode(',',$l[1]);
                  $options = array();
                  foreach($alloptions as $opt){
                    $options[]=array('label' =>$opt,'value'=>$opt);
                  }
                }

                $key = 'vibe_'.strtolower(str_replace(' ', '-',$label));


                if($type == 'checkbox')$type='switch';
                $listing_settings['custom_fields'][$key]=array(
                      'type' => $type,
                     'label' => $label,
                     'name' => $key,
                     'options' => $options
                  );

            }

    }

  if(function_exists('vibe_new_front_post_form')){
    $agentform= vibe_new_front_post_form('add_agent',$profile_settings);  
    $listingform= vibe_new_front_post_form('add_listing',$listing_settings);
  }
      

}

add_action('init','vibe_register_forms');


function vibe_postid_functions($post_id){

            $post=get_post($post_id);
            $authid = $post->post_author;

            $author_id=get_post_meta( $post->ID,'vibe_agent_id',true);

         if(get_post_type( $post->ID) == 'agent'){   
            if($authid != $author_id){
                update_post_meta($post->ID,'vibe_agent_id',$authid);
                update_user_meta($authid,'agent_profile',$post->ID);
            }
         }

}
?>