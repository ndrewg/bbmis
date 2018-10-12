$(document).ready(function(){
  fetch_donor();
  //savedonorinfo();
  editdonorinfo();
  fetch_banneddonor();
  function fetch_donor(){
    var dataTable = $('#tbl_donor').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url: "people-related/fetch_donor.php",
        type: "POST"
      }
    });
  }

  function fetch_banneddonor(){
    var dataTable = $('#tbl_banneddonor').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url: "people-related/fetch_banneddonor.php",
        type: "POST"
      }
    });
  }

  function editdonorinfo(){
    $('#editdonorinfo').on('show.bs.modal', function(e) {

      var rowid = $(e.relatedTarget).data('id');
      var fname = $(e.relatedTarget).data('fname');
      var mname = $(e.relatedTarget).data('mname');
      var lname = $(e.relatedTarget).data('lname');
      var occ = $(e.relatedTarget).data('occ');
      var contact = $(e.relatedTarget).data('contact');
      var sex = $(e.relatedTarget).data('sex');
      var btype = $(e.relatedTarget).data('btype');
      var status = $(e.relatedTarget).data('status');
      var age = $(e.relatedTarget).data('age');
    //  alert(btype);
      $("#clientId").val(rowid);
      $("#clientfname").val(fname);
      $("#clientminit").val(mname);
      $("#clientlname").val(lname);
      $("#clientocc").val(occ);
      $("#clientcontact").val(contact);
      $("#clientsex").val(sex);
      $("#clientbloodtype").val(btype);
      $("#clientcivstat").val(status);
      $("#clientbday").val(age);
      var bbtype = $('#clientbloodtype').val();
      console.log(bbtype);
    });
  }

/*  function savedonorinfo(){
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
            url: "people-related/edit_donorrecord.php",
            method: "POST",
            data: {formdata : formdata},
            success:function(data){
              console.log(data);
              if (data == '1')
              {
                alert("Edit Successful");
                $('#editdonorinfo').modal('hide');
                $("#editdonorinfo .modal-body input").val("");
                window.location.href = "donor-tab.php";
              }
              else if(data == '2')
              {
                alert("Edit Unsuccessful");
                window.location.href = "donor-tab.php";
              }
            }
          });
        }
      }else{
        alert("Invalid Contact");
      }
    });
  }*/
/*  $image_crop = $('#image_demo').croppie({
    enableExif:true,
    viewport:{
      width:200,
      height:200,
      type:'square'
    },
    boundary:{
      width:300,
      height:300
    }
  });*/

  /*$('#fileimg').on('change',function(){
    console.log("hi");
    var reader = new FileReader();
    reader.onload = function(event){
      $image_crop.croppie('bind',{
        url:event.target.result
      }).then(function(){
        console.log('Jquery binf complete');
      });
      reader.readAsDataURL(this.files[0]);
      $('#uploadedimageModal').modal('show');
    }
  });*/

  function readURL(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $('#imageprev').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

$("#fileimg").change(function() {
  readURL(this);
});

function readURL2(input) {

if (input.files && input.files[0]) {
  var reader = new FileReader();

  reader.onload = function(e) {
    $('#imageprev2').attr('src', e.target.result);
  }

  reader.readAsDataURL(input.files[0]);
}
}

$("#clientimage").change(function() {
readURL2(this);
});
});
