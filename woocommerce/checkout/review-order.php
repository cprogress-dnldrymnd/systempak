<?php

/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined('ABSPATH') || exit;
?>

<table class="shop_table woocommerce-checkout-review-order-table">

	<tbody>
		<?php
		do_action('woocommerce_review_order_before_cart_contents');

		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);

			if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key)) {
		?>
				<tr class="<?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?> cart-product-<?= $_product->get_id() ?>">
					<td class="product-name">
						<div class="d-flex align-items-center">
							<div class="product-image">
								<?= $_product->get_image() ?>
							</div>
							<div>
								<div class="name mb-4">
									<?php

									?>
									<span class="name-wrapper"><?php echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key)) . '&nbsp;'; ?></span>
									<div><?php echo 'Price per unit: ' . WC()->cart->get_product_subtotal($_product, 1); ?></div>
								</div>
								<?php echo apply_filters('woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf('&times;&nbsp;%s', $cart_item['quantity']) . '</strong>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
								?>
								<?php echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
								?>
							</div>
						</div>

					</td>
					<td class="product-total">
						<div class="d-flex flex-column justify-content-between align-items-end">
							<?php
							$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
							?>
							<?php
							echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
								'woocommerce_cart_item_remove_link',
								sprintf(
									'<a href="%s" class="remove-item mb-3" aria-label="%s" data-product_id="%s" data-product_sku="%s"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="none"> <path d="M9 1L1 9M9 9L1 1" stroke="#16110E" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" /> </svg></a>',
									esc_url(wc_get_cart_remove_url($cart_item_key)),
									/* translators: %s is the product name */
									esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
									esc_attr($product_id),
									esc_attr($_product->get_sku())
								),
								$cart_item_key
							);
							?>

							<?php
							if (!$cart_item['custom_price']) {
								echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
							} else {
								echo wc_price($cart_item['custom_price'] * $cart_item['quantity']);
							}
							?>
						</div>
					</td>
				</tr>
		<?php
			}
		}


		?>

		<tr id="update-cart" class="d-none">
			<td colspan="2" class="td-coupon">
				<a class="button update_cart_button d-inline-block">UPDATE CART</a>
			</td>
		</tr>

		<tr class="custom-coupon custom-forms" id="custom-coupon">
			<td colspan="2" class="td-coupon">
				<div class="checkout_coupon_custom">
					<p class="form-row form-row-first not-hide">
						<input type="text" name="custom_coupon" class="input-text" placeholder="Coupon Code" id="custom_coupon">
					</p>
					<p class="form-row form-row-last">
						<a class="button apply_custom_coupon">APPLY</a>
					</p>
				</div>
				<div class="custom-shipping-message"></div>
			</td>
		</tr>

		<tr class="custom-shipping custom-forms" id="custom-shipping-cost">
			<td colspan="2" class="td-coupon">
				<div class="checkout_coupon_custom">
					<p class="form-row form-row-first not-hide">
						<input type="number" name="custom_shipping_cost" class="input-text" placeholder="Custom Shipping Cost" id="custom_shipping_cost">
					</p>
					<p class="form-row form-row-last">
						<a class="button apply_custom_shipping_cost">Set Cost</a>
					</p>

					<div class="blockUI blockUICustomShipping  blockOverlay d-none" style="z-index: 1000; border: none; margin: 0px; padding: 0px; width: 100%; height: 100%; top: 0px; left: 0px; background: rgb(255, 255, 255); opacity: 0.6; cursor: default; position: absolute;"></div>
				</div>
				<div class="custom-shipping-message"></div>
			</td>
		</tr>
	</tbody>
	<tfoot>

		<tr class="cart-subtotal">
			<th><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
			<td><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach (WC()->cart->get_coupons() as $code => $coupon) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
				<th><?php wc_cart_totals_coupon_label($coupon); ?></th>
				<td><?php wc_cart_totals_coupon_html($coupon); ?></td>
			</tr>
		<?php endforeach; ?>


		<?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>

			<?php do_action('woocommerce_review_order_before_shipping'); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action('woocommerce_review_order_after_shipping'); ?>

		<?php endif; ?>


		<?php foreach (WC()->cart->get_fees() as $fee) : ?>
			<tr class="fee">
				<th><?php echo esc_html($fee->name); ?></th>
				<td>
					<?php wc_cart_totals_fee_html($fee); ?>
					<?php if ($fee->name == 'Custom Shipping Cost') { ?>
						<a class="woocommerce-remove-coupon remove-custom-shipping" data-coupon="custom_shipping">[Remove]</a>
					<?php } ?>
				</td>
			</tr>
		<?php endforeach; ?>

		<?php if (wc_tax_enabled() && !WC()->cart->display_prices_including_tax()) : ?>
			<?php if ('itemized' === get_option('woocommerce_tax_total_display')) : ?>
				<?php foreach (WC()->cart->get_tax_totals() as $code => $tax) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited 
				?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr(sanitize_title($code)); ?>">
						<th><?php echo esc_html($tax->label); ?></th>
						<td><?php echo wp_kses_post($tax->formatted_amount); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html(WC()->countries->tax_or_vat()); ?></th>
					<td><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action('woocommerce_review_order_before_order_total'); ?>

		<tr class="order-total">
			<th><?php esc_html_e('Total', 'woocommerce'); ?></th>
			<td><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action('woocommerce_review_order_after_order_total'); ?>

	</tfoot>
</table>