$(document).ready(function(){

  fetch_donorslist();
  fetch_bloodcomponent();
  fetch_disease();

  function fetch_donorslist() {
    var dataTable = $('#tbl_donorrecord').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url: "donor-related/table_donorrecord.php",
        type: "POST"
      }
    });
  }

  function fetch_bloodcomponent(){
    var dataTable = $('#tbl_bloodcomponent').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url : "blood-related/fetch_bloodcomponent.php",
        type: "POST"
      }
    });
  }

  function fetch_disease(){
    var dataTable = $('#tbl_disease').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url : "disease-related/fetch_disease.php",
        type: "POST"
      }
    });
  }
});
