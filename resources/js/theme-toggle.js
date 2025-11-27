(function () {
  const darkIcon = document.getElementById("theme-toggle-dark-icon");
  const lightIcon = document.getElementById("theme-toggle-light-icon");
  const btn = document.getElementById("theme-toggle");

  if (!btn) return;

  // Mostrar icono correcto al cargar
  const stored = localStorage.getItem("color-theme");
  const isDark =
    stored === "dark" ||
    (!stored && window.matchMedia("(prefers-color-scheme: dark)").matches);

  if (isDark) {
    document.documentElement.classList.add("dark");
    lightIcon.classList.remove("hidden"); // sol visible
  } else {
    document.documentElement.classList.remove("dark");
    darkIcon.classList.remove("hidden"); // luna visible
  }

  btn.addEventListener("click", () => {
    const nowDark = document.documentElement.classList.toggle("dark");
    darkIcon.classList.toggle("hidden", nowDark);
    lightIcon.classList.toggle("hidden", !nowDark);
    localStorage.setItem("color-theme", nowDark ? "dark" : "light");
  });
})();
