<?php
/**
 * The Template For Displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 **/
?>

<?php if ( post_password_required() ) : ?>
    <!-- Message --><div id="message" class="error"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'metrodir'); ?></div><!-- /Message -->
<?php return; endif; ?>

<?php if ( have_comments() ) : ?>

    <div class="title">
        <h2 id="comments-title">
            <?php
			    printf( _n( '1 Comment', '%1$s Comments', get_comments_number(), 'metrodir' ),
			    number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
			?>
        </h2>
    </div>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <div class="older-coments">
            <div class="nav-next"><?php next_comments_link( '<i class="fa fa-arrow-circle-right"></i>'.__( 'Newer Comments', 'metrodir' ) ); ?></div>
            <div class="nav-previous"><?php previous_comments_link( '<i class="fa fa-arrow-circle-left"></i>'.__( 'Older Comments', 'metrodir' ) ); ?></div>
        </div>
    <?php endif;?>

	<ul class="commentlist">
	    <?php wp_list_comments( array( 'callback' => 'metrodir_comment' ) ); ?>
	</ul>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
        <div class="older-coments">
            <div class="nav-next"><?php next_comments_link( '<i class="fa fa-arrow-circle-right"></i>'.__( 'Newer Comments', 'metrodir' ) ); ?></div>
            <div class="nav-previous"><?php previous_comments_link( '<i class="fa fa-arrow-circle-left"></i>'.__( 'Older Comments', 'metrodir' ) ); ?></div>
        </div>
    <?php endif;?>

    <?php if ( ! comments_open() && get_comments_number() ) : ?>
        <!-- Message --><div id="message" class="error"><?php _e('Comments are closed.', 'metrodir'); ?></div><!-- /Message -->
	<?php endif;  ?>

<?php endif; ?>

<div id="comment-message" class="comment-message">
    <?php
        $commenter = wp_get_current_commenter();
        $req = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
        $fields =  array(
            'author' => '<input id="author" class="text-input-grey one-line" name="author" type="text" value="'.
                esc_attr( $commenter['comment_author'] ).
                '" size="30"'.
                $aria_req.
                ' placeholder="'.
                __( 'Name', 'metrodir' ).
                '*"/>',
            'email'  => '<input id="email" class="text-input-grey one-line" name="email" type="text" value="'.
                esc_attr(  $commenter['comment_author_email'] ).
                '" size="30"'.
                $aria_req.
                ' placeholder="'.
                __( 'Email', 'metrodir' ).
                '*" /><div class="clear"></div>',
            'url'    => '<input id="url" class="text-input-grey" name="url" type="text" value="'.
                esc_attr( $commenter['comment_author_url'] ).
                '" size="30" placeholder="'.
                __( 'Website', 'metrodir' ).
                '"/><div class="clear"></div>',
        );
        $comments_args = array(
            'fields'                =>  $fields,
            'title_reply'           => '<div class="title">'.__('Leave a Reply', 'metrodir').'</div>',
            'id_form'               => 'comment-message-form',
            'label_submit'          => __('Post Comment', 'metrodir'),
            'id_submit'             => 'button-2-green',
            'comment_notes_before'  => '',
            'comment_notes_after'   => '',
            'comment_field'         => '<textarea class="text-input-grey comment-message-main"  name="comment" cols="45" rows="8" aria-required="true" placeholder="' . __( 'Comment...', 'metrodir' ) . '"></textarea><div class="clear"></div>',
        );
        comment_form($comments_args);
    ?>
</div>