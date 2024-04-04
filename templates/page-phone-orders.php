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
        'role' => array('customer'),
        'number' => 10,
    );
    $user_query = new WP_User_Query($args);
    ?>

    <section class="select-user-form py-5">
        <div class="container">
            <h3>Please search and select a user first before creating order</h3>

            <div id="userSearchForm">
                <div class="form-holder">
                    <div class="mb-3">
                        <label for="userSearch" class="form-label">Email address</label>
                        <input type="search" class="form-control" name="search" id="userSearch">
                    </div>
                    <button type="submit" class="btn btn-primary" id="userSearchFormTrigger">Submit</button>
                </div>
                <div id="user-results">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"><strong>Name</strong></th>
                                <th scope="col"><strong>Email Address</strong></th>
                                <th scope="col"><strong>Actions</strong></th>
                            </tr>
                        </thead>
                        <tbody class="results-holder">

                        </tbody>
                    </table>

                    <div class="loading d-none">
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