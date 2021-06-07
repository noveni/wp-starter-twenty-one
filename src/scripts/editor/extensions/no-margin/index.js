import classnames from 'classnames';
/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { ToggleControl, PanelBody } from '@wordpress/components';
import { createHigherOrderComponent} from '@wordpress/compose';
import { InspectorControls, InspectorAdvancedControls, BlockControls } from '@wordpress/block-editor';
import { Fragment } from '@wordpress/element';
import { addFilter } from '@wordpress/hooks';

const addAttributes = (settings, name) => {
  if ( typeof settings.attributes !== 'undefined') {
    settings.attributes = Object.assign(settings.attributes, {
      ecrannoirtwentyoneNoMargin: {
        type: 'boolean',
      }
    });
  }
  return settings;
}

const withAttributesControls = createHigherOrderComponent( BlockEdit => {
	return ( props ) => {
    const { attributes, setAttributes, isSelected } = props;
		if (isSelected ) {
      
			return (
				<Fragment>
					<BlockEdit { ...props } />
          <InspectorAdvancedControls>
            <ToggleControl
              label='No Margin'
              checked={!!attributes.ecrannoirtwentyoneNoMargin}
              onChange={() => setAttributes({ ecrannoirtwentyoneNoMargin: !attributes.ecrannoirtwentyoneNoMargin })}
            />
					</InspectorAdvancedControls>
				</Fragment>
			);
		}

		return <BlockEdit { ...props } />;
	};
}, 'withAttributesControls' );

function applyExtraClass(extraProps, blockType, attributes) {
	const { ecrannoirtwentyoneNoMargin } = attributes;
 
  if ( typeof ecrannoirtwentyoneNoMargin !== 'undefined' && ecrannoirtwentyoneNoMargin ) {

    extraProps.className = classnames( extraProps.className, 'ecrannoirtwentyone-no-margin' );
	}
	return extraProps;
}


addFilter(
  'blocks.registerBlockType',
  'ecrannoirtwentyone/no-margin-block-attributes',
  addAttributes
);

addFilter(
	'editor.BlockEdit',
	'ecrannoirtwentyone/no-margin-block',
	withAttributesControls
);

addFilter(
	'blocks.getSaveContent.extraProps',
	'ecrannoirtwentyone/no-margin-block-apply-class',
	applyExtraClass
);
