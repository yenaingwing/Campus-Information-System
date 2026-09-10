document.addEventListener("DOMContentLoaded", function () {
    const slide = document.querySelector(".slide");
    if (!slide) return;

    const items = Array.from(slide.querySelectorAll(".item"));
    if (!items.length) return;

    const nextButton = document.querySelector(".next");
    const prevButton = document.querySelector(".prev");

    let index = 0;
    let timer = null;

    function render() {
        items.forEach(function (item, itemIndex) {
            item.classList.toggle("active", itemIndex === index);
        });
    }

    function next() {
        index = (index + 1) % items.length;
        render();
    }

    function previous() {
        index = (index - 1 + items.length) % items.length;
        render();
    }

    function startAutoPlay() {
        stopAutoPlay();
        timer = window.setInterval(next, 5000);
    }

    function stopAutoPlay() {
        if (timer !== null) {
            window.clearInterval(timer);
            timer = null;
        }
    }

    nextButton?.addEventListener("click", function () {
        next();
        startAutoPlay();
    });

    prevButton?.addEventListener("click", function () {
        previous();
        startAutoPlay();
    });

    slide.addEventListener("mouseenter", stopAutoPlay);
    slide.addEventListener("mouseleave", startAutoPlay);

    render();
    startAutoPlay();
});
