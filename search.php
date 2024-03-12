<?php get_header() ?>

<?= do_shortcode('[search]') ?>

<?php get_footer() ?>

<script>
    jQuery(document).ready(function($) {
        ajax();
    });
</script>