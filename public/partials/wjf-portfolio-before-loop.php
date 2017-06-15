<?php 
/**
 * WJF Portfolio loop content
 * 
 * Loop content of the works
 *
 * @link       https://github.com/jiadams/
 * @since      1.0.0
 *
 * @package    Wjf_Portfolio
 * @subpackage Wjf_Portfolio/public/partials
 */

?>

<div class="works-container">
    <?php 
        $terms = get_terms( 'work_type' );
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :?>
            <ul class="works-tax-list">
                <li>All</li>
            <?php foreach ( $terms as $term ) : ?>
                <li> <?php echo $term->name; ?> </li>
            <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <div class="grid">