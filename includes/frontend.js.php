(function($) {

	$(function() {
	
		new FLBuilderPostGrid({
			id: '<?php echo $id ?>',
			layout: '<?php echo $settings->layout; ?>',
			pagination: '<?php echo $settings->pagination; ?>',
			postSpacing: '<?php echo $settings->post_spacing; ?>',
			postWidth: '<?php echo $settings->post_width; ?>',
			postHeight: '<?php echo $settings->post_height; ?>',
			matchHeight: '<?php echo $settings->match_height; ?>',
			showFilters: <?php echo $settings->show_filters; ?>
		});

		var	verticalFilter = '',
			verticalFilterClass = '',
			acceleratorFilter = '',
			acceleratorFilterClass = '';


		$('.verticals-item').find('a').on('click', function(e){

			e.preventDefault();

			$('.verticals-item').removeClass('selected');
			$(this).parent().addClass('selected');

			verticalFilter = $(this).attr('class');
			if (verticalFilter == 'all') {
				verticalFilterClass = '';
			}
			else {
				verticalFilterClass = '.' + verticalFilter;
			}

			var $grid = jQuery('.fl-post-grid, .fl-post-gallery');
			$grid.isotope({ filter: verticalFilterClass + acceleratorFilterClass });

			// display message box if no filtered items are found
			if ( $grid.data('isotope').filteredItems.length === 0 ) {
			  $('.fl-post-grid-empty').show();
			}
			else {
			  $('.fl-post-grid-empty').hide();
			}
		});

		$('.accelerators-item').find('a').on('click', function(e){

			e.preventDefault();

			$('.accelerators-item').removeClass('selected');
			$(this).parent().addClass('selected');

			acceleratorFilter = $(this).attr('class');
			if (acceleratorFilter == 'all') {
				acceleratorFilterClass = '';
			}
			else {
				acceleratorFilterClass = '.' + acceleratorFilter;
			}

			var $grid = jQuery('.fl-post-grid, .fl-post-gallery');
			$grid.isotope({ filter: verticalFilterClass + acceleratorFilterClass });

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