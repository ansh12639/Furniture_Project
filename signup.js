document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const errorElem = document.getElementById("error");

  const urlParams = new URLSearchParams(window.location.search);
  const errorParam = urlParams.get("error");

  if (errorParam) {
    let message = "";
    if (errorParam === "password_mismatch") {
      message = "Passwords do not match.";
    } else if (errorParam === "username_exists") {
      message = "Username already exists.";
    } else if (errorParam === "email_exists") {
      message = "Email address already registered.";
    } else if (errorParam === "registration_failed") {
      message = "Registration failed. Please try again.";
    }
    errorElem.textContent = message;
  }

  form.addEventListener("submit", function (e) {
    const username = form.username.value.trim();
    const email = form.email.value.trim();
    const password = form.password.value;
    const confirmPassword = form.confirm_password.value;

    let valid = true;
    errorElem.textContent = "";

    if (username === "" || !/^[a-zA-Z ]+$/.test(username)) {
      errorElem.textContent = "Enter a valid name.";
      valid = false;
    } else if (email === "" || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      errorElem.textContent = "Enter a valid email.";
      valid = false;
    } else if (password !== confirmPassword) {
      errorElem.textContent = "Passwords do not match.";
      valid = false;
    }

    if (!valid) e.preventDefault();
  });

  ["username", "email", "password", "confirm_password"].forEach((id) => {
    document.querySelector(`input[name='${id}']`)
      .addEventListener("input", () => {
        errorElem.textContent = "";
      });
  });

  // Toggle password visibility
  const togglePassword = document.getElementById("togglePassword");
  const passwordInput = document.getElementById("password");

  togglePassword.addEventListener("click", () => {
    const isHidden = passwordInput.type === "password";
    passwordInput.type = isHidden ? "text" : "password";
    togglePassword.classList.toggle("fa-eye");
    togglePassword.classList.toggle("fa-eye-slash");
  });

  const toggleConfirmPassword = document.getElementById("toggleConfirmPassword");
  const confirmPasswordInput = document.getElementById("confirm_password");

  toggleConfirmPassword.addEventListener("click", () => {
    const isHidden = confirmPasswordInput.type === "password";
    confirmPasswordInput.type = isHidden ? "text" : "password";
    toggleConfirmPassword.classList.toggle("fa-eye");
    toggleConfirmPassword.classList.toggle("fa-eye-slash");
  });
});
