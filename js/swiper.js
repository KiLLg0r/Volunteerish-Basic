let btn = document.getElementById("reg-btn");
var swiper = new Swiper(".swiper-container", {
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  pagination: {
    el: ".swiper-pagination",
  },
  on: {
    reachEnd: function () {
      btn.style.display = "block";
    },
    slidePrevTransitionStart: function () {
      btn.style.display = "none";
    },
  },
});
