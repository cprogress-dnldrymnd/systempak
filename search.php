<?php get_header() ?>
<?php

?>

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