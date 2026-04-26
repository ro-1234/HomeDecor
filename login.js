document.getElementById("registerForm").addEventListener("submit", function(e){
    e.preventDefault();

    let username = document.getElementById("username").value.trim();
    let email = document.getElementById("email").value.trim();
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirmPassword").value;
    let error = document.getElementById("error");

    error.innerHTML = "";

    if(username === "" || email === "" || password === "" || confirmPassword === ""){
        error.innerHTML = "All fields are required!";
        return;
    }

    if(password.length < 6){
        error.innerHTML = "Password must be at least 6 characters!";
        return;
    }

    if(password !== confirmPassword){
        error.innerHTML = "Passwords do not match!";
        return;
    }

    alert("Account created successfully!");
});