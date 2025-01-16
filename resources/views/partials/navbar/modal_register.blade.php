<head>
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
</head>
<x-modal id="modalr-{{ uniqid() }}" title="Iniciar sesión" actionButton="Aceptar" class="custom-modal" extraClass="">
    <div class="wide-content">
        <div class="login-card">
            <div class="brand">
                <img src="{{ asset('assets/imgs/Grupo.LN1NegroFTransp.png') }}" alt="Grupo LN1 Logo">
                <h1>Regístrate</h1>
            </div>
            <form id="loginForm">
                <div class="form-group">
                    <label for="username">Correo</label>
                    <input
                        type="text"
                        id="username"
                        placeholder="username"
                        autocomplete="username">
                    <div class="error" id="usernameError"></div>
                </div>
                <div class="form-group">
                    <label for="password">Nombre Completo</label>
                    <input
                        type="password"
                        id="password"
                        placeholder="Enter your password"
                        autocomplete="current-password">
                    <div class="error" id="passwordError"></div>
                </div>
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input
                        type="text"
                        id="username"
                        placeholder="username"
                        autocomplete="username">
                    <div class="error" id="usernameError"></div>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        placeholder="Enter your password"
                        autocomplete="current-password">
                    <div class="error" id="passwordError"></div>
                </div>
                <button type="submit" class="login-btn" id="loginButton">
                    Ingresar
                </button>
            </form>
            <div class="signup-link">
                <p>¿ya tienes una cuenta? <a href="#" id="openLoginModal">Ingresa Aquí</a></p>
            </div>
        </div>
    </div>
</x-modal>

<script src="{{ asset('js/auth/login.js') }}"></script>