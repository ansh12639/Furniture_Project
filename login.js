document.addEventListener("DOMContentLoaded", function () {
  const errorElem = document.getElementById("error");

  const urlParams = new URLSearchParams(window.location.search);
  const error = urlParams.get("error");

  if (error === "invalid") {
    errorElem.textContent = "Invalid username or password.";
  } else if (error === "required") {
    errorElem.textContent = "Login required to continue.";
  }

  ["username", "password"].forEach((id) => {
    document.querySelector(`input[name='${id}']`).addEventListener("input", () => {
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
});
