import primaryMenu from '../elements/primary-navigation';
import ecrannoirtwentyoneResponsiveEmbeds from '../elements/responsive-embeds';
import skipLinkFocus from '../elements/skip-link-focus-fix';

import { touchEnabled, intrinsicRatioVideos } from '../../utils/dom';

export const getHeaderHeight = () => {
  const header = document.getElementById('site-header');
  if (header) {
    return header.offsetHeight;
  }
  return 0;
}

// :TODO: Add a way to check if first block is a cover, 
// if it is, add negative margin and check color text contrast
const addHeaderHeightAsMarginToElement = (selector) => {

	const addMargin = (elementSelector) => {
		const element = document.querySelector(elementSelector);
		const headerInner = document.querySelector('#site-header .header-inner');
		const height = headerInner ? headerInner.offsetHeight : getHeaderHeight();
	
		if (element) {
			element.style.marginTop = `${height}px`;
		}
	
	}
	
	addMargin(selector);
	window.addEventListener( 'resize', () => {
		addMargin(selector);
	});
	
}

export default {
  init() {

		let ecrannoir = ecrannoir || {};

		// Set a default value for scrolled.
		ecrannoir.scrolled = 0;

		document.documentElement.classList.remove('no-js');
		window.ecrannoir = ecrannoir;
		intrinsicRatioVideos();	// Retain aspect ratio of videos on window resize
		primaryMenu();	// Primary Menu
		touchEnabled();	// Add class to body if device is touch-enabled

		// Run on initial load.
		ecrannoirtwentyoneResponsiveEmbeds();
		skipLinkFocus();

		// Run on resize.
		window.onresize = ecrannoirtwentyoneResponsiveEmbeds;


		// addHeaderHeightAsMarginToElement('#site-content');

	},
	finalize() {
	}
}
