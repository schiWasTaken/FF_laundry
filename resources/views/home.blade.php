@extends('layouts.template')
@section('title')
    Home
@endsection
@section('content')
<!-- Masthead-->
<header class="masthead bg-primary text-white text-center" id="home">
    <div class="container d-flex align-items-center flex-column">
        <!-- Masthead Avatar Image-->
        <img class="masthead-avatar mb-5" src="assets/img/avataaars.svg" alt="..." />
        <!-- Masthead Heading-->
        <h1 class="masthead-heading text-uppercase mb-0">Start Bootstrap</h1>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Masthead Subheading-->
        <p class="masthead-subheading font-weight-light mb-0">Graphic Artist - Web Designer - Illustrator</p>
    </div>
</header>
<section class="page-section" id="services">
    <div class="container">
        <h1 class="page-section-heading text-center text-uppercase text-secondary mb-5">Our Services</h1>
        <div class="services-container">
            <div class="service-card">
                <img src="{{ asset('assets/img/services/service1.jpg') }}" alt="Wash & Iron">
                <h3>Wash & Iron</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet animi neque, veritatis quae fugiat rerum magni.</p>
                <!-- Button to Open the Modal -->
                <div class="service-actions">
                    <button type="button" class="btn btn-primary selectServiceButton" data-bs-toggle="modal" data-bs-target="#service1Modal" data-service="1">
                        Select
                    </button>
                </div>
            </div>
            <div class="service-card">
                <img src="{{ asset('assets/img/services/service3.jpg') }}" alt="Wash & Iron (Express)">
                <h3>Iron Only</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet animi neque, veritatis quae fugiat rerum magni.</p>
                <!-- Button to Open the Modal -->
                <div class="service-actions">
                    <button type="button" class="btn btn-primary selectServiceButton" data-bs-toggle="modal" data-bs-target="#service2Modal" data-service="2">
                        Select
                    </button>
                </div>
            </div>
            <div class="fixed-bottom bg-dark text-white p-3" id="proceedBanner">
                <div class="container d-flex justify-content-between align-items-center">
                    <span id="selectedServicesMessage">You have selected services.</span>
                    <button id="proceedButton" class="btn btn-success">Proceed</button>
                </div>
            </div>

            <!-- Modals -->
            @include('layouts.modal', [
                'modalId' => 'service1Modal',
                'modalTitle' => 'Wash & Iron',
                'modalContent' => view('modals.wash_iron')->render()
            ])

            @include('layouts.modal', [
                'modalId' => 'service2Modal',
                'modalTitle' => 'Iron Only',
                'modalContent' => view('modals.iron_only')->render()
            ])
        </div>
    </div>
</section>
<!-- About Section-->
<section class="page-section bg-primary text-white mb-0" id="about">
    <div class="container">
        <!-- About Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-white">About</h2>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- About Section Content-->
        <div class="row">
            <div class="col-lg-4 ms-auto"><p class="lead">Freelancer is a free bootstrap theme created by Start Bootstrap. The download includes the complete source files including HTML, CSS, and JavaScript as well as optional SASS stylesheets for easy customization.</p></div>
            <div class="col-lg-4 me-auto"><p class="lead">You can create your own custom avatar for the masthead, change the icon in the dividers, and add your email address to the contact form to make it fully functional!</p></div>
        </div>
        <!-- About Section Button-->
        <div class="text-center mt-4">
            <a class="btn btn-xl btn-outline-light" href="https://startbootstrap.com/theme/freelancer/">
                <i class="fas fa-download me-2"></i>
                Free Download!
            </a>
        </div>
    </div>
</section>
<!-- Contact Section-->
<section class="page-section" id="contact">
    <div class="container">
        <!-- Contact Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Contact Me</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Contact Section Form-->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <!-- * * * * * * * * * * * * * * *-->
                <!-- * * SB Forms Contact Form * *-->
                <!-- * * * * * * * * * * * * * * *-->
                <!-- This form is pre-integrated with SB Forms.-->
                <!-- To make this form functional, sign up at-->
                <!-- https://startbootstrap.com/solution/contact-forms-->
                <!-- to get an API token!-->
                <form id="contactForm" data-sb-form-api-token="API_TOKEN">
                    <!-- Name input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="name" type="text" placeholder="Enter your name..." data-sb-validations="required" />
                        <label for="name">Full name</label>
                        <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                    </div>
                    <!-- Email address input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="email" type="email" placeholder="name@example.com" data-sb-validations="required,email" />
                        <label for="email">Email address</label>
                        <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                        <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                    </div>
                    <!-- Phone number input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="phone" type="tel" placeholder="(123) 456-7890" data-sb-validations="required" />
                        <label for="phone">Phone number</label>
                        <div class="invalid-feedback" data-sb-feedback="phone:required">A phone number is required.</div>
                    </div>
                    <!-- Message input-->
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="message" type="text" placeholder="Enter your message here..." style="height: 10rem" data-sb-validations="required"></textarea>
                        <label for="message">Message</label>
                        <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.</div>
                    </div>
                    <!-- Submit success message-->
                    <!---->
                    <!-- This is what your users will see when the form-->
                    <!-- has successfully submitted-->
                    <div class="d-none" id="submitSuccessMessage">
                        <div class="text-center mb-3">
                            <div class="fw-bolder">Form submission successful!</div>
                            To activate this form, sign up at
                            <br />
                            <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                        </div>
                    </div>
                    <!-- Submit error message-->
                    <!---->
                    <!-- This is what your users will see when there is-->
                    <!-- an error submitting the form-->
                    <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                    <!-- Submit Button-->
                    <button class="btn btn-primary btn-xl disabled" id="submitButton" type="submit">Send</button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
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
                newDeselectButton.setAttribute('class', 'btn btn-secondary deselectServiceButton');
                newDeselectButton.textContent = 'Deselect';
                newDeselectButton.setAttribute('data-service', service);
                button.parentNode.insertBefore(newDeselectButton, button.previousSibling);
        
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
</script>
@endsection
