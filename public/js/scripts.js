/*!
* Start Bootstrap - Freelancer v7.0.7 (https://startbootstrap.com/theme/freelancer)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-freelancer/blob/master/LICENSE)
*/
//
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink')
        } else {
            navbarCollapsible.classList.add('navbar-shrink')
        }

    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    // Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-section')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });
    
});

document.addEventListener('DOMContentLoaded', function () {
    let selectedServices = {};

    document.querySelectorAll('.selectServiceButton').forEach(button => {
        button.addEventListener('click', function () {
            const service = button.getAttribute('data-service');
            console.log(service);
        });
    });

    document.querySelectorAll('.confirmSelectionButton').forEach(button => {
        button.addEventListener('click', function () {
            const service = button.getAttribute('data-service');
            const form = document.getElementById(`service${service}Form`);
            const serviceType = form.querySelector('input[name="serviceType' + service + '"]:checked').value;
            console.log('Confirmed Selection:', service, serviceType);

            // Store the selected service and type
            selectedServices[service] = serviceType;

            // Update the button to "Change" and add a deselect button
            updateServiceButton(service);
            
            // Show the proceed banner if at least one service is selected
            if (Object.keys(selectedServices).length > 0) {
                showProceedBanner();
            }
        });
    });

    document.getElementById('proceedButton').addEventListener('click', function () {
        // Pass the selected services data to the next page
        // Encode the selectedServices data into a query string
        const queryString = Object.entries(selectedServices).map(([key, value]) => {
            return `${encodeURIComponent(key)}=${encodeURIComponent(value)}`;
        }).join('&');

        // Construct the URL of the destination page with the query string
        const destinationPageUrl = 'destination-page?' + queryString;

        // Redirect to the destination page
        window.location.href = destinationPageUrl;
        console.log('Proceeding with services:', selectedServices);
    });

    function updateServiceButton(service) {
        // Update the select button for the given service to "Change"
        const button = document.querySelector(`.selectServiceButton[data-service="${service}"]`);
        button.textContent = 'Change';
    
        // Check if a "Deselect" button already exists
        const deselectButton = document.querySelector(`.deselectServiceButton[data-service="${service}"]`);
        if (!deselectButton) {
            // Create and append the deselect button
            const newDeselectButton = document.createElement('button');
            newDeselectButton.setAttribute('type', 'button');
            newDeselectButton.setAttribute('class', 'btn btn-danger deselectServiceButton');
            newDeselectButton.textContent = 'Deselect';
            newDeselectButton.setAttribute('data-service', service);
            button.parentNode.insertBefore(newDeselectButton, button.nextSibling);
    
            // Add event listener for the deselect button
            newDeselectButton.addEventListener('click', function () {
                // Remove the service from the selected services data
                delete selectedServices[service];
                console.log('Deselected Service:', service);
    
                // Update the button back to "Select" and remove the deselect button
                button.textContent = 'Select';
                newDeselectButton.parentNode.removeChild(newDeselectButton);
    
                // Hide the proceed banner if no services are selected
                if (Object.keys(selectedServices).length === 0) {
                    hideProceedBanner();
                }
            });
        }
    }    

    function showProceedBanner() {
        // Show the proceed banner
        const proceedBanner = document.getElementById('proceedBanner');
        proceedBanner.classList.add('show');
    }
    
    function hideProceedBanner() {
        // Hide the proceed banner
        const proceedBanner = document.getElementById('proceedBanner');
        proceedBanner.classList.remove('show');
    }
});