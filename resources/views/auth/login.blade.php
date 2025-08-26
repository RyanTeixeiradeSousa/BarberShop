<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BarberShop - Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Mudando para fontes tecnológicas Inter e JetBrains Mono -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        /* Aplicando nova paleta de cores tecnológica: preto, azul escuro e branco */
        :root {
          --tech-black: #0a0a0a;
          --tech-dark-blue: #1e293b;
          --tech-blue: #3b82f6;
          --tech-light-blue: #60a5fa;
          --pure-white: #ffffff;
          --tech-gray: #64748b;
          --tech-light-gray: #f1f5f9;
          --tech-border: #334155;
          --tech-accent: #06b6d4;
          --shadow-tech: rgba(59, 130, 246, 0.1);
          --shadow-dark: rgba(0, 0, 0, 0.3);
        }

        * {
          margin: 0;
          padding: 0;
          box-sizing: border-box;
        }

        /* Aplicando fonte Inter como padrão e background tecnológico */
        body.login-page {
          font-family: "Inter", sans-serif;
          background: linear-gradient(135deg, var(--tech-black) 0%, var(--tech-dark-blue) 100%);
          min-height: 100vh;
          position: relative;
          overflow-x: hidden;
        }

        /* Adicionando padrão de grid tecnológico no background */
        body.login-page::before {
          content: "";
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-image: 
            linear-gradient(rgba(59, 130, 246, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(59, 130, 246, 0.03) 1px, transparent 1px);
          background-size: 50px 50px;
          z-index: 1;
        }

        .login-container {
          min-height: 100vh;
          display: flex;
          align-items: center;
          justify-content: center;
          padding: 20px;
          position: relative;
          z-index: 2;
        }

        /* Redesenhando card com estética tecnológica e glassmorphism */
        .login-card {
          background: rgba(255, 255, 255, 0.05);
          backdrop-filter: blur(20px);
          border: 1px solid rgba(255, 255, 255, 0.1);
          border-radius: 16px;
          padding: 50px 40px;
          box-shadow: 
            0 25px 50px rgba(0, 0, 0, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
          width: 100%;
          max-width: 450px;
          min-height: 650px;
          position: relative;
          display: flex;
          flex-direction: column;
          justify-content: center;
        }

        /* Borda superior com gradiente azul tecnológico */
        .login-card::before {
          content: "";
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          height: 3px;
          background: linear-gradient(90deg, var(--tech-blue), var(--tech-accent));
          border-radius: 16px 16px 0 0;
        }

        .logo-section {
          text-align: center;
          margin-bottom: 50px;
        }

        .logo-container {
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 15px;
          margin-bottom: 15px;
        }

        /* Ícone com cor azul tecnológica */
        .logo-icon {
          font-size: 2.8rem;
          color: var(--tech-light-blue);
          filter: drop-shadow(0 0 10px rgba(96, 165, 250, 0.3));
        }

        /* Texto com fonte Inter e cor branca */
        .logo-text {
          font-family: "Inter", sans-serif;
          font-weight: 700;
          font-size: 2.2rem;
          color: var(--pure-white);
          margin: 0;
          text-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        /* Subtítulo com fonte JetBrains Mono para aspecto tecnológico */
        .logo-subtitle {
          color: var(--tech-gray);
          font-size: 1rem;
          font-weight: 500;
          margin: 0;
          font-family: "JetBrains Mono", monospace;
          letter-spacing: 0.5px;
        }

        .login-form {
          width: 100%;
          flex-grow: 1;
          display: flex;
          flex-direction: column;
          justify-content: center;
        }

        .form-group {
          margin-bottom: 25px;
          position: relative;
        }

        /* Labels com cor azul tecnológica */
        .form-label {
          display: flex;
          align-items: center;
          gap: 8px;
          font-weight: 600;
          color: var(--tech-light-blue);
          margin-bottom: 8px;
          font-size: 0.95rem;
        }

        .form-label i {
          font-size: 0.9rem;
        }

        /* Inputs com design tecnológico escuro */
        .form-control {
          width: 100%;
          padding: 14px 16px;
          border: 1px solid var(--tech-border);
          border-radius: 8px;
          font-size: 1rem;
          transition: all 0.3s ease;
          background: rgba(255, 255, 255, 0.05);
          color: var(--pure-white);
          backdrop-filter: blur(10px);
        }

        .form-control:focus {
          outline: none;
          border-color: var(--tech-blue);
          box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
          background: rgba(255, 255, 255, 0.08);
        }

        .form-control::placeholder {
          color: var(--tech-gray);
          font-size: 0.95rem;
        }

        .password-input-container {
          position: relative;
        }

        /* Botão de toggle com cor tecnológica */
        .password-toggle {
          position: absolute;
          right: 12px;
          top: 50%;
          transform: translateY(-50%);
          background: none;
          border: none;
          color: var(--tech-gray);
          cursor: pointer;
          padding: 6px;
          transition: color 0.2s ease;
          font-size: 1rem;
        }

        .password-toggle:hover {
          color: var(--tech-light-blue);
        }

        .form-options {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 30px;
          flex-wrap: wrap;
          gap: 15px;
        }

        .form-check {
          display: flex;
          align-items: center;
          gap: 10px;
        }

        /* Checkbox com estilo tecnológico */
        .form-check-input {
          width: 20px;
          height: 20px;
          border: 2px solid var(--tech-border);
          border-radius: 4px;
          background: rgba(255, 255, 255, 0.05);
        }

        .form-check-input:checked {
          background-color: var(--tech-blue);
          border-color: var(--tech-blue);
        }

        /* Label com cor cinza tecnológica */
        .form-check-label {
          font-size: 1rem;
          color: var(--tech-gray);
          cursor: pointer;
        }

        /* Link com cor azul tecnológica */
        .forgot-password {
          color: var(--tech-accent);
          text-decoration: none;
          font-size: 1rem;
          font-weight: 500;
          transition: color 0.2s ease;
        }

        .forgot-password:hover {
          color: var(--tech-light-blue);
          text-decoration: underline;
        }

        /* Botão com gradiente azul tecnológico */
        .btn-login {
          width: 100%;
          padding: 14px;
          background: linear-gradient(135deg, var(--tech-blue), var(--tech-accent));
          color: var(--pure-white);
          border: none;
          border-radius: 8px;
          font-size: 1.1rem;
          font-weight: 600;
          cursor: pointer;
          transition: all 0.3s ease;
          position: relative;
          overflow: hidden;
          margin-bottom: 25px;
          box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .btn-login:hover {
          box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
          transform: translateY(-1px);
        }

        .btn-login:active {
          transform: translateY(0);
        }

        .btn-loader {
          position: absolute;
          top: 50%;
          left: 50%;
          transform: translate(-50%, -50%);
        }

        .register-link {
          text-align: center;
        }

        /* Texto de registro com cores tecnológicas */
        .register-link p {
          color: var(--tech-gray);
          font-size: 1rem;
          margin: 0;
        }

        .register-link a {
          color: var(--tech-light-blue);
          text-decoration: none;
          font-weight: 600;
          transition: color 0.2s ease;
        }

        .register-link a:hover {
          color: var(--tech-accent);
          text-decoration: underline;
        }

        .login-footer {
          position: absolute;
          bottom: 20px;
          left: 50%;
          transform: translateX(-50%);
          text-align: center;
        }

        /* Footer com cor tecnológica */
        .login-footer p {
          color: rgba(100, 116, 139, 0.8);
          font-size: 0.9rem;
          margin: 0;
          font-family: "JetBrains Mono", monospace;
        }

        /* Estilos de erro com cores tecnológicas */
        .is-invalid {
          border-color: #ef4444 !important;
        }

        .invalid-feedback {
          display: block;
          color: #ef4444;
          font-size: 0.9rem;
          margin-top: 8px;
        }

        .error-message {
          color: #ef4444;
          font-size: 0.85rem;
          margin-top: 6px;
          display: none;
          padding-left: 4px;
        }

        .error-message.show {
          display: block;
        }

        .form-control.error {
          border-color: #ef4444;
          background-color: rgba(239, 68, 68, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
          .login-card {
            padding: 40px 30px;
            margin: 20px;
            min-height: 600px;
          }

          .logo-text {
            font-size: 2rem;
          }

          .form-options {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
          }
        }

        @media (max-width: 480px) {
          .login-card {
            padding: 30px 25px;
            min-height: 550px;
          }

          .logo-container {
            flex-direction: column;
            gap: 10px;
          }

          .logo-text {
            font-size: 1.8rem;
          }

          .form-control {
            padding: 12px 14px;
            font-size: 0.95rem;
          }

          .btn-login {
            padding: 12px;
            font-size: 1rem;
          }
        }
    </style>
</head>
<body class="login-page">
    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo-container">
                    <i class="fas fa-cut logo-icon"></i>
                    <h1 class="logo-text">BarberShop</h1>
                </div>
                <!-- Subtítulo com fonte monospace tecnológica -->
                <p class="logo-subtitle">SISTEMA.ADMIN.V2.0</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="login-form" id="loginForm">
                @csrf
                
                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope"></i>
                        E-mail
                    </label>
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autocomplete="email" 
                        autofocus
                        placeholder="Digite seu e-mail"
                    >
                    <div class="error-message" id="emailError"></div>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock"></i>
                        Senha
                    </label>
                    <div class="password-input-container">
                        <input 
                            type="password" 
                            class="form-control @error('password') is-invalid @enderror" 
                            id="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            placeholder="Digite sua senha"
                        >
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="error-message" id="passwordError"></div>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-options">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Lembrar-me
                        </label>
                    </div>
                    
                    @if (Route::has('password.request'))
                        <a class="forgot-password" href="{{ route('password.request') }}">
                            Esqueceu a senha?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-login" id="loginBtn">
                    <span class="btn-text">ACESSAR SISTEMA</span>
                    <div class="btn-loader" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                </button>

                @if (Route::has('register'))
                    <div class="register-link">
                        <p>Não tem uma conta? <a href="{{ route('register') }}">Cadastre-se</a></p>
                    </div>
                @endif
            </form>
        </div>

        <div class="login-footer">
            <!-- Footer com estilo tecnológico -->
            <p>&copy; {{ date('Y') }} BARBERSHOP.TECH | ALL.RIGHTS.RESERVED</p>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        /* Adicionando validação JavaScript com mensagens abaixo dos campos */
        document.addEventListener("DOMContentLoaded", () => {
          // Elements
          const loginForm = document.getElementById("loginForm")
          const loginBtn = document.getElementById("loginBtn")
          const togglePassword = document.getElementById("togglePassword")
          const passwordInput = document.getElementById("password")
          const emailInput = document.getElementById("email")
          const emailError = document.getElementById("emailError")
          const passwordError = document.getElementById("passwordError")

          // Validation functions
          function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
            return emailRegex.test(email)
          }

          function validatePassword(password) {
            return password.length >= 6
          }

          function showError(input, errorElement, message) {
            input.classList.add("error")
            errorElement.textContent = message
            errorElement.classList.add("show")
          }

          function hideError(input, errorElement) {
            input.classList.remove("error")
            errorElement.classList.remove("show")
          }

          // Real-time validation
          if (emailInput && emailError) {
            emailInput.addEventListener("blur", () => {
              const email = emailInput.value.trim()
              if (!email) {
                showError(emailInput, emailError, "E-mail é obrigatório")
              } else if (!validateEmail(email)) {
                showError(emailInput, emailError, "Digite um e-mail válido")
              } else {
                hideError(emailInput, emailError)
              }
            })

            emailInput.addEventListener("input", () => {
              if (emailError.classList.contains("show")) {
                const email = emailInput.value.trim()
                if (email && validateEmail(email)) {
                  hideError(emailInput, emailError)
                }
              }
            })
          }

          if (passwordInput && passwordError) {
            passwordInput.addEventListener("blur", () => {
              const password = passwordInput.value
              if (!password) {
                showError(passwordInput, passwordError, "Senha é obrigatória")
              } else if (!validatePassword(password)) {
                showError(passwordInput, passwordError, "Senha deve ter pelo menos 6 caracteres")
              } else {
                hideError(passwordInput, passwordError)
              }
            })

            passwordInput.addEventListener("input", () => {
              if (passwordError.classList.contains("show")) {
                const password = passwordInput.value
                if (password && validatePassword(password)) {
                  hideError(passwordInput, passwordError)
                }
              }
            })
          }

          // Form validation on submit
          if (loginForm) {
            loginForm.addEventListener("submit", (e) => {
              let isValid = true

              // Validate email
              const email = emailInput.value.trim()
              if (!email) {
                showError(emailInput, emailError, "E-mail é obrigatório")
                isValid = false
              } else if (!validateEmail(email)) {
                showError(emailInput, emailError, "Digite um e-mail válido")
                isValid = false
              }

              // Validate password
              const password = passwordInput.value
              if (!password) {
                showError(passwordInput, passwordError, "Senha é obrigatória")
                isValid = false
              } else if (!validatePassword(password)) {
                showError(passwordInput, passwordError, "Senha deve ter pelo menos 6 caracteres")
                isValid = false
              }

              if (!isValid) {
                e.preventDefault()
                return false
              }

              // Show loading state
              const btnText = loginBtn.querySelector(".btn-text")
              const btnLoader = loginBtn.querySelector(".btn-loader")

              if (btnText && btnLoader) {
                btnText.style.display = "none"
                btnLoader.style.display = "block"
                loginBtn.disabled = true
              }
            })
          }

          // Password toggle functionality
          if (togglePassword && passwordInput) {
            togglePassword.addEventListener("click", function () {
              const type = passwordInput.getAttribute("type") === "password" ? "text" : "password"
              passwordInput.setAttribute("type", type)

              const icon = this.querySelector("i")
              if (type === "password") {
                icon.classList.remove("fa-eye-slash")
                icon.classList.add("fa-eye")
              } else {
                icon.classList.remove("fa-eye")
                icon.classList.add("fa-eye-slash")
              }
            })
          }
        })
    </script>
</body>
</html>
