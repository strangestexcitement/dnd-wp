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
        const accordion_content = accordion.querySelector('.npc__accordion__content');

        if(accordion.classList.contains('open')) {
          gsap.to(accordion_content, {height: 0});
        }
        else {
          gsap.to(accordion_content, {height: "auto", duration: 0.67, ease: "power3.out"});
        }

        accordion.classList.toggle('open');
      }
    });
  });

}() );
