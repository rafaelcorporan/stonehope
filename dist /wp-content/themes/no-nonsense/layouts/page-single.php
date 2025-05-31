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

	</div>

</article>

<?php comments_template() ?>