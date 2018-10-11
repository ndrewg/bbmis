<?php
include("../connections.php");

$viewdisease = mysqli_query($connections,"SELECT *
                                                  FROM tbldisease
                                                  WHERE stfDiseaseStatus = 'Able'");

      if(mysqli_num_rows($viewdisease) > 0){
        $output = "
        <table class='table table-bordered mt-5 text-center' >
        <thead>
        <tr style='background-color:#fa4251; color:#fff'>
        <th>ID</th>
        <th>Disease Name</th>
        <th>Action</th>
        </tr>
        </thead>
        ";
        while($row = mysqli_fetch_assoc($viewdisease)){
          $disease_id = $row["intDiseaseId"];
          $disease_name = $row["strDiseaseName"];

            $output .="
            <tbody>
            <tr>
            <td>$disease_id</td>
            <td>$disease_name</td>
            <td><button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#editDiseaseModal' data-id='".$disease_id."' id='btntbl'>Edit</button><button type='button' class='btn btn-default btn-sm ml-2' data-toggle='modal' data-target='#viewdonor' data-id='".$disease_id."'>Delete</button></td>
            </tr>
            </tbody>
            ";
        }
        $output .="</table>";
        echo $output;
      }
?>
