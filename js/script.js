document.addEventListener("DOMContentLoaded", function() {
    console.log("JavaScript is ready!");

    // Smooth scrolling for navigation links
    const navLinks = document.querySelectorAll('nav ul li a');
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = link.getAttribute('href');
            if (targetId.startsWith('#')) {
                document.querySelector(targetId).scrollIntoView({
                    behavior: 'smooth'
                });
            } else {
                window.location.href = targetId;
            }
        });
    });

    // Hamburger menu functionality
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.querySelector('nav ul.nav-links');
    
    hamburger.addEventListener('click', () => {
        console.log('Hamburger clicked');
        navMenu.classList.toggle('active');
    });

    // Form submission validation and handling
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const messageInput = document.getElementById('message');

            // Simple validation
            if (nameInput.value.trim() === '' || emailInput.value.trim() === '' || messageInput.value.trim() === '') {
                alert('Please fill out all fields.');
                return;
            }

            // You can add additional validation logic here, such as email format validation

            // If all fields are filled, you can send the form data to your server or do something else with it
            const formData = {
                name: nameInput.value.trim(),
                email: emailInput.value.trim(),
                message: messageInput.value.trim()
            };

            // Example: sending the form data using fetch
            fetch('your-backend-endpoint', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                if (response.ok) {
                    alert('Message sent successfully!');
                    nameInput.value = '';
                    emailInput.value = '';
                    messageInput.value = '';
                } else {
                    throw new Error('Failed to send message.');
                }
            })
            .catch(error => {
                alert(error.message);
            });
        });
    }

    // Service card hover effect
    const serviceCards = document.querySelectorAll(".service-card");
    serviceCards.forEach(card => {
        card.addEventListener("mouseenter", () => {
            card.style.boxShadow = "0 0 20px rgba(0, 0, 0, 0.2)";
        });
        card.addEventListener("mouseleave", () => {
            card.style.boxShadow = "0 0 10px rgba(0, 0, 0, 0.1)";
        });
    });
});
