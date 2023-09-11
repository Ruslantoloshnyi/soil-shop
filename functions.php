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
