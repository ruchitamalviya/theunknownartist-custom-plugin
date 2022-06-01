<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link         https://www.expresstechsoftwares.com/
 * @since      1.0.0
 *
 * @package    Ets_Development
 * @subpackage Ets_Development/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ets_Development
 * @subpackage Ets_Development/includes
 * @author     ExpressTech Softwares Solutions Pvt Ltd <www.expresstechsoftwares.com>
 */
class Ets_Development {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ets_Development_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ETS_DEVELOPMENT_VERSION' ) ) {
			$this->version = ETS_DEVELOPMENT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ets-development';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ets_Development_Loader. Orchestrates the hooks of the plugin.
	 * - Ets_Development_i18n. Defines internationalization functionality.
	 * - Ets_Development_Admin. Defines all hooks for the admin area.
	 * - Ets_Development_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ets-development-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ets-development-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ets-development-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ets-development-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ets-development-public-profile-page.php';

		$this->loader = new Ets_Development_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ets_Development_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ets_Development_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Ets_Development_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'ets_development_menu' );	
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ets_Development_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'ets_wp_fontawasome');		
		//product short description.
		$this->loader->add_action( 'woocommerce_after_shop_loop_item_title', $plugin_public, 'ets_add_shop_short_description' );
		//show hide filter  term.
		$this->loader->add_filter( 'berocket_aapf_get_terms_args', $plugin_public, 'ets_show_empty_terms' ,10 ,3);
		//remove add to cart button.
		$this->loader->add_filter( 'woocommerce_is_purchasable', $plugin_public, 'ets_remove_cart_button' );
		$this->loader->add_action( 'woocommerce_before_shop_loop', $plugin_public, 'ets_custom_search' );
		//woo product search
		$this->loader->add_action( 'woocommerce_product_query',$plugin_public, 'ets_before_filter_query' );
		//add shopping bag icon.
		$this->loader->add_action( 'woocommerce_after_shop_loop_item',$plugin_public, 'ets_add_shopping_bag' );	
		/*product detail hooks*/
		//remove quantity
		$this->loader->add_filter( 'woocommerce_is_sold_individually', $plugin_public, 'remove_all_quantity_fields', 10, 2 );
		//remove additonal information tab
		$this->loader->add_filter( 'woocommerce_product_tabs', $plugin_public ,'ets_remove_product_tabs', 99999);
		//display attribute on single details page
		$this->loader->add_action('woocommerce_share', $plugin_public, 'display_some_product_attributes');
		$this->loader->add_action('woocommerce_before_single_product_summary', $plugin_public, 'add_wishlist');
		//add review
		$this->loader->add_action( 'woocommerce_before_add_to_cart_form', $plugin_public, 'ets_add_long_description' );
		$this->loader->add_action('after_wcfm_products_manage_meta_save', $plugin_public, 'ets_save_review_setting');
		$this->loader->add_filter( 'woocommerce_single_product_carousel_options',$plugin_public, 'ets_add_product_carousel' );
		//rename review tab title 
		$this->loader->add_filter( 'woocommerce_product_tabs', $plugin_public,'rename_review_tabs', 98, 1 );		
		//get shipping attribute
		$this->loader->add_action( 'woocommerce_before_add_to_cart_button', $plugin_public,'ets_get_shipping_attribute' );
		//add artist work
		$this->loader->add_action( 'woocommerce_single_product_summary', $plugin_public,'ets_add_artist_work', 5 );
		//add artist work for mobile
		$this->loader->add_action( 'woocommerce_before_single_product', $plugin_public,'ets_add_artist_work_mobile');
		//get artist name
		$this->loader->add_action('woocommerce_single_product_summary', $plugin_public, 'ets_add_artist_name');
		//change review submit btn text
		$this->loader->add_action('woocommerce_product_review_comment_form_args', $plugin_public,'ets_review_publish_btn');
		//change review submit btn text
		$this->loader->add_action('woocommerce_review_before', $plugin_public,'ets_review_avtar');
		$this->loader->add_filter( 'yith_wcwl_show_add_to_wishlist', $plugin_public,'ets_remove_white_list_single_page', 10 );
		$this->loader->add_action('woocommerce_before_add_to_cart_button', $plugin_public,'ets_add_mobile_product_attr');		

		$this->loader->add_action('wp_print_styles', $plugin_public, 'remove_wooleneter_slick_css');
		$this->loader->add_action('wp_print_scripts', $plugin_public, 'remove_wooleneter_slick_js');
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ets_Development_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
