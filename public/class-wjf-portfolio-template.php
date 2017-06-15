<?php

/**
 * The page template functionality of the plugin.
 *
 * 
 * @link       https://github.com/jiadams/
 * @since      1.0.0
 *
 * @package    Wjf_Portfolio
 * @subpackage Wjf_Portfolio/public
 * @author     Josh Adams <jadams@wjfmakreting.com>
 */


class WJF_Portfolio_Template {


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

    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    } // __construct()

    /**
     * Includes the wjf-portfolio-before-loop
     *
     * @hooked      wjf-portfolio-before-loop       10
     *
     * @param       object      $work       A post object
     */
    public function before_work_loop() {

        include plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-before-loop.php';
    
    }

    /**
     * Includes the wjf-portfolio-loop-content
     *
     * @hooked      wjf-portfolio-loop-content      10
     *
     * @param       object      $work       A post object
     */
    public function list_work_content( $works ) {

        include plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-loop-content.php';
    
    }

    /**
     * Includes the wjf-portfolio-after-loop
     *
     * @hooked      wjf-portfolio-after-loop       10
     *
     * @param       object      $work       A post object
     */
    public function after_work_loop() {

        include plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-after-loop.php';
    
    }

}