(function($) {

	$(function() {
	
		new FLBuilderPostGrid({
			id: '<?php echo $id ?>',
			layout: '<?php echo $settings->layout; ?>',
			pagination: '<?php echo $settings->pagination; ?>',
			postSpacing: '<?php echo $settings->post_spacing; ?>',
			postWidth: '<?php echo $settings->post_width; ?>',
			matchHeight: '<?php echo $settings->match_height; ?>',
			showFilters: <?php echo $settings->show_filters; ?>
		});

		var getCategoryFilter = null,
			categoryFilter = '',
			categoryFilterClass = '',
			acceleratorFilter = '',
			acceleratorFilterClass = '';


		$('.cat-item').find('a').on('click', function(e){

			e.preventDefault();

			$('.cat-item').removeClass('selected');
			$(this).parent().addClass('selected');

			categoryFilter = $(this).attr('class');
			if (categoryFilter == 'all') {
				categoryFilterClass = '';
			}
			else {
				categoryFilterClass = '.' + categoryFilter;
			}

			var $grid = jQuery('.fl-post-grid, .fl-post-gallery');
			$grid.isotope({ filter: categoryFilterClass + acceleratorFilterClass });

			// display message box if no filtered items are found
			if ( $grid.data('isotope').filteredItems.length === 0 ) {
			  $('.fl-post-grid-empty').show();
			}
			else {
			  $('.fl-post-grid-empty').hide();
			}
		});

		$('.accel-item').find('a').on('click', function(e){

			e.preventDefault();

			$('.accel-item').removeClass('selected');
			$(this).parent().addClass('selected');

			acceleratorFilter = $(this).attr('class');
			if (acceleratorFilter == 'all') {
				acceleratorFilterClass = '';
			}
			else {
				acceleratorFilterClass = '.' + acceleratorFilter;
			}

			var $grid = jQuery('.fl-post-grid, .fl-post-gallery');
			$grid.isotope({ filter: categoryFilterClass + acceleratorFilterClass });

			// display message box if no filtered items are found
			if ( $grid.data('isotope').filteredItems.length === 0 ) {
			  $('.fl-post-grid-empty').show();
			}
			else {
			  $('.fl-post-grid-empty').hide();
			}
		});

	});

	<?php if($settings->layout == 'grid') : ?>
	$(window).on('load', function() {
		$('.fl-node-<?php echo $id; ?> .fl-post-<?php echo $settings->layout; ?>').isotope('reloadItems');
	});
	<?php endif; ?>
	
})(jQuery);