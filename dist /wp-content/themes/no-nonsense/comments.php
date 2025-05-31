<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package WordPress
 * @subpackage No Nonsense
 * @since No Nonsense 1.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php if( comments_open() || have_comments() ) : ?>
<div id="comments" class="comments-area box">

	<div class='box-content'>
		<?php if ( have_comments() ) : ?>

			<h3 id='comments-title'><?php
			printf(
			_n( 'One Comment', '%1$s Comments', get_comments_number(), 'no-nonsense' ),
			number_format_i18n( get_comments_number() )
			);
			?></h3>


			<ol class="commentlist">
				<?php wp_list_comments( array( 'callback' => 'nn_comments', 'style' => 'ul' ) ); ?>
			</ol>


			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
				<nav class="comment-navigation" role="navigation">
					<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'productlanch' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'productlanch' ) ); ?></div>
				</nav>
			<?php endif; ?>

			<?php
			if ( ! comments_open() && get_comments_number() ) : ?>
				<div class="nocomments alert-box primary-scheme">
					<?php _e( 'Comments are closed.' , 'productlanch' ); ?>
					<a href="" class="close">&times;</a>
				</div>
			<?php endif; ?>

		<?php endif ?>


		<h3 id='reply-title'><?php _e( 'Share Your Thoughts', 'no-nonsense' ) ?></h3>


		<?php 
			$args = array(
				'title_reply' => '',
				'comment_notes_before' => '',
				'comment_notes_after' => ''
			);
			comment_form( $args ); 
		?>

	</div>
</div>
<?php endif ?>