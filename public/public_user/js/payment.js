$("#sec-bkash").hide();
$("#sec-dbbl").hide();
$(document).ready(function(){
  $("#cash").click(function(){
    $("#sec-cash").show();
    $("#sec-bkash").hide();
    $("#sec-dbbl").hide();
    // $(".payment-cash").css("box-shadow", "0 0 2px 1px rgba(0, 140, 186, 0.5)");
    $(".payment-cash").css("background", "#2979F3");
    $(".payment-bkash").css("background", "transparent");
    $(".payment-dbbl").css("background", "transparent");
    $(".p-text").css("color", "black");
    $(".cash-text").css("color", "green");


  });
  $("#bkash").click(function(){
    $("#sec-cash").hide();
    $("#sec-bkash").show();
    $("#sec-dbbl").hide();
    // $(".payment-bkash").css("box-shadow", "0 0 2px 1px rgba(0, 140, 186, 0.5)");
    $(".payment-bkash").css("background", "#2979F3");
    $(".payment-cash").css("background", "transparent");
    $(".payment-dbbl").css("background", "transparent");
    $(".p-text").css("color", "black");
    $(".bkash-text").css("color", "green");
  });
  $("#dbbl").click(function(){
    $("#sec-dbbl").show();
    $("#sec-bkash").hide();
    $("#sec-cash").hide();
    // $(".payment-dbbl").css("box-shadow", "0 0 2px 1px rgba(0, 140, 186, 0.5)");
    $(".payment-dbbl").css("background", "#2979F3");
    $(".payment-bkash").css("background", "transparent");
    $(".payment-cash").css("background", "transparent");
    $(".p-text").css("color", "black");
    $(".dbbl-text").css("color", "green");
  });
});

function dropOrder() {
  var aggr = document.getElementById("aggrement").checked;
  if (aggr) {

    var r = confirm("Are you confirm to drop this order?");
    if (r == true) {
      alert("Your order submited!");
    }
  } else {
    alert("Please check the aggrement");
  }

}

$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip({
      placement : 'top'
  });
});
