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

    <section class="select-user-form py-5">
        <div class="container">
            <h3>Please search and select a user first before creating order</h3>

            <form action="">
                <div class="mb-3">
                    <label for="userSearch" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="userSearch" aria-describedby="emailHelp">
                </div>
            
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <div id="user-results">
                <div class="results-holder">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email Address</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) { ?>

                                <?php
                                $link = user_switching::maybe_switch_url($user);
                                ?>
                                <tr>
                                    <td><?= $user->display_name ?> </td>
                                    <td><?= $user->user_email ?></td>
                                    <td>
                                        <a class="btn btn-primary" href="<?= $link ?>&redirect_to=https://systempak.net/phone-orders/">
                                            Select Customer
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>

                        </tbody>
                    </table>
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