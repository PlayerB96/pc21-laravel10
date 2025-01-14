<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    body {
        line-height: 1.5;
        font-family: 'Poppins', sans-serif;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container {
        max-width: 1170px;
        margin: auto;
    }

    /* Efecto al pasar el cursor sobre los íconos */
    /* Cambiar el fondo al pasar el cursor sobre los íconos */
    .social-links a:hover {
        background-color: #ffffff;
        transition: background-color 0.3s ease;
        border-radius: 50%;

    }

    /* Si quieres agregar un poco de espacio entre el ícono y el fondo */
    .social-links a img {
        transition: background-color 0.3s ease;
        padding: 0.1rem;
        margin: 0.2rem;
        border-radius: 50%;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
    }

    ul {
        list-style: none;
    }

    .footer {
        background-color: #24262b;
        padding: 70px 0;
    }

    .footer-col {
        width: 25%;
        padding: 0 15px;
    }

    .footer-col h4 {
        font-size: 18px;
        color: #ffffff;
        text-transform: capitalize;
        margin-bottom: 35px;
        font-weight: 500;
        position: relative;
    }

    .footer-col h4::before {
        content: '';
        position: absolute;
        left: 0;
        bottom: -10px;
        background-color: #e91e63;
        height: 2px;
        box-sizing: border-box;
        width: 50px;
    }

    .footer-col ul li:not(:last-child) {
        margin-bottom: 10px;
    }

    .footer-col ul li a {
        font-size: 16px;
        text-transform: capitalize;
        color: #ffffff;
        text-decoration: none;
        font-weight: 300;
        color: #bbbbbb;
        display: block;
        transition: all 0.3s ease;
    }

    .footer-col ul li a:hover {
        color: red;
        padding-left: 8px;
    }

    .footer-col .social-links a {
        display: inline-block;
        height: 40px;
        width: 40px;
        margin: 0 10px 10px 0;

    }



    /*responsive*/
    @media(max-width: 767px) {
        .footer-col {
            width: 50%;
            margin-bottom: 30px;
        }
    }

    @media(max-width: 574px) {
        .footer-col {
            width: 100%;
        }
    }
</style>
<footer class="footer footerbackground">
    <div class="container">
        <div class="row">
            <div class="footer-col">
                <h4>Compañia</h4>
                <ul>
                    <li><a class="footertext" href="#">Sobre Nosotros</a></li>
                    <li><a class="footertext" href="#">Nuestros Servicios</a></li>
                    <li><a class="footertext" href="#">Política de Privacidad</a></li>
                    <li><a class="footertext" href="#">Aplicativo LN1</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Obtener Ayuda</h4>
                <ul>
                    <li><a class="footertext" href="#">FAQ</a></li>
                    <li><a class="footertext" href="#">Soporte</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Tienda en Línea </h4>
                <ul>
                    <li><a class="footertext" href="https://www.lanumero1.com.pe/collections/infantil" target="_blank">Infantil</a></li>
                    <li><a class="footertext" href="https://www.lanumero1.com.pe/collections/hombre" target="_blank">Hombre</a></li>
                    <li><a class="footertext" href="https://www.lanumero1.com.pe/collections/mujer" target="_blank">Mujer</a></li>
                    <li><a class="footertext" href="https://www.lanumero1.com.pe/collections/promos-de-navidad" target="_blank">Ofertas</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Síganos</h4>
                <div class="social-links">
                    <a href="#">
                        <img id="fb-icon" src="{{ asset('assets/icons/facebook-icon.svg') }}" alt="FB Icono" class="theme-icon" title="Facebook LN1" />
                    </a>
                    <a href="#">
                        <img id="fb-icon" src="{{ asset('assets/icons/instagram-icon.svg') }}" alt="INSTA Icono" class="theme-icon" title="Instagram LN1" />
                    </a>
                    <a href="#">
                        <img id="fb-icon" src="{{ asset('assets/icons/linkedin-icon.svg') }}" alt="LINKDN Icono" class="theme-icon" title="Linkedn LN1" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>