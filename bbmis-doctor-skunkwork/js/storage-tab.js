$(document).ready(function(){
  fetch_activestorage();
  fetch_inactivestorage();

  function fetch_activestorage(){
    var dataTable = $('#tbl_activestorage').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url: "storage-related/fetch_activestorage.php",
        type: "POST"
      },
      "language" : {
        "emptyTable" : "No active storage to show"
      }
    });
  }

  function fetch_inactivestorage(){
    var dataTable = $('#tbl_inactivestorage').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url: "storage-related/fetch_inactivestorage.php",
        type: "POST"
      },
      "language" : {
        "emptyTable" : "No inactive storage to show"
      }
    });
  }
});
