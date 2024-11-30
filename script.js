const loginForm = document.getElementById("loginForm");
const signupForm = document.getElementById("signupForm");
const updateForm = document.getElementById("updateForm");
const switchToSignUp = document.getElementById("switchToSignUp");
const switchToLogin = document.getElementById("switchToLogin");
const authContainer = document.getElementById("authContainer");
const userContainer = document.getElementById("userContainer");
const usernameDisplay = document.getElementById("usernameDisplay");
const userAvatar = document.getElementById("userAvatar");

// Switch forms
switchToSignUp.addEventListener("click", () => {
  loginForm.classList.add("hidden");
  signupForm.classList.remove("hidden");
});

switchToLogin.addEventListener("click", () => {
  signupForm.classList.add("hidden");
  loginForm.classList.remove("hidden");
});

// Login
loginForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const formData = new FormData(loginForm);
  const response = await fetch("php/login.php", {
    method: "POST",
    body: formData,
  });
  const result = await response.json();
  if (result.success) {
    authContainer.classList.add("hidden");
    userContainer.classList.remove("hidden");
    usernameDisplay.textContent = result.username;
    userAvatar.src = result.avatar;
  } else {
    alert(result.message);
  }
});

// Signup
signupForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const formData = new FormData(signupForm);
  const response = await fetch("php/register.php", {
    method: "POST",
    body: formData,
  });
  const result = await response.json();
  alert(result.message);
});

// Update
updateForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const formData = new FormData(updateForm);
  const response = await fetch("php/updateUser.php", {
    method: "POST",
    body: formData,
  });
  const result = await response.json();
  if (result.success) {
    usernameDisplay.textContent = result.newUsername;
    if (result.avatar) userAvatar.src = result.avatar;
  } else {
    alert(result.message);
  }
});
