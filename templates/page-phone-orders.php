<?php
/*-----------------------------------------------------------------------------------*/
/* Template Name: Phone Orders
/*-----------------------------------------------------------------------------------*/
?>
<?php get_header() ?>

<?php if (current_user_can('administrator')) { ?>
    <section class="select-user">
        <h3>Please select a user first before creating order</h3>
    </section>
<?php } else { ?>
    <section class="checkout-form">
        <?= do_shortcode('[woocommerce_checkout]') ?>
    </section>
<?php } ?>
<?php get_footer() ?>