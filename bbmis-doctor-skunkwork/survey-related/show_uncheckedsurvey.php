<?php
include("../connections.php");

$unchecked_surveys = mysqli_query($connections,"SELECT DISTINCT(d.intDonationId), c.intClientId, CONCAT(strClientFirstName, ' ', strClientMiddleName, ' ', strClientLastName) AS Applicant_DonorName
                                                FROM tbldonation d JOIN tblclient c ON d.intClientId = c.intClientId JOIN tblmedicalexam m ON d.intDonationId = m.intDonationId
                                                WHERE stfAnswerRemarks = 'Unchecked'
                                                AND dtmExamTaken BETWEEN DATE_SUB(NOW(), INTERVAL 4 DAY) AND NOW()");

            if(mysqli_num_rows($unchecked_surveys) > 0){

                    $output = "
                             <table class='table table-bordered text-center' id='tbldonorsurvey'>
                             <thead>
                             <tr >
                             <th>Exam Code</th>
                             <th>Donor Code</th>
                             <th>Donor/Applicant Name</th>
                             <th>Action</th>
                             </tr>
                           </thead>";

          while ($row = mysqli_fetch_assoc($unchecked_surveys)) {
            $exam = $row["intDonationId"];
            $donor_id = $row["intClientId"];
            $donor_name = $row["Applicant_DonorName"];

              $output .= "
             <tbody>
             <tr>
             <td>$exam</td>
             <td>$donor_id</td>
             <td> $donor_name</td>
             <td><a href = 'fetch_donorsurveyanswers.php?rowid=$exam' ><button type='button' class='btn ml-2 btn-sm btnchecksurvey' data-id='$exam' name = 'check_survey'>Check</button></a></td>
             </tr>
           </tbody>";

  }

  $output .="
</table>";
echo $output;

}
?>
