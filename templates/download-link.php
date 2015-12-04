<?php
// template for free downloads link
// to customise, copy to your theme:
//    /wp-contents/theme/YOUR_THEME/plugins/easy-digital-downloads-free-link/download-link.php

if (!defined('ABSPATH')) {
	exit;
}
?>

<a href="<?php echo esc_url($download_url); ?>" class="<?php echo esc_attr($download_link_classes); ?>">
	<span class="edd-add-to-cart-label"><?php echo esc_html($download_label); ?></span>
</a>
