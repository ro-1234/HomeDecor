document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".contact-form");

  const nameInput = document.getElementById("name");
  const emailInput = document.getElementById("email");
  const subjectInput = document.getElementById("subject");
  const messageInput = document.getElementById("message");

  form.addEventListener("submit", async function (event) {
    event.preventDefault(); 

    let errors = [];

    if (nameInput.value.trim().length < 3) {
      errors.push("Name must be at least 3 characters");
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(emailInput.value.trim())) {
      errors.push("Invalid email");
    }

    if (subjectInput.value.trim().length < 5) {
      errors.push("Subject too short");
    }

    if (messageInput.value.trim().length < 10) {
      errors.push("Message too short");
    }

    if (errors.length > 0) {
      alert(errors.join("\n"));
      return;
    }

    const formData = new FormData(form);

    const response = await fetch("Contact.php", {
      method: "POST",
      body: formData
    });

    const result = await response.text();

    alert(result);

    if (result.includes("successfully")) {
      form.reset(); 
    }
  });
});