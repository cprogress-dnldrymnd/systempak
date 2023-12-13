<?php
function product_category_subcategory()
{
    ob_start();
    $term = get_queried_object();
    $terms = get_terms(array(
        'taxonomy' => 'product_cat',
        'parent'   => $term->term_id
    ));

    foreach ($terms as $term) {
        do_shortcode("[hfe_template id='5407']");
?>

        <?php
    }

    return ob_get_clean();
}

add_shortcode('product_category_subcategory', 'product_category_subcategory');


function term_name($term_id, $taxonomy = 'product_cat')
{
    $term = get_term_by('id', $term_id, 'product_cat');

    return $term->name;
}

add_shortcode('term_name', 'term_name');
