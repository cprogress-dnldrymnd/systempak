<?php
use TierPricingTable\PriceManager;


add_action('wp_ajax_nopriv_search_ajax', 'search_ajax'); // for not logged in users
add_action('wp_ajax_search_ajax', 'search_ajax');
function search_ajax()
{
    $posts_per_page_val = $_POST['posts_per_page'];
    $s = $_POST['s'];
    $post_type = $_POST['post_type'];
    $posts_per_page = $posts_per_page_val ? $posts_per_page_val : get_option('posts_per_page');
    $offset = $_POST['offset'];
    $args = array();


    if ($offset) {
        $args['offset'] = $offset;
    }
    if ($s) {
        $args['s'] = $s;
    }

    $args['posts_per_page'] = $posts_per_page;

    $args['post_type'] = $post_type;


    $the_query_args = new WP_Query($args);

    $found_posts = $the_query_args->found_posts;


    if (!$found_posts && $post_type == 'product' && $s != '') {
        $args['meta_query'] = array(
            array(
                'key' => '_sku',
                'value' => $s,
                'compare' => 'LIKE',
            ),
        );
        unset($args['s']);
    }


    $the_query = new WP_Query($args);


    $count = $the_query->found_posts;
    echo hide_load_more($count, $offset, $posts_per_page);

?>
    <div class="post-item-holder">
        <?php
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
        ?>
                <div class="post-item">
                    <div class="row">
                        <?php
                        if (get_the_post_thumbnail_url(get_the_ID())) {
                            $url = get_the_post_thumbnail_url(get_the_ID());
                        } else {
                            $url = wc_placeholder_img_src();
                        }
                        ?>
                        <div class="col-image">
                            <img src="<?= $url  ?>" alt="<?php the_title() ?>">
                        </div>
                        <div class="col-content">
                            <h2><?php the_title() ?></h2>
                            <div class="excerpt">
                                <?php the_excerpt() ?>
                            </div>
                            <div class="more-link-wrap">
                                <a class="more-link" href="<?php the_permalink() ?>">View <?= get_post_type() ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }
        } else {
            ?>
            <h2>No Results Found</h2>
        <?php
        }
        wp_reset_postdata();
        ?>
    </div>

<?php

    die();
}
function hide_load_more($count, $offset, $posts_per_page)
{
    ob_start();
?>
    <script>
        jQuery(document).ready(function() {
            <?php if ($count == ($offset + $posts_per_page) || $count < ($offset + $posts_per_page) || $count < $posts_per_page + 1) { ?>
                jQuery('#loadmore-holder').addClass('d-none');
            <?php } else { ?>
                jQuery('#loadmore-holder').removeClass('d-none');
            <?php } ?>
        });
    </script>
<?php
    return ob_get_clean();
}

add_action('wp_ajax_nopriv_search_ajax_products', 'search_ajax_products'); // for not logged in users
add_action('wp_ajax_search_ajax_products', 'search_ajax_products');
function search_ajax_products()
{
    
    $posts_per_page_val = 10;
    $s = $_POST['s'];
    $post_type = 'product';
    $posts_per_page = $posts_per_page_val ? $posts_per_page_val : get_option('posts_per_page');
    $offset = $_POST['offset'];
    $args = array();


    if ($offset) {
        $args['offset'] = $offset;
    }
    if ($s) {
        $args['s'] = $s;
    }

    $args['posts_per_page'] = $posts_per_page;

    $args['post_type'] = $post_type;

    $args['post_status'] = array('publish');

    $the_query_args = new WP_Query($args);

    $found_posts = $the_query_args->found_posts;

    if (!$found_posts && $post_type == 'product' && $s != '') {
        $args['meta_query'] = array(
            array(
                'key' => '_sku',
                'value' => $s,
                'compare' => 'LIKE',
            ),
        );
        unset($args['s']);
    }


    $the_query = new WP_Query($args);

    $count = $the_query->found_posts;
    echo hide_load_more($count, $offset, $posts_per_page);

?>
    <div class="post-item-holder">
        <?php
        if ($the_query->have_posts()) {
            while ($the_query->have_posts()) {
                $the_query->the_post();
        ?>
                <div class="post-item">
                    <div class="row">
                        <?php
                        if (get_the_post_thumbnail_url(get_the_ID())) {
                            $url = get_the_post_thumbnail_url(get_the_ID());
                        } else {
                            $url = wc_placeholder_img_src();
                        }
                        ?>
                        <div class="col-image col-auto">
                            <img src="<?= $url  ?>" alt="<?php the_title() ?>">
                        </div>
                        <div class="col-content d-flex align-items-center justify-content-between col">
                            <p><strong><?php the_title() ?></strong></p>
                            <!-- Button trigger modal -->
                            <button type="button" class="button product-add-to-cart-modal" data-bs-toggle="modal" title="<?= get_the_title() ?>" data-bs-target="#productModal" product-id="<?= get_the_ID() ?>">
                                Select
                            </button>
                        </div>
                    </div>
                </div>
            <?php }
        } else {
            ?>
            <h2>No Results Found</h2>
        <?php
        }
        wp_reset_postdata();
        ?>
    </div>

<?php

    die();
}


add_action('wp_ajax_nopriv_product_modal_ajax', 'product_modal_ajax'); // for not logged in users
add_action('wp_ajax_product_modal_ajax', 'product_modal_ajax');
function product_modal_ajax()
{
    $product_id = $_POST['product_id'];

    $args = array(
        'posts_per_page'      => 1,
        'post_type'           => 'product',
        'post_status'         => 'publish',
        'ignore_sticky_posts' => 1,
        'no_found_rows'       => 1,
    );

    if (isset($product_id)) {
        $args['p'] = absint($product_id);
    }

    $single_product = new WP_Query($args);

    while ($single_product->have_posts()) {
        $single_product->the_post();
        echo '<div class="single-product">';
        woocommerce_template_single_add_to_cart();

  

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

					if ($quantity_per_box) {
						$price_num =  wc_get_price_to_display(
							wc_get_product($product_id),
							array('price' => $real_price,)
						);

						$price_per_unit = wp_kses_post(wc_price($price_num / $quantity_per_box));
					} else {
						$price_per_unit = wp_kses_post(wc_price(wc_get_price_to_display(
							wc_get_product($product_id),
							array('price' => $real_price,)
						)));
					}
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

					if ($quantity_per_box) {
						$quantity_per_box = get_post_meta($product_id, 'quantity_per_box', true);

						$price_num =  PriceManager::getPriceByRules(
							$currentQuantity,
							$product_id
						);

						$price_per_unit = wp_kses_post(wc_price($price_num / $quantity_per_box));
					} else {
						$price_per_unit = wp_kses_post(wc_price(PriceManager::getPriceByRules(
							$currentQuantity,
							$product_id
						)));
					}

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
<?php endif; 
    }

    wp_reset_postdata();

    die();
}
