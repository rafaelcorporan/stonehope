<?php
/**
 * The template for displaying search forms in tvelements
 *
 * @package tvelements
 */
?>
<form id="search" role="search" method="get" class="input-group" action="<?php echo esc_url( home_url( '/' ) ); ?>">

	<input type="search" class="form-control full" placeholder="<?php esc_attr_e( 'Search &hellip;', 'placeholder', 'tvelements' ); ?>" value="<?php esc_attr_e( get_search_query() ); ?>" name="s" title="<?php esc_attr_e( 'Search for:', 'tvelements' ); ?>">
	
</form>
