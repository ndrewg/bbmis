<?php
include("../connections.php");
parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
function sanitize($string){
  return filter_var($string,FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}
$bloodTypeid = $params["bloodtype_ID"];
$bloodTypename = $params["editBloodTypeName"];
$bloodTyperhesus = $params["editBloodTypeRhesus"];
$sanitized_bloodtypename = sanitize($bloodTypename);

if($bloodTypeid && $sanitized_bloodtypename && $bloodTyperhesus){

    $viewType = mysqli_query($connections,"SELECT *
                              FROM tblbloodtype
                              WHERE stfBloodType  LIKE '$sanitized_bloodtypename'
                              AND stfBloodTypeRhesus LIKE '$bloodTyperhesus' ");

    if(mysqli_num_rows($viewType) <= 0){//if di nageexist yung blood component

      mysqli_query($connections,"UPDATE tblbloodtype
                                  SET stfBloodType = '$sanitized_bloodtypename', stfBloodTypeRhesus = '$bloodTyperhesus'
                                  WHERE intBloodTypeId = '$bloodTypeid'");
      echo "1";
    }
    elseif (mysqli_num_rows($viewType) > 0) {//if ] nageexist yung blood component
      mysqli_query($connections,"UPDATE tblbloodtype
                                  SET  stfBloodTypeRhesus = '$bloodTyperhesus'
                                  WHERE intBloodTypeId = '$bloodTypeid'");
      echo "2";
    }

}
else {
  echo "3";
}
?>
