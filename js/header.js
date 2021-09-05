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

  // add hover states to submenus
  const headerMenuItems = document.querySelectorAll('.site-header > .main-navigation > div > ul > .menu-item');

  headerMenuItems.forEach(element => {
    let subMenu = element.querySelector('.sub-menu');
    if(subMenu) {
      element.addEventListener('mouseenter', event => {
        if(window.innerWidth >= 768) {
          gsap.to(subMenu, {height: "auto", duration: 0.67, ease: "power3.out"});
        }
      }); 

      element.addEventListener('mouseleave', event => {
        if(window.innerWidth >= 768) {
          gsap.to(subMenu, {height: "0", duration: 0.67, ease: "power3.out"});
        }
      });

      let subMenuItems = element.querySelectorAll('.sub-menu > .menu-item');
      subMenuItems.forEach(item => {
        let subSubMenu = item.querySelector('.sub-menu');
        if(subSubMenu) {
          item.addEventListener('mouseenter', event => {
            if(window.innerWidth >= 768) {
              gsap.to(subSubMenu, {width: "auto", duration: 0.67, ease: "power3.out"});
            }
          }); 
    
          item.addEventListener('mouseleave', event => {
            if(window.innerWidth >= 768) {
              gsap.to(subSubMenu, {width: 0, duration: 0.67, ease: "power3.out"});
            }
          });
        }
      });
    }
  });

}() );
