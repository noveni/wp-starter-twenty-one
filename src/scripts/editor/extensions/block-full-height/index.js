import classnames from 'classnames';

import { addFilter } from '@wordpress/hooks';
import { Fragment } from '@wordpress/element';
import { InspectorAdvancedControls } from '@wordpress/block-editor';
import { ToggleControl } from '@wordpress/components';
import { createHigherOrderComponent } from '@wordpress/compose';

const authorizedBlocks = [ 'core/group' ];

const addAttributes = (settings, name) => {

  if ( typeof settings.attributes !== 'undefined' && authorizedBlocks.includes( settings.name ) ) {
    settings.attributes = Object.assign(settings.attributes, {
      ecrannoirtwentyone_block_full_height: {
        type: 'boolean',
      }
    });
  }
  return settings;
}

const withAttributesControls = createHigherOrderComponent((BlockEdit) => {
	return (props) => {
		const { attributes, setAttributes, isSelected } = props;
		return (
			<Fragment>
				<BlockEdit {...props} />
				{isSelected && (authorizedBlocks.includes( props.name )) && 
					<InspectorAdvancedControls>
            <ToggleControl
              label='Full Height'
              checked={!!attributes.ecrannoirtwentyone_block_full_height}
              onChange={(newval) => setAttributes({ ecrannoirtwentyone_block_full_height: !attributes.ecrannoirtwentyone_block_full_height })}
            />
					</InspectorAdvancedControls>
				}
			</Fragment>
		);
	};
}, 'withAttributesControls');

const applyExtraClass = (extraProps, blockType, attributes) => {
	const { ecrannoirtwentyone_block_full_height } = attributes;
 
  if ( typeof ecrannoirtwentyone_block_full_height !== 'undefined' && ecrannoirtwentyone_block_full_height && authorizedBlocks.includes( blockType.name ) ) {
    extraProps.className = classnames( extraProps.className, 'ecrannoirtwentyone-is-full-height' );
	}
	return extraProps;
}


addFilter(
  'blocks.registerBlockType', 
  'ecrannoirtwentyone/block-full-height-attributes', 
  addAttributes
)

addFilter(
	'editor.BlockEdit',
	'ecrannoirtwentyone/block-full-height-attributes-controls',
	withAttributesControls
);
 
addFilter(
	'blocks.getSaveContent.extraProps',
	'ecrannoirtwentyone/block-full-height-attributes-apply-class',
	applyExtraClass
);

