import "./bootstrap";
import Chart from "chart.js/auto";
import ChartDataLabels from "chartjs-plugin-datalabels";

Chart.register(ChartDataLabels);
window.Chart = Chart;

/* =====================================================
   DROPDOWN USUÁRIO
===================================================== */
document.addEventListener("DOMContentLoaded", () => {
    const dropdownButton = document.getElementById("userDropdownButton");
    const dropdownContent = document.getElementById("dropdownContent");

    if (dropdownButton && dropdownContent) {
        dropdownButton.addEventListener("click", (e) => {
            e.stopPropagation();
            dropdownContent.classList.toggle("hidden");
        });

        window.addEventListener("click", (event) => {
            if (
                !dropdownButton.contains(event.target) &&
                !dropdownContent.contains(event.target)
            ) {
                dropdownContent.classList.add("hidden");
            }
        });
    }
});

/* =====================================================
   SIDEBAR
===================================================== */
document.addEventListener("DOMContentLoaded", () => {
    const toggleSidebar = document.getElementById("toggleSidebar");
    const closeSidebar = document.getElementById("closeSidebar");
    const sidebar = document.getElementById("sidebar");

    if (toggleSidebar && sidebar) {
        toggleSidebar.addEventListener("click", () => {
            sidebar.classList.toggle("sidebar-open");
        });
    }

    if (closeSidebar && sidebar) {
        closeSidebar.addEventListener("click", () => {
            sidebar.classList.remove("sidebar-open");
        });
    }
});

/* =====================================================
   SWEETALERT – EXCLUSÃO
===================================================== */
window.confirmDelete = function (id, name) {
    if (typeof Swal === "undefined") return;

    Swal.fire({
        title: "Excluir registro",
        text: `Tem certeza que deseja excluir ${name}?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sim, excluir",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById(`delete-form-${id}`);
            if (form) {
                form.submit();
            }
        }
    });
};
