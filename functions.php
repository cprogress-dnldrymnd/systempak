<?php
add_action('wp_enqueue_scripts', 'priotech_child_enqueue_styles');
function priotech_child_enqueue_styles()
{
	wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}

require_once('includes/woocommerce.php');
