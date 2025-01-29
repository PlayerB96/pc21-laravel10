const mainContent = document.getElementById("main-content");

// Delegación de eventos para enlaces y botones con data-route
document.body.addEventListener("click", function (event) {
    const target = event.target.closest("[data-route]");
    if (target) {
        event.preventDefault();
        const url = target.getAttribute("data-route");
        loadContent(url);
    }
});


// Función para cargar contenido
function loadContent(url) {
    fetch(url)
        .then((response) => response.text())
        .then((data) => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(data, "text/html");
            const newContent = doc.querySelector("#main-content");

            if (newContent) {
                mainContent.innerHTML = newContent.innerHTML;
            }

            const newTitle = doc.querySelector("title");
            if (newTitle) {
                document.title = newTitle.innerText;
            }

            history.pushState(null, "", url);
            executeScripts(doc);
        })
        .catch((error) => console.error("Error loading content:", error));
}

// Función para ejecutar scripts dentro del contenido cargado
function executeScripts(doc) {
    const existingScripts = document.body.querySelectorAll(
        "script[data-dynamic]"
    );
    existingScripts.forEach((script) => script.remove()); // Eliminar scripts anteriores para evitar duplicados

    const scripts = doc.querySelectorAll("script");
    scripts.forEach((script) => {
        const newScript = document.createElement("script");
        newScript.setAttribute("data-dynamic", "true");

        if (script.src) {
            newScript.src = script.src;
            newScript.async = true;
        } else {
            newScript.textContent = script.textContent;
        }

        document.body.appendChild(newScript);
    });
}
