document.addEventListener("DOMContentLoaded", () => {
  initializeSubmenus()
  initializeExpandAll()
})

function initializeSubmenus() {
  const categoryToggles = document.querySelectorAll(".nav-category-toggle")

  categoryToggles.forEach((toggle) => {
    toggle.addEventListener("click", function () {
      const sidebar = document.getElementById("sidebar")

      // Não permitir toggle de submenus quando sidebar está colapsada
      if (sidebar && sidebar.classList.contains("collapsed")) {
        return
      }

      const targetId = this.dataset.target
      const submenu = document.getElementById(targetId)
      const isActive = this.classList.contains("active")

      // Toggle do submenu atual
      if (isActive) {
        this.classList.remove("active")
        if (submenu) submenu.classList.remove("show")
      } else {
        this.classList.add("active")
        if (submenu) submenu.classList.add("show")
      }

      updateExpandAllButtonState()
    })
  })

  // Expandir automaticamente o submenu que contém a página ativa
  const activeLink = document.querySelector(".nav-submenu .nav-link.active")
  if (activeLink) {
    const submenu = activeLink.closest(".nav-submenu")
    if (submenu) {
      const toggle = document.querySelector(`[data-target="${submenu.id}"]`)
      if (toggle) {
        toggle.classList.add("active")
        submenu.classList.add("show")
        updateExpandAllButtonState()
      }
    }
  }
}

function updateExpandAllButtonState() {
  const expandAllBtn = document.getElementById("expandAllBtn")
  if (!expandAllBtn) return

  const categoryToggles = document.querySelectorAll(".nav-category-toggle")
  const activeToggles = document.querySelectorAll(".nav-category-toggle.active")

  if (activeToggles.length === categoryToggles.length && categoryToggles.length > 0) {
    // Todos expandidos
    expandAllBtn.innerHTML = '<i class="fas fa-compress-arrows-alt"></i><span class="btn-text">Recolher Todos</span>'
    expandAllBtn.title = "Recolher todos os menus"
    expandAllBtn.dataset.allExpanded = "true"
  } else {
    // Nem todos expandidos
    expandAllBtn.innerHTML = '<i class="fas fa-expand-arrows-alt"></i><span class="btn-text">Expandir Todos</span>'
    expandAllBtn.title = "Expandir todos os menus"
    expandAllBtn.dataset.allExpanded = "false"
  }
}

function initializeExpandAll() {
  const expandAllBtn = document.getElementById("expandAllBtn")
  const categoryToggles = document.querySelectorAll(".nav-category-toggle")
  const submenus = document.querySelectorAll(".nav-submenu")

  if (!expandAllBtn) return

  expandAllBtn.addEventListener("click", () => {
    const sidebar = document.getElementById("sidebar")

    // Não permitir expandir todos quando sidebar está colapsada
    if (sidebar && sidebar.classList.contains("collapsed")) {
      return
    }

    const allExpanded = expandAllBtn.dataset.allExpanded === "true"

    if (!allExpanded) {
      // Expandir todos
      categoryToggles.forEach((toggle) => {
        toggle.classList.add("active")
      })
      submenus.forEach((submenu) => {
        submenu.classList.add("show")
      })
      expandAllBtn.innerHTML = '<i class="fas fa-compress-arrows-alt"></i><span class="btn-text">Recolher Todos</span>'
      expandAllBtn.title = "Recolher todos os menus"
      expandAllBtn.dataset.allExpanded = "true"
    } else {
      // Recolher todos
      categoryToggles.forEach((toggle) => {
        toggle.classList.remove("active")
      })
      submenus.forEach((submenu) => {
        submenu.classList.remove("show")
      })
      expandAllBtn.innerHTML = '<i class="fas fa-expand-arrows-alt"></i><span class="btn-text">Expandir Todos</span>'
      expandAllBtn.title = "Expandir todos os menus"
      expandAllBtn.dataset.allExpanded = "false"
    }

    updateExpandAllButtonState()
  })

  updateExpandAllButtonState()
}
