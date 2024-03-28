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
        <form action="/" method="GET">
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


function category_image()
{
    $term = get_queried_object();
    $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
    $image = wp_get_attachment_url($thumbnail_id);

    // print the IMG HTML
    return  "<img src='{$image}' alt='{$term->name}' class='category-image' />";
}
add_shortcode('category_image', 'category_image');

function product_category_features()
{
    ob_start();
    $term = get_queried_object();
    $parent = $term->parent;
    $hide_featured_section = carbon_get_term_meta($term->term_id, 'hide_featured_section');


    if (!$parent) {
        $term_id = $term->term_id;
        $featured_section_left = carbon_get_term_meta($term->term_id, 'featured_section');
        $featured_section_right = carbon_get_term_meta($term->term_id, 'featured_section_right');
    } else {
        $term_id = $parent;
        $featured_section_left = carbon_get_term_meta($term->term_id, 'featured_section');
        $featured_section_right = carbon_get_term_meta($term->term_id, 'featured_section_right');
        if ($featured_section_left || $featured_section_right) {
            $featured_section_left = carbon_get_term_meta($term->term_id, 'featured_section');
            $featured_section_right = carbon_get_term_meta($term->term_id, 'featured_section_right');
        } else {
            $featured_section_left = carbon_get_term_meta($term_id, 'featured_section');
            $featured_section_right = carbon_get_term_meta($term_id, 'featured_section_right');
        }
    }


    if (!$hide_featured_section) {
        if ($featured_section_left || $featured_section_right) {
            $thumbnail_id = get_term_meta($term_id, 'thumbnail_id', true);
            $image = wp_get_attachment_url($thumbnail_id);

            if ($thumbnail_id) {
                $class = '';
                $class2 = 'col-lg-4';
            } else {
                $class2 = 'col-lg-6';
                $class = 'no-image';
            }
    ?>
            <div class="featured-section <?= $class ?>">
                <div class="row">
                    <div class="<?= $class2 ?>">
                        <?php foreach ($featured_section_left as $featured_section) { ?>
                            <div class="icon-box d-flex">
                                <div class="icon">
                                    <img src="<?= wp_get_attachment_image_url($featured_section['image'], 'medium') ?>" alt="<?= $featured_section['heading'] ?>">
                                </div>
                                <div class="content">
                                    <h3><?= $featured_section['heading'] ?></h3>
                                    <?= wpautop($featured_section['description']) ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($thumbnail_id) { ?>
                        <div class="col-lg-4">
                            <div class="category-image">
                                <img src="<?= $image ?>" alt="<?= $term->name ?>">
                            </div>
                        </div>
                    <?php } ?>
                    <div class="<?= $class2 ?>">
                        <?php foreach ($featured_section_right as $featured_section) { ?>
                            <div class="icon-box d-flex">
                                <div class="icon">
                                    <img src="<?= wp_get_attachment_image_url($featured_section['image'], 'medium') ?>" alt="<?= $featured_section['heading'] ?>">
                                </div>
                                <div class="content">
                                    <h3><?= $featured_section['heading'] ?></h3>
                                    <?= wpautop($featured_section['description']) ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    return ob_get_clean();
}

add_shortcode('product_category_features', 'product_category_features');


function phone_orders_header()
{
    ob_start();
    ?>
    <section class="logged-in-as mb-5">
        <?php
        $current_user = wp_get_current_user();
        ?>
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 me-2">Logged-in as <?= $current_user->user_email ?></h5>
                    <a class="button d-inline-block me-2" href="/my-account/orders/">View Orders</a>

                    <?php if (!is_page(8978)) { ?>
                        <a class="button" href="<?= get_permalink(8978) ?>">
                            Create Order
                        </a>
                    <?php } ?>
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
<?php
    return ob_get_clean();
}

add_shortcode('phone_orders_header', 'phone_orders_header');


function faqs()
{
    ob_start();
    $args = array(
        'numberposts' => -1,
        'post_type'   => 'faq'
    );

    $faqs = get_posts($args);

    $terms = get_terms(array(
        'taxonomy'   => 'faq_cat',
        'hide_empty' => false,
    ));
?>

    <div class="faqs-tabs">
        <ul>
            <li><button target="all"> Show All</button></li>
            <?php foreach ($terms as $term) { ?>
                <li>
                    <button target="<?= $term->slug ?>"><?= $term->name ?></button>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="faqs-holder">
        <div class="elementor-element elementor-element-563633e elementor-widget elementor-widget-n-accordion" data-id="563633e" data-element_type="widget" data-settings="{&quot;default_state&quot;:&quot;all_collapsed&quot;,&quot;max_items_expended&quot;:&quot;one&quot;,&quot;n_accordion_animation_duration&quot;:{&quot;unit&quot;:&quot;ms&quot;,&quot;size&quot;:400,&quot;sizes&quot;:[]}}" data-widget_type="nested-accordion.default">
            <div class="elementor-widget-container">
                <div class="e-n-accordion">
                    <?php foreach ($faqs as $faq) { ?>

                        <?php
                        $cats = get_the_terms($faq->ID, 'faq_cat');
                        $class = '';
                        foreach ($cats as $cat) {
                            $class .= $cat->slug . ' ';
                        }
                        ?>
                        <details id="e-n-accordion-item-<?= $faq->ID ?>" class="e-n-accordion-item <?= $class ?>">
                            <summary class="e-n-accordion-item-title" data-accordion-index="1" tabindex="0" aria-expanded="false" aria-controls="e-n-accordion-item-<?= $faq->ID ?>">
                                <span class="e-n-accordion-item-title-header">
                                    <div class="e-n-accordion-item-title-text"> <?= $faq->post_title ?> </div>
                                </span>
                                <span class="e-n-accordion-item-title-icon">
                                    <span class="e-opened"><svg aria-hidden="true" class="e-font-icon-svg e-fas-minus" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M416 208H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h384c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z">
                                            </path>
                                        </svg></span>
                                    <span class="e-closed"><svg aria-hidden="true" class="e-font-icon-svg e-fas-plus" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z">
                                            </path>
                                        </svg></span>
                                </span>

                            </summary>
                            <div role="region" aria-labelledby="e-n-accordion-item-<?= $faq->ID ?>" class="elementor-element elementor-element-1ccc9dd e-con-full e-flex e-con e-child" data-id="1ccc9dd" data-element_type="container">
                                <div class="elementor-element elementor-element-2cb1db1 elementor-widget elementor-widget-text-editor" data-id="2cb1db1" data-element_type="widget" data-widget_type="text-editor.default">
                                    <div class="elementor-widget-container">
                                        <?= wpautop($faq->post_content) ?>
                                    </div>
                                </div>
                            </div>
                        </details>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        jQUery(document).ready(function() {
            jQUery('.faqs-tabs button').click(function(e) {
                $target = jQuery(this).attr('target');
                if ($target == 'all') {
                    jQuery('.faqs-holder .e-n-accordion-item').removeClass('d-none');
                } else {
                    jQuery('.faqs-holder ..e-n-accordion-item:not(.' + $target + ')').addClass('d-none');
                }
                e.preventDefault();
            });
        });
    </script>
<?php
    return ob_get_clean();
}

add_shortcode('faqs', 'faqs');
