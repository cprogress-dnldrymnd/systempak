</div><!-- .col-full -->
</div><!-- #content -->
<?php
$old_user = user_switching::get_old_user();
if (!$old_user) {
    if (is_product_category()) {
        echo do_shortcode("[hfe_template id='5440']");
    }

?>
    <div class="search-header d-none">
        <?= do_shortcode('[search]') ?>
    </div>
    <script>
        jQuery(document).ready(function() {
            jQuery('.site-search-popup .site-search-popup-wrap .site-search').remove();
            jQuery('.search-header').appendTo('.site-search-popup .site-search-popup-wrap');
        });

        jQuery('#search-input').keypress(function(e) {
            if (e.which == 13) return false;

        });
    </script>


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
}

/**
 * Functions hooked in to priotech_after_footer action
 * @see priotech_sticky_single_add_to_cart 	- 999 - woo
 */
do_action('priotech_after_footer');
?>

</div><!-- #page -->
<?php
$old_user = user_switching::get_old_user();
?>

<?php if (is_user_logged_in() && $old_user) { ?>
    <!-- Modal -->
    <div class="modal fade" id="addCustomProduct" tabindex="-1" aria-labelledby="addCustomProductLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomProductLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-form">
                    <div class="mb-3 d-flex align-items-center form-holder mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter title">
                        </div>
                        <div class="mb-3 d-flex align-items-center form-holder mb-3">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="sku" name="sku" placeholder="Enter SKU">
                        </div>
                        <div class="mb-3 d-flex align-items-center form-holder mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter Quantity">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Add product</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
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