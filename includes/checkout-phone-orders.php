<?php

add_action('wp_ajax_nopriv_search_ajax_products', 'search_ajax_products'); // for not logged in users
add_action('wp_ajax_search_ajax_products', 'search_ajax_products');
function search_ajax_products()
{
    $posts_per_page_val = 5;
    $s = $_POST['s'];
    $post_type = array('product', 'product_variation');
    $posts_per_page = $posts_per_page_val ? $posts_per_page_val : get_option('posts_per_page');
    $offset = $_POST['offset'];
    $args = array();


    if ($offset) {
        $args['offset'] = $offset;
    }
    if ($s) {
        $args['s'] = $s;
    }

    $args['posts_per_page'] = $posts_per_page;

    $args['post_type'] = $post_type;

    $args['post_status'] = array('publish');

    $args['post__not_in'] = get_cart_product_ids();

    $the_query_args = new WP_Query($args);

    $args['tax_query'] = array(
        array(
            'taxonomy' => 'product_type',
            'field'    => 'slug',
            'terms'    => array('variable'),
            'operator' => 'NOT IN'
        ),
    );

    $found_posts = $the_query_args->found_posts;

    if (!$found_posts  && $s != '') {
        $args['meta_query'] = array(
            array(
                'key' => '_sku',
                'value' => $s,
                'compare' => 'LIKE',
            ),
        );
        unset($args['s']);
    }




    $the_query = new WP_Query($args);

    $count = $the_query->found_posts;
    echo hide_load_more($count, $offset, $posts_per_page);

?>
    <div class="post-item-holder">
        <?php
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
                global $product;

        ?>
                <div class="post-item post-<?= get_the_ID() ?>" product-id="<?= get_the_ID() ?>">
                    <div class="row">
                        <?php
                        if ($product->get_type() == ' simple') {
                            if (get_the_post_thumbnail_url(get_the_ID())) {
                                $url = get_the_post_thumbnail_url(get_the_ID());
                            } else {
                                $url = wc_placeholder_img_src();
                            }
                        } else {
                            if (wp_get_attachment_image_url($product->get_image_id())) {
                                $url = wp_get_attachment_image_url($product->get_image_id());
                            } else {
                                if (get_the_post_thumbnail_url(get_the_ID())) {
                                    $url = get_the_post_thumbnail_url(get_the_ID());
                                } else {
                                    $url = wc_placeholder_img_src();
                                }
                            }
                        }

                        $get_stock_quantity = $product->get_stock_quantity();
                        if ($get_stock_quantity) {
                            $stock = $get_stock_quantity;
                        } else {
                            $stock = $product->get_stock_status();
                        }
                        ?>
                        <div class="col-image col-auto">
                            <img src="<?= $url  ?>" alt="<?php the_title() ?>">
                        </div>
                        <div class="col-content d-flex align-items-center justify-content-between col">
                            <div>
                                <p><strong><?php the_title() ?></strong></p>
                                <p><strong>SKU: </strong> <?= $product->get_sku() ?> </p>
                                <p><strong>STOCK: </strong> <?= $stock ?> </p>

                            </div>

                            <button type="button" class="plus-minus product-add-to-basket" product-id="<?= get_the_ID() ?>">
                                +
                            </button>
                        </div>
                    </div>
                </div>
            <?php }
        } else {
            ?>
            <h2>No Results Found</h2>
        <?php
        }
        wp_reset_postdata();
        ?>
    </div>

<?php

    die();
}


add_action('wp_ajax_nopriv_select_product_ajax', 'select_product_ajax'); // for not logged in users
add_action('wp_ajax_select_product_ajax', 'select_product_ajax');
function select_product_ajax()
{
    $product_ids = $_POST['product_ids'];
    global $woocommerce;

    foreach ($product_ids as $product_id) {
        $woocommerce->cart->add_to_cart($product_id);
    }

    die();
}
//add custom shipping

add_action('wp_ajax_custom_shipping_ajax', 'custom_shipping_ajax');
add_action('wp_ajax_nopriv_custom_shipping_ajax', 'custom_shipping_ajax');
function custom_shipping_ajax()
{
    if (isset($_POST['custom_shipping_cost'])) {
        $custom_shipping_cost = sanitize_key($_POST['custom_shipping_cost']);
        WC()->session->set('custom_shipping_cost', $custom_shipping_cost);
    }
    die(); // Alway at the end (to avoid server error 500)
}
// Calculate and add extra fee based on radio button selection
add_action('woocommerce_cart_calculate_fees', 'add_custom_extra_fee', 20, 1);
function add_custom_extra_fee($cart)
{
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }
    $custom_shipping_cost = WC()->session->get('custom_shipping_cost');
    if ($custom_shipping_cost != 'false') {
        $cart->add_fee(__('Custom Shipping Cost', 'text-domain'), $custom_shipping_cost, true, 'standard');
    } else {
        $fees = $cart->get_fees();
        foreach ($fees as $key => $fee) {
            // unset that specific fee from the array
            if ($fees[$key]->name === __("Custom Shipping Cost")) {
                unset($fees[$key]);
            }
            if ($fees[$key]->name === __("Custom")) {
                unset($fees[$key]);
            }
        }
        $cart->fees_api()->set_fees($fees);
    }
}


/**
 * @snippet       Item Quantity Inputs @ WooCommerce Checkout
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 7
 * @community     https://businessbloomer.com/club/
 */

// ----------------------------
// Add Quantity Input Beside Product Name

add_filter('woocommerce_checkout_cart_item_quantity', 'bbloomer_checkout_item_quantity_input', 9999, 3);

function bbloomer_checkout_item_quantity_input($product_quantity, $cart_item, $cart_item_key)
{
    $product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
    if (!$product->is_sold_individually()) {
        $product_quantity = '<div class="quantity-parent">';
        $product_quantity .= '<button type="button" class="minus" target="shipping_method_qty_' . $product_id . '">-</button>';
        $product_quantity .= woocommerce_quantity_input(array(
            'input_name'  => 'shipping_method_qty_' . $product_id,
            'input_value' => $cart_item['quantity'],
            'max_value'   => $product->get_max_purchase_quantity(),
            'min_value'   => '0',
        ), $product, false);
        $product_quantity .= '<input type="hidden" name="product_key_' . $product_id . '" value="' . $cart_item_key . '">';
        $product_quantity .= '<button type="button" class="plus" target="shipping_method_qty_' . $product_id . '">+</button>';
        $product_quantity .= '</div>';
    }
    return $product_quantity;
}

// ----------------------------
// Detect Quantity Change and Recalculate Totals

add_action('woocommerce_checkout_update_order_review', 'bbloomer_update_item_quantity_checkout');

function bbloomer_update_item_quantity_checkout($post_data)
{
    parse_str($post_data, $post_data_array);
    $updated_qty = false;
    foreach ($post_data_array as $key => $value) {
        if (substr($key, 0, 20) === 'shipping_method_qty_') {
            $id = substr($key, 20);
            WC()->cart->set_quantity($post_data_array['product_key_' . $id], $post_data_array[$key], false);
            $updated_qty = true;
        }
    }
    if ($updated_qty) WC()->cart->calculate_totals();
}



function ajax_apply_coupon_cart()
{
    if (!isset($_POST['coupon_code']) || empty($_POST['coupon_code'])) {
        wp_send_json(['success' => false, 'data' => ['message' => 'No coupon code provided']], 200);
        // return; // <== Not needed as wp_send_json() throws die();
    }
    $coupon_code = sanitize_text_field($_POST['coupon_code']);

    if (!WC()->cart->has_discount($coupon_code)) {
        $coupon_id = wc_get_coupon_id_by_code($coupon_code);

        if (!$coupon_id) {
            wp_send_json(['success' => false, 'data' => ['message' => sprintf(__('Coupon  does not exist!', 'woocommerce'), $coupon_code)]], 200);
            // return; // <== Not needed as wp_send_json() throws die();
        }

        $result = WC()->cart->apply_coupon($coupon_code); // Apply coupon

        if ($result) {
            WC()->cart->calculate_totals(); // <=== Refresh totals (Missing)

            wp_send_json_success(['message' => sprintf(__('Coupon  applied successfully.', 'woocommerce'), $coupon_code)], 200);
        }
    } else {
        wp_send_json_error(['message' => sprintf(__('Coupon  is already applied!', 'woocommerce'), $coupon_code)], 200);
    }
}



add_action('wp_ajax_nopriv_coupon_ajax', 'coupon_ajax'); // for not logged in users
add_action('wp_ajax_coupon_ajax', 'coupon_ajax');
function coupon_ajax()
{
    $coupon_code = $_POST['coupon_code'];
    if ($coupon_code) {
        if (!WC()->cart->has_discount($coupon_code)) {

            if (wc_get_coupon_id_by_code($coupon_code)) {
                WC()->cart->apply_coupon($coupon_code);
                echo 'Coupon code applied successfully.';
            } else {
                echo '<span class="failed">Please enter a valid coupon code.</span>';
            }
        } else {


            echo '<span class="failed">Coupon code is already applied.</span>';
        }
    } else {
        echo '<span class="failed">Please enter a valid coupon code.</span>';
    }

    die();
}

/**
 * @snippet       Avoid Empty Cart Redirect @ WooCommerce Checkout
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 3.6.4
 * @community     https://businessbloomer.com/club/
 */

add_filter('woocommerce_checkout_redirect_empty_cart', '__return_false');
add_filter('woocommerce_checkout_update_order_review_expired', '__return_false');

function action_wp_head_phone_oders()
{
    $old_user = user_switching::get_old_user();
    if ($old_user) {
?>
        <style>
            #qlwapp {
                display: none !important;
            }
            #user_switching_switch_on {
                display: none;
            }
        </style>
<?php
    }
}

add_action('wp_head', 'action_wp_head_phone_oders');

