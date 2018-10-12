$(document).ready(function(){
  fetch_staff();
  editstaffinfo();
  //ajax_edit();
  function fetch_staff(){
    var dataTable = $('#tbl_staff').DataTable({
      "processing" : true,
      "serverSide" : true,
      "ajax" : {
        url: "people-related/fetch_staff.php",
        type: "POST"
      }
    });
  }

  function editstaffinfo(){
    $('#editstaffinfo').on('show.bs.modal', function(e) {

      var rowid = $(e.relatedTarget).data('id');
      var fname = $(e.relatedTarget).data('fname');
      var mname = $(e.relatedTarget).data('mname');
      var lname = $(e.relatedTarget).data('lname');
      var status = $(e.relatedTarget).data('status');
      var type = $(e.relatedTarget).data('type');
      var uname = $(e.relatedTarget).data('uname');
      var pass = $(e.relatedTarget).data('pass');
      //alert(rowid+fname+status);
      $("#hidden_id").val(rowid);
      $("#edit_lblFirstName").val(fname);
      $("#edit_lblMiddleName").val(mname);
      $("#edit_lblLastName").val(lname);
      $("#edit_optPos").val(type);
      $("#edit_optstat").val(status);
      $("#view_username").val(uname);
      $("#view_password").val(pass);
    });
  }

/*  function ajax_edit(){
    $("form[name='editemployee']").on('submit',function(e){
      e.preventDefault();
      var formdata = $("form[name='editemployee']").serialize();
      $.ajax({
        url:"valEmployeeEdit.php",
        type:"POST",
        data:{formdata:formdata},
        success:function(data){
          console.log(data);
          if(data == 1){
            alert('Edit Succesful');
          window.location.href = 'staff-tab.php';
        }else{
          alert('Incomplete data');
          window.location.href = 'staff-tab.php';
        }
        }
      });

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

$("#edit_image").change(function() {
readURL2(this);
});
});
