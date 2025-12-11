document.addEventListener("DOMContentLoaded", function () {
    const toggleSwitch = document.getElementById("userTypeSwitch");
    if (!toggleSwitch) return;

    const userType = document.getElementById("user_type");
    const userTypeLabel = document.getElementById("userTypeLabel");

    function applyState() {
        userType.value = toggleSwitch.checked ? "driver" : "passenger";
        userTypeLabel.textContent = userType.value;
    }

    applyState(); // Ejecuta al cargar
    toggleSwitch.addEventListener("change", applyState); // Ejecuta al cambiar
});
