document.addEventListener("DOMContentLoaded", function () {
    const body = document.body;
    const siteNav = document.querySelector(".site-nav");
    const menuToggle = document.querySelector(".menu-toggle");
    const darkLight = document.querySelector(".dark-light");
    const searchToggle = document.querySelector(".searchToggle");
    const searchField = document.querySelector(".search-field");
    const searchInput = searchField ? searchField.querySelector("input") : null;
    const navLinks = document.querySelectorAll(".nav-link");

    /* Theme */
    const savedTheme = localStorage.getItem("ucsm-theme");
    const isDark = savedTheme === "dark";

    body.classList.toggle("dark", isDark);
    darkLight?.classList.toggle("active", isDark);
    darkLight?.setAttribute("aria-pressed", isDark ? "true" : "false");

    darkLight?.addEventListener("click", function (event) {
        event.preventDefault();
        event.stopPropagation();

        const dark = body.classList.toggle("dark");
        darkLight.classList.toggle("active", dark);
        darkLight.setAttribute("aria-pressed", dark ? "true" : "false");
        localStorage.setItem("ucsm-theme", dark ? "dark" : "light");
    });

    /* Mobile navigation */
    function closeMenu() {
        siteNav?.classList.remove("active");
        menuToggle?.setAttribute("aria-expanded", "false");
        menuToggle?.setAttribute("aria-label", "Open navigation menu");
    }

    function openMenu() {
        siteNav?.classList.add("active");
        menuToggle?.setAttribute("aria-expanded", "true");
        menuToggle?.setAttribute("aria-label", "Close navigation menu");
    }

    menuToggle?.addEventListener("click", function (event) {
        event.preventDefault();
        event.stopPropagation();

        if (siteNav?.classList.contains("active")) {
            closeMenu();
        } else {
            openMenu();
        }
    });

    navLinks.forEach(function (link) {
        link.addEventListener("click", closeMenu);
    });

    /* Search */
    searchToggle?.addEventListener("click", function (event) {
        event.preventDefault();
        event.stopPropagation();

        const active = searchToggle.classList.toggle("active");
        searchToggle.setAttribute("aria-expanded", active ? "true" : "false");

        if (active) {
            window.setTimeout(function () {
                searchInput?.focus();
            }, 50);
        }
    });

    /* Close controls when clicking outside */
    document.addEventListener("click", function (event) {
        const target = event.target;

        if (siteNav && menuToggle && !siteNav.contains(target) && !menuToggle.contains(target)) {
            closeMenu();
        }

        if (searchToggle && searchField && !searchToggle.contains(target) && !searchField.contains(target)) {
            searchToggle.classList.remove("active");
            searchToggle.setAttribute("aria-expanded", "false");
        }
    });

    /* Escape key */
    document.addEventListener("keydown", function (event) {
        if (event.key !== "Escape") return;

        closeMenu();

        searchToggle?.classList.remove("active");
        searchToggle?.setAttribute("aria-expanded", "false");
    });
});
