=== Easy Digital Downloads Free Link ===
Contributors: webaware
Plugin Name: Easy Digital Downloads Free Link
Plugin URI: http://shop.webaware.com.au/easy-digital-downloads-free-link/
Author URI: http://webaware.com.au/
Donate link: http://shop.webaware.com.au/donations/?donation_for=Easy+Digital+Downloads+Free+Link
Tags: download, downloads, digital downloads, easy digital downloads
Requires at least: 3.7
Tested up to: 4.3
Stable tag: 1.0.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

replace EDD add-to-cart button with download link when product is free

== Description ==

Replace the add-to-cart button in Easy Digital Downloads with a direct link to the download file when the product is free and has only one file. This only works when the file is an external link to a web-accessible file.

For archive pages on the [Shop Front theme](http://wordpress.org/themes/shop-front), the cart icon is replaced with a download icon and direct download link.

Want to see it in action? Check out [my shop](http://shop.webaware.com.au/) -- it's running this plugin.

= Translations =

Many thanks to the generous efforts of our translators:

* Norwegian: Bokmål (nb_NO) -- [neonnero](http://www.neonnero.com/)
* Norwegian: Nynorsk (nn_NO) -- [neonnero](http://www.neonnero.com/)

If you'd like to help out by translating this plugin, please [sign up for an account and dig in](http://translate.webaware.com.au/projects/edd-free-link).

== Installation ==

1. Either install automatically through the WordPress admin, or download the .zip file, unzip to a folder, and upload the folder to your /wp-content/plugins/ directory. Read [Installing Plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins) in the WordPress Codex for details.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Frequently Asked Questions ==

= Why? =

Because I wanted to add my free plugins to an Easy Digital Downloads shop, without making it harder to download them from the shop than from WordPress.org plugin pages.

= Are downloads logged in Easy Digital Downloads? =

No. Downloads are direct from the site hosting the linked file.

= Can I change the download link label? =

Yes, see Downloads > Settings > Extensions. There's also a filter hook, `edd_free_link_label`, if you want finer control over the link label.

= Can I change the download link HTML? =

Yes, there are templates. Look in the templates folder of the plugin. There's also a filter hook, `edd_free_link_template`, if you want finer control over which template is used.

== Screenshots ==

1. Download button on a free download
2. Download icon on Shop Front theme home page

== Contributions ==

* [Translate into your preferred language](http://translate.webaware.com.au/projects/edd-free-link)
* [Fork me on GitHub](https://github.com/webaware/easy-digital-downloads-free-link)

== Changelog ==

= 1.0.3.1, 2014-08/31 =

* added: Norwegian translations (thanks, [neonnero](http://www.neonnero.com/)!)

= 1.0.2, 2014-06-22 =

* fixed: links in plugins admin page (copypasta error)
* added: where to sign up for translation contributions

= 1.0.1, 2014-05-28 =

* change: move settings into EDD settings page > Extensions

= 1.0.0, 2014-05-26 =

* initial public version
