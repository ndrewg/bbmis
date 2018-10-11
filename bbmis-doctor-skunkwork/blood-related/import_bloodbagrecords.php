<?php
include("../connections.php");

if($_FILES["bloodbagcsv"]){
  $csvfile = $_FILES['bloodbagcsv'];
  $csvfilename = $_FILES['bloodbagcsv']['name'];
  $csvtmpfilename = $_FILES['bloodbagcsv']['tmp_name'];
  $csvfileExt = explode('.', $csvfilename);
  $csvfileActualExt = strtolower(end($csvfileExt));

  $allowed = array('csv');
  if (in_array($csvfileActualExt, $allowed)) {
    $handle = fopen($csvtmpfilename, 'r');
    while (($datafromcsv = fgetcsv($handle,1000,',')) !== FALSE){
      print_r($datafromcsv);
      $storage_name = $datafromcsv[0];
      $client_fname = $datafromcsv[1];
      $client_mname = $datafromcsv[2];
      $client_lname = $datafromcsv[3];
      $bloodtype = $datafromcsv[4];
      $bloodrhesus = $datafromcsv[5];
      $bloodvolume = $datafromcsv[6];
      $serialno = $datafromcsv[7];
      $isbloodbagexpired = $datafromcsv[8];
      $isbloodbagdiscarded = $datafromcsv[9];
      $dispatchment_status = $datafromcsv[10];
      $dispatchment_reason = $datafromcsv[11];
      $date = $datafromcsv[12];
      $client_name = $client_fname." ".$client_mname." ".$client_lname;
      $client_bloodtype = $bloodtype." ".$bloodrhesus;
      $date_stored = strtotime($date);
      $formatted_date = date('Y-m-d',$date_stored);
      settype($bloodvolume,"int");
      // get storage id
      $fetch_storageid = mysqli_query($connections, " SELECT intStorageId FROM tblstorage
        WHERE strStorageName = '$storage_name' ");
        $row_storageid = mysqli_fetch_assoc($fetch_storageid);
        $storage_id = $row_storageid["intStorageId"];
      // get client's id
      $fetch_clientid = mysqli_query($connections, " SELECT intClientId
        FROM tblclient
        WHERE strClientFirstName  LIKE '%$client_name%' OR strClientMiddleName LIKE '%$client_name%' OR strClientLastName LIKE '%$client_name%' OR CONCAT(strClientFirstName, ' ', strClientLastName) LIKE '%$client_name%' OR CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ', strClientLastName) LIKE '%$client_name%' ");
        $row_clientid = mysqli_fetch_assoc($fetch_clientid);
        $client_id = $row_clientid["intClientId"];
      // get blood type id
      $fetch_bloodtypeid = mysqli_query($connections, " SELECT intBloodTypeId FROM tblbloodtype
        WHERE stfBloodType = '$bloodtype' AND stfBloodTypeRhesus = '$bloodrhesus' ");
        $row_bloodtypeid = mysqli_fetch_assoc($fetch_bloodtypeid);
        $bloodtype_id = $row_bloodtypeid["intBloodTypeId"];
      // get blood volume id
      $fetch_bloodvolumeid = mysqli_query($connections, " SELECT intBloodVolumeId FROM tblbloodvolume
        WHERE intBloodVolume = $bloodvolume ");
        $row_bloodvolumeid = mysqli_fetch_assoc($fetch_bloodvolumeid);
        $blood_volumeid = $row_bloodvolumeid["intBloodVolumeId"];
      // get dispatchment id
      $fetch_dispatchmentid = mysqli_query($connections, " SELECT intBloodDispatchmentId FROM tblblooddispatchment
        WHERE strBloodDispatchment = '$dispatchment_status' ");
        $row_blooddispatchmentid = mysqli_fetch_assoc($fetch_dispatchmentid);
        $dispatchment_id = $row_blooddispatchmentid["intBloodDispatchmentId"];
      // convert fetched IDs to int
      settype($storage_id,"int");
      settype($client_id,"int");
      settype($bloodtype_id, "int");
      settype($blood_volumeid,"int");
      settype($dispatchment_id, "int");
      // check if the data is already present in the database
      $fetch_similar_data = mysqli_query($connections, " SELECT * FROM tblbloodbag
        WHERE intStorageId = $storage_id
        AND intClientId = $client_id
        AND intBloodTypeId = $bloodtype_id
        AND intBloodDispatchmentId = $dispatchment_id
        AND intBloodVolumeId = $blood_volumeid
        AND strBloodBagSerialNo = '$serialno'
        AND stfIsBloodBagExpired = '$isbloodbagexpired'
        AND stfIsBloodBagDiscarded = '$isbloodbagdiscarded'
        AND txtDispatchmentReason = '$dispatchment_reason'
        AND dtmDateStored = '$formatted_date' ");

        if (mysqli_num_rows($fetch_similar_data) > 0 ){
          echo "Data already exists"; // if data already exists
        }
        elseif (mysqli_num_rows($fetch_similar_data) == 0 ) {
          $insert_query = mysqli_query($connections, " INSERT INTO tblbloodbag(intClientId,intStorageId,intBloodTypeId,intBloodDispatchmentId,intBloodVolumeId,strBloodBagSerialNo,stfIsBloodBagExpired,stfIsBloodBagDiscarded,txtDispatchmentReason,dtmDateStored) VALUES ($client_id,$storage_id,$bloodtype_id,$dispatchment_id,$blood_volumeid,'$serialno','$isbloodbagexpired','$isbloodbagdiscarded','$dispatchment_reason','$formatted_date') ");
          echo "File Upload Success!"; // success import
        }
      }
    }
    else{
      echo "3"; //if somehow the file passed thru the validation in the client side, another validation in server side will block. echo 3 if it fails the validation in server side
    }
  }


  ?>
