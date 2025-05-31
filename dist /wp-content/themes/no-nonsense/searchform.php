<?php
/**
 * The default search form
 * 
 * This form is used in such places as the search widget in the theme. It serves as the default search form.
 *
 * @package WordPress
 * @subpackage No Nonsense
 * @since No Nonsense 1.0
 */
?>
<form role="search" method="get" class="collapsed" action="<?php echo home_url() ?>">
	<input type="text" value="" name="s" id="s" placeholder="<?php _e( 'Search...', 'no-nonsense') ?>">
	<input type='submit' value='<?php _e( 'Search', 'no-nonsense' ) ?>'>
</form>