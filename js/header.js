/**
 * File header.js.
 *
 * Header
 *
 * 
 */

 ( function( $ ) {

  // pad top of site to height of sticky header
  const padTop = () => {
    const headerHeight = document.querySelector('.site-header').clientHeight;
    document.body.style.paddingTop = `${headerHeight}px`;
  };

  window.addEventListener('load', padTop);
  window.addEventListener('resize', padTop);

}() );
