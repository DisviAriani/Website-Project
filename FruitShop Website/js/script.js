const navbar = document.getElementById("navbar");
const menu = document.getElementById("icon-list");

menu.addEventListener("click", () => {
  navbar.classList.toggle("active");
});
