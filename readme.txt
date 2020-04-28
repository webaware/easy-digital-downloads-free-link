# Easy Digital Downloads Free Link
Contributors: webaware
Plugin Name: Easy Digital Downloads Free Link
Plugin URI: https://wordpress.org/plugins/easy-digital-downloads-free-link/
Author URI: https://shop.webaware.com.au/
Donate link: https://shop.webaware.com.au/donations/?donation_for=Easy+Digital+Downloads+Free+Link
Tags: download, downloads, digital downloads, easy digital downloads, edd
Requires at least: 4.0
Tested up to: 5.3
Requires PHP: 5.6
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

replace EDD add-to-cart button with download link when product is free

## Description

Replace the add-to-cart button in [Easy Digital Downloads](https://wordpress.org/plugins/easy-digital-downloads/) with a direct link to the download file when the product is free and has only one file. This only works when the file is an external link to a web-accessible file.

For archive pages on the [Shop Front theme](https://wordpress.org/themes/shop-front), the cart icon is replaced with a download icon and direct download link.

Want to see it in action? Check out the [WebAware shop](https://shop.webaware.com.au/) -- it's running this plugin.

### Translations

Many thanks to the generous efforts of our translators:

* Albanian (sq) -- [the Albanian translation team](https://translate.wordpress.org/locale/sq/default/wp-plugins/easy-digital-downloads-free-link)
* Chinese (zh_CN) -- [the Chinese (simplified) translation team](https://translate.wordpress.org/locale/zh-cn/default/wp-plugins/easy-digital-downloads-free-link)
* English (en_CA) -- [the English (Canadian) translation team](https://translate.wordpress.org/locale/en-ca/default/wp-plugins/easy-digital-downloads-free-link)
* English (en_GB) -- [the English (British) translation team](https://translate.wordpress.org/locale/en-gb/default/wp-plugins/easy-digital-downloads-free-link)
* French (fr_FR) -- [the French translation team](https://translate.wordpress.org/locale/fr/default/wp-plugins/easy-digital-downloads-free-link)
* Hungarian (hu_HU) -- [Tom Vicces](https://profiles.wordpress.org/theguitarlesson/)
* Japanese (ja) -- [the Japanese translation team](https://translate.wordpress.org/locale/ja/default/wp-plugins/easy-digital-downloads-free-link)
* Norwegian: Bokmål (nb_NO) -- [neonnero](http://www.neonnero.com/)
* Norwegian: Nynorsk (nn_NO) -- [neonnero](http://www.neonnero.com/)

If you'd like to help out by translating this plugin, please [sign up for an account and dig in](https://translate.wordpress.org/projects/wp-plugins/easy-digital-downloads-free-link).

## Installation

1. Either install automatically through the WordPress admin, or download the .zip file, unzip to a folder, and upload the folder to your /wp-content/plugins/ directory. Read [Installing Plugins](https://codex.wordpress.org/Managing_Plugins#Installing_Plugins) in the WordPress Codex for details.
2. Activate the plugin through the 'Plugins' menu in WordPress.

## Frequently Asked Questions

### Why?

Because I wanted to add my free plugins to an Easy Digital Downloads shop, without making it harder to download them from the shop than from WordPress.org plugin pages.

### Are downloads logged in Easy Digital Downloads?

No. Downloads are direct from the site hosting the linked file.

### Can I change the download link label?

Yes, see Downloads > Settings > Extensions. There's also a filter hook, `edd_free_link_label`, if you want finer control over the link label.

### Can I change the download link HTML?

Yes, there are templates. Look in the templates folder of the plugin. There's also a filter hook, `edd_free_link_template`, if you want finer control over which template is used.

## Screenshots

1. Download button on a free download
2. Download icon on Shop Front theme home page

## Upgrade Notice

### 1.1.0

requires minimum PHP version 5.6 (recommend version 7.2 or greater)

### 1.2.0

A new special hook has been defined for the download link: 'edd_free_link_requested_file'.

## Changelog

The full changelog can be found [on GitHub](https://github.com/webaware/easy-digital-downloads-free-link/blob/master/changelog.md). Recent entries:

### 1.1.0

Released 2018-11-25

* changed: requires minimum PHP version 5.6 (recommend version 7.2 or greater)
* tested: WordPress 5.0

### 1.2.0

Released 2020-04-28

* A new special hook has been defined for the download link: 'edd_free_link_requested_file'
* tested: WordPress 5.4
