<?php
/*
Plugin Name: Easy Digital Downloads Free Link
Plugin URI: http://shop.webaware.com.au/easy-digital-downloads-free-link/
Description: replace add-to-cart button with download link when product is free
Version: 1.0.1
Author: WebAware
Author URI: http://webaware.com.au/
Text Domain: edd-free-link
Domain Path: /languages/
*/

if (!defined('EDD_FREE_LINK_PLUGIN_ROOT')) {
	define('EDD_FREE_LINK_PLUGIN_ROOT', dirname(__FILE__) . '/');
	define('EDD_FREE_LINK_PLUGIN_NAME', basename(dirname(__FILE__)) . '/' . basename(__FILE__));
	define('EDD_FREE_LINK_PLUGIN_FILE', __FILE__);

	define('EDD_FREE_LINK_OPT_LINK_LABEL', 'edd_free_link_label');
}

require EDD_FREE_LINK_PLUGIN_ROOT . 'includes/class.EddFreeLinkPlugin.php';
EddFreeLinkPlugin::getInstance();
