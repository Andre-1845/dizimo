import "./bootstrap";
import Chart from "chart.js/auto";
import ChartDataLabels from "chartjs-plugin-datalabels";
import Cropper from "cropperjs";
import "cropperjs/dist/cropper.css";

Chart.register(ChartDataLabels);
window.Chart = Chart;

/* ******   CROPPER JS ********** */
window.Cropper = Cropper;

/* =====================================================
   MENU DO SITE - VERSÃO SIMPLIFICADA
===================================================== */
function initSiteMobileMenu() {
    const menuToggle = document.getElementById("siteMenuToggle");
    const mobileMenu = document.getElementById("siteMobileMenu");

    if (!menuToggle || !mobileMenu) return;

    console.log("Configurando menu do site...");

    // Remover classes antigas e adicionar as novas
    mobileMenu.classList.remove(
        "hidden",
        "inset-0",
        "flex",
        "items-center",
        "justify-center",
    );
    mobileMenu.classList.add("site-sidebar");

    // Criar overlay
    const overlay = document.createElement("div");
    overlay.className = "site-sidebar-overlay";
    document.body.appendChild(overlay);

    // Evento de clique
    menuToggle.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();

        mobileMenu.classList.toggle("site-sidebar-expanded");
        overlay.classList.toggle("active");
    });

    // Fechar ao clicar no overlay
    overlay.addEventListener("click", function () {
        mobileMenu.classList.remove("site-sidebar-expanded");
        overlay.classList.remove("active");
    });

    // Fechar ao clicar em links
    mobileMenu.querySelectorAll("a").forEach((link) => {
        link.addEventListener("click", function () {
            mobileMenu.classList.remove("site-sidebar-expanded");
            overlay.classList.remove("active");
        });
    });

    // Fechar ao redimensionar para desktop
    window.addEventListener("resize", function () {
        if (window.innerWidth >= 768) {
            mobileMenu.classList.remove("site-sidebar-expanded");
            overlay.classList.remove("active");
        }
    });
}

document.addEventListener("DOMContentLoaded", initSiteMobileMenu);

/* =====================================================
   SIDEBAR MOBILE
===================================================== */
function initSidebar() {
    const toggleSidebar = document.getElementById("toggleSidebar");
    const closeSidebar = document.getElementById("closeSidebar");
    const sidebar = document.getElementById("sidebar");

    if (!toggleSidebar || !sidebar) return;

    // Abrir
    toggleSidebar.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        sidebar.classList.add("sidebar-expanded");
    });

    // Fechar pelo botão X
    closeSidebar?.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        sidebar.classList.remove("sidebar-expanded");
    });

    // Fechar clicando fora (mobile)
    document.addEventListener("click", function (e) {
        if (window.innerWidth < 1024) {
            if (
                !sidebar.contains(e.target) &&
                !toggleSidebar.contains(e.target)
            ) {
                sidebar.classList.remove("sidebar-expanded");
            }
        }
    });

    // Reset ao ir para desktop
    window.addEventListener("resize", function () {
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove("sidebar-expanded");
        }
    });
}

document.addEventListener("DOMContentLoaded", initSidebar);

// Inicializar
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initSidebar);
} else {
    initSidebar();
}
window.addEventListener("load", initSidebar);

/* =====================================================
   NAVBAR DROPDOWNS
===================================================== */
document.addEventListener("DOMContentLoaded", () => {
    const churchBtn = document.getElementById("churchDropdownButton");
    const churchMenu = document.getElementById("churchDropdown");

    const userBtn = document.getElementById("userDropdownButton");
    const userMenu = document.getElementById("userDropdown");

    function closeAll() {
        churchMenu?.classList.add("hidden");
        userMenu?.classList.add("hidden");
    }

    function toggle(menu) {
        const isHidden = menu.classList.contains("hidden");
        closeAll();
        if (isHidden) menu.classList.remove("hidden");
    }

    churchBtn?.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        toggle(churchMenu);
    });

    userBtn?.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        toggle(userMenu);
    });

    document.addEventListener("click", closeAll);

    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") closeAll();
    });
});
/* NAV BAR CHURCH USER */

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
