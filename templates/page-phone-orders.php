<?php
/*-----------------------------------------------------------------------------------*/
/* Template Name: Phone Orders
/*-----------------------------------------------------------------------------------*/
?>
<?php get_header() ?>
<?php
$old_user = user_switching::get_old_user();
echo '<br><br>';
?>

<?php if (current_user_can('administrator')) { ?>
    <?php
    $args = array(
        'role' => array('customer'),
        'number' => 10,
    );
    $user_query = new WP_User_Query($args);
    ?>

    <section class="select-user-form py-5">
        <div class="container">
            <?php if (empty($_POST)) { ?>
                <div id="addNewCustomer" class="form-wrapper">
                    <form action="<?= get_permalink() ?>" method="POST">
                        <div class="form-holder">
                            <h3>Add Customer Form</h3>

                            <div class="row g-3 m-0">
                                <div class="col-12">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Customer Email Address" required>
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Customer Username" required>
                                </div>
                                <div class="col-12">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Customer Password" required>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary w-100" style="border-radius: 5px !important;">Create Customer and Create Order</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } else { ?>

                <?php
                $email = $_POST['email'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $user_id = wc_create_new_customer($email, $username, $password);
                ?>

            <?php } ?>
            <div id="userSearchForm" class="form-wrapper">
                <div class="form-holder">
                    <h3>Customer Search Form</h3>

                    <div class="row g-0 m-0">
                        <div class="col">
                            <input type="text" class="form-control" name="search" id="userSearch" placeholder="Search by name or email adress">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary" id="userSearchFormTrigger">Search customer</button>
                        </div>
                    </div>
                </div>
                <div id="user-results">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"><strong>Name</strong></th>
                                <th scope="col"><strong>Email Address</strong></th>
                                <th scope="col" class="text-end"><strong>Actions</strong></th>
                            </tr>
                        </thead>
                        <tbody class="results-holder">
                            <?php foreach ($user_query->get_results() as $user) {  ?>

                                <?php
                                $link = user_switching::maybe_switch_url($user);
                                ?>
                                <tr>
                                    <td><?= $user->display_name ?> </td>
                                    <td><?= $user->user_email ?></td>
                                    <td class="text-end">
                                        <div class="d-inline-flex">
                                            <a class="btn btn-link me-3" href="<?= $link ?>&redirect_to=https://systempak.net/my-account/orders/">
                                                View Orders
                                            </a>
                                            <a class="btn btn-link" href="<?= $link ?>&redirect_to=https://systempak.net/phone-orders/">
                                                Select Customer
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <div class="loading-style-1 d-none">
                        <svg class="adding-product" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"></path>
                        </svg>
                    </div>
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