<?php
/* Remove product meta */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);


/**
 * @snippet       Move product tabs beside the product image - WooCommerce
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 7
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */

remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);


function woocommerce_js()
{
?>
    <script>
        jQuery(document).ready(function() {
            jQuery('#accordion-container').appendTo('.summary .left');
        });
    </script>
<?php
}

add_action('wp_footer', 'woocommerce_js');


function action_woocommerce_before_add_to_cart_form() {
    ?>
sccscscs
    <?php
}

add_action('woocommerce_before_add_to_cart_form', 'action_woocommerce_before_add_to_cart_form');