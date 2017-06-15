<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/jiadams/
 * @since      1.0.0
 *
 * @package    Wjf_Portfolio
 * @subpackage Wjf_Portfolio/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wjf_Portfolio
 * @subpackage Wjf_Portfolio/public
 * @author     Josh Adams <jadams@wjfmakreting.com>
 */
class Wjf_Portfolio_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

    /**
     * The options set for this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $options    The options set for this plugin.
     */
    private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->set_options();

	}

    /**
     * Sets the class variable $options
     */
    private function set_options() {

        $this->options = get_option( $this->plugin_name . '-options' );


    } // set_options()

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wjf_Portfolio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wjf_Portfolio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wjf-portfolio-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wjf_Portfolio_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wjf_Portfolio_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_script( 'masonry.pkgd.min', plugin_dir_url( __FILE__ ) . 'js/masonry.pkgd.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'imagesloaded.pkgd.min', plugin_dir_url( __FILE__ ) . 'js/imagesloaded.pkgd.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wjf-portfolio-public.js', array( 'jquery' ), $this->version, true );

	}

	/**
	 * Returns a post object of portfolio posts
	 *
	 * @param 	array 		$params 			An array of optional parameters
	 * 							types 			An array of portfolio item type slugs
	 * 							quantity		Number of posts to return
	 * @param 	string 		$cache 				String to create a new cache of posts
	 *
	 * @return 	object 		A post object
	 */
	public function get_works ( $params, $cache = '' ) {

		$return 	= '';
		$cache_name = $this->plugin_name . '_works_posts';

		if ( ! empty( $cache ) ) {

			$cache_name .= '_' . $cache;

		}

		$return = wp_cache_get( $cache_name, $this->plugin_name . '_works_posts' );

		if ( false === $return ) {

			$args 	= $this->set_args( $params );
			$query 	= new WP_Query( $args );

			if ( is_wp_error( $query ) ) {

				$return = 'No Works Found';

			} else {

				wp_cache_set( $cache_name, $query->posts, $this->plugin_name . '_works_posts', 5 * MINUTE_IN_SECONDS );

				$return = $query;

			}
		}

		return $return;

	} // get_openings()

	/**
	 * Sets the args array for a WP_Query call
	 *
	 * @param 	array 		$params 		Array of shortcode parameters
	 * @return 	array 						An array of parameters for WP_Query
	 */
	private function set_args( $params ) {

		if ( empty( $params ) ) { return; }

		$args = array();

		$args['no_found_rows']			= true;
		$args['orderby'] 				= $params['order'];
		$args['posts_per_page'] 		= absint( $params['quantity'] );
		$args['post_status'] 			= 'publish';
		$args['post_type'] 				= 'work';
		$args['update_post_term_cache'] = false;

		unset( $params['order'] );
		unset( $params['quantity'] );
		unset( $params['listview'] );
		unset( $params['singleview'] );

		if ( empty( $params ) ) { return $args; }

		$args = wp_parse_args( $params, $args );

		return $args;

	} // set_args()

	/**
	 * Processes shortcode nowhiring
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 *
	 * @uses	get_option
	 * @uses	get_layout
	 *
	 * @return	mixed	$output		Output of the buffer
	 */
	public function list_works( $atts = array() ) {

		ob_start();
		$defaults['loop-template'] 	= plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-loop.php';
		$defaults['order'] 			= 'date';
		$defaults['quantity'] 		= 10;
		$args						= shortcode_atts( $defaults, $atts, 'nowhiring' );
		$works 						= $this->get_works( $args );


		if ( is_array( $works ) || is_object( $works ) ) {

			include $args['loop-template'];

		} else {

			echo $works;

		}

		$output = ob_get_contents();

		ob_end_clean();

		return $output;

	} // list_openings()

	/**
	 * Creates page template to display list of works
	 *
	 * @param   array	$atts		The attributes from the shortcode
	 *
	 * @uses	get_option
	 *
	 * @return	mixed	$output		Output of the buffer
	 */
	public function append_works ( $content ) {

	    if ( is_page($this->get_options()['display-page']) ) {

	    	$works_query = $this->list_works();

			$content .= $works_query;

	    }

	    return $content;

	} // works_page_template()

    public function list_work_content( $works ) {

        include plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-loop-content.php';
    
    }

    public function get_options() {

        return $this->options;

    }//get_options()

}
