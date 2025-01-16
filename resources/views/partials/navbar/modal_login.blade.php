<head>
    <link rel="stylesheet" href="{{ asset('css/login/login.css') }}">
</head>
<style>
    .custom-modal .wide-content {
        width: 100%;
        margin: 0 auto;
        padding: 20px;
        overflow-x: auto;
    }

    .wide-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .wide-table th,
    .wide-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    .wide-table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }
</style>

<x-modal id="modal-{{ uniqid() }}" title="Iniciar sesión" actionButton="Aceptar" class="custom-modal">
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

                <button type="submit" class="login-btn" id="loginButton">
                    Ingresar
                </button>
            </form>
            <div class="signup-link">
                <p>¿No tienes una cuenta? <a href="#">Registrarse</a></p>
            </div>
        </div>


    </div>
</x-modal>


<script src="{{ asset('js/login/login.js') }}"></script>