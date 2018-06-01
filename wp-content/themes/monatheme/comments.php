<?php
/*
  The comments page for Bones
 */

// don't load it if you can't comment
if (post_password_required()) {
    return;
}


/* * *********** COMMENT LAYOUT ******************** */

// Comment Layout
function mona_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    $bgauthemail = get_comment_author_email();
    $user = get_user_by('email', $bgauthemail);
   $name = @$user->data->display_name;
   if($user==false){
      $name =$comment->comment_author;
   }
    ?>
<li class="item" id="<?php echo 'comment-'. get_comment_ID();?>">

        <div class="img"><a href=""><?php echo mona_get_avatar_img(@$user->ID);  ?></a></div>
        <div class="content">
            <div class="subject">
                <h6 class="sub-title"><a href=""><?php echo $name; ?></a></h6>
                <p class="ago"><?php echo comment_time(''); ?></p>
            </div>
            <div class="detail">
                <div class="fz-15"> <?php comment_text() ?></div>
            </div>
             <?php //comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        </div>

    </li>
        <?php
    }
    ?>
    <div class="comment-box">
        <?php if (!is_user_logged_in()) {
     echo '<div class="mona-comment-no-login">';
        }
            ?><div class="title">
                <h3 class="fz-24 sub-title2"><?php _e('Để lại lời nhắn','monamedia');?></h3>
            </div>
            <div class="form">
                <?php
                comment_form(
                        array(
                            'comment_field' => ' <textarea id="comment" class="form-control" name="comment" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"></textarea>',
                            'class_submit' => 'btn',
                            'logged_in_as' => ' ',
                            'title_reply' => ' ',
                            'title_reply_to' => '',
                            'title_reply_before' => '',
                            'title_reply_after' => '',
                        )
                );
                ?>
            </div>
            <?php
      if (!is_user_logged_in()) {          echo '</div>'; }
        ?>

        <?php if (have_comments()) : ?>
        <div class="wp-temp-form-div" id="wp-temp-form-div">
            <ul class="comment__list">
                <?php
                wp_list_comments(array(
                    'style' => 'ul',
                    'short_ping' => true,
                    'avatar_size' => 40,
                    'callback' => 'mona_comments',
                    'type' => 'all',
                    'reply_text' => __('Reply', 'monamedia'),
                    'page' => '',
                    'per_page' => 5,
                    'reverse_top_level' => null,
                    'reverse_children' => ''
                ));
                ?>
            </ul>
</div>
            <?php
                paginate_comments_links(); ?>

            <?php if (!comments_open()) : ?>
                <p class="no-comments"><?php _e('Comments are closed.', 'monamedia'); ?></p>
            <?php endif; ?>

        <?php endif; ?>
    </div>


