<?php
function _get_the_excerpt($post_id) {
    global $post;  
    $save_post = $post;
    $post = get_post($post_id);
    $output = get_the_excerpt();
    $post = $save_post;
    return $output;
  }
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

    $args['post_status'] = array('publish');

    $args['posts_per_page'] = $posts_per_page;

    if ($post_type == 'product') {
        $args['post_type'] = array('product', 'product_variation');
    } else {
        $args['post_type'] = $post_type;
    }


    $args['tax_query'] = array(
        array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'exclude-from-catalog',
            'operator' => 'NOT IN',
        ),
    );

    $the_query_args = new WP_Query($args);


    $post_ids = array();
    if ($the_query_args->have_posts()) {
        while ($the_query_args->have_posts()) {
            $the_query_args->the_post();
            $post_ids[] = get_the_ID();
        }
        wp_reset_postdata();
    }

    // $found_posts = $the_query_args->found_posts;


    $args['meta_query'] = array(
        array(
            'key' => '_sku',
            'value' => $s,
            'compare' => 'LIKE',
        ),
    );
    unset($args['s']);

    $args['post__not_in'] = $post_ids;

    $the_query = new WP_Query($args);


    if ($the_query->have_posts() && $post_type == 'product' && $s != '') {
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $post_ids[] = get_the_ID();
        }
        wp_reset_postdata();
    }


    $count = count($post_ids);
    echo hide_load_more($count, $offset, $posts_per_page);

?>
    <div class="post-item-holder">
        <?php
        if ($post_ids) {
            foreach ($post_ids as $post_id) {

                if (get_post_type($post_id) == 'product_variation') {
                    $variation = wc_get_product($post_id);
                    $permalink = get_the_permalink($variation->get_parent_id());
                    $button_text = 'Product';
                } else {
                    $permalink = get_the_permalink($post_id);
                    $button_text = get_post_type($post_id);
                }
        ?>
                <div class="post-item">
                    <div class="row">
                        <?php
                        if (get_the_post_thumbnail_url($post_id)) {
                            $url = get_the_post_thumbnail_url($post_id);
                        } else {
                            $url = wc_placeholder_img_src();
                        }
                        ?>
                        <div class="col-image">
                            <img src="<?= $url  ?>" alt="<?= get_the_title($post_id) ?>">
                        </div>
                        <div class="col-content">
                            <h2><?php get_the_title($post_id) ?></h2>
                            <div class="excerpt">
                                <?php get_the_excerpt($post_id) ?>
                            </div>
                            <div class="more-link-wrap">
                                <a class="more-link" href="<?= $permalink ?>">View <?= $button_text ?></a>
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
