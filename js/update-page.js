$("#first").click(function(){
  $("#first").addClass("active");
    $("#second").removeClass("active");
    $("#third").removeClass("active");
  $("#first-div").removeClass("invisible")
  $("#second-div").addClass("invisible");
  $("#third-div").addClass("invisible");
});

$("#second").click(function(){
  $("#second").addClass("active");
  $("#third").removeClass("active");
  $("#first").removeClass("active");
  $("#second-div").removeClass("invisible")
  $("#first-div").addClass("invisible");
  $("#third-div").addClass("invisible");
});

$("#third").click(function(){
  $("#second").removeClass("active");
  $("#first").removeClass("active");
  $("#third").addClass("active");
  $("#third-div").removeClass("invisible active");
  $("#first-div").addClass("invisible");
  $("#second-div").addClass("invisible");
});
