<?php

global $post;

$post_id = get_the_ID();

$terms = get_the_terms($post_id, 'portfolio_category' );
if ($terms && ! is_wp_error($terms)) :
	$term_slugs_arr = array();
	foreach ($terms as $term) {
	    $term_slugs_arr[] = $term->slug;
	}
	$terms_slug_str = join( " ", $term_slugs_arr);
else :
	$terms_slug_str = '';
endif;
?>

<?php # http://www.tcbarrett.com/2011/09/wordpress-the_slug-get-post-slug-function/ ?>
<div class="fl-post-grid-post bms-portfolio-grid-container element-item <?php echo $terms_slug_str; ?> <?php echo $post->post_name; ?>" data-post-title="<?php the_title(); ?>" itemscope itemtype="<?php BMSPortfolioGridModule::schema_itemtype(); ?>">

	<?php //echo $terms_slug_str; ?>

	<?php BMSPortfolioGridModule::schema_meta(); ?>

	<div class="flipper">

		<div class="fl-post-grid-image bms-portfolio-grid-front">
		<?php if(has_post_thumbnail() && $settings->show_image) : ?>
			<?php the_post_thumbnail($settings->image_size); ?>
		<?php else : ?>
			<?php # Insert transparent image so non-logo cards will flip on iOS ?>
			<img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'img/xpar.png'; ?>" alt="" />
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

	            
                <?php if($settings->show_more_link) : ?>
                	<?php if( !empty( get_field( 'website_url' ) ) ) : ?>
	                	<div class="bms-portfolio-grid-website" >
	                		<a class="fl-post-grid-more" href="<?php the_field( 'website_url' ); ?>" target="_blank" title="<?php the_title_attribute(); ?>"><?php echo $settings->more_link_text; ?></a>
	                	</div>
                	 <?php endif; ?>
                <?php endif; ?>

				<?php if( !empty( get_field( 'twitter_url' ) ) ) : ?>
		            <div class="bms-portfolio-grid-social">
		                <a href="<?php the_field( 'twitter_url' ); ?>" target="_blank">
		                    <span class="fl-icon-wrap">
		                        <span class="fl-icon">
		                            <i class="fa fa-twitter"></i> 
		                        </span>
		                    </span>
		                </a>  
		            </div>
	            <?php endif; ?>

			<?php endif; ?>

		</div><!-- bms-portfolio-grid-back -->
    </div><!-- flipper -->
</div>