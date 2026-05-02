const form = document.getElementById("loginForm");
const errorDiv = document.getElementById("error");

form.addEventListener("submit", async function(e) {
  e.preventDefault();

  const username = document.getElementById("username").value.trim();
  const password = document.getElementById("password").value.trim();

  errorDiv.textContent = "";

  if (username.length < 3) {
    errorDiv.textContent = "Username must be at least 3 characters long!";
    return;
  }

  if (password.length < 6) {
    errorDiv.textContent = "Password must be at least 6 characters long!";
    return;
  }

  const numberRegex = /[0-9]/;
  if (!numberRegex.test(password)) {
    errorDiv.textContent = "Password must contain at least one number!";
    return;
  }

  const formData = new FormData();
  formData.append("username", username);
  formData.append("password", password);

  try {
    const response = await fetch("login.php", {
      method: "POST",
      body: formData
    });

    const data = await response.text();

    if (data.trim() === "success") {
      window.location.href = "index.php";
    } else {
      errorDiv.textContent = data;
    }

  } catch (error) {
    errorDiv.textContent = "Server error!";
  }
});