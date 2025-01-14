<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Extranet La Número Uno')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <!-- Navbar (siempre visible) -->
    @include('partials.navbar')

    <!-- Main Content: Aquí se cargará el contenido dinámico -->
    <main id="main-content" style="min-height: 500px;">
        @yield('content')

        <!-- Contenedor del footer -->
        <div id="footer-placeholder" style="min-height: 100px;">
            <!-- Placeholder para el footer cargado dinámicamente -->
        </div>

        <!-- Botón flotante para abrir el chat -->
        <button id="chat-button" class="chat-button">
            <img style="width:2rem" src="{{ asset('assets/imgs/chatbot.png') }}" alt="Chatbot" />
        </button>

        <!-- Ventana del chat -->
        <div id="chat-window" class="chat-window" style="display:none;">
            <div class="chat-header">
                <span>Chat</span>
                <button id="close-chat" class="close-chat">X</button>
            </div>
            <div class="chat-body">
                <p>¡Hola! ¿En qué puedo ayudarte?</p>
            </div>
            <div class="chat-footer">
                <input type="text" placeholder="Escribe un mensaje..." />
                <button>Enviar</button>
            </div>
        </div>

        <script>
            // Lazy loading para el footer
            const footerPlaceholder = document.getElementById('footer-placeholder');
            const mainContent = document.getElementById('main-content');

            const loadFooter = () => {
                fetch("{{ route('footer.view') }}")
                    .then(response => response.text())
                    .then(html => {
                        footerPlaceholder.innerHTML = html;
                        loadFooterScripts();
                    })
                    .catch(error => console.error('Error loading footer:', error));
            };

            const loadFooterScripts = () => {
                const script = document.createElement('script');
                // script.src = "{{ asset('js/footer.js') }}";
                document.body.appendChild(script);
            };

            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        loadFooter();
                        observer.unobserve(footerPlaceholder);
                    }
                });
            }, {
                threshold: 0.1
            });

            observer.observe(footerPlaceholder);

            // Lazy loading para contenido dinámico
            document.querySelectorAll('a[data-route]').forEach(anchor => {
                anchor.addEventListener('click', function(event) {
                    event.preventDefault();
                    const url = this.getAttribute('data-route');
                    fetch(url)
                        .then(response => response.text())
                        .then(data => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(data, 'text/html');
                            const content = doc.querySelector('#main-content').innerHTML;
                            mainContent.innerHTML = content;
                            history.pushState(null, '', url);
                        })
                        .catch(error => console.error('Error loading content:', error));
                });
            });

            // Chat interactions
            const chatButton = document.getElementById('chat-button');
            const chatWindow = document.getElementById('chat-window');
            const closeChatButton = document.getElementById('close-chat');

            chatButton.addEventListener('click', () => {
                chatWindow.style.display = 'block';
            });

            closeChatButton.addEventListener('click', () => {
                chatWindow.style.display = 'none';
            });
        </script>
</body>

</html>