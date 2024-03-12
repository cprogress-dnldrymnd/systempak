<?php get_header() ?>


<div class="search-section">
    <form>
        <div class="search-by">
            <div class="search-by-wrapper">
                <input type="checkbox" id="searchby_sku">
                <label for="searchby_sku">
                    Search by SKU
                </label>
            </div>
            <div class="search-by-wrapper">
                <input type="checkbox" id="searchby_product">
                <label for="searchby_product">
                    Products
                </label>
            </div>
            <div class="search-by-wrapper">
                <input type="checkbox" id="searchby_blog">
                <label for="searchby_blog">
                    Blog
                </label>
            </div>
            <div class="search-by-wrapper">
                <input type="checkbox" id="searchby_page">
                <label for="searchby_page">
                    Blog
                </label>
            </div>
        </div>
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