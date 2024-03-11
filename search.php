<?php get_header() ?>
<?php
$args = array(
    'post_type' => 'product',
    'meta_query' => array(
        array(
            'key' => '_sku',
            'value' => $_GET['s'],
            'compare' => 'LIKE',
        ),
    ),
);
$query = new WP_Query($args);

?>

<div class="search">
    <ul>
        <?php if ($query->have_posts()) { ?>
            <?php while ($query->have_posts()) { ?>
                <?php $query->the_post(); ?>
                <li>
                    <?php the_title() ?>
                </li>
            <?php  } ?>
        <?php  } else { ?>
            No Result Found
        <?php  } ?>
    </ul>
</div>
<div class="search">
    <ul>
        <?php if (have_posts()) { ?>
            <?php while (have_posts()) { ?>
                <?php the_post(); ?>
                <li>
                    <?php the_title() ?>
                </li>
            <?php  } ?>
        <?php  } else { ?>
            No Result Found
        <?php  } ?>
    </ul>
</div>
<?php get_footer() ?>