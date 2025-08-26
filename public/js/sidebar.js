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
    })
  })

  // Expandir automaticamente o submenu que contém a página ativa
  const activeLink = document.querySelector(".nav-submenu .nav-link.active")
  if (activeLink) {
    const submenu = activeLink.closest(".nav-submenu")
    const toggle = document.querySelector(`[data-target="${submenu.id}"]`)
    if (toggle && submenu) {
      toggle.classList.add("active")
      submenu.classList.add("show")
    }
  }
}

function initializeExpandAll() {
  const expandAllBtn = document.getElementById("expandAllBtn")
  const categoryToggles = document.querySelectorAll(".nav-category-toggle")
  const submenus = document.querySelectorAll(".nav-submenu")
  let allExpanded = false

  if (!expandAllBtn) return

  expandAllBtn.addEventListener("click", () => {
    const sidebar = document.getElementById("sidebar")

    // Não permitir expandir todos quando sidebar está colapsada
    if (sidebar && sidebar.classList.contains("collapsed")) {
      return
    }

    allExpanded = !allExpanded

    if (allExpanded) {
      // Expandir todos
      categoryToggles.forEach((toggle) => {
        toggle.classList.add("active")
      })
      submenus.forEach((submenu) => {
        submenu.classList.add("show")
      })
      expandAllBtn.innerHTML = '<i class="fas fa-compress-arrows-alt"></i><span class="btn-text">Recolher Todos</span>'
      expandAllBtn.title = "Recolher todos os menus"
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
    }
  })

  // Verificar estado inicial
  function checkExpandedState() {
    const activeToggles = document.querySelectorAll(".nav-category-toggle.active")
    const totalToggles = categoryToggles.length

    if (activeToggles.length === totalToggles && totalToggles > 0) {
      allExpanded = true
      expandAllBtn.innerHTML = '<i class="fas fa-compress-arrows-alt"></i><span class="btn-text">Recolher Todos</span>'
      expandAllBtn.title = "Recolher todos os menus"
    } else {
      allExpanded = false
      expandAllBtn.innerHTML = '<i class="fas fa-expand-arrows-alt"></i><span class="btn-text">Expandir Todos</span>'
      expandAllBtn.title = "Expandir todos os menus"
    }
  }

  // Verificar estado quando um submenu individual é alterado
  categoryToggles.forEach((toggle) => {
    toggle.addEventListener("click", () => {
      setTimeout(checkExpandedState, 100)
    })
  })

  checkExpandedState()
}

document.addEventListener('DOMContentLoaded', function() {
  // Funcionalidade de toggle dos submenus
  const categoryToggles = document.querySelectorAll('.nav-category-toggle');
  
  categoryToggles.forEach(toggle => {
      toggle.addEventListener('click', function() {
          const targetId = this.getAttribute('data-target');
          const submenu = document.getElementById(targetId);
          const icon = this.querySelector('.toggle-icon');
          const category = this.closest('.nav-category');
          
          if (submenu) {
              // Toggle do submenu
              if (submenu.style.display === 'block') {
                  submenu.style.display = 'none';
                  icon.classList.remove('fa-chevron-up');
                  icon.classList.add('fa-chevron-down');
                  category.classList.remove('expanded');
              } else {
                  submenu.style.display = 'block';
                  icon.classList.remove('fa-chevron-down');
                  icon.classList.add('fa-chevron-up');
                  category.classList.add('expanded');
              }
          }
      });
  });
  
  // Botão expandir todos
  const expandAllBtn = document.getElementById('expandAllBtn');
  let allExpanded = false;
  
  if (expandAllBtn) {
      expandAllBtn.addEventListener('click', function() {
          const submenus = document.querySelectorAll('.nav-submenu');
          const icons = document.querySelectorAll('.toggle-icon');
          const categories = document.querySelectorAll('.nav-category');
          const btnText = this.querySelector('.btn-text');
          const btnIcon = this.querySelector('i');
          
          if (!allExpanded) {
              // Expandir todos
              submenus.forEach(submenu => submenu.style.display = 'block');
              icons.forEach(icon => {
                  icon.classList.remove('fa-chevron-down');
                  icon.classList.add('fa-chevron-up');
              });
              categories.forEach(category => category.classList.add('expanded'));
              btnText.textContent = 'Recolher Todos';
              btnIcon.classList.remove('fa-expand-arrows-alt');
              btnIcon.classList.add('fa-compress-arrows-alt');
              allExpanded = true;
          } else {
              // Recolher todos
              submenus.forEach(submenu => submenu.style.display = 'none');
              icons.forEach(icon => {
                  icon.classList.remove('fa-chevron-up');
                  icon.classList.add('fa-chevron-down');
              });
              categories.forEach(category => category.classList.remove('expanded'));
              btnText.textContent = 'Expandir Todos';
              btnIcon.classList.remove('fa-compress-arrows-alt');
              btnIcon.classList.add('fa-expand-arrows-alt');
              allExpanded = false;
          }
      });
  }
  
  // Funcionalidade do botão de fechar sidebar (mobile)
  const sidebarClose = document.getElementById('sidebarClose');
  const sidebar = document.getElementById('sidebar');
  
  if (sidebarClose && sidebar) {
      sidebarClose.addEventListener('click', function() {
          sidebar.classList.remove('show');
      });
  }
});