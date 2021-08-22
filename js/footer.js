/**
 * File footer.js.
 *
 * Footer
 *
 * 
 */

 ( function( $ ) {

  // pad bottom of site to height of absolutely positioned footer
  const padBottom = () => {
    const footerHeight = document.querySelector('.site-footer').clientHeight;
    document.querySelector('.site').style.paddingBottom = `${footerHeight}px`;
  };

  window.addEventListener('load', padBottom);
  window.addEventListener('resize', padBottom);

}() );
