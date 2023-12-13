<?php
function product_category_subcategory()
{
    ob_start();
    $current = get_queried_object();
    $terms = get_terms(array(
        'taxonomy' => 'product_cat',
        'parent'   => $current->term_id
    ));

?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <div class="product-category-slider">
        <div class="swiper mySwiper-ProductCategory">
            <div class="swiper-wrapper">
                <?php foreach ($terms as $term) { ?>
                    <?php
                    $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                    ?>
                    <div class="swiper-slide">
                        <div class="term-name">
                            <h4><?= $term->name ?></h4>
                        </div>
                        <div class="product-counts">
                            <span>4 Products</span>
                        </div>
                        <div class="image-box">
                            <img src="<?= wp_get_attachment_url($thumbnail_id, 'large') ?>" alt="<?= $term->name ?>">
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>


    <script>
        var mySwiperProductCategory = new Swiper(".mySwiper-ProductCategory", {
            loop: true,
            speed: 3000,
            autoplay: {
                delay: 0,
                disableOnInteraction: false
            },
            breakpoints: {
                0: {
                    slidesPerView: 2,
                },

                992: {
                    slidesPerView: 3,
                },


                1200: {
                    slidesPerView: 4,
                },

            },
            pagination: {
                el: ".swiper-pagination",
                dynamicBullets: true,
                clickable: true
            },

        });
    </script>
<?php
    return ob_get_clean();
}

add_shortcode('product_category_subcategory', 'product_category_subcategory');
