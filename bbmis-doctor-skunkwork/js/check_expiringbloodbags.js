$(function(){
  check_expiringbloodbags();

  function check_expiringbloodbags(){
    $.ajax({
      type: "POST",
      url: "blood-related/check_expiringbloodbags.php"
    });
  }

});
