<?php
include("../connections.php");

function sanitize($string){
  return filter_var($string,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}
parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$bloodcomponentname = $params["newBloodComponentName"];
$sanitized_bloodcomponentname = sanitize($bloodcomponentname);
$deferral = $params["newBloodComponentDeferral"];
if(!$deferral){
    $deferral = 0;
}
//settype($deferral,"int");
if($sanitized_bloodcomponentname){

    $viewbloodcomponent = mysqli_query($connections,"SELECT *
                              FROM tblbloodcomponent
                              WHERE strBloodComponent  LIKE '%$sanitized_bloodcomponentname%' ");

    if(mysqli_num_rows($viewbloodcomponent) <= 0){//if di nageexist yung blood component

      mysqli_query($connections,"INSERT INTO tblbloodcomponent(strBloodComponent,intDeferralDay) VALUES ('$sanitized_bloodcomponentname','$deferral')");
      echo "1";
    }
    elseif (mysqli_num_rows($viewbloodcomponent) > 0) {//if ] nageexist yung blood component
      echo "2";
    }

}
else {
  echo "3";
}
?>
