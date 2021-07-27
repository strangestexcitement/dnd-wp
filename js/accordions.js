/**
 * File accordion.js.
 *
 * Accordions
 *
 * 
 */

( function( $ ) {
  const npc_accordions = document.querySelectorAll('.npc__accordion__heading');

  npc_accordions.forEach(element => {
    element.addEventListener('click', (event) => {
      if(window.innerWidth < 768) {
        const accordion = event.target.parentNode;
        accordion.classList.toggle('open');
      }
    });
  });

}() );
