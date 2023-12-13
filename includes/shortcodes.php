<?php
function product_category_subcategory()
{
    ob_start();
    $term = get_queried_object();
    $terms = get_terms(array(
        'taxonomy' => 'product_cat',
        'parent'   => $term->term_id
    ));
    echo $term->term_id;
    echo 'sdsdsds';
    foreach ($terms as $subcat) { ?>

        <?php }

    return ob_get_clean();
}

add_shortcode('product_category_subcategory', 'product_category_subcategory');
