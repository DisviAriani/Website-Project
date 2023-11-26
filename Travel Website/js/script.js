// RESPONSIVE NAVBAR MOBILE
const iconList = document.getElementById("icon-list");
const menuList = document.getElementById("menu-list");

iconList.addEventListener("click", () => {
  menuList.classList.toggle("hidden");
});

// VALIDATION FORM
function validateForm() {
  const name = document.getElementById("name-input").value;
  const email = document.getElementById("email-input").value;
  const destination = document.getElementById("destination-input").value;

  document.getElementById("name-error").innerHTML = "";
  document.getElementById("email-error").innerHTML = "";
  document.getElementById("destination-error").innerHTML = "";

  let isValid = true;

  if (name === "") {
    document.getElementById("name-error").innerHTML = "*Nama tidak boleh kosong";
    isValid = false;
  }

  if (email === "") {
    document.getElementById("email-error").innerHTML = "*email tidak boleh kosong";
    isValid = false;
  }

  if (destination === "" || destination === "Choose your destination") {
    document.getElementById("destination-error").innerHTML = "*Pilih destinasi anda";
    isValid = false;
  }

  return isValid;
}

// AUTO SLIDE IMAGE
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
}, 1000);
