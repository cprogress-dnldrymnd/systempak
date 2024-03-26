<?php
define('theme_dir', get_stylesheet_directory_uri() . '/');
define('assets_dir', theme_dir . 'assets/');
define('image_dir', assets_dir . 'images/');
define('vendor_dir', assets_dir . 'vendors/');

add_action('wp_enqueue_scripts', 'priotech_child_enqueue_styles');
function priotech_child_enqueue_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css', NULL, 2.6);
	if (is_product_category()) {
		wp_enqueue_style('systempak-swiper', vendor_dir . 'swiper/swiper-bundle.min.css');
		wp_enqueue_script('systempak-swiper', vendor_dir . 'swiper/swiper-bundle.min.js');
	}

	if (is_page(8978)) {
		wp_enqueue_style('systempak-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
		wp_enqueue_script('systempak-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js');
		wp_enqueue_script('systempak-checkout', assets_dir . 'javascripts/checkout-phone-orders.js', array('jquery'), 3.7);
		wp_enqueue_style('systempak-checkout', assets_dir . 'stylesheets/checkout/checkout.css');

	}

	wp_enqueue_script('systempak-main', assets_dir . 'javascripts/main.js', array('jquery'), 2.4);
}

/*-----------------------------------------------------------------------------------*/
/* Register Carbofields
/*-----------------------------------------------------------------------------------*/
add_action('carbon_fields_register_fields', 'tissue_paper_register_custom_fields');
function tissue_paper_register_custom_fields()
{
	require_once('includes/post-meta.php');
}

require_once('includes/shortcodes.php');
require_once('includes/woocommerce.php');
require_once('includes/ajax.php');
require_once('includes/checkout-phone-orders.php');


function action_wp_footer()
{
	if (is_product_category()) {
?>

		<script>
			var mySwiperProductCategory = new Swiper(".mySwiper-ProductCategory", {
				loop: true,
				speed: 3000,
				autoplay: true,
				spaceBetween: 30,
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
					clickable: true
				},

			});
		</script>

<?php
	}
}

add_action('wp_footer', 'action_wp_footer');

add_filter('get_the_archive_title', function ($title) {
	if (is_category()) {
		$title = single_cat_title('', false);
	} elseif (is_tag()) {
		$title = single_tag_title('', false);
	} elseif (is_author()) {
		$title = '<span class="vcard">' . get_the_author() . '</span>';
	} elseif (is_tax()) { //for custom post types
		$title = sprintf(__('%1$s'), single_term_title('', false));
	} elseif (is_post_type_archive()) {
		$title = post_type_archive_title('', false);
	}
	return $title;
});
