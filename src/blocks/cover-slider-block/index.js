/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { postList as icon } from '@wordpress/icons';
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import edit from './edit';
import save from './save';

registerBlockType('ecrannoirtwentyone/cover-slider', {
  title:  __( 'Cover Slider' ),
  description: __( 'Display a slider cover.' ),
  icon: 'slides',
  category: 'common',
  keywords: [ __( 'recent posts' ) ],
  supports: {
    align: ['wide', 'full'],
    html: false,
    color: {
			gradients: true,
			link: true
		},
  },
  example: {},
  attributes: {
    imageIds: {
      type: 'array',
    },
    globalContent: {
      type: 'string',
      default: ''
    }
  },
  edit,
  save
});
