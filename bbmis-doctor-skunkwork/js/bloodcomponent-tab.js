$(document).ready(function(){
  //initialize datatables
  fetch_activebloodcomponent();
  fetch_inactivebloodcomponent();
  function fetch_activebloodcomponent(){
    //initialize active blood component table
    var dataTable = $('#tbl_activebloodcomponent').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url : "blood-related/fetch_activebloodcomponent.php",
        type: "POST"
      },
      "language" : {
        "emptyTable" : "No active blood component to show"
      }
    });
  }
  //initialize inactive blood component table
  function fetch_inactivebloodcomponent(){
    var dataTable = $('#tbl_inactivebloodcomponent').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url: "blood-related/fetch_inactivebloodcomponent.php",
        type: "POST"
      },
      "language" : {
        "emptyTable" : "No inactive blood component to show"
      }
    });
  }
});
