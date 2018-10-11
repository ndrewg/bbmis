<?php
include("../connections.php");

if($_POST['rowid']){
  $requestid = $_POST['rowid'];
  settype($requestid,'int');

$viewrecord = mysqli_query($connections,"SELECT CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ', strClientLastName) AS Fullname, intClientReqId, c.intClientId, intEmployeeId, stfRequestStatus, stfRequestFeedback, txtChanges, dtmDateRequested, dtmDateAccepted, dtmDateUpdated FROM tblrequest r JOIN tblclient c ON r.intClientId = c.intClientId WHERE intClientReqId = $requestid");

$row = mysqli_fetch_assoc($viewrecord);

echo json_encode($row);

}
?>
