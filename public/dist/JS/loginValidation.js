const loginForm = document.getElementById("login-form");
const elements = Array.from(document.querySelectorAll(".form-element"));

loginForm.addEventListener("submit", (e) => {
    e.preventDefault();
    for (let i = 0; i < elements.length; i++) {
        errorMessage = elements[i].nextElementSibling;
        if (!elements[i].value) {
            errorMessage.textContent = "This Field Is required";
            errorMessage.classList.add("show");
        } else if (elements[i].type == "email") {
            if (!elements[i].value.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g)) {
                errorMessage.textContent = "Please Enter A valid Email Address";
                errorMessage.classList.add("show");
            }
        } else {
            loginForm.submit();
        }
    }
});
