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
 * Template post type: page
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
		 * @hooked storefront_product_categories    - 20
		 * @hooked storefront_recent_products       - 30
		 * @hooked storefront_featured_products     - 40
		 * @hooked storefront_popular_products      - 50
		 * @hooked storefront_on_sale_products      - 60
		 * @hooked storefront_best_selling_products - 70
		 */
		do_action('homepage');
		?>

		<section id="custom_posts">
			<?php $archive_post_link = get_post_type_archive_link('post'); ?>
			<h2 class="custom-section-title"><a href="<?php echo get_permalink('248'); ?>">Блоги та новини</a></h2>

			<div class="custom_posts">
				<?php
				$args = array(
					'post_type' => 'post',
					'category_name' => 'news',
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
					<?php wp_reset_postdata(); ?>
				<?php endif; ?>
			</div>
		</section>



		<section id="custom_info">
			<?php
			$category_info = get_category_by_slug('info');
			if ($category_info) :
			?>
				<h2 class="custom-section-title">Інформація</h2>
			<?php endif; ?>
			<?php
			$args2 = array(
				'post_type' => 'post',
				'category_name' => 'info',
				'posts_per_page' => -1
			);
			$query2 = new WP_Query($args2);
			if ($query2->have_posts()) :
				while ($query2->have_posts()) :
					$query2->the_post();
			?>
					<div class="custom_info">
						<div class="custom_info__title"><?php the_title(); ?></div>
						<div class="custom_info__content"><?php the_content(); ?></div>
					</div>
		</section>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>

	</main><!-- #main -->
</div><!-- #primary -->
<?php
get_footer();
