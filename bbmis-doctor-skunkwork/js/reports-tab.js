$(document).ready(function(){
reports_remaining();
reports_wastage();
function reports_remaining(){
  var dataTable = $('#tblremaining').DataTable({
    "processing" : true,
    "serverSide" : true,
    "ajax" : {
      url: "reports-related/reports_remaining.php",
      type: "POST"
    }
  });
}
function reports_wastage(){
  var dataTable = $('#tblwastage').DataTable({
    "processing" : true,
    "serverSide" : true,
    "ajax" : {
      url: "reports-related/reports_wastage.php",
      type: "POST"
    }
  });
}

});
