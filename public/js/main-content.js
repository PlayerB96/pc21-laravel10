if (!window.mainContentInitialized) {
    window.mainContentInitialized = true;

    var mainContent = document.getElementById("main-content");

    document.body.addEventListener("click", function (event) {
        const target = event.target.closest("[data-route]");
        if (target) {
            event.preventDefault();
            const url = target.getAttribute("data-route");
            loadContent(url);
        }
    });

    window.addEventListener("popstate", (event) => {
        if (event.state && event.state.url) {
            loadContent(event.state.url);
        }
    });

    async function loadContent(url) {
        try {
            const response = await fetch(url, {
                headers: { "X-Requested-With": "XMLHttpRequest" },
            });

            if (!response.ok) {
                throw new Error(
                    `Error ${response.status}: ${response.statusText}`
                );
            }

            const text = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(text, "text/html");

            const newContent = doc.querySelector("#main-content");
            if (newContent) {
                mainContent.innerHTML = newContent.innerHTML;
            }

            const newTitle = doc.querySelector("title");
            if (newTitle) {
                document.title = newTitle.innerText;
            }

            if (window.location.href !== url) {
                history.pushState({ url }, "", url);
            }

            executeScripts(doc);
        } catch (error) {
            console.error("Error cargando contenido:", error);
        }
    }

    function executeScripts(doc) {
        doc.querySelectorAll("script").forEach((script) => {
            const newScript = document.createElement("script");
            if (script.src) {
                newScript.src = script.src;
                newScript.async = true;
            } else {
                newScript.textContent = script.textContent;
            }
            document.body.appendChild(newScript);
        });
    }
}
