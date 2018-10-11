$(document).ready(function(){

ajax_showsurvey();
    function ajax_showsurvey() {
      $.ajax({
        url: 'fetchIntSheetQuestions.php',
        success: function(data) {
          $("#surveycontainer").html(data);
        }
      });
    }
});