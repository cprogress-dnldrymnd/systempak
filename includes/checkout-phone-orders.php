<?php

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


function action_woocommerce_checkout_empty_cart()
{
    if (is_page(8978)) {
        return false;
    }
}

add_filter('woocommerce_checkout_redirect_empty_cart', 'action_woocommerce_checkout_empty_cart');
add_filter('woocommerce_checkout_update_order_review_expired', 'action_woocommerce_checkout_empty_cart');

add_action('init', 'enable_checkout_if_empty');

remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
