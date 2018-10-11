$(document).ready(function(){
  count_notifications();
  //count notification
  function count_notifications(){
    $.ajax({
      url: "blood-related/count_notifications.php",
      success: function (data){
        $('.count').html(data);
      }
    });
  }
});
//show notification on button click
$(document).on("click", ".dropdown-toggle", function(){
  $.ajax({
    url: "blood-related/fetch_notifications.php",
    success: function(data){
      $('.dropdown-menu').html(data);
    }
  });
});
