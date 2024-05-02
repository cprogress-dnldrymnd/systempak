<?php
/**
 * Customer invoice email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-invoice.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 3.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Executes the e-mail header.
 *
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>



<div class="text-center" style="margin-bottom: 20px;">
	<img src="https://systempak.net/wp-content/uploads/2024/04/Icon-awesome-check-circle.png">
</div>
<div class="fs-24 text-center mb-30">
	<strong>Your order has been placed</strong>
</div>

<?php if ( $order->needs_payment() ) { ?>
	<div class="wc-email-table-holder">
		<p>
		<?php
		printf(
			wp_kses(
				/* translators: %1$s Site title, %2$s Order pay link */
				__( 'An order has been created for you on %1$s. Your invoice is below, with a link to make payment when you’re ready: %2$s', 'woocommerce' ),
				array(
					'a' => array(
						'href' => array(),
					),
				)
			),
			esc_html( get_bloginfo( 'name', 'display' ) ),
			'<a href="' . esc_url( $order->get_checkout_payment_url() ) . '">' . esc_html__( 'Pay for this order', 'woocommerce' ) . '</a>'
		);
		?>
		</p>
	</div>
<?php } ?>

<div class="wc-email-table-holder" style="margin-bottom: 20px;">
	<table class="wc-email-table">
		<tr>
			<th class="fs-11">ORDER DATE</th>
			<th class="fs-11 text-end">ORDER NO.</th>
		</tr>
		<tr>
			<td class="fs-13"><?= esc_html( wc_format_datetime( $order->get_date_created() ) ) ?></td>
			<td class="fs-13 text-end"><?= $order->get_id() ?></td>
		</tr>
	</table>
</div>
<?php

/**
 * Hook for the woocommerce_email_order_details.
 *
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Hook for the woocommerce_email_order_meta.
 *
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/**
 * Hook for woocommerce_email_customer_details.
 *
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/**
 * Executes the email footer.
 *
 * @hooked WC_Emails::email_footer() Output the email footer
 */

?>
	</div>
																	</td>
																</tr>
															</table>
															<!-- End Content -->
														</td>
													</tr>
												</table>
												<!-- End Body -->
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr>
								<td align="center" valign="top" style="background-color: #F9F9F9; padding-top: 40px;">
									<!-- Footer -->
									<table border="0" cellpadding="10" cellspacing="0" width="100%" id="template_footer">
										<tr>
											<td style="padding-left: 38px; padding-right: 38px">
												<table class="bank-details"  border="0" cellpadding="10" cellspacing="0" width="100%">
													<tr>
														<td colspan="2"  valign="top" style="font-size: 14px; color: #000">
															<strong>BANK DETAILS</strong>
														</td>
													</tr>
													<tr>
														<td colspan="2" valign="top" style="font-size: 12px; border-bottom: 2px solid #F2F2F2; padding-bottom: 20px !important;color: #000">
															Bank details are as follows should you have selected to pay by bank transfer.
														</td>
													</tr>
													<tr>
														<td class="fs-11"  style="width: 120px; color: #000">
															<strong>BANK NAME:</strong>
														</td>
														<td class="fs-11" style="color: #000">
															Natwest
														</td>
													</tr>
													<tr>
														<td class="fs-11" style="color: #000">
															<strong>ACCOUNT NAME:</strong>
														</td>
														<td class="fs-11" style="color: #000">
															Systempak LTD
														</td>
													</tr>
													<tr>
														<td class="fs-11" style="color: #000">
															<strong>SORT CODE:</strong>
														</td>
														<td class="fs-11" style="color: #000">
															60-21-36
														</td>
													</tr>
													<tr>
														<td class="fs-11" style="color: #000">
															<strong>ACCOUNT NUMBER:</strong>
														</td>
														<td class="fs-11" style="color: #000">
															5750 6620
														</td>
													</tr>
													<tr>
														<td colspan="2" valign="top" style="font-size: 12px; border-top: 2px solid #F2F2F2; padding-top: 20px !important; color: #000">
															Please use your Order No. as the payment reference. Your order will not be shipped until the funds have cleared in our account.
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td valign="top">
												<table border="0" cellpadding="10" cellspacing="0" width="100%">
													<tr>
														<td colspan="2" valign="middle" id="credit">
															<img src="https://systempak.net/testing/wp-content/uploads/2024/04/systempak-email-footer.png">
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
									<!-- End Footer -->
								</td>
							</tr>
						</table>
					</div>
				</td>
				<td><!-- Deliberately empty to support consistent sizing and layout across multiple email clients. --></td>
			</tr>
		</table>
	</body>
</html>