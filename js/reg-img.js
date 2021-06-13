$("#img-placeholder").click(function () {
  $("#imageUpload").click();
});

$("#imgLabel").click(function () {
  $("#imageUpload").click();
});

var loadFile = function (event) {
  var image = document.getElementById("img-placeholder");
  image.src = URL.createObjectURL(event.target.files[0]);
};
