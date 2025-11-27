(function () {
  function getCtor() {
    const ns = window.simpleDatatables;
    return (ns && (ns.DataTable || ns.default)) || null;
  }

  function init() {
    const Ctor = getCtor();
    const tableEl = document.getElementById("filter-table");
    if (!Ctor || !tableEl) return false;

    // 🔥 Crear la tabla y guardar la instancia manualmente
    const dt = new Ctor(tableEl, {
      searchable: true,
      sortable: true,
      perPage: 10,
      perPageSelect: [5, 10, 20, 50],
    });

    tableEl._datatable = dt;

    // 👉 Añade la clase 'tw-dt-fix' al wrapper real que crea el plugin
    requestAnimationFrame(() => {
      const wrapper =
        tableEl.closest(".datatable-wrapper") ||
        tableEl.parentElement?.querySelector(".datatable-wrapper");
      if (wrapper && !wrapper.classList.contains("tw-dt-fix")) {
        wrapper.classList.add("tw-dt-fix");
      }
      dt.update();
    });

    // --- Añadir fila de filtros (tu estilo original no se toca) ---
    const thead = tableEl.querySelector("thead");
    if (!thead || thead.querySelector(".search-filtering-row")) return true;

    const headerRow = thead.querySelector("tr");
    const thCount = headerRow ? headerRow.children.length : 0;
    const filterRow = document.createElement("tr");
    filterRow.className = "search-filtering-row";

    for (let i = 0; i < thCount; i++) {
      const th = document.createElement("th");
      th.innerHTML = `
        <input
          class="datatable-input w-full px-2 py-1 rounded bg-transparent border border-gray-500/40
                 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-1
                 focus:ring-blue-500"
          type="search"
          data-column="${i}"
          placeholder=""
        />
      `;
      filterRow.appendChild(th);
    }

    thead.appendChild(filterRow);

    // --- Enlazar los inputs con las columnas ---
    thead.querySelectorAll(".search-filtering-row input").forEach((input) => {
      input.addEventListener("input", function () {
        const col = parseInt(this.dataset.column, 10);
        dt.columns().search(this.value, col);
      });
    });

    // 🔁 Forzar render si estaba vacío al inicio
    requestAnimationFrame(() => dt.update());
    return true;
  }

  document.addEventListener("DOMContentLoaded", () => {
    if (init()) return;
    let tries = 0;
    const t = setInterval(() => {
      if (init() || ++tries > 50) clearInterval(t);
    }, 100);
  });
})();
