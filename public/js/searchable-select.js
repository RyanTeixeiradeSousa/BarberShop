/**
 * SearchableSelect - Componente para transformar selects em campos com busca
 * Uso: new SearchableSelect(elemento, opcoes)
 */
class SearchableSelect {
    constructor(selectElement, options = {}) {
      this.originalSelect = selectElement
      this.options = {
        placeholder: options.placeholder || "Digite para buscar...",
        noResultsText: options.noResultsText || "Nenhum resultado encontrado",
        maxHeight: options.maxHeight || "200px",
        searchMinLength: options.searchMinLength || 0,
        allowClear: options.allowClear || false,
        ajax: options.ajax || null, // Para busca via AJAX
        ...options,
      }
  
      this.isOpen = false
      this.selectedValue = this.originalSelect.value
      this.selectedText = this.getSelectedText()
      this.filteredOptions = []
  
      this.init()
    }
  
    init() {
      this.createWrapper()
      this.createSearchInput()
      this.createDropdown()
      this.bindEvents()
      this.hideOriginalSelect()
  
      // Inicializar com valor selecionado
      if (this.selectedValue) {
        this.updateDisplay()
      }
    }
  
    createWrapper() {
      this.wrapper = document.createElement("div")
      this.wrapper.className = "searchable-select-wrapper"
      this.wrapper.style.position = "relative"
      this.wrapper.style.width = "100%"
  
      this.originalSelect.parentNode.insertBefore(this.wrapper, this.originalSelect)
      this.wrapper.appendChild(this.originalSelect)
    }
  
    createSearchInput() {
      this.searchInput = document.createElement("input")
      this.searchInput.type = "text"
      this.searchInput.className = this.originalSelect.className + " searchable-select-input"
      this.searchInput.placeholder = this.options.placeholder
      this.searchInput.autocomplete = "off"
      this.searchInput.style.cursor = "pointer"
      this.searchInput.style.paddingRight = "30px"
  
      // Criar ícone de dropdown
      this.dropdownIcon = document.createElement("span")
      this.dropdownIcon.innerHTML = '<i class="fas fa-chevron-down"></i>'
      this.dropdownIcon.className = "searchable-select-icon"
      this.dropdownIcon.style.position = "absolute"
      this.dropdownIcon.style.right = "10px"
      this.dropdownIcon.style.top = "50%"
      this.dropdownIcon.style.transform = "translateY(-50%)"
      this.dropdownIcon.style.pointerEvents = "none"
      this.dropdownIcon.style.color = "#6b7280"
      this.dropdownIcon.style.transition = "transform 0.2s ease"
  
      this.wrapper.appendChild(this.searchInput)
      this.wrapper.appendChild(this.dropdownIcon)
    }
  
    createDropdown() {
      this.dropdown = document.createElement("div")
      this.dropdown.className = "searchable-select-dropdown"
      this.dropdown.style.position = "absolute"
      this.dropdown.style.top = "100%"
      this.dropdown.style.left = "0"
      this.dropdown.style.right = "0"
      this.dropdown.style.background = "var(--card-bg, #ffffff)"
      this.dropdown.style.border = "1px solid var(--border-color, #d1d5db)"
      this.dropdown.style.borderTop = "none"
      this.dropdown.style.borderRadius = "0 0 8px 8px"
      this.dropdown.style.maxHeight = this.options.maxHeight
      this.dropdown.style.overflowY = "auto"
      this.dropdown.style.zIndex = "1000"
      this.dropdown.style.display = "none"
      this.dropdown.style.boxShadow = "0 4px 6px -1px rgba(0, 0, 0, 0.1)"
  
      this.isInModal = this.originalSelect.closest(".modal") !== null
      if (this.isInModal) {
        this.dropdown.style.zIndex = "1060" // Acima do modal backdrop
      }
  
      this.wrapper.appendChild(this.dropdown)
      this.updateDropdownOptions()
    }
  
    updateDropdownOptions() {
      this.dropdown.innerHTML = ""
  
      const options = Array.from(this.originalSelect.options)
      this.filteredOptions = options.filter((option) => {
        if (option.value === "") return false // Pular opção vazia
  
        const searchTerm = this.searchInput.value.toLowerCase()
        if (searchTerm.length < this.options.searchMinLength) return true
  
        return option.text.toLowerCase().includes(searchTerm)
      })
  
      if (this.filteredOptions.length === 0) {
        const noResults = document.createElement("div")
        noResults.className = "searchable-select-no-results"
        noResults.textContent = this.options.noResultsText
        noResults.style.padding = "12px 16px"
        noResults.style.color = "var(--text-muted, #6b7280)"
        noResults.style.textAlign = "center"
        noResults.style.fontStyle = "italic"
        this.dropdown.appendChild(noResults)
        return
      }
  
      this.filteredOptions.forEach((option) => {
        const optionElement = document.createElement("div")
        optionElement.className = "searchable-select-option"
        optionElement.textContent = option.text
        optionElement.dataset.value = option.value
  
        optionElement.style.padding = "12px 16px"
        optionElement.style.cursor = "pointer"
        optionElement.style.color = "var(--text-primary, #1f2937)"
        optionElement.style.transition = "background-color 0.2s ease"
  
        if (option.value === this.selectedValue) {
          optionElement.style.background = "rgba(59, 130, 246, 0.1)"
          optionElement.style.color = "#3b82f6"
          optionElement.style.fontWeight = "500"
        }
  
        optionElement.addEventListener("mouseenter", () => {
          if (option.value !== this.selectedValue) {
            optionElement.style.background = "rgba(59, 130, 246, 0.05)"
          }
        })
  
        optionElement.addEventListener("mouseleave", () => {
          if (option.value !== this.selectedValue) {
            optionElement.style.background = "transparent"
          }
        })
  
        optionElement.addEventListener("click", () => {
          this.selectOption(option.value, option.text)
        })
  
        this.dropdown.appendChild(optionElement)
      })
    }
  
    selectOption(value, text) {
      this.selectedValue = value
      this.selectedText = text
      this.originalSelect.value = value
  
      this.searchInput.setCustomValidity("")
  
      // Disparar evento change no select original
      const changeEvent = new Event("change", { bubbles: true })
      this.originalSelect.dispatchEvent(changeEvent)
  
      this.updateDisplay()
      this.closeDropdown()
    }
  
    updateDisplay() {
      this.searchInput.value = this.selectedText
      this.searchInput.style.cursor = "pointer"
    }
  
    openDropdown() {
      if (this.isOpen) return
  
      this.isOpen = true
  
      if (this.isInModal) {
        this.positionDropdownInModal()
      }
  
      this.dropdown.style.display = "block"
      this.dropdownIcon.style.transform = "translateY(-50%) rotate(180deg)"
      this.searchInput.style.borderRadius = "8px 8px 0 0"
      this.searchInput.style.cursor = "text"
  
      // Limpar campo para busca
      this.searchInput.value = ""
      this.searchInput.focus()
      this.updateDropdownOptions()
  
      // Fechar outros dropdowns abertos
      document.querySelectorAll(".searchable-select-wrapper").forEach((wrapper) => {
        if (wrapper !== this.wrapper) {
          const instance = wrapper.searchableSelectInstance
          if (instance && instance.isOpen) {
            instance.closeDropdown()
          }
        }
      })
    }
  
    positionDropdownInModal() {
      const inputRect = this.searchInput.getBoundingClientRect()
      const viewportHeight = window.innerHeight
      const dropdownHeight = 200 // altura máxima do dropdown
  
      // Calcular se há espaço suficiente abaixo
      const spaceBelow = viewportHeight - inputRect.bottom
      const spaceAbove = inputRect.top
  
      // Usar position fixed para escapar do overflow do modal
      this.dropdown.style.position = "fixed"
      this.dropdown.style.left = inputRect.left + "px"
      this.dropdown.style.width = inputRect.width + "px"
      this.dropdown.style.right = "auto"
  
      if (spaceBelow >= dropdownHeight || spaceBelow >= spaceAbove) {
        // Posicionar abaixo do input
        this.dropdown.style.top = inputRect.bottom + "px"
        this.dropdown.style.bottom = "auto"
        this.dropdown.style.maxHeight = Math.min(dropdownHeight, spaceBelow - 10) + "px"
      } else {
        // Posicionar acima do input
        this.dropdown.style.top = "auto"
        this.dropdown.style.bottom = viewportHeight - inputRect.top + "px"
        this.dropdown.style.maxHeight = Math.min(dropdownHeight, spaceAbove - 10) + "px"
        this.dropdown.style.borderRadius = "8px 8px 0 0"
        this.searchInput.style.borderRadius = "0 0 8px 8px"
      }
    }
  
    closeDropdown() {
      if (!this.isOpen) return
  
      this.isOpen = false
      this.dropdown.style.display = "none"
      this.dropdownIcon.style.transform = "translateY(-50%) rotate(0deg)"
      this.searchInput.style.borderRadius = "8px"
  
      if (this.isInModal) {
        this.dropdown.style.position = "absolute"
        this.dropdown.style.top = "100%"
        this.dropdown.style.left = "0"
        this.dropdown.style.right = "0"
        this.dropdown.style.bottom = "auto"
        this.dropdown.style.width = "auto"
        this.dropdown.style.maxHeight = this.options.maxHeight
        this.dropdown.style.borderRadius = "0 0 8px 8px"
      }
  
      this.updateDisplay()
    }
  
    bindEvents() {
      // Salvar referência da instância no wrapper
      this.wrapper.searchableSelectInstance = this
  
      // Click no input para abrir/fechar
      this.searchInput.addEventListener("click", (e) => {
        e.stopPropagation()
        if (this.isOpen) {
          this.closeDropdown()
        } else {
          this.openDropdown()
        }
      })
  
      // Input para filtrar opções
      this.searchInput.addEventListener("input", () => {
        if (this.isOpen) {
          this.updateDropdownOptions()
        }
      })
  
      // Teclas de navegação
      this.searchInput.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
          this.closeDropdown()
        } else if (e.key === "Enter") {
          e.preventDefault()
          if (this.isOpen && this.filteredOptions.length > 0) {
            const firstOption = this.filteredOptions[0]
            this.selectOption(firstOption.value, firstOption.text)
          }
        } else if (e.key === "ArrowDown" && !this.isOpen) {
          e.preventDefault()
          this.openDropdown()
        }
      })
  
      this.scrollHandler = () => {
        if (this.isOpen && this.isInModal) {
          // Reposicionar o dropdown quando rolar
          this.positionDropdownInModal()
        }
      }
  
      // Adicionar listener para scroll na janela e no modal
      window.addEventListener("scroll", this.scrollHandler, { passive: true })
  
      // Também escutar scroll no modal se existir
      const modal = this.originalSelect.closest(".modal")
      if (modal) {
        modal.addEventListener("scroll", this.scrollHandler, { passive: true })
      }
  
      document.addEventListener("click", (e) => {
        // Não fechar se o clique foi no wrapper ou dropdown
        if (this.wrapper.contains(e.target) || this.dropdown.contains(e.target)) {
          return
        }
  
        // Se estiver em modal, não fechar se o clique foi em elementos do modal
        if (this.isInModal) {
          const modal = this.originalSelect.closest(".modal")
          const modalContent = modal?.querySelector(".modal-content, .modal-dialog, .modal-body")
  
          // Se o clique foi dentro do conteúdo do modal, não fechar
          if (modalContent && modalContent.contains(e.target)) {
            // Verificar se não é um botão de fechar ou ação que deve fechar o dropdown
            const isCloseButton = e.target.closest(".btn-close, .modal-close, [data-bs-dismiss], [data-dismiss]")
            if (!isCloseButton) {
              return
            }
          }
        }
  
        this.closeDropdown()
      })
  
      this.searchInput.addEventListener("blur", (e) => {
        // Usar setTimeout para permitir que o clique em opções seja processado primeiro
        setTimeout(() => {
          // Se o foco foi para um elemento dentro do dropdown ou modal, não fechar
          const activeElement = document.activeElement
          if (this.dropdown.contains(activeElement)) {
            return
          }
  
          if (this.isInModal) {
            const modal = this.originalSelect.closest(".modal")
            const modalContent = modal?.querySelector(".modal-content, .modal-dialog, .modal-body")
            if (modalContent && modalContent.contains(activeElement)) {
              return
            }
          }
  
          // Se não há elemento ativo ou o foco saiu completamente, fechar
          if (!activeElement || !this.wrapper.contains(activeElement)) {
            this.closeDropdown()
          }
        }, 150)
      })
  
      const observer = new MutationObserver(() => {
        this.updateDropdownOptions()
        if (this.originalSelect.value !== this.selectedValue) {
          this.selectedValue = this.originalSelect.value
          this.selectedText = this.getSelectedText()
          this.updateDisplay()
        }
      })
  
      observer.observe(this.originalSelect, {
        childList: true,
        subtree: true,
        attributes: true,
        attributeFilter: ["value"],
      })
  
      const form = this.originalSelect.closest("form")
      if (form) {
        form.addEventListener("submit", (e) => {
          if (!this.validate()) {
            e.preventDefault()
            e.stopPropagation()
          }
        })
      }
    }
  
    hideOriginalSelect() {
      this.originalSelect.style.position = "absolute"
      this.originalSelect.style.left = "-9999px"
      this.originalSelect.style.opacity = "0"
      this.originalSelect.style.pointerEvents = "none"
      this.originalSelect.style.zIndex = "-1"
    }
  
    getSelectedText() {
      const selectedOption = this.originalSelect.options[this.originalSelect.selectedIndex]
      return selectedOption ? selectedOption.text : ""
    }
  
    // Método para atualizar opções via AJAX
    async loadOptions(searchTerm = "") {
      if (!this.options.ajax) return
  
      try {
        const response = await fetch(this.options.ajax.url, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
          },
          body: JSON.stringify({
            search: searchTerm,
            ...this.options.ajax.data,
          }),
        })
  
        const data = await response.json()
  
        // Limpar opções existentes (exceto a primeira vazia)
        const firstOption = this.originalSelect.options[0]
        this.originalSelect.innerHTML = ""
        if (firstOption && firstOption.value === "") {
          this.originalSelect.appendChild(firstOption)
        }
  
        // Adicionar novas opções
        data.forEach((item) => {
          const option = document.createElement("option")
          option.value = item.value
          option.text = item.text
          this.originalSelect.appendChild(option)
        })
  
        this.updateDropdownOptions()
      } catch (error) {
        console.error("Erro ao carregar opções:", error)
      }
    }
  
    destroy() {
      // Remover event listeners
      if (this.scrollHandler) {
        window.removeEventListener("scroll", this.scrollHandler)
        const modal = this.originalSelect.closest(".modal")
        if (modal) {
          modal.removeEventListener("scroll", this.scrollHandler)
        }
      }
  
      this.wrapper.parentNode.insertBefore(this.originalSelect, this.wrapper)
      this.originalSelect.style.display = ""
      this.wrapper.remove()
    }
  
    // Método para validação manual
    validate() {
      // Verificar se o campo é obrigatório e não tem valor
      if (this.originalSelect.hasAttribute("required") && !this.selectedValue) {
        // Focar no input de busca para mostrar erro
        this.searchInput.focus()
        this.searchInput.setCustomValidity("Este campo é obrigatório")
        this.searchInput.reportValidity()
        return false
      }
  
      this.searchInput.setCustomValidity("")
      return true
    }
  }
  
  // Função utilitária para inicializar todos os selects com busca
  function initSearchableSelects(selector = ".searchable-select", options = {}) {
    document.querySelectorAll(selector).forEach((select) => {
      if (!select.closest(".searchable-select-wrapper")) {
        new SearchableSelect(select, options)
      }
    })
  }
  
  // Auto-inicializar quando o DOM estiver pronto
  document.addEventListener("DOMContentLoaded", () => {
    // Inicializar selects com a classe 'searchable-select'
    initSearchableSelects()
  })
  
  // Exportar para uso global
  window.SearchableSelect = SearchableSelect
  window.initSearchableSelects = initSearchableSelects
  