<?php
// template for free downloads link icon (Shopfront theme)
// to customise, copy to your child theme:
//    /wp-contents/theme/YOUR_THEME/plugins/easy-digital-downloads-free-link/download-icon.php

if (!defined('ABSPATH')) {
	exit;
}
?>

<a href="<?php echo esc_url($download_url); ?>" class="icon-action <?php echo esc_attr($download_link_classes); ?>">
	<span class="edd-add-to-cart-label">
		<i class="<?php echo esc_attr($args['edd_free_link_icon']); ?>" aria-hidden="true"></i>
		<span class="visuallyhidden"><?php echo esc_html($download_label); ?></span>
	</span>
</a>
