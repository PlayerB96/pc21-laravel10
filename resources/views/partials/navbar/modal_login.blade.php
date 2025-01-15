<x-modal id="modalLogin" title="Iniciar sesión" actionButton="Aceptar">
    <form>
        <!-- Formulario de login -->
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" required>
        </div>
    </form>
</x-modal>