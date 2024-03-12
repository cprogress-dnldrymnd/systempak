<?php
add_action('wp_ajax_nopriv_search_ajax', 'search_ajax'); // for not logged in users
add_action('wp_ajax_search_ajax', 'search_ajax');
function search_ajax()
{
    $posts_per_page_val = 10;
    $s = $_POST['s'];
    $page = $_POST['page'];
    $posts_per_page = $posts_per_page_val ? $posts_per_page_val : get_option('posts_per_page');
    $args = array();

    if ($s) {
        $args['s'] = $s;
    }
    $args['post_type'] = array('product');
    $the_query = new WP_Query($args);

    $found_posts = $the_query->found_posts;
    $post_count = $the_query->post_count;


    if ($page == 1) {
        $post_count_val = $post_count;
    } else {
        $post_count_val = ($page - 1) * $posts_per_page + $post_count;
    }
?>
    <div class="row gy-3 product-holder product-grid post-box-PostSlider">
        <?php
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
        ?>
                <div class="post-item">
                    <div class="row">
                        <div class="col-image">
                            <img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'medium')  ?>" alt="<?php the_title() ?>">
                        </div>
                        <div class="col-content">
                            <h2><?php the_title() ?></h2>
                            <div class="excerpt">
                                <?php the_excerpt() ?>
                            </div>
                            <div class="button-box">
                                <a href="<?php the_permalink() ?>"> Read More </a>
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
