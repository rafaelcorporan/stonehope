<?php $primary_color = get_tvelements_option('primary_color'); ?>
<?php $secondary_color = get_tvelements_option('secondary_color'); ?>
<?php $background_color = get_background_color(); ?>
<style type="text/css">

	<?php if( $primary_color ) : ?>
	h1,h2,h3,h4,h5,h6,
	.item-wrapper .section-title a,
	.entry-footer-meta,
	.pagination a .dashicons,
	#comments .comments-title,
	.pagination .pagenums .diag,
	.entry-footer-meta ul li a {
  		color: <?php echo $primary_color; ?>;
	}
	<?php endif; ?>
	<?php if( $secondary_color ) : ?>
	a:hover,
	.video-meta,
	.entry-meta,
	.entry-footer-meta span a,
	.pagination .pagenums span,
	.pagination a:hover .dashicons,
	.item-wrapper .section-title a:hover,
	.comment-list li .comment-body .comment-author a,
	.comment-list li .comment-body .comment-metadata a,
	.post-password-form input[type=submit]:hover,
	.gform_button:hover,
	.btn:hover {
		color: <?php echo $secondary_color; ?>;
	}
	.post-password-form input[type=submit]:hover,
	.gform_button:hover,
	.btn:hover {
		border-color: <?php echo $secondary_color; ?>;
	}
	<?php endif; ?>

	<?php if($background_color) : ?>
	#page {
		background-color: #<?php echo $background_color; ?>;
	}
	<?php endif; ?>
}
</style>