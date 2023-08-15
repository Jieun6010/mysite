<?php

/**
 * Register, display and save a password field setting in the admin menu
 *
 * @since 2.6.8
 * @package Simple Admin Pages
 */

class sapAdminPageSettingPassword_2_6_13 extends sapAdminPageSetting_2_6_13 {

	public $sanitize_callback = 'sanitize_text_field';

	/**
	 * Placeholder string for the input field
	 * @since 2.6.8
	 */
	public $placeholder = '';

	/**
	 * Display this setting
	 * @since 2.6.8
	 */
	public function display_setting() {
		?>

		<fieldset <?php $this->print_conditional_data(); ?>>
			<input name="<?php echo esc_attr( $this->get_input_name() ); ?>" type="password" id="<?php echo esc_attr( $this->get_input_name() ); ?>" value="<?php echo esc_attr( $this->value ); ?>"<?php echo !empty( $this->placeholder ) ? ' placeholder="' . esc_attr( $this->placeholder ) . '"' : ''; ?> class="regular-text <?php echo ( $this->small ? 'sap-small-text-input' : '' ); ?>" <?php echo ( $this->disabled ? 'disabled' : ''); ?> />

			<?php $this->display_disabled(); ?>	
		</fieldset>

		<?php 

		$this->display_description();
	}

}
