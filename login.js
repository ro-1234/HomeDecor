const form = document.getElementById("loginForm");
const errorDiv = document.getElementById("error");

form.addEventListener("submit", async function(e) {
  e.preventDefault();

  const username = document.getElementById("username").value.trim();
  const password = document.getElementById("password").value.trim();

  errorDiv.textContent = "";

  // username min 3 characters
  if (username.length < 3) {
    errorDiv.textContent = "Username must be at least 3 characters long!";
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


  const formData = new FormData();
  formData.append("username", username);
  formData.append("password", password);

  const response = await fetch("login.php", {
    method: "POST",
    body: formData
  });

  const data = await response.text();

  if (data === "success") {
    alert("Login successful!");
    window.location.href = "index.php"; 
  } else {
    errorDiv.textContent = data;
  }
});