<head>
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
</head>
<x-modal id="modal-{{ uniqid() }}" title="Iniciar sesión" actionButton="Aceptar" class="custom-modal" extraClass="">
    <div class="wide-content">
        <div class="login-card">
            <div class="brand">
                <img src="{{ asset('assets/imgs/Grupo.LN1NegroFTransp.png') }}" alt="Grupo LN1 Logo">
                <h1>Bienvenido</h1>
                <p>Ingrese sus credenciales para acceder a su cuenta </p>
            </div>
            <form id="loginForm">
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
                <x-button
                    text="Iniciar sesión"
                    id="loginButton"
                    class="btn-primary"
                    style="width: 100%; padding: 1rem; margin: 1rem 0rem; background: #000; color: white; border: none; border-radius: 12px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;" />
            </form>
            <div class=" signup-link">
                <p>¿No tienes una cuenta? <a href="#" id="openRegisterModal">Registrarse</a></p>
            </div>
        </div>
    </div>
</x-modal>

<script src="{{ asset('js/auth/login.js') }}"></script>