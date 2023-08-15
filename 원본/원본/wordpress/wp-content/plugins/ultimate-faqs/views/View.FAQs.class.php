<?php

/**
 * Class to display multiple FAQs on the front end.
 *
 * @since 2.0.0
 */
class ewdufaqViewFAQs extends ewdufaqView {

	// Array containing all of the FAQs that could be displayed
	public $faqs = array();

	// Array containing all of the FAQs that were displayed
	public $displayed_faqs = array();

	// Array containing all of the titles for the FAQs being displayed
	public $questions = array();

	// An multi-dimensional array containing the different categories, with their FAQs in sub-arrays
	public $category_faqs = array();

	// Array containing IDs of categories to display, empty if all should be displayed
	public $include_categories = array();

	// Array containing IDs of categories to not display, empty if all should be displayed
	public $exclude_categories = array();

	public $show_on_load = '';

	/**
	 * Define the the FAQs to be used
	 *
	 * @since 2.0.0
	 */
	public function set_faqs( $faqs ) {
		global $ewd_ufaq_controller;
		
		$this->display_all_answers = sizeOf( $faqs ) == 1 ? true : $this->display_all_answers;
		
		// Set the group_by_category property based on the shortcode attribute, default to the setting's value
		$this->group_by_category = ! empty( $this->group_by_category ) ? ( strtolower( $this->group_by_category ) == 'yes' ? true : false ) : $ewd_ufaq_controller->settings->get_setting( 'group-by-category' );
		
		// Override the group by category setting if there's only a single FAQ being displayed
		$this->group_by_category = sizeOf( $faqs ) == 1 ? false : $this->group_by_category;

		foreach ( $faqs as $faq ) {
			
			if ( get_class( $faq ) != 'ewdufaqFAQ' ) { continue; }

			$faq->is_search = ! empty( $this->is_search ) ? true : false;
			$faq->search_string = ! empty( $this->search_string ) ? $this->search_string : '';
			
			$faq_view = new ewdufaqViewFAQ( $faq );

			$this->faqs[] = $faq_view;
		}
	}

	/**
	 * Render the view and enqueue required stylesheets
	 * @since 2.0.0
	 */
	public function render() {
		global $ewd_ufaq_controller;

		$this->set_faqs_options();

		$this->create_faq_data();

		$this->set_faq_properties();

		$this->add_schema_data();

		// Add any dependent stylesheets or javascript
		$this->enqueue_assets();

		// Add css classes to the slider
		$this->classes = $this->get_classes();

		ob_start();
		$this->add_custom_styling();
		$template = $this->find_template( 'faqs' );
		if ( $template ) {
			include( $template );
		}
		$output = ob_get_clean();

		if ( $ewd_ufaq_controller->settings->get_setting( 'display-style' ) == 'list' ){

			$output = $this->replace_list_header( $output );
		}

		return apply_filters( 'ewd_ufaq_faqs_output', $output, $this );
	}

	/**
	 * Print the FAQ shortcode arguments needed for AJAX updating
	 *
	 * @since 2.0.0
	 */
	public function print_shortcode_args() {
		
		$template = $this->find_template( 'faqs-shortcode-args' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Print the FAQ expand/collapse all, if any enabled
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_expand_collapse_all() {
		global $ewd_ufaq_controller;
		
		if ( ! $ewd_ufaq_controller->settings->get_setting( 'expand-collapse-all' ) ) { return; }

		if ( sizeOf( $this->faqs ) == 1 ) { return; }
		
		$template = $this->find_template( 'faqs-expand-collapse-all' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Adds in the FAQ list header placeholder, if enabled, to be replaced later
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_header() {
		global $ewd_ufaq_controller;
		
		if ( $ewd_ufaq_controller->settings->get_setting( 'display-style' ) != 'list' ) { return; }
		
		echo '%list_header_placeholder%';
	}

	/**
	 * Print the FAQs
	 *
	 * @since 2.0.0
	 */
	public function print_faqs() {

		if ( $this->group_by_category ) { $this->print_faqs_by_category(); }
		else { $this->print_faqs_individually(); }
	}

	/**
	 * Print FAQs grouped by category
	 *
	 * @since 2.0.0
	 */
	public function print_faqs_by_category() {

		$faq_count = 0;

		foreach ( $this->category_faqs as $term_id => $category_faqs ) {
			
			if ( ! empty( $this->include_categories ) and ! in_array( $term_id, $this->include_categories ) ) { continue; }
		
			if ( $faq_count < $this->faqs_per_page * ( $this->faq_page - 1 ) ) { 

				$faq_count += sizeof( $category_faqs );

				continue;
			}

			if ( $faq_count >= $this->faqs_per_page * ( $this->faq_page ) ) { continue; }
			
			$this->current_category = get_term( $term_id );

			$this->open_category_header();

			foreach ( $category_faqs as $faq ) {

				$this->faq_count = $faq_count;

				$this->displayed_faqs[] = $faq->post->ID;

				echo $faq->render();

				$faq_count++;
			}

			$this->close_categories_container();
		}
	}

	/**
	 * Print FAQs individually (not grouped by category)
	 *
	 * @since 2.0.0
	 */
	public function print_faqs_individually() {

		foreach ( $this->faqs as $faq_count => $faq ) {
			if ( $this->faqs_per_page > 0 && ($faq_count < $this->faqs_per_page * ( $this->faq_page - 1) or $faq_count >= $this->faqs_per_page * ( $this->faq_page ) ) ) { continue; }
			
			$this->faq_count = $faq_count;

			$this->displayed_faqs[] = $faq->post->ID;
			
			echo $faq->render();
		}
	}

	/**
	 * Print the category header for a particular category and opens the category container
	 *
	 * @since 2.0.0
	 */
	public function open_category_header() {
		global $ewd_ufaq_controller;
		
		if ( ! empty( $this->faqs_container_open ) ) { return; }

		$this->faqs_container_open = true;
		
		$template = $this->find_template( 'faqs-category-header' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Closes the inner category container that contains individual FAQs
	 *
	 * @since 2.0.0
	 */
	public function close_categories_container() {

		if ( empty( $this->faqs_container_open ) ) { return; }

		$this->faqs_container_open = false;

		$template = $this->find_template( 'faqs-category-footer' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Adds in pagination controls, if necessary
	 *
	 * @since 2.0.0
	 */
	public function maybe_print_pagination() {

		if ( $this->max_page <= 1 ) { return; }

		$template = $this->find_template( 'faqs-pagination' );
		
		if ( $template ) {
			include( $template );
		}
	}

	/**
	 * Replace the list header placeholder with the FAQ list
	 *
	 * @since 2.0.0
	 */
	public function replace_list_header( $output ) {

		if ( $this->group_by_category ) { $template = $this->find_template( 'faqs-category-list-header' ); }
		else { $template = $this->find_template( 'faqs-list-header' ); }
		
		ob_start();

		if ( $template ) {
			include( $template );
		}

		$list_header = ob_get_clean();

		return str_replace( '%list_header_placeholder%', $list_header, $output );
	}

	/**
	 * Get the name of the current category, if set
	 *
	 * @since 2.0.0
	 */
  	public function get_category_name() {

  		return ! empty( $this->current_category ) ? $this->current_category->name : '';
  	}

  	/**
	 * Get the slug of the current category, if set
	 *
	 * @since 2.0.0
	 */
  	public function get_category_slug() {

  		return ! empty( $this->current_category ) ? $this->current_category->slug : '';
  	}

	/**
	 * Get the number of FAQs in the current category, if set
	 *
	 * @since 2.0.0
	 */
  	public function get_category_count() {

  		return ( ! empty( $this->current_category ) and ! empty( $this->category_faqs[ $this->current_category->term_id ] ) ) ? sizeof( $this->category_faqs[ $this->current_category->term_id ] ) : 0;
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
				'ewd-ufaq-faq-list',
				'ewd-ufaq-page-type-' . $ewd_ufaq_controller->settings->get_setting( 'page-type' ),
			)
		);

		if ( $this->category_accordion ) {
			$classes[] = 'ewd-ufaq-faq-category-title-accordion';
		}

		return apply_filters( 'ewd_ufaq_faqs_classes', $classes, $this );
	}

	/**
	 * Allow some parameters to be overwritten with URL parameters, to link to specific FAQ sets
	 * @since 2.0.0
	 */
	public function set_request_parameters() {

		if ( ! empty( $_REQUEST['faq_page'] ) ) { $this->faq_page = intval( $_REQUEST['faq_page'] ); }
		if ( ! empty( $_REQUEST['current_url'] ) ) { $this->current_url = sanitize_text_field( $_REQUEST['current_url'] ); }
	}

	/**
	 * Returns all of the titles for the matching FAQs
	 * @since 2.0.0
	 */
	public function get_faq_titles() {

		$titles = array();

		foreach ( $this->faqs as $faq ) { $titles[] = $faq->post->post_title; }

		return $titles;
	}

	/**
	 * Sets properties that need to be individually set
	 * @since 2.0.0
	 */
	public function set_faq_properties() {

		foreach ( $this->faqs as $faq ) {

			$faq->display_all_answers = $this->display_all_answers;
			$faq->no_comments = $this->no_comments;
			$faq->current_url = $this->current_url;

			$faq->add_faq_permalink();
		}
	}

	/**
	 * Create pagination data and put FAQs into their categories, if necessary
	 * @since 2.0.0
	 */
	public function create_faq_data() {
		global $ewd_ufaq_controller;

		$this->faq_count = count( $this->faqs );
		$this->max_page = ceil( $this->faq_count / $this->faqs_per_page );

		if ( ! $this->group_by_category and $ewd_ufaq_controller->settings->get_setting( 'display-style' ) != 'list' ) { return; }

		$args = array(
			'taxonomy'		=> EWD_UFAQ_FAQ_CATEGORY_TAXONOMY,
			'orderby'		=> $this->category_orderby,
			'order'			=> $this->category_order,
			'hide_empty'	=> false
		);

		$categories = get_terms( $args ); 

		foreach ( $categories as $category ) {

			foreach( $this->faqs as $faq ) {

				if ( in_array( $category, $faq->categories ) ) {

					if ( ! $this->faq_not_in_category( $category->term_id, $faq ) ) { $this->category_faqs[ $category->term_id ][] = $faq; }
				}
				elseif ( $this->include_category_children ) { 
				
					$this->check_child_faq_categories( $category, $faq, get_term_children( $category->term_id, EWD_UFAQ_FAQ_CATEGORY_TAXONOMY ) );
				}
			}
		}
	}

	/**
	 * Recursively checks for matching child FAQs, if enabled
	 *
	 * @since 2.0.0
	 */
	public function check_child_faq_categories( $category, $faq, $child_term_ids ) {

		foreach ( $child_term_ids as $child_term_id ) { 

			$child_category = get_term( $child_term_id, EWD_UFAQ_FAQ_CATEGORY_TAXONOMY );

			if ( in_array( $child_category, $faq->categories ) ) { 

				if ( ! $this->faq_not_in_category( $category->term_id, $faq ) ) { $this->category_faqs[ $category->term_id ][] = $faq; }
			}

			$this->check_child_faq_categories( $category, $faq, get_term_children( $child_category->term_id, EWD_UFAQ_FAQ_CATEGORY_TAXONOMY ) );
		}
	}

	/**
	 * Determines whether an FAQ is already included in a category or not
	 *
	 * @since 2.0.0
	 */
	public function faq_not_in_category( $term_id, $faq ) {

		if ( empty( $this->category_faqs[ $term_id ] ) ) { return false; }

		foreach ( $this->category_faqs[ $term_id ] as $category_faq ) {

			if ( $category_faq->post->ID == $faq->post->ID ) { return true; }
		}

		return false;
	}

	/**
	 * Add in default options if not overwritten by shortcode attributes
	 *
	 * @since 2.0.0
	 */
	public function set_faqs_options() {
		global $ewd_ufaq_controller;
		
		$this->current_url = !empty( $this->current_url ) ? $this->current_url : get_permalink();
		
		$this->category_order = empty( $this->category_order ) ? $ewd_ufaq_controller->settings->get_setting( 'category-order' ) : $this->category_order;
		$this->category_orderby = empty( $this->category_orderby ) ? $ewd_ufaq_controller->settings->get_setting( 'category-order-by' ) : $this->category_orderby;
		$this->faqs_per_page = empty( $this->faqs_per_page ) ? $ewd_ufaq_controller->settings->get_setting( 'faqs-per-page' ) : $this->faqs_per_page;
		
		$this->no_comments = ! empty( $this->no_comments ) ? $this->no_comments : ! $ewd_ufaq_controller->settings->get_setting( 'comments-on' );
		$this->display_all_answers = ! empty( $this->display_all_answers ) ? $this->display_all_answers : $ewd_ufaq_controller->settings->get_setting( 'display-all-answers' );
		$this->include_category_children =  ( ! empty( $this->include_category_children ) and strtolower( $this->include_category_children ) == 'yes' ) ? true : false;

		$this->category_accordion = empty( $this->category_accordion ) ? $ewd_ufaq_controller->settings->get_setting( 'faq-category-accordion' ) : ( strtolower( $this->category_accordion ) == 'yes' ? true : false );
		$this->faq_accordion = empty( $this->faq_accordion ) ? $ewd_ufaq_controller->settings->get_setting( 'faq-accordion' ) : ( strtolower( $this->faq_accordion ) == 'yes' ? true : false );

		$this->include_categories = ! empty( $this->include_category_ids ) ? explode( ',', $this->include_category_ids ) : array();

		$include_category_slugs = ! empty( $this->include_category ) ? explode( ',', $this->include_category ) : array();
		foreach ( $include_category_slugs as $include_category ) { 

			$category = get_term_by( 'slug', $include_category, EWD_UFAQ_FAQ_CATEGORY_TAXONOMY );

			if ( $category ) { $this->include_categories[] = $category->term_id; }
		}

		$this->include_categories = array_filter( $this->include_categories );

		//allow settings to be filtered if necessary
		$this->display_all_answers = apply_filters( 'ewd_ufaq_display_all_answers', $this->display_all_answers, $this );
		$this->group_by_category = apply_filters( 'ewd_ufaq_group_by_category', $this->group_by_category, $this );
	}

	/**
	 * Enqueue the necessary CSS and JS files
	 * @since 2.0.0
	 */
	public function enqueue_assets() {
		global $ewd_ufaq_controller, $wp_scripts;

		wp_enqueue_style( 'ewd-ufaq-rrssb' );
		wp_enqueue_style( 'ewd-ufaq-jquery-ui' );
		wp_enqueue_style( 'ewd-ufaq-css' );

		wp_enqueue_style( 'ewd-ufaq-rrssb' );
		wp_enqueue_style( 'ewd-ufaq-jquery-ui' );

		$handle = 'ewd-ufaq-js';
		$args = array(
			'faq_accordion'      => isset( $this->faq_accordion ) ? $this->faq_accordion : $ewd_ufaq_controller->settings->get_setting( 'faq-accordion' ),
			'category_accordion' => isset( $this->category_accordion ) ? $this->category_accordion : $ewd_ufaq_controller->settings->get_setting( 'faq-category-accordion' ),
			'faq_scroll'         => $ewd_ufaq_controller->settings->get_setting( 'scroll-to-top' ),
			'reveal_effect'      => $ewd_ufaq_controller->settings->get_setting( 'reveal-effect' ),
			'retrieving_results' => $ewd_ufaq_controller->settings->get_setting( 'label-retrieving-results' ),
			'highlight_search_term' => $ewd_ufaq_controller->settings->get_setting( 'highlight-search-term' ),
			'autocomplete_question' => $ewd_ufaq_controller->settings->get_setting( 'auto-complete-titles' ),
			'question_titles' => $this->get_faq_titles(),
			'display_faq'     => 0,
			'nonce'           => wp_create_nonce( $handle ),
		);

		if ( ! empty( get_query_var( 'single_faq' ) ) ) {

			$faq = get_page_by_path( get_query_var( 'single_faq' ), OBJECT, EWD_UFAQ_FAQ_POST_TYPE );
			$args['display_faq'] = $faq->ID;
		}
		elseif ( isset( $_GET['Display_FAQ'] ) ) {
			$args['display_faq'] = intval( $_GET['Display_FAQ'] );
		}

		// Fetch any existing script data
		$prev_question_titles = $ewd_ufaq_controller->get_front_end_php_data( $handle, 'question_titles' );

		if ( ! empty( $prev_question_titles ) ) {
			$args['question_titles'] = array_merge( $prev_question_titles, $args['question_titles'] );
			$args['question_titles'] = array_unique( $args['question_titles'] );
		}

		$ewd_ufaq_controller->add_front_end_php_data( $handle, 'question_titles', $args['question_titles'] );

		wp_enqueue_script( $handle );

		$ewd_ufaq_controller->add_front_end_php_data( $handle, 'ewd_ufaq_php_data', apply_filters( 'ewd_ufaq_js_localize_data', $args ) );

		wp_enqueue_script( 'jquery-ui-core' );

		if ( $ewd_ufaq_controller->settings->get_setting( 'auto-complete-titles' ) ) {

			wp_enqueue_script( 'jquery-ui-autocomplete' );
		}

		if ( $ewd_ufaq_controller->settings->get_setting( 'reveal-effect' ) != 'none' ) {

			wp_enqueue_script( 'jquery-effects-core' );
			wp_enqueue_script( 'jquery-ui-autocomplete' );

			if ( $ewd_ufaq_controller->settings->get_setting( 'reveal-effect' ) == 'blind' ) { wp_enqueue_script( 'jquery-effects-blind' ); }
			if ( $ewd_ufaq_controller->settings->get_setting( 'reveal-effect' ) == 'bounce' ) { wp_enqueue_script( 'jquery-effects-bounce' ); }
			if ( $ewd_ufaq_controller->settings->get_setting( 'reveal-effect' ) == 'clip' ) { wp_enqueue_script( 'jquery-effects-clip' ); }
			if ( $ewd_ufaq_controller->settings->get_setting( 'reveal-effect' ) == 'drop' ) { wp_enqueue_script( 'jquery-effects-drop' ); }
			if ( $ewd_ufaq_controller->settings->get_setting( 'reveal-effect' ) == 'explode' ) { wp_enqueue_script( 'jquery-effects-explode' ); }
			if ( $ewd_ufaq_controller->settings->get_setting( 'reveal-effect' ) == 'fade' ) { wp_enqueue_script( 'jquery-effects-fade' ); }
			if ( $ewd_ufaq_controller->settings->get_setting( 'reveal-effect' ) == 'fold' ) { wp_enqueue_script( 'jquery-effects-fold' ); }
			if ( $ewd_ufaq_controller->settings->get_setting( 'reveal-effect' ) == 'highlight' ) { wp_enqueue_script( 'jquery-effects-highlight' ); }
			if ( $ewd_ufaq_controller->settings->get_setting( 'reveal-effect' ) == 'pulsate' ) { wp_enqueue_script( 'jquery-effects-pulsate' ); }
			if ( $ewd_ufaq_controller->settings->get_setting( 'reveal-effect' ) == 'shake' ) { wp_enqueue_script( 'jquery-effects-shake' ); }
			if ( $ewd_ufaq_controller->settings->get_setting( 'reveal-effect' ) == 'slide' ) { wp_enqueue_script( 'jquery-effects-slide' ); }
		}

	}
}
