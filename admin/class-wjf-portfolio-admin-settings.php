<?php

/**
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin settings specific stylesheet and JavaScript and functions
 *
 * @link       https://github.com/jiadams/
 * @since      1.0.0
 *
 * @package    Wjf_Portfolio
 * @subpackage Wjf_Portfolio/admin
 * @author     Josh Adams <jadams@wjfmakreting.com>
 */

class Wjf_Portfolio_Admin_Settings {

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
     * The default options set for this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $options    The options set for this plugin.
     */
    protected $defaults;

    /**
     * List of Pages on WP install
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $options    The options set for this plugin.
     */
    protected $pages;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->set_options();

        $this->pages = get_pages();

    }

    /**
     * Sets the class variable $options
     */
    private function set_options() {

        $this->options = get_option( $this->plugin_name . '-options' );


    } // set_options()


    /**
     * Adds a settings page link to a menu
     *
     * @link        https://codex.wordpress.org/Administration_Menus
     * @since       1.0.0
     * @return      void
     */
    public function add_menu() {

        // Top-level page
        // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );

        // Submenu Page
        // add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);

        add_submenu_page(
            'edit.php?post_type=work',
            apply_filters( $this->plugin_name . '-settings-page-title', esc_html__( 'WJF Portfolio Settings', 'wjf-portfolio' ) ),
            apply_filters( $this->plugin_name . '-settings-menu-title', esc_html__( 'Settings', 'wjf-portfolio' ) ),
            'manage_options',
            $this->plugin_name . '-settings',
            array( $this, 'page_options' )
        );

    } // add_menu()

    /**
     * Registers settings sections with WordPress
     */
    public function register_sections() {

        // add_settings_section( $id, $title, $callback, $menu_slug );

        add_settings_section(
            $this->plugin_name . '-display',
            apply_filters( $this->plugin_name . 'section-title-messages', esc_html__( 'Display Settings', 'wjf-portfolio' ) ),
            array( $this, 'section_messages' ),
            $this->plugin_name
        );

    } // register_sections()

    /**
     * Registers plugin settings
     *
     * @since       1.0.0
     * @return      void
     */
    public function register_settings() {

        // register_setting( $option_group, $option_name, $sanitize_callback );

        register_setting(
            $this->plugin_name . '-options',
            $this->plugin_name . '-options',
            array( $this, 'validate_options' )
        );
    } // register_settings()

    public function register_fields() {

        // add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );

        add_settings_field(
            'display-page',
            apply_filters( $this->plugin_name . 'label-display-page', esc_html__( 'Display Page', 'wjf-portfolio' ) ),
            array( $this, 'field_select' ),
            $this->plugin_name,  // menu slug, see t5_sae_add_options_page()
            $this->plugin_name . '-display',
            array (
                'id'            => "display-date",
                'selections'    => $this->get_page_meta('post_title'),
                'id'            => "display-page",
            )
        );

        add_settings_field(
            'display-order',
            apply_filters( $this->plugin_name . 'label-display-page', esc_html__( 'Default Sort Order', 'wjf-portfolio' ) ),
            array( $this, 'field_select' ),
            $this->plugin_name,  // menu slug, see t5_sae_add_options_page()
            $this->plugin_name . '-display',
            array (
                'id'            => "display-order",
                'selections'    => array( 
                                    array ( 'value' =>  'date_published',
                                            'label' =>  'Date Published'),
                                    array ( 'value' =>  'last_modified',
                                            'label' =>  'Last Modified'),
                                    array ( 'value' =>  'alphabetical',
                                            'label' =>  'Alphabetical')
                                    ),
                'description'   => 'Default sort order (for Display Page)',
            )
        );

    } // register_fields()


    /**
     * Returns array of the title and page
     *
     * @since       1.0.0
     * @return      void
     */
    private function get_page_meta( $page_meta ) {

        $page_info = array();

        array_push ($page_info, array('value' => '', 'label' => 'None') );

        foreach( $this->pages as $page ) {
            array_push( $page_info, array('value' => $page->ID, 'label' => $page->post_title));
        }


        return $page_info;

    }// get_page_meta()

    /**
     * Returns an array of options names, fields types, and default values
     *
     * @return      array           An array of options
     */
    public static function get_options_list() {

        $options = array();

        $options[] = array( 'display-page', 'select', '' );
        $options[] = array( 'display-order', 'select', 'date_published' );

        return $options;

    } // get_options_list()

    function debug_var( $var, $before = '' ) {
        $export = esc_html( var_export( $var, TRUE ) );
        print "<pre>$before = $export</pre>";
    }

    /**
     *
     * Render functions
     * Order:
     *
     *  1. Pages
     *  2. Form Fields
     *  
     */

    /**
     * Creates the options page
     *
     * @since       1.0.0
     * @return      void
     */
    public function page_options() {

        include( plugin_dir_path( __FILE__ ) . 'partials/wjf-portfolio-admin-settings-page.php' );

    } // page_options()

    public function section_messages( $params ) {

        include( plugin_dir_path( __FILE__ ) . 'partials/wjf-portfolio-admin-section-messages.php' );

    } // section_messages()

    /**
     * Creates a text field
     *
     * @param   array       $args           The arguments for the field
     * @return  string                      The HTML field
     */
    public function field_text( $args ) {

        $defaults['class']          = 'text widefat';
        $defaults['description']    = '';
        $defaults['label']          = '';
        $defaults['name']           = $this->plugin_name . '-options[' . $args['id'] . ']';
        $defaults['placeholder']    = '';
        $defaults['type']           = 'text';
        $defaults['value']          = '';

        apply_filters( $this->plugin_name . '-field-text-options-defaults', $defaults );

        $atts = wp_parse_args( $args, $defaults );

        if ( ! empty( $this->options[$atts['id']] ) ) {

            $atts['value'] = $this->options[$atts['id']];

        }

        include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-text.php' );

    } // field_text()

    /**
     * Creates a select field
     *
     * Note: label is blank since its created in the Settings API
     *
     * @param   array       $args           The arguments for the field
     * @return  string                      The HTML field
     */
    public function field_select( $args ) {

        $defaults['aria']           = '';
        $defaults['blank']          = '';
        $defaults['class']          = '';
        $defaults['context']        = '';
        $defaults['description']    = '';
        $defaults['label']          = '';
        $defaults['name']           = $this->plugin_name . '-options[' . $args['id'] . ']';
        $defaults['selections']     = array();
        $defaults['value']          = '';

        apply_filters( $this->plugin_name . '-field-select-options-defaults', $defaults );

        $atts = wp_parse_args( $args, $defaults );

        if ( ! empty( $this->options[$atts['id']] ) ) {

            $atts['value'] = $this->options[$atts['id']];

        }

        if ( empty( $atts['aria'] ) && ! empty( $atts['description'] ) ) {

            $atts['aria'] = $atts['description'];

        } elseif ( empty( $atts['aria'] ) && ! empty( $atts['label'] ) ) {

            $atts['aria'] = $atts['label'];

        }

        include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-admin-field-select.php' );

    } // field_select()

    /**
     *
     * Sanitize Functionality
     *
     * 1.   Validate Options
     * 2.   Sanitizer Switch
     * 
     *  
     */
    
    /**
     * Validates saved options
     *
     * @since       1.0.0
     * @param       array       $input          array of submitted plugin options
     * @return      array                       array of validated plugin options
     */
    public function validate_options( $input ) {


        $valid      = array();
        $options    = $this->get_options_list();

        foreach ($options as $option) {

            $name = $option[0];
            $type = $option[1];

            $valid[$option[0]] = $this->sanitize( $type, $input[$name] );

        }


        return $valid;

    }

    public function sanitize($type, $data) {

        $sanitized = '';

        /**
         * Add additional santization before the default sanitization
         */
        do_action( 'wjf_portfolio_pre_stanitize', $sanitized );

        switch ( $type ) {

            case 'select'           : $sanitized = sanitize_text_field( $data ); break;
            case 'text'             : $sanitized = sanitize_text_field( $data ); break;

        } // switch

        /**
         * Add additional santization after the default .
         */
        do_action( 'wjf_portfolio_post_stanitize', $sanitized );

        return $sanitized;

    } // clean()

    /**
     * Performs general cleaning functions on data
     *
     * @param   mixed   $input      Data to be cleaned
     * @return  mixed   $return     The cleaned data
     */
    private function sanitize_random( $input ) {

            $one    = trim( $input );
            $two    = stripslashes( $one );
            $return = htmlspecialchars( $two );

        return $return;

    } // sanitize_random()

    /**
     * Retrieve the plugin settings.
     *
     * @since     1.0.0
     * @return    string    The options array of the plugin.
     */
    public function get_options() {

        return $this->options;

    }//get_options()

}