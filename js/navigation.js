/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	const siteNavigation = document.getElementById( 'site-navigation' );

	// Return early if the navigation don't exist.
	if ( ! siteNavigation ) {
		return;
	}

	const button = siteNavigation.getElementsByTagName( 'button' )[ 0 ];

	// Return early if the button don't exist.
	if ( 'undefined' === typeof button ) {
		return;
	}

	const menu = siteNavigation.getElementsByTagName( 'ul' )[ 0 ];

	// Hide menu toggle button if menu is empty and return early.
	if ( 'undefined' === typeof menu ) {
		button.style.display = 'none';
		return;
	}

	if ( ! menu.classList.contains( 'nav-menu' ) ) {
		menu.classList.add( 'nav-menu' );
	}

	// Toggle the .toggled class and the aria-expanded value each time the button is clicked.
	button.addEventListener( 'click', function() {
		siteNavigation.classList.toggle( 'toggled' );

		if ( button.getAttribute( 'aria-expanded' ) === 'true' ) {
			button.setAttribute( 'aria-expanded', 'false' );
			button.classList.remove( 'is-active' );
			closeMobileNav();
		} else {
			button.setAttribute( 'aria-expanded', 'true' );
			button.classList.add( 'is-active' );
			openMobileNav();
		}
	} );

	// Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
	document.addEventListener( 'click', function( event ) {
		const isClickInside = siteNavigation.contains( event.target );

		if ( ! isClickInside ) {
			siteNavigation.classList.remove( 'toggled' );
			button.setAttribute( 'aria-expanded', 'false' );
			button.classList.remove( 'is-active' );
			closeMobileNav();
		}
	} );

	function openMobileNav() {
    const headerHeight = document.querySelector('.site-header').clientHeight;
		const navHeight = window.innerHeight - headerHeight;
		if(window.innerWidth < 768) {
			gsap.to('.main-navigation > div', {height: navHeight, duration: 0.67, ease: "power3.out"});
		}
	}

	function closeMobileNav() {
		if(window.innerWidth < 768) {
			gsap.to('.main-navigation > div', {height: "0", duration: 0.67, ease: "power3.out"});
		}
	}


	// Get all the li elements with children within the menu.
	const lisWithChildren = menu.querySelectorAll( '.menu-item-has-children, .page_item_has_children' );

	// Add event listeners
	for ( const li of lisWithChildren ) {
		// li.addEventListener( 'touchstart', toggleFocus, false );
		li.addEventListener( 'click', toggleFocus, false );
	}

	// Toggle focus
	function toggleFocus() {
		event.stopPropagation();
		if(event.target.classList.contains('menu-item-has-children'))
			this.classList.toggle('focus');
			const submenu = this.querySelector('.sub-menu');
			let h = 0;
			if(this.classList.contains('focus')) {
				h = 'auto';
			}
			if(window.innerWidth < 768) {
				gsap.to(submenu, {height: h, duration: 0.67, ease: "power3.out"});
			}
	
	}

	window.addEventListener('resize', resizeMenus);

	function resizeMenus() {
		if(window.innerWidth < 768) {
			document.querySelector('.main-navigation > div').style.height = 0;
			document.querySelectorAll('.main-navigation > div ul.nav-menu .sub-menu').forEach(item => {
				item.style.width = 'auto';
			});
		}
		else {
			document.querySelector('.main-navigation > div').style.height = 'auto';
			document.querySelectorAll('.main-navigation .menu-item').forEach(item => {
				item.classList.remove('focus');
				item.querySelectorAll('.sub-menu .sub-menu').forEach(subItem => {
					subItem.style.width = 0;
				});
			});
			document.querySelectorAll('.main-navigation #primary-menu > .menu-item > .sub-menu').forEach(el => {
				el.style.height = 0;
			});
		}
	}

}() );

