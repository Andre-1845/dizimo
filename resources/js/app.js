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

    // Garantir que o conteúdo existente seja mantido
    // mas com a estrutura correta

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
    const sidebar = document.getElementById("sidebar");

    if (!toggleSidebar || !sidebar) {
        console.warn(
            "Sidebar: elementos não encontrados, tentando novamente...",
        );
        setTimeout(initSidebar, 500);
        return;
    }

    console.log("Sidebar: elementos encontrados, configurando...");

    const icons = {
        open: `<svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
        </svg>`,
        close: `<svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M6 18L18 6M6 6l12 12" />
        </svg>`,
    };

    // Garantir que comece com ícone de menu
    toggleSidebar.innerHTML = icons.open;

    // Remover eventos antigos (clonar e substituir)
    const newToggle = toggleSidebar.cloneNode(true);
    toggleSidebar.parentNode.replaceChild(newToggle, toggleSidebar);

    newToggle.addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();

        sidebar.classList.toggle("sidebar-expanded");
        const isExpanded = sidebar.classList.contains("sidebar-expanded");
        this.innerHTML = isExpanded ? icons.close : icons.open;

        console.log("Sidebar toggled:", isExpanded);
    });

    // Fechar ao clicar fora (mobile)
    document.addEventListener("click", function (e) {
        if (window.innerWidth < 1024) {
            const isClickInside =
                sidebar.contains(e.target) || newToggle.contains(e.target);
            const isExpanded = sidebar.classList.contains("sidebar-expanded");

            if (!isClickInside && isExpanded) {
                sidebar.classList.remove("sidebar-expanded");
                newToggle.innerHTML = icons.open;
            }
        }
    });

    // Fechar ao redimensionar para desktop
    window.addEventListener("resize", function () {
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove("sidebar-expanded");
            newToggle.innerHTML = icons.open;
        }
    });

    console.log("✅ Sidebar configurada com sucesso!");
}

// Inicializar
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initSidebar);
} else {
    initSidebar();
}
window.addEventListener("load", initSidebar);
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
