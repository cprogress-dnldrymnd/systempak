<?php
/*-----------------------------------------------------------------------------------*/
/* Template Name: Phone Orders
/*-----------------------------------------------------------------------------------*/
?>
<?php get_header() ?>
<?php
$old_user = user_switching::get_old_user();
?>
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
                                <strong><?= $user->user_email ?></strong>
                                <a class="button" href="<?= $link ?>&redirect_to=https://systempak.net/phone-orders/">
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
    <?php if (is_user_logged_in() && $old_user) { ?>

        <section class="checkout-form">
            <div class="container-fluid">
                <a href="<?= get_site_url() ?>"></a>
                <?= do_shortcode('[woocommerce_checkout]') ?>
            </div>
        </section>
    <?php } ?>


<?php } ?>


<?php get_footer() ?>