<?php

/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Homepage
 *
 * @package storefront
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php
		/**
		 * Functions hooked in to homepage action
		 *
		 * @hooked storefront_homepage_content      - 10
		 * @hooked     - 20
		 * @hooked storefront_recent_products       - 30
		 * @hooked storefront_featured_products     - 40
		 * @hooked storefront_popular_products      - 50
		 * @hooked storefront_on_sale_products      - 60
		 * @hooked storefront_best_selling_products - 70
		 */
		do_action('homepage');
		?>

		<h2 class="custom-section-title">Блоги та новини</h2>

		<div class="custom_posts">
			<?php
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 4
			);
			$query = new WP_Query($args);
			if ($query->have_posts()) :
				while ($query->have_posts()) :
					$query->the_post();
			?>
					<div class="custom_posts_card">
						<div class="custom_posts_card__image">
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
						</div>
						<div class="custom_posts_card__title"><?php the_title(); ?></div>
						<div class="custom_posts_card__content"><?php the_excerpt(); ?></div>
						<div class="custom_posts_card__button"><a href="<?php the_permalink(); ?>">Читати</a></div>

					</div>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>

	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();
