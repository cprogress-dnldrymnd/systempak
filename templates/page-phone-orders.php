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

        <section class="checkout-form">
            <div class="container-fluid">
                <a href="<?= get_site_url() ?>"></a>
                <?= do_shortcode('[woocommerce_checkout]') ?>
            </div>
        </section>
    <?php } ?>

    <!-- Modal -->
    <div class="modal fade" id="addCustomProduct" tabindex="-1" aria-labelledby="addCustomProductLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCustomProductLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php get_footer() ?>