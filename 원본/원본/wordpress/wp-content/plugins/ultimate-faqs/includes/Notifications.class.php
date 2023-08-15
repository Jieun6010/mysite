<?php

/**
 * Class to handle sending notifications when an FAQ is submitted
 */

if ( !defined( 'ABSPATH' ) )
	exit;

if ( !class_exists( 'ewdufaqNotifications' ) ) {
class ewdufaqNotifications {

	public function __construct() {
		
		add_action( 'ewd_ufaq_insert_faq', array( $this, 'admin_notification_email' ) );
		add_action( 'ewd_ufaq_insert_faq', array( $this, 'user_submission_email' ) );
	}

	/**
	 * Send an email to the site admin when an FAQ is submitted, if selected
	 *
	 * @since 2.0.0
	 */
	public function admin_notification_email( $faq ) {
		global $ewd_ufaq_controller;

		if ( ! $ewd_ufaq_controller->settings->get_setting( 'admin-question-notification' ) ) { return; }

		$admin_emails = $ewd_ufaq_controller->settings->get_setting( 'admin-notification-email' ) ? explode( ',', $ewd_ufaq_controller->settings->get_setting( 'admin-notification-email' ) ) : (array) get_option( 'admin_email' );
	
		$faq_link = site_url() . '/wp-admin/post.php?post=' . $faq->ID . '&action=edit';
	
		$subject_line = __( 'New Question Received', 'ultimate-faqs' );
	
		$message_body = __( 'Hello Admin,', 'ultimate-faqs' ) . '<br/><br/>';
		$message_body .= __( 'You\'ve received a new question titled ', 'ultimate-faqs' ) . $faq->question . '.<br/><br/>';
		
		if ( ! empty( $faq->answer ) ) {

			$message_body .= __( 'The answer reads:<br>', 'ultimate-faqs' );
			$message_body .= esc_html( $faq->answer ) . '<br><br><br>';
		}
		
		$message_body .= __( 'You can view the question in the admin area by going to the following link:<br>', 'ultimate-faqs' );
		$message_body .= '<a href=\'' . $faq_link . '\'>' . __( 'See the FAQ', 'ultimate-faqs' ) . '</a><br/><br/>';
		$message_body .= __( 'Have a great day,', 'ultimate-faqs' ) . '<br/><br/>';
		$message_body .= __( 'Ultimate FAQs Team', 'ultimate-faqs' );
	
		$headers = array( 'Content-Type: text/html; charset=UTF-8' );

		foreach ( $admin_emails as $admin_email ) {

			$success = wp_mail( $admin_email, $subject_line, $message_body, $headers );
		}

		return $success;
	}

	/**
	 * Send an email to the FAQ author using UWPM when an FAQ is submitted, if selected
	 *
	 * @since 2.0.0
	 */
	public function user_submission_email( $faq ) {
		global $ewd_ufaq_controller;

		if ( ! $ewd_ufaq_controller->settings->get_setting( 'submit-faq-email' ) ) { return; }

		$params = array(
			'email_id' => $ewd_ufaq_controller->settings->get_setting( 'submit-faq-email' ),
			'email_address' => $faq->faq_author_email,
			'post_id' => $faq->ID
		);
		
		if ( function_exists( 'ewd_uwpm_send_email' ) ) {
			 
			ewd_uwpm_send_email( $params );
		}
	}
}
} // endif;

