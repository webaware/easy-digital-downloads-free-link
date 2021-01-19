<?php
/*
Plugin Name: Easy Digital Downloads Free Link
Plugin URI: https://wordpress.org/plugins/easy-digital-downloads-free-link/
Description: replace add-to-cart button with download link when product is free
Version: 1.2.0
Author: WebAware
Author URI: https://shop.webaware.com.au/
Text Domain: easy-digital-downloads-free-link
Domain Path: /languages/
*/

/*
copyright (c) 2014-2018 WebAware Pty Ltd (email : support@webaware.com.au)

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

This program incorporates some code that is copyright by Photocrati Media 2012
under the GPLv2. Please see the readme.txt file distributed with NextGEN Gallery
for more information: https://wordpress.org/plugins/nextgen-gallery/
*/

if (!defined('ABSPATH')) {
	exit;
}

define('EDD_FREE_LINK_PLUGIN_ROOT', dirname(__FILE__) . '/');
define('EDD_FREE_LINK_PLUGIN_NAME', basename(dirname(__FILE__)) . '/' . basename(__FILE__));
define('EDD_FREE_LINK_PLUGIN_FILE', __FILE__);
define('EDD_FREE_LINK_MIN_PHP', '5.6');

define('EDD_FREE_LINK_OPT_LINK_LABEL', 'edd_free_link_label');

require EDD_FREE_LINK_PLUGIN_ROOT . 'includes/functions-global.php';

if (version_compare(PHP_VERSION, EDD_FREE_LINK_MIN_PHP, '<')) {
	add_action('admin_notices', 'edd_free_link_fail_php_version');
	return;
}

require EDD_FREE_LINK_PLUGIN_ROOT . 'includes/bootstrap.php';
