<?php get_header() ?>

<div class="search">
    <form>
        <input type="text" name="s" placeholder="search" id="search-input">
    </form>

    <div id="results">
        <div class="results-holder">

        </div>
        <div id="pagination">

        </div>
    </div>
</div>

<?php get_footer() ?>

<script>
    jQuery(document).ready(function($) {
        ajax();
    });
</script>