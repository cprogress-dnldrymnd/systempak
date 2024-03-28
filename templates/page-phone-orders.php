<?php
/*-----------------------------------------------------------------------------------*/
/* Template Name: Phone Orders
/*-----------------------------------------------------------------------------------*/
?>
<?php get_header() ?>

<?php if (current_user_can('administrator')) { ?>
    <?php
    $args = array(
        'role' => array('customer')
    );
    $users = get_users($args);
    ?>
    <section class="select-user py-5">
        <div class="container-fluid">
            <div class="inner">
                <h3>Please select a user first before creating order</h3>
                <div class="row gy-2">
                    <?php foreach ($users as $user) { ?>
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
        </div>
    </section>
<?php } else { ?>
    <?php if (is_user_logged_in()) { ?>
        <section class="logged-in-as mb-5">
            <?php
            $current_user = wp_get_current_user();
            ?>
            <div class="container-fluid">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-0">Logged-in as <?= $current_user->user_email ?></h5>
                        <a class="button" href="/my-account/orders/">View Orders</a>
                    </div>
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
<?php } ?>

<?php get_footer() ?>