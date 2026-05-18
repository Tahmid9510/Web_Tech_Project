document.addEventListener("DOMContentLoaded", function () {
    const registrationForm = document.getElementById("registrationForm");

    if (registrationForm) {
        registrationForm.addEventListener("submit", function (event) {
            let isValid = true;

            clearErrors();

            const name = document.getElementById("name");
            const phone = document.getElementById("phone");
            const email = document.getElementById("email");
            const address = document.getElementById("address");
            const password = document.getElementById("password");
            const role = document.getElementById("role");

            if (name.value.trim() === "") {
                showError(name, "nameError", "Name is required");
                isValid = false;
            }

            if (phone.value.trim() === "") {
                showError(phone, "phoneError", "Phone is required");
                isValid = false;
            }

            if (email.value.trim() === "") {
                showError(email, "emailError", "Email is required");
                isValid = false;
            } else if (!isValidEmail(email.value.trim())) {
                showError(email, "emailError", "Enter a valid email address");
                isValid = false;
            }

            if (address.value.trim() === "") {
                showError(address, "addressError", "Address is required");
                isValid = false;
            }

            if (password.value.trim() === "") {
                showError(password, "passwordError", "Password is required");
                isValid = false;
            } else if (password.value.length < 8) {
                showError(password, "passwordError", "Password must be at least 8 characters");
                isValid = false;
            }

            if (role.value !== "customer" && role.value !== "admin") {
                showError(role, "roleError", "Please select a valid account type");
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    }
});




document.addEventListener("DOMContentLoaded", function () {
    const profileForm = document.getElementById("profileForm");
    const passwordForm = document.getElementById("passwordForm");
    const profilePicture = document.getElementById("profile_picture");

    if (profileForm) {
        profileForm.addEventListener("submit", function (event) {
            let isValid = true;

            clearErrors();

            const name = document.getElementById("name");
            const phone = document.getElementById("phone");
            const email = document.getElementById("email");
            const address = document.getElementById("address");

            if (name.value.trim() === "") {
                showError(name, "nameError", "Name is required");
                isValid = false;
            }

            if (phone.value.trim() === "") {
                showError(phone, "phoneError", "Phone is required");
                isValid = false;
            } else if (!isValidPhone(phone.value.trim())) {
                showError(phone, "phoneError", "Enter a valid phone number");
                isValid = false;
            }

            if (email.value.trim() === "") {
                showError(email, "emailError", "Email is required");
                isValid = false;
            } else if (!isValidEmail(email.value.trim())) {
                showError(email, "emailError", "Enter a valid email address");
                isValid = false;
            }

            if (address.value.trim() === "") {
                showError(address, "addressError", "Address is required");
                isValid = false;
            }

            if (profilePicture && profilePicture.files.length > 0) {
                const file = profilePicture.files[0];
                const allowedTypes = ["image/jpeg", "image/png", "image/webp"];
                const maxSize = 2 * 1024 * 1024;

                if (!allowedTypes.includes(file.type)) {
                    alert("Only JPG, PNG, or WEBP images are allowed");
                    isValid = false;
                } else if (file.size > maxSize) {
                    alert("Profile picture must be less than 2MB");
                    isValid = false;
                }
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    }

    if (passwordForm) {
        passwordForm.addEventListener("submit", function (event) {
            let isValid = true;

            clearErrors();

            const currentPassword = document.getElementById("current_password");
            const newPassword = document.getElementById("new_password");
            const confirmPassword = document.getElementById("confirm_password");

            if (currentPassword.value.trim() === "") {
                showError(currentPassword, "currentPasswordError", "Current password is required");
                isValid = false;
            }

            if (newPassword.value.trim() === "") {
                showError(newPassword, "newPasswordError", "New password is required");
                isValid = false;
            } else if (newPassword.value.length < 8) {
                showError(newPassword, "newPasswordError", "Password must be at least 8 characters");
                isValid = false;
            }

            if (confirmPassword.value.trim() === "") {
                showError(confirmPassword, "confirmPasswordError", "Confirm password is required");
                isValid = false;
            } else if (newPassword.value !== confirmPassword.value) {
                showError(confirmPassword, "confirmPasswordError", "Passwords do not match");
                isValid = false;
            }

            if (
                currentPassword.value.trim() !== "" &&
                newPassword.value.trim() !== "" &&
                currentPassword.value === newPassword.value
            ) {
                showError(newPassword, "newPasswordError", "New password cannot be same as current password");
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    }
});

function showError(inputElement, errorId, message) {
    inputElement.classList.add("input-error");
    document.getElementById(errorId).innerText = message;
}

function clearErrors() {
    const errorTexts = document.querySelectorAll(".error-text");
    const inputs = document.querySelectorAll("input, select");

    errorTexts.forEach(function (errorText) {
        errorText.innerText = "";
    });

    inputs.forEach(function (input) {
        input.classList.remove("input-error");
    });
}

function isValidEmail(email) {
    const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return pattern.test(email);
}