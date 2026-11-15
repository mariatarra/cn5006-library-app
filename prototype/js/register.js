/**
 * Checks the registration form fields before the form is sent.
 * If something is wrong, it stops the form and shows the messages.
 *
 * @param {Event} event The form submit event
 * @return {void}
 */
function validateRegisterForm(event) {
    var username = document.getElementById("username").value.trim();
    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("password").value;
    var role = document.getElementById("role").value;
    var code = document.getElementById("code").value.trim();
    var errors = [];

    if (username === "") {
        errors.push("Username is required.");
    }

    if (email === "") {
        errors.push("Email is required.");
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        errors.push("Email is not valid.");
    }

    if (password === "") {
        errors.push("Password is required.");
    } else if (password.length < 6) {
        errors.push("Password must be at least 6 characters.");
    }

    if (role === "") {
        errors.push("Please select a role.");
    }

    if (code === "") {
        errors.push("Registration code is required.");
    }

    var messageBox = document.getElementById("errorMessages");

    if (errors.length > 0) {
        event.preventDefault();
        messageBox.innerHTML = errors.join("<br>");
    } else {
        messageBox.innerHTML = "";
    }
}

document.getElementById("registerForm").addEventListener("submit", validateRegisterForm);