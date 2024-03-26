<?php
/*-----------------------------------------------------------------------------------*/
/* Template Name: Phone Orders
/*-----------------------------------------------------------------------------------*/
?>
<?php get_header() ?>
<section class="checkout-form">
    <div class="container-fluid">
        <?= do_shortcode('[woocommerce_checkout]') ?>
    </div>
</section>
<?php get_footer() ?>