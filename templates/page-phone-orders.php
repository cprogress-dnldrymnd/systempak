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
        'orderby' => 'registered',
        'order' => 'DESC'
    );
    $user_query = new WP_User_Query($args);
    ?>

    <section class="select-user-form py-5">
        <div class="container">
            <?php
            $errors = '';
            if (!empty($_POST)) {
                $email = $_POST['email'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $company_name = $_POST['company_name'];
                $country = $_POST['country'];
                $address_1 = $_POST['address_1'];
                $address_2 = $_POST['address_2'];
                $city = $_POST['city'];
                $state = $_POST['state'];
                $postcode = $_POST['postcode'];
                $phone = $_POST['phone'];


                if (email_exists($email)) {
                    $errors = '<p>An account is already registered with your email address.</p>';
                }

                if (empty($username) || !validate_username($username)) {
                    $errors .= '<p>Please enter a valid account username.</p>';
                }

                if (username_exists($username)) {
                    $errors .= '<p>An account is already registered with that username. Please choose another.</p>';
                }
            }
            ?>


            <div id="addNewCustomer" class="form-wrapper">
                <?php
                if ($errors == '') {
                    $user_id = wc_create_new_customer($email, $username, $password);

                    update_user_meta($user_id, "billing_first_name", $first_name);
                    update_user_meta($user_id, "billing_last_name", $last_name);
                    update_user_meta($user_id, "billing_company", $company_name);
                    update_user_meta($user_id, "billing_country", $country);
                    update_user_meta($user_id, "billing_address_1", $address_1);
                    update_user_meta($user_id, "billing_address_2", $billing_address_2);
                    update_user_meta($user_id, "billing_city", $city);
                    update_user_meta($user_id, "billing_state", $state);
                    update_user_meta($user_id, "billing_postcode", $postcode);
                    update_user_meta($user_id, "billing_phone", $phone);

                    update_user_meta($user_id, "shipping_first_name", $first_name);
                    update_user_meta($user_id, "shipping_last_name", $last_name);
                    update_user_meta($user_id, "shipping_company", $company_name);
                    update_user_meta($user_id, "shipping_country", $country);
                    update_user_meta($user_id, "shipping_address_1", $address_1);
                    update_user_meta($user_id, "shipping_address_2", $shipping_address_2);
                    update_user_meta($user_id, "shipping_city", $city);
                    update_user_meta($user_id, "shipping_state", $state);
                    update_user_meta($user_id, "shipping_postcode", $postcode);
                    update_user_meta($user_id, "shipping_phone", $phone);


                    $user = get_user_by('id', $user_id);
                    if ($user) {
                        wp_redirect($link);
                        $link = user_switching::maybe_switch_url($user) . '&redirect_to=https://systempak.net/phone-orders/';
                        $link_final = str_replace('&amp;', '&', $link);
                        wp_redirect($link_final);
                        exit;
                    }
                } else {
                    echo $errors;
                }
                ?>
                <?php if ($errors || empty($_POST)) { ?>
                    <form action="<?= get_permalink() ?>" method="POST">
                        <div class="form-holder">
                            <h3>Add Customer Form</h3>

                            <div class="row g-3 m-0">

                                <div class="col-6">
                                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Customer First Name" value="<?= $first_name ?>" required>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Customer Last Name" value="<?= $last_name ?>" required>
                                </div>

                                <div class="col-12">
                                    <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Customer Company Name" value="<?= $company_name ?>">
                                </div>

                                <div class="col-12">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Customer Email Address" value="<?= $email ?>" required>
                                </div>
                                <div class="col-12">
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Customer Username" value="<?= $username ?>" required>
                                </div>
                                <div class=" col-12">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Customer Password" value="<?= $password ?>" required>
                                </div>
                                <div class=" col-12">
                                    <?php
                                    global $woocommerce;
                                    $countries_obj   = new WC_Countries();
                                    $countries   = $countries_obj->__get('countries');

                                    if (isset($country)) {
                                        $default = $country;
                                    } else {
                                        $default = 'GB';
                                    }
                                    woocommerce_form_field(
                                        'country',
                                        array(
                                            'type'       => 'select',
                                            'class'      => array('chzn-drop'),
                                            'placeholder'    => __('Select a Country'),
                                            'options'    => $countries,
                                            'required' => true,
                                            'default' => $default
                                        )
                                    );
                                    ?>
                                </div>

                                <div class="col-12">
                                    <input type="text" class="form-control" name="address_1" id="address_1" placeholder="Customer Street Address" value="<?= $address_1 ?>" required>
                                </div>

                                <div class="col-12">
                                    <input type="text" class="form-control" name="address_2" id="address_2" placeholder="Customer Flat, suite, unit, etc. (optional)" value="<?= $address_2 ?>">
                                </div>

                                <div class="col-12">
                                    <input type="text" class="form-control" name="city" id="city" placeholder="Customer Town/City" value="<?= $city ?>" required>
                                </div>

                                <div class="col-12">
                                    <input type="text" class="form-control" name="state" id="state" placeholder="Customer State/County" value="<?= $state ?>" required>
                                </div>


                                <div class="col-12">
                                    <input type="text" class="form-control" name="postcode" id="postcode" placeholder="Customer Postcode" value="<?= $postcode ?>" required>
                                </div>

                                <div class="col-12">
                                    <input type="tel" class="form-control" name="phone" id="phone" placeholder="Customer Phone" value="<?= $phone ?>" required>
                                </div>

                                <div class=" col-12">
                                    <button type="submit" class="btn btn-primary w-100" style="border-radius: 5px !important;">Create Customer and Create Order</button>
                                </div>

                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>

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