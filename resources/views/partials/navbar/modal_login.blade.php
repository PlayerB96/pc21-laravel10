<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <input type="text" id="username" placeholder="username" autocomplete="username">
                    <div class="error" id="usernameError"></div>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" placeholder="Enter your password"
                        autocomplete="current-password">
                    <div class="error" id="passwordError"></div>
                </div>
                <p id="mensajeError" style="color: red;"></p>

                <button id="loginButton" class="btn-primary"
                    style="width: 100%; padding: 1rem; margin: 0.5rem 0rem; background: #000; color: white; border: none; border-radius: 12px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease;">
                    Iniciar sesión
                </button>

            </form>
            <div class=" signup-link">
                <p>¿No tienes una cuenta? Solicitar <a href="#" id="redirectWhasstp">aquí</a></p>
            </div>
        </div>
    </div>
</x-modal>

<script src="{{ asset('js/auth/login.js') }}"></script>

<style>
    .login-card {
        background: white;
        border-radius: 20px;
        padding: 3rem 2rem;
        width: 100%;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }


    @media (max-width: 1370px) {
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 1.2rem 2rem;
            width: 100%;

            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }

        .brand {
            text-align: center;
            margin-bottom: 1rem !important;
        }

        .brand img {
            width: 6rem !important;
        }

        .form-group {
            margin-bottom: 1rem;
            position: relative;
        }
    }

    @media (max-width: 768px) {
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 1rem 1rem;
            width: 100%;

            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        }



    }

    .brand img {
        width: 14rem;
    }

    .brand {
        text-align: center;
        margin-bottom: 2rem;
    }

    .brand-logo {
        width: 50px;
        height: 50px;
        background: #000;
        border-radius: 50%;
        margin: 0 auto 1rem;
    }

    .brand h1 {
        font-size: 1.75rem;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }

    .brand p {
        color: var(--text-secondary);
        font-size: 0.95rem;
    }

    .form-group {
        margin-bottom: 1rem;
        position: relative;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: var(--text-secondary) !important;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .form-group input {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 2px solid #e1e1e1;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
        color: #000 !important;

    }

    .form-group input:focus {
        outline: none;
        border-color: #000;
        box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.1);
    }



    .remember-forgot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .remember-me {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .remember-me input[type="checkbox"] {
        width: 16px;
        height: 16px;
        border-radius: 4px;
    }

    .remember-me label {
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .forgot-password {
        color: #000;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .login-btn {
        width: 100%;
        padding: 1rem;
        background: #000;
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .login-btn:hover {
        background: #333;
        transform: translateY(-2px);
    }

    .login-btn:active {
        transform: translateY(0);
    }

    .social-login {
        margin-top: 2rem;
        text-align: center;
    }

    .social-login p {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 1rem;
        position: relative;
    }

    .social-login p::before,
    .social-login p::after {
        content: "";
        position: absolute;
        top: 50%;
        width: 45%;
        height: 1px;
        background: #e1e1e1;
    }

    .social-login p::before {
        left: 0;
    }

    .social-login p::after {
        right: 0;
    }

    .social-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .social-btn {
        width: 50px;
        height: 50px;
        border: 2px solid #e1e1e1;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .social-btn:hover {
        border-color: #000;
        background: #f5f5f5;
    }

    .signup-link {
        text-align: center;
        margin-top: 1.5rem;
    }

    .signup-link a {
        color: #000;
        text-decoration: none;
        font-weight: 600;
    }

    .signup-link p {
        color: #000;
        text-decoration: none;
        font-weight: 400;
    }

    .signup-link a:hover {
        text-decoration: underline;
    }

    .error {
        color: var(--error);
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: none;
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        20%,
        60% {
            transform: translateX(-5px);
        }

        40%,
        80% {
            transform: translateX(5px);
        }
    }

    .shake {
        animation: shake 0.5s ease;
    }
</style>
