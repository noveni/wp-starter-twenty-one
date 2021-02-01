<?php
/**
 * Custom template tags for this theme
 *
 */

/**
 * Print the site Logo
 */
function ecrannoir_twenty_one_the_logo() {
    echo ecrannoir_twenty_one_get_the_logo();
}

/**
 * Get the site logo
 */
function ecrannoir_twenty_one_get_the_logo() {
    return EcranNoirTwentyOne_Icons::get_svg('brand', 'logo', false);
}
