<?php
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'ewdufaqSettings' ) ) {
/**
 * Class to handle configurable settings for Ultimate FAQs
 * @since 2.0.0
 */
class ewdufaqSettings {

	/**
	 * Default values for settings
	 * @since 2.0.0
	 */
	public $defaults = array();

	/**
	 * Stored values for settings
	 * @since 2.0.0
	 */
	public $settings = array();

	public function __construct() {

		add_action( 'init', array( $this, 'set_defaults' ) );

		add_action( 'init', array( $this, 'load_settings_panel' ), 11 );
	}

	/**
	 * Load the plugin's default settings
	 * @since 2.0.0
	 */
	public function set_defaults() {

		$this->defaults = array(

			'include-permalink' => 'none',
			'permalink-type'    => 'same_page',
			'access-role'       => 'manage_options',
			'category-order'    => 'asc',
			'faq-order-by'      => 'title',
			'faq-order'         => 'asc',

			'display-style'      => 'default',
			'slug-base'          => 'ufaqs',
			'number-of-columns'  => 'one',
			'faqs-per-page'      => 100000,
			'page-type'          => 'distinct',
			'faq-elements-order' => json_encode( 
				array(
					'categories'    => 'Categories',
					'body'          => 'Body',
					'author_date'   => 'Author/Date',
					'custom_fields' => 'Custom Fields',
					'tags'          => 'Tags',
					'ratings'       => 'Ratings',
					'social_media'  => 'Social Media',
					'permalink'     => 'Permalink',
					'comments'      => 'Comments',
					'back_to_top'   => 'Back to Top',
				)
			),

			'wpforms-faq-location' 				=> 'above',
			'wpforms-minimum-characters' 	=> 12,

			'faq-fields' => array(),

			'styling-toggle-symbol'         => 'A',
			'styling-category-heading-type' => 'h3',
			'styling-faq-heading-type'      => 'h4',

			'label-retrieving-results' 				=> __( 'Retrieving Results', 'ultimate-faqs' ),
			'label-no-results-found'   				=> __( 'No result FAQ\'s contained the term \'%s\'', 'ultimate-faqs' ),
			'label-woocommerce-tab'    				=> __( 'FAQs', 'ultimate-faqs' ),
			'label-captcha-empty'    					=> __( 'Please fill out the image number field.', 'ultimate-faqs' ),
			'label-captcha-incorrect'    			=> __( 'The number you entered for the image was incorrect.', 'ultimate-faqs' ),
			'label-no-question-title-entered' => __( 'Please make sure that there is a question that you are submitting as an FAQ.', 'ultimate-faqs' ),
			'label-thank-you-submit'   				=> __( 'Thank you for submitting an FAQ.', 'ultimate-faqs' ),
		);

		$this->defaults = apply_filters( 'ewd_ufaq_defaults', $this->defaults, $this );
	}

	/**
	 * Get a setting's value or fallback to a default if one exists
	 * @since 2.0.0
	 */
	public function get_setting( $setting ) { 

		if ( empty( $this->settings ) ) {
			$this->settings = get_option( 'ewd-ufaq-settings' );
		}
		
		if ( ! empty( $this->settings[ $setting ] ) ) {
			return apply_filters( 'ewd-ufaq-settings-' . $setting, $this->settings[ $setting ] );
		}

		if ( ! empty( $this->defaults[ $setting ] ) ) { 
			return apply_filters( 'ewd-ufaq-settings-' . $setting, $this->defaults[ $setting ] );
		}

		return apply_filters( 'ewd-ufaq-settings-' . $setting, null );
	}

	/**
	 * Set a setting to a particular value
	 * @since 2.0.0
	 */
	public function set_setting( $setting, $value ) {

		$this->settings[ $setting ] = $value;
	}

	/**
	 * Save all settings, to be used with set_setting
	 * @since 2.0.0
	 */
	public function save_settings() {
		
		update_option( 'ewd-ufaq-settings', $this->settings );
	}

	/**
	 * Load the admin settings page
	 * @since 2.0.0
	 * @sa https://github.com/NateWr/simple-admin-pages
	 */
	public function load_settings_panel() {

		global $ewd_ufaq_controller;

		require_once( EWD_UFAQ_PLUGIN_DIR . '/lib/simple-admin-pages/simple-admin-pages.php' );
		$sap = sap_initialize_library(
			$args = array(
				'version' => '2.6.13',
				'lib_url' => EWD_UFAQ_PLUGIN_URL . '/lib/simple-admin-pages/',
				'theme'   => 'purple',
			)
		);
		
		$sap->add_page(
			'submenu',
			array(
				'id'            => 'ewd-ufaq-settings',
				'title'         => __( 'Settings', 'ultimate-faqs' ),
				'menu_title'    => __( 'Settings', 'ultimate-faqs' ),
				'parent_menu'	=> 'edit.php?post_type=ufaq',
				'description'   => '',
				'capability'    => $this->get_setting( 'access-role' ),
				'default_tab'   => 'ewd-ufaq-basic-tab',
			)
		);

		$sap->add_section(
			'ewd-ufaq-settings',
			array(
				'id'            	=> 'ewd-ufaq-basic-tab',
				'title'         	=> __( 'Basic', 'ultimate-faqs' ),
				'is_tab'			=> true,
				'tutorial_yt_id'	=> 'MUuFQxywjsA'
			)
		);

		$sap->add_section(
			'ewd-ufaq-settings',
			array(
				'id'            => 'ewd-ufaq-general',
				'title'         => __( 'General', 'ultimate-faqs' ),
				'tab'	        => 'ewd-ufaq-basic-tab',
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-general',
			'post',
			array(
				'id'            => 'faq-page',
				'title'         => __( 'FAQs Page', 'ultimate-faqs' ),
				'description'   => __( 'Select a page on your site to automatically display all of the FAQs you have created. Alternatively, you can also use the blocks and shortcodes to display your FAQs on pages other than the one selected above.', 'ultimate-faqs' ),
				'blank_option'	=> true,
				'args'					=> array(
					'post_type' 			=> 'page',
					'posts_per_page'	=> -1,
					'post_status'			=> 'publish',
					'orderby'					=> 'title',
					'order'						=> 'ASC',
				),
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-general',
			'textarea',
			array(
				'id'			=> 'custom-css',
				'title'			=> __( 'Custom CSS', 'ultimate-faqs' ),
				'description'	=> __( 'You can add custom CSS styles to your FAQs in the box above.', 'ultimate-faqs' ),			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-general',
			'toggle',
			array(
				'id'			=> 'scroll-to-top',
				'title'			=> __( 'Scroll To Top', 'ultimate-faqs' ),
				'description'	=> __( 'Should the browser scroll to the top of the FAQ when it\'s opened?', 'ultimate-faqs' )
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-general',
			'toggle',
			array(
				'id'			=> 'comments-on',
				'title'			=> __( 'Turn On Comment Support', 'ultimate-faqs' ),
				'description'	=> __( 'Should comment support be turned on, so that if the "Allow Comments" checkbox is selected for a given FAQ, comments are shown in the FAQ list?', 'ultimate-faqs' )
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-general',
			'toggle',
			array(
				'id'			=> 'disable-microdata',
				'title'			=> __( 'Disable Microdata', 'ultimate-faqs' ),
				'description'	=> __( 'By default, the plugin adds FAQ page scheme when the shortcode is used. Select this option to disable this behaviour.', 'ultimate-faqs' )
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-general',
			'radio',
			array(
				'id'			=> 'include-permalink',
				'title'			=> __( 'Include Permalink', 'ultimate-faqs' ),
				'description'	=> __( 'Display permalink to each question? If so, text, icon or both?', 'ultimate-faqs' ),
				'options'		=> array(
					'none'			=> __( 'None', 'ultimate-faqs' ),
					'text'			=> __( 'Text', 'ultimate-faqs' ),
					'icon'			=> __( 'Icon', 'ultimate-faqs' ),
					'both'			=> __( 'Both', 'ultimate-faqs' ),
				),
				'default'		=> $this->defaults['include-permalink']
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-general',
			'radio',
			array(
				'id'			=> 'permalink-type',
				'title'			=> __( 'Permalink Destination', 'ultimate-faqs' ),
				'description'	=> __( 'Should the permalink link to the main FAQ page or the individual FAQ page?', 'ultimate-faqs' ),
				'options'		=> array(
					'same_page'			=> __( 'Main FAQ Page', 'ultimate-faqs' ),
					'individual_page'	=> __( 'Individual FAQ Page', 'ultimate-faqs' ),
				),
				'default'		=> $this->defaults['permalink-type']
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-general',
			'select',
			array(
				'id'            => 'access-role',
				'title'         => __( 'Set Access Role', 'ultimate-faqs' ),
				'description'   => __( 'Which level of user should have access to FAQs, Settings, etc.?.', 'ultimate-faqs' ), 
				'blank_option'	=> false,
				'options'       => array(
					'administrator'				=> __( 'Administrator', 'ultimate-faqs' ),
					'delete_others_pages'		=> __( 'Editor', 'ultimate-faqs' ),
					'delete_published_posts'	=> __( 'Author', 'ultimate-faqs' ),
					'delete_posts'				=> __( 'Contributor', 'ultimate-faqs' ),
				)
			)
		);

		$sap->add_section(
			'ewd-ufaq-settings',
			array(
				'id'            => 'ewd-ufaq-functionality',
				'title'         => __( 'Functionality', 'ultimate-faqs' ),
				'tab'	        => 'ewd-ufaq-basic-tab',
			)
		);
		
		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-functionality',
			'toggle',
			array(
				'id'			=> 'disable-faq-toggle',
				'title'			=> __( 'Disable FAQ Toggle', 'ultimate-faqs' ),
				'description'	=> __( 'Should the FAQs open on a separate page when clicked, instead of opening and closing?', 'ultimate-faqs' )
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-functionality',
			'toggle',
			array(
				'id'			=> 'faq-accordion',
				'title'			=> __( 'FAQ Accordion', 'ultimate-faqs' ),
				'description'	=> __( 'Should the FAQs accordion? (Only one FAQ is open at a time, requires FAQ Toggle)', 'ultimate-faqs' ),
				'conditional_on'		=> 'disable-faq-toggle',
				'conditional_on_value'	=> false
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-functionality',
			'toggle',
			array(
				'id'			=> 'faq-category-toggle',
				'title'			=> __( 'FAQ Category Toggle', 'ultimate-faqs' ),
				'description'	=> __( 'Should the FAQ categories hide/open when they are clicked, if FAQs are being grouped by category ("Group FAQs by Category" in the "Ordering" area)?', 'ultimate-faqs' )
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-functionality',
			'toggle',
			array(
				'id'			=> 'faq-category-accordion',
				'title'			=> __( 'FAQ Category Accordion', 'ultimate-faqs' ),
				'description'	=> __( 'Should it only be possible to open one FAQ category at a time, if FAQ categories are being toggled ("FAQ Category Toggle" must be enabled above)?', 'ultimate-faqs' ),
				'conditional_on'		=> 'faq-category-toggle',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-functionality',
			'toggle',
			array(
				'id'			=> 'expand-collapse-all',
				'title'			=> __( 'FAQ Expand/Collapse All', 'ultimate-faqs' ),
				'description'	=> __( 'Should there be a control to open and close all FAQs simultaneously?', 'ultimate-faqs' ),
				'conditional_on'		=> 'disable-faq-toggle',
				'conditional_on_value'	=> false
			)
		);

		$sap->add_section(
			'ewd-ufaq-settings',
			array(
				'id'            => 'ewd-ufaq-display',
				'title'         => __( 'Display', 'ultimate-faqs' ),
				'tab'	        => 'ewd-ufaq-basic-tab',
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-display',
			'toggle',
			array(
				'id'			=> 'hide-categories',
				'title'			=> __( 'Hide Categories', 'ultimate-faqs' ),
				'description'	=> __( 'Should the categories for each FAQ be hidden?', 'ultimate-faqs' )
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-display',
			'toggle',
			array(
				'id'			=> 'hide-tags',
				'title'			=> __( 'Hide Tags', 'ultimate-faqs' ),
				'description'	=> __( 'Should the tags for each FAQ be hidden?', 'ultimate-faqs' )
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-display',
			'toggle',
			array(
				'id'			=> 'display-all-answers',
				'title'			=> __( 'Display All Answers', 'ultimate-faqs' ),
				'description'	=> __( 'Should all answers be displayed when the page loads? (Careful if FAQ Accordion is on)', 'ultimate-faqs' )
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-display',
			'toggle',
			array(
				'id'			=> 'display-author',
				'title'			=> __( 'Display Post Author', 'ultimate-faqs' ),
				'description'	=> __( 'Should the display name of the post\'s author be displayed beneath the FAQ title?', 'ultimate-faqs' )
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-display',
			'toggle',
			array(
				'id'			=> 'display-date',
				'title'			=> __( 'Display Post Date', 'ultimate-faqs' ),
				'description'	=> __( 'Should the date the post was created be displayed beneath the FAQ title?', 'ultimate-faqs' )
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-display',
			'toggle',
			array(
				'id'			=> 'display-back-to-top',
				'title'			=> __( 'Display \'Back to Top\'', 'ultimate-faqs' ),
				'description'	=> __( 'Should a link to return to the top of the page be added to each FAQ post?', 'ultimate-faqs' )
			)
		);

		$sap->add_section(
			'ewd-ufaq-settings',
			array(
				'id'            	=> 'ewd-ufaq-ordering-tab',
				'title'         	=> __( 'Ordering', 'ultimate-faqs' ),
				'is_tab'			=> true,
				'tutorial_yt_id'	=> 'sTzcb20tjc0'
			)
		);

		$sap->add_section(
			'ewd-ufaq-settings',
			array(
				'id'            => 'ewd-ufaq-ordering-settings',
				'title'         => __( 'Settings', 'ultimate-faqs' ),
				'tab'	        => 'ewd-ufaq-ordering-tab',
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-ordering-settings',
			'toggle',
			array(
				'id'			=> 'group-by-category',
				'title'			=> __( 'Group FAQs by Category', 'ultimate-faqs' ),
				'description'	=> __( 'Should FAQs be grouped by category, or should all categories be mixed together?', 'ultimate-faqs' )
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-ordering-settings',
			'toggle',
			array(
				'id'			=> 'group-by-category-count',
				'title'			=> __( 'Display FAQ Category Count', 'ultimate-faqs' ),
				'description'	=> __( 'If FAQs are grouped by category, should the number of FAQs in a category be displayed beside the category name?', 'ultimate-faqs' ),
				'conditional_on'		=> 'group-by-category',
				'conditional_on_value'	=> true
			)
		);	

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-ordering-settings',
			'select',
			array(
				'id'            => 'category-order-by',
				'title'         => __( 'Sort Categories', 'ultimate-faqs' ),
				'description'   => __( 'How should FAQ categories be ordered? (Only used if "Group FAQs by Category" above is enabled.)', 'ultimate-faqs' ), 
				'blank_option'	=> false,
				'options'       => array(
					'name'				=> __( 'Name', 'ultimate-faqs' ),
					'count'				=> __( 'FAQ Count', 'ultimate-faqs' ),
					'slug'				=> __( 'Slug', 'ultimate-faqs' ),
				),
				'conditional_on'		=> 'group-by-category',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-ordering-settings',
			'radio',
			array(
				'id'			=> 'category-order',
				'title'			=> __( 'Sort Categories Ordering', 'ultimate-faqs' ),
				'description'	=> __( 'How should FAQ categories be ordered? (Only used if "Group FAQs by Category" above is enabled.)', 'ultimate-faqs' ),
				'options'		=> array(
					'asc'			=> __( 'Ascending', 'ultimate-faqs' ),
					'desc'			=> __( 'Descending', 'ultimate-faqs' ),
				),
				'default'		=> $this->defaults['category-order'],
				'conditional_on'		=> 'group-by-category',
				'conditional_on_value'	=> true
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-ordering-settings',
			'radio',
			array(
				'id'            => 'faq-order-by',
				'title'         => __( 'FAQ Ordering', 'ultimate-faqs' ),
				'description'   => __( 'How should individual FAQs be ordered?', 'ultimate-faqs' ), 
				'blank_option'	=> false,
				'options'       => array(
					'date'				=> __( 'Created Date', 'ultimate-faqs' ),
					'title'				=> __( 'Title', 'ultimate-faqs' ),
					'modified'			=> __( 'Modified Date', 'ultimate-faqs' )
				),
				'default'		=> $this->defaults['faq-order-by']
			)
		);

		$sap->add_setting(
			'ewd-ufaq-settings',
			'ewd-ufaq-ordering-settings',
			'radio',
			array(
				'id'			=> 'faq-order',
				'title'			=> __( 'Sort FAQs Ordering', 'ultimate-faqs' ),
				'description'	=> __( 'Should FAQ be ascending or descending order, based on the ordering criteria above?', 'ultimate-faqs' ),
				'options'		=> array(
					'asc'			=> __( 'Ascending', 'ultimate-faqs' ),
					'desc'			=> __( 'Descending', 'ultimate-faqs' ),
				),
				'default'		=> $this->defaults['faq-order']
			)
		);

    /**
     * Premium options preview only
     */
    // "Premium" Tab
    $sap->add_section(
      'ewd-ufaq-settings',
      array(
        'id'     				=> 'ewd-ufaq-premium-tab',
        'title'  				=> __( 'Premium', 'ultimate-faqs' ),
        'is_tab' 				=> true,
        'tutorial_yt_id'		=> 'gV0mAkKWSXg',
        'show_submit_button' 	=> $this->show_submit_button( 'premium' )
      )
    );
    $sap->add_section(
      'ewd-ufaq-settings',
      array(
        'id'       => 'ewd-ufaq-premium-tab-body',
        'tab'      => 'ewd-ufaq-premium-tab',
        'callback' => $this->premium_info( 'premium' )
      )
    );

    // "Fields" Tab
    $sap->add_section(
      'ewd-ufaq-settings',
      array(
        'id'     				=> 'ewd-ufaq-fields-tab',
        'title'  				=> __( 'Fields', 'ultimate-faqs' ),
        'is_tab' 				=> true,
        'tutorial_yt_id'		=> 'yo2PcuirlnY',
        'show_submit_button' 	=> $this->show_submit_button( 'fields' )
      )
    );
    $sap->add_section(
      'ewd-ufaq-settings',
      array(
        'id'       => 'ewd-ufaq-fields-tab-body',
        'tab'      => 'ewd-ufaq-fields-tab',
        'callback' => $this->premium_info( 'fields' )
      )
    );

    // "Labelling" Tab
    $sap->add_section(
      'ewd-ufaq-settings',
      array(
        'id'     				=> 'ewd-ufaq-labelling-tab',
        'title'  				=> __( 'Labelling', 'ultimate-faqs' ),
        'is_tab' 				=> true,
        'tutorial_yt_id'		=> 'ziuY0Tj75MQ',
        'show_submit_button' 	=> $this->show_submit_button( 'labelling' )
      )
    );
    $sap->add_section(
      'ewd-ufaq-settings',
      array(
        'id'       => 'ewd-ufaq-labelling-tab-body',
        'tab'      => 'ewd-ufaq-labelling-tab',
        'callback' => $this->premium_info( 'labelling' )
      )
    );

    // "Styling" Tab
    $sap->add_section(
      'ewd-ufaq-settings',
      array(
        'id'     				=> 'ewd-ufaq-styling-tab',
        'title'  				=> __( 'Styling', 'ultimate-faqs' ),
        'is_tab' 				=> true,
        'tutorial_yt_id'		=> 'OenPtDrNBjg',
        'show_submit_button' 	=> $this->show_submit_button( 'styling' )
      )
    );
    $sap->add_section(
      'ewd-ufaq-settings',
      array(
        'id'       => 'ewd-ufaq-styling-tab-body',
        'tab'      => 'ewd-ufaq-styling-tab',
        'callback' => $this->premium_info( 'styling' )
      )
    );

		$sap = apply_filters( 'ewd_ufaq_settings_page', $sap, $this );

		$sap->add_admin_menus();

	}

	public function show_submit_button( $permission_type = '' ) {
		global $ewd_ufaq_controller;

		if ( $ewd_ufaq_controller->permissions->check_permission( $permission_type ) ) {
			return true;
		}

		return false;
	}

	public function premium_info( $section_and_perm_type ) {
		global $ewd_ufaq_controller;

		$is_premium_user = $ewd_ufaq_controller->permissions->check_permission( $section_and_perm_type );
		$is_helper_installed = defined( 'EWDPH_PLUGIN_FNAME' ) && is_plugin_active( EWDPH_PLUGIN_FNAME );

		if ( $is_premium_user || $is_helper_installed ) {
			return false;
		}

		$content = '';

		$premium_features = '
			<p><strong>' . __( 'The premium version also gives you access to the following features:', 'ultimate-faqs' ) . '</strong></p>
			<ul class="ewd-ufaq-dashboard-new-footer-one-benefits">
				<li>' . __( 'Unlimited FAQs', 'ultimate-faqs' ) . '</li>
				<li>' . __( 'FAQ Search', 'ultimate-faqs' ) . '</li>
				<li>' . __( 'Custom Fields', 'ultimate-faqs' ) . '</li>
				<li>' . __( 'WooCommerce FAQs', 'ultimate-faqs' ) . '</li>
				<li>' . __( '15 Different Icon Sets', 'ultimate-faqs' ) . '</li>
				<li>' . __( 'Import/Export FAQs', 'ultimate-faqs' ) . '</li>
				<li>' . __( 'Advanced Styling Options', 'ultimate-faqs' ) . '</li>
				<li>' . __( 'Social Sharing', 'ultimate-faqs' ) . '</li>
				<li>' . __( 'Email Support', 'ultimate-faqs' ) . '</li>
			</ul>
			<div class="ewd-ufaq-dashboard-new-footer-one-buttons">
				<a class="ewd-ufaq-dashboard-new-upgrade-button" href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1&utm_source=ufaq_settings&utm_content=' . $section_and_perm_type . '" target="_blank">' . __( 'UPGRADE NOW', 'ultimate-faqs' ) . '</a>
			</div>
		';

		switch ( $section_and_perm_type ) {

			case 'premium':

				$content = '
					<div class="ewd-ufaq-settings-preview">
						<h2>' . __( 'Premium', 'ultimate-faqs' ) . '<span>' . __( 'Premium', 'ultimate-faqs' ) . '</span></h2>
						<p>' . __( 'The premium options let you change the FAQ layout, configure WooCommerce and WPForms integration, add reveal effects, paginate your FAQs, add an FAQ rating/voting system, add social sharing, change the the slug base of the post type and much more.', 'ultimate-faqs' ) . '</p>
						<div class="ewd-ufaq-settings-preview-images">
							<img src="' . EWD_UFAQ_PLUGIN_URL . '/assets/img/premium-screenshots/premium1.png" alt="UFAQ premium screenshot one">
							<img src="' . EWD_UFAQ_PLUGIN_URL . '/assets/img/premium-screenshots/premium2.png" alt="UFAQ premium screenshot two">
						</div>
						' . $premium_features . '
					</div>
				';

				break;

			case 'fields':

				$content = '
					<div class="ewd-ufaq-settings-preview">
						<h2>' . __( 'Fields', 'ultimate-faqs' ) . '<span>' . __( 'Premium', 'ultimate-faqs' ) . '</span></h2>
						<p>' . __( 'You can add custom fields to your FAQs, which let you display extra content, such as product manuals, location info, links and more. ', 'ultimate-faqs' ) . '</p>
						<div class="ewd-ufaq-settings-preview-images">
							<img src="' . EWD_UFAQ_PLUGIN_URL . '/assets/img/premium-screenshots/fields.png" alt="UFAQ fields screenshot">
						</div>
						' . $premium_features . '
					</div>
				';

				break;

			case 'labelling':

				$content = '
					<div class="ewd-ufaq-settings-preview">
						<h2>' . __( 'Labelling', 'ultimate-faqs' ) . '<span>' . __( 'Premium', 'ultimate-faqs' ) . '</span></h2>
						<p>' . __( 'The labelling options let you change the wording of the different labels that appear on the front end of the plugin. You can use this to translate them, customize the wording for your purpose, etc.', 'ultimate-faqs' ) . '</p>
						<div class="ewd-ufaq-settings-preview-images">
							<img src="' . EWD_UFAQ_PLUGIN_URL . '/assets/img/premium-screenshots/labelling1.png" alt="UFAQ labelling screenshot one">
							<img src="' . EWD_UFAQ_PLUGIN_URL . '/assets/img/premium-screenshots/labelling2.png" alt="UFAQ labelling screenshot two">
						</div>
						' . $premium_features . '
					</div>
				';

				break;

			case 'styling':

				$content = '
					<div class="ewd-ufaq-settings-preview">
						<h2>' . __( 'Styling', 'ultimate-faqs' ) . '<span>' . __( 'Premium', 'ultimate-faqs' ) . '</span></h2>
						<p>' . __( 'The styling options let you change the toggle symbol and FAQ heading types, as well as modify the color, font size, font family, border, margin and padding of the various elements found in your FAQs.', 'ultimate-faqs' ) . '</p>
						<div class="ewd-ufaq-settings-preview-images">
							<img src="' . EWD_UFAQ_PLUGIN_URL . '/assets/img/premium-screenshots/styling1.png" alt="UFAQ styling screenshot one">
							<img src="' . EWD_UFAQ_PLUGIN_URL . '/assets/img/premium-screenshots/styling2.png" alt="UFAQ styling screenshot two">
						</div>
						' . $premium_features . '
					</div>
				';

				break;
		}

		return function() use ( $content ) {

			echo wp_kses_post( $content );
		};
	}
}
} // endif;
