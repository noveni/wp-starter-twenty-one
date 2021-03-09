<?php 

function ecrannoir_twenty_one_add_term_fields( $taxonomy ) {

    echo '<a href="#" class="ecrannoirtwentyone-upl">Upload image</a>
            <a href="#" class="ecrannoirtwentyone-rmv" style="display:none">Remove image</a>
            <input type="hidden" name="ecrannoirtwentyone-img" value="">';
}

add_action( 'category_add_form_fields', 'ecrannoir_twenty_one_add_term_fields' );

 
function ecrannoir_twenty_one_edit_term_fields( $term, $taxonomy ) {
 
	$image_id = get_term_meta( $term->term_id, 'ecrannoirtwentyone-img', true );

    echo '<tr class="form-field">
	<th>
		<label for="ecrannoirtwentyone-text">Text Field</label>
	</th>
	<td>';
    if( $image = wp_get_attachment_image_src( $image_id ) ) {
 
        echo '<a href="#" class="ecrannoirtwentyone-upl"><img src="' . $image[0] . '" /></a>
              <a href="#" class="ecrannoirtwentyone-rmv">Remove image</a>
              <input type="hidden" name="ecrannoirtwentyone-img" value="' . $image_id . '">';
     
    } else {
     
        echo '<a href="#" class="ecrannoirtwentyone-upl">Upload image</a>
              <a href="#" class="ecrannoirtwentyone-rmv" style="display:none">Remove image</a>
              <input type="hidden" name="ecrannoirtwentyone-img" value="">';
     
    }

    echo '<p class="description">Field description may go here.</p>
	</td>
	</tr>';
 
}
add_action( 'category_edit_form_fields', 'ecrannoir_twenty_one_edit_term_fields', 10, 2 );


add_action( 'created_category', 'ecrannoir_twenty_one_save_term_fields' );
add_action( 'edited_category', 'ecrannoir_twenty_one_save_term_fields' );
 
function ecrannoir_twenty_one_save_term_fields( $term_id ) {
 
	update_term_meta(
		$term_id,
		'ecrannoirtwentyone-img',
		sanitize_text_field( $_POST[ 'ecrannoirtwentyone-img' ] )
	);
 
}
