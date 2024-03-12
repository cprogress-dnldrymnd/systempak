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
    $post_count = $the_query_args->post_count;


    if (!$found_posts && $post_type == 'product' && $s != '') {
        $args['meta_query'] = array(
            array(
                'key' => '_sku',
                'value' => 'XSDS323',
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

                        <?php if (get_the_post_thumbnail_url(get_the_ID())) { ?>
                            <div class="col-image">
                                <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'medium')  ?>" alt="<?php the_title() ?>">
                            </div>
                        <?php } ?>
                        <div class="col-content">
                            <h2><?php the_title() ?></h2>
                            <div class="excerpt">
                                <?php the_excerpt() ?>
                            </div>
                            <div class="more-link-wrap">
                                <a class="more-link" href="<?php the_permalink() ?>">View Product</a>
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


    <!--
    <script>
        jQuery(document).ready(function() {
            jQuery('.total-post').text('<?= $found_posts ?>');
            jQuery('.result-post').text('<?= $post_count_val ?>');
        });
    </script>

    -->

<?php

    die();
}
function hide_load_more($count, $offset, $posts_per_page)
{
    if ($count == ($offset + $posts_per_page) || $count < ($offset + $posts_per_page) || $count < $posts_per_page + 1) {
        return '<style>#loadmore-holder {display: none} </style>';
    }
}
