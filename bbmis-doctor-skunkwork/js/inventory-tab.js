$(function(){
  //initialize waves/ripple effect
  Waves.init();
  Waves.attach('button');

  //live search of donors
  $('#blooddonor').keyup(function(){
    // get value of the input field on change
    var inputVal = $(this).val();
    var resultDropdown = $(this).siblings(".result");

    console.log(inputVal);
    if(inputVal.length){
        $.get("blood-related/backend-search.php", {term: inputVal}).done(function(data){
          // Display the returned data in browser
          resultDropdown.html(data);
        });
      } else{
        resultDropdown.empty();
      }
  });
});
