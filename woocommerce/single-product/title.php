<?php

/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

the_title('<h1 class="product_title entry-title">', '</h1>');

global $product;

$sku = $product->get_sku();
$gtin = get_post_meta('_wpm_gtin_code');
echo '<div class="product-meta">';
if ($sku) {
	echo '<p class="sku-meta"><strong>SKU: </strong><span class="sku-val">' . $sku . '</span></p>';
}

if(current_user_can('administrator')) {
	echo '<pre>';
	var_dump(get_post_meta(11091));
	echo '</pre>';
}

if($gtin) {
	echo '<p class="gtin-meta"><strong>GTIN: </strong><span class="gtin-val">' . $gtin . '</span></p>';
}
echo '</div>';