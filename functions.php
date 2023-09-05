<?php

function art_remove_action()
{
    remove_action('storefront_homepage', 'storefront_homepage_header', 10);
    // remove_action('storefront_homepage', 'storefront_page_content', 20);
    remove_action('homepage', 'storefront_recent_products', 30);
    remove_action('homepage', 'storefront_popular_products', 50);
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

add_filter('excerpt_length', function () {
    return 17;
});
