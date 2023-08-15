<?php
/*
Plugin Name: Ultimate FAQ - WordPress FAQ and Accordion Plugin
Plugin URI: https://www.etoilewebdesign.com/plugins/ultimate-faq/
Description: FAQ and accordion plugin with easy to use Gutenberg blocks, shortcodes and widgets. Includes an advanced FAQ search and FAQ schema.
Author URI: https://www.etoilewebdesign.com/
Terms and Conditions: https://www.etoilewebdesign.com/plugin-terms-and-conditions/
Text Domain: ultimate-faqs
Version: 2.2.6
WC requires at least: 3.0
WC tested up to: 7.5
*/

if ( ! defined( 'ABSPATH' ) )
	exit;

if ( ! class_exists( 'ewdufaqInit' ) ) {
class ewdufaqInit {

	// Any data that needs to be passed from PHP to our JS files 
	public $front_end_php_js_data = array();

	public $schema_faq_data = array();

	/**
	 * Initialize the plugin and register hooks
	 */
	public function __construct() {

		self::constants();
		self::includes();
		self::instantiate();
		self::wp_hooks();
	}

	/**
	 * Define plugin constants.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @return void
	 */
	protected function constants() {

		define( 'EWD_UFAQ_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'EWD_UFAQ_PLUGIN_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
		define( 'EWD_UFAQ_PLUGIN_FNAME', plugin_basename( __FILE__ ) );
		define( 'EWD_UFAQ_TEMPLATE_DIR', 'ewd-ufaq-templates' );
		define( 'EWD_UFAQ_VERSION', '2.2.6' );

		define( 'EWD_UFAQ_FAQ_POST_TYPE', 'ufaq' );
		define( 'EWD_UFAQ_FAQ_CATEGORY_TAXONOMY', 'ufaq-category' );
		define( 'EWD_UFAQ_FAQ_TAG_TAXONOMY', 'ufaq-tag' );
	}

	/**
	 * Include necessary classes.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @return void
	 */
	protected function includes() {

		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/AboutUs.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/Ajax.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/Blocks.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/Patterns.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/CustomPostTypes.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/Dashboard.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/DeactivationSurvey.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/FAQ.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/Helper.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/InstallationWalkthrough.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/Notifications.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/OrderingTable.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/Permissions.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/Query.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/ReviewAsk.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/Settings.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/template-functions.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/UltimateWPMail.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/Widgets.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/WooCommerce.class.php' );
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/WPForms.class.php' );
	}

	/**
	 * Spin up instances of our plugin classes.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @return void
	 */
	protected function instantiate() {

		new ewdufaqDashboard();
		new ewdufaqDeactivationSurvey();
		new ewdufaqInstallationWalkthrough();
		new ewdufaqReviewAsk();

		$this->cpts 		= new ewdufaqCustomPostTypes();
		$this->permissions 	= new ewdufaqPermissions();
		$this->settings 	= new ewdufaqSettings(); 

		if ( $this->settings->get_setting( 'woocommerce-faqs' ) ) {
			
			$this->woocommerce = new ewdufaqWooCommerce();
		}

		if ( $this->settings->get_setting( 'wpforms-integration' ) ) {
			
			$this->wpforms = new ewdufaqWPForms();
		}

		new ewdufaqAJAX();
		new ewdufaqBlocks();
		if ( function_exists( 'register_block_pattern' ) ) { new ewdufaqPatterns(); }
		new ewdufaqNotifications();
		new ewdufaqOrderingTable();
		new ewdufaqUltimateWPMail();
		new ewdufaqWidgetManager();

		new ewdufaqAboutUs();
	}

	/**
	 * Run walk-through, load assets, add links to plugin listing, etc.
	 *
	 * @since  2.0.0
	 * @access protected
	 * @return void
	 */
	protected function wp_hooks() {

		register_activation_hook( __FILE__, 	array( $this, 'run_walkthrough' ) );
		register_activation_hook( __FILE__, 	array( $this, 'convert_options' ) );

		add_filter( 'ewd_ufaq_admin_menu', 		array( $this, 'admin_menu_optional' ) );

		add_filter( 'init', 					array( $this, 'rewrite_rules' ) );
		add_filter( 'query_vars', 				array( $this, 'add_query_vars' ) );
		add_filter( 'redirect_canonical', 		array( $this, 'disable_canonical_redirect_for_front_page' ) );

		add_filter( 'the_content', 				array( $this, 'alter_faq_content' ) );
		add_filter( 'the_content', 				array( $this, 'add_faqs_content' ) );
		add_action( 'wp_footer', 				array( $this, 'output_ld_json_content' ) );

		add_action( 'init', 					array( $this, 'load_view_files' ) );

		add_action( 'plugins_loaded', 			array( $this, 'load_textdomain' ) );

		add_action( 'admin_notices', 			array( $this, 'display_header_area' ) );
		add_action( 'admin_notices', 			array( $this, 'maybe_display_helper_notice' ) );

		add_action( 'admin_enqueue_scripts', 	array( $this, 'enqueue_admin_assets' ), 10, 1 );
		add_action( 'wp_enqueue_scripts', 		array( $this, 'register_assets' ) );
		add_action( 'wp_head', 					'ewd_add_frontend_ajax_url' );
		add_action( 'wp_footer', 				array( $this, 'assets_footer' ), 2 );

		add_filter( 'plugin_action_links', 		array( $this, 'plugin_action_links' ), 10, 2);

		add_action( 'wp_ajax_ewd_ufaq_hide_helper_notice', array( $this, 'hide_helper_notice' ) );
	}

	/**
	 * Run the options conversion function on update if necessary
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function convert_options() {
		
		require_once( EWD_UFAQ_PLUGIN_DIR . '/includes/BackwardsCompatibility.class.php' );
		new ewdufaqBackwardsCompatibility();
	}

	/**
	 * Adds in the rewrite rules used by the plugin and flushes rules if necessary
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function rewrite_rules() {

		$review_rules = get_option( 'rewrite_rules' );
		$frontpage_id = get_option( 'page_on_front' );

		add_rewrite_tag( '%single_faq%', '([^&]+)' );
 		add_rewrite_tag( '%ufaq_category_slug%', '([^+]+)' );
 		add_rewrite_tag( '%ufaq_tag_slug%', '([^?]+)' );
	
		add_rewrite_rule( "single-faq/([^&]*)/?$", "index.php?page_id=". $frontpage_id . "&single_faq=\$matches[1]", 'top' );
		add_rewrite_rule( "(.?.+?)/single-faq/([^&]*)/?$", "index.php?pagename=\$matches[1]&single_faq=\$matches[2]", 'top' );
		add_rewrite_rule( "faq-category/([^+]*)/?$", "index.php?page_id=". $frontpage_id . "&ufaq_category_slug=\$matches[1]", 'top' );
		add_rewrite_rule( "(.?.+?)/faq-category/([^+]*)/?$", "index.php?pagename=\$matches[1]&ufaq_category_slug=\$matches[2]", 'top' );
		add_rewrite_rule( "faq-tag/([^?]*)/?$", "index.php?page_id=". $frontpage_id . "&ufaq_tag_slug=\$matches[1]", 'top' );
		add_rewrite_rule( "(.?.+?)/faq-tag/([^?]*)/?$", "index.php?pagename=\$matches[1]&ufaq_tag_slug=\$matches[2]", 'top' );

		if ( ! isset( $review_rules['(.?.+?)/single-faq/([^&]*)/?$'] ) ) { flush_rewrite_rules(); }
	}

	/**
	 * Adds in the query vars used by the plugin
	 *
	 * @since  2.0.0
	 * @access public
	 * @return array
	 */
	public function add_query_vars( $vars ) {

		$vars[] = 'single_faq';
		$vars[] = 'ufaq_category_slug';
		$vars[] = 'ufaq_tag_slug';

		return $vars;
	}

	/**
	 * Disables the automatic redirect that happens on the front-page
	 *
	 * @since  2.0.0
	 * @access public
	 * @return array
	 */
	public function disable_canonical_redirect_for_front_page( $redirect ) {
		global $ewd_ufaq_controller;

		if ( empty( $ewd_ufaq_controller->settings->get_setting( 'disable-homepage-canoncial-redirect' ) ) ) { return $redirect; }

		if ( ! is_page() ) { return $redirect; }

		$front_page = get_option( 'page_on_front' );

		if ( ! is_page( $front_page ) ) { return $redirect; }

		return false;
	}

	/**
	 * Load files needed for views
	 * @since 2.0.0
	 * @note Can be filtered to add new classes as needed
	 */
	public function load_view_files() {
	
		$files = array(
			EWD_UFAQ_PLUGIN_DIR . '/views/Base.class.php' // This will load all default classes
		);
	
		$files = apply_filters( 'ewd_ufaq_load_view_files', $files );
	
		foreach( $files as $file ) {
			require_once( $file );
		}
	
	}

	/**
	 * Load the plugin textdomain for localisation
	 * @since 2.0.0
	 */
	public function load_textdomain() {
		
		load_plugin_textdomain( 'ultimate-faqs', false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Set a transient so that the walk-through gets run
	 * @since 2.0.0
	 */
	public function run_walkthrough() {

		set_transient( 'ewd-ufaq-getting-started', true, 30 );
	} 

	/**
	 * Enqueue the admin-only CSS and Javascript
	 * @since 2.0.0
	 */
	public function enqueue_admin_assets( $hook ) {

		wp_enqueue_script( 'ewd-ufaq-helper-notice', EWD_UFAQ_PLUGIN_URL . '/assets/js/ewd-ufaq-helper-install-notice.js', array( 'jquery' ), EWD_UFAQ_VERSION, true );
		wp_localize_script(
			'ewd-ufaq-helper-notice',
			'ewd_ufaq_helper_notice',
			array( 'nonce' => wp_create_nonce( 'ewd-ufaq-helper-notice' ) )
		);

		wp_enqueue_style( 'ewd-ufaq-helper-notice', EWD_UFAQ_PLUGIN_URL . '/assets/css/ewd-ufaq-helper-install-notice.css', array(), EWD_UFAQ_VERSION );

		$screen = get_current_screen();

		$hooks = array(
			'widgets.php',
			'ufaq_page_ewd-ufaq-ordering-table',
			'ufaq_page_ewd-ufaq-settings'
		);

		$screen_ids = array(
			'ufaq',
			'ufaq_page_ewd-ufaq-dashboard',
			'edit-ufaq',
			'edit-ufaq-category',
			'edit-ufaq-tag',
			'ufaq_page_ewd-ufaq-about-us',
			'ufaq_page_ewd-ufaq-export',
			'ufaq_page_ewd-ufaq-import'
		);

		if ( ! in_array( $hook, $hooks ) and ! in_array( $screen->id, $screen_ids ) ) { return; }

		wp_enqueue_style( 'ewd-ufaq-admin-css', EWD_UFAQ_PLUGIN_URL . '/assets/css/ewd-ufaq-admin.css', array(), EWD_UFAQ_VERSION );

		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );

		wp_register_script( 'ewd-ufaq-admin-js', EWD_UFAQ_PLUGIN_URL . '/assets/js/ewd-ufaq-admin.js', array( 'jquery', 'jquery-ui-sortable' ), EWD_UFAQ_VERSION, true );

		$args = array(
			'nonce' => wp_create_nonce( 'ewd-ufaq-admin-js' ),
			'ordering' => $this->permissions->check_permission( 'ordering' )
		);
		
		wp_localize_script( 'ewd-ufaq-admin-js', 'ewd_ufaq_php_data', $args );

		wp_enqueue_script( 'ewd-ufaq-admin-js' );
	}

	/**
	 * Register the front-end CSS and Javascript for the FAQs
	 * @since 2.0.0
	 */
	public function register_assets() {
		global $ewd_ufaq_controller;

		wp_register_style( 'ewd-ufaq-rrssb', EWD_UFAQ_PLUGIN_URL . '/assets/css/rrssb-min.css', EWD_UFAQ_VERSION );
		wp_register_style( 'ewd-ufaq-jquery-ui', EWD_UFAQ_PLUGIN_URL . '/assets/css/jquery-ui.min.css', EWD_UFAQ_VERSION );
		
		wp_register_style( 'ewd-ufaq-css', EWD_UFAQ_PLUGIN_URL . '/assets/css/ewd-ufaq.css', EWD_UFAQ_VERSION );
		
		wp_register_script( 'ewd-ufaq-js', EWD_UFAQ_PLUGIN_URL . '/assets/js/ewd-ufaq.js', array( 'jquery', 'jquery-ui-core' ), EWD_UFAQ_VERSION, true );
	}

	/**
	 * Print out any PHP data needed for our JS to work correctly
	 * @since 2.1.0
	 */
	public function assets_footer() {

		if ( empty( $this->front_end_php_js_data ) ) { return; }

		$print_variables = array();

		foreach ( (array) $this->front_end_php_js_data as $variable => $values ) {

			if ( empty( $values ) ) { continue; }

			$print_variables[ $variable ] = ewdufaqHelper::escape_js_recursive( $values );
		}

		foreach ( $print_variables as $variable => $values ) {

			echo "<script type='text/javascript'>\n";
			echo "/* <![CDATA[ */\n";
			echo 'var ' . esc_attr( $variable ) . ' = ' . wp_json_encode( $values ) . "\n";
			echo "/* ]]> */\n";
			echo "</script>\n";
		}
	}

	/**
	 * Adds a variable to be passed to our front-end JS
	 * @since 2.1.0
	 */
	public function add_front_end_php_data( $handle, $variable, $data ) {

		$this->front_end_php_js_data[ $variable ] = $data;
	}

	/**
	 * Returns the corresponding front-end JS variable if it exists, otherwise an empty array
	 * @since 2.1.0
	 */
	public function get_front_end_php_data( $handle, $variable ) {

		return ! empty( $this->front_end_php_js_data[ $variable ] ) ? $this->front_end_php_js_data[ $variable ] : array();
	}

	/**
	 * Add links to the plugin listing on the installed plugins page
	 * @since 2.0.0
	 */
	public function plugin_action_links( $links, $plugin ) {
		global $ewd_ufaq_controller;
		
		if ( $plugin == EWD_UFAQ_PLUGIN_FNAME ) {

			if ( ! $ewd_ufaq_controller->permissions->check_permission( 'premium' ) ) {

				array_unshift( $links, '<a class="ewd-ufaq-plugin-page-upgrade-link" href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1&utm_source=wp_admin_plugins_page" title="' . __( 'Try Premium', 'ultimate-faqs' ) . '" target="_blank">' . __( 'Try Premium', 'ultimate-faqs' ) . '</a>' );
			}

			$links['settings'] = '<a href="admin.php?page=ewd-ufaq-settings" title="' . __( 'Head to the settings page for Ultimate FAQs', 'ultimate-faqs' ) . '">' . __( 'Settings', 'ultimate-faqs' ) . '</a>';
		}

		return $links;

	}

	/**
	 * Replace the content of the single FAQ page with the FAQ shortcode
	 * @since 2.0.0
	 */
	public function alter_faq_content( $content ) {
		global $post, $ewd_ufaq_controller;

		if ( empty( $post ) ) { return $content; }

		if ( $post->post_type != EWD_UFAQ_FAQ_POST_TYPE ) { return $content; }

		if ( ! empty( $ewd_ufaq_controller->shortcode_printing ) ) { return $content; }

		if ( is_archive() ) { return $content; }

		$ewd_ufaq_controller->single_page_print = true;

		$content = do_shortcode( '[select-faq faq_id="' . $post->ID . '"]' );

		$ewd_ufaq_controller->single_page_print = false;
		
		return $content;
	}

	/**
	 * Append the ultimate-faqs shortcode to a post's $content variable
	 * @since 2.1.12
	 */
	function add_faqs_content( $content ) {
		global $post;

		if ( ! is_main_query() || ! in_the_loop() ) {

			return $content;
		}

		if ( $this->settings->get_setting( 'faq-page' ) === $post->ID ) {

			return $content . do_shortcode( '[ultimate-faqs]' );
		}

		return $content;
	}

	/**
	 * Output any FAQ schema data, if enabled
	 *
	 * @since  2.0.0
	 */
	public function output_ld_json_content() {
		global $ewd_ufaq_controller;

		if ( empty( $this->schema_faq_data ) ) { return; }

		if ( $ewd_ufaq_controller->settings->get_setting( 'disable-microdata' ) ) { return; }

		$ewd_ufaq_schema_data = array(
			'@context' => 'https://schema.org',
			'@type' => 'FAQPage',
			'mainEntity' => $this->schema_faq_data
		);

		$ld_json_ouptut = apply_filters( 'ewd_ufaq_ld_json_output', $ewd_ufaq_schema_data );

		echo '<script type="application/ld+json" class="ewd-ufaq-ld-json-data">';
		echo wp_json_encode( $ld_json_ouptut );
		echo '</script>';
	}

	/**
	 * Adds in a menu bar for the plugin
	 * @since 2.0.0
	 */
	public function display_header_area() {
		global $ewd_ufaq_controller;

		$screen = get_current_screen();
		
		if ( empty( $screen->parent_file ) or $screen->parent_file != 'edit.php?post_type=ufaq' ) { return; }
		
		if ( ! $ewd_ufaq_controller->permissions->check_permission( 'styling' ) or get_option( 'EWD_UFAQ_Trial_Happening' ) == 'Yes' ) {
			?>
			<div class="ewd-ufaq-dashboard-new-upgrade-banner">
				<div class="ewd-ufaq-dashboard-banner-icon"></div>
				<div class="ewd-ufaq-dashboard-banner-buttons">
					<a class="ewd-ufaq-dashboard-new-upgrade-button" href="https://www.etoilewebdesign.com/license-payment/?Selected=UFAQ&Quantity=1&utm_source=ufaq_admin&utm_content=banner" target="_blank">UPGRADE NOW</a>
				</div>
				<div class="ewd-ufaq-dashboard-banner-text">
					<div class="ewd-ufaq-dashboard-banner-title">
						GET FULL ACCESS WITH OUR PREMIUM VERSION
					</div>
					<div class="ewd-ufaq-dashboard-banner-brief">
						WooCommerce Integration, Advanced styling options, Advanced control options and more!
					</div>
				</div>
			</div>
			<?php
		}

		$menu_list = apply_filters(
			'ewd_ufaq_admin_menu',
			array(
				array(
					'id'        => 'dashboard-menu',
					'label'     => __("Dashboard", 'ultimate-faqs'),
					'url'       => 'admin.php?page=ewd-ufaq-dashboard',
					'screen-id' => 'ufaq_ewd-ufaq-dashboard',
				),
				array(
					'id'        => 'faqs-menu',
					'label'     => __("FAQs", 'ultimate-faqs'),
					'url'       => 'edit.php?post_type=ufaq',
					'screen-id' => 'edit-ufaq',
				),
				array(
					'id'        => 'add-faq-menu',
					'label'     => __("Add New", 'ultimate-faqs'),
					'url'       => 'post-new.php?post_type=ufaq',
					'screen-id' => 'not-required',
				),
				array(
					'id'        => 'categories-menu',
					'label'     => __("Categories", 'ultimate-faqs'),
					'url'       => 'edit-tags.php?taxonomy=ufaq-category&post_type=ufaq',
					'screen-id' => 'edit-ufaq-category',
				),
				array(
					'id'        => 'tags-menu',
					'label'     => __("Tags", 'ultimate-faqs'),
					'url'       => 'edit-tags.php?taxonomy=ufaq-tag&post_type=ufaq',
					'screen-id' => 'edit-ufaq-tag',
				),
				array(
					'id'        => 'options-menu',
					'label'     => __("Settings", 'ultimate-faqs'),
					'url'       => 'edit.php?post_type=ufaq&page=ewd-ufaq-settings',
					'screen-id' => 'ufaq_page_ewd-ufaq-settings',
				)
			)
		);

		?>
		<div class="ewd-ufaq-admin-header-menu">
			<h2 class="nav-tab-wrapper">
			<a 
				id="ewd-ufaq-dash-mobile-menu-open" 
				href="#" 
				class="menu-tab nav-tab">
				<?php _e("MENU", 'ultimate-faqs'); ?>
				<span id="ewd-ufaq-dash-mobile-menu-down-caret">&nbsp;&nbsp;&#9660;</span>
				<span id="ewd-ufaq-dash-mobile-menu-up-caret">&nbsp;&nbsp;&#9650;</span>
			</a>
			
			<?php
				foreach ($menu_list as $menu) {
					$active = $screen->id == $menu['screen-id'] ? 'nav-tab-active' : '';
			?>
				<a 
					id='<?php echo esc_attr( $menu['id'] ); ?>'
					href='<?php echo esc_attr( $menu['url'] ); ?>'
					class='menu-tab nav-tab <?php echo esc_attr( $active ); ?>'>
					<?php echo esc_html( $menu['label'] ); ?>
				</a>
			<?php
				}
			?>

			</h2>
		</div>
		<?php
	}

	public function maybe_display_helper_notice() {
		global $ewd_ufaq_controller;

		if ( empty( $ewd_ufaq_controller->permissions->check_permission( 'premium' ) ) ) { return; }

		if ( is_plugin_active( 'ewd-premium-helper/ewd-premium-helper.php' ) ) { return; }

		if ( get_transient( 'ewd-helper-notice-dismissed' ) ) { return; }

		?>

		<div class='notice notice-error is-dismissible ewd-ufaq-helper-install-notice'>
			
			<div class='ewd-ufaq-helper-install-notice-img'>
				<img src='<?php echo EWD_UFAQ_PLUGIN_URL . '/lib/simple-admin-pages/img/options-asset-exclamation.png' ; ?>' />
			</div>

			<div class='ewd-ufaq-helper-install-notice-txt'>
				<?php _e( 'You\'re using the Ultimate FAQs premium version, but the premium helper plugin is not active.', 'ultimate-faqs' ); ?>
				<br />
				<?php echo sprintf( __( 'Please re-activate the helper plugin, or <a target=\'_blank\' href=\'%s\'>download and install it</a> if the plugin is no longer installed to ensure continued access to the premium features of the plugin.', 'ultimate-faqs' ), 'https://www.etoilewebdesign.com/2021/12/11/requiring-premium-helper-plugin/' ); ?>
			</div>

			<div class='ewd-ufaq-clear'></div>

		</div>

		<?php 
	}

	public function hide_helper_notice() {
		global $ewd_ufaq_controller;

		// Authenticate request
		if (
			! check_ajax_referer( 'ewd-ufaq-helper-notice', 'nonce' )
			||
			! current_user_can( $ewd_ufaq_controller->settings->get_setting( 'access-role' ) )
		) {
			ewdufaqHelper::admin_nopriv_ajax();

		}

		set_transient( 'ewd-helper-notice-dismissed', true, 3600*24*7 );

		die();
	}

	public function admin_menu_optional( $menu_list ) {
		global $ewd_ufaq_controller;

		if ( $ewd_ufaq_controller->settings->get_setting( 'faq-order-by' ) == 'set_order' ) {
			array_splice(
				$menu_list,
				count( $menu_list ) - 1,
				0,
				array(
					array(
						'id'        => 'ordering-table',
						'label'     => __("FAQ Order", 'ultimate-faqs'),
						'url'       => 'edit.php?post_type=ufaq&page=ewd-ufaq-ordering-table',
						'screen-id' => 'ufaq_page_ewd-ufaq-ordering-table',
					)
				)
			);
		}

		return $menu_list;
	}

}
} // endif;

global $ewd_ufaq_controller;
$ewd_ufaq_controller = new ewdufaqInit();

do_action( 'ewd_ufaq_initialized' );