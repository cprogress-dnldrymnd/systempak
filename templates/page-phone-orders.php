<?php
/*-----------------------------------------------------------------------------------*/
/* Template Name: Phone Orders
/*-----------------------------------------------------------------------------------*/
?>
<?php get_header() ?>

<?php if (current_user_can('administrator')) { ?>
    <section class="select-user" style="max-width: 500px">
        <h3>Please select a user first before creating order</h3>
        <div class="row g-2">
            <?php foreach (get_users() as $user) { ?>
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <strong><?= $user->display_name ?></strong>
                        <a class="button" href="<?= wp_login_url() ?>?action=switch_to_user&user_id=<?= $user->ID ?>&nr=1&_wpnonce=<?= wp_create_nonce() ?>">
                            Select Customer
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
<?php } else { ?>
    <section class="checkout-form">
        <?= do_shortcode('[woocommerce_checkout]') ?>
    </section>
<?php } ?>