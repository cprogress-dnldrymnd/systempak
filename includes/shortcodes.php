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
    <div class="search-section search-section-products mb-5">
        <form>
            <input class="w-100" type="text" name="s" value="<?= isset($_GET['s']) ? $_GET['s'] : '' ?>" placeholder="Search products" id="search-input-product">
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

add_shortcode('search_products', 'search_products');


function add_to_cart_form_shortcode($atts)
{
    if (empty($atts)) {
        return '';
    }

    if (!isset($atts['id']) && !isset($atts['sku'])) {
        return '';
    }

    $args = array(
        'posts_per_page'      => 1,
        'post_type'           => 'product',
        'post_status'         => 'publish',
        'ignore_sticky_posts' => 1,
        'no_found_rows'       => 1,
    );

    if (isset($atts['sku'])) {
        $args['meta_query'][] = array(
            'key'     => '_sku',
            'value'   => sanitize_text_field($atts['sku']),
            'compare' => '=',
        );

        $args['post_type'] = array('product', 'product_variation');
    }

    if (isset($atts['id'])) {
        $args['p'] = absint($atts['id']);
    }

    $single_product = new WP_Query($args);

    $preselected_id = '0';


    if (isset($atts['sku']) && $single_product->have_posts() && 'product_variation' === $single_product->post->post_type) {

        $variation = new WC_Product_Variation($single_product->post->ID);
        $attributes = $variation->get_attributes();


        $preselected_id = $single_product->post->ID;


        $args = array(
            'posts_per_page'      => 1,
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'no_found_rows'       => 1,
            'p'                   => $single_product->post->post_parent,
        );

        $single_product = new WP_Query($args);
    ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                var $variations_form = $('[data-product-page-preselected-id="<?php echo esc_attr($preselected_id); ?>"]').find('form.variations_form');
                <?php foreach ($attributes as $attr => $value) { ?>
                    $variations_form.find('select[name="<?php echo esc_attr($attr); ?>"]').val('<?php echo esc_js($value); ?>');
                <?php } ?>
            });
        </script>
    <?php
    }

    $single_product->is_single = true;
    ob_start();
    global $wp_query;

    $previous_wp_query = $wp_query;

    $wp_query = $single_product;

    wp_enqueue_script('wc-single-product');
    while ($single_product->have_posts()) {
        $single_product->the_post()
    ?>
        <div class="single-product" data-product-page-preselected-id="<?php echo esc_attr($preselected_id); ?>">
            <?php woocommerce_template_single_add_to_cart(); ?>
        </div>
<?php
    }

    $wp_query = $previous_wp_query;

    wp_reset_postdata();
    return '<div class="woocommerce">' . ob_get_clean() . '</div>';
}
add_shortcode('add_to_cart_form', 'add_to_cart_form_shortcode');
