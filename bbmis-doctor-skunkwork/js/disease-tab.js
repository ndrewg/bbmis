$(document).ready(function(){
  fetch_activedisease();
  fetch_inactivedisease();

  function fetch_activedisease(){
    var dataTable = $('#tbl_activedisease').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url : "disease-related/fetch_activedisease.php",
        type: "POST"
      },
      "language" : {
        "emptyTable" : "No active diseases to show"
      }
    });
  }

  function fetch_inactivedisease(){
    var dataTable = $('#tbl_inactivedisease').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url : "disease-related/fetch_inactivedisease.php",
        type : "POST"
      },
      "language" : {
        "emptyTable" : "No inactive diseases to show"
      }
    });
  }
});
