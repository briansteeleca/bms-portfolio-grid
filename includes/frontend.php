<?php
wp_reset_query();

function sort_display_order($a, $b) {
	if ($a->display_order == $b->display_order) {
			return 0;
	} elseif ($a->display_order < $b->display_order) {
			return -1;
	} else {
			return 1;
	}
}

// Get the query data.
$query = FLBuilderLoop::query($settings);

// Get the Portfolio Categories from settings – these will be used to get parent categories for filters
$category_ids_to_display = $settings->tax_portfolio_portfolio_category;
// Create an array of Portfolio Categories to determine the order to display them
$category_order = explode(',', $category_ids_to_display);

// Show filters if "Show Filters" option is set to Yes
if($settings->show_filters == '1' && $query->have_posts()) :
	// Display taxonomy terms for filtering portfolio grid
	$taxonomy = 'portfolio_category';
	// Get parent (top-level) terms for taxonomy
	if ( !empty( $category_ids_to_display )  ) :
		// Get the parent categories for filters based on Portfolio Categories in settings.
		// Note: Although non-parent Portfolio Categories can be selected in settings, only parent categories will be used as filters.
		$parent_terms = get_terms( $taxonomy, array( 'include' => $category_ids_to_display, 'parent' => 0 ) );

		if ($parent_terms) :
			// Loop through parent categories...
			foreach ($parent_terms as $index => $term) {
				// Get the display order of the parent categories based on the category order in the Portfolio Categories settings.
				$display_order  = array_search($parent_terms[$index]->term_id, $category_order);
				$parent_terms[$index]->display_order = $display_order;					
			}
			// ... And sort based on 'display_order'.
			usort($parent_terms, 'sort_display_order');
		endif;

	else :
		// TODO: remove this after we've updated Portfolio Categories in all sites. For now, leaving it for backwards compatibility.
		// If no Portfolio Categories are displayed, just find the first two.
		$parent_terms = get_terms( $taxonomy, array( 'parent' => 0, 'orderby'  => 'slug' ) );
	endif;
	?>

	<div class="filter-wrapper">

	<?php

	/* 
		There are two filter lists that are determined by the first two
		parent (top-level) categories. 
	*/

	if ( $parent_terms && !is_wp_error( $parent_terms ) ) :

		// Create the filter lists from parent (top-level) categories,
		// but only allow 2 filter lists (uses the first two).
		$counter = 0;
		foreach ( $parent_terms as $parent_term ) {

			if( $counter == 2) {
				break;
			}
			$counter++;

			$parent_term_id = $parent_term->term_id;
			$child_terms = get_terms( array( 'taxonomy' => 'portfolio_category', 'parent' => $parent_term_id ) );
			?>
			<ul class="filter-list filter-list-<?php echo $counter; ?>">
				<li class="<?php echo $parent_term->slug; ?>-item filter-item selected"><a class="all" href="#"><?php _e( 'All ', 'fl-builder' ); if($settings->show_category_for_all == '1' ) : echo $parent_term->name; endif; ?></a></li>
				<?php foreach ( $child_terms as $child_term ) { ?>
					<li class="<?php echo $parent_term->slug; ?>-item filter-item"><a class="<?php echo $child_term->slug ?>" href="<?php echo get_term_link($child_term->slug, $taxonomy); ?>"><?php echo $child_term->name; ?></a></li>
				<?php } ?>
			</ul>
		<?php
		}

	endif;
	?>

	</div><!-- filter-wrapper -->

<?php endif; ?>
 
<?php

// Render the posts.
if($query->have_posts()) :

?>
<div class="fl-post-<?php echo $settings->layout; ?> bms-portfolio-<?php echo $settings->layout; ?>" itemscope="itemscope" itemtype="http://schema.org/Blog">
	<?php

	while($query->have_posts()) {

		$query->the_post();
		
		include apply_filters( 'fl_builder_posts_module_layout_path', $module->dir . 'includes/post-' . $settings->layout . '.php', $settings->layout );
	}

	?>
	<div class="fl-post-grid-sizer"></div>
</div>
<div class="fl-clear"></div>
<?php endif; ?>

<?php

// Render the pagination.
if($settings->pagination != 'none' && $query->have_posts()) :

?>
<div class="fl-builder-pagination"<?php if($settings->pagination == 'scroll') echo ' style="display:none;"'; ?>>
	<?php FLBuilderLoop::pagination($query); ?>
</div>
<?php endif; ?>

<div class="fl-post-grid-empty" style="display:none">
	<?php 
	if (isset($settings->no_results_message)) :
		echo $settings->no_results_message;
	else :
		_e( 'No posts found.', 'fl-builder' );
	endif; 
	?>
</div>

<?php

wp_reset_postdata();

?>