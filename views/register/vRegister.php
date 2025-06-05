<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TechMarket - Registro de Usuario</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <style>
        .error-message {
            background-color: #ffe0e0;
            border: 1px solid #ff4d4d;
            padding: 0.75rem;
            border-radius: 4px;
            color: #a94442;
            margin-bottom: 1rem;
        }

        .error-message ul {
            list-style: none;
            padding-left: 0;
            margin: 0;
        }

        .error-message li {
            margin-bottom: 0.5rem;
        }

        .input-error {
            border-color: #ff4d4d !important;
        }
    </style>
</head>

<body>
    <?php require_once("./views/header/header.php"); ?>

    <main>
        <div class="login-container">
            <h2>Crear Cuenta</h2>

            <?php if (isset($_GET['register']) && $_GET['register'] == 'success'): ?>
                <div style="color: green; margin-bottom: 15px;">
                    Registro exitoso. Ahora puedes iniciar sesión.
                </div>
            <?php endif; ?>

            <form method="POST" action="index.php?acc=Register" id="registerForm" novalidate>
                <div class="form-group">
                    <label for="username">Usuario:</label>
                    <input type="text" id="username" name="username" required minlength="4" maxlength="50" />
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required minlength="6" />
                </div>
                <div class="form-group">
                    <label for="name">Nombre Completo:</label>
                    <input type="text" id="name" name="name" maxlength="100" required />
                </div>
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" id="email" name="email" maxlength="100" required />
                </div>
                <div class="form-group">
                    <label for="phone">Teléfono:</label>
                    <input type="tel" id="phone" name="phone" maxlength="20" required />
                </div>

                <!-- Errores del servidor abajo del formulario -->
                <?php if (!empty($errors)): ?>
                    <div class="error-message" id="phpErrorContainer">
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                
                <div id="errorContainer"></div>

                <button type="submit" name="register">Registrarse</button>
            </form>

            <p class="register-link">
                ¿Ya tienes cuenta? <a href="index.php?acc=Home">Inicia sesión aquí</a>
            </p>
        </div>
    </main>

    <footer>
        <p>&copy; 2025 TechMarket ADS</p>
    </footer>

    <script>
        const form = document.getElementById('registerForm');
        const username = document.getElementById('username');
        const password = document.getElementById('password');
        const nameField = document.getElementById('name');
        const email = document.getElementById('email');
        const phone = document.getElementById('phone');
        const errorContainer = document.getElementById('errorContainer');

        function clearErrors() {
            errorContainer.innerHTML = '';
            document.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
        }

        function showError(message, inputElement) {
            const error = document.createElement('div');
            error.className = 'error-message';
            error.textContent = message;
            errorContainer.appendChild(error);
            if (inputElement) {
                inputElement.classList.add('input-error');
            }
        }

        form.addEventListener('input', () => {
            clearErrors();
        });

        form.addEventListener('submit', (e) => {
            clearErrors();
            let hasError = false;

            if (username.value.trim().length < 4) {
                showError('El usuario debe tener al menos 4 caracteres.', username);
                hasError = true;
            }

            if (password.value.length < 6) {
                showError('La contraseña debe tener al menos 6 caracteres.', password);
                hasError = true;
            }

            if (nameField.value.trim() === '') {
                showError('El nombre completo es obligatorio.', nameField);
                hasError = true;
            }

            if (!email.value.includes('@')) {
                showError('El correo electrónico no es válido.', email);
                hasError = true;
            }

            const phoneRegex = /^[0-9+\s()-]*$/;
            if (!phoneRegex.test(phone.value)) {
                showError('El número de teléfono contiene caracteres inválidos.', phone);
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
            }
        });
    </script>
</body>

</html>
