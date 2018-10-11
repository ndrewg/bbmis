$(document).ready(function(){
  editsurvey();
  add_deleterow();
  addrow();
  saveeditedquestion();
  saveeditedsurvey();
var tr_number_add = 0;
var deleted_rows = 0;

function editsurvey(){
 $('#editsurveyitem').on('show.bs.modal', function(e) {
   $("#save_changes").show();
   var rowid = $(e.relatedTarget).data('id');
   alert(rowid);
       var question = $('#question'+rowid).val();
       var type = $('#type'+rowid).val();
       var category = $('#category'+rowid).val();

       $('#question_id').val(rowid);
       $('#editQuestion').val(question);
       $('#editquestiontype').val(type);
       $('#editquestioncategory').val(category);
 });
}
function add_deleterow(){
  $(".add_delete-row").click(function(){
    $("#add_table_questions tbody").find('input[name="record"]').each(function(){
        if($(this).is(":checked")){
          $('#add_submit_item').attr("disabled", false);
            $(this).parents("tr").remove();
        }
    });
  });
}
//------------------------------------------------------------------------------------------------------------------------
function addrow(){
 var rowid;

$('#add_submit_item').click(function() {
  $(this).attr("disabled", true);
 var add_chosenType = $('#add_questiontype option:selected').val();
 var add_chosenCategory = $('#add_questioncategory option:selected').val();
 var add_question = $("#add_question_text").val();
 rowid = parseInt($('#tblsurvey tr:last').attr('id')) + 1;
 console.log(rowid);
 var add_total_row = "<tr><td><input type='checkbox' name='record'></td><td>" + "<input type ='text' id = 'question_add"+rowid+"' "+"value = '"+ add_question +"'>" + "</td><td>" + "<input type ='text' id = 'category_add"+rowid+"' "+"value = '" + add_chosenCategory +"'>" + "</td><td>" + "<input type ='text' id = 'type_add"+rowid+"' "+"value = '" + add_chosenType + "'>" + "</td></tr>";

 console.log(add_total_row);
 $("#add_table_questions tbody").append(add_total_row);
 $("#items input").val("");
});

//function addtoselectedsurvey(){

  $("#add_save").click(function(e){
    var rowCount = $('#add_table_questions tr').length;
    rowid = $('#tblsurvey tr:last').attr('id');
    var counter = parseInt(rowid) + (parseInt(rowCount) - 1);
    console.log(rowCount);
    console.log(rowid);
    console.log(counter);
    for(var i = parseInt(rowid) + 1; i <= counter; i++){
    var new_chosenType = $("#type_add"+i).val();
    var new_chosenCategory = $("#category_add"+i).val();
    var new_question = $("#question_add"+i).val();
    console.log(new_question+new_chosenType+new_chosenCategory);
    console.log(tr_number_add);

    var add_total_row =  "<tr id ='"+i+"'><td><textarea class='form-control' value ='"+new_question+"' name='question"+i+"' id='question"+i+"' readonly>"+new_question+"</textarea></td>"+"<td><input type = 'text' value = '"+new_chosenType+"' name = 'type"+i+"' id='type"+i+"' readonly></td>"+"<td><input type = 'text' value = '"+new_chosenCategory+"' name = 'category"+i+"' id='category"+i+"' readonly></td>"+
            "<td><button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editsurveyitem' data-id='"+i+"'>Edit</button> <button type='button' class='btn btn-danger' data-id='"+i+"'>Delete</button></td></tr>"

   console.log(add_total_row);
         //$("#tblsurvey :last-child").append(add_total_row);
         $("#save_changes").show();
         $('#tblsurvey tr:last').after(add_total_row);
         $('#add_questiontype').val("Select Question Type");
         $('#add_questioncategory').val("Select Question Category");
         $("#add_question_text").val("");

         $("#add_table_questions tbody").find('input[name="record"]').each(function(){
           //  if($(this).is(":checked")){
               $('#add_submit_item').attr("disabled", false);
                 $(this).parents("tr").remove();

           //    }
                });
  }

  });
//}
}
//------------------------------------------------------------------------------------------------------------------------

//---------------------------------------------------------------------



   function saveeditedquestion(){
     $("#btnsaveeditquestion").click(function(e){
       e.preventDefault(e);
       var confirm_input = confirm("Are you sure?");
       var id = $('#question_id').val();
       var question = $('#editQuestion').val();
       var type = $('#editquestiontype').val();
       var category = $('#editquestioncategory').val();
       if (confirm_input == true){
         $('#question'+id).val(question);
         $('#type'+id).val(type);
         $('#category'+id).val(category);
         alert("Changes appended");
       }
       else{
         alert("Confirmation Cancelled");
         return false;
       }
       });
     }

     function saveeditedsurvey(){
       $("#save_changes").click(function(e){
         e.preventDefault;
         var formdata = $("form[name ='survey']").serialize();
         var selected = $('#hiddensurveyversion').val();
         var rowCount = $('#tblsurvey tr').length;
         var confirm_input = confirm("Are you sure?");
         rowCount = rowCount - 1;
         var allrows = rowCount+deleted_rows;
         console.log(formdata);
         console.log(allrows);
         if (confirm_input == true){
         $.ajax({
           url:"edit_question.php",
           type:"POST",
           data:{formdata:formdata,
                 selected:selected,
                 allrows:allrows},
           dataType: "json",
           success:function(data){
             //console.log(data);
             alert("Changes had been saved the survey is named :"+data.intQuestionVersion);
            // console.log(data.intQuestionVersion);
             window.location.href = ".././survey-tab.php";
           },
           error: function(xhr, status, error) {
            var err = JSON.parse(xhr.responseText);
            alert(err.Message);
          }
         });
       }
       else{
         alert("Confirmation Cancelled");
         return false;
       }
       });
     }

     $('#tblsurvey tbody').on('click','.btn-danger',function(){
       var confirm_delete = confirm("Are you sure you want to delete?");

       if(confirm_delete == true){
        $("#save_changes").show();
       $(this).closest('tr').remove();
       deleted_rows = deleted_rows + 1;
       console.log(deleted_rows);
     }
     else{
       alert("Confirmation Cancelled");
       return false;
     }
     });

     $('#setasactive').click(function(){
       var survey = $("#hiddensurveyversion").val();
       var confirm_changes = confirm("Are you sure you want to change the survey to "+survey+"?");
       console.log("hi");
       if(confirm_changes == true){
       $.ajax({
         url:"change_activesurvey.php",
         type:"POST",
         data:{survey:survey},
         success:function(data){
           console.log(data);
           alert("The survey in use is "+data);
           window.location.href = ".././survey-tab.php";
         }

     });
      }else{
        alert("Confirmation Cancelled");
        return false;
      }

      });

});
