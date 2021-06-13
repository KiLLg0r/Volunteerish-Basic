function getStateByCountry() {
  var countryId = $("#countryId").val();
  $.post("../php/ajax.php", { getStateByCountry: "getStateByCountry", countryId: countryId }, function (response) {
    var data = response.split("^");
    $("#stateId").html(data[1]);
  });
}

function getCityByState() {
  var stateId = $("#stateId").val();
  $.post("../php/ajax.php", { getCityByState: "getCityByState", stateId: stateId }, function (response) {
    var data = response.split("^");
    $("#cityDiv").html(data[1]);
  });
}
