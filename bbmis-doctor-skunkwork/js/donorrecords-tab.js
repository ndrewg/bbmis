$(document).ready(function(){

  //function declaration
  // showdonors();
  editdonorinfo();
  savedonorinfo();
  savephysicalexam();
  saveinitialscreening();
  saveserologicalscreening();
  change_storage();

  //initialize ripple effect
  Waves.init();
  Waves.attach('button');

  //check the exam remark selected
  $("#examremarks").change(function() {
    var chosenType = (this).value;

    if(chosenType == 'Temporarily Deferred'){
      $("#reason").show();
      $("#amount").hide();
      $("#bloodamount").val("N/A");
      $("#reasonfordeferal").prop('required',true);
      $("#instruction").prop('required',true);
      $("#bloodamount").prop('required',false);
    }
    else if (chosenType == 'Permanently Deferred') {
      $("#reason").show();
      $("#amount").hide();
      $("#bloodamount").val("N/A");
      $("#reasonfordeferal").prop('required',true);
      $("#instruction").prop('required',true);
      $("#bloodamount").prop('required',false);
    }
    else if (chosenType == 'Accepted'){
      $("#amount").show();
      $("#bloodamount").prop('required',true);
      $("#reason").hide();
      $("#reasonfordeferal").val("");
      $("#reasonfordeferal").prop('required',false);
      $("#instruction").val("");
      $("#instruction").prop('required',false);
    }
  });

  // function showdonors(){
  //   var action = "fetch";
  //   $.ajax({
  //     url:"people-related/show_donorrecords.php",
  //     method:"POST",
  //     data:{action:action},
  //     success:function(data){
  //       $('#donortable').html(data);
  //     },
  //     complete: function() {
  //       // Schedule the next request when the current one's complete
  //       setTimeout(showdonors, 5000);
  //     }
  //   });
  // }

  $('#tbl_donorrecords').on("click", ".btnAddphysical", function(){
    var clientid = $(this).attr("data-id");
    console.log(clientid);
    $('#clientId_phys').val(clientid);

    $.ajax({
      type: "POST",
      url: 'people-related/fetch_newdonorinfo.php',
      data: 'clientid=' + clientid,
      dataType: "json",
      success:function(data){
        $('#cname').text(data.strClientFirstName);
        $('#cname').append(" ");
        $('#cname').append(data.strClientMiddleName);
        $('#cname').append(" ");
        $('#cname').append(data.strClientLastName);
        $('#cbday').text(data.datClientBirthday);
        $('#csex').text(data.stfClientSex);
        $('#ccontact').text(data.strClientContact);
        $('#ccivstat').text(data.stfClientCivilStatus);
        $('#coccupation').text(data.strClientOccupation);
        $('#div_donorrecords').hide(600);
        // $('#divsearchdonor').hide(600);
        $('#div_donorinfo').show(600);
        $('#div_donoraddphysical').show(600);
        $('#clientId_phys').val(clientid);
        $('#clientId_init').val(clientid);
        $('#clientId_sero').val(clientid);
      }
    });
  });

  $('#tbl_donorrecords').on("click", ".btnAddinitial", function(){
    var clientid = $(this).attr("data-id");
    console.log(clientid);
    $('#clientId_init').val(clientid);

    $.ajax({
      type: "POST",
      url: 'people-related/fetch_newdonorinfo.php',
      data: 'clientid=' + clientid,
      dataType: "json",
      success: function(data){
        $('#cname').text(data.strClientFirstName);
        $('#cname').append(" ");
        $('#cname').append(data.strClientMiddleName);
        $('#cname').append(" ");
        $('#cname').append(data.strClientLastName);
        $('#cbday').text(data.datClientBirthday);
        $('#csex').text(data.stfClientSex);
        $('#ccontact').text(data.strClientContact);
        $('#ccivstat').text(data.stfClientCivilStatus);
        $('#coccupation').text(data.strClientOccupation);
        $('#div_donorrecords').hide(600);
        // $('#divsearchdonor').hide(600);
        $('#div_donorinfo').show(600);
        $('#div_donoraddinitial').show(600);
      }
    })
  });

  $('#tbl_donorrecords').on("click", ".btnAddserological", function(){
    var clientid = $(this).attr("data-id");
    console.log(clientid);
    $('#clientId_sero').val(clientid);

    $.ajax({//kung magpoproceed sa sero kunin mo yung nakaquarantine na bloodbag
      type: "POST",
      url: 'blood-related/fetch_underquarantinebloodbag.php',
      data: {clientid,clientid},
      success:function(data){
        $('#bloodbag_underquarantine').val(data);
        $('#bloodbag_underquarantine2').val(data);
      }
    });

    $.ajax({
      type: "POST",
      url: 'people-related/fetch_newdonorinfo.php',
      data: 'clientid=' + clientid,
      dataType: "json",
      success:function(data){
        $('#cname').text(data.strClientFirstName);
        $('#cname').append(" ");
        $('#cname').append(data.strClientMiddleName);
        $('#cname').append(" ");
        $('#cname').append(data.strClientLastName);
        $('#cbday').text(data.datClientBirthday);
        $('#csex').text(data.stfClientSex);
        $('#ccontact').text(data.strClientContact);
        $('#ccivstat').text(data.stfClientCivilStatus);
        $('#coccupation').text(data.strClientOccupation);
        $('#div_donorrecords').hide(600);
        // $('#divsearchdonor').hide(600);
        $('#div_donorinfo').show(600);
        $('#div_donoraddserological').show(600);
      }
    });
  });

  function editdonorinfo(){
    $('#editdonorinfo').on('show.bs.modal', function(e) {

      var rowid = $(e.relatedTarget).data('id');
      //alert(rowid);
      $.ajax({
        type: "POST",
        url: 'people-related/fetch_donorinfo.php',
        data: 'rowid=' + rowid,
        dataType: "json",
        success: function(data){
          $('#clientId').val(data.intClientId);
          $('#clientfname').val(data.strClientFirstName);
          $('#clientminit').val(data.strClientMiddleName);
          $('#clientlname').val(data.strClientLastName);
          $('#clientcontact').val(data.strClientContact);
          $('#clientsex').val(data.stfClientSex);
          $('#clientbloodtype').val(data.intBloodTypeId);
          $('#clientcivstat').val(data.stfClientCivilStatus);
          $('#clientbday').val(data.datClientBirthday);
          $('#clientocc').val(data.strClientOccupation);
          /*var btype = $('#clientbloodtype').val();
          console.log(btype);*/
        }
      });
    });
  }

  function savedonorinfo(){
    $("form[name = 'editdonor' ]").submit(function(e){
      e.preventDefault();
      var clientocc = $("#clientocc").val();
      var clientcontact = $("#clientcontact").val();
      var clientcivstat = $("#clientcivstat").val();
      var confirm_input = confirm("Are you sure?");
      var formdata = $(this).serialize();
      console.log(formdata);
      if(clientcontact.length == 11)
      {
        if(confirm_input == true)
        {
          $.ajax({
            url: "people-related/edit_donorrecord2.php",
            method: "POST",
            data: {formdata : formdata},
            success:function(data){
              console.log(data);
              if (data == '1')
              {
                alert("Edit Successful");
                $('#editdonorinfo').modal('hide');
                $("#editdonorinfo .modal-body input").val("");
              }
              else if(data == '2')
              {
                alert("Edit Unsuccessful");
              }
            }
          });
        }
      }else{
        alert("Invalid Contact");
      }
    });
  }

  function savephysicalexam(){
    $("form[name='adddonorphysrecord']").on('submit',function(e){
      e.preventDefault();
      var status =$("#donorstatus option:selected").text();
      var confirm_input = confirm("Are you sure? Once you hit OK you cannot change your inputs");

      if(confirm_input == true){

        e.preventDefault();
        var formdata = $("form[name='adddonorphysrecord']").serialize();
        console.log(formdata);
        $.ajax({
          type: "POST",
          url: 'people-related/save_donorphysicalexam.php',
          data: {formdata,formdata},
          success:function(data){
            console.log(data);
            if (data == '1')
            {
              alert("Insert Successful");
              $('#div_donoraddphysical').hide(600);
              $('#div_donoraddinitial').show(600);
            }
            else if(data == '2')
            {
              alert("Insert Successful, You will not proceed to Initial Screening because the donor failed in Physical Exam");
              $("#donorphysrecord_save").hide();
              $("#btnclearphys").hide();
            }
            else if (data == '3') {
              alert("Insert Unsuccessful");
            }
            else if(data == '42'){
              alert("Insert Succesful, Donor will not be allowed to donate again");
              $('#donorphysrecord_save').hide(600);

            }
            else if(data == '5'){
              alert("Insert unsuccesful, The date must not be greater than today's date");


            }
          }
        });
      }//confirm
      else{
        alert("Confirmation Cancelled");
        return false;
      }

    });
  }

  function saveinitialscreening(){
    $("form[name='adddonorinitexam']").on('submit',function(e){
      e.preventDefault();
      var confirm_input = confirm("Are you sure? Once you hit OK you cannot change your inputs");
      var donor_id = $('#clientId_init').val();
      var formdata = $("form[name='adddonorinitexam']").serialize();
      console.log(formdata);
      if (confirm_input == true){

        $.ajax({
          type: "POST",
          url: 'people-related/save_donorinitialexam.php',
          data: {formdata,formdata},
          success:function(data){
            console.log(data);
            if(data == '1'){
              alert("Insert Successful");
              $('#div_donoraddinitial').hide(600);
              $('#div_donoraddserological').show(600);

              $.ajax({//kung magpoproceed sa sero kunin mo yung nakaquarantine na bloodbag
                type: "POST",
                url: 'fetch_underquarantinebloodbag.php',
                data: {donor_id,donor_id},
                success:function(data){
                  $('#bloodbag_underquarantine').val(data);
                }
              });

            }
            else if(data == '2'){
              alert("Insert Successful, You will not proceed to Serological Screening because the donor failed in Initial Screening Exam");
              $('#donorinitrecord_save').hide();
            }
            else if(data == '3'){
              alert("Insert Unsuccessful");
            }
            else if(data == '4'){
              alert("Insert Unsuccessful,The date must not be greater than today's date");
            }

          }
        });
      }//if true
      else{
        alert("Confirmation Cancelled");
        return false;
      }
    });
  }

  function change_storage(){
    $("form[name='change_storageForm']").on('submit',function(e){
        e.preventDefault();
        var confirm_input = confirm("Are you sure?");
        var formdata = $("form[name='change_storageForm']").serialize();

          if (confirm_input == true){
            console.log(formdata);
            $.ajax({
              type:"POST",
              url:"blood-related/update_storage.php",
              data:{formdata,formdata},
              success:function(data){
                console.log(data);
                if(data == 1){
                $('#chooseStorageModal').modal('hide');
                window.location.href = "donorrecords-tab.php";
              }
              else{
                alert("We've encountered an error"+' '+data);
              }
              }
            });
          }else{
            alert("Confirmation Cancelled");
            return false;
          }
    });
  }

  function saveserologicalscreening(){
    $("form[name='adddonorseroexam']").on('submit',function(e){
      e.preventDefault();
      var confirm_input = confirm("Are you sure? Once you hit OK you cannot change your inputs");
      var formdata = $("form[name='adddonorseroexam']").serialize();

      if (confirm_input == true){
        console.log(formdata);
        $.ajax({
          type: "POST",
          url: 'people-related/save_donorserologicalexam.php',
          data: {formdata,formdata},
          success:function(data){
            console.log(data);
            if(data == 1){
              console.log(data);
              alert("Insert Unsuccessful");
            /*  $('#div_donoraddserological').hide(600);
              $('#donorinitrecord_save').hide();*/
              //$('#donortable').show();
              //$('#divdonoraddsero').show(600);
            }
            else if(data == 2){
              alert("Insert Unsuccessful, No Blood Bag Record");
            }
            else if(data == 3){
              alert("Insert Succesful, Donor will not be allowed to donate again");
              $('#div_donoraddserological').hide(600);
              $('#donorinitrecord_save').hide();
            }
            else if(data == 4){
              alert("Insert Successful, Choose a storage");
              $('#chooseStorageModal').modal('show');
            }
            else if(data == 5){
              alert("Insert Unsuccessful,The date must not be greater than today's date");
            }

          }
        });
      }//if true
      else{
        alert("Confirmation Cancelled");
        return false;
      }
    });
  }
});
