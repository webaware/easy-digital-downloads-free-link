<?php
// settings form

global $wp_version;
?>

<div class="wrap">
	<?php if (version_compare($wp_version, '3.8', '<')) screen_icon('options-general'); ?>
	<h2><?php _e('Easy Digital Downloads Free Link settings', 'edd-free-link'); ?></h2>

	<form action="<?php echo admin_url('options.php'); ?>" method="POST">
		<?php settings_fields(EDD_FREE_LINK_OPTIONS); ?>

		<table class="form-table">

			<tr valign="top">
				<th scope="row"><?php _e('Download link label', 'edd-free-link'); ?></th>
				<td>
					<input type="text" class="regular-text" name="edd_free_link[linkLabel]" value="<?php echo esc_attr($options['linkLabel']); ?>" />
				</td>
			</tr>

		</table>

		<?php submit_button(); ?>
	</form>
</div>
