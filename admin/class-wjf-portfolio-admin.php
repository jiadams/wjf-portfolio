<?php


/**
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript
 *
 * @link       https://github.com/jiadams/
 * @since      1.0.0
 *
 * @package    Wjf_Portfolio
 * @subpackage Wjf_Portfolio/admin
 * @author     Josh Adams <jadams@wjfmakreting.com>
 */

class Wjf_Portfolio_Admin {

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
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    public function settings_init() {

        $settings = new Wjf_Portfolio_Admin_Settings();

    }

    /**
     * Register the stylesheets for the admin area.
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

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wjf-portfolio-admin.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the admin area.
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

        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wjf-portfolio-admin.js', array( 'jquery' ), $this->version, false );

    }

    /**
     * Registers new post type for portfolio
     * 
     * @since 1.0.0 
     * @access public
     * @uses new_porfolio()
     */

    public static function new_cpt_portfolio() {
        $cap_type   = 'post';
        $plural     = 'Works';
        $single     = 'Work';
        $wjfport_name   = 'work';

        $args['can_export']                             = TRUE;
        $args['capability_type']                        = $cap_type;
        $args['description']                            = '';
        $args['exclude_from_search']                    = FALSE;
        $args['has_archive']                            = FALSE;
        $args['hierarchical']                           = FALSE;
        $args['map_meta_cap']                           = TRUE;
        $args['menu_icon']                              = 'dashicons-desktop';
        $args['menu_position']                          = 25;
        $args['public']                                 = TRUE;
        $args['publicly_querable']                      = TRUE;
        $args['query_var']                              = TRUE;
        $args['register_meta_box_cb']                   = '';
        $args['rewrite']                                = FALSE;
        $args['show_in_admin_bar']                      = TRUE;
        $args['show_in_menu']                           = TRUE;
        $args['show_in_nav_menu']                       = TRUE;
        $args['show_ui']                                = TRUE;
        $args['supports']                               = array( 'title', 'editor', 'thumbnail' );
        $args['taxonomies']                             = array();

        $args['capabilities']['delete_others_posts']    = "delete_others_{$cap_type}s";
        $args['capabilities']['delete_post']            = "delete_{$cap_type}";
        $args['capabilities']['delete_posts']           = "delete_{$cap_type}s";
        $args['capabilities']['delete_private_posts']   = "delete_private_{$cap_type}s";
        $args['capabilities']['delete_published_posts'] = "delete_published_{$cap_type}s";
        $args['capabilities']['edit_others_posts']      = "edit_others_{$cap_type}s";
        $args['capabilities']['edit_post']              = "edit_{$cap_type}";
        $args['capabilities']['edit_posts']             = "edit_{$cap_type}s";
        $args['capabilities']['edit_private_posts']     = "edit_private_{$cap_type}s";
        $args['capabilities']['edit_published_posts']   = "edit_published_{$cap_type}s";
        $args['capabilities']['publish_posts']          = "publish_{$cap_type}s";
        $args['capabilities']['read_post']              = "read_{$cap_type}";
        $args['capabilities']['read_private_posts']     = "read_private_{$cap_type}s";

        $args['labels']['add_new']                      = esc_html__( "Add New {$single}", 'wjf-portfolio' );
        $args['labels']['add_new_item']                 = esc_html__( "Add New {$single}", 'wjf-portfolio' );
        $args['labels']['all_items']                    = esc_html__( $plural, 'Dealer Part Source' );
        $args['labels']['edit_item']                    = esc_html__( "Edit {$single}" , 'Dealer Part Source' );
        $args['labels']['menu_name']                    = esc_html__( $plural, 'wjf-portfolio' );
        $args['labels']['name']                         = esc_html__( $plural, 'wjf-portfolio' );
        $args['labels']['name_admin_bar']               = esc_html__( $single, 'wjf-portfolio' );
        $args['labels']['new_item']                     = esc_html__( "New {$single}", 'wjf-portfolio' );
        $args['labels']['not_found']                    = esc_html__( "No {$plural} Found", 'wjf-portfolio' );
        $args['labels']['not_found_in_trash']           = esc_html__( "No {$plural} Found in Trash", 'wjf-portfolio' );
        $args['labels']['parent_item_colon']            = esc_html__( "Parent {$plural} :", 'wjf-portfolio' );
        $args['labels']['search_items']                 = esc_html__( "Search {$plural}", 'wjf-portfolio' );
        $args['labels']['singular_name']                = esc_html__( $single, 'wjf-portfolio' );
        $args['labels']['view_item']                    = esc_html__( "View {$single}", 'wjf-portfolio' );

        $args['rewrite']['ep_mask']                     = EP_PERMALINK;
        $args['rewrite']['feeds']                       = FALSE;
        $args['rewrite']['pages']                       = TRUE;
        $args['rewrite']['slug']                        = esc_html__( strtolower( $plural ), 'wjf-portfolio' );
        $args['rewrite']['with_front']                  = FALSE;

        $args = apply_filters( 'wjf-portfolio-opt', $args );

        register_post_type( strtolower( $wjfport_name ), $args );

    }//new_portfolio()

    /**
     * Registers New Taxonomy for custom post type work
     *
     * @since 1.0.0
     * @access public
     * @uses new_taxonomy_type()
     * 
     */

    public static function new_cpt_taxonomy_type() {

        $plural     = 'Work Types';
        $single     = 'Work Type';
        $tax_name   = 'work_type';

        $args['hierarchical']                           = TRUE;
        //$args['meta_box_cb']                          = '';
        $args['public']                                 = TRUE;
        $args['query_var']                              = $tax_name;
        $args['show_admin_column']                      = FALSE;
        $args['show_in_nav_menus']                      = TRUE;
        $args['show_tag_cloud']                         = TRUE;
        $args['show_ui']                                = TRUE;
        $args['sort']                                   = '';
        //$args['update_count_callback']                    = '';

        $args['capabilities']['assign_terms']           = 'edit_posts';
        $args['capabilities']['delete_terms']           = 'manage_categories';
        $args['capabilities']['edit_terms']             = 'manage_categories';
        $args['capabilities']['manage_terms']           = 'manage_categories';

        $args['labels']['add_new_item']                 = esc_html__( "Add New {$single}", 'wjf-portfolio' );
        $args['labels']['add_or_remove_items']          = esc_html__( "Add or remove {$plural}", 'wjf-portfolio' );
        $args['labels']['all_items']                    = esc_html__( $plural, 'wjf-portfolio' );
        $args['labels']['choose_from_most_used']        = esc_html__( "Choose from most used {$plural}", 'wjf-portfolio' );
        $args['labels']['edit_item']                    = esc_html__( "Edit {$single}" , 'wjf-portfolio');
        $args['labels']['menu_name']                    = esc_html__( $plural, 'wjf-portfolio' );
        $args['labels']['name']                         = esc_html__( $plural, 'Dealer Part Source' );
        $args['labels']['new_item_name']                = esc_html__( "New {$single} Name", 'wjf-portfolio' );
        $args['labels']['not_found']                    = esc_html__( "No {$plural} Found", 'wjf-portfolio' );
        $args['labels']['parent_item']                  = esc_html__( "Parent {$single}", 'wjf-portfolio' );
        $args['labels']['parent_item_colon']            = esc_html__( "Parent {$single}:", 'wjf-portfolio' );
        $args['labels']['popular_items']                = esc_html__( "Popular {$plural}", 'wjf-portfolio' );
        $args['labels']['search_items']                 = esc_html__( "Search {$plural}", 'wjf-portfolio' );
        $args['labels']['separate_items_with_commas']   = esc_html__( "Separate {$plural} with commas", 'wjf-portfolio' );
        $args['labels']['singular_name']                = esc_html__( $single, 'wjf-portfolio' );
        $args['labels']['update_item']                  = esc_html__( "Update {$single}", 'wjf-portfolio' );
        $args['labels']['view_item']                    = esc_html__( "View {$single}", 'wjf-portfolio' );

        $args['rewrite']['ep_mask']                     = EP_NONE;
        $args['rewrite']['hierarchical']                = FALSE;
        $args['rewrite']['slug']                        = esc_html__( strtolower( $tax_name ), 'wjf-portfolio' );
        $args['rewrite']['with_front']                  = FALSE;

        $args = apply_filters( 'wjf-portfolio-taxonomy-options', $args );

        register_taxonomy( $tax_name, 'work', $args );

    } // new_taxonomy_type()
}