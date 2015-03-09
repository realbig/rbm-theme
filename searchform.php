<?php
/**
 * The theme's search form.
 *
 * @since   0.1.0
 * @package RBMTheme
 */

// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die;
}
?>

<form role="search" method="get" class="search-form" action="<?php bloginfo( 'url' ); ?>">

	<div class="fields">
		<label class="search-field-label">
			<span class="screen-reader-text">Search for:</span>
			<input type="search" class="search-field" placeholder="Looking for something?" value="" name="s"
			       title="Search for:">
		</label>

		<button class="button tiny">
			Search
		</button>
	</div>
</form>