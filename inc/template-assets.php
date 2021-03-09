<?php
/**
 * Functions which enhance the theme by hooking into WordPress assets
 *
 */

/** 
 * Allow SVG through WordPress Media Uploader 
 * */
function ecrannoir_twenty_one_filter_upload_mimes($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}

add_filter('upload_mimes', 'ecrannoir_twenty_one_filter_upload_mimes');

/**
 * Sanitize name file on upload
 */
function ecrannoir_twenty_one_sanitize_file_name($filename){
    $sanitized_filename = remove_accents($filename); // Convert to ASCII

	// Standard replacements
	$invalid = array(
		' ' => '-',
		'%20' => '-',
		'_' => '-'
	);
	$sanitized_filename = str_replace(array_keys($invalid), array_values($invalid), $sanitized_filename);

	$sanitized_filename = preg_replace('/[^A-Za-z0-9-\. ]/', '', $sanitized_filename); // Remove all non-alphanumeric except .
	$sanitized_filename = preg_replace('/\.(?=.*\.)/', '', $sanitized_filename); // Remove all but last .
	$sanitized_filename = preg_replace('/-+/', '-', $sanitized_filename); // Replace any more than one - in a row
	$sanitized_filename = str_replace('-.', '.', $sanitized_filename); // Remove last - if at the end
	$sanitized_filename = strtolower($sanitized_filename); // Lowercase

	return $sanitized_filename;
}
add_filter('sanitize_file_name', 'ecrannoir_twenty_one_sanitize_file_name');

/**
 * Gets the SVG code for a given icon.
 *
 * @since Twenty Twenty-One 1.0
 *
 * @param string $group The icon group.
 * @param string $icon The icon.
 * @param int    $size The icon size in pixels.
 *
 * @return string
 */
function ecrannoir_twenty_one_get_icon_svg( $group, $icon, $size = 24 ) {
	return EcranNoirTwentyOne_Icons::get_svg( $group, $icon, $size );
}



/**
 * Get Image Placeholder for image replacement
 */
function ecrannoir_twenty_one_get_image_placeholder( ) {
	$image_placeholder_default_size = [
		'width' => 600,
		'height' => 600,
	];

	$style = '';

	$url = get_template_directory_uri() . '/assets/img/placeholder-color.png';

	$className = 'attachment-post-thumbnail size-post-thumbnail wp-post-image';

	$image = sprintf('<img src="%1$s" class="%2$s" alt="" %3$s>', $url, $className, $style );

	return $image;
}
