document.addEventListener("DOMContentLoaded", function () {
  const toggleSwitch = document.getElementById("userTypeSwitch");
  if (!toggleSwitch) return;
  
  const userType = document.getElementById("user_type");
  const userTypeLabel = document.getElementById("userTypeLabel");
  const initialUserType = document.getElementById("initial_user_type");

  const isEdit = !!document.getElementById("edit_profile");

  function applyState() {
    if (isEdit) {
      userType.value = toggleSwitch.checked
        ? "driver&passenger"
        : initialUserType.value;
      userTypeLabel.textContent = userType.value;
    } else {
      userType.value = toggleSwitch.checked ? "driver" : "passenger";
      userTypeLabel.textContent = userType.value;
    }
  }

  applyState(); // Ejecuta al cargar
  toggleSwitch.addEventListener("change", applyState); // Ejecuta al cambiar
});
