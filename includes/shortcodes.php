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
    foreach ($terms as $subcat) {
        echo 'sdsdsds';
        echo  do_shortcode("[hfe_template id='5407']");
?>

        <?php
    }

    return ob_get_clean();
}

add_shortcode('product_category_subcategory', 'product_category_subcategory');


function term_name($term_id, $taxonomy = 'product_cat')
{
    $term = get_term_by('id', $term_id, $taxonomy);

    return $term->name;
}

add_shortcode('term_name', 'term_name');
