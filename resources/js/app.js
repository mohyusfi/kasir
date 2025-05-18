import "./bootstrap";
import AOS from "aos";
import "aos/dist/aos.css";

document.addEventListener("DOMContentLoaded", () => {
    AOS.init({
        duration: 650,
        once: true,
    });
});

document.addEventListener("livewire:navigated", () => {
    AOS.init({
        duration: 650,
        once: true,
    });
});
