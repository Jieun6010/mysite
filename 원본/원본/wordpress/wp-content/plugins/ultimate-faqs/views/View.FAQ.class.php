<?php

/**
 * Class to display a single FAQ on the front end.
 *
 * @since 2.0.0
 */
class ewdufaqViewFAQ extends ewdufaqView {

	public function __construct( $args ) {

		parent::__construct( $args );

		$this->set_variables();
	} 

	/**
	 * Render the view and enqueue required stylesheets
	 * @since 2.0.0
	 */
	public function render() {

		// Add any dependent stylesheets or javascript
		$this->enqueue_assets();

		$this->set_display_variables();

		// Add css classes to the slider
		$this->classes = $this->get_classes();

		ob_start();
		
		if ( ! empty( $this->single_post ) ) { $this->add_custom_styling(); }

		$template = $this->find_template( 'faq' );
		if ( $template ) {
			include( $template );
		}
		$output = ob_get_clean();

		return apply_filters( 'ewd_ufaq_faq_output', $output, $this );
	}

	/**
	 * Print the FAQ title
	 *
	 * @since 2.0.0
	 */
	public function print_faq_title() {
		
		$template = $this->find_template( 'faq-title' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print the FAQ preview, if any
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_faq_preview() {
		global $ewd_ufaq_controller;
		
		if ( ! strlen( $this->post->post_excerpt ) ) { return; }
		
		$template = $this->find_template( 'faq-preview' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print the custom fields, if enabled
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_element( $element ) {
		
		if ( $element == 'author_date' ) {

			$this->maybe_print_author_date(); 
		}
		elseif ( $element == 'body' ) {

			$this->print_faq_answer(); 
		}
		elseif ( $element == 'custom_fields' ) {

			$this->maybe_print_custom_fields(); 
		}
		elseif ( $element == 'categories' ) {

			$this->maybe_print_categories(); 
		}
		elseif ( $element == 'tags' ) {

			$this->maybe_print_tags(); 
		}
		elseif ( $element == 'ratings' ) {

			$this->maybe_print_ratings(); 
		}
		elseif ( $element == 'social_media' ) {

			$this->maybe_print_social_media(); 
		}
		elseif ( $element == 'permalink' ) {

			$this->maybe_print_permalink(); 
		}
		elseif ( $element == 'comments' ) {

			$this->maybe_print_comments(); 
		}
		elseif ( $element == 'back_to_top' ) {

			$this->maybe_print_back_to_top(); 
		}
	}

	/**
	 * Print the author/date container
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_author_date() {
		global $ewd_ufaq_controller;
		
		if ( ! $ewd_ufaq_controller->settings->get_setting( 'display-author' ) and ! $ewd_ufaq_controller->settings->get_setting( 'display-date' ) ) { return; }
		
		$template = $this->find_template( 'faq-author-date' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print the author if one is assigned
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_author() {
		global $ewd_ufaq_controller;
		
		if ( ! $ewd_ufaq_controller->settings->get_setting( 'display-author' ) or ! $this->faq_author ) { return; }
		
		$template = $this->find_template( 'faq-author' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print the author/date container
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_date() {
		global $ewd_ufaq_controller;
		
		if ( ! $ewd_ufaq_controller->settings->get_setting( 'display-date' ) or ! $this->date ) { return; }
		
		$template = $this->find_template( 'faq-date' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print the FAQ answer
	 *
	 * @since 2.0.0
	 */
	public function print_faq_answer() {
		
		$template = $this->find_template( 'faq-answer' );

		add_filter( 'wp_kses_allowed_html', array( $this, 'get_allowed_faq_content_tags' ) );
		
		if ( $template ) {
			include( $template );
		}

		remove_filter( 'wp_kses_allowed_html', array( $this, 'get_allowed_faq_content_tags' ) );
	}

	/**
	 * Print the custom fields, if enabled
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_custom_fields() {
		global $ewd_ufaq_controller;
		
		if ( empty( $ewd_ufaq_controller->settings->get_setting( 'faq-fields' ) ) ) { return; }
		
		$template = $this->find_template( 'faq-custom-fields' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print the categories, if enabled
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_categories() {
		global $ewd_ufaq_controller;
		
		if ( $ewd_ufaq_controller->settings->get_setting( 'hide-categories' ) or ! $this->categories ) { return; }
		
		$template = $this->find_template( 'faq-categories' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print the tags, if enabled
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_tags() {
		global $ewd_ufaq_controller;
		
		if ( $ewd_ufaq_controller->settings->get_setting( 'hide-tags' ) or ! $this->tags ) { return; }
		
		$template = $this->find_template( 'faq-tags' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print the ratings, if enabled
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_ratings() {
		global $ewd_ufaq_controller;
		
		if ( ! $ewd_ufaq_controller->settings->get_setting( 'faq-ratings' ) ) { return; }
		
		$template = $this->find_template( 'faq-ratings' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print the social media links, if enabled
	 *
	 * Extra checks included to make sure that this section doesn't
	 * display with an array that has only a blank element
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_social_media() {
		global $ewd_ufaq_controller;
		
		if ( empty( $ewd_ufaq_controller->settings->get_setting( 'social-media' ) ) ) { return; }

		if ( ! is_array( $ewd_ufaq_controller->settings->get_setting( 'social-media' ) ) ) { return; } 

		if ( sizeof( $ewd_ufaq_controller->settings->get_setting( 'social-media' ) ) == 1 and in_array( '', $ewd_ufaq_controller->settings->get_setting( 'social-media' ) ) ) { return; }
		
		$template = $this->find_template( 'faq-social-media' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print the permalink, if enabled
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_permalink() {
		global $ewd_ufaq_controller;
		
		if ( $ewd_ufaq_controller->settings->get_setting( 'include-permalink' ) == 'none' ) { return; }
		
		$template = $this->find_template( 'faq-permalink' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print the comments, if enabled
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_comments() {
		global $ewd_ufaq_controller;
		
		if ( $this->no_comments ) { return; }
		
		$comments = get_comments( array( 'post_id' => $this->post->ID ) );

		wp_list_comments( array(), $comments );

		comment_form( array(), $this->post->ID );
	}

	/**
	 * Print the 'Back to Top' link, if enabled
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_back_to_top() {
		global $ewd_ufaq_controller;
		
		if ( ! $ewd_ufaq_controller->settings->get_setting( 'display-back-to-top' ) ) { return; }
		
		$template = $this->find_template( 'faq-back-to-top' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print the selected social media buttons
	 *
	 * @since 2.0.0
	 */
	public function print_social_media_buttons() {
		global $ewd_ufaq_controller;
		
		if ( in_array( 'facebook', $ewd_ufaq_controller->settings->get_setting( 'social-media' ) ) ) { $this->print_facebook_button(); }
		if ( in_array( 'twitter', $ewd_ufaq_controller->settings->get_setting( 'social-media' ) ) ) { $this->print_twitter_button(); }
		if ( in_array( 'linkedin', $ewd_ufaq_controller->settings->get_setting( 'social-media' ) ) ) { $this->print_linkedin_button(); }
		if ( in_array( 'pinterest', $ewd_ufaq_controller->settings->get_setting( 'social-media' ) ) ) { $this->print_pinterest_button(); }
		if ( in_array( 'email', $ewd_ufaq_controller->settings->get_setting( 'social-media' ) ) ) { $this->print_email_button(); }
	}

	/**
	 * Print a link to share this FAQ on Facebook
	 *
	 * @since 2.0.0
	 */
	public function print_facebook_button() {
		
		$template = $this->find_template( 'faq-social-media-facebook' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print a link to share this FAQ on Twitter
	 *
	 * @since 2.0.0
	 */
	public function print_twitter_button() {
		
		$template = $this->find_template( 'faq-social-media-twitter' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print a link to share this FAQ on LinkedIn
	 *
	 * @since 2.0.0
	 */
	public function print_linkedin_button() {
		
		$template = $this->find_template( 'faq-social-media-linkedin' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print a link to share this FAQ on Pinterest
	 *
	 * @since 2.0.0
	 */
	public function print_pinterest_button() {
		
		$template = $this->find_template( 'faq-social-media-pinterest' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print a link to share this FAQ via email
	 *
	 * @since 2.0.0
	 */
	public function print_email_button() {
		
		$template = $this->find_template( 'faq-social-media-email' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Returns the unique ID for this FAQ
	 *
	 * @since 2.0.0
	 */
	public function get_id() {

  		return 'ewd-ufaq-post-' . $this->unique_id;
  	}

  	/**
	 * Returns the json_decoded elements order
	 *
	 * @since 2.0.0
	 */
	public function get_order_elements() {
		global $ewd_ufaq_controller;

		return is_array( $ewd_ufaq_controller->settings->get_setting( 'faq-elements-order' ) ) ? $ewd_ufaq_controller->settings->get_setting( 'faq-elements-order' ) : json_decode( $ewd_ufaq_controller->settings->get_setting( 'faq-elements-order' ) );
	}

  	/**
	 * Returns the class for the color block, if any
	 *
	 * @since 2.0.0
	 */
  	public function get_color_block_shape() {
  		global $ewd_ufaq_controller;

  		return 'ewd-ufaq-' . $ewd_ufaq_controller->settings->get_setting( 'color-block-shape' );
  	}

	/**
	 * Returns the selected toggle symbol
	 *
	 * @since 2.0.0
	 */
  	public function get_toggle_symbol() {
  		global $ewd_ufaq_controller;

  		return $this->display_all_answers ? $ewd_ufaq_controller->settings->get_setting( 'styling-toggle-symbol' ) : strtolower( $ewd_ufaq_controller->settings->get_setting( 'styling-toggle-symbol' ) );
  	}

  	/**
	 * Returns the permalink for the main anchor tag (either the FAQ permalink or #)
	 *
	 * @since 2.0.25
	 */
  	public function get_anchor_permalink() {
  		global $ewd_ufaq_controller;

  		return $ewd_ufaq_controller->settings->get_setting( 'disable-faq-toggle' ) ? get_permalink( $this->post->ID ) : '#';
  	}

  	/**
	 * Returns an array of the custom fields that exist for this site
	 *
	 * @since 2.0.0
	 */
  	public function get_custom_fields() {
  		global $ewd_ufaq_controller;

  		return ewd_ufaq_decode_infinite_table_setting( $ewd_ufaq_controller->settings->get_setting( 'faq-fields' ) );
  	}

	/**
	 * Returns the value for a given custom field
	 *
	 * @since 2.0.0
	 */
  	public function get_custom_field_value( $custom_field ) {

  		$value = get_post_meta( $this->post->ID, 'Custom_Field_' . $custom_field->id, true );

  		if ( $custom_field->type == 'file' ) {

  			return ! empty( $value ) ? '<a href="' . esc_attr( $value ) . '">' . strrpos( $value, '/' ) ? esc_html( substr( $value, strrpos( $value, '/' ) + 1 ) ) : esc_html( $value ) . '</a>' : '';
  		} 
		elseif ( $custom_field->type == 'link' ) {

			return ! empty( $value ) ? '<a href="' . esc_attr( $value ) . '" target="_blank">' . esc_attr( $value ) . '</a>' : '';
		} 
		else { return $value; }
	}

	/**
	 * Returns the category label, based on the label or number of category terms
	 *
	 * @since 2.0.0
	 */
  	public function get_categories_label() {
  		global $ewd_ufaq_controller;

  		return $ewd_ufaq_controller->settings->get_setting( 'label-categories' ) ? $ewd_ufaq_controller->settings->get_setting( 'label-categories' ) : ( sizeOf( $this->categories ) == 1 ? __( 'Category:', 'ultimate-faqs' ) : __( 'Categories:', 'ultimate-faqs' ) );
  	}

  	/**
	 * Returns a link with the name of a category
	 *
	 * @since 2.0.0
	 */
  	public function get_category_value( $category ) {
  		global $ewd_ufaq_controller;

  		$category_url = $ewd_ufaq_controller->settings->get_setting( 'pretty-permalinks' ) ? $this->current_url . 'faq-category/' . urlencode( $category->slug ) . '/' : add_query_arg( 'include_category', urlencode( $category->slug ), $this->current_url );

  		return empty( $ewd_ufaq_controller->single_page_print ) ? '<a href="' . esc_attr( $category_url ) . '">' . esc_html( $category->name ) . '</a>' : esc_html( $category->name );
  	}

  	/**
	 * Returns the tag label, based on the label or number of tag terms
	 *
	 * @since 2.0.0
	 */
  	public function get_tags_label() {
  		global $ewd_ufaq_controller;

  		return $ewd_ufaq_controller->settings->get_setting( 'label-tags' ) ? $ewd_ufaq_controller->settings->get_setting( 'label-tags' ) : ( sizeOf( $this->tags ) == 1 ? __( 'Tag:', 'ultimate-faqs' ) : __( 'Tags:', 'ultimate-faqs' ) );
  	}

  	/**
	 * Returns a link with the name of a tag
	 *
	 * @since 2.0.0
	 */
  	public function get_tag_value( $tag ) {
  		global $ewd_ufaq_controller;

  		$tag_url = $ewd_ufaq_controller->settings->get_setting( 'pretty-permalinks' ) ? $this->current_url . 'faq-tag/' . urlencode( $tag->slug ) . '/' : add_query_arg( 'include_tag', urlencode( $tag->slug ), $this->current_url );

  		return empty( $ewd_ufaq_controller->single_page_print ) ? '<a href="' . esc_attr( $tag_url ) . '">' . esc_html( $tag->name ) . '</a>' : esc_html( $tag->name );
  	}

	/**
	 * Returns an image with a custom thumbs up rating image, or the default one if unavailable
	 *
	 * @since 2.0.0
	 */
  	public function get_thumbs_up_image() {
  		global $ewd_ufaq_controller;

  		$img_url = ( $ewd_ufaq_controller->settings->get_setting( 'thumbs-up-image' ) and $ewd_ufaq_controller->settings->get_setting( 'thumbs-up-image' ) != 'http://' ) ? $ewd_ufaq_controller->settings->get_setting( 'thumbs-up-image' ) : EWD_UFAQ_PLUGIN_URL . '/assets/img/Thumbs-up-icon.png';

  		return '<img src="' . esc_url( $img_url ) . '" />';
  	}

  	/**
	 * Returns the positive vote count
	 *
	 * @since 2.0.0
	 */
  	public function get_up_votes() {

  		return get_post_meta( $this->post->ID, "FAQ_Up_Votes", true ) ? get_post_meta( $this->post->ID, "FAQ_Up_Votes", true ) : 0;
  	}

  	/**
	 * Returns an image with a custom thumbs down rating image, or the default one if unavailable
	 *
	 * @since 2.0.0
	 */
  	public function get_thumbs_down_image() {
  		global $ewd_ufaq_controller;

  		$img_url = ( $ewd_ufaq_controller->settings->get_setting( 'thumbs-down-image' ) and $ewd_ufaq_controller->settings->get_setting( 'thumbs-down-image' ) != 'http://' ) ? $ewd_ufaq_controller->settings->get_setting( 'thumbs-down-image' ) : EWD_UFAQ_PLUGIN_URL . '/assets/img/Thumbs-down-icon.png';

  		return '<img src="' . esc_url( $img_url ) . '" />';
  	}

  	/**
	 * Returns the negative vote count
	 *
	 * @since 2.0.0
	 */
  	public function get_down_votes() {

  		return get_post_meta( $this->post->ID, "FAQ_Down_Votes", true ) ? get_post_meta( $this->post->ID, "FAQ_Down_Votes", true ) : 0;
  	}

	/**
	 * Returns a link to this FAQ for Twitter
	 *
	 * @since 2.0.0
	 */
  	public function get_social_twitter_link() {

  		$text = __( 'Check out this helpful FAQ', 'ultimate-faqs' ) . ': ';

  		return 'https://twitter.com/intent/tweet?text=' . urlencode( $text ) . urlencode( $this->post->post_title ) . urlencode( ' | ' ) . urlencode( $this->permalink );
  	}

	/**
	 * Returns a link to this FAQ for LinkedIn
	 *
	 * @since 2.0.0
	 */
  	public function get_social_linkedin_link() {

  		$text = __( 'Check out this helpful FAQ', 'ultimate-faqs' );

  		return 'http://www.linkedin.com/shareArticle?mini=true&amp;url=' . $this->permalink . "&amp;title=" . urlencode( $text ) . "&amp;summary=" . urlencode( $this->post->post_title );
  	}

	/**
	 * Returns a link to this FAQ for Pinterest
	 *
	 * @since 2.0.0
	 */
  	public function get_social_pinterest_link() {

  		$text = __( 'Check out this helpful FAQ', 'ultimate-faqs' ) . ': ';

  		return 'http://pinterest.com/pin/create/button/?url=' . $this->permalink . "&amp;description=" . urlencode( $text ) . urlencode( $this->post->post_title );
  	}

	/**
	 * Returns a link to this FAQ that can be emailed
	 *
	 * @since 2.0.0
	 */
  	public function get_social_email_mailto_link() {

  		$subject = __( 'Check out this helpful FAQ', 'ultimate-faqs' );

  		return 'mailto:?subject=' . urlencode( $subject ) . "&amp;body=" . urlencode( $this->post->post_title ) . urlencode( ' | ' ) . urlencode( $this->permalink );
  	}

	/**
	* Get the initial submit faq css classes
	* @since 2.1.6
	*/
	public function get_allowed_faq_content_tags( $tags ) {

		$tags['iframe'] = array(
			'src'				=> true,
			'height'			=> true,
			'width'				=> true,
			'frameborder'		=> true,
			'allowfullscreen'	=> true,
		);

		return apply_filters( 'ewd_ufaq_kses_allowed_html', $tags );
	}

	/**
	 * Get the initial submit faq css classes
	 * @since 2.0.0
	 */
	public function get_classes( $classes = array() ) {
		global $ewd_ufaq_controller;

		$classes = array_merge(
			$classes,
			array(
				'ewd-ufaq-faq-div',
				'ewd-ufaq-faq-column-count-' . $ewd_ufaq_controller->settings->get_setting( 'number-of-columns' ),
				'ewd-ufaq-faq-responsive-columns-' . $ewd_ufaq_controller->settings->get_setting( 'responsive-columns' ),
				'ewd-ufaq-faq-display-style-' . $ewd_ufaq_controller->settings->get_setting( 'display-style' ),
			)
		);

		if ( empty( $ewd_ufaq_controller->settings->get_setting( 'disable-faq-toggle' ) ) ) {
			$classes[] = 'ewd-ufaq-can-be-toggled';
		}

		return apply_filters( 'ewd_ufaq_faq_classes', $classes, $this );
	}


	/**
	 * Set any neccessary variables when the FAQ is created
	 * @since 2.0.0
	 */
	public function set_variables() {
		global $ewd_ufaq_controller;

		$this->categories = get_the_terms( $this->post->ID, EWD_UFAQ_FAQ_CATEGORY_TAXONOMY );
		$this->categories = is_array ( $this->categories ) ? $this->categories : array();
		$this->tags = get_the_terms( $this->post->ID, EWD_UFAQ_FAQ_TAG_TAXONOMY );
		$this->tags = is_array ( $this->tags ) ? $this->tags : array();
		
		$this->no_comments = ! empty( $this->no_comments ) ? $this->no_comments : ! $ewd_ufaq_controller->settings->get_setting( 'comments-on' );
		$this->display_all_answers = ! empty( $this->display_all_answers ) ? $this->display_all_answers : $ewd_ufaq_controller->settings->get_setting( 'display-all-answers' );

		$this->current_url = ! empty( $this->current_url ) ? $this->current_url : get_permalink();

		$this->add_faq_permalink();

		if ( ! empty( $this->single_post ) ) { $this->display_all_answers = true; }
	}

	/**
	 * Set any neccessary variables before displaying the FAQ
	 * @since 2.0.0
	 */
	public function set_display_variables() {
		global $post;
		global $ewd_ufaq_controller;
		
		// Added in to get another f$*!ing page builder to work correctly
		$post = get_post( $this->post->ID );

		add_filter( 'siteorigin_panels_filter_content_enabled', array( $this, 'disable_site_origin_page_builder' ) );

		$this->unique_id = $this->post->ID . '-' . ewd_random_string();
		$this->faq_title = apply_filters( 'the_title', $this->post->post_title, $this->post->ID );
		$this->faq_answer = apply_filters( 'the_content', html_entity_decode( $this->post->post_content ) );
		$this->faq_preview = apply_filters( 'the_content', html_entity_decode( $this->post->post_excerpt ) );
		$this->faq_author = get_post_meta( $this->post->ID, 'EWD_UFAQ_Post_Author', true);
		$this->date = get_the_date( '', $this->post->ID );
		
		if ( ! empty( $this->search_string ) and $ewd_ufaq_controller->settings->get_setting( 'highlight-search-term' ) ) {

			$this->faq_title = preg_replace( '/\b(' . $this->search_string . ')\b/i', '<span class="ewd-ufaq-highlight-search-term">$0</span>', $this->faq_title );
			$this->faq_answer = preg_replace( '/\b(' . $this->search_string . ')\b/i', '<span class="ewd-ufaq-highlight-search-term">$0</span>', $this->faq_answer );
		}

		remove_filter( 'siteorigin_panels_filter_content_enabled', array( $this, 'disable_site_origin_page_builder' ) );

		wp_reset_postdata();
	}

	/**
	 * Builds the display permalink for the current FAQ, based on selected settings
	 * @since 2.0.0
	 */
	public function add_faq_permalink() {
		global $ewd_ufaq_controller;

		if ( $ewd_ufaq_controller->settings->get_setting( 'permalink-type' ) == 'individual_page' or ! empty( $this->is_search ) ) {

			$this->permalink =  get_permalink( $this->post->ID );

			return;
		}

		if ( $ewd_ufaq_controller->settings->get_setting( 'pretty-permalinks' ) ) {

			$this->permalink =  get_permalink() . 'single-faq/' . $this->post->post_name . '/';

			return;
		} 

		$this->permalink = add_query_arg( 'Display_FAQ', $this->post->ID, ( ! empty( $this->current_url ) ? $this->current_url : get_permalink() ) );
	}

	/**
	 * Ridiculous workaround for Site Origin Page Builder. Can remove once (hopefully)
	 * it is less prevalent
	 * @since 2.0.0
	 */
	public function disable_site_origin_page_builder( $bool ) {

		return false;
	}

	/**
	 * Enqueue the necessary CSS and JS files
	 * @since 2.0.0
	 */
	public function enqueue_assets() {
		
		wp_enqueue_style( 'ewd-ufaq-rrssb' );
		wp_enqueue_style( 'ewd-ufaq-jquery-ui' );
		wp_enqueue_style( 'ewd-ufaq-css' );

		wp_enqueue_style( 'ewd-ufaq-rrssb' );
		wp_enqueue_style( 'ewd-ufaq-jquery-ui' );

		wp_enqueue_script( 'ewd-ufaq-js' );

	}
}
