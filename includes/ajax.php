<?php
add_action('wp_ajax_nopriv_search_ajax', 'search_ajax'); // for not logged in users
add_action('wp_ajax_search_ajax', 'search_ajax');
function search_ajax()
{
    $posts_per_page_val = $_POST['posts_per_page'];
    $s = $_POST['s'];
    $post_type = $_POST['post_type'];
    $posts_per_page = $posts_per_page_val ? $posts_per_page_val : get_option('posts_per_page');
    $offset = $_POST['offset'];
    $args = array();


    if ($offset) {
        $args['offset'] = $offset;
    }
    if ($s) {
        $args['s'] = $s;
    }

    $args['posts_per_page'] = $posts_per_page;

    $args['post_type'] = $post_type;


    $the_query_args = new WP_Query($args);

    $found_posts = $the_query_args->found_posts;


    if (!$found_posts && $post_type == 'product' && $s != '') {
        $args['meta_query'] = array(
            array(
                'key' => '_sku',
                'value' => $s,
                'compare' => 'LIKE',
            ),
        );
        unset($args['s']);
    }

    $the_query = new WP_Query($args);


    $count = $the_query->found_posts;
    echo hide_load_more($count, $offset, $posts_per_page);

?>
    <div class="post-item-holder">
        <?php
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
        ?>
                <div class="post-item">
                    <div class="row">
                        <?php
                        if (get_the_post_thumbnail_url(get_the_ID())) {
                            $url = get_the_post_thumbnail_url(get_the_ID());
                        } else {
                            $url = wc_placeholder_img_src();
                        }
                        ?>
                        <div class="col-image">
                            <img src="<?= $url  ?>" alt="<?php the_title() ?>">
                        </div>
                        <div class="col-content">
                            <h2><?php the_title() ?></h2>
                            <div class="excerpt">
                                <?php the_excerpt() ?>
                            </div>
                            <div class="more-link-wrap">
                                <a class="more-link" href="<?php the_permalink() ?>">View <?= get_post_type() ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        } else {
            ?>
            <h2>No Results Found</h2>
        <?php
        }
        wp_reset_postdata();
        ?>
    </div>

<?php

    die();
}
function hide_load_more($count, $offset, $posts_per_page)
{
    ob_start();
?>
    <script>
        jQuery(document).ready(function() {
            <?php if ($count == ($offset + $posts_per_page) || $count < ($offset + $posts_per_page) || $count < $posts_per_page + 1) { ?>
                jQuery('#loadmore-holder').addClass('d-none');
            <?php } else { ?>
                jQuery('#loadmore-holder').removeClass('d-none');
            <?php } ?>
        });
    </script>
<?php
    return ob_get_clean();
}

function get_cart_product_ids()
{
    $product_ids = [];
    foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
        $product_ids[] = $_product->get_id();
    }

    return $product_ids;
}

add_action('wp_ajax_nopriv_search_ajax_products', 'search_ajax_products'); // for not logged in users
add_action('wp_ajax_search_ajax_products', 'search_ajax_products');
function search_ajax_products()
{
    $posts_per_page_val = 5;
    $s = $_POST['s'];
    $post_type = array('product', 'product_variation');
    $posts_per_page = $posts_per_page_val ? $posts_per_page_val : get_option('posts_per_page');
    $offset = $_POST['offset'];
    $args = array();


    if ($offset) {
        $args['offset'] = $offset;
    }
    if ($s) {
        $args['s'] = $s;
    }

    $args['posts_per_page'] = $posts_per_page;

    $args['post_type'] = $post_type;

    $args['post_status'] = array('publish');







    $the_query_args = new WP_Query($args);

    $args['tax_query'] = array(
        array(
            'taxonomy' => 'product_type',
            'field'    => 'slug',
            'terms'    => array('variable'),
            'operator' => 'NOT IN'
        ),
    );

    $found_posts = $the_query_args->found_posts;

    if (!$found_posts  && $s != '') {
        $args['meta_query'] = array(
            array(
                'key' => '_sku',
                'value' => $s,
                'compare' => 'LIKE',
            ),
        );
        unset($args['s']);
    }




    $the_query = new WP_Query($args);

    $count = $the_query->found_posts;
    echo hide_load_more($count, $offset, $posts_per_page);

?>
<?php var_dump(get_cart_product_ids()) ?>
    <div class="post-item-holder">
        <?php
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
                global $product;

        ?>
                <div class="post-item post-<?= get_the_ID() ?>" product-id="<?= get_the_ID() ?>">
                    <div class="row">
                        <?php
                        if ($product->get_type() == ' simple') {
                            if (get_the_post_thumbnail_url(get_the_ID())) {
                                $url = get_the_post_thumbnail_url(get_the_ID());
                            } else {
                                $url = wc_placeholder_img_src();
                            }
                        } else {
                            if (wp_get_attachment_image_url($product->get_image_id())) {
                                $url = wp_get_attachment_image_url($product->get_image_id());
                            } else {
                                if (get_the_post_thumbnail_url(get_the_ID())) {
                                    $url = get_the_post_thumbnail_url(get_the_ID());
                                } else {
                                    $url = wc_placeholder_img_src();
                                }
                            }
                        }
                        ?>
                        <div class="col-image col-auto">
                            <img src="<?= $url  ?>" alt="<?php the_title() ?>">
                        </div>
                        <div class="col-content d-flex align-items-center justify-content-between col">
                            <div>
                                <p><strong><?php the_title() ?></strong></p>
                                <p><strong>SKU: </strong> <?= $product->get_sku() ?> </p>
                            </div>

                            <button type="button" class="button product-add-to-basket" product-id="<?= get_the_ID() ?>">
                                Add to basket
                            </button>
                        </div>
                    </div>
                </div>
            <?php }
        } else {
            ?>
            <h2>No Results Found</h2>
        <?php
        }
        wp_reset_postdata();
        ?>
    </div>

<?php

    die();
}


add_action('wp_ajax_nopriv_select_product_ajax', 'select_product_ajax'); // for not logged in users
add_action('wp_ajax_select_product_ajax', 'select_product_ajax');
function select_product_ajax()
{
    $product_ids = $_POST['product_ids'];
    global $woocommerce;

    foreach ($product_ids as $product_id) {
        $woocommerce->cart->add_to_cart($product_id);
    }

    die();
}
