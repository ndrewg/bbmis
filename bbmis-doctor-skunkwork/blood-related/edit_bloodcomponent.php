<?php
include("../connections.php");
function sanitize($string){
  return filter_var($string,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}
parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$bloodcomponentid = $params["bloodcomp_ID"];
$bloodcomponentname = $params["editBloodComponentName"];
$sanitized_bloodcomponentname = sanitize($bloodcomponentname);
$deferral = $params["editBloodComponentDeferral"];
  if(!$deferral){
      $deferral = 0;
  }
if($bloodcomponentid && $sanitized_bloodcomponentname){

    $viewbloodcomponent = mysqli_query($connections,"SELECT *
                              FROM tblbloodcomponent
                              WHERE strBloodComponent = '$sanitized_bloodcomponentname'
                              AND intDeferralDay = '$deferral'");

    if(mysqli_num_rows($viewbloodcomponent) <= 0){//if di nageexist yung blood component

      mysqli_query($connections,"UPDATE tblbloodcomponent
                                  SET strBloodComponent = '$sanitized_bloodcomponentname', intDeferralDay = '$deferral'
                                  WHERE intBloodComponentId = '$bloodcomponentid'");
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
