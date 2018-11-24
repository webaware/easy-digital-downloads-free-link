<?php
if (!defined('ABSPATH')) {
	exit;
}
?>

<div class="notice notice-error">
	<p>
		<?php echo edd_free_link_external_link(
				sprintf(esc_html__('Easy Digital Downloads Free Link requires PHP %1$s or higher; your website has PHP %2$s which is {{a}}old, obsolete, and unsupported{{/a}}.', 'easy-digital-downloads-free-link'),
					esc_html(EDD_FREE_LINK_MIN_PHP), esc_html(PHP_VERSION)),
				'https://secure.php.net/supported-versions.php'
			); ?>
	</p>
	<p><?php printf(esc_html__('Please upgrade your website hosting. At least PHP %s is recommended.', 'easy-digital-downloads-free-link'), '7.2'); ?></p>
</div>
