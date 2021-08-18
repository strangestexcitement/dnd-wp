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


}() );