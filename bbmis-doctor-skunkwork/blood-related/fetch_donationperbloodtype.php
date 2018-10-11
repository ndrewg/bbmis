<?php
include("../connections.php");

$fetch_donationperbloodtype = mysqli_query($connections, " SELECT * FROM tblbloodbag tbb JOIN tblbloodtype tbt ON tbb.intBloodTypeId = tbt.intBloodTypeId ORDER BY tbt.stfBloodType ");

$row = mysqli_fetch_assoc($fetch_donationperbloodtype);

echo json_encode($row);


 ?>
