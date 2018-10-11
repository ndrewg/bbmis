<?php
include("../connections.php");
// class donorClass{
//   public $donorfirstname;
//   public $donormiddlename;
//   public $donorlastname;
// }
$viewclienttable = mysqli_query($connections, "SELECT intClientId, strClientFirstName, strClientMiddleName, strClientLastName, CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ',strClientLastName) AS clientname FROM tblclient WHERE boolIsAllowed = '1'");
$somevariable ='';
if(mysqli_num_rows($viewclienttable) > 0){
  $output = "";

  while ($row = mysqli_fetch_assoc($viewclienttable)){
    $clientid = $row["intClientId"];
    $clientfirstname = $row["strClientFirstName"];
    $clientmiddlename = $row["strClientMiddleName"];
    $clientlastname = $row["strClientLastName"];
    $objectofdonors = array('donorfirstname' => $clientfirstname, 'donormiddlename' => $clientmiddlename, 'donorlastname' => $clientlastname);

    $getlatestdonationIDquery = mysqli_query($connections,"SELECT intDonationId FROM tbldonation WHERE intClientId = '$clientid' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0");

    if(mysqli_num_rows($getlatestdonationIDquery) > 0){
      while ($row2 = mysqli_fetch_assoc($getlatestdonationIDquery)) {
        $latestdonationID = $row2["intDonationId"];
      }
      $check_ifhasrecordwithinninetydays = mysqli_query($connections,"SELECT c.intClientId
        FROM tblclient c
        JOIN tbldonation d ON c.intClientId = d.intClientId
        JOIN tblmedicalexam me ON d.intDonationId = me.intDonationId
        JOIN tblphysicalexam pe ON me.intDonationId = pe.intDonationId
        JOIN tblinitialscreening ins ON pe.intDonationId = ins.intDonationId
        JOIN tblserologicalscreening ss ON ins.intDonationId = ss.intDonationId
        WHERE c.intClientId = '$clientid'
        AND d.stfDonationRemarks = 'Complete'
        AND d.intDonationId = (SELECT intDonationId FROM tbldonation WHERE intClientId = '$clientid' ORDER BY intDonationId DESC LIMIT 1 OFFSET 0)
        AND d.intDonationId IN (SELECT me.intDonationId FROM tblmedicalexam me)
        AND d.intDonationId IN (SELECT pe.intDonationId FROM tblphysicalexam pe)
        AND d.intDonationId IN (SELECT ins.intDonationId FROM tblinitialscreening ins)
        AND d.intDonationId IN (SELECT ss.intDonationId FROM tblserologicalscreening ss)
        AND me.dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()
        AND pe.dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()
        AND ins.dtmDateScreened BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()
        AND ss.dtmDateScreened BETWEEN DATE_SUB(NOW(), INTERVAL 90 DAY) AND NOW()");

        $failed_survey = mysqli_query($connections,"SELECT *
          FROM `tblmedicalexam`
          WHERE intDonationId = '$latestdonationID'
          AND `stfClientMedicalExamStatus` = 'Wrong'
          AND `dtmExamTaken` BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()");

          $failed_WBC = mysqli_query($connections,"SELECT *
            FROM `tblinitialscreening`
            WHERE intDonationId = '$latestdonationID'
            AND intBloodComponentId = '2'
            AND `stfClientInitialScreeningStatus` = 'Failed'
            AND dtmDateScreened BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()");

            $failed_hemo = mysqli_query($connections,"SELECT *
              FROM `tblinitialscreening`
              WHERE intDonationId = '$latestdonationID'
              AND intBloodComponentId = '3'
              AND `stfClientInitialScreeningStatus` = 'Failed'
              AND dtmDateScreened BETWEEN DATE_SUB(NOW(), INTERVAL 3 DAY) AND NOW()");

              $check_ifseroremaining = mysqli_query($connections,"SELECT *
                FROM tbldonation
                WHERE stfDonationRemarks = 'Incomplete'
                AND intDonationId IN (SELECT intDonationId FROM tblphysicalexam WHERE intDonationId = '$latestdonationID')
                AND intDonationId IN (SELECT intDonationId FROM tblinitialscreening WHERE intDonationId = '$latestdonationID')
                AND intDonationId NOT IN (SELECT intDonationId FROM tblserologicalscreening WHERE intDonationId = '$latestdonationID')
                AND intClientId = '$clientid' ");

                $check_ifnoinit = mysqli_query($connections,"SELECT *
                  FROM tbldonation
                  WHERE stfDonationRemarks = 'Incomplete'
                  AND intDonationId IN (SELECT intDonationId FROM tblphysicalexam WHERE intDonationId = '$latestdonationID')
                  AND intDonationId NOT IN(SELECT intDonationId FROM tblinitialscreening WHERE intDonationId = '$latestdonationID')
                  AND intClientId = '$clientid'");

                  $check_ifnophys = mysqli_query($connections,"SELECT *
                    FROM tbldonation
                    WHERE stfDonationRemarks = 'Incomplete'
                    AND intDonationId NOT IN (SELECT intDonationId FROM tblphysicalexam WHERE intDonationId = '$latestdonationID')
                    AND intClientId = '$clientid'");

                    $checkifpwedenaulit = mysqli_query($connections,"SELECT *
                      FROM tbldonation
                      WHERE stfDonationRemarks = 'Complete'
                      AND intDonationId = '$latestdonationID'");

                      // print_r($objectofdonors);
                      // $output1 ="
                      // $objectofdonors->donorfirstname=$clientfirstname;
                      // $objectofdonors->donormiddlename=$clientmiddlename;
                      // $objectofdonors->donorlastname=$clientlastname;
                      // ";
                      if(mysqli_num_rows($check_ifhasrecordwithinninetydays) == 0){
                        if(mysqli_num_rows($failed_WBC) == 0 AND mysqli_num_rows($failed_survey) == 0){
                          if(mysqli_num_rows($failed_hemo) == 0){
                            //--------------------------------------------------------------------------------------------------------------------------------------------------------------

                            if(mysqli_num_rows($check_ifnophys) > 0){
                              $somevariable = "<button type='button' class='btn btn-success btn-sm btnaddphys' data-id='".$row["intClientId"]."' data-target='#divdonorrecord'>Add Physical Screening Record</button> <button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec' data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a>";
                              $objectofdonors = array('donorfirstname' => $clientfirstname, 'donormiddlename' => $clientmiddlename, 'donorlastname' => $clientlastname);
                              echo json_encode($objectofdonors);
                              // $output .="
                              // <td><button type='button' class='btn btn-success btn-sm btnaddphys' data-id='".$row["intClientId"]."' data-target='#divdonorrecord'>Add Physical Screening Record</button> <button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec' data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a></td>
                              // ";
                            }
                            else if(mysqli_num_rows($check_ifnoinit) > 0){
                              $somevariable .= "
                              <button type='button' class='btn btn-success btn-sm btnaddinit' data-id='".$row["intClientId"]."' data-target='#divdonorrecord'>Add Initial Screening Record</button> <button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec' data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a>
                              ";
                              $objectofdonors = array('donorfirstname' => $clientfirstname, 'donormiddlename' => $clientmiddlename, 'donorlastname' => $clientlastname);
                              echo json_encode($objectofdonors);
                              // $output .="
                              // <td><button type='button' class='btn btn-success btn-sm btnaddinit' data-id='".$row["intClientId"]."' data-target='#divdonorrecord'>Add Initial Screening Record</button> <button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec' data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a></td>
                              // ";
                            }
                            else if(mysqli_num_rows($check_ifseroremaining) > 0 ){
                              $somevariable .= "
                              <button type='button' class='btn btn-success btn-sm btnaddsero' data-id='".$row["intClientId"]."' data-target='#divdonorrecord'>Add Serological record</button> <button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec' data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a>
                              ";
                              $objectofdonors = array('donorfirstname' => $clientfirstname, 'donormiddlename' => $clientmiddlename, 'donorlastname' => $clientlastname);
                              echo json_encode($objectofdonors);
                              // $output .="
                              // <td><button type='button' class='btn btn-success btn-sm btnaddsero' data-id='".$row["intClientId"]."' data-target='#divdonorrecord'>Add Serological record</button> <button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec' data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a></td>
                              // ";

                            }
                            else if (mysqli_num_rows($checkifpwedenaulit) > 0){
                              $somevariable .= "
                              <a href = 'fetchIntSheetQuestions.php?client_id=$clientid'><button type='button' class='btn btn-success btn-sm btnaddrec' data-id='".$row["intClientId"]."' data-target='#divdonorrecord'>Add record</button></a> <button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec' data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a>
                              ";
                              $objectofdonors = array('donorfirstname' => $clientfirstname, 'donormiddlename' => $clientmiddlename, 'donorlastname' => $clientlastname);
                              echo json_encode($objectofdonors);
                              // $output .="
                              // <td><a href = 'fetchIntSheetQuestions.php?client_id=$clientid'><button type='button' class='btn btn-success btn-sm btnaddrec' data-id='".$row["intClientId"]."' data-target='#divdonorrecord'>Add record</button></a> <button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec' data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a></td>
                              // ";
                            }
                            //------------------------------------------------------------------------------------------------------------------------------------------------------------
                          }else {
                            $somevariable = "
                            <button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec'  data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a>
                            ";
                            $objectofdonors = array('donorfirstname' => $clientfirstname, 'donormiddlename' => $clientmiddlename, 'donorlastname' => $clientlastname);
                            echo json_encode($objectofdonors);
                            // $output .="
                            // <td><button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec'  data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a></td>
                            // ";
                          }
                        }else{
                          $somevariable ="
                          <button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec'  data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a>
                          ";
                          $objectofdonors = array('donorfirstname' => $clientfirstname, 'donormiddlename' => $clientmiddlename, 'donorlastname' => $clientlastname);
                          echo json_encode($objectofdonors);
                          // $output .="
                          // <td><button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec'  data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a></td>
                          // ";
                        }
                      }else {
                        $somevariable = "
                        <button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec'  data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a>
                        ";
                        $objectofdonors = array('donorfirstname' => $clientfirstname, 'donormiddlename' => $clientmiddlename, 'donorlastname' => $clientlastname);
                        echo json_encode($objectofdonors);
                        // $output .="
                        // <td><button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec'  data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a></td>
                        // ";
                      }
                      // $output .="
                      // </tr>
                      // </tbody>
                      // ";

                    }
                    else{
                      $somevariable ="
                      <a href = 'fetchIntSheetQuestions.php?client_id=$clientid'><button type='button' class='btn btn-success btn-sm btnaddrec' data-id='".$row["intClientId"]."' data-target='#divdonorrecord'>Add record</button></a> <button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec' data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a>
                      ";
                      $objectofdonors = array('donorfirstname' => $clientfirstname, 'donormiddlename' => $clientmiddlename, 'donorlastname' => $clientlastname);
                      echo json_encode($objectofdonors);
                      // $output .="
                      // <tbody>
                      // <tr>
                      // <td>$clientfirstname</td>
                      // <td>$clientmiddlename</td>
                      // <td>$clientlastname</td>
                      // ";
                      // $output .="
                      // <td><a href = 'fetchIntSheetQuestions.php?client_id=$clientid'><button type='button' class='btn btn-success btn-sm btnaddrec' data-id='".$row["intClientId"]."' data-target='#divdonorrecord'>Add record</button></a> <button type='button' class='btn ml-2 btn-sm' data-toggle='modal' data-target='#editdonorinfo' data-id='".$row['intClientId']."'>Edit</button> <a class='btn btn-default btn-sm ml-2 btn_viewrec' data-id='".$row['intClientId']."' href='donorrecords-tab-viewinfo.php?id=$clientid'>View</a></td>
                      // ";


                    }

                  }
                  // $output .="</table>";
                  // echo json_encode($objectofdonors);
                }





                ?>
