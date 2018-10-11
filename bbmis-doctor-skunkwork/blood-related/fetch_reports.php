<?php 
include("../connections.php");

/* REPORTS ARE SORTED PER BLOOD Type
*/
/* get storage lifespan
$wastage_typea = mysqli_query($connections, " SELECT COUNT(*) AS 'Wasted Blood Bags'
FROM tblbloodbag
WHERE stfIsBloodBagExpired = 'Yes'
AND TIMESTAMPDIFF(DAY, dtmDateStored, NOW()) > $bloodbaglifespan
AND stfTransfusionSuccess = 'No'
 ")


 ?>
