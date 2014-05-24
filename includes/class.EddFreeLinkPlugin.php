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
		add_filter('edd_purchase_download_form', array($this, 'eddPurchaseDownloadForm'), 20, 2);
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
					$download_label = 'Download';
					$download_link_classes = implode(' ', array($args['style'], $args['color'], trim($args['class'])));

					// build download link
					ob_start();
					$this->loadTemplate('download-link', compact('download_url', 'download_label', 'download_link_classes', 'args'));
					$purchase_form = ob_get_clean();
				}
			}

//~ error_log(__METHOD__ . "\n$purchase_form");

		}

		return $purchase_form;
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
