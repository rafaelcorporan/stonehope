<?php
/**
 * The template for displaying comments.
 *
 * @package tvelements
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php // You can start editing here -- including this comment! ?>
	<div class="comments-title">
		<strong class="upper">
			<?php
				printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'tvelements' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</strong>
	</div>

	<?php if ( have_comments() ) : ?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-above" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'tvelements' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'tvelements' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'tvelements' ) ); ?></div>
		</nav><!-- #comment-nav-above -->
		<?php endif; // check for comment navigation ?>

		<ol class="comment-list">
			<?php wp_list_comments( array( 'callback' => 'tvelements_comment' ) ); ?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'tvelements' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'tvelements' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'tvelements' ) ); ?></div>
		</nav><!-- #comment-nav-below -->
		<?php endif; // check for comment navigation ?>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'tvelements' ); ?></p>
	<?php endif; ?>

	<?php 
		ob_start();
		comment_form( 
			array(
				'comment_notes_after'=>'',
				'comment_field' => 
					'<div class="block comment-form-comment">' . 
					'<div class="col-sm-12 no-gutter"><textarea id="comment" name="comment" class="form-control" rows="8"></textarea>' .
					'</div></div>',
				'fields' => apply_filters( 'comment_form_default_fields', array(
			    'author' =>
					'<div class="block comment-form-author">' .
					'<div class="col-xs-8 no-gutter"><input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
					'" size="30" />' .
					'</div><div class="col-xs-4"><label for="author">' . __( 'Name', 'tvelements' ) . '</label> ' .
					( $req ? '<span class="required">*</span>' : '' ) .
					'</div></div>',
			
			    'email' =>
					'<div class="block comment-form-author">' .
					'<div class="col-xs-8 no-gutter"><input id="email" class="form-control" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
					'" size="30" />' .
					'</div><div class="col-xs-4"><label for="email">' . __( 'Email', 'tvelements' ) . '</label> ' .
					( $req ? '<span class="required">*</span>' : '' ) .
					'</div></div>',
			    )
			  ),
			)
		); 
		$string = ob_get_contents();
	    $string = str_replace('<h3 id="reply-title"', '<strong class="upper" ', $string);
	    $string = str_replace('</h3>', '</strong>', $string);
	    $string = str_replace('<input name="submit"', '<input class="btn btn-primary" name="submit" ', $string);
	    ob_end_clean();
	
	    // submit
	    echo $string;
	?>

</div><!-- #comments -->
