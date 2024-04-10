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

    $args['post_status'] = array('publish', 'private');

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
                                <p class="custom-price"><input type="number" name="custom_price" placeholder="Enter custom price"> </p>

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
    $products = $_POST['products'];
    global $woocommerce;


    foreach ($products as $product) {
        $woocommerce->cart->add_to_cart($product['product_id'], 1, 0, array(), array('custom_price' => $product['custom_price']));
    }

    die();
}
//add custom shipping

add_action('wp_ajax_custom_shipping_ajax', 'custom_shipping_ajax');
add_action('wp_ajax_nopriv_custom_shipping_ajax', 'custom_shipping_ajax');
function custom_shipping_ajax()
{
    if (isset($_POST['custom_shipping_cost'])) {
        $custom_shipping_cost = $_POST['custom_shipping_cost'];
        WC()->session->set('custom_shipping_cost', $custom_shipping_cost);
    }
    die(); // Alway at the end (to avoid server error 500)
}
/*
// Calculate and add extra fee based on radio button selection
add_action('woocommerce_cart_calculate_fees', 'add_custom_extra_fee', 99, 1);
function add_custom_extra_fee($cart)
{
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }
    $custom_shipping_cost = WC()->session->get('custom_shipping_cost');
    if ($custom_shipping_cost != 'false') {
        $cart->add_fee('Custom Shipping Cost', $custom_shipping_cost, true, 'standard');
    } else {
        $fees = $cart->get_fees();
        foreach ($fees as $key => $fee) {
            // unset that specific fee from the array
            if ($fees[$key]->name === __("Custom Shipping Cost")) {
                unset($fees[$key]);
            }
        }
        $cart->fees_api()->set_fees($fees);
    }
}
*/

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


add_action('wp_ajax_custom_product_ajax', 'custom_product_ajax');
add_action('wp_ajax_nopriv_custom_product_ajax', 'custom_product_ajax');
function custom_product_ajax()
{

    $title = isset($_POST['title']) ? $_POST['title'] : false;
    $sku = isset($_POST['sku']) ? $_POST['sku'] : false;
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
    $price = isset($_POST['price']) ? $_POST['price'] : false;
    $weight = isset($_POST['weight']) ? $_POST['weight'] : false;
    $length = isset($_POST['length']) ? $_POST['length'] : false;
    $width = isset($_POST['width']) ? $_POST['width'] : false;
    $height = isset($_POST['height']) ? $_POST['height'] : false;
    $tax_status = isset($_POST['tax_status']) ? $_POST['tax_status'] : false;
    $tax_class = isset($_POST['tax_class']) ? $_POST['tax_class'] : false;
    $delete_product = isset($_POST['delete_product']) ? $_POST['delete_product'] : false;

    // that's CRUD object
    $product = new WC_Product_Simple();

    if ($title) {
        $product->set_name($title); // product title

    }
    if ($sku) {
        $product->set_sku($sku); // product title

    }
    if ($price) {
        $product->set_regular_price($price); // in current shop currency
    }

    if ($weight) {
        $product->set_weight($weight);
    }
    if ($length) {
        $product->set_length($length);
    }
    if ($width) {
        $product->set_width($width);
    }
    if ($height) {
        $product->set_height($height);
    }

    if ($tax_status) {
        $product->update_meta_data('_tax_status', $tax_status);
    }
    if ($tax_class) {
        $product->update_meta_data('_tax_class', $tax_class);
    }
    if ($delete_product == 'yes') {
        $product->update_meta_data('delete_product', true);
    }
    $product->update_meta_data('custom_product', true);

    $product->set_description('<p>This product was temporarily created for a manual/order order. This product will be automatically deleted.</p>');

    $product->set_catalog_visibility('hidden');

    $product->set_category_ids(array(1263));

    $product->save();
    echo '<div id="custom-product-cart-style">';
    echo '<style> .cart-product-' . $product->get_id() . ' .name-wrapper:after{ content: "Just added"; background-color: var(--accent-color); padding: 5px 15px; border-radius: 20px; font-size: 15px; text-transform: uppercase; } </style>';
    echo '</div>';

    global $woocommerce;

    $woocommerce->cart->add_to_cart($product->get_id(), $quantity);



    die(); // Alway at the end (to avoid server error 500)
}


function action_custom_checkout()
{
    ?>
    <script>
        jQuery(document).on('click', '#add-custom-product', function() {
            var title = jQuery('#addCustomProduct input[name="title"]').val();
            var sku = jQuery('#addCustomProduct input[name="sku"]').val();
            var quantity = parseFloat(jQuery('#addCustomProduct input[name="quantity"]').val());
            var price = parseFloat(jQuery('#addCustomProduct input[name="price"]').val());
            var weight = parseFloat(jQuery('#addCustomProduct input[name="weight"]').val());
            var length = parseFloat(jQuery('#addCustomProduct input[name="length"]').val());
            var width = parseFloat(jQuery('#addCustomProduct input[name="width"]').val());
            var height = parseFloat(jQuery('#addCustomProduct input[name="height"]').val());
            var tax_status = jQuery('#addCustomProduct select[name="tax_status"]').val();
            var tax_class = jQuery('#addCustomProduct select[name="tax_class"]').val();
            var delete_product = jQuery('#addCustomProduct select[name="delete_product"]').val();

            if (price && title) {
                jQuery('#addCustomProduct .loading').removeClass('d-none');
                jQuery.ajax({
                    type: 'POST',
                    url: "/wp-admin/admin-ajax.php",
                    data: {
                        'action': 'custom_product_ajax',
                        'title': title,
                        'sku': sku,
                        'quantity': quantity,
                        'price': price,
                        'weight': weight,
                        'length': length,
                        'width': width,
                        'height': height,
                        'tax_status': tax_status,
                        'tax_class': tax_class,
                        'delete_product': delete_product
                    },
                    success: function(result) {
                        jQuery(result).appendTo('.select-products');
                        jQuery('body').trigger('update_checkout');
                        jQuery('body').addClass('trigger-add-custom-product');

                    }
                });
            } else {
                alert('Title and price field is required.');
            }
        });

        jQuery(document.body).on('updated_checkout', function() {
            if (jQuery('body').hasClass('trigger-add-custom-product')) {
                jQuery('html, body').animate({
                    scrollTop: jQuery("#order_review").offset().top
                }, 2000);
                jQuery('#addCustomProduct .loading').addClass('d-none');
                const myModalEl = document.getElementById('addCustomProduct');
                var modal = bootstrap.Modal.getInstance(myModalEl);
                modal.hide();
                setTimeout(function() {
                    jQuery('#custom-product-cart-style').remove();
                    jQuery('body').removeClass('trigger-add-custom-product');
                }, 2000);
            } else {

            }

        });


        jQuery(document).on('click', '#userSearchFormTrigger', function() {
            var search = jQuery('#userSearchForm input[name="search"]').val();
            if (search) {
                jQuery('#userSearchForm .loading-style-1').removeClass('d-none');
                jQuery('#user-results .results-holder').html('');
                jQuery.ajax({
                    type: 'POST',
                    url: "/wp-admin/admin-ajax.php",
                    data: {
                        'action': 'user_search_ajax',
                        'search': search,
                    },
                    success: function(result) {
                        console.log('xsdsds');
                        jQuery('#user-results .results-holder').html(result);
                        jQuery('#userSearchForm .loading-style-1').addClass('d-none');
                    }
                });
            } else {
                alert('Search field is required.');
            }
        });



        jQuery('#custom-shipping-cost').on('click', '.apply_custom_shipping_cost', function() {
            var custom_shipping_cost = jQuery('#custom-shipping-cost input[name="custom_shipping_cost"]').val();
            console.log(custom_shipping_cost);
            jQuery.ajax({
                type: 'POST',
                url: "/wp-admin/admin-ajax.php",
                data: {
                    'action': 'custom_shipping_ajax',
                    'custom_shipping_cost': custom_shipping_cost,
                },
                success: function(result) {
                    setTimeout(function() {
                        jQuery('body').trigger('update_checkout');
                    }, 1000);
                }
            });
        });
    </script>
    <?php
}

add_action('wp_footer', 'action_custom_checkout');


add_action('woocommerce_thankyou', 'action_delete_custom_products');

function action_delete_custom_products($order_id)
{
    $order = wc_get_order($order_id);
    // Get and Loop Over Order Items
    foreach ($order->get_items() as $item_id => $item) {
        $product_id = $item->get_product_id();
        $delete_product = get_post_meta($product_id, 'delete_product', true);

        if ($delete_product) {
            wp_delete_post($product_id, true);
        }
    }
}



add_action('wp_ajax_nopriv_user_search_ajax', 'user_search_ajax'); // for not logged in users
add_action('wp_ajax_user_search_ajax', 'user_search_ajax');
function user_search_ajax()
{
    $search = $_POST['search'];
    $args = array(
        'role' => array('customer'),
        'number' => 10, ''
    );
    $args['role'] = array('customer');
    $args['number'] = 10;
    if (isset($search)) {
        $args['search'] = '*' . $search . '*';
    }
    $user_query = new WP_User_Query($args);
    if ($user_query->get_results()) {
    ?>
        <?php foreach ($user_query->get_results() as $user) {  ?>
            <?php
            $link = user_switching::maybe_switch_url($user);
            ?>
            <tr>
                <td><?= $user->display_name ?> </td>
                <td><?= $user->user_email ?></td>
                <td class="text-end">
                    <div class="d-inline-flex">
                        <a class="btn btn-link me-3" href="<?= $link ?>&redirect_to=https://systempak.net/my-account/orders/">
                            View Orders
                        </a>
                        <a class="btn btn-link" href="<?= $link ?>&redirect_to=https://systempak.net/phone-orders/">
                            Select Customer
                        </a>
                    </div>
                </td>
            </tr>
        <?php } ?>

    <?php

    } else {
    ?>
        <tr>
            <td colspan="3" class="p-5">
                <h3>No customer found</h3>
            </td>
        </tr>
<?php
    }

    die();
}


add_action('admin_bar_menu', 'add_toolbar_items', 100);
function add_toolbar_items($admin_bar)
{
    $admin_bar->add_menu(array(
        'id'    => 'phone-orders',
        'title' => 'Phone Orders',
        'href'  => 'https://systempak.net/phone-orders/',
        'meta'  => array(
            'title' => __('Phone Orders'),
        ),
    ));
}


add_action('woocommerce_before_calculate_totals', 'custom_cart_item_price', 999999, 1);
function custom_cart_item_price($cart)
{

    if (is_admin() && !defined('DOING_AJAX'))
        return;

    foreach ($cart->get_cart() as $cart_item) {
        if (isset($cart_item['custom_price']) && !empty($cart_item['custom_price'])) {
            $final_price = $cart_item['custom_price'];
            $cart_item['data']->set_price($final_price);
        }
    }
}

function customer_capabilities()
{
    $user_id = get_current_user_id();
    $old_user = user_switching::get_old_user();

    if ($old_user) {
        //to add capability to user
        $user = new WP_User($user_id);
        $user->add_cap('read_private_products', true);
        $user->add_cap('edit_others_products', true);
        $user->add_cap('edit_private_products', true);

        $user->add_cap('read_private_product_variations', true);
        $user->add_cap('edit_others_product_variations', true);
        $user->add_cap('edit_private_product_variations', true);
    } else {
        $user = new WP_User($user_id);
        $user->remove_cap('read_private_products', true);
        $user->remove_cap('edit_others_products', true);
        $user->remove_cap('edit_private_products', true);

        $user->remove_cap('read_private_product_variations', true);
        $user->remove_cap('edit_others_product_variations', true);
        $user->remove_cap('edit_private_product_variations', true);
    }
}

add_action('init', 'customer_capabilities');

function disable_shipping_calc_on_cart($show_shipping)
{
    $old_user = user_switching::get_old_user();
    if ($old_user) {
        return false;
    } else {
        return $show_shipping;
    }
}
add_filter('woocommerce_cart_ready_to_calc_shipping', 'disable_shipping_calc_on_cart', 99);


remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
add_action('custom_coupon_form', 'woocommerce_checkout_coupon_form');

