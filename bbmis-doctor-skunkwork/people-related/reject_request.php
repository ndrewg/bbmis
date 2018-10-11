<?php
include("../connections.php");
include("../checkSession.php");
$reqId = $_POST["reqId"];

mysqli_query($connections,"UPDATE tblrequest SET stfRequestFeedback = 'Rejected', dtmDateAccepted = NOW(),	stfUpdateStatus = 'Updated', intEmployeeId = '$varEmpId' WHERE intClientReqId = $reqId");

?>
