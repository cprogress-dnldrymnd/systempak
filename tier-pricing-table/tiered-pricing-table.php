<?php

/**
 * Available variables
 *
 * @var array $price_rules
 * @var string $pricing_type
 * @var string $real_price
 * @var string $product_name
 * @var WC_Product $product
 * @var string $id
 * @var int $product_id
 * @var int $minimum
 * @var array $settings
 */

use TierPricingTable\PriceManager;

if (!defined('WPINC')) {
	die;
}
?>

<?php if (!empty($price_rules)) : ?>
	<div class="clear"></div>

	<div class="tiered-pricing-wrapper">
		<?php if (!empty($settings['title'])) : ?>

			<h3 style="clear:both;margin: 20px 0;"><?php echo esc_attr($settings['title']); ?></h3>
		<?php endif; ?>

		<table class="shop_table tiered-pricing-table" id="<?php echo esc_attr($id); ?>" data-tiered-pricing-table data-product-id="<?php echo esc_attr($product_id); ?>" data-price-rules="<?php echo esc_attr(json_encode($price_rules)); ?>" data-minimum="<?php echo esc_attr($minimum); ?>" data-product-name="<?php echo esc_attr($product_name); ?>" data-regular-price="<?php echo esc_attr($product->get_regular_price()); ?>" data-sale-price="<?php echo esc_attr($product->get_sale_price()); ?>" data-price="<?php echo esc_attr($product->get_price()); ?>" data-product-price-suffix="<?php echo esc_attr($product->get_price_suffix()); ?>">

			<?php if ('' != $settings['quantity_column_title'] && '' != $settings['price_column_title']) : ?>
				<thead>
					<tr>
						<th>
							<span class="nobr"><strong><?php echo esc_attr(sanitize_text_field($settings['quantity_column_title'])); ?></strong></span>
						</th>

						<?php if ($settings['show_discount_column']) : ?>
							<th>
								<span class="nobr"><strong><?php echo esc_attr(sanitize_text_field($settings['discount_column_title'])); ?></strong></span>
							</th>
						<?php endif; ?>

						<th>
							<span class="nobr"><strong><?php echo esc_attr(sanitize_text_field($settings['price_column_title'])); ?></strong></span>
						</th>
						<th>
							<span class="nobr"><strong>Price Per Unit</strong></span>
						</th>
					</tr>
				</thead>
			<?php endif; ?>

			<tbody>
				<tr class="tiered-pricing--active" data-tiered-quantity="<?php echo esc_attr($minimum); ?>" data-tiered-price="
				<?php
				echo esc_attr(wc_get_price_to_display(
					wc_get_product($product_id),
					array('price' => $real_price,)
				));
				?>
				" data-tiered-price-exclude-taxes="
				<?php
				echo esc_attr(wc_get_price_excluding_tax(
					wc_get_product($product_id),
					array('price' => $real_price,)
				));
				?>
				" data-tiered-price-include-taxes="
				<?php
				echo esc_attr(wc_get_price_including_tax(wc_get_product($product_id), array(
					'price' => $real_price,
				)));
				?>
				">
					<td>
						<?php if (1 >= array_keys($price_rules)[0] - $minimum || 'static' === $settings['quantity_type']) : ?>
							<span><?php echo esc_attr(number_format_i18n($minimum)); ?></span>
							<?php echo esc_attr(' ' . $settings['quantity_measurement_singular']); ?>
						<?php else : ?>
							<span><?php echo esc_attr(number_format_i18n($minimum)); ?> - <?php echo esc_attr(number_format_i18n(array_keys($price_rules)[0] - 1)); ?></span>
							<?php echo esc_attr(' ' . $settings['quantity_measurement_plural']); ?>
						<?php endif; ?>
					</td>
					<?php if ($settings['show_discount_column']) : ?>
						<td>
							—
						</td>
					<?php endif; ?>
					<td>
						<?php
						echo wp_kses_post(wc_price(wc_get_price_to_display(
							wc_get_product($product_id),
							array('price' => $real_price,)
						)));
						?>
					</td>
					<?php
					$quantity_per_box = get_post_meta($product_id, 'quantity_per_box', true);

					$price_num =  wc_get_price_to_display(
						wc_get_product($product_id),
						array('price' => $real_price,)
					);

					$price_per_unit = wp_kses_post(wc_price($price_num / $quantity_per_box));
					?>
					<td>
						<span class="price-per-unit"><?= $price_per_unit ?></span>
					</td>
				</tr>

				<?php $iterator = new ArrayIterator($price_rules); ?>

				<?php while ($iterator->valid()) : ?>
					<?php
					$currentPrice    = $iterator->current();
					$currentQuantity = $iterator->key();

					$iterator->next();


					if ('percentage' === $pricing_type) {
						$discountAmount = $currentPrice;
					} else {
						$discountAmount = PriceManager::calculateDiscount($real_price, $currentPrice);
					}

					$quantity = number_format_i18n($currentQuantity);

					if ($iterator->valid()) {

						if (intval($iterator->key() - 1 != $currentQuantity) && 'range' === $settings['quantity_type']) {
							$quantity .= ' - ' . number_format_i18n(intval($iterator->key() - 1));
						}
					} else {
						$quantity .= '+';
					}

					$quantity .= ' ' . $settings['quantity_measurement_plural'];

					$currentProductPrice = PriceManager::getPriceByRules($currentQuantity, $product_id);

					$currentProductPriceExcludeTaxes = wc_get_price_excluding_tax(wc_get_product($product_id), array(
						'price' => PriceManager::getPriceByRules($currentQuantity, $product_id, null, null, false),
					));

					$currentProductPriceIncludeTaxes = wc_get_price_including_tax(wc_get_product($product_id), array(
						'price' => PriceManager::getPriceByRules($currentQuantity, $product_id, null, null, false),
					));

					$quantity_per_box = get_post_meta($product_id, 'quantity_per_box', true);

					$price_num =  PriceManager::getPriceByRules(
						$currentQuantity,
						$product_id
					);

					$price_per_unit = wp_kses_post(wc_price($price_num / $quantity_per_box));
					?>
					<tr data-tiered-quantity="<?php echo esc_attr($currentQuantity); ?>" data-tiered-price="<?php echo esc_attr($currentProductPrice); ?>" data-tiered-price-exclude-taxes="<?php echo esc_attr($currentProductPriceExcludeTaxes); ?>" data-tiered-price-include-taxes="<?php echo esc_attr($currentProductPriceIncludeTaxes); ?>">
						<td>
							<span><?php echo esc_attr($quantity); ?></span>
						</td>
						<?php if ($settings['show_discount_column']) : ?>
							<td>
								<span><?php echo esc_attr(round($discountAmount, 2)); ?> %</span>
							</td>
						<?php endif; ?>
						<td>
							<?php

							echo wp_kses_post(wc_price(PriceManager::getPriceByRules(
								$currentQuantity,
								$product_id
							)));
							?>
						</td>
						<td>
							<span class="price-per-unit"><?= $price_per_unit ?></span>
						</td>
					</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
	</div>

	<style>
		<?php
		if ($settings['clickable_rows']) {
			echo esc_attr('#' . $id) . ' tr {cursor: pointer; }';
		}
		?><?php echo esc_attr('#' . $id); ?>.tiered-pricing--active td {
			background-color: <?php echo esc_attr($settings['active_tier_color']); ?> !important;
		}
	</style>
<?php endif; ?>