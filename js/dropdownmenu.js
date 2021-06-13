function openDropdownHelping() {
  $(".dropdown-content.helping").toggleClass("show");
  $("#dropdown-img-1-helping").toggle();
  $("#dropdown-img-2-helping").toggle();
}

function openDropdownActive() {
  $(".dropdown-content.active").toggleClass("show");
  $("#dropdown-img-1-active").toggle();
  $("#dropdown-img-2-active").toggle();
}

function openDropdownInactive() {
  $(".dropdown-content.inactive").toggleClass("show");
  $("#dropdown-img-1-inactive").toggle();
  $("#dropdown-img-2-inactive").toggle();
}

function openDropdownFilter() {
  $(".dropdown-content.filter").toggleClass("show");
  $("#dropdown-img-1-filter").toggle();
  $("#dropdown-img-2-filter").toggle();
  $(".dropbtn.filter").toggleClass("down");
}

function openDropdownVol() {
  $(".dropdown-content.volunteer").toggleClass("show");
  $("#dropdown-img-1-vol").toggle();
  $("#dropdown-img-2-vol").toggle();
}

function openDropdownNeedy() {
  $(".dropdown-content.needy").toggleClass("show");
  $("#dropdown-img-1-needy").toggle();
  $("#dropdown-img-2-needy").toggle();
}
