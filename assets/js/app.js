import '../css/app.scss';
import "bootswatch/dist/lux/bootstrap.min.css";
import './dropdown.js';
import './toggle-password';




window.addEventListener("scroll", function() {
    var logo = document.getElementById("logo");
    var yOffset = window.scrollY;
    if (yOffset > 50) {
        logo.classList.add("hidden");
    } else {
        logo.classList.remove("hidden");
    }
});





