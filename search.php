<?php get_header() ?>
<?php

?>

<div class="search">
    <ul>
        <?php while (have_posts()) { ?>
            <?php the_post(); ?>
            <li>
                <?php the_title() ?>

            </li>
        <?php  } ?>
    </ul>
</div>
<?php get_footer() ?>