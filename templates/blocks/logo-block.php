<?php

/**
 * Блок: Custom logo block
 *
 * Registers a logo block and ensures its display in the editor and on the frontend.
 *
 * @since 1.0.0
 */
?>

<?php
$custom_logo = get_field('logo_block_head');

if ($custom_logo) {
?>
    <div class="custom_container">
        <h2 class="custom_logo">
            <a href="<?php echo home_url(); ?>"><?php echo $custom_logo; ?></a>
        </h2>
    </div>
<?php

} else {
    echo '<div class="custom_logo">ACF field is empty</div>';
}
?>