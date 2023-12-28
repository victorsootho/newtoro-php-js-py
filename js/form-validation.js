document.addEventListener('DOMContentLoaded', function() {
    // Identify which form is active
    const isRegisterForm = document.querySelector('input[name="username"]') !== null;
    const isLoginForm = document.querySelector('input[name="username_email"]') !== null;

    // Common elements for both forms
    const form = document.querySelector('form');
    const password = document.querySelector('input[name="password"]');
    const passwordError = document.getElementById('password-error');

    // Registration form specific elements
    let username, email, usernameError, emailError;
    if (isRegisterForm) {
        username = document.querySelector('input[name="username"]');
        email = document.querySelector('input[name="email"]');
        usernameError = document.getElementById('username-error');
        emailError = document.getElementById('email-error');
    }

    // Login form specific elements
    let usernameEmail, usernameEmailError;
    if (isLoginForm) {
        usernameEmail = document.querySelector('input[name="username_email"]');
        usernameEmailError = document.getElementById('username-email-error');
    }

    form.addEventListener('submit', function(e) {
        let valid = true;
        clearErrors();

        // Registration form validation
        if (isRegisterForm) {
            if (username.value.trim() === '') {
                usernameError.textContent = 'Username is required.';
                valid = false;
            }

            if (!validateEmail(email.value)) {
                emailError.textContent = 'Please enter a valid email.';
                valid = false;
            }
        }

        // Login form validation
        if (isLoginForm) {
            if (usernameEmail.value.trim() === '') {
                usernameEmailError.textContent = 'Username or Email is required.';
                valid = false;
            }
        }

        // Common password validation
        if (password.value.length < 6) {
            passwordError.textContent = 'Password must be at least 6 characters long.';
            valid = false;
        }

        if (!valid) {
            e.preventDefault(); // Prevent form from submitting
        }
    });

    function clearErrors() {
        if (isRegisterForm) {
            usernameError.textContent = '';
            emailError.textContent = '';
        }
        if (isLoginForm) {
            usernameEmailError.textContent = '';
        }
        passwordError.textContent = '';
    }

    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email.toLowerCase());
    }
});
