<?php
wp_reset_query();

// Get the query data.
$query = FLBuilderLoop::query($settings);

// Show filters if "Show Filters" option is set to Yes
if($settings->show_filters == '1' && $query->have_posts()) :

	// Display taxonomy terms for filtering portfolio grid
	$taxonomy = 'portfolio_category';
	// Get all terms for taxonomy
	$terms = get_terms($taxonomy);

	?>

	<div class="filter-wrapper">

	<?php

	if ( $terms && !is_wp_error( $terms ) ) :

	  foreach ( $terms as $term ) {

		// TODO: this is too specific for general use - should be an option
		if ($term->slug == 'vertical') : 

			$vertical_term = get_term_by( 'slug', 'vertical', $taxonomy);
			$vertical_term_id = $vertical_term->term_id; 
			$vertical_child_terms = get_terms( array( 'taxonomy' => 'portfolio_category', 'parent' => $vertical_term_id ) );
			?>
			<ul class="cat-list filter-list">
				<li class="cat-item filter-item selected"><a class="all" href="#"><?php _e( 'All Verticals', 'fl-builder' ); ?></a></li>
				<?php foreach ( $vertical_child_terms as $vertical_child_term ) { ?>
					<li class="cat-item filter-item"><a class="<?php echo $vertical_child_term->slug ?>" href="<?php echo get_term_link($vertical_child_term->slug, $taxonomy); ?>"><?php echo $vertical_child_term->name; ?></a></li>
				<?php } ?>
			</ul>
		<?php endif;

		// TODO: this is too specific for general use - should be an option
		if ($term->slug == 'accelerator') : 

			$accelerator_term = get_term_by( 'slug', 'accelerator', $taxonomy);
			$accelerator_term_id = $accelerator_term->term_id; 
			$accelerator_child_terms = get_terms( array( 'taxonomy' => 'portfolio_category', 'parent' => $accelerator_term_id ) );
			?>
			<ul class="accel-list filter-list">
				<li class="accel-item filter-item selected"><a class="all" href="#"><?php _e( 'All Accelerators', 'fl-builder' ); ?></a></li>
				<?php foreach ( $accelerator_child_terms as $accelerator_child_term ) { ?>
					<li class="accel-item filter-item"><a class="<?php echo $accelerator_child_term->slug ?>" href="<?php echo get_term_link($accelerator_child_term->slug, $taxonomy); ?>"><?php echo $accelerator_child_term->name; ?></a></li>
				<?php } ?>
			</ul>
		<?php endif;
	  }

	endif;
	?>

	</div><!-- filter-wrapper -->

<?php endif; ?>
 
<?php

// Render the posts.
if($query->have_posts()) :

?>
<div class="fl-post-<?php echo $settings->layout; ?>" itemscope="itemscope" itemtype="http://schema.org/Blog">
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

<div class="fl-post-grid-empty" style="display:none"><?php _e( 'No posts found. Please make your search less specific.', 'fl-builder' ); ?></div>

<?php

wp_reset_postdata();

?>