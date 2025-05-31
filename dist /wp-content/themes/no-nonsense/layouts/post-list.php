<article <?php post_class( 'box layout-post-list' ) ?>>
	<?php if( has_post_thumbnail() ) : ?>
	<header>
		<div class='item-image-title'>
			<h2><a href='<?php the_permalink() ?>'><?php the_title() ?></a></h2>
		</div>
		<a href='<?php the_permalink() ?>' class='hoverlink'>
			<?php the_post_thumbnail() ?>
		</a>
	</header>
	<?php endif ?>



	<div class='box-content'>

		<?php if( !has_post_thumbnail() ) : ?>
		<h2 class='item-title'><a href='<?php the_permalink() ?>'><?php the_title() ?></a></h2>
		<?php endif ?>

		<div class='user-content'>
			<?php the_excerpt() ?>
		</div>

	</div>

	<footer>
		<span class='meta meta-time'>
			<a href='<?php the_permalink() ?>'><?php the_time( get_option( 'date_format' ) ) ?></a>
		</span>
		<span class='meta meta-author'>
			<?php the_author() ?>
		</span>
		
		<?php if( has_category() ) : ?> 
		<span class='meta meta-category'>
			<?php the_category( ', ' ) ?>
		</span>
		<?php endif ?>

		<span class='meta meta-comment'>
			<?php comments_number( __( 'No Comments', 'no-nonsense' ), __( '1 Comment', 'no-nonsense' ), __( '% Comments', 'no-nonsense' )  ) ?>
		</span>

	</footer>
</article>