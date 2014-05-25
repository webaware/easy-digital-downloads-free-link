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
			'linkLabel' => '',
		);

		$this->options = (array) get_option(EDD_FREE_LINK_OPTIONS);

		if (count(array_diff(array_keys($defaults), array_keys($this->options))) > 0) {
			// options not yet saved, or new options added; need to update and save
			$this->options = array_merge($defaults, $this->options);
			unset($this->options[0]);
			update_option(EDD_FREE_LINK_OPTIONS, $this->options);
		}

		add_filter('init', array($this, 'init'));
		add_action('admin_init', array($this, 'adminInit'));
		add_action('admin_menu', array($this, 'adminMenu'));
		add_filter('plugin_row_meta', array($this, 'addPluginDetailsLinks'), 10, 2);

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
	* register settings in WP admin
	*/
	public function adminInit() {
		add_settings_section(EDD_FREE_LINK_OPTIONS, false, false, EDD_FREE_LINK_OPTIONS);
		register_setting(EDD_FREE_LINK_OPTIONS, EDD_FREE_LINK_OPTIONS, array($this, 'settingsValidate'));
	}

	/**
	* admin menu items
	*/
	public function adminMenu() {
		$title = __('EDD Free Link', 'edd-free-link');
		add_options_page($title, $title, 'manage_options', 'eddfreelink', array($this, 'settingsPage'));
	}

	/**
	* settings admin
	*/
	public function settingsPage() {
		$options = $this->options;
		require EDD_FREE_LINK_PLUGIN_ROOT . 'views/settings-form.php';
	}

	/**
	* validate/sanitise settings on save
	* @param array $input
	* @return array
	*/
	public function settingsValidate($input) {
		$output = array();

		$output['linkLabel'] = wp_kses_data(trim($input['linkLabel']));

		return $output;
	}

	/**
	* action hook for adding plugin details links
	*/
	public function addPluginDetailsLinks($links, $file) {
		if ($file == DISABLE_EMAILS_PLUGIN_NAME) {
			$links[] = '<a href="http://wordpress.org/support/plugin/easy-digital-downloads-free-link">' . __('Get help', 'edd-free-link') . '</a>';
			$links[] = '<a href="http://wordpress.org/plugins/easy-digital-downloads-free-link/">' . __('Rating', 'edd-free-link') . '</a>';
			$links[] = '<a href="http://shop.webaware.com.au/donations/?donation_for=Easy+Digital+Downloads+Free+Link">' . __('Donate', 'edd-free-link') . '</a>';
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

//~ error_log(__METHOD__ . ": args = \n" . print_r($args,1));

		$download_id = absint($args['download_id']);
		if ($download_id) {
			$price = floatval(edd_get_lowest_price_option($args['download_id']));

			if ($price < 0.001) {
				$files = edd_get_download_files($download_id);

				if (count($files) == 1 && !empty($files[0]['file'])) {
					$download_url = $files[0]['file'];
					$download_label = empty($this->options['linkLabel']) ? __('Download', 'edd-free-link') : $this->options['linkLabel'];
					$download_link_classes = implode(' ', array($args['style'], $args['color'], trim($args['class'])));
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
		global $woocommerce, $product;

		extract($templateData);

		$templatePath = locate_template("plugins/easy-digital-downloads-free-link/$template.php");
		if (!$templatePath) {
			$templatePath = EDD_FREE_LINK_PLUGIN_ROOT . "templates/$template.php";
		}

		require $templatePath;
	}

}
