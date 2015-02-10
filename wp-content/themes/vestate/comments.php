<?php

/**
 * FILE: comments.php 
 * Created on Nov 1, 2012 at 7:08:03 PM 
 * Author: Mr.Vibe 
 * Credits: www.VibeThemes.com
 */
?>
<div id="comments">
    <a href="<?php echo get_post_comments_feed_link(' '); ?>" class="comments_rss"><i class="icon-rss-1"></i></a><h3 class="comments-title"><?php comments_number('0','1','%'); ?> Responses on "<?php the_title(); ?>"</h3>
  		   		<ol class="commentlist"> 
  		   		<?php 
                                    wp_list_comments('type=comment&avatar_size=120'); 
                                ?>	
  		   		</ol>	
                         <div class="navigation">
                            <div class="alignleft"><?php previous_comments_link() ?></div>
                            <div class="alignright"><?php next_comments_link() ?></div>
                        </div>
                        <?php
                        
                        $fields =  array(
        'author' => '<p><label class="comment-form-author clearfix">'.__( 'Name','vibe' ) . ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' . '<input class="form_field" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" /></p>',
        'email'  => '<p><label class="comment-form-email clearfix">'.__( 'Email','vibe' ) .  ( $req ? '<span class="required">*</span>' : '' ) . '</label> ' .          '<input id="email" class="form_field" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"/></p>',
        'url'   => '<p><label class="comment-form-url clearfix">'. __( 'Website','vibe' ) . '</label>' . '<input id="url" name="url" type="text" class="form_field" value="' . esc_attr( $commenter['comment_author_url'] ) . '"/></p>',
         );
               $comment_field='<p><label class="comment-form-textarea">'. __( 'Comment','vibe' ) . '</label>' . '<textarea id="comment" name="comment" class="form_field" rows="8" "></textarea></p>';

                comment_form(array('fields'=>$fields,'comment_field'=>$comment_field,'title_reply'=> '<span>'.__('Leave a Message','vibe').'</span>' ));
                ?>
</div>