<?php

$post_id = get_the_ID();

$terms = get_the_terms($post_id, 'portfolio_category' );
if ($terms && ! is_wp_error($terms)) :
	$term_slugs_arr = array();
	foreach ($terms as $term) {
	    $term_slugs_arr[] = $term->slug;
	}
	$terms_slug_str = join( " ", $term_slugs_arr);
endif;
?>

<div class="fl-post-grid-post bms-portfolio-grid-container element-item <?php echo $terms_slug_str; ?>" itemscope itemtype="<?php BMSPortfolioGridModule::schema_itemtype(); ?>">

	<?php //echo $terms_slug_str; ?>

	<?php BMSPortfolioGridModule::schema_meta(); ?>

	<div class="flipper">

		<div class="fl-post-grid-image bms-portfolio-grid-front">
		<?php if(has_post_thumbnail() && $settings->show_image) : ?>
			<?php the_post_thumbnail($settings->image_size); ?>
		<?php else : ?>
			<h3><?php the_title(); ?></h3>
		<?php endif; ?>
		</div>

		<div class="fl-post-grid-text bms-portfolio-grid-back">

			<h2 class="fl-post-grid-title" itemprop="headline">
				<?php the_title(); ?>
			</h2>

			<?php if($settings->show_content || $settings->show_more_link) : ?>
			<div class="fl-post-grid-content">
				<?php if($settings->show_content) : ?>
				<?php the_excerpt(21); ?>
				<?php endif; ?>
			</div>

            <div class="bms-portfolio-grid-website" >
                <?php if($settings->show_more_link) : ?>
                <a class="fl-post-grid-more" href="<?php the_field( 'website_url' ); ?>" title="<?php the_title_attribute(); ?>"><?php echo $settings->more_link_text; ?></a>
                <?php endif; ?>
            </div>

            <div class="bms-portfolio-grid-social">
                <a href="<?php the_field( 'twitter_url' ); ?>" target="_self">
                    <span class="fl-icon-wrap">
                        <span class="fl-icon">
                            <i class="fa fa-twitter"></i> 
                        </span>
                    </span>
                </a>  
            </div>
			<?php endif; ?>

		</div><!-- bms-portfolio-grid-back -->
    </div><!-- flipper -->
</div>