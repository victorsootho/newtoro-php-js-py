document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const username = document.querySelector('input[name="username"]');
    const email = document.querySelector('input[name="email"]');
    const password = document.querySelector('input[name="password"]');
    const usernameError = document.getElementById('username-error');
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');

    form.addEventListener('submit', function (e) {
        let valid = true;
        clearErrors();

        // Validate username
        if (username.value.trim() === '') {
            usernameError.textContent = 'Username is required.';
            valid = false;
        }

        // Validate email
        if (!validateEmail(email.value)) {
            emailError.textContent = 'Please enter a valid email.';
            valid = false;
        }

        // Validate password
        if (password.value.length < 6) {
            passwordError.textContent = 'Password must be at least 6 characters long.';
            valid = false;
        }

        if (!valid) {
            e.preventDefault(); // Prevent form from submitting
        }
    });

    function clearErrors() {
        usernameError.textContent = '';
        emailError.textContent = '';
        passwordError.textContent = '';
    }

    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email.toLowerCase());
    }
});

