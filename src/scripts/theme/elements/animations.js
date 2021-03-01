import { gsap } from 'gsap';
import { SplitText } from "gsap/SplitText";
import { DrawSVGPlugin } from "gsap/DrawSVGPlugin";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(SplitText, DrawSVGPlugin, ScrollTrigger);


const prefixAnim = 'theme-anim-';


/**
 *  Banner Text Slider,
 *  banner-text-slider
 */
const BannerTextSlider = () => {
  const animName = 'banner-text-slider',
  selectorName = `.${prefixAnim}${animName}`,
  bannerTexts = document.querySelectorAll(selectorName);
  
  
  if (bannerTexts.length) {
    gsap.set(selectorName, {x: '-50%'})
    // const boxWidth = bannerTexts[0].offsetWidth,
    //       totalWidth = boxWidth * bannerTexts.length,
    //       dirFromLeft = "+=" + totalWidth,
    //       dirFromRight = "-=" + totalWidth;

    // console.log({totalWidth, 'window.innerWidth': window.innerWidth, boxWidth});

    // const windowWrap = gsap.utils.wrap(0, window.innerWidth);

    gsap.utils.toArray(`${selectorName}`).forEach(function(elem, index, array) {

      var splitCoverText = new SplitText(elem, {type: "lines, words", linesClass: animName + "-split-line", wordsClass: animName + "-split-word", position: "absolute"});
      const textWidth = splitCoverText.words.reduce((carry, target) => {
        return carry + target.offsetWidth;
      }, 0);
      const bannerWidth = elem.offsetWidth > textWidth + 150 ? elem.offsetWidth : textWidth + 150;
      
      gsap.set(splitCoverText.words, {
        x: (i, target, targets) => target.offsetLeft,
        left: 0,
      });
      var mod = gsap.utils.wrap(0, bannerWidth);

      gsap.to(splitCoverText.words, {
        x: `+=${bannerWidth}`,
        modifiers: {
          // x: gsap.utils.unitize(x => parseFloat(x) % bannerWidth)
          x: x => mod(parseFloat(x)) + "px"
        },
        ease: 'none',
        duration: 15,
        repeat: -1
      });
    });

  }

}

const animateTexts = (splitText, direction) => {
  direction = direction | 1;
  const x = 0,
      y = direction * 100;
  // Title
  gsap.fromTo(splitText.words,{ y: y, autoAlpha: 0 }, {duration: 0.3, y: 0, autoAlpha: 1, ease: "power4.easeOut", stagger: 0.1});
}

const animateHide = (elem) => gsap.set(elem, {autoAlpha: 0})


const animateImg = (elem, direction) => {
  direction = direction | 1;
  const tl = gsap.timeline({
    defaults: {ease: "power3.easeOut"}
  });

  const evolution = direction * 100;
  tl.fromTo(elem, {autoAlpha:0, y:-100}, {duration: 0.5, autoAlpha:1, y:0})
}

/**
 *  Banner Image Reveal,
 *  value: 'img-reveal'
 */
const imgReveal = () => {
  const imgBlock = document.querySelectorAll(`[class*=${prefixAnim}img-reveal]`);
  if (imgBlock.length) {
    gsap.utils.toArray(`[class*=${prefixAnim}img-reveal]`).forEach(function(elem) {
      ScrollTrigger.create({
        trigger: elem,
        onEnter: function() { animateImg(elem) }, 
        onEnterBack: function() { animateImg(elem, -1) },
        onLeave: function() { animateHide(elem) }, // assure that the element is hidden when scrolled into view
      });
    });
  }
}

const animateSimpleBlocks = (elem) => {
  const tl = gsap.timeline({ defaults: {ease: "power4.easeOut"} });
  tl.fromTo(elem, { y:-100, autoAlpha: 0}, {duration: 0.4, y: 0, autoAlpha: 1})
}

/**
 *  Banner Media Reveal,
 *  value: 'block-media-reveal'
 */
const blockMediaReveal = () => {
  const animName = 'block-media-reveal',
  selectorName = `.${prefixAnim}${animName}`,
  elements = document.querySelectorAll(selectorName);

  if (elements.length) {

    gsap.utils.toArray(`${selectorName}`).forEach(function(elem) {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: elem,
        }
      });

      const media = elem.querySelector('.wp-block-media-text__media'),
            texts = elem.querySelectorAll('p'),
            titles = elem.querySelectorAll('h1, h2, h3, h4, h5, h6'),
            btn = elem.querySelectorAll('.wp-block-button');

      if (media) {
        gsap.set(media, { autoAlpha: 0});
        tl.add(() => { animateImg(media) }, "+=0.4")
      }
      if (titles.length) {
        const splitText = new SplitText(titles, {type: "lines, words", linesClass: "split-line", wordsClass: "cover-split-word"});
        gsap.set(splitText.words, { autoAlpha: 0});
        tl.add(() => { animateTexts(splitText) }, "+=0.4")
      }
      if (texts.length) {
        gsap.set(texts, { autoAlpha: 0});
        tl.add(() => { animateSimpleBlocks(texts) }, "+=0.4")
      }
      if (btn.length) {
        gsap.set(btn, { autoAlpha: 0});
        tl.add(() => { animateSimpleBlocks(btn) }, "+=0.4")
      }
    });
  }
}

/** 
 * Simple Reveal
 * block-simple-reveal
 */
const blockSimpleReveal = () => {
  const animName = 'block-simple-reveal',
  selectorName = `.${prefixAnim}${animName}`,
  elements = document.querySelectorAll(selectorName);

  if (elements.length) {
    gsap.utils.toArray(`${selectorName}`).forEach(function(elem) {

      const tl = gsap.timeline({
        defaults: { ease: "power4.inOut" },
        scrollTrigger: {
          trigger: elem,
        }
      });

      tl.fromTo(elem, {y:-100, autoAlpha: 0}, {duration: 0.4, y: 0, autoAlpha: 1})

    })
  }
}

/** 
 * Reveal From Left
 * reveal-from-left
 */
const simpleRevealFromLeft = () => {
  const animName = 'reveal-from-left',
  selectorName = `.${prefixAnim}${animName}`,
  elements = document.querySelectorAll(selectorName);

  if (elements.length) {
    gsap.utils.toArray(`${selectorName}`).forEach(function(elem) {

      const tl = gsap.timeline({
        defaults: { ease: "power4.inOut" },
        scrollTrigger: {
          trigger: elem,
        }
      });

      tl.fromTo(elem, {x: 100, autoAlpha: 0}, {duration: 0.4, x: 0, autoAlpha: 1})

    })
  }
}

/** 
 * Reveal From Right
 * reveal-from-right
 */
const simpleRevealFromRight = () => {
  const animName = 'reveal-from-right',
  selectorName = `.${prefixAnim}${animName}`,
  elements = document.querySelectorAll(selectorName);

  if (elements.length) {
    gsap.utils.toArray(`${selectorName}`).forEach(function(elem) {

      const tl = gsap.timeline({
        defaults: { ease: "power4.inOut" },
        scrollTrigger: {
          trigger: elem,
        }
      });

      tl.fromTo(elem, {x: -100, autoAlpha: 0}, {duration: 0.4, x: 0, autoAlpha: 1})

    })
  }
}

/** 
 * Reveal From Bottom
 * reveal-from-bottom
 */
const simpleRevealFromBottom = () => {
  const animName = 'reveal-from-bottom',
  selectorName = `.${prefixAnim}${animName}`,
  elements = document.querySelectorAll(selectorName);

  if (elements.length) {

    gsap.utils.toArray(`${selectorName}`).forEach(function(elem) {
      const tl = gsap.timeline({
        // defaults: { ease: "power4.inOut" },
        scrollTrigger: {
          trigger: elem,
        }
      });

      tl.fromTo(elem, {y: -100, autoAlpha: 0}, {duration: 0.4, y: 0, autoAlpha: 1})
    });
  }
}
/**
 * Reveal Multiple items From Bottom With Stagger
 * reveal-lists-from-bottom-stagger
 */
const RevealFromBottomStagger = () => {
  const animName = 'reveal-lists-from-bottom-stagger',
  selectorName = `.${prefixAnim}${animName}`,
  elements = document.querySelectorAll(selectorName);

  if (elements.length) {

    gsap.utils.toArray(`${selectorName}`).forEach(function(element) {
      const items = element.children;
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: element,
        }
      });

      tl.fromTo(items, {y: -100, autoAlpha: 0}, {duration: 0.4, y: 0, autoAlpha: 1, stagger: 0.3})
    })
  }
}

/** 
 * Reveal Text From Bottom
 * reveal-text-from-bottom
 */
const revealTextFromBottom = () => {
  const animName = 'reveal-text-from-bottom',
  selectorName = `.${prefixAnim}${animName}`,
  elements = document.querySelectorAll(selectorName);

  if (elements.length) {

    gsap.utils.toArray(`${selectorName}`).forEach(function(elem) {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: elem,
        }
      });

      const splitText = new SplitText(elem, {type: "lines, words", linesClass: "split-line", wordsClass: "cover-split-word"});
      gsap.set(splitText.words, { autoAlpha: 0});
      tl.add(() => { animateTexts(splitText, -1) }, "+=0.4")
    });
  }
}
// When block are on multiple line like grid
const batchBlockAppear = () => {
  const animName = 'batch-blocks',
  selectorName = `.${prefixAnim}${animName}`,
  elements = document.querySelectorAll(selectorName);

  if (elements.length) {

    gsap.utils.toArray(`${selectorName}`).forEach(function(element) {
      const items = element.children;
      ScrollTrigger.batch(items, {
        onEnter: batch => gsap.fromTo(batch, {y: -100, autoAlpha: 0}, {autoAlpha: 1, y: 0, stagger: {each: 0.15}, overwrite: true, clearProps:"transform"}),
      })
    })
  }  
}
// eslint-disable-next-line no-unused-vars
export default {
  init() {
    batchBlockAppear();
    BannerTextSlider();
    blockMediaReveal();
    blockSimpleReveal();

    simpleRevealFromLeft();
    simpleRevealFromRight();
    simpleRevealFromBottom();
    revealTextFromBottom();
    RevealFromBottomStagger();
    imgReveal();
  },
  finalize() {
  },
};
