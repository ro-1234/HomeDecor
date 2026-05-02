
document.addEventListener("DOMContentLoaded", function() {

  const form = document.getElementById("registerForm");
  const errorDiv = document.getElementById("error");

  if (!form) return;

  form.addEventListener("submit", async function(e) {
    e.preventDefault();

    const name = document.getElementById("name").value.trim();
    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    errorDiv.textContent = "";

    if (name.length < 3) {
      errorDiv.textContent = "Name must be at least 3 characters";
      return;
    }

    if (username.length < 3) {
      errorDiv.textContent = "Username must be at least 3 characters";
      return;
    }

    if (!email.includes("@")) {
      errorDiv.textContent = "Invalid email";
      return;
    }

    if (password.length < 6) {
      errorDiv.textContent = "Password must be at least 6 characters";
      return;
    }

    const formData = new FormData();
    formData.append("name", name);
    formData.append("username", username);
    formData.append("email", email);
    formData.append("password", password);

    try {
      const response = await fetch("register.php", {
        method: "POST",
        body: formData
      });

      const data = await response.text();
      console.log("SERVER RESPONSE:", data);

      if (data.trim() === "success") {
        alert("Registered successfully!");
        window.location.href = "login.php";
      } else {
        errorDiv.textContent = data;
      }

    } catch (error) {
      errorDiv.textContent = "Network error!";
      console.error(error);
    }
  });

});