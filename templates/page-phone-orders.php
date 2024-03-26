<?php
/*-----------------------------------------------------------------------------------*/
/* Template Name: Phone Orders
/*-----------------------------------------------------------------------------------*/
?>
<?php get_header() ?>
<?php

?>
<?php if (current_user_can('administrator')) { ?>
    <section class="select-user py-5" style="max-width: 800px">
        <div class="container-fluid">
            <h3>Please select a user first before creating order</h3>


            <div class="row gy-2">
                <?php foreach (get_users() as $user) { ?>
                    <?php
                    $link = user_switching::maybe_switch_url($user);
                    ?>
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <strong><?= $user->display_name ?></strong>
                            <a class="button" href="<?= $link ?>&redirect_to=https://spnew.theprogressteam.com/phone-orders/">
                                Select Customer
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } else { ?>
    <section class="logged-in-as mb-5">
        <?php
        $current_user = wp_get_current_user();
        ?>
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <h5 class="mb-0">Logged-in as <?= $current_user->user_email ?></h5>
                <h5 class="mb-0">
                    <?php
                    $old_user = user_switching::get_old_user();
                    if ($old_user) {
                        printf(
                            '<a href="%1$s">Switch back to %2$s</a>',
                            esc_url(user_switching::switch_back_url($old_user)) . '&redirect_to=https://spnew.theprogressteam.com/phone-orders/',
                            esc_html($old_user->display_name)
                        );
                    }
                    ?>
                </h5>
            </div>
        </div>
    </section>
    <section class="checkout-form">
        <div class="container-fluid">
            <?= do_shortcode('[woocommerce_checkout]') ?>
        </div>
    </section>
<?php } ?>