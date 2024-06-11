<?php
define('theme_dir', get_stylesheet_directory_uri() . '/');
define('assets_dir', theme_dir . 'assets/');
define('image_dir', assets_dir . 'images/');
define('vendor_dir', assets_dir . 'vendors/');
define('checkout_version', 10);
add_action('after_setup_theme', 'add_wc_gallery_lightbox', 100);

function add_wc_gallery_lightbox()
{
	add_theme_support('wc-product-gallery-lightbox');
}
add_action('wp_enqueue_scripts', 'priotech_child_enqueue_styles');
function priotech_child_enqueue_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css', NULL, 9);
	if (is_product_category()) {
		wp_enqueue_style('systempak-swiper', vendor_dir . 'swiper/swiper-bundle.min.css');
		wp_enqueue_script('systempak-swiper', vendor_dir . 'swiper/swiper-bundle.min.js');
	}
	if (is_page(8978) || is_checkout()) {
		wp_enqueue_style('systempak-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
		wp_enqueue_script('systempak-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js');
		wp_enqueue_style('systempak-checkout', assets_dir . 'stylesheets/checkout/checkout.css', NULL, checkout_version);
	}
	if (is_page(8978)) {

		wp_enqueue_script('systempak-checkout', assets_dir . 'javascripts/checkout-phone-orders.js', array('jquery'), checkout_version);
		// in JavaScript, object properties are accessed as ajax_object.ajax_url
		wp_localize_script(
			'systempak-checkout',
			'ajax_object',
			array(
				'ajax_url' => admin_url('admin-ajax.php')
			)
		);
	}
	wp_enqueue_script('systempak-main', assets_dir . 'javascripts/main.js', array('jquery'), 3.8);

	if (is_product()) {
		$product = wc_get_product(get_the_ID());
		if ($product->get_type() == 'variable') {
			$gtin = array();
			$price_per_unit = array();
			$available_variations = $product->get_available_variations();
			foreach ($available_variations as $key => $value) {
				$product_var = wc_get_product(get_the_ID());
				$gtin_val = get_post_meta($value['variation_id'], '_wpm_gtin_code', true);
				$gtin['p_' . $value['variation_id']] = $gtin_val;

				$pricingRule = \TierPricingTable\PriceManager::getPricingRule($value['variation_id']);

				if (!$pricingRule->getRules()) {
					$quantity_per_box = get_post_meta($value['variation_id'], 'quantity_per_box', true);

					if ($quantity_per_box) {
						$price_num =  wc_get_price_to_display(
							wc_get_product($value['variation_id']),
							array('price' => $product_var->get_price())
						);
						$price_per_unit['p_' . $value['variation_id']] = '£' . round($price_num / $quantity_per_box, 3);
					} else {
						$price_per_unit['p_' . $value['variation_id']] = wp_kses_post(wc_price(wc_get_price_to_display(
							wc_get_product($value['variation_id']),
							array('price' => $product_var->get_price())
						)));
					}
				}
			}

			wp_localize_script('systempak-main', 'gtin', $gtin);
			wp_localize_script('systempak-main', 'price_per_unit', $price_per_unit);
		}
	}

	wp_enqueue_script('systempak-main');

	$old_user = user_switching::get_old_user();
	if($old_user) {
		wp_enqueue_style('admin-bar');
	}

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
require_once('includes/post-types.php');
require_once('includes/checkout-phone-orders.php');


function action_wp_footer()
{
	if (is_product_category()) {
?>

		<script>
			var mySwiperProductCategory = new Swiper(".mySwiper-ProductCategory", {
				loop: true,
				autoplay: true,
				spaceBetween: 30,
				breakpoints: {
					0: {
						slidesPerView: 2,
						spaceBetween: 10,
					},

					992: {
						slidesPerView: 3,
						spaceBetween: 30,
					},

					1024: {
						slidesPerView: 4,
						spaceBetween: 30,
					},


					1200: {
						slidesPerView: 5,
						spaceBetween: 30,
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


add_filter('woocommerce_apply_base_tax_for_local_pickup', '__return_false');
