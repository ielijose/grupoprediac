<?php if($this->current_user_can_post ): 
   
    ?>
        <div class="vibe-front-form">
       <?php
       $this->vibe_show_message();
       ?>
        <form class="standard-form vibe-front-form"  method="post" action=""  enctype="multipart/form-data">
            <!-- do not modify/remove the line blow -->
            <input type="hidden" name="vibe_front_form_id" value="<?php echo $this->id;?>" />
            <?php wp_nonce_field( 'vibe_front_new_post_'.$this->id ); ?>
            <input type="hidden" name="action" value="vibe_front_new_post_<?php echo $this->id;?>" />
            <?php if($post_id):?>
                <input type="hidden" name="post_id" value="<?php echo $post_id;?>" />
            <?php endif;?>
                    
             <!-- you can modify these, just make sure to not change the name of the fields -->
             
             <label for="vibe_front_title"><?php _e('Listing Title','vibe');?></label>
                <input type="text" name="vibe_front_title"  value="<?php echo $title;?>"/>
             
            
             <label for="vibe_front_text" ><?php _e('Listing Description','vibe');?> </label>

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

               $editor_id = 'vibe_front_text';
               wp_editor($content, $editor_id,$settings);
               ?>
            
             <!--- generating the file upload box -->
              <?php 

              if(count($this->upload_array)):?>
            
                <label> <?php _e('Uploads','vibe');?></label>
                
                
                <div class="vibe_front_uploads_input">
                    <ul>
                 <?php 
                 foreach($this->upload_array as $key=>$value):?>
                    <li><label><?php echo $value; ?></label>
                    <div class="thumbimage">
                    <?php
                      if(isset($post_id) && $key == 'thumbnail'){
                        echo get_the_post_thumbnail($post_id,'full');
                      }else{
                        $aid=get_post_meta($post_id,$key,true);
                        if(wp_attachment_is_image($aid)){
                            echo wp_get_attachment_image($aid);
                        }
                      }
                    ?></div>
                    <input type="file" name="<?php echo $key;?>" /></li>
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
                <h3><?php _e('Listing Information','vibe'); ?></h3>
                   <?php $this->render_custom_fields();?>
            <?php echo "</div>";?>    
           <?php endif;?>     
                
            <?php

              if(isset($post_id))
                  $button=__('Edit Listing','vibe');
              else  
                $button=__('Add Listing','vibe');

            ?>
                
            <input  type="hidden" value="<?php echo $_SERVER['REQUEST_URI']; ?>" name="post_form_url"  />

            <input id="submit" name='vibe_front_form_subimitted' type="submit" value="<?php 
            echo $button;
            ?>" />

        </form>
        </div>
      <?php
        
    endif;
    ?>