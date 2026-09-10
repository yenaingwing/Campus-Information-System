document.addEventListener("DOMContentLoaded", function () {
    const nav = document.querySelector("[data-campus-nav]");
    if (!nav) return;

    const toggle = nav.querySelector(".campus-nav-toggle");
    const links = nav.querySelectorAll(".campus-nav-links a");
    const current = (window.location.pathname.split("/").pop() || "index.html").toLowerCase();

    links.forEach(function (link) {
        const target = (link.getAttribute("href") || "").split("#")[0].toLowerCase();
        if (target === current || (current === "" && target === "index.html")) {
            link.classList.add("active");
            link.setAttribute("aria-current", "page");
        }
    });

    function setOpen(open) {
        nav.classList.toggle("open", open);
        toggle?.setAttribute("aria-expanded", open ? "true" : "false");
    }

    toggle?.addEventListener("click", function (event) {
        event.preventDefault();
        setOpen(!nav.classList.contains("open"));
    });

    links.forEach(function (link) {
        link.addEventListener("click", function () {
            setOpen(false);
        });
    });

    document.addEventListener("click", function (event) {
        if (!nav.contains(event.target)) setOpen(false);
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") setOpen(false);
    });

    window.addEventListener("resize", function () {
        if (window.innerWidth > 900) setOpen(false);
    });
});
