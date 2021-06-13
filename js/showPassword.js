function showPass(obj) {
  var obj = document.getElementById('password');
  var obj2 = document.getElementById('passImg');
  if (obj.type === "password") {
      obj.type = "text";
      obj2.src = "https://s2.svgbox.net/hero-solid.svg?ic=eye-off&color=ff0000";
  } else {
      obj.type = "password";
      obj2.src = "https://s2.svgbox.net/hero-solid.svg?ic=eye&color=ff0000";
  }
}

function showConfirmPass(obj) {
  var obj = document.getElementById('confirmPassword');
  var obj2 = document.getElementById('confirmPassImg');
  if (obj.type === "password") {
      obj.type = "text";
      obj2.src = "https://s2.svgbox.net/hero-solid.svg?ic=eye-off&color=ff0000";
  } else {
      obj.type = "password";
      obj2.src = "https://s2.svgbox.net/hero-solid.svg?ic=eye&color=ff0000";
  }
}