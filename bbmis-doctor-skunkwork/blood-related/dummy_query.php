<?php
include("../connections.php");


if($_POST["formdata"]){
  $text = $_POST["dummytext"];

  $search_query = mysqli_query($connections, " SELECT * FROM tblclient WHERE strClientFirstName LIKE '%$text%' ");

  if(mysqli_num_rows($search_query) > 0){
    $output = "
    <table>
    <tr>
      <th>First Name</th>
      <th>Middle Name</th>
    </tr>
    ";
    while($row = mysqli_fetch_assoc($search_query)){

    }
  }
}


 ?>
