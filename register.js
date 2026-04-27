const form = document.getElementById("registerForm");
const errorDiv = document.getElementById("error");

form.addEventListener("submit", function(e) {
  e.preventDefault();

  const name = document.getElementById("name").value.trim();
  const username = document.getElementById("username").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();

  errorDiv.textContent = "";

  if (name === "" || username === "" || email === "" || password === "") {
    errorDiv.textContent = "Please fill in all fields!";
    return;
  }

  // username min 3 chars
  const usernameRegex = /^.{3,}$/;
  if (!usernameRegex.test(username)) {
    errorDiv.textContent = "Username must be at least 3 characters!";
    return;
  }

  // email validation
  const emailRegex = /^\S+@\S+\.\S+$/;
  if (!emailRegex.test(email)) {
    errorDiv.textContent = "Invalid email!";
    return;
  }

  // password min 6 characters
  if (password.length < 6) {
    errorDiv.textContent = "Password must be at least 6 characters long!";
    return;
  }

  // password must contain at least one number
  const numberRegex = /[0-9]/;
  if (!numberRegex.test(password)) {
    errorDiv.textContent = "Password must contain at least one number!";
    return;
  }

  // success
  alert("Registration successful!");
  form.reset();
});