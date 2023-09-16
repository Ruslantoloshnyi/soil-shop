<?php

/**
 * 
 *
 * Template name: news
 * Template post type: page
 *
 * 
 */

get_header(); ?>

<section id="custom_posts">
    <?php $archive_post_link = get_post_type_archive_link('post'); ?>
    <h2 class="custom-section-title">Блоги та новини</h2>

    <div class="custom_posts">
        <?php
        $args = array(
            'post_type' => 'post',
            'category_name' => 'news',
            'posts_per_page' => -1
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


<?php get_footer();
