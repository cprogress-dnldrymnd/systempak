jQuery(document).ready(function () {
    quantity_plus_minus();
    steps();
    apply_coupon_custom();
    ajax_products_form();
    ajax_products();
    ajax_select_product_trigger();
    select_products();
    custom_shipping_ajax();
    //custom_product_ajax();
    //load_more_button_listener();
});


function quantity_plus_minus() {
    jQuery(document).on('click', 'button.plus, button.minus', function () {
        target = jQuery(this).attr('target');
        var qty = jQuery('input[name="' + target + '"]');
        var val = parseFloat(qty.val());
        var max = parseFloat(qty.attr('max'));
        var min = parseFloat(qty.attr('min'));
        var step = parseFloat(qty.attr('step'));

        if (jQuery(this).is('.plus')) {
            if (max && (max <= val)) {
                qty.val(max);
            } else {
                qty.val(val + step);
            }
        } else {
            if (min && (min >= val)) {
                qty.val(min);
            } else if (val > 1) {
                qty.val(val - step);
            }
        }

        qty.change();


    });

    jQuery(document).on('click', '.remove-item', function () {
        target = jQuery(this).attr('target');
        var qty = jQuery('input[name="' + target + '"]');
        qty.val(0);
        console.log(qty.val());
        qty.change();
    });


}

function steps() {
    jQuery(document).on('click', '.continue', function () {
        validate();
    });
    jQuery(document).on('click', '.back-to', function () {
        jQuery('.step-box.active').addClass('d-none').removeClass('active').prev().removeClass('d-none').addClass('active');

        jQuery('.nav-box ul li.active').removeClass('active').prev().addClass('active');
        $step = jQuery('.step-box.active').attr('step');

        previous_step($step);
    });
}


function validate() {

    jQuery('#place_order').click();

    if (jQuery('.step-box.active .woocommerce-invalid').length > 0) {

    } else {
        jQuery('.step-box.active').addClass('d-none').removeClass('active').next().removeClass('d-none').addClass('active');
        jQuery('.nav-box ul li.active').removeClass('active').next().addClass('active');
        $step = jQuery('.step-box.active').attr('step');
        previous_step($step);
    }
}



function previous_step($step) {
    if ($step == 1) {
        jQuery('.previous-step').addClass('d-none');
    } else if ($step == 2) {
        $email = jQuery('input[name="billing_email"]').val();
        jQuery('.previous-step.contact .email').text($email);
        jQuery('.previous-step.contact').removeClass('d-none');
        jQuery('.previous-step.address').addClass('d-none');

    } else if ($step == 3) {
        $billing_address_1 = jQuery('input[name="billing_address_1"]').val();
        $billing_address_2 = jQuery('input[name="billing_address_2"]').val();
        $billing_city = jQuery('input[name="billing_city"]').val();
        $billing_state = jQuery('input[name="billing_state"]').val();
        $billing_postcode = jQuery('input[name="billing_postcode"]').val();
        $address = $billing_address_1 + ' ' + $billing_address_2 + ' ' + $billing_city + ' ' + $billing_state + ' ' + $billing_postcode;

        jQuery('.previous-step.address').removeClass('d-none');
        jQuery('.previous-step.address .address').text($address);

    }
}

function apply_coupon_custom() {

    jQuery(document).on('click', '.apply_coupon_custom', function () {
        coupon_ajax();
    });

    jQuery(document).on('click', '.woocommerce-remove-coupon', function () {

        jQuery(document.body).on('updated_checkout', function () {
            jQuery('.coupon-message').html('<span>Coupon has been removed.</span>');

        });
    });

}


function coupon_ajax() {
    $coupon_code = jQuery('input[name="coupon_code_custom"]').val();
    console.log($coupon_code);
    if ($coupon_code) {
        jQuery.ajax({
            type: "POST",


            url: "/wp-admin/admin-ajax.php",

            data: {
                action: 'coupon_ajax',
                coupon_code: $coupon_code,
            },

            success: function (response) {
                jQuery('body').trigger('update_checkout');
                jQuery(document.body).on('updated_checkout', function () {
                    jQuery('.coupon-message').html(response);
                });
            },
            error: function (e) {
                console.log(e);
            }

        });

    } else {
        jQuery('.coupon-message').html('<span class="failed">Please enter a valid coupon code.</span>');

    }
}


function ajax_products_form() {
    var typingTimer;
    var doneTypingInterval = 500;

    jQuery('.search-section-products #search-input-product').on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    jQuery('.search-section-products #search-input-product').on('keydown', function () {
        clearTimeout(typingTimer);
    });

    function doneTyping() {
        ajax_products();
    }
}
/*

function load_more_button_listener($) {
    jQuery(document).on("click", '.search-section-products #load-more', function (event) {
        event.preventDefault();
        var offset = jQuery('.post-item').length;
        ajax_products(offset, 'append');
    });

}*/




function ajax_products($offset, $event_type = 'html') {

    var $loadmore = jQuery('.search-section-products #load-more');

    var $archive_section = jQuery('.search-section-products');

    var $result_holder = jQuery('.search-section-products #results .results-holder');

    var $s = jQuery('#search-input-product').val();

    $loading = jQuery('<div class="loading-results"> <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"/></svg></div>');

    $archive_section.addClass('loading-post');

    if ($event_type == 'html') {
        jQuery('#results  .results-holder').html($loading);
        $loadmore.addClass('d-none');
    } else {
        $loadmore.addClass('loading');
        $loadmore.find('span').text('Loading');
    }


    jQuery.ajax({

        type: "POST",

        url: "/wp-admin/admin-ajax.php",

        data: {

            action: 'search_ajax_products',

            s: $s,

            offset: $offset,

        },

        success: function (response) {
            if ($event_type == 'append') {
                $result_holder_row = $result_holder.find('.post-item-holder');
                jQuery(response).appendTo($result_holder_row);
            } else {
                $result_holder.html(response);
                jQuery('#pagination').html('');
                jQuery('.pagination').appendTo('#pagination');
            }
            $loadmore.removeClass('d-none loading');

            $loadmore.find('span').text('Load more');

            $archive_section.removeClass('loading-post');

        },
        error: function (e) {
            console.log(e);
        }

    });
}

function ajax_select_product_trigger() {
    jQuery(document).on('click', '#add-to-order', function () {
        ajax_select_product(jQuery(this));
    });
}



function select_products() {
    jQuery(document).on('click', '.product-add-to-basket', function () {
        if (jQuery('#selected-products').hasClass('d-none')) {
            jQuery('#selected-products').removeClass('d-none');
        }
        $product_id = jQuery(this).attr('product-id');
        $post_item = jQuery('.post-' + $product_id);
        $post_item.find('.product-add-to-basket').text('-').addClass('product-remove-to-basket').removeClass('product-add-to-basket');
        $post_item.appendTo('#selected-products .post-item-holder');
    });

    jQuery(document).on('click', '.product-remove-to-basket', function () {
        if (jQuery('#selected-products .post-item').length == 1) {
            jQuery('#selected-products').addClass('d-none');
        } else {
            jQuery('#selected-products').removeClass('d-none');
        }
        $product_id = jQuery(this).attr('product-id');
        $post_item = jQuery('.post-' + $product_id);
        $post_item.find('.product-remove-to-basket').text('+').addClass('product-add-to-basket').removeClass('product-remove-to-basket');
        $post_item.appendTo('.select-products .results-holder .post-item-holder');
    });


}


function ajax_select_product($this) {
    $this.addClass('adding');

    $post_item = jQuery('#selected-products .post-item');
    $product_ids = [];
    $post_item.each(function (index, element) {
        $product_id = jQuery(this).attr('product-id');
        $product_ids.push($product_id);

    });



    jQuery.ajax({

        type: "POST",

        url: "/wp-admin/admin-ajax.php",

        data: {

            action: 'select_product_ajax',

            product_ids: $product_ids,

        },

        success: function (response) {
            jQuery('body').trigger('update_checkout');
            $this.removeClass('adding');
            $post_item.remove();
        },
        error: function (e) {
            console.log(e);
        }

    });
}

function custom_shipping_ajax() {
    jQuery('div.woocommerce').on('click', '.apply_custom_shipping_cost', function () {
        var custom_shipping_cost = parseFloat(jQuery('#custom-shipping-cost input[name="custom_shipping_cost"]').val());

        if (custom_shipping_cost) {
            custom_shipping_cost_val = custom_shipping_cost;
        } else {
            custom_shipping_cost_val = 'false';
        }
        console.log(custom_shipping_cost_val);
        jQuery.ajax({
            type: 'POST',
            url: "/wp-admin/admin-ajax.php",
            data: {
                'action': 'custom_shipping_ajax',
                'custom_shipping_cost': custom_shipping_cost_val,
            },
            success: function (result) {
                jQuery('body').trigger('update_checkout');
            }
        });
    });
}

function custom_product_ajax() {
    jQuery(document).on('click', '#add-custom-product', function () {

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
            },
            success: function (result) {
                jQuery('#addCustomProduct .loading').addClass('d-none');
                jQuery('body').trigger('update_checkout');
                jQuery('button[data-bs-dismiss="modal"]')

                jQuery('.cart-product-' + result).addClass('highlight');

                setTimeout(function () {

                    jQuery('.cart-product-' + result).removeClass('highlight');

                }, 1000);

            }
        });
    });
}