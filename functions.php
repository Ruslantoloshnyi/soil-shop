<?php

// Remoove woocommerce hoocks
function art_remove_action()
{
    remove_action('storefront_homepage', 'storefront_homepage_header', 10);
    // remove_action('storefront_homepage', 'storefront_page_content', 20);
    // remove_action('homepage', 'storefront_recent_products', 30);
    // remove_action('homepage', 'storefront_popular_products', 50);
    // remove_action('storefront_before_content', 'woocommerce_breadcrumb', 10);
    remove_action('storefront_footer', 'storefront_credit', 20);
    // remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
    // remove_action('woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10);
}
add_action('after_setup_theme', 'art_remove_action');

/**
 * Автоматически генерировать SKU при добавлении товара.
 */
function generate_product_sku($product_id)
{
    // Проверяем, что это новый товар, чтобы избежать изменения SKU для существующих товаров.
    if ('product' === get_post_type($product_id) && empty(get_post_meta($product_id, '_sku', true))) {
        // Получаем случайный уникальный номер, который можно использовать в качестве SKU.
        $sku = uniqid();

        // Устанавливаем SKU товара.
        update_post_meta($product_id, '_sku', $sku);
    }
}

// Добавляем хук, который будет вызываться при создании нового товара.
add_action('woocommerce_new_product', 'generate_product_sku');

/**
 * Change excerpt size
 */
add_filter('excerpt_length', function () {
    return 17;
});

/**
 * Change excerpt size
 */
function change_currency_symbol($currency_symbol, $currency)
{
    switch ($currency) {
        case 'UAH': // Код валюты для гривны
            return ' грн';
        default:
            return $currency_symbol;
    }
}
add_filter('woocommerce_currency_symbol', 'change_currency_symbol', 10, 2);

/* add custom image size */
add_image_size('custom-large', 600, 250, true);

/* Remove woocommerce checkout fields */
function remove_checkout_fields($fields)
{
    // unset($fields['order']['order_comments']['placeholder']);
    unset($fields['billing']['billing_company']);
    // unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_address_1']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_city_field']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_city']);
    // unset($fields['order']['order_comments']);

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'remove_checkout_fields');

add_filter('woocommerce_checkout_fields', 'misha_not_required_fields', 9999);

function misha_not_required_fields($fields)
{

    unset($fields['billing']['billing_email']['required']);

    // the same way you can make any field required, example:
    // $fields[ 'billing' ][ 'billing_company' ][ 'required' ] = true;

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'misha_not_required_fields', 9999);

/* register custom acf gutenberg blocks */
function register_acf_block_types()
{

    if (function_exists('acf_register_block_type')) {
        acf_register_block_type(array(
            'name'              => 'custom_logo_block',
            'title'             => __('Custom logo block'),
            'render_template'   => get_stylesheet_directory() . '/templates/blocks/logo-block.php', // Указываем правильный путь
            'category'          => 'Custom ACF',
            'icon'              => 'admin-comments',
            'keywords'          => array('custom', 'block'),
        ));
    }
}
add_action('acf/init', 'register_acf_block_types');

function custom_after_cart()
{
?>
    <section id="custom_posts">
        <h2 class="custom-section-title">Вас може зацікавити</h2>

        <div class="custom_posts">
            <?php
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 4,
                'meta_key' => 'total_sales',
                'orderby' => 'meta_value_num',
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) :
                while ($query->have_posts()) :
                    $query->the_post();
                    $product = wc_get_product(get_the_ID());
            ?>
                    <div class="custom_posts_card">
                        <div class="custom_posts_card__image">
                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium'); ?></a>
                        </div>

                        <div class="custom_posts_card__content"><?php the_title(); ?></div>
                        <div class="woocommerce star-rating"></div>
                        <div class="custom_posts_card__content"><?php echo $product->get_price(); ?> грн</div>


                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </section>
<?php
}
add_action('custom_after_cart', 'custom_after_cart');

function disable_comments_on_cart_page($open, $post_id)
{
    if (is_page('cart')) { // Проверяем, является ли текущая страница страницей корзины
        return false; // Отключаем комментарии
    }
    return $open; // В остальных случаях возвращаем текущее состояние
}
add_filter('comments_open', 'disable_comments_on_cart_page', 10, 2);



function check_existing_comment($commentdata)
{
    $user = wp_get_current_user();
    $post_id = $commentdata['comment_post_ID'];
    $existing_comments = get_comments(array('user_id' => $user->ID, 'post_id' => $post_id));

    if (!empty($existing_comments)) {
        wp_die('Вы уже оставили комментарий к этому товару.');
    }

    return $commentdata;
}

add_filter('preprocess_comment', 'check_existing_comment');
