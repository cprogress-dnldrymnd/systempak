<?php
function product_category_subcategory()
{
    ob_start();
    $current = get_queried_object();
    $terms = get_terms(array(
        'taxonomy' => 'product_cat',
        'parent'   => $current->term_id
    ));

?>
    <div class="product-category-slider">
        <div class="swiper mySwiper-ProductCategory">
            <div class="swiper-wrapper">
                <?php foreach ($terms as $term) { ?>
                    <?php
                    $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                    ?>
                    <div class="swiper-slide">
                        <a href="<?= get_term_link($term->term_id) ?>"></a>
                        <div class="term-name">
                            <h4><?= $term->name ?></h4>
                        </div>
                        <div class="product-counts">
                            <span>4 Products</span>
                        </div>
                        <div class="image-box">
                            <img src="<?= wp_get_attachment_url($thumbnail_id, 'large') ?>" alt="<?= $term->name ?>">
                        </div>
                        <div class="circle-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </div>
                    </div>

                <?php } ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
<?php
    return ob_get_clean();
}

add_shortcode('product_category_subcategory', 'product_category_subcategory');


function term_name()
{
    return '<h1> ' . get_queried_object()->name . ' </h1>';
}

add_shortcode('term_name', 'term_name');




function term_description_sc()
{
    return get_queried_object()->description;
}

add_shortcode('term_description', 'term_description_sc');


function custom_breadcrumbs()
{

    if (is_singular()) {
        $title = get_the_title();
    } else if (is_tax()) {
        $title = get_queried_object()->name;
    }
    return '<a href="' . get_site_url() . '">Home</a> / ' . $title;
}

add_shortcode('custom_breadcrumbs', 'custom_breadcrumbs');

function breadcrumbs()
{
    $html = '<div class="breadcrumbs-holder">';
    $html .= '<ul>';
    $html .= '<li><a href="' . get_site_url() . '">Home</a></li>';

    if (is_post_type_archive()) {
        $html .= '<li><span>' . get_the_archive_title() . '</span></li>';
    }

    if (is_single()) {
        $post_type_obj = get_post_type_object(get_post_type());
        $post_type = $post_type_obj->labels->name; //Ice Creams.
        $html .= '<li><a href="' . get_post_type_archive_link(get_post_type())  . '">' . $post_type . '</a></li>';
        $html .= '<li><span>' . get_the_title() . '</span></li>';
    }

    if (is_page()) {
        $html .= '<li><span>' . get_the_title() . '</span></li>';
    }


    $html .= '</ul>';
    $html .= '</div>';
    return $html;
}

add_shortcode('breadcrumbs', 'breadcrumbs');


function search()
{
    ob_start();
?>
    <div class="search-section search-section-default">
        <form>
            <div class="search-by">

                <div class="search-by-wrapper">
                    <input type="radio" id="searchby_product" name="post_type" value="product" checked>
                    <label for="searchby_product">
                        Product
                    </label>
                </div>

                <div class="search-by-wrapper">
                    <input type="radio" id="searchby_blog" name="post_type" value="post">
                    <label for="searchby_blog">
                        Blog
                    </label>
                </div>
                <div class="search-by-wrapper">
                    <input type="radio" id="searchby_page" name="post_type" value="page">
                    <label for="searchby_page">
                        Page
                    </label>
                </div>
            </div>
            <input type="text" name="s" value="<?= isset($_GET['s']) ? $_GET['s'] : '' ?>" placeholder="Please type what you are looking for.." id="search-input">
        </form>

        <div id="results" page="1">
            <div class="results-holder">

            </div>
            <div id="loadmore-holder" class="d-none">
                <button id="load-more"><span>Load More</span></button>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}

add_shortcode('search', 'search');


function search_products()
{
    ob_start();
?>
    <div class="select-products">
        <h3>Add Products</h3>
        <div class="search-section search-section-products">
            <form>
                <input class="w-100 mb-3" type="text" name="s" value="<?= isset($_GET['s']) ? $_GET['s'] : '' ?>" placeholder="Search products" id="search-input-product">
            </form>
            <div id="results" page="1">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="results-holder">

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="selected-products d-none" id="selected-products">
                            <div class="post-item-holder">

                            </div>
                            <a id="add-to-order" class="d-inline-block button mt-4 w-100 text-center">
                                <span>Add to order</span>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}

add_shortcode('search_products', 'search_products');


function add_to_cart_form_shortcode($atts)
{
    ob_start();

    $args = array(
        'posts_per_page'      => 1,
        'post_type'           => 'product',
        'post_status'         => 'publish',
        'ignore_sticky_posts' => 1,
        'no_found_rows'       => 1,
    );

    if (isset($atts['id'])) {
        $args['p'] = absint($atts['id']);
    }

    $single_product = new WP_Query($args);

    wp_enqueue_script('wc-single-product');
    while ($single_product->have_posts()) {
        $single_product->the_post();
        echo '<div class="single-product">';
        woocommerce_template_single_add_to_cart();
        echo '</div>';
    }

    wp_reset_postdata();

    return ob_get_clean();
}
add_shortcode('add_to_cart_form', 'add_to_cart_form_shortcode');


function woocommerce_checkout_custom()
{
    ob_start();
    $args = array(
        'role' => array('customer')
    );
    $users = get_users($args);
?>
    <?php if (current_user_can('administrator')) { ?>
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
        <style>
            .entry-content .woocommerce {
                display: none !important;
            }
        </style>
    <?php } else { ?>
        <?php if (is_user_logged_in()) { ?>

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
        <?php } ?>
    <?php } ?>
<?php
    return ob_get_clean();
}

add_shortcode('woocommerce_checkout_custom', 'woocommerce_checkout_custom');




function product_category_features() {
    $term = get_queried_object();


}

add_shortcode('product_category_features', 'product_category_features');