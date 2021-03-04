import SliderImage from './slider-image';

export const Slider = ( props ) => {
  const {
    isSelected,
    images,
    selectedImage,
    onMoveBackward,
		onMoveForward,
		onRemoveImage,
		onSelectImage,
		onDeselectImage,
  } = props;

  return (
    <ul className="block-cover-slider-gallery">
    { images.map( ( img, index ) => { 
      return (
        <li className={ img.id || img.url }>
          <SliderImage
            url={img.url}
            id={img.id }
            isFirstItem={ index === 0 }
            isLastItem={ index + 1 === images.length }
            isSelected={
              isSelected && selectedImage === index
            }
            onMoveBackward={ onMoveBackward( index ) }
            onMoveForward={ onMoveForward( index ) }
            onRemove={ onRemoveImage( index ) }
            onSelect={ onSelectImage( index ) }
            onDeselect={ onDeselectImage( index ) }
          />
        </li>
      )
    })}
    </ul>
  )
}
export default Slider;
