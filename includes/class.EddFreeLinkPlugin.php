<?php

if (!defined('ABSPATH')) {
	exit;
}

/**
* class for managing the plugin
*/
class EddFreeLinkPlugin {

	/**
	* static method for getting the instance of this singleton object
	* @return self
	*/
	public static function getInstance() {
		static $instance = null;

		if ($instance === null) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	* hide constructor
	*/
	private function __construct() {}

	/**
	* initialise plugin
	*/
	public function pluginStart() {
		add_filter('init', 'edd_free_link_load_text_domain');
		add_filter('plugin_row_meta', [$this, 'addPluginDetailsLinks'], 10, 2);

		// Easy Digital Download hooks
		add_filter('edd_purchase_download_form', [$this, 'eddPurchaseDownloadForm'], 20, 2);
		add_filter('edd_settings_sections_extensions', [$this, 'eddSettingsExtensionsSection']);
		add_filter('edd_settings_extensions', [$this, 'eddSettingsExtensions']);

		// Shopfront theme hooks
		add_filter('shopfront_purchase_download_form', [$this, 'shopfrontPurchaseLink'], 20, 2);
	}

	/**
	* settings section
	*/
	public function eddSettingsExtensionsSection($sections) {
		$sections['edd_free_link'] = __('EDD Free Link', 'easy-digital-downloads-free-link');

		return $sections;
	}

	/**
	* settings items
	* @param array $settings
	* @return array
	*/
	public function eddSettingsExtensions($settings) {
		$our_settings = [

			[
				'id' => 'edd_free_link_header',
				'name' => sprintf('<strong>%s</strong>', __('EDD Free Link', 'easy-digital-downloads-free-link')),
				'desc' => '',
				'type' => 'header',
				'size' => 'regular'
			],

			[
				'id' => EDD_FREE_LINK_OPT_LINK_LABEL,
				'name' => __('Download link label', 'easy-digital-downloads-free-link'),
				'desc' => '',
				'type' => 'text',
				'size' => 'regular'
			],

		];

		// move into custom section on EDD 2.5+
		if (version_compare(EDD_VERSION, 2.5, '>=')) {
			$our_settings = ['edd_free_link' => $our_settings];
		}

		return array_merge($settings, $our_settings);
	}

	/**
	* action hook for adding plugin details links
	*/
	public function addPluginDetailsLinks($links, $file) {
		if ($file === EDD_FREE_LINK_PLUGIN_NAME) {
			$links[] = sprintf('<a href="https://wordpress.org/support/plugin/easy-digital-downloads-free-link" rel="noopener" target="_blank">%s</a>', _x('Get help', 'plugin details links', 'easy-digital-downloads-free-link'));
			$links[] = sprintf('<a href="https://wordpress.org/plugins/easy-digital-downloads-free-link/" rel="noopener" target="_blank">%s</a>', _x('Rating', 'plugin details links', 'easy-digital-downloads-free-link'));
			$links[] = sprintf('<a href="https://translate.wordpress.org/projects/wp-plugins/easy-digital-downloads-free-link" rel="noopener" target="_blank">%s</a>', _x('Translate', 'plugin details links', 'easy-digital-downloads-free-link'));
			$links[] = sprintf('<a href="https://shop.webaware.com.au/donations/?donation_for=Easy+Digital+Downloads+Free+Link" rel="noopener" target="_blank">%s</a>', _x('Donate', 'plugin details links', 'easy-digital-downloads-free-link'));
		}

		return $links;
	}

	/**
	* intercept download form, replace with a link if product is free and only has one download file
	* @param string $purchase_form
	* @param array $args
	* @return string
	*/
	public function eddPurchaseDownloadForm($purchase_form, $args) {
		global $edd_options;

		$download_id = absint($args['download_id']);
		if ($download_id && $this->canDownloadFreeSingle($download_id)) {
			$files = edd_get_download_files($download_id);

			// get first file only, with its array key
			$file_keys = array_keys($files);
			$file_key  = $file_keys[0];
			$file_data = $files[$file_key];

			$download_url          = $file_data['file'];
			$download_label        = empty($edd_options[EDD_FREE_LINK_OPT_LINK_LABEL]) ? __('Download', 'easy-digital-downloads-free-link') : $edd_options[EDD_FREE_LINK_OPT_LINK_LABEL];
			$download_link_classes = implode(' ', ['edd_free_link', $args['style'], $args['color'], trim($args['class'])]);
			$template              = empty($args['edd_free_link_icon']) ? 'download-link' : 'download-icon';

			$download_url   = apply_filters('edd_requested_file', $download_url, $files, $file_key);
			$download_label = apply_filters('edd_free_link_label', $download_label, $download_id, $args);
			$template       = apply_filters('edd_free_link_template', $template, $download_id, $args);

			// build download link
			ob_start();
			$this->loadTemplate($template, compact('download_url', 'download_label', 'download_link_classes', 'args'));
			$purchase_form = ob_get_clean();
		}

		return $purchase_form;
	}

	/**
	* test for free download possible: lowest price is free, and only one file to download
	* @param int $download_id
	* @return bool
	*/
	protected function canDownloadFreeSingle($download_id) {
		$price = floatval(edd_get_lowest_price_option($download_id));

		if ($price >= 0.001) {
			return false;
		}

		$files = edd_get_download_files($download_id);
		if (count($files) > 1) {
			return false;
		}

		// get first (only) file; NB: may not be index 0, so pull from front of array
		$file = array_shift($files);

		return !empty($file['file']);
	}

	/**
	* intercept Shopfront theme purchase link and maybe replace with download link
	* @param string $purchase_form
	* @param array $args
	* @return string
	*/
	public function shopfrontPurchaseLink($purchase_form, $args) {
		$args['edd_free_link_icon'] = 'icon-product';
		return $this->eddPurchaseDownloadForm($purchase_form, $args);
	}

	/**
	* load template from theme or plugin
	* @param string $template name of template to load
	* @param array $templateData data to make available to templates
	*/
	protected function loadTemplate($template, $templateData = []) {
		global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

		extract($templateData);

		$templatePath = locate_template("plugins/easy-digital-downloads-free-link/$template.php");
		if (!$templatePath) {
			$templatePath = EDD_FREE_LINK_PLUGIN_ROOT . "templates/$template.php";
		}

		require $templatePath;
	}

}
