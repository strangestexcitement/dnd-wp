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

        if(!accordion.classList.contains('closed')) {
          gsap.to(accordion_content, {height: 0});
        }
        else {
          gsap.to(accordion_content, {height: "auto", duration: 0.67, ease: "power3.out"});
        }

        accordion.classList.toggle('closed');
      }
    });
  });

  // expand all accordions when window is resized to 768px or above
  window.addEventListener('resize', event => {
    if(window.innerWidth >= 768) {
      npc_accordions.forEach(element => {
        const accordion = element.parentNode;
        const accordion_content = accordion.querySelector('.npc__accordion__content');
        accordion.classList.remove('closed');
        accordion_content.style.height = "auto";
      });
    }
  });

}() );
