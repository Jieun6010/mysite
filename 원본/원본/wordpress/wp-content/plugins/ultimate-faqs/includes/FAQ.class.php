<?php
if ( !defined( 'ABSPATH' ) ) exit;

if ( !class_exists( 'ewdufaqFAQ' ) ) {
/**
 * Class to handle an FAQ for Ultimate FAQs
 *
 * @since 2.0.0
 */
class ewdufaqFAQ {

	/**
	 * Whether or not this request has been processed. Used to prevent
	 * duplicate forms on one page from processing an FAQ form more than
	 * once.
	 * @since 2.0.0
	 */
	public $faq_processed = false;

	/**
	 * Whether or not this request was successfully saved to the database.
	 * @since 2.0.0
	 */
	public $FAQ_inserted = false;

	public $custom_fields = array();

	public function __construct() {}

	/**
	 * Load the FAQ information from a WP_Post object or an ID
	 *
	 * @uses load_wp_post()
	 * @since 2.0.0
	 */
	public function load_post( $post ) {

		if ( is_int( $post ) || is_string( $post ) ) {
			$post = get_post( $post );
		}

		if ( get_class( $post ) == 'WP_Post' && $post->post_type == EWD_UFAQ_FAQ_POST_TYPE ) {
			$this->load_wp_post( $post );
			return true;
		} else {
			return false;
		}

	}

	/**
	 * Load data from WP post object and retrieve metadata
	 *
	 * @uses load_post_metadata()
	 * @since 2.0.0
	 */
	public function load_wp_post( $post ) {

		// Store post for access to other data if needed by extensions
		$this->post = $post;

		$this->ID = $post->ID;
		$this->question = $post->post_title;
		$this->date = $post->post_date;
		$this->answer = $post->post_content;
		$this->post_status = $post->post_status;

		$this->categories = get_the_terms( $post, EWD_UFAQ_FAQ_CATEGORY_TAXONOMY );
		if ( ! is_array( $this->categories ) ) { $this->categories = array(); }

		$this->tags = get_the_terms( $post, EWD_UFAQ_FAQ_TAG_TAXONOMY );
		if ( ! is_array( $this->tags ) ) { $this->tags = array(); }

		$this->load_custom_fields();
		$this->load_post_metadata();

		do_action( 'ewd_ufaq_faq_load_post_data', $this, $post );
	}

	/**
	 * Store custom field information for post
	 * @since 2.0.0
	 */
	public function load_custom_fields() {
		global $ewd_ufaq_controller;

		$custom_fields = ewd_ufaq_decode_infinite_table_setting( $ewd_ufaq_controller->settings->get_setting( 'faq-fields' ) );

		foreach ( $custom_fields as $custom_field ) {

			if ( ! $custom_field->id ) { continue; }

			$this->custom_fields[ $custom_field->id ] = get_post_meta( $this->ID, 'Custom_Field_' . $custom_field->id, true );
		}
	}

	/**
	 * Store metadata for post
	 * @since 2.0.0
	 */
	public function load_post_metadata() {

		$faq_author = get_post_meta( $this->ID, 'EWD_UFAQ_Post_Author', true );

		$user = wp_get_current_user();
		$this->faq_author = $faq_author ? $faq_author : $user->display_name;
		$this->faq_author_email = get_post_meta( $this->ID, 'EWD_UFAQ_Post_Author_Email', true );

		$this->views = get_post_meta( $this->ID, 'ufaq_view_count', true ) ? get_post_meta( $this->ID, 'ufaq_view_count', true ) : 0;

		$this->up_votes = get_post_meta( $this->ID, 'FAQ_Up_Votes', true );
		$this->down_votes = get_post_meta( $this->ID, 'FAQ_Down_Votes', true );
	}

	/**
	 * Insert a new FAQ submission into the database
	 *
	 * Validates the data, adds it to the database and executes notifications
	 * @since 2.0.0
	 */
	public function insert_faq() {

		// Check if this request has already been processed. If multiple forms
		// exist on the same page, this prevents a single submission from
		// being added twice.
		if ( $this->faq_processed === true ) {
			return true;
		}

		$this->faq_processed = true;

		if ( empty( $this->ID ) ) {
			$action = 'insert';
		} else {
			$action = 'update';
		}

		$this->validate_submission();
		if ( $this->is_valid_submission() === false ) {
			return false;
		}

		if ( $this->insert_post_data() === false ) { 
			return false;
		} else {
			$this->faq_inserted = true;
		}

		do_action( 'ewd_ufaq_' . $action . '_faq', $this );

		return true;
	}

	/**
	 * Validate submission data. Expects to find data in $_POST.
	 * @since 2.0.0
	 */
	public function validate_submission() {
		global $ewd_ufaq_controller;

		$this->validation_errors = array();

		// CAPTCHA
		if ( $ewd_ufaq_controller->settings->get_setting( 'submit-question-captcha' ) ) {
			
			$modified_code = intval( $_POST['ewd_ufaq_modified_captcha'] );
			$user_code = intval( $_POST['ewd_ufaq_captcha'] );

			if ( empty( $user_code ) ) {

				$this->validation_errors[] = array(
					'field'		=> 'captcha',
					'error_msg'	=> 'Captcha incorrect',
					'message'	=> $ewd_ufaq_controller->settings->get_setting( 'label-captcha-empty' ),
				);
			}
			elseif ( $user_code != $this->decrypt_modified_code( $modified_code ) ) {

				$this->validation_errors[] = array(
					'field'		=> 'captcha',
					'error_msg'	=> 'Captcha incorrect',
					'message'	=> $ewd_ufaq_controller->settings->get_setting( 'label-captcha-incorrect' ),
				);
			}
		}

		// QUESTION
		$this->question = empty( $_POST['faq_question'] ) ? false : sanitize_text_field( $_POST['faq_question'] );
		
		if ( ! $this->question ) {

			$this->validation_errors[] = array(
				'field'		=> 'faq_question',
				'error_msg'	=> 'Question is blank',
				'message'	=> $ewd_ufaq_controller->settings->get_setting( 'label-no-question-title-entered' ),
			);
		}

		// AUTHOR
		$this->faq_author = empty( $_POST['post_author'] ) ? false : sanitize_text_field( $_POST['post_author'] );

		// AUTHOR EMAIL
		$this->faq_author_email = empty( $_POST['post_author_email'] ) ? false : sanitize_email( $_POST['post_author_email'] );

		// ANSWER
		if ( $ewd_ufaq_controller->settings->get_setting( 'allow-proposed-answer' ) ) {

			$this->answer = empty( $_POST['faq_answer'] ) ? false : sanitize_textarea_field( $_POST['faq_answer'] );
		}

		// CATEGORY
		if ( $ewd_ufaq_controller->settings->get_setting( 'submitted-default-category' ) ) {

			$args = array(
				'taxonomy'		=> EWD_UFAQ_FAQ_CATEGORY_TAXONOMY,
				'hide_empty' 	=> false,
				'slug'			=> $ewd_ufaq_controller->settings->get_setting( 'submitted-default-category' )
			);

			$this->categories = get_terms( $args );
		}

		// CUSTOM FIELDS
		$custom_fields = ewd_ufaq_decode_infinite_table_setting( $ewd_ufaq_controller->settings->get_setting( 'faq-fields' ) );

		foreach ( $custom_fields as $custom_field ) {

			if ( ! $custom_field->id ) { continue; }

			$input_name = 'ewd_ufaq_custom_field_' . $custom_field->id;

			if ( $custom_field->type == 'checkbox' ) {

				$checkbox_values = ( empty( $_POST[ $input_name ] ) or ! is_array( $_POST[ $input_name ] ) ) ? array() : $_POST[ $input_name ];

				$this->custom_fields[ $custom_field->id ] =  array_map( 'sanitize_text_field', $checkbox_values );
			}
			else { $this->custom_fields[ $custom_field->id ] = empty( $_POST[ $input_name ] ) ? false : sanitize_text_field( $_POST[ $input_name ] ); }
		}

		
		$this->post_status = 'draft';

		do_action( 'ewd_ufaq_validate_faq_submission', $this );
	}

	/**
	 * Returns the decrypted version of the captcha code
	 * @since 2.0.0
	 */
	public function decrypt_modified_code( $user_code ) {

		$decrypted_code = ($user_code / 3) - 5;

		return $decrypted_code;
	}

	/**
	 * Check if submission is valid
	 *
	 * @since 2.0.0
	 */
	public function is_valid_submission() {

		if ( !count( $this->validation_errors ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Insert post data for a new FAQ or update a FAQ
	 * @since 2.0.0
	 */
	public function insert_post_data() {

		$args = array(
			'post_type'		=> EWD_UFAQ_FAQ_POST_TYPE,
			'post_title'	=> $this->question,
			'post_content'	=> ! empty( $this->answer ) ? $this->answer : '',
			'post_status'	=> $this->post_status,
		);

		if ( ! empty( $this->ID ) ) {
			$args['ID'] = $this->ID;
		}

		$args = apply_filters( 'ewd_ufaq_insert_faq_data', $args, $this );

		// When updating a FAQ, we need to update the metadata first, so that
		// notifications hooked to the status changes go out with the new metadata.
		// If we're inserting a new FAQ, we have to insert it before we can
		// add metadata, and the default notifications don't fire until it's all done.
		if ( ! empty( $this->ID ) ) {

			$this->insert_post_meta();
			$this->insert_post_categories();
			$id = wp_insert_post( $args );
		} else {

			$id = wp_insert_post( $args );
			if ( $id && ! is_wp_error( $id ) ) {
				$this->ID = $id;
				$this->insert_post_meta();
				$this->insert_post_categories();

				$this->clear_post_submission();
			}
		}

		return ! is_wp_error( $id ) && $id !== false;
	}

	/**
	 * Insert the post metadata for a new FAQ or when updating a FAQ
	 * @since 2.0.0
	 */
	public function insert_post_meta() {
		global $ewd_ufaq_controller;

		$meta = array();

		if ( ! empty( $this->faq_author ) ) {

			update_post_meta( $this->ID, 'EWD_UFAQ_Post_Author', $this->faq_author );
		}

		if ( ! empty( $this->faq_author_email ) ) {
			
			update_post_meta( $this->ID, 'EWD_UFAQ_Post_Author_Email', $this->faq_author_email );
		}

		$custom_fields = ewd_ufaq_decode_infinite_table_setting( $ewd_ufaq_controller->settings->get_setting( 'faq-fields' ) );

		foreach ( $custom_fields as $custom_field ) {

			if ( ! empty( $this->custom_fields[ $custom_field->id ] ) ) {

				update_post_meta( $this->ID, 'Custom_Field_' . $custom_field->id, $this->custom_fields[ $custom_field->id ] );
			}
		}
	}

	/**
	 * Update the categories for an FAQ
	 * @since 2.0.0
	 */
	public function insert_post_categories() {

		if ( empty( $this->categories ) or ! is_array( $this->categories ) ) { return; }

		$submit_categories = array();
		foreach ( $this->categories as $category ) { $submit_categories[] = $category->term_id; }

		wp_set_object_terms( $this->ID, $submit_categories, EWD_UFAQ_FAQ_CATEGORY_TAXONOMY );
	}

	/**
	 * Clears the $_POST values used by the plugin on successful submission
	 * @since 2.0.0
	 */
	public function clear_post_submission() {
		global $ewd_ufaq_controller;

		unset( $_POST['faq_question'] );
		unset( $_POST['faq_answer'] );
		unset( $_POST['post_author'] );
		unset( $_POST['post_author_email'] );

		$custom_fields = ewd_ufaq_decode_infinite_table_setting( $ewd_ufaq_controller->settings->get_setting( 'faq-fields' ) );

		foreach ( $custom_fields as $custom_field ) {

			unset( $_POST[ 'ewd_ufaq_custom_field_' . $custom_field->id ] );
		}
	}

}
} // endif;
