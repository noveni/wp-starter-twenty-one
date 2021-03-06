import classnames from 'classnames';
/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { ToggleControl } from '@wordpress/components';
import { createHigherOrderComponent} from '@wordpress/compose';
import { InspectorAdvancedControls, BlockControls } from '@wordpress/block-editor';
import { Fragment } from '@wordpress/element';
import { addFilter } from '@wordpress/hooks';

const authorizedBlocks = [ 'core/cover', 'core/group', 'core/columns', 'core/column', 'core/media-text', 'core/heading', 'ecrannoirtwentyone/cover-slider' ];

const addAttributes = (settings, name) => {
  if ( typeof settings.attributes !== 'undefined' && authorizedBlocks.includes( settings.name ) ) {
    settings.attributes = Object.assign(settings.attributes, {
      ecrannoirtwentyoneNoPadding: {
        type: 'boolean',
      }
    });
  }
  return settings;
}

const withPaddingChoice = createHigherOrderComponent( BlockEdit => {
	return ( props ) => {
    const { attributes, setAttributes, isSelected } = props;
		if (isSelected && authorizedBlocks.includes( props.name )) {
      
			return (
				<Fragment>
					<BlockEdit { ...props } />
          <InspectorAdvancedControls>
            <ToggleControl
              label='No Padding'
              checked={!!attributes.ecrannoirtwentyoneNoPadding}
              onChange={() => setAttributes({ ecrannoirtwentyoneNoPadding: !attributes.ecrannoirtwentyoneNoPadding })}
            />
					</InspectorAdvancedControls>
				</Fragment>
			);
		}

		return <BlockEdit { ...props } />;
	};
}, 'withPaddingChoice' );

function applyExtraClass(extraProps, blockType, attributes) {
	const { ecrannoirtwentyoneNoPadding } = attributes;
 
  if ( typeof ecrannoirtwentyoneNoPadding !== 'undefined' && ecrannoirtwentyoneNoPadding && authorizedBlocks.includes( blockType.name ) ) {

    extraProps.className = classnames( extraProps.className, 'ecrannoirtwentyone-no-padding' );
	}
	return extraProps;
}


addFilter(
  'blocks.registerBlockType',
  'ecrannoirtwentyone/no-padding-block-attributes',
  addAttributes
);

addFilter(
	'editor.BlockEdit',
	'ecrannoirtwentyone/no-padding-block',
	withPaddingChoice
);

addFilter(
	'blocks.getSaveContent.extraProps',
	'ecrannoirtwentyone/no-padding-block-apply-class',
	applyExtraClass
);
