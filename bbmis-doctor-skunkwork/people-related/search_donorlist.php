<?php
include("../connections.php");
/*parse_str($_POST["formdata"], $params);
$clientname = $params["searchclientname"];*/
// searchquery == WHERE strClientFirstName  LIKE '%$clientname%' OR strClientMiddleName LIKE '%$clientname%' OR strClientLastName LIKE '%$clientname%' OR CONCAT(strClientFirstName, ' ', strClientLastName) LIKE '%$clientname%' OR CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ', strClientLastName) LIKE '%$clientname%' "

//if($clientname){
  // echo $realtimedonor;
  $searchedclientname = mysqli_query($connections, "SELECT intClientId, strClientFirstName, strClientMiddleName, strClientLastName, CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ', strClientLastName) AS 'Client Full Name' FROM tblclient");

if(mysqli_num_rows($searchedclientname) > 0){
    $output ="
    <table class='table table-bordered text-center table-hover sortable' id='tbldonorrec'>
    <thead>
    <tr>
    <th>First Name</th>
    <th>Middle Name</th>
    <th>Last Name</th>
    <th>Action</th>
    </tr>
    </thead>

    ";
    while ($row = mysqli_fetch_assoc($searchedclientname)){
      $clientfirstname = $row["strClientFirstName"];
      $clientmiddlename = $row["strClientMiddleName"];
      $clientlastname = $row["strClientLastName"];

      $output .="
      <tbody>
      <tr>
      <td>$clientfirstname</td>
      <td>$clientmiddlename</td>
      <td>$clientlastname</td>
      <td><button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#editphysexam' data-id='".$row["intClientId"]."' id='btntbl'>Edit</button><button type='button' class='btn btn-default btn-sm ml-2' data-toggle='modal' data-target='#viewdonor' data-id='".$row['intClientId']."'>View</button></td>

      </tr>
      </tbody>
      ";

    }
    $output .="</table>";
    echo $output;
  }
  /*else {
    echo "record not found";
  }*/

  /*if (empty($clientname)){
    $viewclienttable = mysqli_query($connections, "SELECT intClientId, strClientFirstName, strClientMiddleName, strClientLastName, CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ',strClientLastName) AS clientname FROM tblclient");

    if(mysqli_num_rows($viewclienttable) > 0){
      $output = "
      <table class='table table-bordered mt-5 text-center' id='tbldonorrec'>
      <thead>
      <tr style='background-color:#fa4251; color:#fff'>
      <th>First Name</th>
      <th>Middle Name</th>
      <th>Last Name</th>
      <th>Action</th>
      </tr>
      </thead>
      ";

      while ($row = mysqli_fetch_assoc($viewclienttable)){
        $clientid = $row["intClientId"];
        $clientfirstname = $row["strClientFirstName"];
        $clientmiddlename = $row["strClientMiddleName"];
        $clientlastname = $row["strClientLastName"];

        $output .="
        <tbody>
        <tr>
        <td>$clientfirstname</td>
        <td>$clientmiddlename</td>
        <td>$clientlastname</td>
        <td><button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#editphysexam' data-id='".$row["intClientId"]."' id='btntbl'>Edit</button><button type='button' class='btn btn-default btn-sm ml-2' data-toggle='modal' data-target='#viewdonor' data-id='".$row['intclientId']."'>View</button></td>
        </tr>
        </tbody>
        ";
      }
      $output .="</table>";
      echo $output;
    }
  }

}*/
?>
