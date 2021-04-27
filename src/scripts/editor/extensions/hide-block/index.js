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

const addAttributes = (settings, name) => {
  if ( typeof settings.attributes !== 'undefined') {
    settings.attributes = Object.assign(settings.attributes, {
      ecrannoirtwentyoneHideBlock: {
        type: 'boolean',
      }
    });
  }
  return settings;
}

const withHideChoice = createHigherOrderComponent( BlockEdit => {
	return ( props ) => {
    const { attributes, setAttributes, isSelected } = props;
		if (isSelected ) {
      
			return (
				<Fragment>
					<BlockEdit { ...props } />
          <InspectorAdvancedControls>
            <ToggleControl
              label='Hide Block'
              checked={!!attributes.ecrannoirtwentyoneHideBlock}
              onChange={() => setAttributes({ ecrannoirtwentyoneHideBlock: !attributes.ecrannoirtwentyoneHideBlock })}
            />
					</InspectorAdvancedControls>
				</Fragment>
			);
		}

		return <BlockEdit { ...props } />;
	};
}, 'withPaddingChoice' );

function applyExtraClass(extraProps, blockType, attributes) {
	const { ecrannoirtwentyoneHideBlock } = attributes;
 
  if ( typeof ecrannoirtwentyoneHideBlock !== 'undefined' && ecrannoirtwentyoneHideBlock ) {

    extraProps.className = classnames( extraProps.className, 'ecrannoirtwentyone-no-padding' );
	}
	return extraProps;
}


addFilter(
  'blocks.registerBlockType',
  'ecrannoirtwentyone/hide-block-attributes',
  addAttributes
);

addFilter(
	'editor.BlockEdit',
	'ecrannoirtwentyone/hide-block',
	withHideChoice
);

addFilter(
	'blocks.getSaveContent.extraProps',
	'ecrannoirtwentyone/hide-block-apply-class',
	applyExtraClass
);
