document.addEventListener("DOMContentLoaded", () => {
  initializeSidebar()
  initializeThemeToggle()
})


function initializeSidebar() {
  const sidebar = document.getElementById("sidebar")
  const sidebarToggle = document.getElementById("sidebarToggle")
  const sidebarCollapseToggle = document.getElementById("sidebarCollapseToggle")
  const sidebarClose = document.getElementById("sidebarClose")
  const sidebarOverlay = document.getElementById("sidebarOverlay")
  const mainContent = document.querySelector(".main-content")

  console.log("Elementos encontrados:", {
    sidebar: !!sidebar,
    sidebarToggle: !!sidebarToggle,
    sidebarOverlay: !!sidebarOverlay,
    mainContent: !!mainContent,
  })

  // Toggle sidebar collapse (desktop)
  if (sidebarCollapseToggle) {
    sidebarCollapseToggle.addEventListener("click", function () {
      if (!sidebar) return

      const isCollapsed = sidebar.classList.contains("collapsed")

      if (isCollapsed) {
        sidebar.classList.remove("collapsed")
        if (mainContent) mainContent.classList.remove("sidebar-collapsed")
        this.innerHTML = '<i class="fas fa-angles-left"></i>'
        this.title = "Recolher sidebar"
      } else {
        sidebar.classList.add("collapsed")
        if (mainContent) mainContent.classList.add("sidebar-collapsed")
        this.innerHTML = '<i class="fas fa-angles-right"></i>'
        this.title = "Expandir sidebar"
      }
    })
  }

  // Toggle sidebar (mobile)
  if (sidebarToggle && sidebar && sidebarOverlay) {
    sidebarToggle.addEventListener("click", (e) => {
      e.preventDefault()
      e.stopPropagation()

      console.log("Toggle sidebar clicked")

      sidebar.classList.toggle("mobile-open")
      sidebarOverlay.classList.toggle("show")
      document.body.style.overflow = sidebar.classList.contains("mobile-open") ? "hidden" : ""
    })
  }

  // Close sidebar (mobile)
  function closeSidebar() {
    if (sidebar) sidebar.classList.remove("mobile-open")
    if (sidebarOverlay) sidebarOverlay.classList.remove("show")
    document.body.style.overflow = ""
  }

  if (sidebarClose) {
    sidebarClose.addEventListener("click", (e) => {
      e.preventDefault()
      e.stopPropagation()
      closeSidebar()
    })
  }

  if (sidebarOverlay) {
    sidebarOverlay.addEventListener("click", closeSidebar)
  }

  // Close sidebar when clicking outside (mobile)
  document.addEventListener("click", (e) => {
    if (
      window.innerWidth < 992 &&
      sidebar &&
      sidebar.classList.contains("mobile-open") &&
      !sidebar.contains(e.target) &&
      sidebarToggle &&
      !sidebarToggle.contains(e.target)
    ) {
      closeSidebar()
    }
  })

  // Handle window resize
  window.addEventListener("resize", () => {
    if (window.innerWidth >= 992) {
      closeSidebar()
      if (sidebar) sidebar.classList.remove("mobile-open")
    }
  })
}

function initializeThemeToggle() {
  const themeToggle = document.getElementById("darkModeToggle")
  const body = document.body
  localStorage.setItem("barbershop-theme", "light") // Definir tema claro como padrão

  if (!themeToggle) return

  // Verificar tema salvo no localStorage
  const savedTheme = localStorage.getItem("barbershop-theme") || "light"

  // Aplicar tema inicial
  if (savedTheme === "dark") {
    body.setAttribute("data-theme", "dark")
    themeToggle.checked = true
  } else {
    body.removeAttribute("data-theme")
    themeToggle.checked = false
  }

  // Toggle do tema com checkbox
  themeToggle.addEventListener("change", () => {
    if (themeToggle.checked) {
      // Mudar para modo escuro
      body.setAttribute("data-theme", "dark")
      localStorage.setItem("barbershop-theme", "dark")
    } else {
      // Mudar para modo claro
      body.removeAttribute("data-theme")
      localStorage.setItem("barbershop-theme", "light")
    }

    // Animação suave
    body.style.transition = "all 0.3s ease"
    setTimeout(() => {
      body.style.transition = ""
    }, 300)
  })

  // Detectar mudanças de preferência do sistema
  if (window.matchMedia) {
    const mediaQuery = window.matchMedia("(prefers-color-scheme: dark)")

    // Se não há preferência salva, usar preferência do sistema
    if (!localStorage.getItem("barbershop-theme")) {
      if (mediaQuery.matches) {
        body.setAttribute("data-theme", "dark")
        themeToggle.checked = true
      }
    }

    // Escutar mudanças na preferência do sistema
    mediaQuery.addEventListener("change", (e) => {
      // Só aplicar se não há preferência manual salva
      if (!localStorage.getItem("barbershop-theme")) {
        if (e.matches) {
          body.setAttribute("data-theme", "dark")
          themeToggle.checked = true
        } else {
          body.removeAttribute("data-theme")
          themeToggle.checked = false
        }
      }
    })
  }


}

function logout() {
  if (confirm("Tem certeza que deseja sair?")) {
    window.location.href = "/login"
  }
}
