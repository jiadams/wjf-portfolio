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
<div class="grid-item" >
    <div class="works-img-container">
        <a href="<?php echo esc_url( get_post_permalink() ) ?>">
            <img src="<?php the_post_thumbnail_url('full')?>" alt="<?php the_title(); ?>">
        </a>
    </div>
    <div class="works-title-container">
        <div class="entry-arrow"></div>
        <?php the_title( '<h3><a href="' . esc_url( get_post_permalink() ) . '">', '</a></h3>' );?>
    </div>
</div>