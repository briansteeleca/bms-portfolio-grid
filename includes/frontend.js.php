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

		/* 
			There are two filter lists that are determined by the first two
			parent (top-level) categories found in frontend.php 
		*/

		var portfolioItemFilterClass1 = '',
			portfolioItemFilterClass2 = '';

		// Filter List 1
		$('.filter-list-1 .filter-item').find('a').on('click', function(e){

			e.preventDefault();

			var	classList = $(this).parent('.filter-item').attr('class').split(/\s+/),
				filterItemClass1 = '', // filter item class use the parent category
				portfolioItemFilter1 = ''; // portfolio item filter uses the child categories

			// Get the specific filter item class (the one other than the generic '.filter-item' class)
			$.each(classList, function(index, item) {
			    if (item !== 'filter-item') {
			        filterItemClass1 = '.' + item;
			    }
			});
			
			$(filterItemClass1).removeClass('selected');
			$(this).parent().addClass('selected');

			var portfolioItemFilter1 = $(this).attr('class');
			if (portfolioItemFilter1 == 'all') {
				portfolioItemFilterClass1 = '';
			}
			else {
				portfolioItemFilterClass1 = '.' + portfolioItemFilter1;
			}

			var $grid = jQuery('.fl-post-grid, .fl-post-gallery');
			$grid.isotope({ filter: portfolioItemFilterClass1 + portfolioItemFilterClass2 });

		});

		// Filter List 2
		$('.filter-list-2 .filter-item').find('a').on('click', function(e){

			e.preventDefault();

			var	classList = $(this).parent('.filter-item').attr('class').split(/\s+/),
				filterItemClass2 = '', // filter item class use the parent category
				portfolioItemFilter2 = ''; // portfolio item filter uses the child categories

			// Get the specific filter item class (the one other than the generic '.filter-item' class)
			$.each(classList, function(index, item) {
			    if (item !== 'filter-item') {
			        filterItemClass2 = '.' + item;
			    }
			});

			$(filterItemClass2).removeClass('selected');
			$(this).parent().addClass('selected');

			var portfolioItemFilter2 = $(this).attr('class');
			if (portfolioItemFilter2 == 'all') {
				portfolioItemFilterClass2 = '';
			}
			else {
				portfolioItemFilterClass2 = '.' + portfolioItemFilter2;
			}

			var $grid = jQuery('.fl-post-grid, .fl-post-gallery');
			$grid.isotope({ filter: portfolioItemFilterClass1 + portfolioItemFilterClass2 });

		});


	});

	<?php if($settings->layout == 'grid') : ?>
	$(window).on('load', function() {
		$('.fl-node-<?php echo $id; ?> .fl-post-<?php echo $settings->layout; ?>').isotope('reloadItems');
	});
	<?php endif; ?>
	
})(jQuery);