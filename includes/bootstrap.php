<?php

if (!defined('ABSPATH')) {
	exit;
}

/**
* kick start the plugin
*/
add_action('plugins_loaded', function() {
	require EDD_FREE_LINK_PLUGIN_ROOT . 'includes/class.EddFreeLinkPlugin.php';
	EddFreeLinkPlugin::getInstance()->pluginStart();
});
