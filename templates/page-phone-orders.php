<?php
/*-----------------------------------------------------------------------------------*/
/* Template Name: Phone Orders
/*-----------------------------------------------------------------------------------*/
?>
<?php get_header() ?>

<section class="checkout-form">
    <?= do_shortcode('[woocommerce_checkout]') ?>
</section>

<?php get_footer() ?>