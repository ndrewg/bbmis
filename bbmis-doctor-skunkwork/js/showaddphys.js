$(function(){
  $('.btnaddphys').click(function(e){
    var rowid = $(this).attr("data-id");

    $.ajax({
      type: "POST",
      url: 'people-related/fetch_newdonorinfo.php',
      data: 'rowid=' + rowid,
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
        $('#donortable').hide(600);
        // $('#divsearchdonor').hide(600);
        $('#div_donorinfo').show(600);
        $('#div_donoraddphysical').show(600);
        $('#clientId_phys').val(rowid);
        $('#clientId_init').val(rowid);
        $('#clientId_sero').val(rowid);
      }
    });
  });

  // $('.btn_viewrec').on("click",function(){
  //   var clientid = $(this).attr("data-id");
  //   alert(clientid);
  //
  //   $.ajax({
  //     type: "POST",
  //     url: "donor-related/fetchdivdonorinfo.php",
  //     data: {clientid:clientid},
  //     dataType: "JSON",
  //     success: function(data) {
  //       console.log(data);
  //       $('#client_fullname').text(data.strClientFirstName);
  //       $('#client_fullname').append(" ");
  //       $('#client_fullname').append(data.strClientMiddleName);
  //       $('#client_fullname').append(" ");
  //       $('#client_fullname').append(data.strClientLastName);
  //       $('#client_sex').text(data.stfClientSex);
  //       $('#client_contact').text(data.strClientContact);
  //       $('#client_bloodtype').text(data.stfBloodType);
  //       $('#client_bloodtype').append(" ");
  //       $('#client_bloodtype').append(data.stfBloodTypeRhesus);
  //       $('#div_viewdonor').show(500);
  //       $('#donortable').hide(500);
  //       $('#divsearchdonor').hide(500);
  //     }
  //   });
  //
  // });

});
