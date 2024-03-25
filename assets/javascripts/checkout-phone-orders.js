jQuery(document).ready(function () {
    quantity_plus_minus();
    steps();
    apply_coupon_custom();
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