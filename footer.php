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

<?php
if (is_checkout() && !(is_wc_endpoint_url('order-pay') || is_wc_endpoint_url('order-received'))) {
    if (is_user_logged_in() && $old_user) { ?>
        <!-- Modal -->
        <div class="modal fade form-style-1" id="addCustomProduct" tabindex="-1" aria-labelledby="addCustomProductLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="loading d-none">
                        <svg class="adding-product" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"></path>
                        </svg>
                    </div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCustomProductLabel">Add Custom Product</h5>
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
                                <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" value="1">
                            </div>
                            <div class="mb-3 d-flex align-items-center form-holder mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price" placeholder="Enter price">
                            </div>
                            <div class="mb-3 d-flex align-items-center form-holder mb-3">
                                <label for="weight" class="form-label">Weight</label>
                                <input type="number" class="form-control" id="weight" name="weight" placeholder="Weight">
                            </div>
                            <div class="mb-3 d-flex align-items-center form-holder mb-3">
                                <label class="form-label">Dimensions</label>
                                <div class="form-group d-flex">
                                    <input type="number" class="form-control" id="length" name="length" placeholder="Length">
                                    <input type="number" class="form-control me-3" id="width" name="width" placeholder="Width">
                                    <input type="number" class="form-control me-3" id="height" name="height" placeholder="Height">
                                </div>
                            </div>
                            <div class="mb-3 d-flex align-items-center form-holder mb-3">
                                <label for="tax_status" class="form-label">Tax Status</label>
                                <select id="tax_status" name="tax_status" class="form-control">
                                    <option value="taxable" selected="selected">Taxable</option>
                                    <option value="shipping">Shipping only</option>
                                    <option value="none">None</option>
                                </select>
                            </div>
                            <div class="mb-3 d-flex align-items-center form-holder mb-3">
                                <label for="tax_class" class="form-label">Tax Class</label>
                                <select id="tax_class" name="tax_class" class="form-control">
                                    <option value="" selected="selected">Standard</option>
                                    <option value="reduced-rate">Reduced rate</option>
                                    <option value="zero-rate">Zero rate</option>
                                </select>
                            </div>
                            <div class="mb-3 d-flex align-items-center mb-3">
                                <label for="tax_class" class="form-label mb-0 me-3">Delete after placed order</label>
                                <select id="delete_product" name="delete_product" class="form-control">
                                    <option value="yes" selected="selected">Yes</option>
                                    <option value="no">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="add-custom-product">Add product</button>
                    </div>
                </div>
            </div>
        </div>
<?php }
} ?>

<script>
    jQuery(document).ready(function() {
        if (jQuery('.term-description').length > 0) {
            $length = jQuery('.elementor-widget-container > .term-description > *').length;

            if ($length > 2) {
                jQuery('.term-desc-read-more').addClass('show');
            } else {

            }
            jQuery('.term-desc-read-more').click(function(e) {
                jQuery('.elementor-widget-container > .term-description').addClass('active');
                jQuery('.term-desc-read-more').removeClass('show');
                e.preventDefault();
            });
        }
    });
</script>

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