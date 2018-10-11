<?php
include("../connections.php");

//parse_str(mysqli_real_escape_string($connections,$_POST["formdata"]), $params);
$id = mysqli_real_escape_string($connections,$_POST['clientId']);
settype($id,'int');
$occupation = mysqli_real_escape_string($connections,$_POST['clientocc']);
$contact = mysqli_real_escape_string($connections,$_POST['clientcontact']);
$civilstat = mysqli_real_escape_string($connections,$_POST['clientcivstat']);
$blood_type = mysqli_real_escape_string($connections, $_POST['clientbloodtype']);

$file = $_FILES ['clientimage'];
$fileName = $_FILES['clientimage']['name'];/*kukunin yung file name*/
$fileTmpName = $_FILES['clientimage']['tmp_name'];/*kukunin yung temporary destination na pinupuntahan ng file bago i upload*/
$fileSize = $_FILES['clientimage']['size'];/*kukunin file size*/
$fileError = $_FILES['clientimage']['error'];/*integer to pag 0 ibig sabihin succesful parang ganun*/
$fileType = $_FILES['clientimage']['type'];/*kukunin file type*/

$fileExt = explode('.', $fileName);
$fileActualExt = strtolower(end($fileExt));

$allowed = array('jpg','jpeg','png');
if (in_array($fileActualExt, $allowed)) { /*ichicheck kung allowed ba yung file type */
  if($fileError === 0){
    if($fileSize < 1000000){
      $fileNameNew = uniqid('', true).".".$fileActualExt;/*gagawin niyang integer na unique*/

      $fileDestination = '../../img/'.$fileNameNew;
      move_uploaded_file($fileTmpName, $fileDestination);/*yung unang paramter kung saan galing which is yung temporary location, yung second parameter kung saan ililipat*/


    }
    else	{
      echo "<script type='text/javascript'>alert('Your file is too big!');</script>";
    }

  }
  else	{
    echo "<script type='text/javascript'>alert('there was an error uploading the file!');</script>";
  }
}
else	{
  echo "<script type='text/javascript'>alert('You cannot upload files of this type!');</script>";
}


if($occupation && $contact && $civilstat && $blood_type)
{
  mysqli_query($connections,"UPDATE tblclient
                            SET strClientContact = '$contact', strClientOccupation = '$occupation', stfClientCivilStatus = '$civilstat', intBloodTypeId = '$blood_type'
                            WHERE intClientId = $id");

  $useridqry = mysqli_query($connections,"SELECT * FROM tblclient c JOIN tbluser u ON c.intUserId = u.intUserId WHERE c.intClientId = '$id'");
  if(mysqli_num_rows($useridqry)>0){
    while ($row = mysqli_fetch_assoc($useridqry)) {
      // code...
      $userid = $row["intUserId"];
    }
  }

  mysqli_query($connections,"UPDATE tbluser SET strUserImageDir = '$fileNameNew' WHERE intUserId = '$userid'");
  echo  "<script type='text/javascript'>alert('Edit Succesful!');</script>";
  echo "<script type='text/javascript'>window.location.href = '../donor-tab.php'</script>";
  //echo $id.$occupation.$contact.$civilstat.$blood_type;
}
else{
  echo  "<script type='text/javascript'>alert('Edit Unsuccesful!');</script>";
  echo "<script type='text/javascript'>window.location.href = '../donor-tab.php'</script>";
}
?>
