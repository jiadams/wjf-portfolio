<?php 
/**
 * WJF Portfolio loop content
 * 
 * Loop through the works
 *
 * @link       https://github.com/jiadams/
 * @since      1.0.0
 *
 * @package    Wjf_Portfolio
 * @subpackage Wjf_Portfolio/public/partials
 */

?>
    <?php 

        do_action( 'wjf-portfolio-before-loop' );

        while ( $works->have_posts() ) : $works->the_post();

        /**
         * wjf-portfolio-loop-content hook
         *
         * @param       object      $works       The post object
         *
         * @hooked      list_work_content       10
         */
        do_action( 'wjf-portfolio-loop-content' ); 

        endwhile; // End of the loop.

        do_action( 'wjf-portfolio-after-loop' );

    ?>