const list = document.getElementById("list");
const menu = document.getElementById("menu");

list.addEventListener("click", () => {
  menu.classList.toggle("hidden");
});

// slideshow image
var slideIndex = 0;
showDivs();

function plusDivs(n) {
  showDivs((slideIndex += n));
}

function showDivs() {
  var i;
  var imgList = document.getElementsByClassName("img-slideshow");
  if (slideIndex >= imgList.length) {
    slideIndex = 0;
  } else if (slideIndex < 0) {
    slideIndex = imgList.length - 1;
  }

  for (i = 0; i < imgList.length; i++) {
    imgList[i].style.display = "none";
  }
  imgList[slideIndex].style.display = "block";
  slideIndex++;
}

setInterval(function () {
  showDivs();
}, 2000);
