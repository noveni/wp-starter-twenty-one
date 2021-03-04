/**
 * External dependencies
 */
import {
	every,
	filter,
	find,
	forEach,
	get,
	isEmpty,
	map,
	reduce,
	some,
	toString,
} from 'lodash';
/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import {
  MediaPlaceholder,
  InspectorControls,
	InnerBlocks,
	useBlockProps,
	__experimentalUseInnerBlocksProps as useInnerBlocksProps,
} from '@wordpress/block-editor';
import { __experimentalBoxControl as BoxControl } from '@wordpress/components';
const { __Visualizer: BoxControlVisualizer } = BoxControl;
import { Platform, useEffect, useState } from '@wordpress/element';

/**
 * Internal dependencies
 */
import Slider from './slider';

/**
 * Module Constants
 */
const ALLOWED_MEDIA_TYPES = [ 'image', 'video' ];
const ALLOWED_INNER_BLOCKS = [ 'core/image', 'core/button', 'core/heading', 'core/paragraph']
const INNER_BLOCKS_TEMPLATE = [
	[
		'core/paragraph',
		{
			align: 'center',
			fontSize: 'large',
			placeholder: __( 'Write title…' ),
		},
	],
];

const pickRelevantMediaFiles = ( image, sizeSlug = 'large' ) => {
	const imageProps = pick( image, [ 'alt', 'id', 'link', 'caption' ] );
	imageProps.url =
		get( image, [ 'sizes', sizeSlug, 'url' ] ) ||
		get( image, [ 'media_details', 'sizes', sizeSlug, 'source_url' ] ) ||
		image.url;
	const fullUrl =
		get( image, [ 'sizes', 'full', 'url' ] ) ||
		get( image, [ 'media_details', 'sizes', 'full', 'source_url' ] );
	if ( fullUrl ) {
		imageProps.fullUrl = fullUrl;
	}
	return imageProps;
};

const GroupEdit = ( props ) => {

  const {
    className,
    isSelected,
    attributes,
    setAttributes,
    clientId
  } = props;
  
  const { imageIds } = attributes;

  const [ selectedImage, setSelectedImage ] = useState();

	const blockProps = useBlockProps();

  const hasInnerBlocks = useSelect(
		( select ) => {
			const { getBlock } = select( 'core/block-editor' );
			const block = getBlock( clientId );
			return !! ( block && block.innerBlocks.length );
		},
		[ clientId ]
	);

  const images = useSelect(( select ) => {
      const { getEntityRecords, getMedia } = select( 'core' );
      const { getSettings } = select( 'core/block-editor' );
		  const { imageSizes, mediaUpload } = getSettings();

      const retrievedImg = reduce(
        imageIds,
        ( currentImages, id ) => {
          if ( ! id ) {
            return currentImages;
          }
          const image = getMedia( id );

          if (!image) {
            return currentImages;
          }

          const defaultUrl = get( image, [
            'sizes',
            'full',
            'url',
          ] );
          const mediaUrl = get( image, [
            'media_details',
            'sizes',
            'full',
            'source_url',
          ] );

          const theImg = {
            id: id,
            url: defaultUrl || mediaUrl,
            link: image.link,
            alt: image.alt_text,
            caption: image.caption && image.caption.rendered,
          }

          currentImages.push(theImg)
          return currentImages;
        },
        []
      );

      return retrievedImg;
    }, 
    [
      imageIds,
      isSelected,
    ]
  )

  const onSelectImage = ( index ) => {
		return () => {
			setSelectedImage( index );
		};
	}

	const onDeselectImage = () => {
		return () => {
			setSelectedImage();
		};
	}

	const onMove = ( oldIndex, newIndex ) => {
		const newImages = [ ...imageIds ];
		newImages.splice( newIndex, 1, images[ oldIndex ].id );
		newImages.splice( oldIndex, 1, images[ newIndex ].id );
		setSelectedImage( newIndex );
		setAttributes( { imageIds: newImages } );
	}

  const onMoveForward = ( oldIndex ) => {
		return () => {
			if ( oldIndex === images.length - 1 ) {
				return;
			}
			onMove( oldIndex, oldIndex + 1 );
		};
	}

	const onMoveBackward = ( oldIndex ) => {
		return () => {
			if ( oldIndex === 0 ) {
				return;
			}
			onMove( oldIndex, oldIndex - 1 );
		};
	}

  const onRemoveImage = ( index ) => {
		return () => {
			const newImages = filter( imageIds, ( img, i ) => index !== i );
			setSelectedImage();
			setAttributes( {
				imageIds: newImages,
			} );
		};
	}

  const onSelectImages = ( newImages ) => {
		setAttributes( {
			imageIds: newImages.map( ( newImage ) => ( toString( newImage.id ) ) ),
		} );
	}

  useEffect( () => {
		// Deselect images when deselecting the block
		if ( ! isSelected ) {
			setSelectedImage();
		}
	}, [ isSelected ] );

  const hasImages = ! isEmpty(images);

	const mediaPlaceholder = (
		<MediaPlaceholder
			addToGallery={ hasImages }
			isAppender={ hasImages }
			className={ className }
			labels={ {
				title: ! hasImages && __( 'Gallery' ),
				instructions: ! hasImages && 'Add image',
			} }
			onSelect={ onSelectImages }
			accept="image/*"
			allowedTypes={ ALLOWED_MEDIA_TYPES }
			multiple
			value={ images }
		/>
	);

	const innerBlocksProps = useInnerBlocksProps(
		{
			className: 'wp-block-group__inner-container',
		},
		{
			templateLock: false,
      allowedBlocks:  ALLOWED_INNER_BLOCKS,
			renderAppender: hasInnerBlocks
				? InnerBlocks.ButtonBlockAppender
				: InnerBlocks.ButtonBlockAppender,
		}
	);

	return (
    <div className={className}>
      <div className="block-cover-slider-wrapper">
        { hasImages && (
          <Slider
            images={ images }
            isSelected={isSelected}
            selectedImage={ selectedImage }
            onMoveBackward={ onMoveBackward }
            onMoveForward={ onMoveForward }
            onRemoveImage={ onRemoveImage }
            onSelectImage={ onSelectImage }
				    onDeselectImage={ onDeselectImage }
            
          />
        )}
        { mediaPlaceholder }
      </div>
      <div { ...blockProps }>
        <div { ...innerBlocksProps } />
      </div>
    </div>
	);
}

export default GroupEdit;
