$(document).ready(function(){
  fetch_activebloodtype();
  fetch_inactivebloodtype();

  function fetch_activebloodtype(){
    var dataTable = $('#tbl_activebloodtype').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url: "blood-related/fetch_activebloodtype.php",
        type: "POST"
      },
      "language" : {
        "emptyTable" : "No active blood type to show"
      }
    });
  }
  function fetch_inactivebloodtype(){
    var dataTable = $('#tbl_inactivebloodtype').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url: "blood-related/fetch_inactivebloodtype.php",
        type: "POST"
      },
      "language" : {
        "emptyTable" : "No inactive blood type to show"
      }
    });
  }
});
