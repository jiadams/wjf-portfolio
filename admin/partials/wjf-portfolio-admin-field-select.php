<?php

/**
 * Provides the markup for any select field
 *
 * @link       https://github.com/jiadams/
 * @since      1.0.0
 *
 * @package    Wjf_Portfolio
 * @subpackage Wjf_Portfolio/admin/partials
 */

if ( ! empty( $atts['label'] ) ) {

?><label for="<?php echo esc_attr( $atts['id'] ); ?>"><?php esc_html_e( $atts['label'], 'wjf-portfolio' ); ?>: </label><?php

}

?><select
aria-label="<?php esc_attr( _e( $atts['aria'], 'wjf-portfolio' ) ); ?>"
class="<?php echo esc_attr( $atts['class'] ); ?>"
id="<?php echo esc_attr( $atts['id'] ); ?>"
name="<?php echo esc_attr( $atts['name'] ); ?>"><?php

if ( ! empty( $atts['blank'] ) ) {

    ?><option value><?php esc_html_e( $atts['blank'], 'wjf-portfolio' ); ?></option><?php

}

foreach ( $atts['selections'] as $selection ) {

if ( is_array( $selection ) ) {

    $label = $selection['label'];
    $value = $selection['value'];

} else {

    $label = strtolower( $selection );
    $value = strtolower( $selection );

}

?><option
    value="<?php echo esc_attr( $value ); ?>" <?php
    selected( $atts['value'], $value ); ?>><?php

    esc_html_e( $label, 'wjf-portfolio' );

?></option><?php

} // foreach

?></select>
<p class="description"><?php esc_html_e( $atts['description'], 'wjf-portfolio' ); ?></p>
</label>
