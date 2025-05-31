<article <?php post_class( 'box layout-post-list' ) ?>>
	<?php if( has_post_thumbnail() ) : ?>
	<header>
		<div class='item-image-title'>
			<h2><?php the_title() ?></h2>
		</div>
		<?php the_post_thumbnail() ?>
	</header>
	<?php endif ?>



	<div class='box-content'>

		<?php if( !has_post_thumbnail() ) : ?>
		<h2 class='item-title'><?php the_title() ?></h2>
		<?php endif ?>

		<div class='user-content'>
			<?php the_content() ?>
		</div>

		<?php wp_link_pages() ?>

		<div class='post-links'>
			<div class='prev'>
			<?php previous_post_link(); ?>
			</div>
			<div class='next'>
			<?php next_post_link(); ?>
			</div>
		</div>

	</div>

	<footer>
		<span class='meta meta-time'>
			<i class='fa fa-clock-o'></i> 
			<?php the_time( get_option( 'date_format' ) ) ?>
		</span>
		<span class='meta meta-author'>
			<i class='fa fa-user'></i> 
			<?php the_author() ?>
		</span>
		
		<?php if( has_category() ) : ?> 
		<span class='meta meta-category'>
			<i class='fa fa-folder'></i> 
			<?php the_category( ', ' ) ?>
		</span>
		<?php endif ?>

		<span class='meta meta-comment'>
			<i class='fa fa-comment'></i> 
			<?php comments_number( __( 'No Comments', 'no-nonsense' ), __( '1 Comment', 'no-nonsense' ), __( '% Comments', 'no-nonsense' )  ) ?>
		</span>

		<?php if( has_tag() ) : ?> 
		<span class='meta meta-tag'>
			<i class='fa fa-tag'></i> 
			<?php the_tags( '' ) ?>
		</span>
		<?php endif ?>


	</footer>
</article>

<?php comments_template() ?>