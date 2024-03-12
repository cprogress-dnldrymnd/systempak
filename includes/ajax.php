<?php
add_action('wp_ajax_nopriv_search_ajax', 'search_ajax'); // for not logged in users
add_action('wp_ajax_search_ajax', 'search_ajax');
function search_ajax()
{
    $posts_per_page_val = $_POST['posts_per_page'];
    $s = $_POST['s'];
    $page = $_POST['page'];
    $post_type = $_POST['post_type'];
    $posts_per_page = $posts_per_page_val ? $posts_per_page_val : get_option('posts_per_page');
    $offset = $_POST['offset'];
    if ($offset) {
        $args['offset'] = $offset;
    }
    $args = array();

    $args['posts_per_page'] = $posts_per_page;

    $args['post_type'] = $post_type;


    $the_query_args = new WP_Query($args);

    $found_posts = $the_query_args->found_posts;
    $post_count = $the_query_args->post_count;


    $args = array();

    $args['posts_per_page'] = $posts_per_page;

    $args['post_type'] = $post_type;

    if (!$found_posts && $post_type == 'product' && $s != '') {
        $args['meta_query'] = array(
            array(
                'key' => '_sku',
                'value' => 'XSDS323',
                'compare' => 'LIKE',
            ),
        );
    } else {
        $args['s'] = $s;
    }


    $the_query = new WP_Query($args);

    echo '<pre>';
    var_dump($args);
    echo '</pre>';
    if ($page == 1) {
        $post_count_val = $post_count;
    } else {
        $post_count_val = ($page - 1) * $posts_per_page + $post_count;
    }
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

    <div class="pagination justify-content-center align-items-center">
        <?php
        echo paginate_links(array(
            'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'total'        => $the_query->max_num_pages,
            'current'      => max(1, $page),
            'format'       => '?paged=%#%',
            'show_all'     => false,
            'type'         => 'plain',
            'end_size'     => 3,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => sprintf('<i></i> %1$s', __('< Previous', 'text-domain')),
            'next_text'    => sprintf('%1$s <i></i>', __('Next >', 'text-domain')),
            'add_args'     => false,
            'add_fragment' => '',
        ));
        ?>
    </div>
    <script>
        jQuery(document).ready(function() {
            jQuery('.total-post').text('<?= $found_posts ?>');
            jQuery('.result-post').text('<?= $post_count_val ?>');
        });
    </script>

<?php

    die();
}
