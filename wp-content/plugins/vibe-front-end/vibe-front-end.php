<?php

/*
  Plugin Name: Vibe Front End Post
  Description: Create Unlimited posts from Front End, embed Custom Post creation from any Page using shortcode.
  Version: 1.0
  Author: VibeThemes
  Author URI: http://www.vibethemes.com
  License: GPLv2
 */

/**
 * How to Use this plugin
 * 
 * If you want to  create a form and show it on Front end, You will need to create and Register a form as follows
 * 
 * Register a from on/before bp_init action using 
 * $form= bp_new_simple_blog_post_form('form_name',$settings);// please see @ bp_new_simple_blog_post_form for the settings options
 * 
 * now, you can retrieve this form anywhere and render it as below
 * 
 * $form=bp_get_simple_blog_post_form('form_name');
 * if($form)
 *  $form->show();//show this post form
 * 
 */

/**
 * This is a helper class, adds support for localization
 */
class VibeFrontPostComponent {

    private static $instance;

    private function __construct() {

        add_action('init', array($this, 'load_textdomain'), 2);
    }

    /**
     * Factory method for singleton object
     * 
     */
    function get_instance() {
        if (!isset(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    //localization
    function load_textdomain() {

        $locale = apply_filters('vibe_load_textdomain', get_locale());

        // if load .mo file
        if (!empty($locale)) {
            $mofile_default = sprintf('%slanguages/%s.mo', plugin_dir_path(__FILE__), $locale);

            $mofile = apply_filters('vibe_load_mofile', $mofile_default);
            // make sure file exists, and load it
            if (file_exists($mofile)) {
                load_textdomain('vibe', $mofile);
            }
        }
    }

    function include_js() {
        
    }

    function include_css() {
        
    }

}

/*
 * Main controller class
 * stores various forms and delegates the post saving to appropriate form
 * 
 */

class VibeFrontPostEditor {

    private static $instance;

    var $forms = array(); // array of Post Forms(multiple post forms)
    private $self_url;

    private function __construct() {
        $this->self_url = plugin_dir_url(__FILE__);
        //hook save action to init
        add_action('wp', array($this, 'save'));
    }

    /**
     * Factory method for singleton object
     * 
     */
    function get_instance() {
        if (!isset(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    /**
     * Register a form
     * 
     * @param VibeFrontPostEditForm $form 
     */
    public function register_form($form) {
        $this->forms[$form->id] = $form; //save/overwrite
    }

    /**
     *
     * @param string $form_name
     * @return VibeFrontPostEditForm|boolean 
     */
    public function get_form_by_name($form_name) {
        $id = md5(trim($form_name));
        return $this->get_form_by_id($id);
    }

    /**
     * Returns the Form Object
     * 
     * @param string $form_id
     * @return VibeFrontPostEditForm|boolean 
     */
    public function get_form_by_id($form_id) {

        if (isset($this->forms[$form_id]))
            return $this->forms[$form_id];
        return false;
    }

    /**
     * Save a post
     * 
     * Delegates the task to  VibeFrontPostEditForm::save() of appropriate form(which was submitted)
     * 
     * @return type 
     */
    function save() {
        if (!empty($_POST['vibe_front_form_subimitted'])) {
            //yeh form was submitted
            //get form id
            $form_id = $_POST['vibe_front_form_id'];
            $form = $this->get_form_by_id($form_id);

            if (!$form)
                return; //we don't need to do anything
                
//so if it is a registerd form, let the form handle it

            $form->save(); //save the post and redirect properly
        }
    }

}

/**
 * A Form Instance class
 * 
 * Do not use it directly, instead call bp_new_simple_blog_post_form to create new instances
 * or you can create your own child class for more felxibility
 */
class VibeFrontPostEditForm {

  /**
   * A unique md5'd id of the post form
   * Each post form has a unique id
   * 
   * @var type 
   */
    var $id; //an unique md5ed hash of the human readable name
    var $current_user_can_post = false; // It is trhe responsibility of developer to set it true or false based on whether he wants to allow the current user to post or not
    /**
     * Which post type we want to edit/create
     * 
     * it can be any valid post type, you can specify it while registering the from
     * 
     * @var string post_type, defaults to post 
     */
    var $post_type = 'post'; 
    /**
     * post status after the post is submitted via front end, defaults to draft
     * 
     * You can set it to 'publish' if you want to directly publish it
     * It can be set via settings while registering the form
     * 
     * @var string
     */
    var $post_status = 'draft'; 
    /**
     * Who wrote this post?, the user_id of post autor, default to current logged in user
     * If it is not set, the logged in user will be attributed as the author
     * @var type 
     */
    var $post_author = false; 

    /**
     * Which categories are allowed for this form
     * just for backward compatibility
     * we will rather use taxonomy
     * @var type 
     */
    var $allowed_categories = array(); //if there are any
    /**
     * @todo: remove in next release
     * 
     * @var type 
     */
    var $allowed_tags = array(); //not implemented, 
    /**
     * Taxonomy settings
     * 
     * @var array  Multidimensional array with details of allowed taxonomy 
     */
    var $tax = array(); //multidimensional array
    /**
     * Custom Fields settings
     * 
     * @var array Mutidimensional array with custom field settings
     *  
     */
    var $custom_fields = array(); //multidimensional array
    /**
     * How many uploads are allowed
     * 
     * @todo: we need to finetune it for allowed media types?
     *
     *  @var type 
     */
    var $upload_array = array();
    /*
    Example Aray
     
    var $upload_array = array(
        'thumbnail' => 'label',
        );
    /**
     * Default comment status, is it open or closed?
     * @var string 
     */
    var $comment_status='open';
    /**
     * Should show the user option to allow comment
     * 
     * @var type 
     */
    public $show_comment_option=true;
    /**
     * Used to store error/success message
     * @var string 
     */
    var $message='';
    

    public function vibe_add_message($mess){
        $this ->message .= $mess;
    }

    public function vibe_show_message(){
        echo '<div class="message">'.$this->message.'</div>';
    }

    /**
     * Create a new instance of the Post Editor Form
     * @param type $name
     * @param array $settings, a multidimensional array of form settings 
     */
    
    public function __construct($name, $settings) {
        $this->id = md5(trim($name));

        $default = array('post_type' => 'post',
            'post_status' => 'draft',
            'tax' => false,
            'post_author' => false,
            'can_user_can_post' => false,
            'custom_fields'=>false,
            'upload_array' => array('thumbnail'=>'Featured Image'),
            'current_user_can_post' => is_user_logged_in() //it may be a bad decision on my part, do we really want to allow all logged in users to post?
        );

        $args = wp_parse_args($settings, $default);
        extract($args);

        $this->post_type = $post_type;
        $this->post_status = $post_status;



        if ($post_author)
            $this->post_author = $post_author;
        else
            $this->post_author = get_current_user_id();

        $this->tax = $tax;

        $this->custom_fields = $custom_fields;

        $this->current_user_can_post = $current_user_can_post; //we will change later for context

        $this->upload_array = $upload_array;
        if($comment_status)
            $this->comment_status=$comment_status;
        
        if($show_comment_option)
            $this->show_comment_option=$show_comment_option;
    }

    /**
     * Show/Render the Post form
     */
    function show($form='form.php') {
        //needed for category/term walker
        require_once(trailingslashit(ABSPATH) . 'wp-admin/includes/template.php');
        //will be exiting post for editing or 0 for new post
        
        //load the post form
       
      
        $this->load_post_form($form);
    }
    /**
     * Locate and load post from
     * we need to allow theme authors to modify it
     * so, we will first look into the template directory and if not found, we will load it from the plugin's included file
     * 
     */
    function load_post_form($form) {
        
            $post_id = $this->get_post_id();

           

            
        $default = array(
            'title' => '', //$_POST['vibe_front_title']
            'content' => ''//$_POST['vibe_front_text']
        );


        if (!empty($post_id)) {
            //should we check if current user can edit this post ?
            $post = get_post($post_id);
            
            if(function_exists('vibe_postid_functions'))
                    vibe_postid_functions($post_id);
         

            $args = array('title' => $post->post_title,
                          'content' => $post->post_content);
            $default = wp_parse_args($args, $default);
        }
       
       
        if(!isset($form))
            $form='form';
        
        $form .='.php';

        extract($default);


        include (plugin_dir_path(__FILE__) . $form);
    }

    /**
     * Get associated term ids for a post/post type
     * 
     * @param type $object_ids
     * @param type $tax
     * @return array of term_ids 
     */
    function get_term_ids($object_ids, $tax) {
        $terms = wp_get_object_terms($object_ids, $tax);
        $included = array();
        foreach ((array) $terms as $term)
            $included[] = $term->term_id;
        return $included;
    }

    /**
     * Get the post id
     * For editing, filter on the hook to return the post_id
     * @return type 
     */
    function get_post_id() {

        if(isset($_GET['agent_id'])){
            return $_GET['agent_id'];
        }elseif($_GET['listing_id']){
            return $_GET['listing_id'];
        }
    }

    /**
     * Does the saving thing
     */
    function save() {
        $post_id=false;
        //verify nonce
        if (!wp_verify_nonce($_POST['_wpnonce'], 'vibe_front_new_post_' . $this->id)){
        
            vibe_add_message(__("The Security check failed!"));
            return;//do not proceed
            
        }

        
        $post_type_details = get_post_type_object($this->post_type);

        $title = $_POST['vibe_front_title'];
        $content = $_POST['vibe_front_text'];

        $message = '';
        $error = '';
        if(isset($_POST['post_id']))
            $post_id = $_POST['post_id'];
        
        if (!empty($post_id)) {
            $post = get_post($post_id);
            //in future, we may relax this check
            //$post->post_author == get_current_user_id() || is_super_admin()
            if (!(current_user_can('edit_posts'))) {
                $error = true;
                $message = __('You are not authorized for the action!', 'vibe');
            }
        }
        if (empty($title) || empty($content)) {
            $error = true;
            $message = __('Please make sure to fill the required fields', 'vibe');
        }

        $error=  apply_filters('vibe_validate_post',$error,$_POST);
        
        if (!$error) {
            
            global $current_user;
            get_currentuserinfo();
            $this->post_author = $current_user->ID;

            $post_data = array(
                'post_author' => $this->post_author,
                'post_content' => $content,
                'post_type' => $this->post_type,
                'post_status' => $this->post_status,
                'post_title' => $title
            );


            //find comment_status
            $comment_status=$_POST['vibe_front_comment_status'];
            if(empty($comment_status)&&!$post_id){
                    $comment_status='closed';//user has not checked it
            
            }       
            if($comment_status)
                $post_data['comment_status']=$comment_status;
            
            if (!empty($post_id))
                $post_data['ID'] = $post_id;
            //EDIT

            $post_id = wp_insert_post($post_data);

            //if everything worked fine, the post was saved
            if (!is_wp_error($post_id)) {

                //update the taxonomy
                //currently does not check if post type is associated with the taxonomy or not
                //TODO: Make sure to check for the association of post type and category
                if (!empty($this->tax) ) {
                    //if we have some taxonomy info
                    //tax_slug=>tax_options set for that taxonomy while registering the form
                    
                    foreach ($this->tax as $tax => $tax_options) {
                        $selected_terms=array();
                        //get all selected terms, may be array, depends on whether a dd or checkklist
                        if(isset($_POST['tax_input'][$tax]))
                            $selected_terms = (array) $_POST['tax_input'][$tax]; 
                        
                        //check if include is given when the form was registered and this is a subset of include
                        if (!empty($tax_options['include'])) {

                            $allowed = $tax_options['include']; //this is an array
                            //check a diff of selected vs include
                            $is_fake = array_diff($selected_terms, $allowed);
                            if (!empty($is_fake))
                                continue; //we have fake input vales, do not store
                        }
                        
                        //if we are here, everything is fine

                        //it can still be empty, if the user has not selected anything and nothing was given
                        //post to all the allowed terms
                        if (empty($selected_terms)&&isset($tax_options['include']))
                            $selected_terms = $tax_options['include']; 

                         
                        //update the taxonomy/post association

                        if (!empty($selected_terms)) {
                            $selected_terms = array_map('intval', $selected_terms);
                           
                                wp_set_object_terms($post_id, $selected_terms, $tax);
                           
                        }
                        
                    }//end of the loop
                }//end of taxonomy saving block
                

                //let us process the custom fields
                
                //same strategy for the custom field as taxonomy

                if (!empty($this->custom_fields)) {
                    //which fields were updated
                    $updated_field = (array) $_POST['custom_fields']; //array of key=>value pair
                   

                    foreach ($this->custom_fields as $key => $data) {
                        
                        //shouldn't we validate the data?
                        
                        $value = $this->get_validated($key, $updated_field[$key], $data);
                        /*
                        if (is_array($value)) {

                            //there were multiple values
                            //delete older one if there is a post id
                            //it may not be a very good idea to delete old post meta field, but we don't know the field has multiple entries or single and cann mess arounf
                            if ($post_id)
                                delete_post_meta($post_id, $key);

                            foreach ($value as $val)
                                add_post_meta($post_id, $key, $val);
                        }
                        else*/
                            if($key == 'vibe_agent_id'){
                                global $current_user;
                                 get_currentuserinfo();
                                 update_user_meta($current_user->ID,'agent_profile',$post_id);
                            }

                            update_post_meta($post_id, $key, $value);
                    }
                }//done for custom fields
                

                //check for upload 
                //upload and save

                $action = 'vibe_front_new_post_' . $this->id;

            foreach($this->upload_array as $key=>$value){
                

                if(isset($_FILES[$key]) && $_FILES[$key]['size'] > 0){ 
                        $attachment = $this->handle_upload($post_id, $key, 'bpsfep_new_post');
                        if($key == 'thumbnail'){
                          set_post_thumbnail( $post_id, $attachment );
                        }else{
                            update_post_meta($post_id,$key,$attachment);
                        }
                    }
            }
               
                do_action('vibe_post_saved', $post_id);
                $message = sprintf(__('%s Saved as %s successfully.', 'vibe'), $post_type_details->labels->singular_name, $this->post_status);
                $message = apply_filters('vibe_post_success_message', $message, $post_id, $post_type_details, $this);
            } else {
                $error = true;
                $message = sprintf(__('There was a problem saving your %s. Please try again later.', 'vibe'), $post_type_details->labels->singular_name);
            }
        }
        
        //need to refactor the message/error infor data in next release when I will be modularizing the plugin a little bit more
       if(!$message)
           $message=$this->message;
       
       if($error)
           $error='error';//buddypress core_add_message does not understand boolean properly
       
       $this->vibe_add_message($message);
        //bp_core_add_message(, $error);
    }

    /**
     * Renders html for individual custom field
     * @param type $field_data array of array(type=>checkbox/dd/input/textbox
     * @param type $current_value
     * @return string 
     */
    function render_field($field_data, $current_value=false) {
        extract($field_data);
        
        if ($type != 'multiselect' && $type != 'gmap')
        $current_value = esc_attr($current_value);

        
        $name = "custom_fields[$key]";
        if ($type == 'checkbox' || $type == 'multiselect')
            $name = $name . "[]";


        switch ($type) {
            case 'textbox':
            case 'text':
            case 'id':
                $input = "<li><label>{$label}</label><input type='text' name='{$name}' id='custom-field-{$key}' value='{$current_value}' /><small>{$desc}</small></li>";
                break;

            case 'readonly':
                $current_value = $std;
                $input = "<li><label>{$label}</label><input type='text' name='{$name}' id='custom-field-{$key}' value='{$current_value}' READONLY /><small>{$desc}</small></li>";
                break;    
                
            case 'price':    
            case 'number':
                $input = "<li><label>{$label}</label><input type='number' name='{$name}' id='custom-field-{$key}' value='{$current_value}' /><small>{$desc}</small></li>";
                break;    

            case 'textarea':
                $input = "<li><label>{$label}</label><textarea  name='{$name}' id='custom-field-{$key}' >{$current_value}</textarea><small>{$desc}</small></li>";
                break;

            case 'radio':
                $input = "<li><label>{$label}</label>";
                foreach ($options as $option)
                    $input.="<label>{$option['label']}</label><input type='radio' name='{$name}' " . checked($option['value'], $current_value, false) . "  value='" . $option['value'] . "' /><small>{$desc}</small></li>";

                break;

            case 'select':
                $input = "<li><label>{$label}</label><select name='{$name}' id='custom-field-{$key}' class='chosen'>";
                foreach ($options as $option)
                    $input.="<option  " . selected($option['value'], $current_value, false) . "  value='" . $option['value'] . "' >{$option['label']}</option>";

                $input.="</select><small>{$desc}</small></li>";
                break;
            
            case 'agents':   
                global $current_user;
                get_currentuserinfo();
                $profileid=get_user_meta($current_user->ID,'agent_profile',true);

                $input = "<li><label>{$label}</label><input type='text' name='{$name}' id='custom-field-{$key}' value='{$profileid}' READONLY />";    
                $input.="<small>{$desc}</small></li>";
                
                break; 

            case 'multiselect':

                $input = "<li><label>{$label}</label><select name='".$name."' id='custom-field-{$key}' class='chosen' multiple>";

               

                foreach ($options as $option){
                     if(is_array($current_value)){
                               $selected = '';

                               if(is_array($current_value[0]))
                                    $current_value =$current_value[0];

                                    if(in_array($option['label'],$current_value))
                                     $selected='SELECTED';   
                                
                            }else{
                                if($option['value'] == $current_value)
                                     $selected='SELECTED';   
                            }

                    $input.="<option  " . $selected . "  value='" . $option['value'] . "' >{$option['label']}</option>";
                }

                $input.="</select><small>{$desc}</small></li>";
                break;
                    
             case 'checkbox':
             case 'available':   
             case 'featured':
             case 'switch':

                $input = "<li><label>{$label}</label>
                <select name='{$name}' id='custom-field-{$key}' class='chosen'>";
                     $input.="<option  " . selected(0, $current_value, false) . "  value='0' > No </option>";
                      $input.="<option  " . selected(1, $current_value, false) . "  value='1' > Yes </option>";
                $input.="</select><small>{$desc}</small></li>";
                break;  

            case 'repeatable':
                $input = "<li><label>{$label}</label>";
                $input .='<ul class="repeatablelist">';
                if(isset($current_value) && is_array($current_value)){
                    foreach($current_value as $key => $value){
                        $input .='<li><span class="sort_handle"><i class="icon-move-vertical"></i></span> <input type="text" name="'.$name.'[]" value="'.$value.'" /></li>';
                    }
                }
                $input .='<li><span class="sort_handle"><i class="icon-move-vertical"></i></span><input type="text" class="option_text" rel-name="'.$name.'[]" value="" placeholder="'.__('Add Option','vibe').'" /></li>';
                $input .='</ul>';
                $input .= '<a class="add_repeatable button small">'.__('Add Option','vibe').'</a>';
                $input.="<small>{$desc}</small></li>";
                break;      



            case 'selectcpt':
                $args= array(
                    'post_type' => $post_type,
                    'post_per_page' => -1
                    );

                $the_query = new WP_Query($args);

                $input = "<li><label>{$label}</label>";
                if ( $the_query->have_posts() ) {
                        $input .= "<select name='{$name}' id='custom-field-{$key}' class='chosen'>";
                        $input.="<option  " . selected(0, $current_value, false) . "  value=0 >None</option>";
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        $input.="<option  " . selected(get_the_ID(), $current_value, false) . "  value='" . get_the_ID() . "' >".get_the_title()."</option>";
                    }
                        echo '</select>';
                } else {
                    $input .=__('No Quiz found','vibe');
                    // no posts found
                }
                /* Restore original Post Data */
                wp_reset_postdata();  
                $input.="</select><small>{$desc}</small></li>";
                
                break;
                

            

            case 'selectmulticpt':
                $args= array(
                    'post_type' => $post_type,
                    'post_per_page' => -1
                    );

                $the_query = new WP_Query($args);

                $input = "<li><label>{$label}</label>";
                if ( $the_query->have_posts() ) {
                        $input .= "<select name='{$name}' id='custom-field-{$key}' class='chosen' multiple>";
                        $input.="<option  " . selected(0, $current_value, false) . "  value=0 >None</option>";
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();

                         if(is_array($current_value)){
                                if(in_array($tax->term_id,$current_value))
                                     $selected='SELECTED';   
                            }else{
                                if($tax->term_id == $current_value)
                                     $selected='SELECTED';   
                            }

                        $input.="<option  " . $selected . "  value='" . get_the_ID() . "' >".get_the_title()."</option>";
                    }
                        echo '</select>';
                } else {
                    $input .=__('No Quiz found','vibe');
                    // no posts found
                }
                /* Restore original Post Data */
                wp_reset_postdata();  
                $input.="</select><small>{$desc}</small></li>";
                
                break;

            case 'selectordercpt'    :
                    $input = "<li><label>{$label}</label>";

                    $args= array(
                    'post_type' => $post_type,
                    'post_per_page' => -1
                    );

                    $cptarray=array();
                $the_query = new WP_Query($args);
                if ( $the_query->have_posts() ) {
                    
                    while ( $the_query->have_posts() ) {
                        $the_query->the_post();
                        $cptarray[get_the_ID()] = get_the_title();
                    }
                }
                /* Restore original Post Data */
                wp_reset_postdata();  

                $input .='<ul class="orderquestions">';
                if(isset($current_value) && is_array($current_value)){
                       foreach($current_value as $key => $value) {
                          $input .='<li><span><i class="icon-move-vertical"></i> '.$cptarray[$value].'<input type="hidden" name="'.$name.'[]" value="'.$value.'"/></li>';
                       }
                }
                $input .= '<li></span>
                <select name="'.$name.'[]" class="chosen"><option>Select a Question</option>';

                foreach($cptarray as $k=>$cp){
                    $input .= '<option value='.$k.'>'.$cp.'</option>';
                    }
                $input .= '</select>
                </li></ul>';
                $input.="<small>{$desc}</small></li>";    
            break;
            case 'selecttax':
                
                $input = "<li><label>{$label}</label><select name='{$name}' id='custom-field-{$key}' class='chosen'>";
                $input.="<option  value='' >".__('Select Course Module','vibe')."</option>";
                $args= array(
                    'hide_empty'    => false
                    );

                $taxs= get_terms($taxonomy,$args);
                foreach($taxs as $tax){
                    $selected='';
                    if(isset($parent)){
                        if($tax->parent == '0' || $tax->parent == 0 || !($tax->parent)){
                            if(isset($current_value)){
                                if($tax->term_id == $current_value)
                                     $selected='SELECTED';   
                                 }
                             $input.="<option  " . $selected . "  value='" . $tax->term_id . "' >".$tax->name."</option>";
                        }
                     
                    }else{
                         if(isset($current_value)){
                                if($tax->term_id == $current_value)
                                     $selected='SELECTED';   
                                 }
                             $input.="<option  " . $selected . "  value='" . $tax->term_id . "' >".$tax->name."</option>";
                    }
                }
                
                $input.="</select><small>{$desc}</small></li>";
                break;     

                case 'selectmultitax':
                
                $input = "<li><label>{$label}</label><select name='{$name}' id='custom-field-{$key}' class='chosen' multiple>";
                
                $args= array(
                    'hide_empty'    => false
                    );

                $taxs= get_terms($taxonomy,$args);
                foreach($taxs as $tax){
                    $selected='';
                    //in_array($tax->term_id, $current_value)?'SELECTED':''
                     if(is_array($current_value)){
                        if(in_array($tax->term_id,$current_value))
                             $selected='SELECTED';   
                    }else{
                        if($tax->term_id == $current_value)
                             $selected='SELECTED';   
                    }

                     $input.="<option  " . $selected . "  value='" . $tax->term_id . "' >".$tax->name."</option>";
                    }
                
                $input.="</select><small>{$desc}</small></li>";
                break;    

                
            case 'checkbox':
                $input = "<li><label>{$label}</label>";
                foreach ($options as $option)
                    $input.="<label>{$option['label']}</label><input type='checkbox' name='{$name}' " . checked($option['value'], $current_value, false) . "  value='" . $option['value'] . "' /><small>{$desc}</small></li>";

                break;

            case 'date':
                $input = "<li><label>{$label}</label><input type='text' class='vibe-front-end-post-date'  id='custom-field-{$key}' name='{$name}' value='{$current_value}' /><small>{$desc}</small></li>";
                break;
            case 'hidden':
                $input = "<li><input type='hidden' class='vibe-front-end-post-hidden'  id='custom-field-{$key}' name='{$name}' value='{$current_value}' /></li>";
                break;

            case 'gmap':
                $input = "<li><label>{$label}</label>";
                global $vibe_options;
                $zoom=(isset($vibe_options['zoomlevel'])?$vibe_options['zoomlevel']:15);
                $default_ll=vibe_get_option('default_ll'); 
                $las = explode(',', $default_ll);

                if(is_array($current_value[0]))
                    $current_value =$current_value[0];
                
                $input .= "<script type='text/javascript'>
                                    jQuery(function() {;

                                    if(typeof google != 'undefined'){
                                    var geocoder = new google.maps.Geocoder();

                                    function geocodePosition(pos) {
                                      geocoder.geocode({
                                        latLng: pos
                                      }, function(responses) {
                                        if (responses && responses.length > 0) {
                                            var address = '',city = '', state = '', zip = '', country = '', formattedAddress = '';
                                                         for (var i = 0; i < responses[0].address_components.length; i++) {
                                                              var addr = responses[0].address_components[i];
                                                              // check if this entry in address_components has a type of country
                                                              if (addr.types[0] == 'country'){
                                                                  document.getElementById('country').value = addr.long_name;
                                                                  country = addr.long_name;
                                                              }else if (addr.types[0] == 'postal_code'){       // Zip
                                                                  document.getElementById('pincode').value = addr.short_name;
                                                                  zip = addr.long_name;
                                                              }else if (addr.types[0] == ['administrative_area_level_1']){       // State
                                                                  document.getElementById('state').value = addr.long_name;
                                                                  state = addr.long_name;
                                                              }else if (addr.types[0] == ['locality']){       // City
                                                                  document.getElementById('city').value = addr.long_name;
                                                                  city = addr.long_name;
                                                                  }
                                                          }
                                                          
                                          var staddr=responses[0].formatted_address;
                                          staddr=staddr.replace(country,'');staddr=staddr.replace(zip,'');staddr=staddr.replace(city,'');staddr=staddr.replace(state,'');
                                          staddr=staddr.replace(', ,','');
                                          document.getElementById('staddress').value = staddr;                
                                          updateMarkerAddress(responses[0].formatted_address);
                                        } else {
                                          updateMarkerAddress('Cannot determine address at this location.');
                                        }
                                      });
                                    }

                                    function updateMarkerStatus(str) { 
                                    }

                                    function updateMarkerPosition(latLng) {

                                      document.getElementById('latitude').value = latLng.lat();
                                      document.getElementById('longitude').value =  latLng.lng();

                                    }

                                    function updateMarkerAddress(str) {
                                        if(str != null)
                                        document.getElementById('address').innerHTML = str;
                                    }

                                    function initialize() {
                                    var lat;var lng;
                                    ".(isset($current_value['latitude'])?"lat= ".$current_value['latitude']:'')." ;

                                    
                                    lat = lat || +37.0625;
                                    if(isNaN(lat))
                                     lat=37.0625;
                                     
                                    ".(isset($current_value['longitude'])?"lng= ".$current_value['longitude']:'')." ;

                                    
                                    lng = lng || -95.677068;
                                    if(isNaN(lng))
                                     lng= -95.677068;


                                      var latLng = new google.maps.LatLng(lat,lng);
                                      var map = new google.maps.Map(document.getElementById('mapCanvas'), {
                                        zoom: ".$zoom.",
                                        center: latLng,
                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                      });
                                      var marker = new google.maps.Marker({
                                        position: latLng,
                                        title: 'Property',
                                        map: map,
                                        draggable: true
                                      });
                                      
                                      // Update current position info.
                                      updateMarkerPosition(latLng);
                                      geocodePosition(latLng);
                                      
                                      // Add dragging event listeners.
                                      google.maps.event.addListener(marker, 'dragstart', function() {
                                        updateMarkerAddress('Dragging...');
                                      });
                                      
                                      google.maps.event.addListener(marker, 'drag', function() {
                                        updateMarkerStatus('Dragging...');
                                        updateMarkerPosition(marker.getPosition());
                                      });
                                      
                                      google.maps.event.addListener(marker, 'dragend', function() {
                                        updateMarkerStatus('Drag ended');
                                        geocodePosition(marker.getPosition());
                                        
                                      });
                                    }
                                        
                                    // Onload handler to fire off the app.
                                    google.maps.event.addDomListener(window, 'load', initialize);
                                    }
                                });
                            </script>";
                
                
                                                    $default_ll=vibe_get_option('default_ll'); 
                                                    $las = explode(',', $default_ll);
                                                    isset($las[0])? $lat = $las[0]: $lat ='37.0625';
                                                    isset($las[1])? $long = $las[1]: $long ='-95.677068';

                                                    $city = $state = 'New York';$country = 'United States'; $pincode='22005';$staddress ='';
                                                       if(isset($current_value)){
                                                           if(isset($current_value['latitude']))
                                                              $lat =  esc_attr( $current_value['latitude'] );
                                                           if(isset($current_value['latitude']))     
                                                               $long =  esc_attr( $current_value['longitude'] );
                                                           if(isset($current_value['staddress']))     
                                                               $staddress =  esc_attr( $current_value['staddress'] );
                                                           if(isset($current_value['city']))     
                                                               $city =  esc_attr( $current_value['city'] );
                                                           if(isset($current_value['state']))     
                                                               $state =  esc_attr( $current_value['state'] );
                                                           if(isset($current_value['pincode']))     
                                                               $pincode =  esc_attr( $current_value['pincode'] );
                                                           if(isset($current_value['country']))     
                                                               $country =  esc_attr( $current_value['country'] );
                                                           
                                                       }
                           $input .='<div id="mapCanvas"></div>
                                    <div id="infoPanel">
                                    <h4>Current position:</h4>
                                    <div class="markerStatus"></div>
                                                <label  style="display:block;width:200px;float:left;">'.__('Latitude','vibe').'</label><input type="text" class="text" id="latitude" name="' . $name . '[latitude] value="' . $lat . '" size="20"  />
                                                <label  style="display:block;width:200px;float:left;">'.__('Longitude','vibe').'</label><input type="text" class="text" id="longitude" name="' . $name . '[longitude]" value="' . $long . '" size="20"  />     
                                                <br /><b  style="width:200px;float:left;">'.__('Closest Matching Address','vibe').'</b>
                                                <div id="address"></div>    
                                                <br />
                                                <label style="width:200px;float:left;">'.__('Street Address','vibe').'</label><input type="text" class="text" id="staddress" name="' . $name . '[staddress]" value="' . $staddress . '" size="20"  />     <br />
                                                <label style="width:200px;float:left;">'.__('City','vibe').'</label><input type="text" class="text" id="city" name="' . $name . '[city]" value="' . $city . '" size="20"  />     <br />
                                                <label style="width:200px;float:left;">'.__('State','vibe').'</label><input type="text" class="text" id="state" name="' . $name . '[state]" value="' . $state . '" size="20"  />     <br />
                                                <label style="width:200px;float:left;">'.__('Zip/Pin Code','vibe').'</label><input type="text" class="text" id="pincode" name="' . $name . '[pincode]" value="' . $pincode . '" size="20"  />     <br />
                                                <label style="width:200px;float:left;">'.__('Country','vibe').'</label><input type="text" class="text" id="country" name="' . $name . '[country]" value="' . $country . '" size="20"  />         <br />
                                              </div>';
                break;

            default:
                $input = '';
        }
        return $input;//return html
    }

    /**
     * Get a validated value for the custom field data
     * 
     * @param type $key
     * @param type $value
     * @param type $data
     * @return string 
     */
    function get_validated($key, $value, $data) {

        extract($data, EXTR_SKIP);
        $sanitized = '';

        switch ($type) {
            case 'textbox':
            case 'readonly':
            case 'number':
            case 'date':
            case 'agents':
            case 'textarea':
            case 'hidden':
                $sanitized = esc_attr($value); //should we escape?   
                break;

            break;    
            case 'radio':
            case 'select':

                foreach ($options as $option)
                    if ($option['value'] == $value)
                        $sanitized = $value;

                break;

            case 'multiselect':
                $vals = array();
                foreach ($options as $option)
                    if (in_array($option['value'],$value) || in_array($option,$value))
                        $vals[] = $option['value'];

                    $sanitized = $vals;//array_diff($vals, (array) $vals);
                break;    

               
           //for checkbox    
            case 'checkbox':
                $vals = array();
                foreach ($options as $option)//how to validate
                    $vals[] = $option['value'];

                $sanitized = array_diff($vals, (array) $vals);

                break;


            default:
                $sanitized = $value;
                break;
        }
        return $sanitized;
    }

    /**
     * Handles Upload
     * @param type $post_id
     * @param type $input_field_name
     * @param type $action
     * @return type 
     */
    function handle_upload($post_id, $input_field_name, $action) {
        require_once( ABSPATH . 'wp-admin/includes/admin.php' );
        $post_data = array();
        $override = array('test_form' => false, 'action' => $action);
        $attachment = media_handle_upload($input_field_name, $post_id, $post_data, $override);

        return $attachment;
    }

  /**
     *
     * @see wp-admin/includes/template.php:wp_terms_checklist
     * modified to include categories
     * @param type $post_id
     * @param type $args 
     */
    function wp_terms_checklist($post_id = 0, $args = array()) {
        $defaults = array(
            'descendants_and_self' => 0,
            'selected_cats' => false,
            'popular_cats' => false,
            'walker' => null,
            'include' => array(),
            'taxonomy' => 'category',
            'checked_ontop' => true
        );
        extract(wp_parse_args($args, $defaults), EXTR_SKIP);

        if (empty($walker) || !is_a($walker, 'Walker'))
            $walker = new BPSimplePostTermsChecklistWalker;//custom walker

        $descendants_and_self = (int) $descendants_and_self;

        $args = array('taxonomy' => $taxonomy);

        $tax = get_taxonomy($taxonomy);
        $args['disabled'] =false;//allow everyone to assign the tax !current_user_can($tax->cap->assign_terms);

        if (is_array($selected_cats))
            $args['selected_cats'] = $selected_cats;
        elseif ($post_id)
            $args['selected_cats'] = wp_get_object_terms($post_id, $taxonomy, array_merge($args, array('fields' => 'ids')));
        else
            $args['selected_cats'] = array();

        if (is_array($popular_cats))
            $args['popular_cats'] = $popular_cats;
        else
            $args['popular_cats'] = get_terms($taxonomy, array('fields' => 'ids', 'orderby' => 'count', 'order' => 'DESC', 'number' => 10, 'hierarchical' => false));

        if ($descendants_and_self) {
            $categories = (array) get_terms($taxonomy, array('child_of' => $descendants_and_self, 'hierarchical' => 0, 'hide_empty' => 0));
            $self = get_term($descendants_and_self, $taxonomy);
            array_unshift($categories, $self);
        } else {

            $categories = (array) get_terms($taxonomy, array('get' => 'all', 'include' => $include));
        }

        echo "<div class='simple-post-tax-wrap simple-post-tax-{$taxonomy}-wrap'>
        <h3>{$tax->labels->singular_name}</h3>";
        echo "<div class='simple-post-tax simple-post-tax-{$taxonomy}'>";
        
        echo "<ul class='simple-post-tax-check-list'>";

        if ($checked_ontop) {
            // Post process $categories rather than adding an exclude to the get_terms() query to keep the query the same across all posts (for any query cache)
            $checked_categories = array();
            $keys = array_keys($categories);

            foreach ($keys as $k) {
                if (in_array($categories[$k]->term_id, $args['selected_cats'])) {
                    $checked_categories[] = $categories[$k];
                    unset($categories[$k]);
                }
            }

            // Put checked cats on top
            echo call_user_func_array(array(&$walker, 'walk'), array($checked_categories, 0, $args));
        }
        // Then the rest of them
        echo call_user_func_array(array(&$walker, 'walk'), array($categories, 0, $args));
        echo "</ul></div></div>";
    }
    
    /**
     * Used to generate terms dropdown
     * 
     * @param type $args
     * @return string 
     */

    function list_terms_dd($args) {
        $defaults = array(
            'show_option_all' => 1,
            'selected' => 0,
            'hide_empty' => false,
            'echo' => false,
            'include' => false,
            'hierarchical' => true,
            'select_label' => false,
            'show_label' => true
        );

        $args = wp_parse_args($args, $defaults);
        extract($args);
        $excluded = false;
        if (is_array($selected))
            $selected = array_pop($selected); //in dd, we don't allow multipl evaues at themoment

        if (!empty($include))
            $excluded = array_diff((array) get_terms($taxonomy, array('fields' => 'ids', 'get' => 'all')), $include);
        $tax = get_taxonomy($taxonomy);
        if ($show_option_all) {

            if (!$select_label)
                $show_option_all = sprintf(__('Select %s', 'bpsep'), $tax->labels->singular_name);
            else
                $show_option_all = $select_label;
        }
        $always_echo = false;
        if (empty($name))
            $name = 'tax_input[' . $taxonomy . ']';

        $taxargs=array('taxonomy' => $taxonomy, 'hide_empty' => $hide_empty, 'name' => $name, 'id' => 'vibe-post-' . $taxonomy, 'selected' => $selected, 'show_option_all' => $show_option_all, 'echo' => false, 'excluded' => $excluded, 'hierarchical' => $hierarchical);
        
        

        $info = wp_dropdown_categories($taxargs);

        $html="<div class='simple-post-tax-wrap simple-post-tax-{$taxonomy}-wrap'>";
        if ($show_label)
            $info = "<div class='simple-post-tax simple-post-tax-{$taxonomy}'><h3>{$tax->labels->singular_name}</h3>" . $info . "</div>";
         $html=$html.$info."</div>";
        if ($echo){
            echo $html;
        }else
            return $html;
    }
    /***
     * Some utility functions for template
     */
    /**
     * Has taxonomy/terms to process
     * @return type 
     */
    function has_tax(){
        if(!empty($this->tax)&&is_array($this->tax))
                return true;
        return false;
    }
    
    function has_custom_fields(){
         if(!empty($this->custom_fields))
                 return true;
         return false;
    }
    /**
     * Generate the taxonomy dd/checkbox for template
     */
    function render_taxonomies(){
            $post_id=$this->get_post_id();
             foreach((array)$this->tax as $tax=>$tax_options){
                 //something is wrong here
                  /*  if(!empty($post_id))
                        $tax_options['include']=*/
                     

                     $tax_options['taxonomy']=$tax;

                     if(isset($tax_options['include']))
                        $tax_options['include']=(array)$tax_options['include'];

                    if($tax_options['view_type']&&$tax_options['view_type']=='dd'){
                            if($post_id){
                                $tax_options['selected']=$this->get_term_ids($post_id,$tax);//array_pop($tax_options['include']);
                            }
                            elseif($_POST['tax_input'][$tax]){
                                //if this is form submit and some taxonomies were selected
                                $tax_options['selected']=$_POST['tax_input'][$tax];
                            }

                            if(!empty($tax_options['include'])){
                                $tax_options['show_all_terms']=0;   
                            }
                            

                          echo $this->list_terms_dd($tax_options);
                    }else{
                        //for checklist
                        
                         if(isset($_POST['tax_input'][$tax])&&!empty($_POST['tax_input'][$tax])){
                                //if this is form submit and some taxonomies were selected
                                $tax_options['selected_cats']=$_POST['tax_input'][$tax];
                            }
                          if(isset($_GET['parent_course_id'])){
                                $cid=$_GET['parent_course_id'];
                                $pmid = get_post_meta($cid,'module',true);
                                if(isset($pmid) && $pmid !=''){
                                    $tax_options['descendants_and_self']=$pmid;
                                }
                            }  
                        $this->wp_terms_checklist($post_id,$tax_options);

                    }   
                    //$selected=wp_get_object_terms($ticket_id, $taxonomy,array('fields' => 'ids'));
                // $selected=  array_pop($selected);
                
                
             }   
                
        
    }
    
    
    function render_custom_fields(){
        $post_id=$this->get_post_id();
        echo '<ul>';
        foreach($this->custom_fields as $key=>$field){
             $val=false;

             if($field['default'])
                $val=$field['default'];

             if($post_id){
                $single=true;

               if($field['type']=='checkbox' || $field['type']=='multiselect' || $field['type']=='gmap')
                    $single=false;
               
               $val=get_post_meta($post_id,$key,$single);


             }
            $field['key']=$key;
            
            echo  $this->render_field($field,$val);
                       
        }
        echo '</ul>';             
    }

}

//end of class

/**
 * A Taxonomy Walker class to fix the input name of the taxonomy terms
 * 
 */
class BPSimplePostTermsChecklistWalker extends Walker {

    var $tree_type = 'category';
    var $db_fields = array('parent' => 'parent', 'id' => 'term_id'); //TODO: decouple this

    function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent<ul class='children'>\n";
    }

    function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    function start_el(&$output, $category, $depth, $args, $id = 0) {
        extract($args);
        if (empty($taxonomy))
            $taxonomy = 'category';


        $name = 'tax_input[' . $taxonomy . ']';

        $class = in_array($category->term_id, $popular_cats) ? ' class="popular-category"' : '';
        $output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit"><input value="' . $category->term_id . '" type="checkbox" name="' . $name . '[]" id="in-' . $taxonomy . '-' . $category->term_id . '"' . checked(in_array($category->term_id, $selected_cats, false), true, false) . disabled(empty($args['disabled']), false, false) . ' /> ' . esc_html(apply_filters('the_category', $category->name)) . '</label>';
    }

    function end_el(&$output, $category, $depth = 0, $args = array()) {
        $output .= "</li>\n";
    }

}

//API for general use
/**
 * Create and Register a New Form Instance, Please make sure to call it before bp_init action to make the form available to the controller logic
 * @param type $form_name:string, a unique name, It can contain letters or what ever eg. my_form or my form or My Form 123
 * @param type $settings:array,It governs what is shown in the form and how the form will be handled, possible values are
 *  array('post_type'=>'post'|'page'|valid_post_type,'post_status'=>'draft'|'publish'|'valid_post_status','show_categories'=>true|false,'current_user_can_post'=>true|false
 * @return VibeFrontPostEditForm 
 */
function vibe_new_front_post_form($form_name, $settings) {

    $form = new VibeFrontPostEditForm($form_name, $settings);
    $editor = VibeFrontPostEditor::get_instance();
    $editor->register_form($form);

    return $form;
}

//get a referenace to a particular form instance
function vibe_get_front_post_form($name) {
    $editor = VibeFrontPostEditor::get_instance();
    return $editor->get_form_by_name($name);
}

//get a referenace to a particular form instance
function vibe_get_front_post_form_by_id($form_id) {
    $editor = VibeFrontPostEditor::get_instance();
    return $editor->get_form_by_id($form_id);
}

VibeFrontPostComponent::get_instance();
?>