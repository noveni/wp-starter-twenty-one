/**
 * Internal dependencies
 */
import DisableTitle from './controls';

/**
 * WordPress dependencies
 */
import { registerPlugin } from '@wordpress/plugins';

registerPlugin( 'ecrannoirtwentyone-disable-title', {
	icon: false,
	render: DisableTitle,
} );
