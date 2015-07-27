<?php

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

		if (is_null($instance)) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	* hook actions and filters
	*/
	private function __construct() {
		add_filter('init', array($this, 'init'));
		add_filter('plugin_row_meta', array($this, 'addPluginDetailsLinks'), 10, 2);

		// Easy Digital Download hooks
		add_filter('edd_purchase_download_form', array($this, 'eddPurchaseDownloadForm'), 20, 2);
		add_filter('edd_settings_extensions', array($this, 'eddSettingsExtensions'));

		// Shopfront theme hooks
		add_filter('shopfront_purchase_download_form', array($this, 'shopfrontPurchaseLink'), 20, 2);
	}

	/**
	* init action
	*/
	public function init() {
		load_plugin_textdomain('edd-free-link', false, basename(dirname(EDD_FREE_LINK_PLUGIN_FILE)) . '/languages/');
	}

	/**
	* settings items
	* @param array $settings
	* @return array
	*/
	public function eddSettingsExtensions($settings) {
		$our_settings = array(
			array(
				'id' => 'edd_free_link_header',
				'name' => sprintf('<strong>%s</strong>', __('EDD Free Link', 'edd-free-link')),
				'desc' => '',
				'type' => 'header',
				'size' => 'regular'
			),
			array(
				'id' => EDD_FREE_LINK_OPT_LINK_LABEL,
				'name' => __('Download link label', 'edd-free-link'),
				'desc' => '',
				'type' => 'text',
				'size' => 'regular'
			),
		);

		return array_merge($settings, $our_settings);
	}

	/**
	* action hook for adding plugin details links
	*/
	public function addPluginDetailsLinks($links, $file) {
		if ($file == EDD_FREE_LINK_PLUGIN_NAME) {
			$links[] = sprintf('<a href="http://wordpress.org/support/plugin/easy-digital-downloads-free-link" target="_blank">%s</a>', _x('Get help', 'plugin details links', 'edd-free-link'));
			$links[] = sprintf('<a href="http://wordpress.org/plugins/easy-digital-downloads-free-link/" target="_blank">%s</a>', _x('Rating', 'plugin details links', 'edd-free-link'));
			$links[] = sprintf('<a href="http://translate.webaware.com.au/projects/edd-free-link" target="_blank">%s</a>', _x('Translate', 'plugin details links', 'edd-free-link'));
			$links[] = sprintf('<a href="http://shop.webaware.com.au/donations/?donation_for=Easy+Digital+Downloads+Free+Link" target="_blank">%s</a>', _x('Donate', 'plugin details links', 'edd-free-link'));
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
		if ($download_id) {
			$price = floatval(edd_get_lowest_price_option($args['download_id']));

			if ($price < 0.001) {
				$files = edd_get_download_files($download_id);

				if (count($files) == 1 && !empty($files[0]['file'])) {
					$download_url = $files[0]['file'];
					$download_label = empty($edd_options[EDD_FREE_LINK_OPT_LINK_LABEL]) ? __('Download', 'edd-free-link') : $edd_options[EDD_FREE_LINK_OPT_LINK_LABEL];
					$download_link_classes = implode(' ', array('edd_free_link', $args['style'], $args['color'], trim($args['class'])));
					$template = empty($args['edd_free_link_icon']) ? 'download-link' : 'download-icon';

					$download_label = apply_filters('edd_free_link_label', $download_label, $download_id, $args);
					$template = apply_filters('edd_free_link_template', $template, $download_id, $args);

					// build download link
					ob_start();
					$this->loadTemplate($template, compact('download_url', 'download_label', 'download_link_classes', 'args'));
					$purchase_form = ob_get_clean();
				}
			}
		}

		return $purchase_form;
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
	protected function loadTemplate($template, $templateData = array()) {
		global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

		extract($templateData);

		$templatePath = locate_template("plugins/easy-digital-downloads-free-link/$template.php");
		if (!$templatePath) {
			$templatePath = EDD_FREE_LINK_PLUGIN_ROOT . "templates/$template.php";
		}

		require $templatePath;
	}

}
