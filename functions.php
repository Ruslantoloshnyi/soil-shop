<?php

// function enqueue_custom_js()
// {
//     wp_enqueue_script('custom-checkout', get_theme_file_uri() . '/assets/js/custom-checkout.js', array('jquery'), '1.0', true);
// }
// add_action('wp_enqueue_scripts', 'enqueue_custom_js');

function enqueue_custom_js_for_checkout()
{
    if (is_checkout()) {
        wp_enqueue_script('custom-checkout', get_stylesheet_directory_uri() . '/assets/js/custom-checkout.js', array('jquery'), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'enqueue_custom_js_for_checkout');



// Remoove woocommerce hoocks
function art_remove_action()
{
    remove_action('storefront_homepage', 'storefront_homepage_header', 10);
    // remove_action('storefront_homepage', 'storefront_page_content', 20);
    remove_action('homepage', 'storefront_product_categories', 20);
    remove_action('homepage', 'storefront_recent_products', 30);
    remove_action('homepage', 'storefront_popular_products', 50);
    remove_action('homepage', 'storefront_on_sale_products', 60);
    remove_action('homepage', 'storefront_best_selling_products', 70);
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
add_image_size('custom-grid-large', 750, 422, true);
add_image_size('custom-grid-medium', 420, 420, true);

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

        acf_register_block_type(array(
            'name'              => 'custom_grid_block',
            'title'             => __('Custom grid block'),
            'render_template'   => get_stylesheet_directory() . '/templates/blocks/grid-block.php', // Указываем правильный путь
            'category'          => 'Custom ACF',
            'icon'              => 'admin-comments',
            'keywords'          => array('custom', 'block'),
            'supports'          => array('align' => true),
        ));
    }
}
add_action('acf/init', 'register_acf_block_types');

function render_custom_grid_block_content()
{
?>
    <section class="front-grid">
        <div class="container">
            <?php
            $grid_fields = get_field('grid_section');
            $grid_img_1 = wp_get_attachment_image($grid_fields['grid_img_1'], 'full', false, ['class' => 'front-grid-img']);
            $grid_img_2 = wp_get_attachment_image($grid_fields['grid_img_2'], 'custom-grid-medium', false, ['class' => 'front-grid-img']);
            $grid_img_3 = wp_get_attachment_image($grid_fields['grid_img_3'], 'custom-grid-medium', false, ['class' => 'front-grid-img']);
            $grid_img_4 = wp_get_attachment_image($grid_fields['grid_img_4'], 'custom-grid-large', false, ['class' => 'front-grid-img']);
            $grid_img_5 = wp_get_attachment_image($grid_fields['grid_img_5'], 'custom-grid-medium', false, ['class' => 'front-grid-img']);
            $grid_img_6 = wp_get_attachment_image($grid_fields['grid_img_6'], 'custom-grid-medium', false, ['class' => 'front-grid-img']);
            $grid_img_7 = wp_get_attachment_image($grid_fields['grid_img_7'], 'custom-grid-medium', false, ['class' => 'front-grid-img']);

            ?>
            <div>
                <h2 class="custom-section-title">При використанні вейпу</h2>
            </div>
            <div class="grid-container">
                <div class="front-grid-item1">
                    <?php echo $grid_img_1; ?>
                    <div class="front-grid__text">Не порушуються смакові почуття</div>
                </div>
                <div class="front-grid-item2">
                    <?php echo $grid_img_2; ?>
                    <div class="front-grid__text">Не жовтіє емаль зубів</div>
                </div>
                <div class="front-grid-item3">
                    <?php echo $grid_img_3; ?>
                    <div class="front-grid__text">Немає змін кольору шкірних покривів</div>
                </div>
                <div class="front-grid-item4">
                    <?php echo $grid_img_4; ?>
                    <div class="front-grid__text">Відсутній неприємний запах одягу</div>
                </div>
                <div class="front-grid-item5">
                    <?php echo $grid_img_5; ?>
                    <div class="front-grid__text">Відсутність кашлю</div>
                </div>
                <div class="front-grid-item6">
                    <?php echo $grid_img_6; ?>
                    <div class="front-grid__text">Не має диму</div>
                </div>
                <div class="front-grid-item7">
                    <?php echo $grid_img_7; ?>
                    <div class="front-grid__text">Не порушуються смакові почуття</div>
                </div>
            </div>

        </div>
    </section>
<?php
}
add_action('homepage', 'render_custom_grid_block_content', 80);

function custom_recent_content()
{
?>
    <section id="recent_products">
        <h2 class="custom-section-title"><a href="<?php echo get_permalink('248'); ?>">Новинки</a></h2>
        <?php echo do_shortcode('[wcpcsu id="265"]'); ?>
    </section>
<?php
}
add_action('homepage', 'custom_recent_content', 75);

function custom_popular_content()
{
?>
    <section id="popular_products">
        <h2 class="custom-section-title"><a href="<?php echo get_permalink('248'); ?>">Часто купують</a></h2>
        <?php echo do_shortcode('[wcpcsu id="267"]'); ?>
    </section>
<?php
}
add_action('homepage', 'custom_popular_content', 76);

/* register custom after cart hoock */
function custom_after_cart()
{
?>
    <section id="custom_posts">
        <h2 class="custom-section-title">Вас може зацікавити</h2>
        <?php echo do_shortcode('[wcpcsu id="265"]'); ?>
    </section>
<?php
}
add_action('custom_after_cart', 'custom_after_cart');

/* remove comments on cart page */
function disable_comments_on_cart_page($open, $post_id)
{
    if (is_page('cart')) { // Проверяем, является ли текущая страница страницей корзины
        return false; // Отключаем комментарии
    }
    return $open; // В остальных случаях возвращаем текущее состояние
}
add_filter('comments_open', 'disable_comments_on_cart_page', 10, 2);

/*  */
function check_existing_comment($commentdata)
{
    $user = wp_get_current_user();
    $post_id = $commentdata['comment_post_ID'];
    $existing_comments = get_comments(array('user_id' => $user->ID, 'post_id' => $post_id));

    if (!empty($existing_comments)) {
        wp_die('Ви вже коментували цей товар.');
    }

    return $commentdata;
}
add_filter('preprocess_comment', 'check_existing_comment');
