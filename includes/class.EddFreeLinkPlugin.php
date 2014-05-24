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
	* load options, hook actions and filters
	*/
	private function __construct() {
		$defaults = array (
			'linkLabel' => __('Download', 'edd-free-link'),
		);

		$this->options = (array) get_option(EDD_FREE_LINK_OPTIONS);

		if (count(array_diff(array_keys($defaults), array_keys($this->options))) > 0) {
			// options not yet saved, or new options added; need to update and save
			$this->options = array_merge($defaults, $this->options);
			unset($this->options[0]);
			update_option(EDD_FREE_LINK_OPTIONS, $this->options);
		}

		add_filter('init', array($this, 'init'));

		// Easy Digital Download hooks
		add_filter('edd_purchase_download_form', array($this, 'eddPurchaseDownloadForm'), 20, 2);

		// Shopfront theme hooks
		add_filter('shopfront_purchase_download_form', array($this, 'shopfrontPurchaseLink'), 20, 2);
	}

	/**
	* init action
	*/
	public function init() {
		load_plugin_textdomain('edd-free-link', false, basename(dirname(__FILE__)) . '/languages/');
	}

	/**
	* intercept download form, replace with a link if product is free and only has one download file
	* @param string $purchase_form
	* @param array $args
	* @return string
	*/
	public function eddPurchaseDownloadForm($purchase_form, $args) {

//~ error_log(__METHOD__ . ": args = \n" . print_r($args,1));

		$download_id = absint($args['download_id']);
		if ($download_id) {
			$price = floatval(edd_get_lowest_price_option($args['download_id']));

//~ error_log(__METHOD__ . ": price = $price");

			if ($price < 0.001) {
				$files = edd_get_download_files($download_id);

//~ error_log(__METHOD__ . ": download = \n" . print_r($files,1));

				if (count($files) == 1 && !empty($files[0]['file'])) {
					$download_url = $files[0]['file'];
					$download_label = apply_filters('edd_free_link_label', $this->options['linkLabel'], $download_id, $args);
					$download_link_classes = implode(' ', array($args['style'], $args['color'], trim($args['class'])));

					// build download link
					ob_start();
					$template = empty($args['edd_free_link_icon']) ? 'download-link' : 'download-icon';
					$this->loadTemplate($template, compact('download_url', 'download_label', 'download_link_classes', 'args'));
					$purchase_form = ob_get_clean();
				}
			}

//~ error_log(__METHOD__ . "\n$purchase_form");

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
		global $woocommerce, $product;

		extract($templateData);

		$templatePath = locate_template("plugins/easy-digital-downloads-free-link/$template.php");
		if (!$templatePath) {
			$templatePath = EDD_FREE_LINK_PLUGIN_ROOT . "templates/$template.php";
		}

		require $templatePath;
	}

}
