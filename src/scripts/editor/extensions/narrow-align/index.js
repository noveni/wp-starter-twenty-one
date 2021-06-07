import classnames from 'classnames';

import { addFilter } from '@wordpress/hooks';
import { Fragment } from '@wordpress/element';
import { InspectorControls, InspectorAdvancedControls } from '@wordpress/block-editor';
import { ToggleControl, PanelBody } from '@wordpress/components';
import { createHigherOrderComponent } from '@wordpress/compose';

const authorizedBlocks = [ 'core/paragraph', 'core/list' ];

const addAttributes = (settings, name) => {

  if ( typeof settings.attributes !== 'undefined' && authorizedBlocks.includes( settings.name ) ) {
    settings.attributes = Object.assign(settings.attributes, {
      ecrannoirtwentyone_align_narrow: {
        type: 'boolean',
				default: false,
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
					<InspectorControls>
            <PanelBody title='Alignement'>
							<ToggleControl
								label='Align Narrow'
								checked={!!attributes.ecrannoirtwentyone_align_narrow}
								onChange={() => setAttributes({ ecrannoirtwentyone_align_narrow: !attributes.ecrannoirtwentyone_align_narrow })}
							/>
						</PanelBody>
					</InspectorControls>
				}
			</Fragment>
		);
	};
}, 'withAttributesControls');

const applyExtraClass = (extraProps, blockType, attributes) => {
	const { ecrannoirtwentyone_align_narrow } = attributes;
 
  if ( typeof ecrannoirtwentyone_align_narrow !== 'undefined' && ecrannoirtwentyone_align_narrow && authorizedBlocks.includes( blockType.name ) ) {
    extraProps.className = classnames( extraProps.className, 'ecrannoirtwentyone-align-narrow' );
	}
	return extraProps;
}


addFilter(
  'blocks.registerBlockType', 
  'ecrannoirtwentyone/block-narrow-align-attributes', 
  addAttributes
)

addFilter(
	'editor.BlockEdit',
	'ecrannoirtwentyone/block-narrow-align-attributes-controls',
	withAttributesControls
);
 
addFilter(
	'blocks.getSaveContent.extraProps',
	'ecrannoirtwentyone/block-narrow-align-attributes-apply-class',
	applyExtraClass
);

