/**
 * File modals.js.
 *
 * Modals
 *
 * 
 */

 ( function( $ ) {

  // attributions modal
  const attributionsTrigger = document.querySelector(".attributions__trigger");
  attributionsTrigger.addEventListener('click', event => {
    document.querySelector('.attributions').classList.add('attributions--show');
  });

  const attributionsOverlay = document.querySelector('.attributions__overlay');
  attributionsOverlay.addEventListener('click', event => {
    document.querySelector('.attributions').classList.remove('attributions--show');
  });

  const attributionsClose = document.querySelector('.attributions__close');
  attributionsClose.addEventListener('click', event => {
    document.querySelector('.attributions').classList.remove('attributions--show');
    attributionsClose.blur();
  });

  const attributionLinks = document.querySelectorAll('.attributions__attribution a');
  attributionLinks.forEach(link => {
    link.target = "_blank";
    link.addEventListener('click', event => {
      document.querySelector('.attributions').classList.remove('attributions--show');
      link.blur();
    });
  });

}() );
