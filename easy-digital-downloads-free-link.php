<?php
/*
Plugin Name: Easy Digital Downloads Free Link
Plugin URI: http://shop.webaware.com.au/easy-digital-downloads-free-link/
Description: replace add-to-cart button with download link when product is free
Version: 1.0.3
Author: WebAware
Author URI: http://webaware.com.au/
Text Domain: edd-free-link
Domain Path: /languages/
*/

/*
copyright (c) 2014 WebAware Pty Ltd (email : support@webaware.com.au)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!defined('EDD_FREE_LINK_PLUGIN_ROOT')) {
	define('EDD_FREE_LINK_PLUGIN_ROOT', dirname(__FILE__) . '/');
	define('EDD_FREE_LINK_PLUGIN_NAME', basename(dirname(__FILE__)) . '/' . basename(__FILE__));
	define('EDD_FREE_LINK_PLUGIN_FILE', __FILE__);

	define('EDD_FREE_LINK_OPT_LINK_LABEL', 'edd_free_link_label');
}

require EDD_FREE_LINK_PLUGIN_ROOT . 'includes/class.EddFreeLinkPlugin.php';
EddFreeLinkPlugin::getInstance();
