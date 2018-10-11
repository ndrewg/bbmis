$(function(){
  $('.btnaddinit').click(function(e){
    var rowid = $(this).attr("data-id");
    console.log("hi");
    $('#clientId_init').val(rowid);
    //var donor_id = $('#clientId_init').val();
    alert(rowid);

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
        $('#div_donoraddinitial').show(600);
      }
    });
  });
});
