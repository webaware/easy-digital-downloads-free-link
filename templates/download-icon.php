<?php
// template for free downloads link icon (Shopfront theme)
// to customise, copy to your child theme:
//    /wp-contents/theme/YOUR_THEME/plugins/easy-digital-downloads-free-link/download-icon.php

if (!defined('ABSPATH')) {
	exit;
}
?>

<a href="<?= esc_url($download_url); ?>" class="icon-action <?= esc_attr($download_link_classes); ?>">
	<span class="edd-add-to-cart-label">
		<i class="<?= esc_attr($args['edd_free_link_icon']); ?>" aria-hidden="true"></i>
		<span class="visuallyhidden"><?= esc_html($download_label); ?></span>
	</span>
</a>
