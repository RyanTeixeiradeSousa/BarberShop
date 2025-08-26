document.addEventListener("DOMContentLoaded", () => {
  initializeNotifications()
})

function initializeNotifications() {
  const notificationsBtn = document.getElementById("notificationsBtn")
  const notificationsDropdown = document.getElementById("notificationsDropdown")
  const notificationsList = document.getElementById("notificationsList")
  const notificationCount = document.getElementById("notificationCount")
  const markAllReadBtn = document.getElementById("markAllReadBtn")

  // Dados simulados das notificações para barbearia
  const notifications = [
    {
      id: 1,
      type: "academic",
      icon: "fa-calendar-check",
      title: "Agendamento Confirmado",
      message: "João Silva confirmou o agendamento para hoje às 14h.",
      time: "2 horas atrás",
      read: false,
    },
    {
      id: 2,
      type: "financial",
      icon: "fa-dollar-sign",
      title: "Pagamento Recebido",
      message: "Pagamento de R$ 45,00 recebido de Maria Santos.",
      time: "1 dia atrás",
      read: false,
    },
    {
      id: 3,
      type: "communication",
      icon: "fa-user-plus",
      title: "Novo Cliente",
      message: "Pedro Oliveira se cadastrou no sistema.",
      time: "2 dias atrás",
      read: false,
    },
    {
      id: 4,
      type: "system",
      icon: "fa-cog",
      title: "Backup Realizado",
      message: "Backup automático dos dados foi concluído.",
      time: "3 dias atrás",
      read: true,
    },
    {
      id: 5,
      type: "academic",
      icon: "fa-scissors",
      title: "Serviço Concluído",
      message: "Corte de cabelo finalizado para Carlos Lima.",
      time: "1 semana atrás",
      read: false,
    },
  ]

  // Toggle dropdown
  if (notificationsBtn) {
    notificationsBtn.addEventListener("click", (e) => {
      e.stopPropagation()
      if (notificationsDropdown) {
        notificationsDropdown.classList.toggle("show")
        renderNotifications()
      }
    })
  }

  // Fechar dropdown ao clicar fora
  document.addEventListener("click", (e) => {
    if (
      notificationsDropdown &&
      !notificationsDropdown.contains(e.target) &&
      notificationsBtn &&
      !notificationsBtn.contains(e.target)
    ) {
      notificationsDropdown.classList.remove("show")
    }
  })

  // Marcar todas como lidas
  if (markAllReadBtn) {
    markAllReadBtn.addEventListener("click", () => {
      notifications.forEach((notification) => {
        notification.read = true
      })
      renderNotifications()
      updateNotificationCount()
      showToast("Todas as notificações foram marcadas como lidas!", "success")
    })
  }

  // Renderizar notificações
  function renderNotifications() {
    if (!notificationsList) return

    notificationsList.innerHTML = notifications
      .map(
        (notification) => `
            <div class="notification-item ${!notification.read ? "unread" : ""}" data-id="${notification.id}">
                <div class="notification-content">
                    <div class="notification-icon ${notification.type}">
                        <i class="fas ${notification.icon}"></i>
                    </div>
                    <div class="notification-text">
                        <div class="notification-title">${notification.title}</div>
                        <div class="notification-message">${notification.message}</div>
                        <div class="notification-time">${notification.time}</div>
                        ${
                          !notification.read
                            ? `
                            <div class="notification-actions">
                                <button class="btn btn-sm btn-primary mark-read-btn" data-id="${notification.id}">
                                    <i class="fas fa-check me-1"></i>
                                    Marcar como lida
                                </button>
                            </div>
                        `
                            : ""
                        }
                    </div>
                    <span class="notification-badge-type badge-${notification.type}">
                        ${getTypeLabel(notification.type)}
                    </span>
                </div>
            </div>
        `,
      )
      .join("")

    // Adicionar event listeners para marcar como lida
    document.querySelectorAll(".mark-read-btn").forEach((btn) => {
      btn.addEventListener("click", function (e) {
        e.stopPropagation()
        const notificationId = Number.parseInt(this.dataset.id)
        markAsRead(notificationId)
      })
    })
  }

  // Marcar notificação como lida
  function markAsRead(id) {
    const notification = notifications.find((n) => n.id === id)
    if (notification) {
      notification.read = true

      // Animação de leitura
      const notificationElement = document.querySelector(`[data-id="${id}"]`)
      if (notificationElement) {
        notificationElement.classList.add("notification-read-animation")
      }

      setTimeout(() => {
        renderNotifications()
        updateNotificationCount()
        showToast("Notificação marcada como lida!", "success")
      }, 300)
    }
  }

  // Atualizar contador
  function updateNotificationCount() {
    if (!notificationCount) return

    const unreadCount = notifications.filter((n) => !n.read).length
    notificationCount.textContent = unreadCount
    notificationCount.style.display = unreadCount > 0 ? "block" : "none"
  }

  // Obter label do tipo
  function getTypeLabel(type) {
    const labels = {
      academic: "Agendamento",
      financial: "Financeiro",
      communication: "Cliente",
      system: "Sistema",
    }
    return labels[type] || "Geral"
  }

  function showToast(message, type = "info") {
    // Criar toast simples sem Bootstrap
    const toastHtml = `
            <div class="custom-toast toast-${type}" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === "success" ? "#10b981" : "#139cbd"};
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 9999;
                font-size: 0.9rem;
                max-width: 300px;
                opacity: 0;
                transform: translateX(100%);
                transition: all 0.3s ease;
            ">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-${type === "success" ? "check-circle" : "info-circle"}"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" style="
                        background: none;
                        border: none;
                        color: white;
                        margin-left: auto;
                        cursor: pointer;
                        padding: 0;
                        font-size: 1.2rem;
                    ">×</button>
                </div>
            </div>
        `

    document.body.insertAdjacentHTML("beforeend", toastHtml)
    const toastElement = document.body.lastElementChild

    // Animar entrada
    setTimeout(() => {
      toastElement.style.opacity = "1"
      toastElement.style.transform = "translateX(0)"
    }, 100)

    // Remover automaticamente após 3 segundos
    setTimeout(() => {
      if (toastElement && toastElement.parentElement) {
        toastElement.style.opacity = "0"
        toastElement.style.transform = "translateX(100%)"
        setTimeout(() => {
          if (toastElement && toastElement.parentElement) {
            toastElement.remove()
          }
        }, 300)
      }
    }, 3000)
  }

  // Inicializar
  updateNotificationCount()
  renderNotifications()
}
