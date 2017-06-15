<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/jiadams/
 * @since      1.0.0
 *
 * @package    Wjf_Portfolio
 * @subpackage Wjf_Portfolio/includes
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
 * @package    Wjf_Portfolio
 * @subpackage Wjf_Portfolio/includes
 * @author     Josh Adams <jadams@wjfmakreting.com>
 */

function tl_save_error() {
    update_option( 'plugin_error',  ob_get_contents() );
}

class Wjf_Portfolio {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wjf_Portfolio_Loader    $loader    Maintains and registers all hooks for the plugin.
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
     * The options set for this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $options    The options set for this plugin.
     */
    private $options;

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

		$this->plugin_name = 'wjf-portfolio';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_template_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wjf_Portfolio_Loader. Orchestrates the hooks of the plugin.
	 * - Wjf_Portfolio_i18n. Defines internationalization functionality.
	 * - Wjf_Portfolio_Admin. Defines all hooks for the admin area.
	 * - Wjf_Portfolio_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wjf-portfolio-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wjf-portfolio-i18n.php';

		/**
		 * The class responsible for defining actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wjf-portfolio-admin.php';
		/**
		 * The class responsible for defining actions that occur in the admin settings area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wjf-portfolio-admin-settings.php';
		/**
		 * The class responsible for loading the template for the works page into the page templates.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wjf-portfolio-template.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wjf-portfolio-public.php';

		$this->loader = new Wjf_Portfolio_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wjf_Portfolio_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wjf_Portfolio_i18n();

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

		//Admin Functionality
		$plugin_admin = new Wjf_Portfolio_Admin( $this->get_plugin_name(), $this->get_version() );
		//Admin Settings
		$plugin_admin_settings = new Wjf_Portfolio_Admin_Settings( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_admin, 'new_cpt_portfolio' );
		$this->loader->add_action( 'init', $plugin_admin, 'new_cpt_taxonomy_type' );
		$this->loader->add_action( 'admin_menu', $plugin_admin_settings, 'add_menu' );
		if ( ! empty ( $GLOBALS['pagenow'] )
		    and ( 
		    	('edit.php' === $GLOBALS['pagenow'] 
		    	and $_GET['post_type'] === 'work' and $_GET['page'] === 'wjf-portfolio-settings' )
		        	or 'options.php' === $GLOBALS['pagenow']
		    )
		) {
		    $this->loader->add_action( 'admin_init', $plugin_admin_settings, 'register_settings' );
		    $this->loader->add_action( 'admin_init', $plugin_admin_settings, 'register_sections' );
		    $this->loader->add_action( 'admin_init', $plugin_admin_settings, 'register_fields' );
		}

	}


	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wjf_Portfolio_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_filter( 'the_content', $plugin_public, 'append_works' );

	}

	/**
	 * Register all of the hooks related to the template area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_template_hooks() {

		$plugin_templates = new WJF_Portfolio_Template( $this->get_plugin_name(), $this->get_version() );

		// Loop
		$this->loader->add_action( 'wjf-portfolio-before-loop', $plugin_templates, 'before_work_loop', 10, 2 );
		$this->loader->add_action( 'wjf-portfolio-loop-content', $plugin_templates, 'list_work_content', 10, 2 );
		$this->loader->add_action( 'wjf-portfolio-after-loop', $plugin_templates, 'after_work_loop', 10, 2 );

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
	 * @return    Wjf_Portfolio_Loader    Orchestrates the hooks of the plugin.
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
