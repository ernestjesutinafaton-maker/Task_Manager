document.addEventListener("DOMContentLoaded", () => {

    /* =========================
       RECHERCHE
    ========================= */

    const searchInput = document.querySelector("#todo-search");
    const todoCards = document.querySelectorAll(".todo-card");

    if (searchInput) {

        searchInput.addEventListener("input", () => {

            const search = searchInput.value.toLowerCase().trim();

            todoCards.forEach(card => {

                const title =
                    card.dataset.title?.toLowerCase() || "";

                const content =
                    card.dataset.content?.toLowerCase() || "";

                if (
                    title.includes(search) ||
                    content.includes(search)
                ) {
                    card.style.display = "";
                } else {
                    card.style.display = "none";
                }

            });

        });

    }


    /* =========================
       MODE SOMBRE
    ========================= */

    const darkModeButton =
        document.querySelector("#dark-mode-button");

    if (darkModeButton) {

        darkModeButton.addEventListener("click", () => {

            document.body.classList.toggle("dark-mode");

            const darkMode =
                document.body.classList.contains("dark-mode");

            localStorage.setItem(
                "darkMode",
                darkMode
            );

            updateDarkModeButton();

        });

    }

    function updateDarkModeButton() {

        if (!darkModeButton) {
            return;
        }

        if (
            document.body.classList.contains("dark-mode")
        ) {
            darkModeButton.textContent = "☀️ Mode clair";
        } else {
            darkModeButton.textContent = "🌙 Mode sombre";
        }

    }

    if (
        localStorage.getItem("darkMode") === "true"
    ) {
        document.body.classList.add("dark-mode");
    }

    updateDarkModeButton();


    /* =========================
       CONFIRMATION STATUS
    ========================= */

    const statusForms =
        document.querySelectorAll(".status-form");

    statusForms.forEach(form => {

        form.addEventListener("submit", event => {

            const confirmed = confirm(
                "Voulez-vous vraiment changer le statut de cette tâche ?"
            );

            if (!confirmed) {
                event.preventDefault();
            }

        });

    });


    /* =========================
       TOAST
    ========================= */

    window.showToast = function(message) {

        let toast =
            document.querySelector(".toast");

        if (!toast) {

            toast = document.createElement("div");

            toast.className = "toast";

            document.body.appendChild(toast);
        }

        toast.textContent = message;

        toast.classList.add("show");

        setTimeout(() => {

            toast.classList.remove("show");

        }, 2500);

    };


    /* =========================
       ANIMATION DES BOUTONS
    ========================= */

    const buttons =
        document.querySelectorAll("button, .btn");

    buttons.forEach(button => {

        button.addEventListener("click", () => {

            button.style.transform = "scale(0.96)";

            setTimeout(() => {

                button.style.transform = "";

            }, 100);

        });

    });

});