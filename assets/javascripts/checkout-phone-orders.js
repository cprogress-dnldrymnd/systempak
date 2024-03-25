jQuery(document).ready(function () {
    quantity_plus_minus();
    steps();
    apply_coupon_custom();
    ajax_products_form();
    ajax_products();
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

    jQuery('.search-section #search-input-product').on('keyup', function () {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(doneTyping, doneTypingInterval);
    });

    jQuery('.search-section #search-input-product').on('keydown', function () {
        clearTimeout(typingTimer);
    });

    function doneTyping() {
        ajax_products();
    }
}


function load_more_button_listener($) {
    jQuery(document).on("click", '#load-more', function (event) {
        event.preventDefault();
        var offset = jQuery('.post-item').length;
        ajax_products(offset, 'append');
    });

}


function results_height() {
    if (jQuery('#results').length > 0) {
        $height = jQuery('#results .results-holder').outerHeight();
        jQuery('#results').css('height', $height + 'px');
    }
}


function ajax_products($offset, $event_type = 'html') {

    var $loadmore = jQuery('#load-more');

    var $archive_section = jQuery('.search-section');

    var $result_holder = jQuery('#results .results-holder');

    var $posts_per_page = 12;

    var $s = jQuery('#search-input').val();

    var $post_type = jQuery('input[name="post_type"]:checked').val();

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

            posts_per_page: $posts_per_page,

            s: $s,

            offset: $offset,

            post_type: $post_type,

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

            //results_height();
        },
        error: function (e) {
            console.log(e);
        }

    });
}

function ajax_product_modal_trigger() {
    jQUery('.product-add-to-cart-modal').click(function (e) {
        $product_id = jQUery(this).attr('product-id');
    });
}


function ajax_product_modal($product_id) {

    jQuery.ajax({

        type: "POST",

        url: "/wp-admin/admin-ajax.php",

        data: {

            action: 'ajax_product_modal',

            product_id: $product_id,

        },

        success: function (response) {
            $result_holder.html(response);
        },
        error: function (e) {
            console.log(e);
        }

    });
}

jQuery(function ($) {
    $ = jQuery;
    /* global wc_add_to_cart_params */
    if (typeof wc_add_to_cart_params === 'undefined') {
        return false;
    }

    $(document).on('submit', 'form.cart', function (e) {

        var form = $(this),
            button = form.find('.single_add_to_cart_button');

        var formFields = form.find('input:not([name="product_id"]), select, button, textarea');
        // create the form data array
        var formData = [];
        formFields.each(function (i, field) {
            // store them so you don't override the actual field's data
            var fieldName = field.name,
                fieldValue = field.value;
            if (fieldName && fieldValue) {
                // set the correct product/variation id for single or variable products
                if (fieldName == 'add-to-cart') {
                    fieldName = 'product_id';
                    fieldValue = form.find('input[name=variation_id]').val() || fieldValue;
                }
                // if the fiels is a checkbox/radio and is not checked, skip it
                if ((field.type == 'checkbox' || field.type == 'radio') && field.checked == false) {
                    return;
                }
                // add the data to the array
                formData.push({
                    name: fieldName,
                    value: fieldValue
                });
            }
        });
        if (!formData.length) {
            return;
        }

        e.preventDefault();

        form.block({
            message: null,
            overlayCSS: {
                background: "#ffffff",
                opacity: 0.6
            }
        });
        $(document.body).trigger('adding_to_cart', [button, formData]);

        $.ajax({
            type: 'POST',
            url: woocommerce_params.wc_ajax_url.toString().replace('%%endpoint%%', 'add_to_cart'),
            data: formData,
            success: function (response) {
                if (!response) {
                    return;
                }
                if (response.error & response.product_url) {
                    window.location = response.product_url;
                    return;
                }

                $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, button]);
            },
            complete: function () {
                form.unblock();
            }
        });

        return false;

    });
});