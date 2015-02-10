<?php if($this->current_user_can_post ): 
   
    ?>

        <div class="bp-simple-post-form">
       
        <form class="standard-form bp-simple-post-form"  method="post" action=""  enctype="multipart/form-data">
            
            <!-- do not modify/remove the line blow -->
            <input type="hidden" name="bp_simple_post_form_id" value="<?php echo $this->id;?>" />
            <?php wp_nonce_field( 'bp_simple_post_new_post_'.$this->id ); ?>
            <input type="hidden" name="action" value="bp_simple_post_new_post_<?php echo $this->id;?>" />
            <?php if($post_id):?>
                <input type="hidden" name="post_id" value="<?php echo $post_id;?>" />
            <?php endif;?>
                    
             <!-- you can modify these, just make sure to not change the name of the fields -->
             
             <label for="bp_simple_post_title"><?php _e('Title:','vibe');?>
                <input type="text" name="bp_simple_post_title"  value="<?php echo $title;?>"/>
             </label>
            
             <label for="bp_simple_post_text" ><?php _e('Content:','vibe');?>

               <?php

               $settings = array(
                    'wpautop' => true,
                    'media_buttons' => true,
                    'tinymce' => array(
                        'theme_advanced_buttons1' => 'save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect',
                        'theme_advanced_buttons2' => "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
                        'theme_advanced_buttons3' => "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
                        'theme_advanced_buttons4' => "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
                        'theme_advanced_text_colors' => '0f3156,636466,0486d3',
                    ),
                    'quicktags' => array(
                        'buttons' => 'b,i,ul,ol,li,link,close'
                    )
                );

               $editor_id = 'bp_simple_post_text';
               wp_editor($content, $editor_id,$settings);
               ?>

                <!--textarea name="bp_simple_post_text" id="bp_simple_post_text" ><?php echo $content; ?></textarea-->
             </label>
             <!--- generating the file upload box -->
            <?php if(count($this->upload_array)):?>
            
                <label> <?php _e('Uploads','vibe');?></label>
                
                
                <div class="bp_simple_post_uploads_input">
                    <ul>
                 <?php 
                 foreach($this->upload_array as $key=>$value):?>
                    <li><label><?php echo $value; ?></label>
                    <?php
                      if(isset($post_id) && $key == 'thumbnail'){
                        the_post_thumbnail($post_id,'thumbnail');
                      }else{

                        $aid=get_post_meta($post_id,$key,true);
                        echo $key.'#'.$aid;
                        if(wp_attachment_is_image($aid)){
                            echo echo wp_get_attachment_image($aid);
                        }
                      }
                    ?><input type="file" name="<?php echo $key;?>" /></li>
                <?php endforeach;?>
               </ul>
                </div>
            <?php endif;?>
                         
            <?php if($this->has_tax()):?>
                <div class='simple-post-taxonomies-box clearfix'>
                <?php $this->render_taxonomies();?>
                    <div class="clear"></div>
                </div>   
            <?php endif;?>   
           
            <?php //custom fields ?>
           <?php if($this->has_custom_fields()):?>
           <?php echo "<div class='simple-post-custom-fields'>";?>     
                <h3>Extra Info</h3>
                   <?php $this->render_custom_fields();?>
            <?php echo "</div>";?>    
           <?php endif;?>     
                
            <?php if($this->show_comment_option):?>
                <div class="simple-post-comment-option">
                    <h3>Allow Comments</h3>
                    <?php $current_status=$this->comment_status;
                        if($post_id){
                            $post=  get_post($post_id);
                            $current_status=$post->comment_status;
                        }
                   ?>
                                    
                        <label for="bp-simple-post-comment-status">
                        <input id="bp-simple-post-comment-status" name="bp_simple_post_comment_status" type="checkbox" value="open" <?php echo checked('open',$current_status);?> /> Yes
                   </label>
                    
                </div>   
                
            <?php endif;?>
                
            <input  type="hidden" value="<?php echo $_SERVER['REQUEST_URI']; ?>" name="post_form_url"  />

            <input id="submit" name='bp_simple_post_form_subimitted' type="submit" value="<?php _e('Create Course','vibe');?>" />

           
        </form>
        </div>
      <?php
        
    endif;
    ?>