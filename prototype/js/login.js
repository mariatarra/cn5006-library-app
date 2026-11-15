/**
 * Checks the login form fields before the form is sent.
 * If something is wrong, it stops the form and shows the messages.
 *
 * @param {Event} event The form submit event
 * @return {void}
 */
function validateLoginForm(event) {
    var email = document.getElementById("email").value.trim();
    var password = document.getElementById("password").value;
    var errors = [];

    if (email === "") {
        errors.push("Email is required.");
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        errors.push("Email is not valid.");
    }

    if (password === "") {
        errors.push("Password is required.");
    }

    var messageBox = document.getElementById("errorMessages");

    if (errors.length > 0) {
        event.preventDefault();
        messageBox.innerHTML = errors.join("<br>");
    } else {
        messageBox.innerHTML = "";
    }
}

document.getElementById("loginForm").addEventListener("submit", validateLoginForm);