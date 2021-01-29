<?php
/**
 * A template partial to output pagination
 * 
 */

$prev_text = sprintf(
	'%s <span class="nav-prev-text">%s</span>',
	is_rtl() ? ecrannoir_twenty_one_get_icon_svg( 'ui', 'arrow-right' ) : ecrannoir_twenty_one_get_icon_svg( 'ui', 'arrow-left'),
	__( 'Newer <span class="nav-short">posts</span>', 'ecrannoir' )
);

$next_text = sprintf(
	'<span class="nav-next-text">%s</span> %s',
	__( 'Older <span class="nav-short">posts</span>', 'ecrannoir' ),
	is_rtl() ? ecrannoir_twenty_one_get_icon_svg( 'ui', 'arrow-left' ) : ecrannoir_twenty_one_get_icon_svg( 'ui', 'arrow-right' )
);

the_posts_pagination(
	array(
		'before_page_number' => esc_html__( 'Page', 'ecrannoir' ) . ' ',
		'mid_size'           => 0,
		'prev_text'          => $prev_text,
		'next_text'          => $next_text
	)
);
