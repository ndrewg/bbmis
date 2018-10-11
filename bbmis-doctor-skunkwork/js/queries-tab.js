$(document).ready(function(){
query();

function query(){
  $("#executequery").on('click',function(e){
    var bloodtype = $("#choose_bloodtype option:selected").val();
    var storage = $("#choose_storage option:selected").val();
    var volume = $("#choose_volume option:selected").val();
    var preservative = $("#choose_preservative option:selected").val();
    console.log(bloodtype);
  /*var dataTable = $('#tblquery').DataTable({
    "processing" : true,
    "serverSide" : true,
    "ajax" : {
      url: "query-related/query_bloodbag.php",
      type: "POST",
      data:{bloodtype:bloodtype,
            storage:storage,
          volume:volume,
          preservative:preservative}
    }
  });*/
  //dataTable.ajax.reload();
  //$('#tblquery').DataTable().ajax.reload();
  $.ajax({
    url: "query-related/query_bloodbag2.php",
    type: "POST",
    data:{bloodtype:bloodtype,
          storage:storage,
        volume:volume,
        preservative:preservative},
        success:function(data){
          $("#tblquery").html(data);
        }
  });
});
}

/*$("#choose_bloodtype").on("change",function(){
  dataTable.ajax.reload();
});*/

});
