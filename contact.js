document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".contact-form");
  const nameInput = document.getElementById("name");
  const emailInput = document.getElementById("email");
  const subjectInput = document.getElementById("subject");
  const messageInput = document.getElementById("message");

  form.addEventListener("submit", function (event) {
    let errors = [];

    if (nameInput.value.trim().length < 3) {
      errors.push("Full name must be at least 3 characters.");
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(emailInput.value.trim())) {
      errors.push("Please enter a valid email address.");
    }

    if (subjectInput.value.trim().length < 5) {
      errors.push("Subject must be at least 5 characters.");
    }

    if (messageInput.value.trim().length < 10) {
      errors.push("Message must be at least 10 characters.");
    }

    if (errors.length > 0) {
      event.preventDefault();
      alert(errors.join("\n"));
    }
  });
});
