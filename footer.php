</div><!-- .col-full -->
</div><!-- #content -->
<?php
if (is_product_category()) {
    echo do_shortcode("[hfe_template id='5440']");
}
if (current_user_can('administrator')) {
    //echo '<pre>';
    //var_dump(get_post_meta(7757));
    //echo '</pre>';
}

?>
<?php if (!is_search()) { ?>
    <div class="search-header d-none">
        <?= do_shortcode('[search]') ?>
    </div>
    <script>
        jQuery(document).ready(function() {
            jQuery('.site-search-popup .site-search-popup-wrap .site-search').remove();
            jQuery('.search-header').appendTo('.site-search-popup .site-search-popup-wrap');
        });
    </script>
<?php } ?>


<?php if (is_page(8978)) { ?>
    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    $product_id = 10755;

                    $args = array(
                        'posts_per_page'      => 1,
                        'post_type'           => 'product',
                        'post_status'         => 'publish',
                        'ignore_sticky_posts' => 1,
                        'no_found_rows'       => 1,
                    );

                    if (isset($product_id)) {
                        $args['p'] = absint($product_id);
                    }

                    $single_product = new WP_Query($args);

                    while ($single_product->have_posts()) {
                        $single_product->the_post();
                        echo '<div class="single-product">';
                        woocommerce_template_single_add_to_cart();

                        $pricingRule = \TierPricingTable\PriceManager::getPricingRule($product_id);

                        echo $pricingRule->pricingData;

                        echo '</div>';
                    }
                    wp_reset_postdata();
                    ?>
                    <div id="modal-result">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php do_action('priotech_before_footer');
if (priotech_is_elementor_activated() && function_exists('hfe_init') && (hfe_footer_enabled() || hfe_is_before_footer_enabled())) {
    do_action('hfe_footer_before');
    do_action('hfe_footer');
} else {
?>

    <footer id="colophon" class="site-footer" role="contentinfo">
        <?php
        /**
         * Functions hooked in to priotech_footer action
         *
         * @see priotech_footer_default - 20
         *
         *
         */
        do_action('priotech_footer');

        ?>

    </footer><!-- #colophon -->

<?php
}

/**
 * Functions hooked in to priotech_after_footer action
 * @see priotech_sticky_single_add_to_cart 	- 999 - woo
 */
do_action('priotech_after_footer');
?>

</div><!-- #page -->

<?php

/**
 * Functions hooked in to wp_footer action
 * @see priotech_template_account_dropdown 	- 1
 * @see priotech_mobile_nav - 1
 * @see priotech_render_woocommerce_shop_canvas - 1 - woo
 */

wp_footer();
?>
</body>

</html>