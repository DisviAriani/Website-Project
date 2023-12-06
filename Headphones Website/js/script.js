// header on scroll color change
let header = document.querySelector("header");

window.addEventListener("scroll", () => {
  header.classList.toggle("shadow", window.scrollY > 0);
});

// MENU ICON
let menu = document.querySelector("#menu-icon");
let navbar = document.querySelector(".navbar");

menu.onclick = () => {
  menu.classList.toggle("ph-x");
  navbar.classList.toggle("active");
};

// remove menu on click any menu link
window.onscroll = () => {
  menu.classList.remove("ph-x");
  navbar.classList.remove("active");
};
