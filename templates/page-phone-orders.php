<?php
/*-----------------------------------------------------------------------------------*/
/* Template Name: Phone Orders
/*-----------------------------------------------------------------------------------*/
?>
<?php get_header(); ?>
<div class="phone-orders">
    <?php
    /**
     * Checkout Form
     *
     * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
     *
     * HOWEVER, on occasion WooCommerce will need to update template files and you
     * (the theme developer) will need to copy the new files to your theme to
     * maintain compatibility. We try to do this as little as possible, but it does
     * happen. When this occurs the version of the template file will be bumped and
     * the readme will list any important changes.
     *
     * @see https://docs.woocommerce.com/document/template-structure/
     * @package WooCommerce\Templates
     * @version 3.5.0
     */

    if (!defined('ABSPATH')) {
        exit;
    }


    // If checkout registration is disabled and not logged in, the user cannot checkout.
    if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
        echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
        return;
    }

    ?>
    <div class="checkout-section">
        <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-7">
                        <div class="column-holder py-5">
                            <div class="logo-box">
                                <a href="<?= get_site_url() ?>">
                                    SYSTEMPAK
                                </a>
                            </div>
                            <div class="nav-box my-4">
                                <ul class="d-flex list-inline">
                                    <li class="active">
                                        DETAILS
                                    </li>
                                    <li>
                                        ADDRESS
                                    </li>
                                    <li>
                                        PAYMENT
                                    </li>
                                </ul>
                            </div>


                            <div class="previous-steps">
                                <div class="previous-step d-none contact">
                                    <div class="row">
                                        <div class="col-2">
                                            <label for="">Contact</label>
                                        </div>
                                        <div class="col-8">
                                            <span class="email"></span>
                                        </div>
                                        <div class="col-2 text-end">
                                            <a class="back-to">Edit</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="previous-step d-none address">
                                    <div class="row">
                                        <div class="col-2">
                                            <label for="">Address</label>
                                        </div>
                                        <div class="col-8">
                                            <div class="address"></div>
                                        </div>
                                        <div class="col-2 text-end">
                                            <a class="back-to">Edit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="step-box customer-details active" step="1">
                                <div class="heading-box">
                                    <h2>Customer Details</h2>
                                </div>
                                <div id="customer_details">
                                    <?php
                                    do_action('woocommerce_checkout_billing');
                                    ?>
                                </div>
                                <div class="step-buttons mt-5 d-flex justify-content-between">
                                    <a class="continue button">CONTINUE TO ADDRESS</a>
                                    <a class="d-flex align-items-center" href="/shop">
                                        <svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="17" height="12" fill="none">
                                            <path d="M16 6H1M6 1L1 6l5 5" stroke="#16110E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <strong>Back to Shop</strong>
                                    </a>
                                </div>
                            </div>

                            <div class="step-box address d-none" step="2">
                                <?php do_action('woocommerce_checkout_shipping'); ?>
                                <div class="step-buttons mt-5 d-flex justify-content-between">
                                    <a class="continue button">CONTINUE TO PAYMENT</a>
                                    <a class="back-to d-flex align-items-center">
                                        <svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="17" height="12" fill="none">
                                            <path d="M16 6H1M6 1L1 6l5 5" stroke="#16110E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <strong>Back</strong>
                                    </a>
                                </div>
                            </div>
                            <div class="step-box payment d-none" step="3">
                                <div class="heading-box">
                                    <h2>Payment</h2>
                                </div>
                                <?php do_action('custom_woocommerce_checkout_shipping'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 column-order">
                        <div class="column-holder py-5">
                            <div class="heading-box basket-heading">
                                <h2>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="25" fill="none">
                                        <path d="M7 10.5v-5a4.013 4.013 0 014-4 4.013 4.013 0 014 4v5m3.734 13H3.266a2 2 0 01-1.985-2.248L3 7.5h16l1.719 13.752a2 2 0 01-1.985 2.248z" stroke="#000" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    Basket
                                    <div class="count">
                                        <span class="counter" id="cart-count">
                                            <?php
                                            $cart_count = WC()->cart->get_cart_contents_count();
                                            echo sprintf(_n('%d', '%d', $cart_count), $cart_count);
                                            ?>
                                        </span>
                                    </div>
                                </h2>
                            </div>
                            <div class="shipping-methods d-flex align-items-center justify-content-between">
                                <div class="shipping-method-title d-flex align-items-center">
                                    <svg class="me-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none">
                                        <path d="M6.5 3.25l12 6M23 7l-10 5m10-5v10l-10 6M23 7L11 1 1 6m12 6L1 6m12 6v11M1 6v11l12 6" stroke="#16110E" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <strong>Shipping</strong>
                                </div>
                                <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

                                    <?php do_action('woocommerce_review_order_before_shipping'); ?>

                                    <?php wc_cart_totals_shipping_html(); ?>

                                    <?php do_action('woocommerce_review_order_after_shipping'); ?>

                                <?php endif; ?>
                            </div>
                            <?php do_action('woocommerce_checkout_before_order_review'); ?>
                            <div id="order_review" class="woocommerce-checkout-review-order">
                                <?php do_action('woocommerce_checkout_order_review'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
    <?php do_action('woocommerce_after_checkout_form', $checkout); ?>

    <script>
        jQuery(document).ready(function() {
            quantity_plus_minus();
            steps();
            apply_coupon_custom();
        });



        function quantity_plus_minus() {
            jQuery(document).on('click', 'button.plus, button.minus', function() {
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

            jQuery(document).on('click', '.remove-item', function() {
                target = jQuery(this).attr('target');
                var qty = jQuery('input[name="' + target + '"]');
                qty.val(0);
                console.log(qty.val());
                qty.change();
            });


        }

        function steps() {
            jQuery(document).on('click', '.continue', function() {
                validate();
            });
            jQuery(document).on('click', '.back-to', function() {
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

            jQuery(document).on('click', '.apply_coupon_custom', function() {
                coupon_ajax();
            });

            jQuery(document).on('click', '.woocommerce-remove-coupon', function() {

                jQuery(document.body).on('updated_checkout', function() {
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

                    success: function(response) {
                        jQuery('body').trigger('update_checkout');
                        jQuery(document.body).on('updated_checkout', function() {
                            jQuery('.coupon-message').html(response);
                        });
                    },
                    error: function(e) {
                        console.log(e);
                    }

                });

            } else {
                jQuery('.coupon-message').html('<span class="failed">Please enter a valid coupon code.</span>');

            }
        }
    </script>
</div>
<?php get_footer(); ?>