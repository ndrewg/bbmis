<?php
include ("../connections.php");

if(isset($_POST["bloodtype"])){
$blood_type = $_POST["bloodtype"];
}else{
$blood_type = "1";
}

if(isset($_POST["storage"])){
$storage = $_POST["storage"];
}
else{
  $storage = "1";
}

if(isset($_POST["volume"])){
$volume = $_POST["volume"];
}
else{
  $volume = "1";
}

if(isset($_POST["preservative"])){
$preservative = $_POST["preservative"];
}
else{
  $preservative = "1";
}

$input = $blood_type.'-'.$storage.'-'.$volume.'-'.$preservative;
echo 'input: '.$input.'/';

$query = mysqli_query($connections,"SELECT bb.strBloodBagSerialNo, s.strStorageName, bt.stfBloodType, bt.stfBloodTypeRhesus, bv.intBloodVolume, p.txtPreservative,TIMESTAMPDIFF(day,dtmDateStored,NOW()) as days,CONCAT(bt.intBloodTypeId,'-',s.intStorageId,'-',bv.intBloodVolumeId,'-',p.intPreservativeId) as test
FROM tblbloodbag bb
JOIN tblbloodtype bt ON bb.intBloodTypeId = bt.intBloodTypeId
JOIN tblbloodvolume bv ON bb.intBloodVolumeId = bv.intBloodVolumeId
JOIN tblstorage s ON bb.intStorageId = s.intStorageId
JOIN tblpreservatives p ON bb.intPreservativeId = p.intPreservativeId
WHERE CONCAT(bt.intBloodTypeId,'-',s.intStorageId,'-',bv.intBloodVolumeId,'-',p.intPreservativeId) LIKE '%$input%'
");

            if(mysqli_num_rows($query) > 0){

                    $output = "
                    <table class='table table-striped table-bordered text-center' style='width:100%'' id = 'tblquery'>
                      <thead>
                        <tr>
                          <th>Blood bag Serial</th>
                          <th>Blood Type</th>
                          <th>Blood Volume</th>
                          <th>Blood Storage</th>
                          <th>Preservative</th>
                          <th>Days in Storage</th>
                        </tr>
                      </thead>";

          while ($row = mysqli_fetch_assoc($query)) {
            $serial = $row["strBloodBagSerialNo"];
            $btype = $row["stfBloodType"];
            $rhesus = $row["stfBloodTypeRhesus"];
            $volume = $row["intBloodVolume"];
            $storagename=$row["strStorageName"];
             $preservative=$row["txtPreservative"];
            $days =$row["days"];
            $test =$row["test"];

            echo $test.'/';
              $output .= "
             <tbody>
             <tr>
             <td>$serial</td>
             <td>$btype $rhesus</td>
             <td>$volume</td>
             <td>$storagename</td>
             <td>$preservative</td>
             <td>$days</td>


             </tr>
           </tbody>";

  }

  $output .="
</table>";
echo $output;

}else{

}


?>
