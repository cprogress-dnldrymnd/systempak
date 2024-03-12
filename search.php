<?php get_header() ?>


<div class="search-section">
    <form>
        <div class="search-by">

            <div class="search-by-wrapper">
                <input type="radio" id="searchby_product" name="post_type" value="product" checked>
                <label for="searchby_product">
                    Product
                </label>
            </div>

            <div class="search-by-wrapper">
                <input type="radio" id="searchby_blog" name="post_type" value="post">
                <label for="searchby_blog">
                    Blog
                </label>
            </div>
            <div class="search-by-wrapper">
                <input type="radio" id="searchby_page" name="post_type" value="page">
                <label for="searchby_page">
                    Page
                </label>
            </div>
        </div>
        <input type="text" name="s" value="<?= isset($_GET['s']) ? $_GET['s'] : '' ?>" placeholder="Please type what you are looking for.." id="search-input">
    </form>

    <div id="results" page="1">
        <div class="results-holder">

        </div>
        <div id="loadmore-holder" class="d-none">
            <button id="load-more"><span>Load More</span></button>
        </div>
    </div>
</div>

<?php get_footer() ?>

<script>
    jQuery(document).ready(function($) {
        ajax();
    });
</script>