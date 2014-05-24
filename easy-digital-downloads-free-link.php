<?php
/*
Plugin Name: Easy Digital Downloads Free Link
Plugin URI:
Description: replace add-to-cart button with download link when product is free
Version: 0.0.1
Author: WebAware
Author URI: http://webaware.com.au/
*/


if (!defined('EDD_FREE_LINK_PLUGIN_ROOT')) {
	define('EDD_FREE_LINK_PLUGIN_ROOT', dirname(__FILE__) . '/');
	define('EDD_FREE_LINK_PLUGIN_NAME', basename(dirname(__FILE__)) . '/' . basename(__FILE__));
	define('EDD_FREE_LINK_PLUGIN_FILE', __FILE__);
	define('EDD_FREE_LINK_PLUGIN_VERSION', '0.0.1');
}

require EDD_FREE_LINK_PLUGIN_ROOT . 'includes/class.EddFreeLinkPlugin.php';
EddFreeLinkPlugin::getInstance();
