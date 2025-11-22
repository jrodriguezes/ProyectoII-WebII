document.addEventListener("DOMContentLoaded", function () {
  const passwordRawInput = document.getElementById("floating_password");
  const confirmPasswordRawInput = document.getElementById(
    "floating_repeat_password"
  );

  const id = document.getElementById("floating_id");
  const first_name = document.getElementById("floating_first_name");
  const last_name = document.getElementById("floating_last_name");
  const date = document.getElementById("date");
  const email = document.getElementById("floating_email");
  const phone = document.getElementById("floating_phone");
  const photo = document.getElementById("photo");
  const password = document.getElementById("floating_password");
  const user_type = document.getElementById("user_type");

  document.addEventListener("submit", function (event) {
    if (
      id.value === "" ||
      first_name.value === "" ||
      last_name.value === "" ||
      date.value === "" ||
      email.value === "" ||
      phone.value === "" ||
      photo.value === "" ||
      password.value === "" ||
      user_type.value === ""
    ) {
      alert("Please fill in all required fields.");
      return;
    }

    if (passwordRawInput.value != confirmPasswordRawInput.value) {
      alert("Passwords do not match.");
      return;
    }
  });
});
