document.addEventListener("DOMContentLoaded", () => {
  initializeSidebar()
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

function logout() {
  if (confirm("Tem certeza que deseja sair?")) {
    window.location.href = "/login"
  }
}
