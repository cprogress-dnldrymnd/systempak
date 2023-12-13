<?php
define('theme_dir', get_stylesheet_directory_uri()() . '/');
define('assets_dir', theme_dir . 'assets/');
define('image_dir', assets_dir . 'images/');
define('vendor_dir', assets_dir . 'vendors/');

add_action('wp_enqueue_scripts', 'priotech_child_enqueue_styles');
function priotech_child_enqueue_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	if (is_product_category()) {
		wp_enqueue_style('systempak-swiper-css', vendor_dir . 'swiper/swiper-bundle.min.css');
		wp_enqueue_script('systempak-swiper-js', vendor_dir . 'swiper/swiper-bundle.min.js');
	}
}
require_once('includes/shortcodes.php');
require_once('includes/woocommerce.php');


function action_wp_footer()
{
?>

	<script>
		var mySwiperProductCategory = new Swiper(".mySwiper-ProductCategory", {
			loop: true,
			speed: 3000,
			autoplay: true,
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
}

add_action('wp_footer', 'action_wp_footer');
