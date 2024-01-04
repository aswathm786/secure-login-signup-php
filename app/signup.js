document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
    this.innerHTML = `<i class="fa ${type === 'password' ? 'fa-lock' : 'fa-lock-open'}"></i>`;
});

(function () {
    'use strict';

    var forms = document.querySelectorAll('.needs-validation');

    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    });
})();

const passwordField = document.getElementById('password');
const passwordCondition = document.querySelector('.password-condition');

passwordField.addEventListener('input', function () {
    const password = this.value;
    const pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}$/;

    if (pattern.test(password)) {
        this.classList.remove('invalid');
        this.classList.add('valid');
        passwordCondition.textContent = 'Password meets criteria.';
        passwordCondition.style.color = 'green';
    } else {
        this.classList.remove('valid');
        this.classList.add('invalid');
        passwordCondition.textContent = 'Password must contain at least one number, one uppercase, one lowercase letter, one special character, no whitespace character and be at least 8 characters long.';
        passwordCondition.style.color = 'red';
    }
});

// Function to check if the username contains special characters
function containsSpecialCharacters(input) {
    const format = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
    return format.test(input);
}

// Function to check if the username contains a number
function containsNumber(input) {
    const format = /\d/;
    return format.test(input);
}

// Event listener for the username field
const usernameField = document.getElementById('username');
usernameField.addEventListener('input', function () {
    const username = this.value;
    const usernameFeedback = document.getElementById('username-feedback');

    if (containsSpecialCharacters(username)) {
        usernameFeedback.textContent = 'Username should not contain special characters.';
        usernameFeedback.style.color = 'red';
        this.classList.remove('valid');
        this.classList.add('invalid');
    } else if (!containsNumber(username)) {
        usernameFeedback.textContent = 'Username should contain at least one number.';
        usernameFeedback.style.color = 'red';
        this.classList.remove('valid');
        this.classList.add('invalid');
    } else {
        usernameFeedback.textContent = 'Username is valid.';
        usernameFeedback.style.color = 'green';
        this.classList.remove('invalid');
        this.classList.add('valid');
    }
});
