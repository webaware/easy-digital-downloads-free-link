<?php
/*
Plugin Name: Easy Digital Downloads Free Link
Plugin URI: http://shop.webaware.com.au/easy-digital-downloads-free-link/
Description: replace add-to-cart button with download link when product is free
Version: 1.0.0
Author: WebAware
Author URI: http://webaware.com.au/
Text Domain: edd-free-link
Domain Path: /languages/
*/

if (!defined('EDD_FREE_LINK_PLUGIN_ROOT')) {
	define('EDD_FREE_LINK_PLUGIN_ROOT', __DIR__ . '/');
	define('EDD_FREE_LINK_PLUGIN_NAME', basename(__DIR__) . '/' . basename(__FILE__));
	define('EDD_FREE_LINK_PLUGIN_FILE', __FILE__);

	define('EDD_FREE_LINK_OPTIONS', 'edd_free_link');
}

require EDD_FREE_LINK_PLUGIN_ROOT . 'includes/class.EddFreeLinkPlugin.php';
EddFreeLinkPlugin::getInstance();
