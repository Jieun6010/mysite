<?php

/**
 * Register, display and save an option for uploading an image/file.
 *
 * This setting accepts the following arguments in its constructor function.
 *
 * $args = array(
 *		'id'			=> 'setting_id', 	// Unique id
 *		'title'			=> 'My Setting', 	// Title or label for the setting
 *		'description'	=> 'Description', 	// Help text description
 * );
 *
 * @since 2.5
 * @package Simple Admin Pages
 */

class sapAdminPageSettingFileUpload_2_6_13 extends sapAdminPageSetting_2_6_13 {

	public $sanitize_callback = 'esc_url_raw';

	/**
	 * Add in the JS requried to allow file uploading
	 * @since 2.5
	 */
	public $scripts = array(
		'sap-file-upload' => array(
			'path'			=> 'js/file_upload.js',
			'dependencies'	=> array( 'jquery' ),
			'version'		=> SAP_VERSION,
			'footer'		=> true,
		),
	);

	/**
	 * Display this setting
	 * @since 2.5
	 */
	public function display_setting() {

		?>

		<fieldset <?php $this->print_conditional_data(); ?>>

			<span class="sap-file-upload-preview">

				<span class="sap-file-upload-preview-label">
					<?php _e( 'Current image:', 'simple-admin-pages' ); ?>
				</span>

				<span class="sap-file-upload-preview-value">
					<?php echo esc_html( $this->value ); ?>
				</span>

			</span>

			<?php echo ( $this->value != '' ? '<br /><br />' : '' ); ?>

			<input name="<?php echo esc_attr( $this->get_input_name() ); ?>" type="hidden" id="<?php echo esc_attr( $this->get_input_name() ); ?>" class="file-upload" value="<?php echo esc_attr( $this->value ); ?>" />

			<input class="button sap-file-upload-button" type="button" value="<?php _e( 'Upload Image', 'simple-admin-pages' ); ?>" />

		</fieldset>

		<br /><br />

		<?php $this->display_disabled(); ?>	

		<?php

		$this->display_description();

	}

}
