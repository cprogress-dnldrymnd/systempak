<?php
/**
 * Email Styles
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-styles.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails
 * @version 8.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load colors.
$bg        = get_option( 'woocommerce_email_background_color' );
$body      = get_option( 'woocommerce_email_body_background_color' );
$base      = get_option( 'woocommerce_email_base_color' );
$base_text = wc_light_or_dark( $base, '#202020', '#ffffff' );
$text      = get_option( 'woocommerce_email_text_color' );

// Pick a contrasting color for links.
$link_color = wc_hex_is_light( $base ) ? $base : $base_text;

if ( wc_hex_is_light( $body ) ) {
	$link_color = wc_hex_is_light( $base ) ? $base_text : $base;
}

$bg_darker_10    = wc_hex_darker( $bg, 10 );
$body_darker_10  = wc_hex_darker( $body, 10 );
$base_lighter_20 = wc_hex_lighter( $base, 20 );
$base_lighter_40 = wc_hex_lighter( $base, 40 );
$text_lighter_20 = wc_hex_lighter( $text, 20 );
$text_lighter_40 = wc_hex_lighter( $text, 40 );

// !important; is a gmail hack to prevent styles being stripped if it doesn't like something.
// body{padding: 0;} ensures proper scale/positioning of the email in the iOS native email app.
?>
body {
	background-color: <?php echo esc_attr( $bg ); ?>;
	padding: 0;
	text-align: center;
	font-family: 'Tahoma', 'Arial', 'Trebuchet MS', sans-serif;
}

#outer_wrapper {
	background-color: <?php echo esc_attr( $bg ); ?>;
}

#wrapper {
	margin: 0 auto;
	padding: 70px 0;
	-webkit-text-size-adjust: none !important;
	width: 100%;
	max-width: 600px;
}

#template_container {
	box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1) !important;
	background-color: <?php echo esc_attr( $body ); ?>;
	border: 1px solid <?php echo esc_attr( $bg_darker_10 ); ?>;
	border-radius: 3px !important;
}

#template_header {
	background-color: <?php echo esc_attr( $base ); ?>;
	border-radius: 3px 3px 0 0 !important;
	color: <?php echo esc_attr( $base_text ); ?>;
	border-bottom: 0;
	font-weight: bold;
	line-height: 100%;
	vertical-align: middle;
	font-family: 'Tahoma', 'Arial', 'Trebuchet MS', sans-serif;
}

#template_header h1,
#template_header h1 a {
	color: <?php echo esc_attr( $base_text ); ?>;
	background-color: inherit;
}

#template_header_image img {
	margin-left: 0;
	margin-right: 0;
}

#template_footer td {
	padding: 0;
	border-radius: 6px;
}

#template_footer #credit {
	border: 0;
	color: <?php echo esc_attr( $text_lighter_40 ); ?>;
	font-family: 'Tahoma', 'Arial', 'Trebuchet MS', sans-serif;
	font-size: 12px;
	line-height: 1.2;
	text-align: center;
	padding: 24px 0;
}

#template_footer #credit p {
	margin: 0 0 16px;
}

#body_content {
	background-color: <?php echo esc_attr( $body ); ?>;
}

#body_content table td {
	padding: 48px 48px 32px;
}

#body_content table td td {
	padding: 12px;
}

#body_content table td th {
	padding: 12px;
}

#body_content td ul.wc-item-meta {
	font-size: small;
	margin: 1em 0 0;
	padding: 0;
	list-style: none;
}

#body_content td ul.wc-item-meta li {
	margin: 0.5em 0 0;
	padding: 0;
}

#body_content td ul.wc-item-meta li p {
	margin: 0;
}

#body_content p {
	margin: 0 0 16px;
}

#body_content_inner {
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	font-family: 'Tahoma', 'Arial', 'Trebuchet MS', sans-serif;
	font-size: 14px;
	line-height: 1.2;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

#body_content_inner * {
	font-family: 'Tahoma', 'Arial', 'Trebuchet MS', sans-serif !important;
}

.td {
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	border: 1px solid <?php echo esc_attr( $body_darker_10 ); ?>;
	vertical-align: middle;
}

.address {
	padding: 12px;
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	font-style: normal;
	font-size: 13px;
}

.additional-fields {
	padding: 12px 12px 0;
	color: <?php echo esc_attr( $text_lighter_20 ); ?>;
	border: 1px solid <?php echo esc_attr( $body_darker_10 ); ?>;
	list-style: none outside;
}

.additional-fields li {
	margin: 0 0 12px 0;
}

.text {
	color: <?php echo esc_attr( $text ); ?>;
	font-family: 'Tahoma', 'Arial', 'Trebuchet MS', sans-serif;
}

.link {
	color: <?php echo esc_attr( $link_color ); ?>;
}

#header_wrapper {
	padding: 36px 48px;
	display: block;
}

h1 {
	color: <?php echo esc_attr( $base ); ?>;
	font-family: 'Tahoma', 'Arial', 'Trebuchet MS', sans-serif;
	font-size: 30px;
	font-weight: 300;
	line-height: 1.2;
	margin: 0;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
	text-shadow: 0 1px 0 <?php echo esc_attr( $base_lighter_20 ); ?>;
}

h2 {
	color: <?php echo esc_attr( $base ); ?>;
	display: block;
	font-family: 'Tahoma', 'Arial', 'Trebuchet MS', sans-serif;
	font-size: 18px;
	font-weight: bold;
	line-height: 1.2;
	margin: 0 0 18px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

h3 {
	color: <?php echo esc_attr( $base ); ?>;
	display: block;
	font-family: 'Tahoma', 'Arial', 'Trebuchet MS', sans-serif;
	font-size: 16px;
	font-weight: bold;
	line-height: 1.2;
	margin: 16px 0 8px;
	text-align: <?php echo is_rtl() ? 'right' : 'left'; ?>;
}

a, .ii a[href], a[href] {
	color: #63C4A9 !important;
	font-weight: normal;
	text-decoration: underline;
}

img {
	border: none;
	display: inline-block;
	font-size: 14px;
	font-weight: bold;
	height: auto;
	outline: none;
	text-decoration: none;
	text-transform: capitalize;
	vertical-align: middle;
	margin-<?php echo is_rtl() ? 'left' : 'right'; ?>: 10px;
	max-width: 100%;
}

.wc-email-table-holder {
	padding: 15px;
	border: 2px solid #F2F2F2;
}

.wc-email-table {
	width: 100%;
	
	border-collapse: collapse;
}

.wc-email-table th, .wc-email-table td {
	padding: 0 !important;
}
.fs-11 {
	font-size: 11px !important;
}
.fs-13 {
	font-size: 13px !important;
}
.fs-24 {
	font-size: 24px !important;
}
.text-center {
	text-align: center !important;
}
.text-end {
	text-align: right !important;
}
.mb-30 {
	margin-bottom: 30px !important;
}
#template_container {
	border: none !important;
	box-shadow: none !important;
}
.main-table {
	background-color: #fff !important;
	border: 1px solid #F2F2F2 !important;
}
.table-row-style {
	background-color: #ECF0F1 !important;
	text-transform: uppercase !important;
}
.table-row-style th, .table-row-style td {
	border: none !important;
	padding: 10px !important;
}
.table-order-details {
	border: none !important;
}
.table-order-details th, .table-order-details td {
	border: none !important;

}
.table-order-details tr > td, .table-order-details tr > th {
	border-bottom: 2px solid #F2F2F2 !important;
}
.order-details p {
	margin-top: 0 !important;
	margin-bottom: 10px !important;
}
.order-details ul p {
	font-size: 11px !important;
}
.bank-details td {
	padding: 10px !important;
}
/**
 * Media queries are not supported by all email clients, however they do work on modern mobile
 * Gmail clients and can help us achieve better consistency there.
 */
@media screen and (max-width: 600px) {
	#header_wrapper {
		padding: 27px 36px !important;
		font-size: 24px;
	}

	#body_content table > tbody > tr > td {
		padding: 10px !important;
	}

	#body_content_inner {
		font-size: 10px !important;
	}
}
<?php
