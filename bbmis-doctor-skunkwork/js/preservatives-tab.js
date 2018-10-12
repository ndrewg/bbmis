$(document).ready(function(){
  //initialize datatables
  fetch_activepreservative();
  fetch_inactivepreservative();
  savenewpreservative();
  saveeditedpreservative();

$("#newpreservativeFresh").on('change',function(){
  console.log("hi");
  var lifespan = parseInt($("#newpreservativeLifespan").val());
  var fresh = parseInt($("#newpreservativeFresh").val());
  var neutral = parseInt($("#newpreservativeMedium").val());
  var critical = parseInt($("#newpreservativeCritical").val());

  if (lifespan > fresh){

  }else{
    alert("Lifespan should have the biggest value");
  }
/*  if(neutral < fresh){
    alert("Neutral level must be greater than fresh level");
  }else if(critical < fresh){
    alert("Critical level must be greater than fresh level and neutral level");
  }*/

});

$("#newpreservativeMedium").on('change',function(){
  console.log("hi");
  var lifespan = parseInt($("#newpreservativeLifespan").val());
  var fresh = parseInt($("#newpreservativeFresh").val());
  var neutral = parseInt($("#newpreservativeMedium").val());
  var critical = parseInt($("#newpreservativeCritical").val());

  if (lifespan > neutral){
    if(neutral < fresh){
      alert("Neutral level must be greater than fresh level");
    }
  }else{
    alert("Lifespan should have the biggest value");
  }

});

$("#newpreservativeCritical").on('change',function(){
  var lifespan = parseInt($("#newpreservativeLifespan").val());
  var fresh = parseInt($("#newpreservativeFresh").val());
  var neutral = parseInt($("#newpreservativeMedium").val());
  var critical = parseInt($("#newpreservativeCritical").val());


  if (lifespan > critical){
    if(critical < neutral || neutral < fresh){
      alert("Neutral level must be greater than fresh level , Critical level must be greater than neutral level");
  }
  }else{
    alert("Lifespan should have the biggest value");
  }


});
//----------------------------------------------------------------------------------------------------------------------------
$("#editpreservativeFresh").on('change',function(){
  var lifespan = parseInt($("#editpreservativeLifespan").val());
  var fresh = parseInt($("#editpreservativeFresh").val());
  var neutral = parseInt($("#editpreservativeMedium").val());
  var critical = parseInt($("#editpreservativeCritical").val());

  if (lifespan > fresh){

  }else{
    alert("Lifespan should have the biggest value");
  }
/*  if(neutral < fresh){
    alert("Neutral level must be greater than fresh level");
  }else if(critical < fresh){
    alert("Critical level must be greater than fresh level and neutral level");
  }*/

});

$("#editpreservativeMedium").on('change',function(){
  var lifespan = parseInt($("#editpreservativeLifespan").val());
  var fresh = parseInt($("#editpreservativeFresh").val());
  var neutral = parseInt($("#editpreservativeMedium").val());
  var critical = parseInt($("#editpreservativeCritical").val());


  if (lifespan > neutral){
    if(neutral < fresh){
      alert("Neutral level must be greater than fresh level");
    }
  }else{
    alert("Lifespan should have the biggest value");
  }

});

$("#editpreservativeCritical").on('change',function(){
  var lifespan = parseInt($("#editpreservativeLifespan").val());
  var fresh = parseInt($("#editpreservativeFresh").val());
  var neutral = parseInt($("#editpreservativeMedium").val());
  var critical = parseInt($("#editpreservativeCritical").val());


  if (lifespan > critical){
    if(critical < neutral || neutral < fresh){
      alert("Neutral level must be greater than fresh level , Critical level must be greater than neutral level");
    }
  }else{
    alert("Lifespan should have the biggest value");
  }

});

  function fetch_activepreservative(){
    //initialize active blood component table
    var dataTable = $('#tbl_activepreservative').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url : "blood-related/fetch_activepreservative.php",
        type: "POST"
      },
      "language" : {
        "emptyTable" : "No active preservative to show"
      }
    });
  }
  //initialize inactive blood component table
  function fetch_inactivepreservative(){
    var dataTable = $('#tbl_inactivepreservative').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url: "blood-related/fetch_inactivepreservative.php",
        type: "POST"
      },
      "language" : {
        "emptyTable" : "No inactive preservative to show"
      }
    });
  }

  function savenewpreservative(){
    $("form[name='form_addnewpreservative']").on('submit',function(e){
      e.preventDefault();
      // var confirm_input = confirm("Are you sure?");
      var fresh = $("#newpreservativeFresh").val();
      var neutral = $("#newpreservativeMedium").val();
      var critical = $("#newpreservativeCritical").val();
      var formdata = $("form[name='form_addnewpreservative']").serialize();

      swal({
        title: "Are you sure?",
        text: "You are about to add a preservative",
        icon: "info",
        buttons: true,
      })
      .then((willApprove) => {
        if (willApprove){
          $.ajax({
            type: "POST",
            url: 'blood-related/add_newpreservative.php',
            data: {formdata,formdata},
            success:function(data){
              console.log(data);
              if(data == 1){
                // alert("Blood Component Added");

                swal({
                  title: "",
                  text: "Preservative Added",
                  icon: "success",
                  buttons: {text:"Close"},
                })
                .then((willApprove) => {
                  if (willApprove) {
                    $('#addpreservativeModal').modal('hide');
                    $("#addpreservativeModal .modal-body input").val("");
                    window.location.href = "preservatives-tab.php";
                  }
                });
                // $('#addpreservativeModal').modal('hide');
                // $("#addpreservativeModal .modal-body input").val("");
                // window.location.href = "preservative-tab.php";
                //$('#divdonoraddsero').show(600);
              }
              else if(data == 2){
                // swal("","The Blood Component You Entered Already Exists","info");
                swal({
                  title: "",
                  text: "The preservative you're trying to add already exists",
                  icon: "warning",
                  buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if(willApprove) {
                    //window.location.href = "preservatives-tab.php";
                  }
                });
              }
              else if (data == 3) {
                // swal("","Blood Component is not saved","info");
                swal({
                  title:"",
                  text:"Preservative is not saved!",
                  icon:"error",
                  buttons:{text:"OKAY"},
                })
                .then((willApprove) => {
                  if (willApprove) {
                    window.location.href = "preservatives-tab.php";
                  }
                });
              }
              else if(data == 4){
                // swal("","The Blood Component You Entered Already Exists","info");
                swal({
                  title: "",
                  text: "The days are not correct",
                  icon: "warning",
                  buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if(willApprove) {
                    //window.location.href = "preservatives-tab.php";
                  }
                });
              }
              else if(data == 5){
                // swal("","The Blood Component You Entered Already Exists","info");
                swal({
                  title: "",
                  text: "The days are not correct, there should be no day greater than lifespan",
                  icon: "warning",
                  buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if(willApprove) {
                    //window.location.href = "preservatives-tab.php";
                  }
                });
              }
            }
          });
        }
        else {
          swal("","Cancelled","info");
        }
      });
    });
  }

  $("#btnsavedeletepreservative").click(function(e){
    e.preventDefault();
    var id = $("#viewpreservative_ID").val();
    // var confirm_delete = confirm("Are you sure?");
    swal({
      title: "Are you sure?",
      text: "You are about to disable this preservative",
      icon: "info",
      buttons: true,
    })
    .then((willApprove) => {
      if (willApprove) {
        $.ajax({
          type: "POST",
          url: 'blood-related/delete_preservative.php',
          data: {id:id},
          success:function(data){
            // alert("Blood Component has been disabled");
            if(data == "deleted"){
            swal({
              title: "",
              text: "The preservative is now disabled",
              icon: "success",
              buttons: {text:"Okay"},
            })
            .then((willApprove) => {
              if (willApprove) {
                window.location.href = "preservatives-tab.php";
              }
            });
          }else{
            swal({
              title: "",
              text: "The preservative is not disabled because "+data+" record/s uses this.",
              icon: "error",
              buttons: {text:"Okay"},
            })
            .then((willApprove) => {
              if (willApprove) {
                window.location.href = "preservatives-tab.php";
              }
            });
          }
          }
        });
      }
      else {
        swal("","Cancelled","info");
      }
    });
});

$("#btnsaveenablepreservative").click(function(e){
  e.preventDefault();
  var id = $("#viewpreservative_ID_enable").val();
  // var confirm_enable = confirm("Are you sure?");
  swal({
    title: "Are you sure",
    text: "You are about to enable this preservative",
    icon: "info",
    buttons: true,
  })
  .then((willApprove) =>{
    if (willApprove) {
      $.ajax({
        type: "POST",
        url: 'blood-related/enable_preservative.php',
        data: {id:id},
        success:function(data){
          // alert("Blood Component has been enabled");
          swal({
            title: "",
            text: "Preservative is now enabled!",
            icons: "success",
            buttons:{text:"Okay"},
          })
          .then((willApprove) => {
            if (willApprove) {
              window.location.href = "preservatives-tab.php";
            }
          });
        }
      });
    }
    else {
      swal("","Cancelled","info");
    }
  });
});

  function saveeditedpreservative(){
    $("form[name='form_editpreservative']").on('submit',function(e){
      e.preventDefault();
      // var confirm_input = confirm("Are you sure?");

      var formdata = $("form[name='form_editpreservative']").serialize();
      swal({
        title: "Are you sure?",
        text: "You are about to edit this preservative",
        icon: "warning",
        buttons: true,
      })
      .then((willApprove) => {
        if (willApprove) {
          $.ajax({
            type: "POST",
            url: 'blood-related/edit_preservative.php',
            data: {formdata,formdata},
            success:function(data){
              console.log(data);
              if(data == 1){
                swal({
                  title: "",
                  text: "Preservative Successfully edited",
                  icon: "success",
                  buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  $('#editpreservativeModal').modal('hide');
                  $("#editpreservativeModal .modal-body input").val("");
                  window.location.href = "preservatives-tab.php";
                });
                // alert("Blood Component Succesfully Edited");
                //$('#divdonoraddsero').show(600);
              }
              else if(data == 2){
                swal({
                  title: "",
                  text: "The Preservative you entered already exists, please check the inactive preservatives too.",
                  icon: "error",
                  buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if (willApprove) {
                  //  window.location.href = "preservatives-tab.php";
                  }
                });
                // alert("The Blood Component You Entered Already Exists");
              }
              else if (data == 3) {
                swal({
                  title: "",
                  text: "Preservative is not edited",
                  icon: "error",
                  buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if (willApprove) {
                    window.location.href = "preservatives-tab.php";
                  }
                });
                // alert("Blood Component is not Edited");

              }
              else if(data == 4){
                // swal("","The Blood Component You Entered Already Exists","info");
                swal({
                  title: "",
                  text: "The days are not correct",
                  icon: "warning",
                  buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if(willApprove) {
                    //window.location.href = "preservatives-tab.php";
                  }
                });
              }
              else if(data == 5){
                // swal("","The Blood Component You Entered Already Exists","info");
                swal({
                  title: "",
                  text: "The days are not correct, there should be no day greater than lifespan",
                  icon: "warning",
                  buttons:{text:"Okay"},
                })
                .then((willApprove) => {
                  if(willApprove) {
                    //window.location.href = "preservatives-tab.php";
                  }
                });
              }
            }
          });
        }
        else {
          swal("","Cancelled","info");
        }
      });
    });
  }

  $('#editpreservativeModal').on('show.bs.modal', function(e) {

    var rowid = $(e.relatedTarget).data('id');
    var txt = $(e.relatedTarget).data('prename');
    var span = $(e.relatedTarget).data('span');
    var fresh = $(e.relatedTarget).data('fresh');
    var neutral = $(e.relatedTarget).data('neutral');
    var critical = $(e.relatedTarget).data('critical');
    //alert(txt);
    $("#preservative_ID").val(rowid);
    $("#editpreservativeName").val(txt);
    $("#editpreservativeLifespan").val(span);
    $("#editpreservativeFresh").val(fresh);
    $("#editpreservativeMedium").val(neutral);
    $("#editpreservativeCritical").val(critical);
  });

  $('#viewpreservativeModal').on('show.bs.modal', function(e) {

    var rowid = $(e.relatedTarget).data('id');
    var txt = $(e.relatedTarget).data('prename');
    var span = $(e.relatedTarget).data('span');
    var fresh = $(e.relatedTarget).data('fresh');
    var neutral = $(e.relatedTarget).data('neutral');
    var critical = $(e.relatedTarget).data('critical');
    //alert(txt);
    $("#viewpreservative_ID").val(rowid);
    $("#viewpreservativeName").val(txt);
    $("#viewpreservativeLifespan").val(span);
    $("#viewpreservativeFresh").val(fresh);
    $("#viewpreservativeMedium").val(neutral);
    $("#viewpreservativeCritical").val(critical);
  });

  $('#viewpreservativeModal_enable').on('show.bs.modal', function(e) {

    var rowid = $(e.relatedTarget).data('id');
    var txt = $(e.relatedTarget).data('prename');
    var span = $(e.relatedTarget).data('span');
    var fresh = $(e.relatedTarget).data('fresh');
    var neutral = $(e.relatedTarget).data('neutral');
    var critical = $(e.relatedTarget).data('critical');
    //alert(txt);
    $("#viewpreservative_ID_enable").val(rowid);
    $("#viewpreservativeName_enable").val(txt);
    $("#viewpreservativeLifespan_enable").val(span);
    $("#viewpreservativeFresh_enable").val(fresh);
    $("#viewpreservativeMedium_enable").val(neutral);
    $("#viewpreservativeCritical_enable").val(critical);
  });

});
