<?php
include("../connections.php");

parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$id = $params['clientId'];
settype($id,'int');
$occupation = $params['clientocc'];
$contact = $params['clientcontact'];
$civilstat = $params['clientcivstat'];
$blood_type = $params['clientbloodtype'];

if($occupation && $contact && $civilstat && $blood_type)
{
  mysqli_query($connections,"UPDATE tblclient
                            SET strClientContact = '$contact', strClientOccupation = '$occupation', stfClientCivilStatus = '$civilstat', intBloodTypeId = '$blood_type'
                            WHERE intClientId = $id");
  echo 1;
  //echo $id.$occupation.$contact.$civilstat.$blood_type;
}
else{
  echo 2;
}
?>
