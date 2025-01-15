<head>
    <link rel="stylesheet" href="{{ asset('css/login/login.css') }}">
</head>

<body>
    <div class="login-card">
        <div class="brand">
            <div class="brand-logo"></div>
            <h1>Bienvenido</h1>
            <p>Enter your credentials to access your account</p>
        </div>

        <form id="loginForm">
            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    placeholder="name@company.com"
                    autocomplete="email">
                <div class="error" id="emailError"></div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    placeholder="Enter your password"
                    autocomplete="current-password">
                <div class="error" id="passwordError"></div>
            </div>

            <div class="remember-forgot">
                <div class="remember-me">
                    <input type="checkbox" id="remember">
                    <label for="remember">Remember me</label>
                </div>
                <a href="#" class="forgot-password">Forgot password?</a>
            </div>

            <button type="submit" class="login-btn" id="loginButton">
                Sign in
            </button>
        </form>

        <div class="social-login">
            <p>O continuar con</p>
            <div class="social-buttons">
                <div class="social-btn">G</div>
                <div class="social-btn">A</div>
                <div class="social-btn">F</div>
            </div>
        </div>

        <div class="signup-link">
            <p>¿No tienes una cuenta? <a href="#">Registrarse</a></p>
        </div>
    </div>
</body>