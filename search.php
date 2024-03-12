<?php get_header() ?>


<div class="search-section">
    <form>
        <input type="text" name="s" value="<?= isset($_GET['s']) ? $_GET['s'] : '' ?>" placeholder="Search by product name or product sku" id="search-input">
    </form>

    <div id="results" page="1">
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