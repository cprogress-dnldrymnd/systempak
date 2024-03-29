<?php

/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if (!defined('ABSPATH')) {
    exit;
}


if ($related_products) :
    $related_ids = [];

    foreach ($related_products as $related) {
        $related_ids[] = $related->get_id();
    }

    $class = 'priotech-theme-swiper priotech-swiper-wrapper swiper ';
    $items = wc_get_loop_prop('columns');
    $number = apply_filters('related-products-number', 4) < $items ? $items : apply_filters('related-products-number', 4);
    $settings = priotech_get_settings_product_caroseul();
    $settings['prevEl'] = '.related-swiper-button-prev';
    $settings['nextEl'] = '.related-swiper-button-next';
    $settings['paginationEl'] = '.related-pagination';
    $show_dots = (in_array($settings['navigation'], ['dots', 'both']));
    $show_arrows = (in_array($settings['navigation'], ['arrows', 'both']));

    $settings['breakpoints']['desktop']['column'] = 5;

    $carousel_enable = (priotech_is_elementor_activated()) ? true : false;
    wc_set_loop_prop('enable_carousel', $carousel_enable);

    $args = array(
        'post_type' => 'product',
        // 'post__in' => $related_ids,
        'meta_key' => 'total_sales',
        'orderby' => 'meta_value_num',
        'posts_per_page' => 6,
    );
    $loop = new WP_Query($args);
    

?>

    <?= do_shortcode("[hfe_template id='5352']") ?>
    <section class="related products elementor-element">

        <h2>Related <span>Products</span></h2>
        <div class="woocommerce <?php echo esc_attr($class); ?>" data-settings="<?php echo esc_attr(wp_json_encode($settings)) ?>">
            <?php woocommerce_product_loop_start(); ?>

            <?php
            if ($loop->have_posts()) {
                while ($loop->have_posts()) :
                    $loop->the_post();
                    do_action('woocommerce_shop_loop');
                    wc_get_template_part('content', 'product');
                endwhile;
            }
            ?>

            <?php woocommerce_product_loop_end(); ?>

            <?php if ($show_dots) : ?>
                <div class="swiper-pagination swiper-pagination  related-swiper-pagination"></div>
            <?php endif; ?>
            <?php if ($show_arrows) : ?>
                <div class="elementor-swiper-button elementor-swiper-button-prev related-swiper-button-prev">
                    <i aria-hidden="true" class="eicon-chevron-left"></i>
                    <span class="elementor-screen-only"><?php echo esc_html__('Previous', 'priotech'); ?></span>
                </div>
                <div class="elementor-swiper-button elementor-swiper-button-next related-swiper-button-next">
                    <i aria-hidden="true" class="eicon-chevron-right"></i>
                    <span class="elementor-screen-only"><?php echo esc_html__('Next', 'priotech'); ?></span>
                </div>
            <?php endif; ?>
        </div>
        <?php
        if (!priotech_is_elementor_activated()) {
        ?>
            <style>
                .related .priotech-products.products.elementor-grid {
                    display: flex;
                }
            </style>
        <?php
        }
        ?>
    </section>
    <?= do_shortcode("  [hfe_template id='5357']") ?>
<?php
endif;


wp_reset_postdata();
