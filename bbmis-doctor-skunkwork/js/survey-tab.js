
$(document).ready(function(){
  deleterow();
  savesurvey();

  var tr_number = 1;

//-----------------------------------------------------------------------------------
  $('#submit_item').click(function() {
    var chosenType = $('#questiontype option:selected').val();
    var chosenCategory = $('#questioncategory option:selected').val();
    var question = $("#question_text").val();

    var total_row = "<tr><td><input type='checkbox' name='record'></td><td>" + "<textarea class = 'form-control' name = 'question"+tr_number+"' "+"value = '"+ question +"'>" +question+ "</textarea></td><td>" + "<input type ='text' name = 'category"+tr_number+"' "+"value = '" + chosenCategory +"' readonly>" + "</td><td>" + "<input type ='text' name = 'type"+tr_number+"' "+"value = '" + chosenType + "' readonly>" + "</td></tr>";

    console.log(total_row+question);
    $("table tbody").append(total_row);

    $("#acceptableValue input").val("");
    $("#items input").val("");
    tr_number = tr_number + 1 ;
  });

  function deleterow(){
    $(".delete-row").click(function(){
      $("table tbody").find('input[name="record"]').each(function(){
          if($(this).is(":checked")){
              $(this).parents("tr").remove();
          }
      });
    });
  }

function savesurvey(){
    $("#save").click(function(e){
      e.preventDefault();
      var formdata = $("form[name ='save_questions']").serialize();
      var rowCount = $('#table_questions tr').length;
      var confirm_input = confirm("Are you sure?");
      console.log(formdata);
      console.log(rowCount);
      if(confirm_input == true){
      $.ajax({
        type: "POST",
        url: 'survey-related/save_survey.php',
        data: {formdata:formdata,
                rowCount:rowCount},
        dataType: "json",
        success:function(data){
          console.log(data);
          alert("You have just created a new survey. Version :"+data.decQuestionVersion);
           window.location.href = "survey-tab.php";
        }
      });
    }
    else{
      alert("Confirmation Cancelled");
      return false;
    }

    });
  }



});
